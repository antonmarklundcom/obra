#!/usr/bin/env node
// Playwright sobre cada URL del sitemap a 1366x768 y 390x844 (docs/IMPROVE-PLAN.md §5.4).
// Falla (exit 1) ante errores de consola, requests fallidos, imagenes rotas, scroll horizontal,
// barra fija movil mal mostrada u ocultada, o botones de accion de menos de 44 px.
// Uso: node tools/pw-check.mjs <base-url> [--paths=/,/casas/] [--shots=./audit-shots]
import { mkdirSync, existsSync } from 'node:fs';
import { chromium } from 'playwright';

const args = process.argv.slice(2);
const base = (args.find(a => !a.startsWith('--')) || 'http://localhost:8081').replace(/\/$/, '');
const opt = k => (args.find(a => a.startsWith(`--${k}=`)) || '').split('=').slice(1).join('=');
const shotsDir = opt('shots') || 'audit-shots';
const VIEWPORTS = [{ name: 'desktop', width: 1366, height: 768 }, { name: 'mobile', width: 390, height: 844 }];
const SHOTS = ['/', '/servicios/', '/casas/', '/piscinas/', '/piscinas/chicas/', '/quinchos/techo-madera/', '/guias/', '/guias/costo-casa/', '/cotizar/', '/credito/'];
const NO_STICKY = ['/cotizar/', '/gracias/'];

let paths = opt('paths') ? opt('paths').split(',') : null;
if (!paths) {
  const sm = await (await fetch(base + '/sitemap.xml')).text();
  paths = [...sm.matchAll(/<loc>([^<]+)<\/loc>/g)].map(m => new URL(m[1]).pathname);
  paths.push('/gracias/');
}

const executablePath = existsSync('/opt/pw-browsers/chromium') && !process.env.PLAYWRIGHT_BROWSERS_PATH ? '/opt/pw-browsers/chromium' : undefined;
const browser = await chromium.launch(executablePath ? { executablePath } : {});
mkdirSync(shotsDir, { recursive: true });
const fail = []; const lcp = {}; let runs = 0;

for (const vp of VIEWPORTS) {
  const context = await browser.newContext({ viewport: { width: vp.width, height: vp.height }, deviceScaleFactor: 1, isMobile: vp.name === 'mobile', hasTouch: vp.name === 'mobile' });
  for (const path of paths) {
    const page = await context.newPage();
    const errs = [];
    page.on('console', m => { if (m.type() === 'error') errs.push('console: ' + m.text()); });
    page.on('pageerror', e => errs.push('pageerror: ' + e.message));
    page.on('requestfailed', r => { if (r.url().startsWith(base)) errs.push('requestfailed: ' + r.url()); });
    page.on('response', r => { if (r.url().startsWith(base) && r.status() >= 400 && r.request().resourceType() !== 'document') errs.push(`http ${r.status()}: ${r.url()}`); });
    await page.addInitScript(() => {
      window.__lcp = null;
      new PerformanceObserver(list => { const e = list.getEntries().at(-1); if (e) window.__lcp = { tag: e.element?.tagName || '?', src: (e.element?.currentSrc || e.url || '').split('/').pop(), t: Math.round(e.startTime) }; }).observe({ type: 'largest-contentful-paint', buffered: true });
    });
    const res = await page.goto(base + path, { waitUntil: 'load' });
    runs++;
    const where = `${vp.name} ${path}`;
    if (!res || res.status() !== 200) fail.push(`${where}: status ${res && res.status()}`);
    await page.waitForTimeout(150);
    const r = await page.evaluate(() => {
      const vis = el => { if (!el) return false; const s = getComputedStyle(el); const b = el.getBoundingClientRect(); return s.display !== 'none' && s.visibility !== 'hidden' && b.width > 0 && b.height > 0; };
      const sticky = document.querySelector('[data-sticky-cta]');
      const small = [];
      for (const el of document.querySelectorAll('a[data-wa], .btn, .menu-toggle, [data-sticky-cta] a, .wa-fab, a[href^="tel:"]')) {
        if (!vis(el) || el.closest('.site-nav:not(.is-open)')) continue;
        const b = el.getBoundingClientRect();
        if (b.height < 44 || b.width < 44) small.push(`${el.className || el.tagName} ${Math.round(b.width)}x${Math.round(b.height)}`);
      }
      return {
        hscroll: document.documentElement.scrollWidth > innerWidth + 1,
        broken: [...document.images].filter(i => i.complete && i.naturalWidth === 0 && i.loading !== 'lazy').map(i => i.src),
        sticky: vis(sticky), fab: vis(document.querySelector('.wa-fab')), small, lcp: window.__lcp,
      };
    });
    if (SHOTS.includes(path)) await page.screenshot({ path: `${shotsDir}/${vp.name}${path.replace(/\//g, '_') || '_'}.png`, fullPage: false });
    // Imagenes lazy: forzar carga desplazando hasta el final y revisar.
    await page.evaluate(async () => { for (let y = 0; y < document.body.scrollHeight; y += innerHeight) { scrollTo(0, y); await new Promise(r => setTimeout(r, 30)); } });
    await page.waitForLoadState('networkidle').catch(() => {});
    const brokenLazy = await page.evaluate(() => [...document.images].filter(i => i.complete && i.naturalWidth === 0).map(i => i.src));
    errs.forEach(e => fail.push(`${where}: ${e}`));
    if (r.hscroll) fail.push(`${where}: horizontal scroll`);
    [...new Set([...r.broken, ...brokenLazy])].forEach(s => fail.push(`${where}: broken image ${s}`));
    const wantSticky = vp.name === 'mobile' && !NO_STICKY.includes(path);
    if (r.sticky !== wantSticky) fail.push(`${where}: sticky bar ${r.sticky ? 'visible' : 'hidden'} (want ${wantSticky ? 'visible' : 'hidden'})`);
    if (vp.name === 'mobile' && r.fab) fail.push(`${where}: round FAB visible on mobile`);
    r.small.forEach(s => fail.push(`${where}: tap target under 44px: ${s}`));
    lcp[where] = r.lcp;
    await page.close();
  }
  await context.close();
}
await browser.close();

const els = {}; for (const v of Object.values(lcp)) { const k = v ? `${v.tag} ${v.tag === 'IMG' ? v.src : ''}`.trim() : 'none'; els[k] = (els[k] || 0) + 1; }
console.log(`pw-check: ${runs} runs (${paths.length} URLs x ${VIEWPORTS.length} viewports). LCP elements: ${Object.entries(els).map(([k, n]) => `${k}=${n}`).join(', ')}. Screenshots in ${shotsDir}/`);
if (fail.length) { console.error(`pw-check FAILED (${fail.length}):\n  ` + fail.slice(0, 100).join('\n  ')); process.exit(1); }
console.log('pw-check OK');
