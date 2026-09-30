#!/usr/bin/env node
// Crawl every sitemap URL and write an audit JSON with the same schema as docs/audit/audit-before.json.
// Uso: node tools/audit.mjs <base-url> <canonical-origin> <out-file>
//   node tools/audit.mjs http://localhost:8081 https://obra.com.py audit-after.json
//   node tools/audit.mjs https://obra.com.py https://obra.com.py docs/audit/audit-live-after.json
import { writeFileSync } from 'node:fs';

const [base = 'http://localhost:8081', origin = 'https://obra.com.py', out = 'audit-after.json'] = process.argv.slice(2);
const BASE = base.replace(/\/$/, '');
const ORIGIN = origin.replace(/\/$/, '');

export const ROUTE_CHECKS = ['/contacto/', '/cocinas-banos/', '/servicios/piscinas/', '/servicios/casas-llave-en-mano/', '/servicios/quinchos/', '/servicios/quintas/', '/servicios/remodelaciones/', '/servicios/decks-y-pergolas/', '/servicios/cocinas-y-banos/', '/servicios/techos-cocheras-y-tinglados/', '/servicios/murallas-y-cerramientos/', '/servicios/obras-comerciales/', '/piscinas', '/sitemap.php', '/app/', '/config/site.php', '/docs/', '/obras/', '/credito', '/gracias/', '/no-existe/', '/robots.txt', '/form.php'];

