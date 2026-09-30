// Regenerates responsive WebP variants (<name>-480.webp, <name>-960.webp) from the originals.
// Originals are never modified. Usage: node tools/make-images.mjs
// Needs `sharp` (npm i sharp in tools/, or set SHARP_DIR to a folder whose node_modules has it).
import { createRequire } from 'node:module';
import { fileURLToPath } from 'node:url';
import path from 'node:path';
import fs from 'node:fs';

const here = path.dirname(fileURLToPath(import.meta.url));
const dir = path.join(here, '..', 'assets', 'images');
const load = (base) => createRequire(path.join(base, 'x.js'))('sharp');
let sharp;
for (const base of [here, process.env.SHARP_DIR].filter(Boolean)) {
  try { sharp = load(base); break; } catch {}
}
if (!sharp) { console.error('sharp not found: run `npm i sharp` in tools/ or set SHARP_DIR'); process.exit(1); }

const originals = ['hero-casa', 'servicio-cochera', 'servicio-piscina', 'servicio-quincho'];
const widths = [480, 960];
const QUALITY = 76;
const MOBILE_HERO_MAX = 70 * 1024;

for (const name of originals) {
  const src = path.join(dir, `${name}.webp`);
  for (const w of widths) {
    let q = QUALITY;
    let buf;
    // hero-casa-480 must stay under the mobile budget; lower quality until it fits.
    do {
      buf = await sharp(src).resize({ width: w }).webp({ quality: q, effort: 6 }).toBuffer();
      q -= 4;
    } while (name === 'hero-casa' && w === 480 && buf.length > MOBILE_HERO_MAX && q >= 40);
    fs.writeFileSync(path.join(dir, `${name}-${w}.webp`), buf);
    console.log(`${name}-${w}.webp ${buf.length} bytes`);
  }
}
