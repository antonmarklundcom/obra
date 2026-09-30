# Prompt for the Opus session (obra.com.py, round 4)

Model: Opus 5.5, high effort. Never Fable. No Google products (no GA4, Search Console, Maps, Ads, Tag Manager). One small PR per phase, merged to `main` only after `tools/verify.sh` is green (Git auto-deploy publishes every merge).

## Read first
`docs/NEXT-WINDOW-PROMPT.md` (HARD RULES still apply: one WhatsApp number 595992279599, voseo messages from `app/wa-messages.php`, no prices, no guarantees, no fixed plazos), `docs/IMPROVE-PLAN.md` (status sections at the end), `docs/LAUNCH-CHECKLIST.md`, `docs/seo/CONTENT-SPEC.md`, `docs/seo/obra-keyword-map.md`, `config/site.php`. Run `cd tools && npm ci`. Playwright uses the preinstalled Chromium; never `playwright install`. Live tools need `NODE_USE_ENV_PROXY=1`.

## State at the start (already on `main`)
- 65 indexable URLs: 12 hubs, 29 specialties, 17 guides, 7 fixed pages. Sitemap is dynamic, guides carry `published`/`updated`.
- Reverse links (services <-> guides), `seo-check` gate in verify, helpful 404 with `error_log`, IndexNow key file + `tools/indexnow.mjs`, LCP preload, own analytics (`t.php`, `stats.php`, `storage/`).
- Not done because they need Anton or the environment: live verification (needs `obra.com.py`, `carpinteria.com.py`, `arq.com.py`, `*.cloudfront.net` in the environment allowlist), `config/local.php` on the server (VenderCRM key, `stats_token`, business facts), real photos, reviews, keyword volumes (keyword-library MCP not connected), zones actually served.

## Preconditions (check first, in this order)
1. `curl -sI https://obra.com.py/` returns a real status. If not, say so in one short message and skip live work.
2. Ask Anton in ONE message (and keep working on what does not depend on it): (a) which zones he truly serves, with one real local detail each; (b) which real projects can be shown (photos, scope, stages, permission); (c) the keyword-library MCP connected or a CSV of PY volumes.
3. Run the live verification from `docs/reports/BUILD-REPORT-20260930-content.md` and commit the live audit JSON. A 500 on any rule means revert that rule in a small PR at once.

## Phases (Opus-suited work)

### Phase A: zone pages system (only zones Anton confirmed)
Data-driven pages `/zonas/<zona>/` (or the structure you justify in the PR): template + `app/content/zones/<slug>.php`. Each zone needs unique, true local content (access, soil/drainage behaviour, typical lots and projects), its own FAQ and WhatsApp messages in `app/wa-messages.php`, links to 3+ services and 2+ guides, reverse links from those, schema (`Service` with `areaServed`), sitemap entry. Guard against thin/doorway pages: minimum 450 words of own copy per zone, no shared paragraphs beyond the template chrome, and a verify check that fails on near-duplicate text between zones (shingle overlap threshold you choose and document). If Anton gave no zones, do not build; write the template and leave it disabled.

### Phase B: `/obras/` portfolio engine (only with real projects)
A data file per project (`app/content/obras/<slug>.php`: location zone, type, scope by rubro, stages, photos with alt and caption, permission flag, dates). Renders the index and case pages, `ImageObject`/`CreativeWork` schema, internal links to the matching service and guide, WhatsApp messages. No project without `permission => true`. Real photos only, never generated images as proof; referential images keep the "Imagen referencial" label. Image pipeline per `higgsfield-image-pipeline` and `webimg-pipeline` (webp, srcset 480/960, alt text).

### Phase C: scope estimator without prices (`/presupuestador/`)
A small no-JS-required flow (progressive enhancement): work type, size band, terrain situation, finishing level, financing idea. Output is a checklist of what drives the budget for that case, the guides to read, and a pre-filled WhatsApp message (voseo) with the selections. It must never output a number, range, plazo or guarantee; add verify tests that scan the rendered output for digits followed by currency words (Gs, guaraníes, USD, dólares, m² price patterns) and for plazo patterns. Log `estimator_used` and `estimator_to_whatsapp` through the existing `t.php` whitelist (extend the whitelist deliberately).

### Phase D: content quality and cannibalization audit (needs keyword data)
`tools/content-audit.mjs` reading the audit JSON plus `docs/seo/obra-keyword-map.md`: pages targeting the same primary keyword, near-duplicate sections across pages (shingles), thin sections, titles that overlap. Output `docs/audit/content-audit.md` with concrete recommendations (merge, differentiate, redirect, rewrite). Replace guessed rows in the keyword map with real group IDs and PY volumes when the MCP or a CSV is available; decide `/credito/`, `/obras/`, NEW-x rows on the data. Propose at most 3 new URLs and at most 3 title changes (old -> new, group ID) and ask Anton in ONE short message; build only what he approves in chat.

### Phase E: URL evolution and redirect safety
`docs/seo/URL-POLICY.md` plus tooling: a single source of truth for redirects (`obra_legacy_redirects()`), a verify check that fails on redirect chains/loops and on any previously indexable URL that now returns 404 without a redirect (compare against the sitemap of the last release kept in `docs/audit/`), and a rule for renaming/merging pages. Include the decision record for any URL changes made in Phase D.

## Definition of done per phase
`tools/verify.sh` green, including `seo-check`, `events` and `check-wa`; no new PHP warnings; 390 and 1366 px pass `pw-check`; content passes the no-prices/no-plazos/no-guarantees scan; docs updated (LAUNCH-CHECKLIST ticks, IMPROVE-PLAN status, build report addendum with NOT RUN items); PR merged; after merge, live check if reachable.

## Final message to Anton
PR links, live result, what he must still do (server `config/local.php` with the VenderCRM key and `stats_token`, a VenderCRM test lead, real photos and permissions, reviews with source, Bing Webmaster sitemap submission, `node tools/indexnow.mjs` after deploys).
