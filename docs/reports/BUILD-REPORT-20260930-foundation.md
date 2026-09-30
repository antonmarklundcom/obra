# Build report: obra.com.py foundation (session 1 of 2), 2026-09-30

Branch `claude/charming-albattani-w2gydt` → PR to `main` (link and merge SHA: see the follow-up section at the end, filled after merge).
Quality gate: `bash tools/verify.sh` (Windows: `tools\verify.ps1`) is **green** on the final commit.

## What shipped (per plan item)

| # | Item | Commit | Result |
|---|---|---|---|
| 1 | Cross-platform tools: `tools/audit.mjs`, `seo-diff.mjs`, `check-wa.mjs`, `pw-check.mjs`, `verify.mjs` + `verify.sh`/`verify.ps1`, `tools/package.json` (Playwright) | `f1e98cb` | `audit.mjs` reproduces `docs/audit/audit-before.json` exactly on all 56 pages (all fields incl. word counts). `docs/audit/approved-changes.json` created. `.gitignore` fixed: it listed `config.local.php` instead of `config/local.php`. `OBRA_LOCAL_CONFIG=0` lets tests ignore a real `config/local.php`. |
| 2 | Retired number removed, docs reconciled | `887381b` | 0 occurrences left in code and docs (also a fake-number pattern in `tools/qa.ps1` no longer spells a number). `docs/seo/obra-com-py-site-structure.md` is the single structure doc (56 real URLs, `/guias/` + `/credito/`, `/obras/` deferred, SEO division). `docs/seo/obra-keyword-map.md` created. |
| 8 | Content split | `a61c8fb` | `app/content/sub/{hub}.php` (11) and `app/content/guides/{slug}.php` (8), fixed order, new files append. **Gate passed: HTML of 56 URLs + /gracias/ + 404 + sitemap byte-identical** (ignoring `?v=` and the form timestamp). |
| 3 | WhatsApp message map (D2 default: picker removed) | `145ac59`, `067ed28` | `app/wa-messages.php`: 56 paths × 5 placements + 8 guide mid-box texts, 13 service texts, form template, 7 fallbacks. All reviewed: voseo, no prices, no plazos, unique. GA4 `whatsapp_click` keeps placement, page_path, service. |
| 4 | Mobile sticky bar, FAB fix, `tel:` | `145ac59` | Sticky WhatsApp + Cotizar ≤760 px on every page except /cotizar/ and /gracias/; hidden with the menu open or a field focused. FAB desktop-only and away from the "Imagen referencial" labels. "Llamar" `tel:+595992279599` in the footer and /cotizar/. Tap targets ≥44 px. |
| 5 | Form | `ee75f76` | `origin_path` + `placement` hidden fields (same-site referrer), service preselected, WA text from the map template, CRM fields and mail carry the origin. `obra_safe_return()` → `/cotizar/` and rejects off-site values (it used to return `/` for a full URL). |
| 6 | Cross-links | `13d1fbb` | /quinchos/techo-madera/ is obra-owned (carpinteria link + copy removed). 9 new contextual notes per plan 3.1/3.2, one per page. None of the sibling paths could be HEAD-checked (see "Blocked"), so they render as **text** until listed in `partner_sites[...]['live_paths']`. |
| 7 | Meta descriptions | `b00833b` | 30 descriptions 161–201 → 135–155 chars, keyword first, listed in `approved-changes.json`. Cards keep the previous text via `summary`, so no visible copy was lost. |
| 12 | Responsive images | `6d21dc1` | 480/960 WebP variants (`tools/make-images.mjs`), srcset + sizes on every `<img>`; mobile hero 19 KB (was 211 KB). `og-obra.png` (729 KB, unused) deleted. |
| 15 | Sitemap lastmod per page | `e6495b1` | Per content file mtime. Note: a zip upload or a fresh checkout sets all mtimes to the same moment, so dates only diverge as files are edited later. |
| — | Content v2 renderer + reference page | `b00833b`, `067ed28` | Optional `process`, `materials`, `sections`, `mistakes` fields; guide soft CTA after section 2. /piscinas/chicas/ written in full as the reference (975 words own copy, 5 FAQs). |
| — | Content spec + briefs | `478af67` | `docs/seo/CONTENT-SPEC.md`, `docs/seo/content-briefs/A–F.md`, `NEW.md`, `tools/content-words.php`, updated `docs/NEXT-WINDOW-PROMPT-SONNET.md`. |
| 13 | Trust pages | skipped | Needs D8 (public business facts). |

## Before / after (local render)

