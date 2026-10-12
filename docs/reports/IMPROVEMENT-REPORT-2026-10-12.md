# obra.com.py: improvement report (2026-10-12)

Scope: full read of the PHP app (`index.php`, `form.php`, `t.php`, `stats.php`, `sitemap.php`, `app/*`, `config/*`, `lib/*`), `.htaccess`, `assets/js/site.js`, the `tools/` quality gate and the docs tree, plus one run of `node tools/verify.mjs --skip-pw` on `main` (commit `80fa1e0`).

Overall the site is in good shape: clean routing, escaped output everywhere, a real CSP, a server-side form flow with receipts, and an unusually thorough local verify suite. The items below are the things that are wrong, drifting, or missing. They are grouped by priority. Each has the evidence and the suggested fix so they can be picked individually.

Legend: **P1** = fix now (bug or lost leads/SEO), **P2** = worth doing this month, **P3** = hygiene.

---

## P1: bugs and lost value

### 1. The verify suite is red on `main`
`node tools/verify.mjs --skip-pw` fails at `seo-diff` with `robots.txt changed`. The baseline `docs/audit/audit-before.json` predates the current `robots.txt`. Every future run will keep failing on this line, which trains people to ignore the gate.
**Fix:** regenerate the baseline (`npm run audit` and copy the JSON over `docs/audit/audit-before.json`), or teach `seo-diff.mjs` that robots.txt differences are reported but not fatal unless `Disallow` lines for indexable pages were added.

### 2. LCP preload points at the wrong image on home and every service page
`index.php:103-105` preloads `/assets/images/hero-casa.webp` (home) or `$service['image']` (always `hero-casa.webp`, see `app/content.php`, 6 services share it). But the rendered hero is `obra_service_image()` → `/assets/images/reference/<slug>-960.webp` (`app/conversion.php:45-58`, `app/pages.php:107`). Result: every page downloads a 210 KB image it never shows, and the real LCP image gets no priority hint.
**Fix:** build `$route['preload']` from `obra_service_image()`/`obra_reference_srcset()` with the same `sizes` as the `<img>`. Then `obra_image_size()` and `obra_srcset()` in `app/layout.php` become dead for the hero path; keep them only for the home gallery or remove.

### 3. Service JSON-LD `image` is the same photo on all 13 services
`index.php:77,82` emits `'image' => '/assets/images/' . $service['image']` which is `hero-casa.webp` for most services and never the reference image the user sees.
**Fix:** use `obra_url($config, obra_service_image($slug, $child))` and drop the `image` key from content (or keep it only as an override).

### 4. Leads can silently never reach the CRM
In `form.php:103-104`, when the CRM POST fails but `mail()` succeeds, state becomes `enviado`, the user sees "Recibimos tu consulta", and nothing retries the CRM. The CRM HTTP status and curl error are discarded (`form.php:40`), so there is no trace in the server log either.
**Fix:** (a) `error_log('obra-crm status=… curl=…')` without PII; (b) on failure write the payload JSON to `storage/leads-pending/<idempotency_key>.json` (the key already exists for safe replay); (c) add `tools/replay-leads.php` (CLI) that re-POSTs pending files and deletes them on 2xx. Document a weekly manual run or a Hostinger cron.

### 5. Sitemap `lastmod` is wrong after every deploy
`sitemap.php:17-24` derives `lastmod` from `filemtime()` of `app/content.php`, `app/pages.php`, etc. Deploying from a zip resets mtimes, so all 74 URLs claim they changed on deploy day. Google learns to ignore `lastmod` from this site. Guides already carry an explicit `updated` date; services and children do not.
**Fix:** add `'updated' => 'YYYY-MM-DD'` to every service and child page and use it; fall back to a `docs/lastmod.json` generated from `git log -1 --format=%cs -- <file>` during packaging instead of runtime mtimes. Add a verify check that no `lastmod` equals today unless the content file changed in git.

### 6. Duplicated "small enquiry" rule in PHP and JS
`app/conversion.php:39-43` and `assets/js/site.js:126` hard-code the same two slug lists. The next person adding a service updates one and not the other, and the form's required fields diverge between client and server.
**Fix:** render the lists from PHP as `data-small-services` / `data-small-specialties` attributes on the `<form>` and read them in JS.

