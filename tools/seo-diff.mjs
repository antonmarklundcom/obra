#!/usr/bin/env node
// Compara dos auditorias (tools/audit.mjs) y falla (exit 1) ante cualquier regresion SEO (docs/IMPROVE-PLAN.md §4.4).
// Uso: node tools/seo-diff.mjs docs/audit/audit-before.json audit-after.json [docs/audit/approved-changes.json]
import { readFileSync, existsSync } from 'node:fs';
import { fileURLToPath } from 'node:url';
import { dirname, join } from 'node:path';

const root = join(dirname(fileURLToPath(import.meta.url)), '..');
const [beforeFile, afterFile, approvedFile = join(root, 'docs/audit/approved-changes.json')] = process.argv.slice(2);
if (!beforeFile || !afterFile) { console.error('uso: node tools/seo-diff.mjs <before.json> <after.json> [approved-changes.json]'); process.exit(2); }
const before = JSON.parse(readFileSync(beforeFile, 'utf8'));
const after = JSON.parse(readFileSync(afterFile, 'utf8'));
const approved = existsSync(approvedFile) ? JSON.parse(readFileSync(approvedFile, 'utf8')) : { changes: [] };
const allowed = (path, field) => (approved.changes || []).some(c => c.path === path && (c.fields || []).includes(field));

// 301 congelados (§4.1). Se comprueban en after.route_checks si la auditoria los incluye.
const LEGACY = { '/contacto/': '/cotizar/', '/cocinas-banos/': '/reformas/cocinas/', '/servicios/piscinas/': '/piscinas/', '/servicios/casas-llave-en-mano/': '/casas/', '/servicios/quinchos/': '/quinchos/', '/servicios/quintas/': '/quintas/', '/servicios/remodelaciones/': '/reformas/', '/servicios/decks-y-pergolas/': '/patios/', '/servicios/cocinas-y-banos/': '/reformas/cocinas/', '/servicios/techos-cocheras-y-tinglados/': '/tinglados/', '/servicios/murallas-y-cerramientos/': '/muros/', '/servicios/obras-comerciales/': '/comerciales/', '/piscinas': '/piscinas/', '/credito': '/credito/', '/sitemap.php': '/sitemap.xml' };
const BLOCKED = ['/app/', '/config/site.php', '/docs/'];

const fail = []; const info = { new_urls: [], changed_descriptions: [], word_delta: {}, links_in_delta: {} };
const same = (a, b) => JSON.stringify(a) === JSON.stringify(b);
const origin = after.canonical_origin;

for (const [path, b] of Object.entries(before.pages)) {
  const a = after.pages[path];
  if (!a) { fail.push(`${path}: missing from the sitemap`); continue; }
  if (a.status !== 200) { fail.push(`${path}: status ${a.status}`); continue; }
  if (a.canonical !== origin + path) fail.push(`${path}: canonical ${a.canonical}`);
  if (/noindex/i.test(a.robots || '')) fail.push(`${path}: noindex`);
  if (a.robots !== b.robots && !allowed(path, 'robots')) fail.push(`${path}: robots "${b.robots}" -> "${a.robots}"`);
  if (a.title !== b.title && !allowed(path, 'title')) fail.push(`${path}: title changed "${b.title}" -> "${a.title}"`);
  if (!same(a.h1, b.h1) && !allowed(path, 'h1')) fail.push(`${path}: H1 changed ${JSON.stringify(b.h1)} -> ${JSON.stringify(a.h1)}`);
  if (a.meta_description !== b.meta_description) {
    if (!allowed(path, 'description')) fail.push(`${path}: description changed without approval`);
    else if (a.meta_description_len > 160 || a.meta_description_len < 70) fail.push(`${path}: new description length ${a.meta_description_len}`);
    info.changed_descriptions.push({ path, before_len: b.meta_description_len, after_len: a.meta_description_len, after: a.meta_description });
  }
  if (a.word_count_main < b.word_count_main) fail.push(`${path}: words ${b.word_count_main} -> ${a.word_count_main}`);
  if (a.word_count_main !== b.word_count_main) info.word_delta[path] = a.word_count_main - b.word_count_main;
  if (a.internal_links_in_count < b.internal_links_in_count) fail.push(`${path}: internal links in ${b.internal_links_in_count} -> ${a.internal_links_in_count}`);
  if (a.internal_links_in_count !== b.internal_links_in_count) info.links_in_delta[path] = a.internal_links_in_count - b.internal_links_in_count;
  const missing = (b.schema_types || []).filter(t => !(a.schema_types || []).includes(t));
  if (missing.length && !allowed(path, 'schema')) fail.push(`${path}: schema types lost ${missing.join(',')}`);
  if ((a.schema_types || []).includes('INVALID_JSON')) fail.push(`${path}: invalid JSON-LD`);
}

