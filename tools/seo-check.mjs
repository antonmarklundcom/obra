#!/usr/bin/env node
// Checks de SEO tecnico sobre un audit JSON (salida de tools/audit.mjs). Sale con 1 si algo falla.
// Uso: node tools/seo-check.mjs <audit.json>
import { readFileSync } from 'node:fs';

const file = process.argv[2];
if (!file) { console.error('uso: node tools/seo-check.mjs <audit.json>'); process.exit(2); }
const pages = JSON.parse(readFileSync(file, 'utf8')).pages;
const fails = [];
const seen = { title: new Map(), desc: new Map(), h1: new Map() };
const dup = (kind, key, path) => { if (!key) return; const prev = seen[kind].get(key); if (prev) fails.push(`${kind} duplicado: ${path} = ${prev}`); else seen[kind].set(key, path); };

for (const [path, p] of Object.entries(pages)) {
  const indexable = /^index/i.test(p.robots || '');
  if (p.status !== 200) { fails.push(`${path}: status ${p.status}`); continue; }
  if (p.canonical_ok === false) fails.push(`${path}: canonical incorrecto (${p.canonical})`);
  if (!indexable) continue;
  if (p.title_len < 20 || p.title_len > 65) fails.push(`${path}: title ${p.title_len} caracteres (20-65)`);
  if (p.meta_description_len < 70 || p.meta_description_len > 160) fails.push(`${path}: description ${p.meta_description_len} caracteres (70-160)`);
  if ((p.h1 || []).length !== 1) fails.push(`${path}: ${(p.h1 || []).length} H1 (debe haber 1)`);
  if ((p.images_without_alt || []).length) fails.push(`${path}: imagenes sin alt ${p.images_without_alt.join(', ')}`);
  if (p.path !== '/' && (p.internal_links_in_count ?? 99) < 3) fails.push(`${path}: solo ${p.internal_links_in_count} enlaces internos entrantes (minimo 3)`);
  dup('title', p.title, path); dup('desc', p.meta_description, path); dup('h1', (p.h1 || [])[0], path);
}
console.log(fails.length ? `seo-check FAIL (${fails.length})\n  ` + fails.join('\n  ') : `seo-check OK (${Object.keys(pages).length} paginas)`);
process.exit(fails.length ? 1 : 0);
