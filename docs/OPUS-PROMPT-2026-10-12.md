# Prompt for Opus 5.5 (copy everything below the line)

Delete any numbered task you do not want before pasting. Task numbers match `docs/reports/IMPROVEMENT-REPORT-2026-10-12.md`.

---

You are working in the repository `antonmarklundcom/obra` (obra.com.py), a vanilla PHP 8.1+ brochure site with no build step, no database and no CI. Read `docs/reports/IMPROVEMENT-REPORT-2026-10-12.md` first: it has the evidence and file locations for every task below. Then implement the tasks in the order given, in the PR groups given.

## Hard rules (never break these)

- The only WhatsApp number anywhere is `595992279599`. Never write any other Paraguayan number, not even in tests or docs. `tools/check-wa.mjs` must stay green.
- All WhatsApp texts live in `app/wa-messages.php`, in voseo Spanish (Paraguay). No prices, no guarantees, no fixed plazos anywhere in public copy.
- Keep every public URL, title, H1 and meta description exactly as they are unless a task says otherwise. `tools/seo-check.mjs` and `tools/seo-diff.mjs` must stay green.
- Never commit `.env`, `config/local.php`, API keys or anything under `storage/` except `.gitkeep` and the new `.htaccess`.
- Never add GitHub Actions or any CI. The quality gate is local: `bash tools/verify.sh` (use `--skip-pw` only while iterating; run the full suite with Playwright before each PR). Playwright uses the preinstalled Chromium; never run `playwright install`.
- No new dependencies in the PHP app. Node dev dependencies only in `tools/`.
- Keep all existing escaping (`h()`, `obra_json()`), the CSP, and the 303 redirect flow of `form.php`.
- Do not reformat files you are not changing. Task 24 is the only task allowed to reflow long lines.
- Work on branch `claude/improvements-2026-10-12`, one PR per group below, each PR green on `tools/verify.sh` before opening. Write commit messages in English, imperative mood. Do not merge; I will.

## Group A: small and safe (one PR)

1. **Fix the verify baseline.** Run `cd tools && npm ci && npm run audit` against a local `php -S` server (see how `verify.mjs` starts one), save the output over `docs/audit/audit-before.json`. Then change `tools/seo-diff.mjs` so a changed `robots.txt` is a warning, not a failure, unless a new `Disallow` line matches an indexable URL from the sitemap. Do this after task 23 so the new robots lines are in the baseline.

2. **Fix the LCP preload.** In `index.php` (the `$route['preload']` block) preload the image the page really renders: for `home`, `service` and `child` use `obra_service_image()` and `obra_reference_srcset()` from `app/conversion.php` with the same `sizes` as the `<img>` in `app/pages.php` and `app/conversion.php::obra_service_media()`. Update `obra_head()` in `app/layout.php` so the preload accepts a ready-made `srcset` string. Remove `obra_image_size()`/`obra_srcset()` from `app/layout.php` if nothing else uses them; if the home gallery still needs them, leave them and say so in the PR.

3. **Fix Service JSON-LD images.** In `index.php` use `obra_url($config, obra_service_image($slug[, $child]))` for the `image` of `Service` schemas. Leave the `image` key in content files alone (they are still used for alt text and the gallery) unless it is truly unused, in which case remove it and its `image_alt` sibling only where unused.

6. **Single source for the "small enquiry" lists.** Export the two arrays from `obra_is_small_enquiry()` in `app/conversion.php` as a function returning `['services' => [...], 'specialties' => [...]]`, render them as `data-small-services` and `data-small-specialties` (space-separated) on the `<form data-form>` in `app/layout.php::obra_contact_form()`, and read them in `assets/js/site.js` instead of the hard-coded arrays. Keep the PHP as the authority.

9. **Tighten CSP and add HSTS.** In `app/helpers.php::obra_security_headers()` remove `'unsafe-inline'` from `style-src`, add `upgrade-insecure-requests`, and send `Strict-Transport-Security: max-age=31536000; includeSubDomains` only when `$_SERVER['HTTPS']` is on. Move the inline `<style>` of `stats.php` into `assets/css/stats.css` and link it with `obra_asset()`. Verify with Playwright that no page logs a CSP violation in the console (`tools/pw-check.mjs` can collect console errors; extend it if needed).

