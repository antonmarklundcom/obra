#!/usr/bin/env node
// Puerta de calidad local (sin CI). La llaman tools/verify.sh y tools/verify.ps1.
//  1. php -l en cada archivo PHP
//  2. rutas: sitemap 200 sin avisos PHP, 301 heredados, rutas bloqueadas 404
//  3. formulario: matriz de docs/IMPROVE-PLAN.md §5.2 con OBRA_CRM_MOCK=success|fail|sin definir
//  4. check-wa  5. audit + seo-diff contra docs/audit/audit-before.json  6. pw-check (Playwright)
// Opciones: --skip-pw (sin Playwright), --php=<ruta a php>
import { spawn, spawnSync, execFileSync } from 'node:child_process';
import { fileURLToPath } from 'node:url';
import { dirname, join } from 'node:path';
import { mkdtempSync } from 'node:fs';
import { tmpdir } from 'node:os';

const root = join(dirname(fileURLToPath(import.meta.url)), '..');
const args = process.argv.slice(2);
const PHP = (args.find(a => a.startsWith('--php=')) || '').slice(6) || process.env.PHP || 'php';
const OK = '595992279599';
const results = []; const servers = [];
const step = (name, ok, detail = '') => { results.push({ name, ok, detail }); console.log(`${ok ? 'PASS' : 'FAIL'}  ${name}${detail ? '  ' + detail : ''}`); };
const sleep = ms => new Promise(r => setTimeout(r, ms));

async function server(port, env = {}) {
  const p = spawn(PHP, ['-S', `127.0.0.1:${port}`, 'router.php'], { cwd: root, env: { ...process.env, OBRA_LOCAL_CONFIG: '0', OBRA_CRM_MOCK: '', ...env }, stdio: 'ignore' });
  servers.push(p);
  const base = `http://127.0.0.1:${port}`;
  for (let i = 0; i < 50; i++) { try { await fetch(base + '/robots.txt'); return base; } catch { await sleep(100); } }
  throw new Error(`php -S on ${port} did not start`);
}
const node = (script, a) => spawnSync(process.execPath, [join(root, 'tools', script), ...a], { cwd: root, encoding: 'utf8' });