---

## P2: robustness, security, SEO

### 7. No rate limiting or origin check on `t.php` and `form.php`
`t.php` appends a line to `storage/events-*.log` for any POST with a plausible body; a script can grow the log without limit and skew `stats.php`. `form.php` has honeypot and timing only.
**Fix:** reject when `Sec-Fetch-Site` is present and not `same-origin`; add a tiny file-based bucket keyed by `hash(ip + daily salt)` (no raw IP stored) allowing e.g. 60 events and 5 form posts per 10 minutes; cap the events file at a few MB.

### 8. Session-based CSRF token for the form
The session already exists for form state (`app/form-state.php`). A cross-site POST will not carry the `SameSite=Lax` cookie, but the handler does not require it, so third-party sites can submit spam leads straight into the CRM.
**Fix:** put a random token in `$_SESSION['obra_form']['csrf']`, render it as a hidden field, and require `hash_equals` in `form.php` before any other validation.

### 9. CSP still allows `'unsafe-inline'` styles
`app/helpers.php:171` sets `style-src 'self' 'unsafe-inline'`. A grep shows no `style="` attributes and no inline `<style>` in `app/` or `index.php`; only `stats.php` has an inline `<style>`.
**Fix:** drop `'unsafe-inline'`; move the stats stylesheet into `assets/css/stats.css`. Also add `Strict-Transport-Security: max-age=31536000; includeSubDomains` when `HTTPS` is on, and `upgrade-insecure-requests`.

### 10. `storage/` is protected only by mod_rewrite
`.htaccess` returns 404 for `storage/` via a RewriteRule. If mod_rewrite is off or the rule is edited, the event logs (and the proposed lead spool) become downloadable.
**Fix:** add `storage/.htaccess` with `Require all denied` (committed, next to `.gitkeep`) and extend the root `FilesMatch` deny to `\.log$` and `\.json$` under storage.

### 11. Transactional email will likely land in spam
`form.php:63` sends with `From: no-reply@obra.com.py` through PHP `mail()`. Unless the domain's SPF includes Hostinger's mail servers and DKIM is set up, Gmail marks it spam, and that is the only fallback channel when the CRM is down.
**Fix:** verify SPF/DKIM for obra.com.py on the Hostinger panel (or route through the Cloudflare email setup the group already uses) and document the check in `docs/LAUNCH-CHECKLIST.md`. Consider SMTP with auth instead of `mail()`.

### 12. Hard-coded `Asunción` and country in schema while `area` is configurable
`index.php:63` sets `addressLocality => 'Asunción'` regardless of `OBRA_AREA`.
**Fix:** add `OBRA_LOCALITY` (default `Asunción`) to `config/site.php` and use it.

### 13. Partner "live_paths" is always empty, so deep links never render
`config/site.php:40-41` and `app/pages.php:51-70`: any content `link` with a `path` degrades to plain text because `live_paths` is `[]`. Either the feature is unused or links are silently lost.
**Fix:** add `tools/check-partners.mjs` that HEADs the paths used in content and writes `docs/partner-live-paths.json`, which `config/site.php` reads. Or remove the `path` option and the dead branch.

### 14. The event log grows forever and `stats.php` only reads two months
`app/events.php` writes `events-YYYY-MM.log` with no cleanup.
**Fix:** on each `stats.php` view (or 1 % of `t.php` hits) delete files older than 13 months; add a 12-month view option to `stats.php` so the retained data is useful.

### 15. Stats token travels in the URL
`stats.php:10` reads `?token=`. The token ends up in browser history, Hostinger access logs and any referrer.
**Fix:** accept the token from a POST form (a tiny login page) and keep it in the existing session for 1 hour; send `Referrer-Policy: no-referrer` on that page.

---

## P3: maintainability and repo hygiene