10. **Harden `storage/`.** Add `storage/.htaccess` containing `Require all denied` and commit it. Keep the existing RewriteRule. Add `/storage/` and `/storage/events-2026-01.log` to the blocked-paths list in `tools/verify.mjs` (expect 404 from the PHP router; the Apache deny cannot be tested locally, say so in a comment).

20. **Use `npm ci`.** In `tools/verify.sh` and `tools/verify.ps1` replace `npm install` with `npm ci --no-fund --no-audit`.

22. **Repo hygiene.** Strip the UTF-8 BOM from `README.md`. Add `.editorconfig` (LF, final newline, 4 spaces for `*.php`, 2 spaces for `*.mjs`/`*.js`/`*.json`/`*.css`) and `.gitattributes` (`* text=auto eol=lf`, `*.webp binary`, `*.jpg binary`, `*.png binary`, `*.ps1 text eol=crlf`).

23. **robots.txt.** Add `Disallow: /t.php` and `Disallow: /stats.php`. Keep everything else.

## Group B: lead delivery and abuse (one PR, full verify suite with Playwright)

4. **Never lose a lead.** In `form.php::obra_crm_send()` capture `curl_error()` and the HTTP status and `error_log('obra-crm status=<n> curl=<msg>')` on failure (no names, phones or message text in the log). When the CRM result is not ok, write the full `$payload` as JSON to `storage/leads-pending/<idempotency_key>.json` (create the directory with 0700 if missing; failure to write must not change the user flow). Add `tools/replay-leads.php`, a CLI script that loads `config/site.php`, iterates the pending directory, re-POSTs each file with the same headers as `obra_crm_send()`, deletes the file on 2xx, and prints a one-line summary. Add a note to `docs/LAUNCH-CHECKLIST.md` on running it weekly (or from Hostinger cron: `php /home/<user>/public_html/tools/replay-leads.php`). Extend the form matrix in `tools/verify.mjs`: with `OBRA_CRM_MOCK=fail` a pending file must appear in the storage dir the test server uses (`OBRA_STORAGE` env is already supported by `app/events.php`; reuse it); with `OBRA_CRM_MOCK=success` none must.

7. **Rate limiting and origin check.** Create `app/ratelimit.php` with `obra_rate_limited(string $bucket, int $limit, int $windowSeconds): bool` that stores counters in `storage/ratelimit/` keyed by `hash('sha256', $ip . gmdate('Y-m-d') . $bucket)` (never the raw IP), one small file per key, pruned when older than the window. Use it in `t.php` (60 events / 10 min, respond 204 silently when limited) and in `form.php` (5 posts / 10 min, redirect back with `error=tiempo` when limited). In both, if the `Sec-Fetch-Site` header is present and not `same-origin` or `none`, reject (204 for `t.php`, 403 for `form.php`). Cap `storage/events-*.log` at 5 MB: stop appending when exceeded. Add tests to `verify.mjs`: 61 beacons in a row, the 61st must not add a line; a form POST with `Sec-Fetch-Site: cross-site` must get 403.

8. **CSRF token.** In `app/form-state.php::obra_form_session()` create `$_SESSION['obra_form']['csrf']` (32 hex chars) if missing and keep it across `obra_form_save()`. Render it as `<input type="hidden" name="csrf">` in `obra_contact_form()`. In `form.php`, right after the method check and `obra_form_session()`, require `hash_equals()` with the posted value; on mismatch redirect to the return path with `error=tiempo` (reuse the existing message). Update the form matrix in `verify.mjs` so every POST first GETs `/cotizar/` to obtain the cookie and the token from the HTML, and add one case that posts without the token and expects the redirect.

## Group C: SEO and configuration (one PR)