| Metric | Before (`audit-before.json`) | After (`audit-after-foundation-local.json`) |
|---|---|---|
| Sitemap URLs | 56 | 56 (0 new, 0 removed) |
| Non-200 / missing H1 / canonical mismatch | 0 / 0 / 0 | 0 / 0 / 0 |
| Word count min / median / max (inside `<main>`) | 186 / 350 / 982 | 186 / 364 / 1,153 |
| Descriptions over 160 chars | 30 | 0 |
| WhatsApp links on sitemap pages / distinct texts | 274 / 205 | 337 / 281 |
| WhatsApp numbers found | only 595992279599 | only 595992279599 (+ 62 `tel:` links, all the same number) |
| Other Paraguayan mobile numbers in repo | 5 hits (4 docs + 1 QA tool) | 0 |
| Home mobile hero bytes | 211 KB | 19 KB |

**seo-diff** (local, against `audit-before.json`): OK. 0 title/H1/canonical/robots/schema changes, 30 approved description changes, 19 pages with more words, none with fewer, no page lost internal links-in, all 14 legacy 301s and the blocked paths intact.
**check-wa**: OK: 60 pages (sitemap + /gracias/ states + 404), 345 WA links, 62 `tel:` links, 68 repo files scanned.
**pw-check**: OK: 114 runs (57 URLs × 1366/390): 0 console errors, 0 failed requests, 0 broken images, 0 horizontal scroll, sticky bar correct on every page, no tap target under 44 px.
**Form matrix**: 15 cases OK (mock success / fail / unset → 303 to wa.me/595992279599 with the origin page in the text; honeypot; too fast; each missing field keeps the service; non-PY phone; off-site return path).

## Blocked in this environment, and what was done

- **Live site unreachable.** The cloud environment's network policy denies `obra.com.py`, `arq.com.py` and `carpinteria.com.py` (proxy 403). So: (a) the Phase 0 live drift check, (b) HEAD checks of sibling URLs, and (c) the post-deploy live check could not run here. The crawl ran on the repo; the plan says live == repo as of 2026-09-29. To allow it next time, add those hosts in the environment's network settings.
- **keyword-library MCP not connected.** No PY volumes: every "Vol PY" is "sin dato" and every NEW-x is "skip (no data)" (`docs/seo/content-briefs/NEW.md`).

## Live check: pending Anton

Run on Anton's PC (PowerShell, repo root, after the deploy):

```powershell
$env:Path = "C:\php;$env:Path"
git checkout main; git pull
cd tools; npm install; npx playwright install chromium; cd ..
node tools/audit.mjs https://obra.com.py https://obra.com.py docs/audit/audit-live-after-foundation.json
node tools/seo-diff.mjs docs/audit/audit-before.json docs/audit/audit-live-after-foundation.json
node tools/check-wa.mjs https://obra.com.py --no-repo
node tools/pw-check.mjs https://obra.com.py --paths=/,/casas/,/piscinas/,/quinchos/techo-madera/,/guias/costo-casa/,/cotizar/
curl.exe -s https://obra.com.py/sitemap.xml | Select-String "<loc>" | Measure-Object   # expect 56
curl.exe -s https://obra.com.py/robots.txt
```

Every command must end with "OK" (seo-diff, check-wa, pw-check). If an existing URL returns 404 or noindex: revert the merge commit on main first, then fix. To check for drift **before** deploying (Phase 0), run the first two commands with `audit-live-before.json` against the live site while it still runs the old code.

If deploy is a manual zip: `powershell -ExecutionPolicy Bypass -File tools\package-hostinger.ps1`, upload to `public_html/`, keep `config/local.php` on the server. The old `app/content-sub.php` and `app/content-guides.php` on the server can be deleted (unused; blocked by .htaccess anyway).

## Open decisions for Anton

1. **Deploy method (plan §9 Q1):** is Hostinger Git auto-deploy connected to `main`? If yes, the merge is the deploy; if not, the zip above.
2. **D8 business facts:** razón social, RUC, address or zona, email, for /nosotros/, footer and schema. Trust pages were skipped without them.
3. **D6 sibling URLs:** which arq.com.py / carpinteria.com.py paths are live. Add each confirmed path to `live_paths` in `config/site.php`; the note then becomes a link automatically.
4. **Keyword volumes (D7):** connect the keyword-library MCP to the next session (or pull volumes yourself) to decide the NEW-x pages.
5. **D4 / D5 / D9:** /obras/ only with real photos; zone pages skipped; no new image generation without your yes.
6. **D1 / D2 / D3** were applied with the recommended defaults (minimalistas repositioned in the brief, picker removed, credit terms stay on /credito/). Say so if you want otherwise.
7. Carpinteria repo (not this repo): its /pergolas/, /decks/ and /machimbre/ pages should route to obra.

## Follow-up (filled after merge)
- PR: (see follow-up commit)
- Merge SHA: (see follow-up commit)