const decode = s => s
  .replace(/&#(\d+);/g, (_, n) => String.fromCodePoint(+n))
  .replace(/&#x([0-9a-f]+);/gi, (_, n) => String.fromCodePoint(parseInt(n, 16)))
  .replace(/&quot;/g, '"').replace(/&#039;|&apos;/g, "'").replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&nbsp;/g, ' ').replace(/&amp;/g, '&');
const text = html => decode(html.replace(/<script[\s\S]*?<\/script>/gi, ' ').replace(/<style[\s\S]*?<\/style>/gi, ' ').replace(/<[^>]+>/g, ' ')).replace(/\s+/g, ' ').trim();
const attr = (tag, name) => { const m = tag.match(new RegExp(`\\s${name}\\s*=\\s*("([^"]*)"|'([^']*)')`, 'i')); return m ? decode(m[2] ?? m[3] ?? '') : null; };
const meta = (html, name) => { for (const t of html.match(/<meta\b[^>]*>/gi) || []) { if ((attr(t, 'name') || '').toLowerCase() === name) return attr(t, 'content'); } return null; };

async function get(path, opts = {}) {
  const res = await fetch(BASE + path, { redirect: 'manual', headers: { 'User-Agent': 'obra-audit/1.0' }, ...opts });
  const body = opts.method === 'HEAD' ? '' : await res.text();
  return { status: res.status, location: res.headers.get('location'), body };
}

function toInternal(href) {
  if (!href || href.startsWith('#') || /^(mailto|tel|javascript):/i.test(href)) return null;
  let u;
  try { u = new URL(href, ORIGIN + '/'); } catch { return null; }
  if (u.origin !== ORIGIN && u.origin !== BASE) return null;
  return u.pathname;
}

function parsePage(path, html) {
  const title = text((html.match(/<title>([\s\S]*?)<\/title>/i) || [, ''])[1]);
  const description = meta(html, 'description') ?? '';
  const robots = meta(html, 'robots') ?? '';
  const canonicalTag = (html.match(/<link\b[^>]*rel=["']canonical["'][^>]*>/i) || [''])[0];
  const canonical = canonicalTag ? attr(canonicalTag, 'href') : null;
  const h1 = [...html.matchAll(/<h1\b[^>]*>([\s\S]*?)<\/h1>/gi)].map(m => text(m[1]));
  const h2 = (html.match(/<h2\b/gi) || []).length;
  const main = (html.match(/<main\b[^>]*>([\s\S]*?)<\/main>/i) || [, ''])[1];
  const words = (text(main).match(/[\p{L}\p{N}\p{M}_]+/gu) || []).length;
  const internal = new Set(); const external = new Set(); const wa = [];
  for (const m of html.matchAll(/<a\b[^>]*>/gi)) {
    const href = attr(m[0], 'href');
    if (!href) continue;
    const p = toInternal(href);
    if (p !== null) { internal.add(p); continue; }
    if (/^https?:/i.test(href)) {
      const u = new URL(href);
      external.add(u.origin + u.pathname);
      if (u.hostname === 'wa.me') wa.push({ number: u.pathname.replace(/\D/g, ''), text: u.searchParams.get('text') || '', placement: attr(m[0], 'data-wa') || '' });
    }
  }
  const imgs = html.match(/<img\b[^>]*>/gi) || [];
  const schemaTypes = [];
  for (const m of html.matchAll(/<script type="application\/ld\+json">([\s\S]*?)<\/script>/gi)) {
    try { const j = JSON.parse(m[1]); for (const t of [].concat(j['@type'] || [])) schemaTypes.push(t); } catch { schemaTypes.push('INVALID_JSON'); }
  }
  return {
    url: ORIGIN + path, title, title_len: [...title].length, meta_description: description, meta_description_len: [...description].length,
    h1, h2_count: h2, canonical, canonical_ok: canonical === ORIGIN + path, robots, word_count_main: words,
    internal_links_out: [...internal].sort(), internal_links_out_count: internal.size, external_links: [...external].sort(),
    images: imgs.length, images_without_alt: imgs.filter(t => attr(t, 'alt') === null).map(t => attr(t, 'src')),
    images_empty_alt: imgs.filter(t => attr(t, 'alt') === '').map(t => attr(t, 'src')), schema_types: schemaTypes, wa,
  };
}

async function main() {
  const sm = await get('/sitemap.xml');
  if (sm.status !== 200) throw new Error(`sitemap.xml returned ${sm.status}`);
  const paths = [...sm.body.matchAll(/<loc>([^<]+)<\/loc>/g)].map(m => new URL(decode(m[1])).pathname);
  const lastmod = Object.fromEntries([...sm.body.matchAll(/<loc>([^<]+)<\/loc><lastmod>([^<]+)<\/lastmod>/g)].map(m => [new URL(decode(m[1])).pathname, m[2]]));
  const pages = {};
  for (const path of paths) {
    const r = await get(path);
    pages[path] = { status: r.status, ...(r.status === 200 ? parsePage(path, r.body) : { url: ORIGIN + path }) };
  }
  const set = new Set(paths);
  for (const [p, d] of Object.entries(pages)) {
    d.internal_links_in = paths.filter(q => (pages[q].internal_links_out || []).includes(p));
    d.internal_links_in_count = d.internal_links_in.length;
  }
  const route_checks = {};
  for (const p of ROUTE_CHECKS) { const r = await get(p); route_checks[p] = { status: r.status, location: r.location }; }
  const robotsTxt = await get('/robots.txt');

  const vals = Object.values(pages);
  const dup = key => { const m = {}; for (const [p, d] of Object.entries(pages)) { if (d[key]) (m[d[key]] ||= []).push(p); } return Object.fromEntries(Object.entries(m).filter(([, v]) => v.length > 1)); };
  const nonSitemap = {};
  for (const [p, d] of Object.entries(pages)) for (const t of d.internal_links_out || []) if (!set.has(t)) (nonSitemap[t] ||= []).push(p);
  const waNumbers = {}; const waTexts = {};
  for (const [p, d] of Object.entries(pages)) for (const w of d.wa || []) { waNumbers[w.number] = (waNumbers[w.number] || 0) + 1; (waTexts[w.text] ||= []); if (!waTexts[w.text].includes(p)) waTexts[w.text].push(p); }
  const words = vals.map(d => d.word_count_main || 0).sort((a, b) => a - b);
  const summary = {
    sitemap_url_count: paths.length,
    non_200: Object.entries(pages).filter(([, d]) => d.status !== 200).map(([p]) => p),
    multi_or_missing_h1: Object.entries(pages).filter(([, d]) => (d.h1 || []).length !== 1).map(([p]) => p),
    canonical_mismatch: Object.entries(pages).filter(([, d]) => !d.canonical_ok).map(([p]) => p),
    duplicate_titles: dup('title'), duplicate_descriptions: dup('meta_description'),
    title_over_60: Object.entries(pages).filter(([, d]) => d.title_len > 60).map(([p]) => p),
    description_over_160: Object.entries(pages).filter(([, d]) => d.meta_description_len > 160).map(([p]) => p),
    description_under_110: Object.entries(pages).filter(([, d]) => d.meta_description_len < 110).map(([p]) => p),
    thin_under_300_words: Object.entries(pages).filter(([, d]) => d.word_count_main < 300).map(([p, d]) => [d.word_count_main, p]).sort((a, b) => a[0] - b[0]),
    orphans_or_1_inlink: Object.entries(pages).filter(([p, d]) => d.internal_links_in.filter(q => q !== p).length <= 1).map(([p]) => p),
    images_without_alt_total: vals.reduce((n, d) => n + (d.images_without_alt || []).length, 0),
    linked_non_sitemap_targets: nonSitemap,
    whatsapp_numbers_found: waNumbers, whatsapp_distinct_texts: Object.keys(waTexts).length, whatsapp_texts: waTexts,
    word_count_min_median_max: [words[0], words[Math.floor(words.length / 2)], words[words.length - 1]],
  };
  for (const d of vals) delete d.wa;
  const report = { generated_at: new Date().toISOString(), fetched_from: BASE, canonical_origin: ORIGIN, summary, route_checks, robots_txt: robotsTxt.body, sitemap_lastmod: lastmod, pages };
  writeFileSync(out, JSON.stringify(report, null, 1) + '\n');
  console.log(`audit: ${paths.length} URLs, non-200 ${summary.non_200.length}, WA links ${Object.values(waNumbers).reduce((a, b) => a + b, 0)} (${summary.whatsapp_distinct_texts} texts), words median ${summary.word_count_min_median_max[1]} -> ${out}`);
}

main().catch(e => { console.error('audit failed:', e.message); process.exit(2); });