const titles = {}; const descs = {};
for (const [path, a] of Object.entries(after.pages)) {
  if (a.title) (titles[a.title] ||= []).push(path);
  if (a.meta_description) (descs[a.meta_description] ||= []).push(path);
  if (before.pages[path]) continue;
  info.new_urls.push(path);
  if (a.status !== 200) fail.push(`NEW ${path}: status ${a.status}`);
  if ((a.h1 || []).length !== 1) fail.push(`NEW ${path}: ${(a.h1 || []).length} H1`);
  if (a.canonical !== origin + path) fail.push(`NEW ${path}: canonical ${a.canonical}`);
  if (/noindex/i.test(a.robots || '')) fail.push(`NEW ${path}: noindex`);
}
for (const [t, ps] of Object.entries(titles)) if (ps.length > 1) fail.push(`duplicate title "${t}": ${ps.join(' ')}`);
for (const [t, ps] of Object.entries(descs)) if (ps.length > 1) fail.push(`duplicate description: ${ps.join(' ')}`);

const rc = after.route_checks || {};
for (const [from, to] of Object.entries(LEGACY)) {
  const r = rc[from];
  if (!r) fail.push(`route ${from}: not checked`);
  else if (r.status !== 301 || !(r.location || '').replace(/^https?:\/\/[^/]+/, '').startsWith(to)) fail.push(`route ${from}: ${r.status} -> ${r.location} (want 301 ${to})`);
}
for (const p of BLOCKED) if (rc[p] && rc[p].status !== 404) fail.push(`route ${p}: ${rc[p].status} (want 404)`);
for (const [p, b] of Object.entries(before.route_checks || {})) {
  if (rc[p] && (rc[p].status !== b.status) && !allowed(p, 'route')) fail.push(`route ${p}: status ${b.status} -> ${rc[p].status}`);
}

const robotsRef = before.robots_txt ?? (existsSync(join(root, 'robots.txt')) ? readFileSync(join(root, 'robots.txt'), 'utf8') : null);
if (after.robots_txt !== undefined && robotsRef !== null && after.robots_txt.trim() !== robotsRef.trim() && !allowed('/robots.txt', 'robots')) fail.push('robots.txt changed');

console.log(`seo-diff: ${Object.keys(before.pages).length} before URLs, ${Object.keys(after.pages).length} after URLs, ${info.new_urls.length} new, ${info.changed_descriptions.length} changed descriptions, ${Object.keys(info.word_delta).length} pages with word delta`);
if (info.new_urls.length) console.log('  new URLs: ' + info.new_urls.join(' '));
for (const d of info.changed_descriptions) console.log(`  description ${d.path}: ${d.before_len} -> ${d.after_len}`);
if (process.env.SEO_DIFF_VERBOSE) console.log(JSON.stringify(info, null, 1));
if (fail.length) { console.error(`seo-diff FAILED (${fail.length}):\n  ` + fail.join('\n  ')); process.exit(1); }
console.log('seo-diff OK');
