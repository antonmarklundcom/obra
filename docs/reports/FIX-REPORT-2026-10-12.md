# obra.com.py: fix report (2026-10-12)

Source: docs/reports/IMPROVEMENT-REPORT-2026-10-12.md (branch claude/ecstatic-cerf-9xswds). Four PRs, all squash-merged with `tools/verify.sh` fully green (Playwright included):
A https://github.com/antonmarklundcom/obra/pull/24 · B https://github.com/antonmarklundcom/obra/pull/25 · C https://github.com/antonmarklundcom/obra/pull/26 · D https://github.com/antonmarklundcom/obra/pull/27

| # | Status | Note |
|---|---|---|
| 1 | done | Baseline regenerated into docs/audit/audit-before.json (verify now uses it); robots.txt change = warning unless a new Disallow hits an indexable URL. |
| 2 | done | LCP preload = hero reference image (same srcset/sizes); Playwright asserts preload == hero currentSrc. |
| 3 | done | Service JSON-LD image = page's reference photo; unused content `image`/`image_alt` removed. |
| 4 | done | CRM failures logged without PII and spooled to storage/leads-pending/; CLI tools/replay-leads.php. |
| 5 | done | `updated` on all 67 service/specialty/guide pages; sitemap uses it; verify fails on missing/future dates. |
| 6 | done | Small-enquiry lists come from PHP via data-small-* on the form. |
| 7 | done | Hashed per-IP limits (t.php 60/10 min, form 5/10 min), Sec-Fetch-Site check, 5 MB log cap. |
| 8 | done | Session CSRF token required by form.php. |
| 9 | done | CSP without 'unsafe-inline' styles + upgrade-insecure-requests; HSTS on HTTPS; stats CSS external. |
| 10 | done | storage/.htaccess deny; router and verify block /storage/. |
| 11 | parked | Needs a human: SPF/DKIM for no-reply@obra.com.py in the Hostinger/DNS panel (cannot be done from the repo). |
| 12 | done | OBRA_LOCALITY (default Asunción) for addressLocality. |
| 13 | done | tools/check-partners.mjs → config/partner-live-paths.json; 4 carpinteria deep links live, arq paths still 404/301. |
| 14 | done | stats.php deletes logs older than 13 months; ?meses=1..13. |
| 15 | done | stats.php POST token login, 1-hour session, no-referrer. |
| 16 | done | CLAUDE.md, README quick start, old prompts/plans in docs/archive/. |
| 17 | done | Services split into app/content/services/; audit JSON identical. |
| 18 | done | One .env.example with all variables and precedence. |
| 19 | done | PHPStan level 6 clean; verify runs it when tools/phpstan.phar exists. |
| 20 | done | npm ci in verify.sh/verify.ps1. |
| 21 | done | Cross-platform tools/package.mjs (old .ps1 whitelist was stale and missed current files). |
| 22 | done | README BOM removed; .editorconfig, .gitattributes. |
| 23 | done | robots.txt disallows /t.php and /stats.php. |
| 24 | done | Long template lines reflowed with byte-identical HTML on 78 pages; 52 raw-HTML lines remain (KNOWN-ISSUES). |

Final `bash tools/verify.sh` on main (bdaf57b):
PASS php -l (73) · content dates (67) · phpstan · reference-images · routes (74 URLs, 14 301s) · form matrix (27) · events · check-wa · audit · seo-check · seo-diff · pw-check (153 runs) → VERIFY GREEN

Needs a human:
- Task 11: check SPF/DKIM for `no-reply@obra.com.py` (or switch mail to authenticated SMTP); email is the fallback when the CRM is down.
- Hostinger cron (weekly) for `php ~/public_html/tools/replay-leads.php`, see docs/LAUNCH-CHECKLIST.md; deploy with the new zip so tools/replay-leads.php and the new app files arrive.
- Set `locality` in config/local.php (or OBRA_LOCALITY) if the legal address is not in Asunción.
- Re-login to /stats.php via its form (the old ?token= links no longer work).
