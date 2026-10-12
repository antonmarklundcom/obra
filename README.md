# obra.com.py

Brochure and lead-generation site for construction services in Paraguay (Asunción y Gran Asunción): service hubs, specialty pages, guides, a quote form that feeds VenderCRM, and a WhatsApp handoff. Vanilla PHP, no database, no build step. Source of truth for the live site as of 2026-09-29 (verified against live).

## Prerequisites
PHP 8.1+ (with curl and mbstring) and Node 20+ (Node is only used for the dev tools in `tools/`).

## Run locally
```
cd tools && npm ci --no-fund --no-audit
cd .. && OBRA_LOCAL_CONFIG=0 php -S 127.0.0.1:8080 router.php
```
Open http://127.0.0.1:8080/. Use `OBRA_CRM_MOCK=success` (or any other value to simulate a failure) to test the form without touching the CRM.

## Verify
`bash tools/verify.sh` is the local quality gate (there is no CI): lint, routes, form matrix, WhatsApp check, SEO checks and Playwright. Use `bash tools/verify.sh --skip-pw` while iterating; on Windows use `tools/verify.ps1`.

## Deploy
`cd tools && npm run package` (or `node tools/package.mjs --out=<path>`) builds the zip from every git-tracked file, minus repo-only files. Upload its contents to `public_html/` on Hostinger.
Never upload a static `sitemap.xml` (it would shadow `sitemap.php`; the packager refuses to run if one exists).
`config/local.php` and `private/vendercrm.php` stay on the server only and are never packaged.

## Configuration
The site reads settings from server environment variables or `config/local.php`. `.env.example` lists every variable and its precedence. Never commit real values.

## Docs
- `CLAUDE.md`: rules and map for agents (read first).
- `app/content/README.md`: content layout and the `'updated'` date rule.
- `docs/LAUNCH-CHECKLIST.md`, `docs/KNOWN-ISSUES.md`, `docs/VENDERCRM-CONFIGURATION.md`.
- `docs/seo/`: site-structure docs (carpinteria, obra, arq), keyword lists, content spec and briefs, audits.
- `docs/reports/`: build and fix reports.
- `docs/archive/`: old agent prompts and plans, historical only.
