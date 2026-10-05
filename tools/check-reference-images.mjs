// Protect the requested image distinctions and responsive local assets.
import { readFileSync, existsSync } from 'node:fs';
import { createHash } from 'node:crypto';
import { fileURLToPath } from 'node:url';
import { dirname, join } from 'node:path';
const root = join(dirname(fileURLToPath(import.meta.url)), '..');
const base = (process.argv[2] || 'http://127.0.0.1:8086').replace(/\/$/, '');
const entries = JSON.parse(readFileSync(join(root, 'docs/media/reference-images.json'), 'utf8'));
const failures = [], hashes = new Map();
if (entries.length !== 51) failures.push(`Expected 51 images, found ${entries.length}`);
for (const entry of entries) {
  const path = entry.slug === 'home' ? '/' : '/' + entry.slug.replace('-', '/') + '/';
  for (const width of [480, 960, 1200]) {
    const asset = join(root, 'assets/images/reference', `${entry.slug}-${width}.webp`);
    if (!existsSync(asset)) { failures.push(`Missing ${asset}`); continue; }
    const data = readFileSync(asset);
    if (data.toString('ascii', 8, 12) !== 'WEBP') failures.push(`Invalid WebP ${asset}`);
    if (width === 960) {
      const hash = createHash('sha256').update(data).digest('hex');
      if (hashes.has(hash)) failures.push(`Identical images: ${entry.slug} and ${hashes.get(hash)}`);
      hashes.set(hash, entry.slug);
    }
  }
  const response = await fetch(base + path);
  const html = await response.text();
  for (const match of html.matchAll(/href="#([^"]+)"/g)) {
    if (!html.includes(`id="${match[1]}"`)) failures.push(`${path}: missing jump target ${match[1]}`);
  }
  if (response.status !== 200) failures.push(`${path}: ${response.status}`);
  const hero = html.match(/<figure class="(?:conversion-media|hero-media)[^>]*>[\s\S]*?<\/figure>/)?.[0] || '';
  if (!hero.includes(`/assets/images/reference/${entry.slug}-960.webp`)) failures.push(`${path}: wrong hero subject`);
  if (!hero.includes('srcset=') || !hero.includes('Imagen generada')) failures.push(`${path}: missing responsive sizes or reference label`);
}
const roof = await (await fetch(base + '/techos/')).text();
const choices = [...roof.matchAll(/class="choice-card"[\s\S]*?<img src="([^"]+)"/g)].map(m => m[1]);
if (choices.length !== 3 || new Set(choices).size !== 3) failures.push('Roofing needs three distinct choice images');
const home = await (await fetch(base + '/')).text();
const directory = await (await fetch(base + '/servicios/')).text();
for (const match of directory.matchAll(/href="#([^"]+)"/g)) {
  if (!directory.includes(`id="${match[1]}"`)) failures.push(`Service directory: missing jump target ${match[1]}`);
}
if (!(home.indexOf('id="elegi"') < home.indexOf('id="empezar"') && home.indexOf('id="empezar"') < home.indexOf('id="servicios"'))) failures.push('Homepage opening order regressed');
if (failures.length) { console.error(failures.join('\n')); process.exit(1); }
console.log('reference-images OK: 51 distinct subjects, 153 WebP assets, hero labels/srcsets, roofing choices and homepage order');