try {
  // 1. Sintaxis PHP
  const files = execFileSync('git', ['ls-files', '--cached', '--others', '--exclude-standard', '*.php'], { cwd: root, encoding: 'utf8' }).split('\n').filter(Boolean);
  const bad = files.filter(f => spawnSync(PHP, ['-l', f], { cwd: root, encoding: 'utf8' }).status !== 0);
  step('php -l', bad.length === 0, `${files.length} files${bad.length ? ', errors: ' + bad.join(' ') : ''}`);

  const base = await server(8090);

  // 2. Rutas
  const sm = await (await fetch(base + '/sitemap.xml')).text();
  const paths = [...sm.matchAll(/<loc>([^<]+)<\/loc>/g)].map(m => new URL(m[1]).pathname);
  const routeFail = [];
  for (const p of paths) {
    const r = await fetch(base + p, { redirect: 'manual' });
    const html = await r.text();
    if (r.status !== 200) routeFail.push(`${p} ${r.status}`);
    if (/(Warning|Notice|Deprecated|Fatal error|Parse error):/.test(html)) routeFail.push(`${p} PHP warning in output`);
    if (!/<\/html>\s*$/.test(html)) routeFail.push(`${p} page truncated (PHP fatal error after output started?)`);
  }
  const legacy = JSON.parse(execFileSync(PHP, ['-r', "require 'app/routes.php'; echo json_encode(obra_legacy_redirects());"], { cwd: root, encoding: 'utf8' }));
  legacy['/piscinas'] = '/piscinas/'; legacy['/sitemap.php'] = '/sitemap.xml';
  for (const [from, to] of Object.entries(legacy)) {
    const r = await fetch(base + from, { redirect: 'manual' });
    if (r.status !== 301 || r.headers.get('location') !== to) routeFail.push(`${from} -> ${r.status} ${r.headers.get('location')} (want 301 ${to})`);
  }
  for (const p of ['/app/', '/app/helpers.php', '/config/', '/config/site.php', '/docs/', '/tools/', '/no-existe/']) {
    const r = await fetch(base + p, { redirect: 'manual' });
    if (r.status !== 404) routeFail.push(`${p} ${r.status} (want 404)`);
  }
  const fg = await fetch(base + '/form.php', { redirect: 'manual' });
  if (fg.status !== 405) routeFail.push(`GET /form.php ${fg.status} (want 405)`);
  step('routes', routeFail.length === 0, `${paths.length} sitemap URLs 200, ${Object.keys(legacy).length} 301s, blocked 404` + (routeFail.length ? '\n      ' + routeFail.join('\n      ') : ''));

  // 3. Formulario
  const formFail = []; let formCases = 0;
  const valid = { name: 'Prueba QA', phone: '0981 123 456', service: 'piscinas', location: 'Luque', terrain: 'si', financing: 'propios', message: 'Prueba automatica del formulario, sin datos reales.', consent: '1', return_path: '/cotizar/', origin_path: '/piscinas/chicas/', placement: 'form', started_at: String(Math.floor(Date.now() / 1000) - 30) };
  const post = async (b, data) => {
    const r = await fetch(b + '/form.php', { method: 'POST', redirect: 'manual', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body: new URLSearchParams(data).toString() });
    formCases++;
    return { status: r.status, location: r.headers.get('location') || '' };
  };
  for (const mock of ['success', 'fail', '']) {
    const b = await server(8091 + ['success', 'fail', ''].indexOf(mock), { OBRA_CRM_MOCK: mock });
    const tag = `mock=${mock || 'unset'}`;
    const r = await post(b, valid);
    if (r.status !== 303 || !r.location.startsWith(`https://wa.me/${OK}?text=`)) formFail.push(`${tag} valid -> ${r.status} ${r.location.slice(0, 60)}`);
    else {
      const text = new URL(r.location).searchParams.get('text') || '';
      if (!text.includes('Prueba QA') || !text.includes('Luque')) formFail.push(`${tag} WA text lacks lead data`);
      if (!text.includes('/piscinas/chicas/')) formFail.push(`${tag} WA text lacks origin page`);
    }
    if (mock !== 'success') continue;
    const hp = await post(b, { ...valid, website: 'spam' });
    if (hp.status !== 303 || hp.location !== '/gracias/?estado=enviado') formFail.push(`honeypot -> ${hp.location}`);
    const fast = await post(b, { ...valid, started_at: String(Math.floor(Date.now() / 1000)) });
    if (!/error=tiempo/.test(fast.location)) formFail.push(`too fast -> ${fast.location}`);
    for (const k of ['name', 'phone', 'service', 'location', 'terrain', 'financing', 'message', 'consent']) {
      const d = { ...valid }; delete d[k];
      const m = await post(b, d);
      if (m.status !== 303 || !/^\/cotizar\/\?error=campos/.test(m.location)) formFail.push(`missing ${k} -> ${m.location}`);
      else if (k !== 'service' && !/servicio=piscinas/.test(m.location)) formFail.push(`missing ${k}: service not kept (${m.location})`);
    }
    const foreign = await post(b, { ...valid, phone: '+1 202 555 0147' });
    if (!/error=campos/.test(foreign.location)) formFail.push(`non-PY phone -> ${foreign.location}`);
    const evil = await post(b, { ...valid, name: '', return_path: 'https://evil.example/' });
    if (!evil.location.startsWith('/cotizar/?error=campos')) formFail.push(`off-site return_path -> ${evil.location}`);
  }
  step('form matrix', formFail.length === 0, `${formCases} cases` + (formFail.length ? '\n      ' + formFail.join('\n      ') : ''));

  // 4. WhatsApp
  const wa = node('check-wa.mjs', [base]);
  step('check-wa', wa.status === 0, (wa.stdout + wa.stderr).trim().split('\n').join('\n      '));

  // 5. Auditoria + seo-diff
  const auditFile = join(mkdtempSync(join(tmpdir(), 'obra-verify-')), 'audit-after.json');
  const au = node('audit.mjs', [base, 'https://obra.com.py', auditFile]);
  step('audit', au.status === 0, (au.stdout + au.stderr).trim());
  const sc = node('seo-check.mjs', [auditFile]);
  step('seo-check', sc.status === 0, (sc.stdout + sc.stderr).trim().split('\n').join('\n      '));
  const sd = node('seo-diff.mjs', [join(root, 'docs/audit/audit-before.json'), auditFile]);
  step('seo-diff', sd.status === 0, (sd.stdout + sd.stderr).trim().split('\n').join('\n      '));

  // 6. Playwright
  if (args.includes('--skip-pw')) step('pw-check', true, 'skipped (--skip-pw)');
  else {
    const pw = node('pw-check.mjs', [base, `--shots=${join(root, 'audit-shots')}`]);
    step('pw-check', pw.status === 0, (pw.stdout + pw.stderr).trim().split('\n').slice(0, 40).join('\n      '));
  }
} catch (e) {
  step('verify', false, e.message);
} finally {
  servers.forEach(s => s.kill());
}
const failed = results.filter(r => !r.ok);
console.log(failed.length ? `\nVERIFY FAILED: ${failed.map(r => r.name).join(', ')}` : '\nVERIFY GREEN');
process.exit(failed.length ? 1 : 0);
