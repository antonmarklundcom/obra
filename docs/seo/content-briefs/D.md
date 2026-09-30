# Content brief D: reformas + ampliaciones

Session 2, round 2. One Sonnet agent at medium effort owns this brief.

## Files you may edit (only these)
- `app/content/sub/reformas.php`
- `app/content/sub/ampliaciones.php`

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
| `/reformas/cocinas/` | `app/content/sub/reformas.php` → `cocinas` | K-22: remodelacion de cocina (obra civil) | 183 → 700–1,000 | 3 → 4–6 | carpinteria `/cocinas/` (text, already set) | Obra civil of the kitchen: demolición, instalaciones (agua, gas, electricidad), revestimientos, mesada support. Muebles = carpinteria, one note. |
| `/reformas/banos/` | `app/content/sub/reformas.php` → `banos` | K-23: remodelacion de baños | 181 → 700–1,000 | 3 → 4–6 | none | Baños: impermeabilización, pendientes, cañerías, ventilación, sanitarios; working while the house is in use. |
| `/reformas/fachadas/` | `app/content/sub/reformas.php` → `fachadas` | K-24: renovacion de fachadas (ejecucion) | 179 → 700–1,000 | 3 → 4–6 | arq `/estilos/` (text, already set) | Execution of a facade renovation: revoques, fisuras, revestimientos, aberturas, andamios. "Fachadas modernas" (design) is arq's. |
| `/reformas/techos/` | `app/content/sub/reformas.php` → `techos` | K-25: cambio / reparacion de techos, impermeabilizacion | 177 → 700–1,000 | 3 → 4–6 | none | Cambio/reparación de techos **plus an H2 section on impermeabilización y humedad** (NEW-5 was skipped for lack of volume data, so it lives here). |
| `/ampliaciones/planta-alta/` | `app/content/sub/ampliaciones.php` → `planta-alta` | K-27: ampliacion planta alta | 194 → 700–1,000 | 3 → 4–6 | arq `/estructural/` (text, already set) | Verification of existing structure, escalera, losa, living in the house during obra. Cálculo estructural itself is arq's. |
| `/ampliaciones/dormitorio/` | `app/content/sub/ampliaciones.php` → `dormitorio` | K-28: ampliacion dormitorio | 171 → 700–1,000 | 3 → 4–6 | none | Adding a dormitorio/baño: union with existing walls, niveles, instalaciones, techos. |
| `/ampliaciones/galeria/` | `app/content/sub/ampliaciones.php` → `galeria` | K-29: ampliacion galeria | 173 → 700–1,000 | 3 → 4–6 | none | Galerías: techo unión con la casa, pisos, orientación, cerramiento later. |

## Page notes
- Hubs `/reformas/` and `/ampliaciones/` are deepened by brief F.
- Suggested guide links: `/guias/permisos/`, `/guias/costo-casa/`, `/guias/plazos/`, `/credito/`.

## Done when
- Every page above: 700–1,000 words of own copy (hubs: +250–450) and 4–6 FAQs per `php tools/content-words.php`, the v2 H2 outline, `related` includes at least one guide (specialties) or two services (guides).
- `php -l` clean; `node tools/seo-diff.mjs` OK against `docs/audit/audit-before.json` (see CONTENT-SPEC §7).
- Reply: per page, words before → after, FAQs, the related paths you added, and any proposed WA text changes.
