#!/usr/bin/env node
// QA de WhatsApp (docs/IMPROVE-PLAN.md §5.1). Falla (exit 1) ante otro numero, textos vacios/cortos,
// precios, tuteo o textos repetidos entre paginas.
// Uso:
//   node tools/check-wa.mjs http://localhost:8081        paginas renderizadas + escaneo del repo
//   node tools/check-wa.mjs https://obra.com.py --no-repo solo el HTML en vivo
//   node tools/check-wa.mjs --repo-only                    solo el escaneo del repo
import { readFileSync, existsSync } from 'node:fs';
import { execFileSync } from 'node:child_process';
import { fileURLToPath } from 'node:url';
import { dirname, join, extname } from 'node:path';

const OK_NUMBER = '595992279599';
const OK_TEL = '+' + OK_NUMBER;
const root = join(dirname(fileURLToPath(import.meta.url)), '..');
const args = process.argv.slice(2);
const base = (args.find(a => !a.startsWith('--')) || '').replace(/\/$/, '');
const fail = [];

// Numero de ejemplo en placeholders ("0981 123 456"): el abonado 123456 no es un numero real.
const PLACEHOLDER_SUBSCRIBER = /^9\d{2}123456$/;
// Movil paraguayo en cualquier formato: +595 9xx xxx xxx, 5959xxxxxxxx, 09xx xxx xxx, wa.me/..., tel:...
const PY_MOBILE = /(?<![\d])(?:\+?\s?595|0)[\s.\-()]*9\d{2}[\s.\-]*\d{3}[\s.\-]*\d{3}(?![\d])/g;
const normalize = raw => { const d = raw.replace(/\D/g, ''); return d.startsWith('0') ? '595' + d.slice(1) : d; };

function scanRepo() {
  let files;
  try { files = execFileSync('git', ['ls-files', '--cached', '--others', '--exclude-standard'], { cwd: root, encoding: 'utf8' }).split('\n').filter(Boolean); }
  catch { console.error('check-wa: git not available for the repo scan'); process.exit(2); }
  const binary = new Set(['.webp', '.jpg', '.jpeg', '.png', '.gif', '.ico', '.zip', '.pdf', '.woff', '.woff2']);
  let scanned = 0;
  for (const f of files) {
    if (binary.has(extname(f).toLowerCase()) || f.startsWith('node_modules/') || f.includes('/node_modules/')) continue;
    const p = join(root, f);
    if (!existsSync(p)) continue;
    const body = readFileSync(p, 'utf8');
    scanned++;
    for (const m of body.matchAll(PY_MOBILE)) {
      const n = normalize(m[0]);
      if (n === OK_NUMBER) continue;
      if (PLACEHOLDER_SUBSCRIBER.test(n.slice(3))) continue;
      const line = body.slice(0, m.index).split('\n').length;
      fail.push(`repo ${f}:${line}: Paraguayan mobile number that is not the official one`);
    }
    for (const m of body.matchAll(/wa\.me\/(\d+)/g)) if (m[1] !== OK_NUMBER) fail.push(`repo ${f}: wa.me link to another number`);
  }
  console.log(`check-wa repo: ${scanned} files scanned`);
}

function fallbackTexts() {
  const map = join(root, 'app/wa-messages.php');
  if (!existsSync(map)) return new Set();
  try {
    const json = execFileSync('php', ['-r', `$m = require '${map.replace(/'/g, "\\'")}'; echo json_encode(array_values($m['fallbacks'] ?? []), JSON_UNESCAPED_UNICODE);`], { encoding: 'utf8' });
    return new Set(JSON.parse(json));
  } catch { return new Set(); }
}

