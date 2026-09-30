# Build window prompt: obra.com.py improvement (paste this whole file as the first message)

You are the **director** of this build: Opus 5.5 at medium effort. You write the foundation code and review everything yourself. You fan out same-shaped work to **Sonnet 5.5 subagents** (low or medium effort, as named per phase). **Never use Fable** for anything (no subagent, session, workflow or routine). Work autonomously and stop only for decisions that are Anton's (listed at the end). Fix whatever you find along the way (broken links, lint, PHP errors, failing checks, review comments, merge conflicts) instead of just reporting it.

## Site and repo
- Site: https://obra.com.py, a PHP brochure site (no DB, no build step). Repo: https://github.com/antonmarklundcom/obra. Live == repo as of 2026-09-29.
- Run locally: `php -S localhost:8081 router.php` (on Anton's PC PHP is in `C:\php`: `$env:Path = "C:\php;$env:Path"` in PowerShell first).
- Structure: `index.php` (router + schema), `app/content.php` (12 hubs), `app/content-sub.php` (29 specialties), `app/content-guides.php` (7 guides + `/credito/`), `app/pages.php`, `app/layout.php`, `app/helpers.php`, `app/routes.php` (routes + legacy 301s), `form.php` (lead form), `config/site.php` (+ untracked `config/local.php`), `sitemap.php` (dynamic, 56 URLs), `.htaccess`, `router.php` (local mirror of the .htaccess rules).
- Read first, in this order: `docs/IMPROVE-PLAN.md` (the plan you execute; its §-numbers are used below), `audit-before.json` (baseline of all 56 URLs), `docs/seo/obra-com-py-site-structure.md`, `docs/SEO-RESEARCH.md`, `docs/LAUNCH-CHECKLIST.md`, `CLAUDE-CHANGES.md`.
- If Anton answered the plan's §9 questions, his answers are in this chat or in `docs/IMPROVE-PLAN.md` §9. Otherwise use the **recommended** option for D1–D3 and skip whatever needs D4–D9.

## Hard rules (every phase, every subagent: copy them into each subagent prompt)
1. **Only WhatsApp number anywhere:** `+595 992 279599`, i.e. `https://wa.me/595992279599`, `tel:+595992279599`, display `+595 992 279 599`. The retired stage-1 number (the `+595 995 …` one, still in 4 docs today, see plan F1) must appear nowhere in code or docs, and no file may spell it out, not even the QA tool. Detect it generically: any PY mobile number other than 595992279599 is a failure.
2. Every WhatsApp CTA has a pre-written Spanish message: Paraguay voseo ("querés", "tenés", "contanos"), no prices, no "gratis", no fixed plazos, PYG only if money is mentioned. The message differs per page and per service. **All messages live in one map file, `app/wa-messages.php`.** QA fails on any other number or an empty or too-short text.
3. SEO division: **obra = build and execution**. **arq.com.py = design** (planos, diseño, renders, carpeta municipal, regularización, cálculo estructural, and all style terms like casas minimalistas/modernas, fachadas modernas). **carpinteria.com.py = wood and aluminium products only**. Pérgolas, decks and machimbre/techos de madera belong to **obra**. **At most one contextual cross-link to a sibling per page**, and only to a URL confirmed live (HEAD 200); otherwise plain text.
4. Keywords: use the **keyword-library MCP** (`list_projects`, `project_overview`, `list_groups`, `get_group`, `keyword_lookup`). One meaning group = one page or section. Never plan pages for brand or competitor phrases. Volumes are Paraguay only.
5. Existing URLs, titles, H1s, canonicals, robots and schema types are **frozen** unless the plan's approved-change list says otherwise. Word count and internal links-in may only go up. No URL changes without a 301 in `obra_legacy_redirects()`.
6. No prices, no invented years, statistics, reviews, guarantees, team names or "mejor/garantizado". Images are labelled referencial; generated images are never presented as real obras.
7. Secrets: never print, commit or send real keys. `config/local.php` and `.env` stay out of git; only `*.example` files are versioned. Form tests use `OBRA_CRM_MOCK=success|fail` (and unset); never a real CRM key.
8. No GitHub Actions workflows (budget policy). The gate is local: `tools/verify`.
9. No model names in commits, PRs, code or docs.

## Phase 0: preflight (Opus, sequential)
1. `git fetch origin && git checkout main && git pull`. Create the working branch `claude/obra-improve-<yyyymmdd>` (or the branch the harness assigns). Confirm `git status` is clean.
2. Start the local server and check that `/sitemap.xml` lists 56 URLs.
3. **Live baseline:** if `https://obra.com.py` is reachable from this machine, crawl it (use the `tools/audit.mjs` you write in Phase 1 step 1, or a quick fetch of the 56 URLs) and confirm titles, H1s and status match `audit-before.json`. Note any drift in the report. If it's not reachable, note that the live check must happen from Anton's PC.
4. **Keyword pull** (keyword-library MCP): find the obra project, list its groups, map each group to a row in plan §3.1/§3.2/§3.3, and write `docs/seo/obra-keyword-map.md` with PY volumes. Mark each NEW-x candidate as build (volume > 0, distinct meaning) or skip. If the MCP isn't available in this session, say so in the report, build no NEW pages, and continue with everything else.

## Phase 1: foundation (Opus, sequential, one commit per step)
1. **Tools** (plan item 1): `tools/audit.mjs` (Node 20+, built-in fetch; regex/DOM-lite parsing; same JSON schema as `audit-before.json`; args: base URL, canonical origin, out file), `tools/seo-diff.mjs` (plan §4.4 rules; exit 1 on violation; reads `docs/audit/approved-changes.json`), `tools/check-wa.mjs` (plan §5.1 QA, including the repo-wide old-number grep), `tools/pw-check.mjs` (Playwright at 1366×768 and 390×844 on all sitemap URLs: console errors, failed requests, broken images, horizontal scroll, LCP element, sticky bar visible or hidden per page type, tap targets ≥ 44 px; screenshots of 10 key pages to `./audit-shots/`, gitignored), and `tools/verify.sh` + `tools/verify.ps1` that run: `php -l` on every PHP file, all 56 routes 200 + legacy 301s + blocked paths 404, the form matrix (plan §5.2) against a second server started with each `OBRA_CRM_MOCK` value, check-wa, audit → seo-diff, pw-check. Move `audit-before.json` → `docs/audit/audit-before.json`. Add `audit-shots/`, `node_modules/` and `docs/audit/audit-after*.json` handling to `.gitignore` as needed (commit the before/after JSON; keep the screenshots out). Playwright: `npm i -D playwright` in a `tools/package.json` (don't download browsers if a local Chromium exists; on Anton's PC `npx playwright install chromium` once is OK).
2. **Old number and docs** (item 2): Sonnet 5.5 **low** subagent. Replace the old number in `docs/seo/*.md` and `CLAUDE-CHANGES.md` (no historical note that spells out the old digits; write "número de etapa 1 anterior, reemplazado"). Make `docs/seo/obra-com-py-site-structure.md` the single structure doc (the `docs/` copy becomes a 2-line pointer), document `/guias/` (7 guides + `/credito/`), mark `/obras/` as deferred until real photos, and add the plan §2 division. You review the diff.
3. **Content split** (item 8): the loader globs `app/content/sub/{hub}.php` and `app/content/guides/{slug}.php` in the current order. **Gate:** save the HTML of all 56 URLs before and after and diff them (ignore `?v=`); it must be identical. Update `tools/package-hostinger.ps1` to include the new folders.
4. **WhatsApp map** (item 3): write `app/wa-messages.php` + `obra_wa_text()` in `app/helpers.php`, and replace every hard-coded message in `app/layout.php` / `app/pages.php`. A Sonnet 5.5 **low** subagent drafts the texts for every sitemap path × placement (hero, band, sticky, header, footer), every service slug, the form template, and the fallbacks for `/gracias/` and 404, following rule 2 and the examples in plan §5.1. You review every line for voseo, no prices and uniqueness. Apply D2 (default: remove the picker in `assets/js/site.js`, keep the GA4 `whatsapp_click` event with `placement`, `page_path` and `service`).
5. **Mobile sticky bar + FAB + tel** (item 4, plan §5.4).
6. **Form** (item 5, plan §5.2).
7. **Cross-links** (item 6, plan §3.1/§3.2): HEAD-check each arq or carpinteria target first. One per page max.
8. **Meta descriptions** (item 7): Sonnet 5.5 **low** drafts ≤155-character descriptions for the 30 long ones, primary keyword first; you review. Add each changed path to `approved-changes.json` (description only).
9. **Images** (item 12): Sonnet 5.5 **low**: `srcset`/`sizes` 480/960/1600 for the 4 WebPs (generate the variants with sharp/npx or the webimg CLI), a mobile hero ≤ 70 KB, `width`/`height` kept, delete `assets/images/og-obra.png` (unused; confirm with grep first).
10. **Sitemap lastmod per page** (item 15): Sonnet 5.5 **low**.
11. Run `tools/verify` → must be green before Phase 2.

## Phase 2: content fan-out (Sonnet 5.5 subagents, **medium** effort, in parallel, max 6 at once)
Write one spec (plan §3.4 step 2) and give every agent: the spec, the hard rules, its keyword rows from `docs/seo/obra-keyword-map.md`, and **only its own files**. They must not touch shared files (`app/pages.php`, `app/layout.php`, `app/wa-messages.php`, CSS); if a template field is missing, they report it to you.
- A `app/content/sub/casas.php` (4, including D1 `/casas/minimalistas/` repositioned to execution + one arq link)
- B `quintas.php` + `piscinas.php` (6, **highest priority: pool season**)
- C `quinchos.php` + `patios.php` (6, techo-madera/decks/pérgolas widened as obra-owned)
- D `reformas.php` + `ampliaciones.php` (7)
- E `tinglados.php` + `muros.php` + `comerciales.php` (5)
- F `supervision.php` + hub deepen sections in `app/content.php` hub entries (you assign the hub rows) + the 8 guides in `app/content/guides/*` (plan item 10)
Targets: specialties 700–1,000 unique words, 4–6 FAQs, the sections from the spec; titles, H1s and URLs untouched. Afterwards **you** review every diff (voice, rules, cannibalization between siblings, frozen fields, one cross-link max) and add the contextual guide ↔ service links yourself.
Then **new pages** (plan item 11, only the NEW-x rows marked build in Phase 0): one Sonnet 5.5 **medium** agent per 2–3 pages, each writing a new file; you add the WA map entries and check sitemap, menu and breadcrumbs.

## Phase 3: trust pages (Opus), only if Anton gave the facts (D8)
`/nosotros/`, `/como-trabajamos/` and `/cotizar/` with real facts; NAP + `tel` in the footer and schema. The facts go in `config/local.php` on the server (never commit them if private); only public copy goes in the repo.

## Phase 4: verify (Opus)
1. `tools/verify` (all of: php -l, routes/301/404, form matrix with `OBRA_CRM_MOCK`, check-wa, audit-after → seo-diff vs `docs/audit/audit-before.json`, pw-check at 1366 and 390). Everything green.
2. Internal link check: 0 broken targets; every new page has ≥ 3 inbound links.
3. Number check: `tools/check-wa` + a repo-wide grep for any PY mobile number other than 595992279599 → 0 hits.
4. Look at the 20 screenshots yourself (hero, sticky bar, no overlap, no horizontal scroll).
5. Commit `docs/audit/audit-after.json` and the diff summary.

## Phase 5: PR, review, merge, live verify (Opus; you own the whole git flow)
1. Push the branch and open **one PR** to `main`. The PR body lists: the work items done, the verify output summary (routes, seo-diff, check-wa, Playwright), changed descriptions, new URLs, skipped items and why, and the decisions pending.
2. Watch the PR: address every review comment or bot finding (fix and push, or reply with why not), resolve merge conflicts by merging `main` into the branch (never force-push), and re-run `tools/verify` after every fix.
3. **Merge only when verify is green and no review thread is open.** Merging to `main` may auto-deploy on Hostinger. If Anton said deploy is a manual zip, run the package script and ask Anton to upload; that's his step.
4. **Post-deploy live check** (from a machine that can reach obra.com.py): `tools/audit.mjs https://obra.com.py` → `docs/audit/audit-live-after.json`, then `seo-diff` against before, `check-wa` on live HTML, and pw-check on 6 URLs (`/`, `/casas/`, `/piscinas/`, `/quinchos/techo-madera/`, `/guias/costo-casa/`, `/cotizar/`) at 390 and 1366, plus `/sitemap.xml` and `/robots.txt`. A failure means fixing forward in a new PR at once; if an existing URL 404s or goes noindex, revert the merge commit first, then fix.
5. Update `docs/LAUNCH-CHECKLIST.md` ticks.

## Final report (write it, commit it in the PR or a follow-up PR)
`docs/reports/BUILD-REPORT-<yyyymmdd>.md`: what shipped (per work item, with commit SHAs), the PR link and merge SHA, verify results before and after (counts: URLs, words median, inlinks, WA texts, numbers found), the seo-diff summary, the live check result, new URLs, anything skipped or broken and what you did about it, and open decisions for Anton. End the chat with the report path, the PR link and the three most important numbers.

## Stop only for Anton's decisions
D1 minimalistas (default: reposition) · D2 picker (default: remove) · D3 credit terms (default: stay on /credito/) · D4 /obras/ (skip without real photos) · D5 zone pages (skip) · D6 unknown arq URLs (text only) · D7 new-page list (build only volume-confirmed) · D8 business facts (skip Phase 3 without them) · D9 image budget (no new Higgsfield generation without his yes). Anything else, including failures, conflicts and review comments, you resolve yourself.
