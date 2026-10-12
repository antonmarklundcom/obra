# CLAUDE.md

obra.com.py: Spanish (Paraguay) brochure and lead site for construction services. Read this before changing anything.

## Stack and entry points
Vanilla PHP 8.1+, no build step, no database, no CI. Hosted on Hostinger shared hosting.
- `index.php` router + JSON-LD; `form.php` lead POST (303 redirects); `t.php` event beacon; `stats.php` private stats (POST token login); `sitemap.php` dynamic, served at /sitemap.xml; `router.php` local `php -S` only.
- `app/`: helpers, layout, pages, conversion, routes, form-state, events, crm, ratelimit. `config/site.php`, `lib/vendercrm-config.php`.

## Hard rules
1. The only WhatsApp number anywhere is 595992279599. Never write any other Paraguayan number, not even in tests, fixtures or docs. `tools/check-wa.mjs` must stay green.
2. WhatsApp texts live only in `app/wa-messages.php`, voseo Spanish (Paraguay). No prices, no guarantees, no fixed plazos in any public copy.
3. Keep every public URL, title, H1 and meta description exactly as they are (changes need an entry in `docs/audit/approved-changes.json`). `tools/seo-check.mjs` and `tools/seo-diff.mjs` must stay green.
4. Never commit `.env`, `config/local.php`, API keys, or anything under `storage/` except `.gitkeep` and `.htaccess`. Never test with real leads: local runs use `OBRA_LOCAL_CONFIG=0` and `OBRA_CRM_MOCK`.
5. No GitHub Actions, no CI, no git hooks. The gate is local: `bash tools/verify.sh` (full suite with Playwright before every PR; `--skip-pw` while iterating). Playwright uses the preinstalled Chromium; never run `playwright install` in cloud sessions. Live network tools need `NODE_USE_ENV_PROXY=1`.
6. No new runtime dependencies in the PHP app. Node dev dependencies only in `tools/`.
7. Keep existing escaping (`h()`, `obra_json()`), the CSP, and the 303 redirect flow of `form.php`.
8. Do not reformat files you are not changing.

## Run and verify locally
- Setup: `cd tools && npm ci --no-fund --no-audit`
- Serve: `OBRA_LOCAL_CONFIG=0 php -S 127.0.0.1:8080 router.php`
- Gate: `bash tools/verify.sh`; while iterating `bash tools/verify.sh --skip-pw`; Windows `tools/verify.ps1`.
- PHPStan: `tools/phpstan.phar` (gitignored; download command is in `tools/phpstan.neon`). verify runs it when present.

## Where content lives
- `app/content.php`: groups, terrain, financing, home FAQs; service order.
- `app/content/{services,sub,guides}`: one file per service, hub or guide; `sub/techos/` has one file per roofing page. There is no `app/content/hub/` any more.
- `'updated'` date rule: see `app/content/README.md` (bump it whenever a page's visible copy changes).
- WhatsApp texts: `app/wa-messages.php` only.

## Lead flow
Form (`obra_contact_form`, CSRF token, honeypot, timing, 5 posts/10 min per IP) -> `form.php` validation -> CRM (`app/crm.php`, VenderCRM `X-Api-Key`) -> email via `mail()` -> if the CRM is not ok, the payload is spooled to `storage/leads-pending/<idempotency_key>.json` -> `php tools/replay-leads.php` (weekly or Hostinger cron) re-sends and deletes on 2xx -> `/gracias/` receipt + WhatsApp handoff.

## Config
`.env.example` lists every variable and its precedence. Secrets live only on the server: `config/local.php` and `private/vendercrm.php` (outside the document root).

## Deploy
Zip with `node tools/package.mjs` (or `cd tools && npm run package`), upload to `public_html/`. Never ship a static `sitemap.xml`. `tools/replay-leads.php` must be present at `public_html/tools/` (the packager already includes it).

## Never commit
`.env*` (except `.env.example`), `config/local.php`, `private/`, `storage/*` (except `.gitkeep`/`.htaccess`), `tools/phpstan.phar`, `audit-shots/`, zips.

## Docs map
`docs/LAUNCH-CHECKLIST.md`, `docs/KNOWN-ISSUES.md`, `docs/VENDERCRM-CONFIGURATION.md`, `docs/reports/`, `docs/seo/`, `docs/archive/` (old agent prompts and plans, historical only).
