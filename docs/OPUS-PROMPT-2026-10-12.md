# Prompt for an Opus 5.5 (high) window on this repo

Paste everything below the line into a fresh Claude Code window on `antonmarklundcom/obra`, model Opus 5.5, effort high, permission mode auto-accept (subagents inherit it). Delete any task number you do not want first. Task numbers match `docs/reports/IMPROVEMENT-REPORT-2026-10-12.md`.

---

You are fixing the repository `antonmarklundcom/obra` (obra.com.py): a vanilla PHP 8.1+ brochure site, no build step, no database, no CI, deployed as a zip to Hostinger shared hosting. Work autonomously until every task below is merged or explicitly parked. Do not ask me questions in chat; I am not watching.

## Read first
- `docs/reports/IMPROVEMENT-REPORT-2026-10-12.md` (evidence, file:line, and the fix for each task). If it is not on `main`, read it with `git show origin/claude/ecstatic-cerf-9xswds:docs/reports/IMPROVEMENT-REPORT-2026-10-12.md`.
- `index.php`, `form.php`, `t.php`, `stats.php`, `sitemap.php`, `app/helpers.php`, `app/layout.php`, `app/conversion.php`, `app/form-state.php`, `app/events.php`, `config/site.php`, `.htaccess`, `assets/js/site.js`, `tools/verify.mjs`. Skim the rest only when a task needs it.
- `docs/NEXT-WINDOW-PROMPT.md` HARD RULES section (the rules below repeat the ones that matter).

## Hard rules (never break)
1. The only WhatsApp number anywhere is `595992279599`. Never write any other Paraguayan number, not even in tests, fixtures or docs. `tools/check-wa.mjs` must stay green.
2. WhatsApp texts live only in `app/wa-messages.php`, voseo Spanish (Paraguay). No prices, no guarantees, no fixed plazos in any public copy.
3. Keep every public URL, title, H1 and meta description exactly as they are. `tools/seo-check.mjs` and `tools/seo-diff.mjs` must stay green after the baseline refresh in task 1.
4. Never commit `.env`, `config/local.php`, API keys, or anything under `storage/` except `.gitkeep` and the new `storage/.htaccess`. Never test with real leads: local runs use `OBRA_LOCAL_CONFIG=0` and `OBRA_CRM_MOCK`.
5. No GitHub Actions, no CI, no git hooks. The gate is local: `bash tools/verify.sh` (full suite with Playwright before every PR; `--skip-pw` only while iterating). Playwright uses the preinstalled Chromium; never run `playwright install`. Live network tools need `NODE_USE_ENV_PROXY=1`.
6. No new runtime dependencies in the PHP app. Node dev dependencies only in `tools/`.
7. Keep existing escaping (`h()`, `obra_json()`), the CSP, and the 303 redirect flow of `form.php`.
8. Do not reformat files you are not changing. Task 24 is the only task allowed to reflow lines.
9. Models: you are Opus. Subagents are Sonnet 5.5 only. Never spawn Fable, never spawn another Opus, never create Routines or new sessions.

## Workflow
- Branch per group off latest `main`: `fix/a-small-safe`, `fix/b-lead-delivery`, `fix/c-seo-config`, `fix/d-maintainability`. Finish group A, open its PR, merge it when `tools/verify.sh` is fully green, then branch group B from the new `main`, and so on. One PR per group, squash-merge. If a PR cannot go green within two fix rounds, push what is green, leave the PR open with a comment stating exactly what fails and why, and continue with the next group from `main`.
- WIP commits at least every 30 minutes. English, imperative commit messages. PR body ≤ 25 lines: tasks done, tasks skipped and why, the PASS/FAIL lines of the final `tools/verify.sh` run.
- Setup once: `cd tools && npm ci --no-fund --no-audit && cd ..`. Local server: `php -S 127.0.0.1:8080 router.php` with `OBRA_LOCAL_CONFIG=0`.
- Before opening each PR, re-run the full verify suite on the branch after merging `main` into it, and re-read your own diff once adversarially. Fix findings in one follow-up commit; no second polish round.
- Minor non-blocking issues go to `docs/KNOWN-ISSUES.md` (create it), one line each. Decisions you had to make go to the PR body. Nothing is "parked for Anton" unless it is a credential or a business decision.

