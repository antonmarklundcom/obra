#!/usr/bin/env node
// Empaqueta el sitio para subir a public_html/ de Hostinger (multiplataforma, Node >= 20, sin dependencias).
// Toma TODO archivo versionado en git (git ls-files) y aplica exclusiones; no hay lista blanca que quede vieja.
// Las entradas del zip usan siempre "/" como separador: con "\" Linux crea archivos llamados
// literalmente "includes\config.php" y el sitio devuelve 500.
// Uso: node tools/package.mjs [--out=<ruta.zip>]
import { execFileSync } from 'node:child_process';
import { deflateRawSync } from 'node:zlib';
import { existsSync, lstatSync, mkdirSync, readFileSync, rmSync, writeFileSync } from 'node:fs';
import { dirname, resolve, sep } from 'node:path';
import { fileURLToPath } from 'node:url';

const siteRoot = resolve(dirname(fileURLToPath(import.meta.url)), '..');
const workspaceRoot = dirname(siteRoot);

function fail(message) {
  console.error('ERROR: ' + message);
  process.exit(1);
}

// --- Argumentos ---
let outArg = null;
for (const arg of process.argv.slice(2)) {
  if (arg.startsWith('--out=')) outArg = arg.slice('--out='.length);
  else fail('Unknown argument: ' + arg + ' (usage: node tools/package.mjs [--out=<path>])');
}
if (outArg !== null && outArg === '') fail('--out needs a path.');
const stamp = new Date();
const pad = (n) => String(n).padStart(2, '0');
const today = stamp.getFullYear() + '-' + pad(stamp.getMonth() + 1) + '-' + pad(stamp.getDate());
const destination = outArg !== null
  ? resolve(process.cwd(), outArg)
  : resolve(workspaceRoot, 'obra-com-py-hostinger-ready-' + today + '.zip');
if (outArg === null) {
  const base = workspaceRoot.endsWith(sep) ? workspaceRoot : workspaceRoot + sep;
  if (!destination.startsWith(base)) fail('Destination must remain inside the workspace.');
}

// --- Guardas ---
if (existsSync(resolve(siteRoot, 'sitemap.xml'))) {
  fail('A static sitemap.xml exists in the site root. Delete it: Apache would serve it instead of the dynamic sitemap.php.');
}

// --- Archivos versionados + exclusiones ---
let tracked;
try {
  tracked = execFileSync('git', ['ls-files', '-z'], { cwd: siteRoot, maxBuffer: 256 * 1024 * 1024 })
    .toString('utf8').split('\0').filter(Boolean);
} catch (e) {
  fail('git ls-files failed: ' + e.message);
}

const EXCLUDED_ROOT_DIRS = ['docs/', 'tools/', 'audit-shots/', '.image-source/', '.github/', '.claude/'];
const EXCLUDED_ANY_SEGMENTS = new Set(['node_modules', '.git']);
const REPO_ONLY_FILES = new Set(['.gitignore', '.gitattributes', '.editorconfig', 'README.md', 'CLAUDE.md', 'CLAUDE-CHANGES.md']);
// tools/ esta bloqueado por .htaccess; este script es solo CLI (rechaza peticiones web) y el cron del servidor lo necesita.
const ALWAYS_INCLUDE = new Set(['tools/replay-leads.php']);

function isExcluded(p) {
  if (ALWAYS_INCLUDE.has(p)) return false;
  const segments = p.split('/');
  const name = segments[segments.length - 1];
  if (EXCLUDED_ROOT_DIRS.some((d) => p.startsWith(d))) return true;
  if (segments.slice(0, -1).some((s) => EXCLUDED_ANY_SEGMENTS.has(s))) return true;
  if (p.startsWith('storage/leads-pending/') || p.startsWith('storage/ratelimit/')) return true;
  if (p.startsWith('storage/') && /^storage\/[^/]*\.log$/.test(p)) return true;
  if (name.startsWith('.env')) return true;
  if (p === 'config/local.php' || p === 'router.php') return true;
  if (name.toLowerCase().endsWith('.zip')) return true;
  if (segments.length === 1 && REPO_ONLY_FILES.has(p)) return true;
  if (name.toLowerCase().endsWith('.md')) return true; // documentacion (raiz o app/content/README.md): nunca hace falta en el servidor
  return false;
}

const files = tracked.filter((p) => !isExcluded(p)).sort();

// Nunca empaquetar: sitemap.xml estatico (taparia a sitemap.php), config/local.php (datos reales), router.php (solo local), .env, private/.
for (const f of files) {
  if (['sitemap.xml', 'config/local.php', 'router.php', '.env'].includes(f) || f.startsWith('private/')) {
    fail('Refusing to package ' + f);
  }
}
if (files.length === 0) fail('No files to package.');
if (files.length > 65535) fail('Too many files for a plain zip.');

