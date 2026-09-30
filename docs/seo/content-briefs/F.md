# Content brief F: hubs, supervision/direccion and the 8 guides

Session 2, round 2. One Sonnet agent at medium effort owns this brief.

## Files you may edit (only these)
- `app/content.php`: all `services` entries **except** `quintas` and `piscinas` (brief B owns those two)
- `app/content/sub/supervision.php`
- `app/content/guides/*.php` (8 files)

May be split into two agents: **F1** = `app/content.php` (10 hubs), **F2** = guides + `supervision.php`.

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
| `/casas/` | `app/content.php` → `casas` | K-02: casas llave en mano, llave en mano, construccion de casas, construir casa, construccion de viviendas, plano y construccion | 238 → +250–450 | 5 → 4–6 | arq root link (existing, keep) | Add an H2 section "Qué pasa si ya tengo planos" (plano y construcción) → the existing arq note covers it. |
| `/quinchos/` | `app/content.php` → `quinchos` | K-14: quincho, quinchos, construccion de quincho, quincho con parrilla | 150 → +250–450 | 4 → 4–6 | carpinteria `/aluminio/` (text, already set) | Deepen; mention machimbre/techo de madera as ours (links to `/quinchos/techo-madera/` via specialties). |
| `/reformas/` | `app/content.php` → `reformas` | K-21: reformas, remodelaciones, reforma de casa, remodelacion de casa, refaccion, refacciones | 169 → +250–450 | 4 → 4–6 | arq `/regularizacion/` (text, already set) | Deepen: how a reforma is ordered, living in the house, humedad. |
| `/ampliaciones/` | `app/content.php` → `ampliaciones` | K-26: ampliaciones, ampliacion de casa | 174 → +250–450 | 4 → 4–6 | none | Deepen. |
| `/patios/` | `app/content.php` → `patios` | K-30: patios | 146 → +250–450 | 4 → 4–6 | none | Deepen; decks and pérgolas as obra work. |
| `/tinglados/` | `app/content.php` → `tinglados` | K-34: tinglados, construccion de tinglados | 135 → +250–450 | 4 → 4–6 | none | Deepen. |
| `/muros/` | `app/content.php` → `muros` | K-37: muros, muro perimetral, murallas | 128 → +250–450 | 4 → 4–6 | none | Deepen: muro perimetral, murallas, límites (say "verificá los límites del terreno"). |
| `/comerciales/` | `app/content.php` → `comerciales` | K-39: obras comerciales | 150 → +250–450 | 4 → 4–6 | arq `/comercial/` (add, text) | Deepen; add `link` => [site arq, path /comercial/, text about the design of the local by the estudio]. |
| `/supervision/` | `app/content.php` → `supervision` | K-42: supervision de obra, fiscalizacion de obra, ingeniero civil | 186 → +250–450 | 4 → 4–6 | none | Add an H2 section on **"ingeniero civil"** (what the engineer controls, when you need one). |
| `/presupuesto/` | `app/content.php` → `presupuesto` | K-08: presupuesto de obra, computo metrico | 174 → +250–450 | 4 → 4–6 | prestamo (text, existing) | Add an H2 **"Cómputo métrico: qué es"**. No prices. |
| `/supervision/direccion/` | `app/content/sub/supervision.php` → `direccion` | K-43: direccion de obra | 181 → 700–1,000 | 3 → 4–6 | none | Dirección de obra: responsibilities, visits, libro de obra, certificaciones (no invented legal requirements). |
| `/guias/costo-casa/` | `app/content/guides/costo-casa.php` → `costo-casa` | K-07: cuanto cuesta construir, costo de construccion, precio construccion | 504 → 700–1,000 | 3 → 4–6 | none | Add "Cómo leer un presupuesto por rubro"; related includes `/presupuesto/`. |
| `/guias/terreno/` | `app/content/guides/terreno.php` → `terreno` | K-47: construir en terreno | 338 → 700–1,000 | 3 → 4–6 | none | Deepen; terreno.com.py is not live: no mention. |
| `/guias/plazos/` | `app/content/guides/plazos.php` → `plazos` | K-48: plazos de obra | 317 → 700–1,000 | 3 → 4–6 | none | Stages and what changes duration; never a number of days/months. |
| `/guias/permisos/` | `app/content/guides/permisos.php` → `permisos` | K-49: permiso de construccion (arq es dueño del servicio) | 251 → 700–1,000 | 3 → 4–6 | arq `/carpeta/` (text, already set) | Execution side: what the builder needs approved before starting. The service (carpeta municipal) is arq's. |
| `/guias/platea/` | `app/content/guides/platea.php` → `platea` | K-45: platea (zapatas, fundaciones) | 287 → 700–1,000 | 3 → 4–6 | none | Deepen. |
| `/guias/ladrillo-bloque/` | `app/content/guides/ladrillo-bloque.php` → `ladrillo-bloque` | K-46: mamposteria (ladrillo, bloque) | 262 → 700–1,000 | 3 → 4–6 | none | Deepen. |
| `/guias/albanil/` | `app/content/guides/albanil.php` → `albanil` | K-44: albañil, albañileria, maestro de obra | 330 → 700–1,000 | 3 → 4–6 | none | Deepen; no guarantee claims. |
| `/credito/` | `app/content/guides/credito.php` → `credito` | K-50: credito para construir, financiacion vivienda (decision D3) | 375 → 700–1,000 | 3 → 4–6 | prestamo (text, existing) | **D3 default**: afd / crédito AFD / che roga / crédito vivienda terms stay here until prestamo.com.py is live. No bank requirements we can't verify. |

## Page notes
- K-01 ("obras civiles" line on the home intro) lives in `app/pages.php`: the **director** adds one sentence there, not this agent.
- Guides: each `related` gets at least 2 services/specialties (guide → service links).

## Done when
- Every page above: 700–1,000 words of own copy (hubs: +250–450) and 4–6 FAQs per `php tools/content-words.php`, the v2 H2 outline, `related` includes at least one guide (specialties) or two services (guides).
- `php -l` clean; `node tools/seo-diff.mjs` OK against `docs/audit/audit-before.json` (see CONTENT-SPEC §7).
- Reply: per page, words before → after, FAQs, the related paths you added, and any proposed WA text changes.