5. **Real `lastmod` dates.** Add `'updated' => 'YYYY-MM-DD'` to every service in `app/content.php` and every child page under `app/content/sub/`. Seed each value with `git log -1 --format=%cs -- <file>` (for services, the last commit that touched the service's block is hard to get; use the file date for all of them once, it is still better than the deploy date). In `sitemap.php` prefer `updated` for `service`, `child` and `guide` and fall back to the mtime logic only when the key is missing. Add a check to `tools/verify.mjs` that fails when any `service`/`child`/`guide` lacks `updated` or has a date in the future.

12. **Configurable locality.** Add `'locality' => obra_env('OBRA_LOCALITY', 'Asunción')` to `config/site.php` and to `.env.example`; use it in `index.php` for `addressLocality`.

13. **Partner deep links.** Add `tools/check-partners.mjs` that collects every `link` with a `path` from the content files, HEADs `url + path` for each live partner site, and writes `docs/partner-live-paths.json` as `{ "arq": ["/path/"], "carpinteria": [] }`. In `config/site.php` read that JSON (if present) into `partner_sites[*]['live_paths']`. Live network tools need `NODE_USE_ENV_PROXY=1` in cloud sessions. If no content entry uses `path` at all, instead delete the `path` branch from `obra_partner_note()` and the `live_paths` keys, and say which you did in the PR.

14. **Log retention.** In `stats.php`, before reading, delete `storage/events-*.log` files older than 13 months. Add a `?meses=12` option (default 1, max 13) that widens the window and the file list accordingly.

15. **Stats token out of the URL.** Replace `?token=` with a minimal POST form on `stats.php` (`<form method="post"><input type="password" name="token">`); on a valid token store `$_SESSION['obra_stats'] = time()` in the existing `obra_form` session (reuse `obra_form_session()`), valid for 1 hour. Send `Referrer-Policy: no-referrer` on that page. Keep the 404 for a wrong or missing token. Update the `events` step of `verify.mjs` to log in via POST.

18. **One `.env.example`.** Merge `vendercrm.env.example` into `.env.example`, add every `OBRA_*` variable `config/site.php` reads (including `OBRA_ADS_*`, `OBRA_STATS_TOKEN`, `OBRA_STORAGE`, `OBRA_LOCALITY`), add a comment block explaining precedence (environment > `private/vendercrm.php` > `config/local.php` > defaults), delete `vendercrm.env.example`, and update `docs/VENDERCRM-CONFIGURATION.md` and `README.md` references.

## Group D: maintainability (one PR, do last)

16. **`CLAUDE.md` and docs cleanup.** Write `CLAUDE.md` at the repo root (about 60 lines): stack and entry points, the hard rules above, how to run the site locally (`php -S 127.0.0.1:8080 router.php`), how to run `tools/verify.sh`, where content lives (`app/content/{guides,sub,hub}`, services in `app/content.php` or `app/content/services/` after task 17), where WhatsApp texts live, how deploy works (zip via `tools/package-*`), and what must never be committed. Move `docs/NEXT-WINDOW-PROMPT.md`, `docs/NEXT-WINDOW-PROMPT-OPUS.md`, `docs/NEXT-WINDOW-PROMPT-SONNET.md`, `docs/IMPROVE-PLAN.md` and `CLAUDE-CHANGES.md` to `docs/archive/` with `git mv` and fix any links to them. Rewrite `README.md` as a real quick start (prerequisites, run, verify, deploy, where docs are).

17. **Split services into one file each.** Move each entry of `services` in `app/content.php` to `app/content/services/<slug>.php` returning the array, and load them with `obra_load_content_dir('services', $order)` using the current key order as `$order`. Output must be identical: run `npm run audit` before and after and diff the JSON (only `generated_at`-style fields may differ).

19. **PHPStan.** Add `tools/phpstan.neon` (level 6; paths: `app`, `config`, `lib`, and the root `*.php` files; exclude `app/content`). In `tools/verify.mjs` add a step that runs `tools/phpstan.phar` if it exists (download instructions in a comment; add `tools/phpstan.phar` to `.gitignore`) and skips with a notice otherwise. Fix every level-6 finding in the app code without changing behaviour.

21. **Cross-platform packaging.** Port `tools/package-hostinger.ps1` to `tools/package.mjs` with the same exclusions and the same guard against a static `sitemap.xml`. Keep the PowerShell script but make it a thin wrapper, or delete it and update docs, your choice, state it in the PR.

24. **Reflow long template lines (optional).** Only in `app/layout.php`, `app/pages.php`, `app/conversion.php`, `app/home-conversion.php`: break lines longer than 200 characters at tag boundaries, without changing the emitted HTML except whitespace between tags. Prove it: run `npm run audit` before and after and diff; run the full verify suite.

## When you are done with each group

Post a short summary in the PR body: which task numbers are done, which you skipped and why, the output of `bash tools/verify.sh` (the PASS/FAIL lines), and anything you want me to decide. Do not merge.