const decode = s => s.replace(/&amp;/g, '&').replace(/&quot;/g, '"').replace(/&#0?39;/g, "'");
function lintText(text, where) {
  if (!text || text.trim().length < 25) fail.push(`${where}: text empty or shorter than 25 chars: "${text}"`);
  if (/(?:\bGs\.?(?=\s|$|\d)|₲|\bUSD\b|\$|\bgratis\b|\bguaran[ií]es\b)/i.test(text)) fail.push(`${where}: money/free wording: "${text}"`);
  if (/\d[\d.,]{3,}/.test(text)) fail.push(`${where}: number that looks like a price: "${text}"`);
  if (/\b\d+\s*(d[ií]as|semanas|meses)\b/i.test(text)) fail.push(`${where}: fixed plazo: "${text}"`);
  if (/\b(usted|tienes|quieres|puedes|necesitas|sabes|cuéntanos|cuentanos|escríbenos|escribenos|tú|contigo)\b/i.test(text)) fail.push(`${where}: not voseo: "${text}"`);
}

async function scanSite() {
  const fallbacks = fallbackTexts();
  const sm = await (await fetch(base + '/sitemap.xml')).text();
  const paths = [...sm.matchAll(/<loc>([^<]+)<\/loc>/g)].map(m => new URL(m[1]).pathname);
  const extra = ['/gracias/', '/gracias/?estado=enviado', '/gracias/?estado=sin-canales', '/pagina-que-no-existe/'];
  const seen = new Map(); // text -> Set(page)
  let links = 0; let tels = 0;
  for (const path of [...paths, ...extra]) {
    const res = await fetch(base + path, { redirect: 'manual' });
    const html = await res.text();
    const anchors = [...html.matchAll(/<a\b[^>]*href="([^"]+)"[^>]*>/gi)];
    let pageWa = 0;
    for (const [tag, rawHref] of anchors) {
      const href = decode(rawHref);
      const placement = (tag.match(/data-wa="([^"]*)"/) || [, '?'])[1];
      if (/^tel:/i.test(href)) { tels++; if (href.replace(/[\s-]/g, '') !== 'tel:' + OK_TEL) fail.push(`${path}: tel link ${href}`); continue; }
      if (!/wa\.me|whatsapp\.com/i.test(href)) continue;
      links++; pageWa++;
      let u; try { u = new URL(href); } catch { fail.push(`${path}: bad WhatsApp URL`); continue; }
      const number = u.pathname.replace(/\D/g, '') || (u.searchParams.get('phone') || '');
      if (number !== OK_NUMBER) fail.push(`${path} [${placement}]: WhatsApp link to another number`);
      const text = u.searchParams.get('text') || '';
      lintText(text, `${path} [${placement}]`);
      if (!seen.has(text)) seen.set(text, new Set());
      seen.get(text).add(path.replace(/\?.*$/, ''));
    }
    if (pageWa === 0 && !path.startsWith('/gracias/?estado=sin')) fail.push(`${path}: no WhatsApp link`);
    for (const m of html.matchAll(PY_MOBILE)) {
      const n = normalize(m[0]);
      if (n !== OK_NUMBER && !PLACEHOLDER_SUBSCRIBER.test(n.slice(3))) fail.push(`${path}: another Paraguayan mobile number in the HTML`);
    }
  }
  for (const [text, pages] of seen) if (pages.size > 1 && !fallbacks.has(text)) fail.push(`text repeated on ${pages.size} pages (${[...pages].slice(0, 4).join(' ')}): "${text}"`);
  console.log(`check-wa site: ${paths.length + extra.length} pages, ${links} WhatsApp links, ${seen.size} distinct texts, ${tels} tel links`);
}

if (!args.includes('--no-repo')) scanRepo();
if (!args.includes('--repo-only')) {
  if (!base) { console.error('uso: node tools/check-wa.mjs <base-url> [--no-repo] | --repo-only'); process.exit(2); }
  await scanSite();
}
if (fail.length) { console.error(`check-wa FAILED (${fail.length}):\n  ` + [...new Set(fail)].slice(0, 80).join('\n  ')); process.exit(1); }
console.log('check-wa OK');