// --- Escritura del zip ---
const CRC_TABLE = (() => {
  const t = new Uint32Array(256);
  for (let n = 0; n < 256; n++) {
    let c = n;
    for (let k = 0; k < 8; k++) c = c & 1 ? 0xedb88320 ^ (c >>> 1) : c >>> 1;
    t[n] = c >>> 0;
  }
  return t;
})();
function crc32(buf) {
  let c = 0xffffffff;
  for (let i = 0; i < buf.length; i++) c = CRC_TABLE[(c ^ buf[i]) & 0xff] ^ (c >>> 8);
  return (c ^ 0xffffffff) >>> 0;
}
function dosDateTime(d) {
  const year = Math.min(Math.max(d.getFullYear(), 1980), 2107);
  const date = ((year - 1980) << 9) | ((d.getMonth() + 1) << 5) | d.getDate();
  const time = (d.getHours() << 11) | (d.getMinutes() << 5) | (d.getSeconds() >> 1);
  return { date, time };
}

const FLAG_UTF8 = 0x0800;
const localParts = [];
const centralParts = [];
const names = [];
let offset = 0;

for (const rel of files) {
  const source = resolve(siteRoot, rel);
  let st;
  try { st = lstatSync(source); } catch { fail('Missing package file: ' + rel); }
  if (!st.isFile()) fail('Missing package file: ' + rel + ' (not a regular file)');
  const data = readFileSync(source);
  if (data.length >= 0xffffffff || offset >= 0xffffffff) fail('File too large for a plain zip: ' + rel);
  const deflated = deflateRawSync(data, { level: 9 });
  const useDeflate = data.length > 0 && deflated.length < data.length;
  const body = useDeflate ? deflated : data;
  const method = useDeflate ? 8 : 0;
  const crc = crc32(data);
  const nameBuf = Buffer.from(rel, 'utf8');
  const { date, time } = dosDateTime(st.mtime);

  const local = Buffer.alloc(30);
  local.writeUInt32LE(0x04034b50, 0);
  local.writeUInt16LE(20, 4);
  local.writeUInt16LE(FLAG_UTF8, 6);
  local.writeUInt16LE(method, 8);
  local.writeUInt16LE(time, 10);
  local.writeUInt16LE(date, 12);
  local.writeUInt32LE(crc, 14);
  local.writeUInt32LE(body.length, 18);
  local.writeUInt32LE(data.length, 22);
  local.writeUInt16LE(nameBuf.length, 26);
  local.writeUInt16LE(0, 28);

  const central = Buffer.alloc(46);
  central.writeUInt32LE(0x02014b50, 0);
  central.writeUInt16LE((3 << 8) | 20, 4); // creado en Unix, version 2.0
  central.writeUInt16LE(20, 6);
  central.writeUInt16LE(FLAG_UTF8, 8);
  central.writeUInt16LE(method, 10);
  central.writeUInt16LE(time, 12);
  central.writeUInt16LE(date, 14);
  central.writeUInt32LE(crc, 16);
  central.writeUInt32LE(body.length, 20);
  central.writeUInt32LE(data.length, 24);
  central.writeUInt16LE(nameBuf.length, 28);
  central.writeUInt16LE(0, 30);
  central.writeUInt16LE(0, 32);
  central.writeUInt16LE(0, 34);
  central.writeUInt16LE(0, 36);
  central.writeUInt32LE(((0o100644) << 16) >>> 0, 38); // permisos 0644 de archivo regular
  central.writeUInt32LE(offset, 42);

  localParts.push(local, nameBuf, body);
  centralParts.push(central, nameBuf);
  names.push(rel);
  offset += local.length + nameBuf.length + body.length;
}

const centralSize = centralParts.reduce((n, b) => n + b.length, 0);
const end = Buffer.alloc(22);
end.writeUInt32LE(0x06054b50, 0);
end.writeUInt16LE(0, 4);
end.writeUInt16LE(0, 6);
end.writeUInt16LE(names.length, 8);
end.writeUInt16LE(names.length, 10);
end.writeUInt32LE(centralSize, 12);
end.writeUInt32LE(offset, 16);
end.writeUInt16LE(0, 20);

mkdirSync(dirname(destination), { recursive: true });
if (existsSync(destination)) rmSync(destination, { force: true });
writeFileSync(destination, Buffer.concat([...localParts, ...centralParts, end]));

// --- Verificacion: releer el central directory; ninguna entrada con backslash ---
const written = readFileSync(destination);
const eocd = written.length - 22;
if (written.readUInt32LE(eocd) !== 0x06054b50) fail('Written zip has no end record.');
const count = written.readUInt16LE(eocd + 10);
let p = written.readUInt32LE(eocd + 16);
const bad = [];
for (let i = 0; i < count; i++) {
  if (written.readUInt32LE(p) !== 0x02014b50) fail('Corrupt central directory in written zip.');
  const nLen = written.readUInt16LE(p + 28);
  const xLen = written.readUInt16LE(p + 30);
  const cLen = written.readUInt16LE(p + 32);
  const name = written.toString('utf8', p + 46, p + 46 + nLen);
  if (name.includes('\\')) bad.push(name);
  p += 46 + nLen + xLen + cLen;
}
if (count !== names.length) fail('Entry count mismatch in written zip.');
if (bad.length > 0) fail('Zip contains backslash entries: ' + bad.join(', '));

console.log('Entries: ' + count);
console.log(destination);
