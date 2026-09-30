#!/usr/bin/env node
// Avisa a Bing, Yandex y otros buscadores con IndexNow de las URLs del sitemap (o de las que pases).
// La clave es publica por diseno: el archivo <clave>.txt en la raiz del sitio la demuestra.
// Uso: node tools/indexnow.mjs [https://obra.com.py] [/guias/costo-quincho/ /quinchos/ ...]
import { readdirSync, readFileSync } from 'node:fs';
import { fileURLToPath } from 'node:url';
import path from 'node:path';

const root = path.join(path.dirname(fileURLToPath(import.meta.url)), '..');
const origin = (process.argv[2] || 'https://obra.com.py').replace(/\/$/, '');
const only = process.argv.slice(3);
const keyFile = readdirSync(root).find(f => /^[a-f0-9]{32}\.txt$/.test(f));
if (!keyFile) { console.error('No hay archivo de clave IndexNow (<32 hex>.txt) en la raiz.'); process.exit(2); }
const key = keyFile.replace('.txt', '');
if (readFileSync(path.join(root, keyFile), 'utf8').trim() !== key) { console.error('El contenido del archivo de clave no coincide con su nombre.'); process.exit(2); }

let urls = only.map(p => origin + p);
if (!urls.length) {
  const xml = await (await fetch(origin + '/sitemap.xml')).text();
  urls = [...xml.matchAll(/<loc>([^<]+)<\/loc>/g)].map(m => m[1]);
}
if (!urls.length) { console.error('Sin URLs para enviar.'); process.exit(2); }
const res = await fetch('https://api.indexnow.org/indexnow', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json; charset=utf-8' },
  body: JSON.stringify({ host: new URL(origin).host, key, keyLocation: `${origin}/${keyFile}`, urlList: urls }),
});
console.log(`IndexNow: ${res.status} ${res.statusText} (${urls.length} URLs)`);
process.exit(res.status === 200 || res.status === 202 ? 0 : 1);
