# Content layout

- `app/content.php`: services, groups, terrain, financing and home FAQs.
- `app/content/hub/`: service files loaded from `content.php` (e.g. `techos.php`).
- `app/content/sub/<hub>.php` and `app/content/sub/techos/`: specialty pages.
- `app/content/guides/`: one guide per file.

Rules:
- Every service, specialty and guide page carries `'updated' => 'YYYY-MM-DD'` right after `'name'`.
- Bump it whenever the visible copy of that page changes. Sitemap `lastmod` and verify rely on it; verify fails on a missing or future date.
- No prices, no guarantees, no fixed plazos in copy.
- WhatsApp texts live only in `app/wa-messages.php`.
- Do not change URLs, titles, H1s or meta descriptions without an approved entry in `docs/audit/approved-changes.json`.
