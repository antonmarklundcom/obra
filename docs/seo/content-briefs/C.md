# Content brief C: quinchos + patios (obra-owned wood)

Session 2, round 2. One Sonnet agent at medium effort owns this brief.

## Files you may edit (only these)
- `app/content/sub/quinchos.php`
- `app/content/sub/patios.php`

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
| `/quinchos/cerrados/` | `app/content/sub/quinchos.php` → `cerrados` | K-16: quinchos cerrados | 185 → 700–1,000 | 3 → 4–6 | carpinteria `/aberturas/` (text, already set) | Closed quincho: ventilation, extraction over the parrilla, baño/cocina, cerramientos. The aluminio/blindex is carpinteria's product; the obra civil and colocación are ours. |
| `/quinchos/parrillas/` | `app/content/sub/quinchos.php` → `parrillas` | K-15: parrillas, asadores | 189 → 700–1,000 | 3 → 4–6 | none | Parrillas and asadores de obra: refractarios, campana, tiraje, mesada, bacha, gas preparation. |
| `/quinchos/techo-madera/` | `app/content/sub/quinchos.php` → `techo-madera` | K-17: machimbre, techos de madera, techado de quincho, quincho de madera (de carpinteria) | 210 → 700–1,000 | 3 → 4–6 | **none** (carpinteria link removed on purpose) | **Obra-owned now.** Widen to "techos de madera y machimbre" for quincho, galería and casa: especies, tratamiento, aislación bajo teja/chapa, mantenimiento. Never say it's made by carpinteria. Title/H1 stay. |
| `/patios/veredas/` | `app/content/sub/patios.php` → `veredas` | K-31: veredas, contrapiso | 176 → 700–1,000 | 3 → 4–6 | none | Veredas and contrapiso: base, compactación, juntas, pendientes, raíces, pisos exteriores. |
| `/patios/decks/` | `app/content/sub/patios.php` → `decks` | K-32: decks, deck de madera (de carpinteria) | 190 → 700–1,000 | 3 → 4–6 | none | **Obra-owned** (routed from carpinteria): wood decks and alternatives, estructura, separación del suelo, ventilación, piscina surrounds, mantenimiento. |
| `/patios/pergolas/` | `app/content/sub/patios.php` → `pergolas` | K-33: pergolas, pergolas de madera (de carpinteria) | 173 → 700–1,000 | 3 → 4–6 | none | **Obra-owned**: pérgolas de madera y metálicas, anclajes, cubiertas (policarbonato, lona, vegetal), relation to galería. |

## Page notes
- Hubs `/quinchos/` and `/patios/` are deepened by brief F; don't edit `app/content.php`.
- Suggested guide links: `/guias/costo-casa/`, `/guias/terreno/`, `/guias/ladrillo-bloque/`.

## Done when
- Every page above: 700–1,000 words of own copy (hubs: +250–450) and 4–6 FAQs per `php tools/content-words.php`, the v2 H2 outline, `related` includes at least one guide (specialties) or two services (guides).
- `php -l` clean; `node tools/seo-diff.mjs` OK against `docs/audit/audit-before.json` (see CONTENT-SPEC §7).
- Reply: per page, words before → after, FAQs, the related paths you added, and any proposed WA text changes.