### 16. No `CLAUDE.md`; the agent instructions are spread over 4 stale docs
There is no `CLAUDE.md`/`AGENTS.md`. The rules that matter (one WhatsApp number, voseo, no prices or plazos, messages only in `app/wa-messages.php`, run `tools/verify`) live in `docs/NEXT-WINDOW-PROMPT.md`, `-OPUS.md`, `-SONNET.md`, `docs/IMPROVE-PLAN.md` (35 KB, 2026-09-30) and `CLAUDE-CHANGES.md` (2026-09-01). An agent starting fresh reads none of them.
**Fix:** write a 60-line `CLAUDE.md` (stack, hard rules, how to run verify, where content lives, deploy notes). Move the three NEXT-WINDOW prompts, `CLAUDE-CHANGES.md` and `IMPROVE-PLAN.md` to `docs/archive/`. Expand `README.md` to a real quick start.

### 17. `app/content.php` is a 54 KB single file while children and guides are split
Services (13 entries) are inline in `app/content.php`; children and guides already use `obra_load_content_dir()`. Agents editing two services at once conflict in one file.
**Fix:** move each service to `app/content/services/<slug>.php`, loaded with the existing helper and the existing order array. Keep `groups`, `terrain`, `financing`, `home_faqs` in `content.php`.

### 18. Two `.env.example` files with different variable names
`.env.example` uses `VENDERCRM_URL` while `config/site.php` also reads legacy `OBRA_CRM_ENDPOINT`/`OBRA_CRM_API_KEY`, and `vendercrm.env.example` repeats the pair. `config/local.example.php` documents a third path.
**Fix:** one `.env.example` with every variable and a comment on precedence (env > `private/vendercrm.php` > `config/local.php`), delete `vendercrm.env.example`, and point `docs/VENDERCRM-CONFIGURATION.md` at it.

### 19. No static analysis for PHP
Only `php -l` runs. Typed code with `declare(strict_types=1)` everywhere would benefit from PHPStan.
**Fix:** add `tools/phpstan.neon` (level 6, paths `app`, `config`, `lib`, root `*.php`) and run `phpstan.phar` from `verify.mjs` when present (download once into `tools/`, gitignored). No CI needed; this is the local gate.

### 20. `tools/verify.sh` uses `npm install` instead of `npm ci`
`package-lock.json` is committed but `verify.sh:5` runs `npm install`, which can drift the lockfile. `verify.ps1` does the same.
**Fix:** `npm ci --no-fund --no-audit` in both scripts.

### 21. Packaging is Windows-only
`tools/package-hostinger.ps1` is the only deploy packager, so a cloud or macOS session cannot produce the zip.
**Fix:** port it to `tools/package.mjs` (Node, cross-platform), keep the same exclusions (docs, tools, storage logs, .env, config/local.php) and the static `sitemap.xml` guard, and have `verify.mjs` optionally run it.

### 22. Repo hygiene: BOM, editorconfig, gitattributes
`README.md` starts with a UTF-8 BOM. There is no `.editorconfig` or `.gitattributes`, so Windows and Linux sessions can flip line endings and `.webp` files have no `binary` marker.
**Fix:** strip the BOM, add `.editorconfig` (LF, 4 spaces for PHP, 2 for JS), add `.gitattributes` (`* text=auto eol=lf`, `*.webp *.jpg *.png binary`).

### 23. `robots.txt` does not list the private endpoints
`stats.php` and `t.php` are reachable; `stats.php` sends `X-Robots-Tag` but `t.php` returns 405 with no robots hint, and neither is in `robots.txt`.
**Fix:** add `Disallow: /t.php` and `Disallow: /stats.php` (and update the seo-diff baseline, see item 1).

### 24. 1000+ character single-line templates in `app/pages.php` and `app/layout.php`
Lines such as `app/layout.php:111` and `app/pages.php:82` are one physical line of mixed PHP and HTML. Diffs are unreadable and reviews miss changes.
**Fix (optional, do last):** reflow the long template lines across multiple lines without changing output; confirm with `tools/audit.mjs` before/after that the HTML is byte-identical except whitespace between tags.

---

## Suggested order
1, 2, 3, 6, 9, 10, 20, 22 are small and safe: one PR.
4, 7, 8 touch the form path: one PR, run the full verify suite including Playwright.
5, 11, 12, 13, 14, 15, 23: one PR each or grouped by SEO vs. security.
16, 17, 18, 19, 21, 24: maintainability PR, can wait.
