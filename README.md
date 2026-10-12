# obra.com.py

Stack: PHP (router.php, app/, config/; reads its settings from server environment variables or config/local.php; see .env.example for every variable and its precedence, never commit real values).

Source of truth for the live site as of 2026-09-29 (verified against live).

Planning and SEO: see docs/seo/ (site-structure docs for carpinteria, obra and arq incl. KWP term lists, arq master brief, audits).

## Deploy

`cd tools && npm run package` (or `node tools/package.mjs --out=<path>`) builds the zip from every git-tracked file, minus repo-only files. Upload its contents to `public_html/` on Hostinger.
Never upload a static `sitemap.xml` (it would shadow `sitemap.php`; the packager refuses to run if one exists).
`config/local.php` and `private/vendercrm.php` stay on the server only and are never packaged.