## Sonnet subagents
Use the Agent tool with model `sonnet` for mechanical, parallel, disjoint-file work only. Each subagent gets: the task text below, the exact files it owns, the hard rules 1 to 4 and 8, and the instruction to run `php -l` on every file it touches and to report the list of files changed. Subagents never touch `form.php`, `app/helpers.php`, `app/layout.php`, `.htaccess`, `tools/verify.mjs`, or anything outside their Owns list. You (Opus) do the form path, the security headers, the verify-suite changes, every merge, and the review of every subagent diff before you commit it. Run at most 4 subagents at once. The tasks marked "Sonnet" below are the ones to delegate; the others you do yourself.

## Group A: small and safe (branch `fix/a-small-safe`)

**23. robots.txt.** Add `Disallow: /t.php` and `Disallow: /stats.php`. Do this before task 1.

**1. Fix the verify baseline.** Start a local server, run `npm run audit` (see how `verify.mjs` calls `tools/audit.mjs`) and save the output over `docs/audit/audit-before.json`. Then change `tools/seo-diff.mjs` so a changed `robots.txt` is a warning, not a failure, unless a new `Disallow` line matches an indexable sitemap URL. `tools/verify.sh --skip-pw` must be green on the branch after this.

**2. Fix the LCP preload.** In `index.php` (the `$route['preload']` block) preload the image the page really renders: for `home`, `service` and `child` use `obra_service_image()` and `obra_reference_srcset()` from `app/conversion.php`, with the same `sizes` as the `<img>` in `app/pages.php:107` and `obra_service_media()`. Let `obra_head()` in `app/layout.php` accept a ready-made `srcset` string. If `obra_image_size()`/`obra_srcset()` in `app/layout.php` end up unused, delete them. Verify with Playwright that the preloaded URL equals the hero `<img currentSrc>` on `/`, `/casas/` and `/techos/goteras/` at 1280 px wide; add that check to `tools/pw-check.mjs`.

**3. Fix Service JSON-LD images.** In `index.php` use `obra_url($config, obra_service_image($slug[, $child]))` for the `image` of `Service` schemas. Leave the content `image` keys alone unless nothing reads them anymore; if so remove them together with their `image_alt` only where unused, and say so in the PR.

**6. Single source for the "small enquiry" lists.** Export the two arrays in `obra_is_small_enquiry()` (`app/conversion.php`) through a function returning `['services' => [...], 'specialties' => [...]]`. Render them as `data-small-services` and `data-small-specialties` (space-separated) on `<form data-form>` in `obra_contact_form()` (`app/layout.php`), and read them in `assets/js/site.js` instead of the hard-coded arrays. PHP stays the authority; the server validation is unchanged.

**9. Tighten CSP and add HSTS.** In `obra_security_headers()` (`app/helpers.php`) remove `'unsafe-inline'` from `style-src`, add `upgrade-insecure-requests`, and send `Strict-Transport-Security: max-age=31536000; includeSubDomains` only when `$_SERVER['HTTPS']` is `on`. Move the inline `<style>` of `stats.php` to `assets/css/stats.css` linked with `obra_asset()`. Extend `tools/pw-check.mjs` to fail on any console message containing `Content Security Policy` on the pages it visits.

**10. Harden `storage/`.** Commit `storage/.htaccess` with `Require all denied`. Keep the RewriteRule. Add `/storage/` and `/storage/events-2026-01.log` to the blocked-path list in `tools/verify.mjs` (the router returns 404; note in a comment that the Apache deny itself cannot be tested locally).

**20. `npm ci`.** In `tools/verify.sh` and `tools/verify.ps1` replace `npm install` with `npm ci --no-fund --no-audit`.

**22. Repo hygiene (Sonnet).** Owns: `README.md` (BOM only), `.editorconfig`, `.gitattributes`. Strip the UTF-8 BOM from `README.md`. Add `.editorconfig` (LF, final newline, trim trailing whitespace, 4 spaces for `*.php`, 2 spaces for `*.mjs`, `*.js`, `*.json`, `*.css`, `*.md`) and `.gitattributes` (`* text=auto eol=lf`, `*.webp binary`, `*.jpg binary`, `*.png binary`, `*.ps1 text eol=crlf`). Confirm `git status` shows no mass line-ending churn afterwards; if it does, fix the attributes, never renormalize the tree.

## Group B: lead delivery and abuse (branch `fix/b-lead-delivery`)

Opus only. Run the full verify suite with Playwright before the PR.

