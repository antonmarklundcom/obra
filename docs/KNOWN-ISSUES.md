# Known issues

Minor, non-blocking items. One line each; newest at the bottom.

- Form rate limit (5 posts / 10 min per IP, `app/ratelimit.php`) can hit several real visitors behind one carrier NAT; their typed values are kept and the message asks them to resend. Raise the limit in `form.php` if `obra-crm`/lead volume shows it.
- `error=tiempo` is reused for a missing/expired CSRF token and for the rate limit, so the visitor sees the "too long / too fast" message in those cases too.
- `tools/replay-leads.php` is not in the deploy zip (tools/ is excluded); it has to be uploaded once to `public_html/tools/` (see `docs/LAUNCH-CHECKLIST.md`).
