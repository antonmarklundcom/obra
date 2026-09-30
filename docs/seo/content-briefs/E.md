# Content brief E: tinglados + muros + comerciales

Session 2, round 2. One Sonnet agent at medium effort owns this brief.

## Files you may edit (only these)
- `app/content/sub/tinglados.php`
- `app/content/sub/muros.php`
- `app/content/sub/comerciales.php`

## Read first
`docs/seo/CONTENT-SPEC.md` (template, voice, frozen fields, checks), then this brief. The reference page is `/piscinas/chicas/`.

## Hard rules (from the build prompt)
1. Only WhatsApp number anywhere: +595 992 279599. Never write another number.
2. You don't edit `app/wa-messages.php`; propose WA texts in your reply only if a page's angle changed.
3. obra = build and execution; arq.com.py = design and style terms; carpinteria.com.py = wood and aluminium products only. Pérgolas, decks, machimbre/techos de madera are obra's work. At most the one sibling note listed below per page.
4. One meaning group = one page or section. No brand or competitor phrases. Keyword rows below are the page's meaning group (PY volumes pending: keyword-library was not connected in session 1).
5. Frozen: URL/slug, name, title, description, summary, h1, image, image_alt, canonical, robots, schema. Word count and links-in only go up. Don't delete FAQs or related entries.
6. No prices, invented years, statistics, reviews, guarantees, team names, "mejor" or "garantizado". Natural Paraguayan Spanish with voseo.
7. No secrets, no GitHub Actions, no model names anywhere.

## Sibling cross-links
None of the arq/carpinteria target URLs could be confirmed live (HEAD 200) in session 1, so every `link` with a `path` renders as **plain text** until the director adds that path to `partner_sites[...]['live_paths']` in `config/site.php` after a HEAD 200 check from a machine that reaches the site. Keep the `link` entries exactly as listed; you may reword their `text` (keep the domain name in it).

## Pages
| Page | File / key | Keyword row | Own words now → target | FAQs now → target | Allowed sibling note | Notes |
|---|---|---|---|---|---|---|
| `/tinglados/galpones/` | `app/content/sub/tinglados.php` → `galpones` | K-35: galpones | 168 → 700–1,000 | 3 → 4–6 | none | B2B: depósitos, talleres, piso industrial, luces, canaletas, accesos para camiones. |
| `/tinglados/cocheras/` | `app/content/sub/tinglados.php` → `cocheras` | K-36: cocheras, techo para autos | 176 → 700–1,000 | 3 → 4–6 | none | Techos para autos: metálica vs hormigón, cubiertas, desagües, piso. |
| `/muros/portones/` | `app/content/sub/muros.php` → `portones` | K-38: portones (metalicos, de acceso) | 184 → 700–1,000 | 3 → 4–6 | carpinteria `/portones/` (text, already set) | Portones metálicos y accesos: pilares, rieles, automatización (obra civil), seguridad. Wood portones = carpinteria note. |
| `/comerciales/locales/` | `app/content/sub/comerciales.php` → `locales` | K-40: locales comerciales | 183 → 700–1,000 | 3 → 4–6 | none | Adecuación de locales: habilitación needs (say "consultá con tu municipio"), vidrieras, baños, instalaciones, working hours. |
| `/comerciales/oficinas/` | `app/content/sub/comerciales.php` → `oficinas` | K-41: oficinas, consultorios | 144 → 700–1,000 | 3 → 4–6 | none | The thinnest page: oficinas y consultorios, divisiones, cableado, climatización, obra con atención abierta. |

## Page notes
- Hubs `/tinglados/`, `/muros/`, `/comerciales/` are deepened by brief F.
- Suggested guide links: `/guias/costo-casa/`, `/guias/plazos/`, `/guias/permisos/`.

## Done when
- Every page above: 700–1,000 words of own copy (hubs: +250–450) and 4–6 FAQs per `php tools/content-words.php`, the v2 H2 outline, `related` includes at least one guide (specialties) or two services (guides).
- `php -l` clean; `node tools/seo-diff.mjs` OK against `docs/audit/audit-before.json` (see CONTENT-SPEC §7).
- Reply: per page, words before → after, FAQs, the related paths you added, and any proposed WA text changes.
