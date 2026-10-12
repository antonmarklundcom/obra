#!/usr/bin/env node
// Comprueba con HEAD las paginas de sitios hermanos que el contenido enlaza ('link' => ['site', 'path']).
// Escribe config/partner-live-paths.json con las rutas que responden 200; config/site.php lo lee en live_paths.
// Solo sitios con 'live' => true. Uso (red real): NODE_USE_ENV_PROXY=1 node tools/check-partners.mjs [--php=php]
import { execFileSync } from 'node:child_process';
import { writeFileSync } from 'node:fs';
import { fileURLToPath } from 'node:url';
import { dirname, join } from 'node:path';

const root = join(dirname(fileURLToPath(import.meta.url)), '..');
const PHP = (process.argv.find(a => a.startsWith('--php=')) || '').slice(6) || process.env.PHP || 'php';
const php = `
$config = require 'config/site.php'; require 'app/helpers.php'; $content = require 'app/content.php'; $links = [];
$walk = function ($v) use (&$walk, &$links) { if (!is_array($v)) return; if (isset($v['link']['site'], $v['link']['path'])) $links[] = $v['link']; foreach ($v as $x) $walk($x); };
$walk($content);
$sites = []; foreach ($config['partner_sites'] as $k => $s) $sites[$k] = ['url' => $s['url'], 'live' => !empty($s['live'])];
echo json_encode(['sites' => $sites, 'links' => $links]);`;
const { sites, links } = JSON.parse(execFileSync(PHP, ['-r', php], { cwd: root, encoding: 'utf8', env: { ...process.env, OBRA_LOCAL_CONFIG: '0' } }));

const out = {};
for (const [site, s] of Object.entries(sites)) {
  if (!s.live) continue;
  const paths = [...new Set(links.filter(l => l.site === site).map(l => l.path))].sort();
  out[site] = [];
  for (const path of paths) {
    const url = s.url.replace(/\/$/, '') + path;
    let status = 0;
    try { status = (await fetch(url, { method: 'HEAD', redirect: 'manual', signal: AbortSignal.timeout(10000) })).status; } catch (e) { status = `error ${e.cause?.code || e.message}`; }
    console.log(`${status === 200 ? 'live' : 'skip'}  ${url}  ${status}`);
    if (status === 200) out[site].push(path);
  }
}
const file = join(root, 'config', 'partner-live-paths.json');
writeFileSync(file, JSON.stringify({ checked_at: new Date().toISOString().slice(0, 10), live_paths: out }, null, 1) + '\n');
console.log(`check-partners: ${Object.values(out).flat().length} live of ${links.length} links -> config/partner-live-paths.json`);