**4. Never lose a lead.** In `form.php::obra_crm_send()` capture `curl_error()` and the HTTP status; on failure `error_log('obra-crm status=<n> curl=<msg>')` with no names, phones or message text. When the result is not ok, write `$payload` as JSON to `storage/leads-pending/<idempotency_key>.json` (directory under `obra_storage_dir()`, create with 0700, never let a write failure change the user flow). Add `tools/replay-leads.php`: a CLI script that refuses to run under a web SAPI, loads `config/site.php`, iterates the pending directory, re-POSTs each file with the same headers as `obra_crm_send()`, deletes the file on 2xx, keeps it otherwise, and prints one summary line. Add a short section to `docs/LAUNCH-CHECKLIST.md` on running it weekly or from Hostinger cron. Tests in `verify.mjs`: with `OBRA_CRM_MOCK=fail` one pending file must appear in the test server's `OBRA_STORAGE` directory (set it to a temp dir per server; `app/events.php` already reads it); with `OBRA_CRM_MOCK=success` none; and running `php tools/replay-leads.php` with `OBRA_CRM_MOCK=success` against that directory must delete the file.

**7. Rate limiting and origin check.** Create `app/ratelimit.php` with `obra_rate_limited(string $bucket, int $limit, int $windowSeconds): bool`. Counters live in `<storage>/ratelimit/` as one small file per key, key = `hash('sha256', $ip . gmdate('Y-m-d') . $bucket)` (never the raw IP), files older than the window pruned on the fly. Use it in `t.php` (60 events per 10 minutes, respond 204 silently when limited) and `form.php` (5 posts per 10 minutes, redirect back with `error=tiempo`). In both, if the `Sec-Fetch-Site` header is present and is neither `same-origin` nor `none`, reject: 204 for `t.php`, 403 for `form.php`. Cap each `storage/events-*.log` at 5 MB: stop appending beyond it. Tests in `verify.mjs`: 61 beacons in a row, line count must stop at 60; a form POST with `Sec-Fetch-Site: cross-site` must get 403; the existing form matrix must still pass (give each test server its own `OBRA_STORAGE` temp dir so limits do not leak between cases).

**8. CSRF token.** In `obra_form_session()` (`app/form-state.php`) create `$_SESSION['obra_form']['csrf']` (32 hex chars) if missing and preserve it across `obra_form_save()`. Render `<input type="hidden" name="csrf">` in `obra_contact_form()`. In `form.php`, right after the method check and `obra_form_session()`, require `hash_equals()` with the posted value; on mismatch redirect to the return path with `error=tiempo`. Update the form matrix in `verify.mjs` so every POST first GETs `/cotizar/` to obtain the cookie and the token from the HTML, and add one case that posts without the token and expects the redirect. Keep the honeypot and the timing check.

## Group C: SEO and configuration (branch `fix/c-seo-config`)

**5. Real `lastmod` dates.** Sonnet subagents, split by directory: one owns `app/content/sub/**`, one owns `app/content/guides/**` plus `app/content/hub/**`, one owns the `services` block of `app/content.php`. Each adds `'updated' => 'YYYY-MM-DD'` right after `'name'` in every page array that lacks it, using `git log -1 --format=%cs -- <file>` for the file (services all get the `app/content.php` date). Opus then changes `sitemap.php` to prefer `updated` for `service`, `child` and `guide` and fall back to the mtime logic only when the key is missing, and adds a verify step that fails when any `service`, `child` or `guide` lacks `updated` or has a future date. Also add `app/content/README.md` (Sonnet, 15 lines) stating that `updated` must be bumped when copy changes.

**12. Configurable locality.** Add `'locality' => obra_env('OBRA_LOCALITY', 'Asunción')` to `config/site.php` and `.env.example`; use it for `addressLocality` in `index.php`.

**13. Partner deep links.** First grep the content files for `'path' =>` inside `link` arrays. If none exist, delete the `path` branch from `obra_partner_note()` (`app/pages.php`) and the `live_paths` keys in `config/site.php`, and state that in the PR. If some exist, add `tools/check-partners.mjs` that HEADs `url + path` for each live partner site (`NODE_USE_ENV_PROXY=1`) and writes `docs/partner-live-paths.json`, and make `config/site.php` read that file into `live_paths` when present.

**14. Log retention.** In `stats.php`, before reading, delete `events-*.log` files older than 13 months. Add `?meses=N` (default 1, max 13) that widens the window and the file list.

**15. Stats token out of the URL.** Replace `?token=` with a minimal POST form on `stats.php` (`<input type="password" name="token">`). A valid token stores `$_SESSION['obra_stats'] = time()` in the existing session (reuse `obra_form_session()`), valid for 1 hour. Send `Referrer-Policy: no-referrer` on that page. Keep the 404 for a wrong or missing token and for GET without a session. Update the `events` step of `verify.mjs` to log in via POST with the cookie.

**18. One `.env.example` (Sonnet).** Owns: `.env.example`, `vendercrm.env.example` (delete), `docs/VENDERCRM-CONFIGURATION.md`, `README.md` (the env paragraph only). Merge the two example files into one `.env.example` listing every variable `config/site.php` reads (`OBRA_*` including `OBRA_ADS_*`, `OBRA_STATS_TOKEN`, `OBRA_STORAGE`, `OBRA_LOCALITY`, and `VENDERCRM_URL`, `VENDERCRM_API_KEY`, `VENDERCRM_CONFIG_FILE`) with a comment block on precedence: environment > `private/vendercrm.php` > `config/local.php` > defaults. Fix every reference to the deleted file.

## Group D: maintainability (branch `fix/d-maintainability`)

**17. Split services into one file each (Sonnet, one subagent).** Owns: `app/content.php`, `app/content/services/**`. Move each entry of `services` to `app/content/services/<slug>.php` returning the array, and load them with `obra_load_content_dir('services', $order)` where `$order` is the current key order. Opus verifies: run `npm run audit` on `main` and on the branch and diff the JSON; only timestamp-like fields may differ.

**16. `CLAUDE.md` and docs cleanup (Sonnet, one subagent, after 17 is committed).** Owns: `CLAUDE.md`, `README.md`, `docs/archive/**`, and `git mv` of `docs/NEXT-WINDOW-PROMPT.md`, `docs/NEXT-WINDOW-PROMPT-OPUS.md`, `docs/NEXT-WINDOW-PROMPT-SONNET.md`, `docs/IMPROVE-PLAN.md`, `CLAUDE-CHANGES.md` into `docs/archive/`. `CLAUDE.md` is about 60 lines: stack and entry points; the hard rules 1 to 8 above; local run and verify commands; where content lives (`app/content/{services,sub,guides,hub}`), where WhatsApp texts live, how the lead flow works (form → CRM → mail → pending spool → `tools/replay-leads.php`); deploy by zip via `tools/package.mjs`; what must never be committed. Rewrite `README.md` as a real quick start (prerequisites, run, verify, deploy, docs map). Fix every link that pointed at a moved file.

**19. PHPStan.** Opus. Add `tools/phpstan.neon` (level 6; paths `app`, `config`, `lib` and the root `*.php` files; exclude `app/content`). Download `phpstan.phar` into `tools/` (gitignore it; put the download command in a comment in `verify.mjs`). Add a verify step that runs it when present and prints a notice when absent. Fix every level-6 finding without changing behaviour; if a finding needs a behaviour change, add a one-line `docs/KNOWN-ISSUES.md` entry and a `@phpstan-ignore` with the reason instead.

**21. Cross-platform packaging (Sonnet).** Owns: `tools/package.mjs`, `tools/package-hostinger.ps1`, `tools/package.json` (scripts only), the deploy paragraph of `README.md`. Port the PowerShell packager to Node with the same exclusions (`docs`, `tools`, `storage/*.log`, `storage/leads-pending`, `storage/ratelimit`, `.env*`, `config/local.php`, `node_modules`, `.git`) and the same guard that fails if a static `sitemap.xml` exists. Keep the PowerShell file as a two-line wrapper that calls `node package.mjs`. Add `"package": "node package.mjs"` to `tools/package.json`.

**24. Reflow long template lines (Sonnet, one subagent per file, run last).** Owns, one file each: `app/layout.php`, `app/pages.php`, `app/conversion.php`, `app/home-conversion.php`. Break lines longer than 200 characters at tag boundaries only, inside PHP template output, without changing the emitted HTML except whitespace between tags. Never move PHP logic, never change attribute order. Opus proves it: `npm run audit` before and after, diff the JSON, then the full verify suite. If the diff shows any non-whitespace change, revert that file and log it in `docs/KNOWN-ISSUES.md`.

## Closing report
When the last group is merged (or parked), write `docs/reports/FIX-REPORT-2026-10-12.md` (≤ 40 lines): per task, done / skipped / parked with one line why; the four PR links; the final `tools/verify.sh` output on `main`; anything that needs a human (SPF/DKIM check for `no-reply@obra.com.py`, task 11; the Hostinger cron for `replay-leads.php`; a `config/local.php` field for `OBRA_LOCALITY` if the area is not Asunción). Commit it to `main` in a final small PR, merge, and stop.
