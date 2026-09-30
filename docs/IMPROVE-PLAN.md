# obra.com.py: improvement plan (2026-09-30)

Planning only. Nothing on the site changed. Files written: `docs/audit/audit-before.json`, this plan, `docs/NEXT-WINDOW-PROMPT.md` (session 1) and `docs/NEXT-WINDOW-PROMPT-SONNET.md` (session 2).
Build: **two sessions**. Session 1 = Opus 5.5 medium: foundation (Phase 0–1, items 1–8, 12, 13, 15), the content spec and briefs, PR, merge, live check. Session 2 = Sonnet 5.5 medium, started after session 1's PR is merged: content fan-out (items 9–11) with Sonnet medium subagents, PRs, merge, live check. Never Fable.

Goal: improve the site a lot while **keeping every URL and ranking it has**, and grow organic traffic and WhatsApp leads for build and execution intent (obra = construcción/ejecución).

---

## 0. How this was investigated (and limits)

| Step | What was done | Result |
|---|---|---|
| Repo | Fresh clone of `antonmarklundcom/obra` (1 commit, `1572dd8`). Read README, CLAUDE-CHANGES, all of `docs/` and `docs/seo/`, `config/`, `app/*`, `form.php`, `router.php`, `.htaccess`, `sitemap.php`, `tools/*.ps1`, CSS/JS. | See findings |
| Live crawl | **Blocked.** This cloud container's egress policy denies `obra.com.py` (curl and WebFetch both refused). | The crawl ran against the repo on `php -S router.php` (PHP 8.4, mbstring and curl on). Live equals repo per your 2026-09-29 check: 56/56 sitemap URLs, the same titles and H1s, byte-identical CSS. **The build window must re-crawl live and diff against `audit-before.json`** (Phase 0). |
| `docs/audit/audit-before.json` | Every sitemap URL: status, title, meta description, H1, canonical, robots, word count (inside `<main>`), internal links in and out, external links, images without alt, schema types, plus redirect and blocked-path checks and every WhatsApp link's number and text. | `/audit-before.json` |
| Playwright | 56 URLs × 1366 px and 390 px (112 runs): console errors, failed requests, broken images, horizontal scroll, LCP element and time, bytes by type, fonts, FAB and CTA above the fold. | `playwright_summary` in audit-before.json; screenshots of 10 key pages × 2 in `./audit-shots/` (local only, not committed) |
| Form | POST with `OBRA_CRM_MOCK=success`, valid data → `303` to `https://wa.me/595992279599?text=…`. Invalid → `303 /cotizar/?error=campos`. | Works |
| Keywords | **The keyword-library MCP is not connected in this cloud session.** The map in §3 uses the KWP term lists in `docs/seo/*-site-structure.md` (70 obra, 60 arq, 60 carpinteria). **Phase 0 of the build pulls PY volumes** with `list_projects` → `project_overview` → `list_groups` → `get_group` / `keyword_lookup` and fills the Vol column. Any "new page" in §3.3 gets built only if its group has real PY volume. | §3 |

---

## 1. Findings

### 1.1 Healthy (protect it, don't "fix" it)
- 56 indexable URLs. All 200, exactly one H1, self canonical, unique titles and descriptions, no orphans, 0 images without alt, 0 broken internal links.
- Legacy 301s work (`/contacto/`, `/cocinas-banos/`, `/servicios/*`, no-trailing-slash → slash). `/app/`, `/config/`, `/docs/`, `/tools/` → 404. `/form.php` GET → 405.
- Schema: `GeneralContractor` (with `@id`) on every page, `Service`+`FAQPage` on hubs and specialties, `Article`+`FAQPage` on guides, `BreadcrumbList`.
- Playwright: 0 console errors, 0 failed requests, 0 broken images, 0 horizontal scroll at 1366 and 390. The LCP is the hero `<img>` or the H1, with `fetchpriority=high` and nothing lazy above the fold. Home: 8.7 KB JS, 34 KB CSS, no web fonts.
- WhatsApp: 274 `wa.me` links across 56 pages, **all to 595992279599**. No empty texts.

### 1.2 Problems found (ranked by impact)
| # | Finding | Evidence |
|---|---|---|
| F1 | **Old number still in the repo docs** (not in the site output). The retired stage-1 number (the `+595 995 …` one; deliberately not written out here) appears in `docs/seo/obra-com-py-site-structure.md:12`, `docs/seo/arq-com-py-site-structure.md:12`, `docs/seo/carpinteria-com-py-site-structure.md:8` and `CLAUDE-CHANGES.md:53`. The config default is already correct (`config/site.php:15` = `595992279599`). But an agent that reads these docs could put the old number back. | grep |
| F2 | **Docs contradict live.** The structure docs list `/obras/` (portfolio), which doesn't exist, and don't list `/guias/` (7 guides + `/credito/`), which is live. `docs/obra-com-py-site-structure.md` and `docs/seo/obra-com-py-site-structure.md` are two copies that differ only in the number. | diff |
| F3 | **WhatsApp messages aren't a map and aren't per page and per service.** They're built from templates in 6 places (`app/layout.php` header and footer, `app/pages.php` ×5) out of page titles. That gives 205 distinct texts, but many are clunky ("vi la página de "Política de privacidad" … y quiero cotizar una obra"), the text isn't reviewable in one place, and there's no QA that fails on another number or an empty text. `assets/js/site.js:84-138` then **intercepts every WA click with an "¿Cómo seguimos?" picker** that rewrites the text by splitting on `' y quiero '`. That's an extra tap before WhatsApp, and it breaks as soon as a message doesn't contain that phrase. | code |
| F4 | **No mobile sticky CTA bar.** On mobile the header WhatsApp button is hidden (`site.css:352`) and only a round FAB remains. The FAB covers the hero image and the "Imagen referencial" label (screenshots). There's no `tel:` link anywhere. | screenshots, grep |
| F5 | **29 specialty pages are thin and weakly linked.** 276 to 385 words each (hubs 470 to 720, guides 325 to 610). Only 3 to 7 internal links in (hub, siblings, `/servicios/`). These are the long-tail growth pages. | audit |
| F6 | **The cross-link rule is broken or unused.** Only 6 pages carry a sibling link, and 3 of them point to domains that aren't live yet (pozo, prestamo) so they render as plain text. `/quinchos/` and `/quinchos/techo-madera/` send **machimbre / techo de madera to carpinteria**, but the new rule says pergolas, decks and machimbre route **to obra**. Style terms (`casas minimalistas/modernas`) are optimized on `/casas/minimalistas/`, but they belong to arq. | content.php:87, content-sub.php:261, :28 |
| F7 | **30 of 56 meta descriptions run over 160 characters** (and get truncated in the SERP). 5 titles run 61 to 64 characters (fine by pixel width, leave them). | audit |
| F8 | **Images:** 4 photos reused across 56 pages (`servicio-cochera.webp` is the hero on 11 pages). No `srcset`: mobile downloads the 1600 px, 211 KB hero. `og-obra.png` (729 KB) is unused. | audit, ls |
| F9 | **Trust pages are thin and have no facts.** `/nosotros/` 189 words, `/cotizar/` 246, `/como-trabajamos/` 291, `/privacidad/` 186. `config/local.php` data (email, RUC, razón social, address) isn't shown. No NAP, no `tel`. That's E-E-A-T and local-pack weakness. | audit |
| F10 | **QA only runs on Windows.** `tools/qa.ps1` and `package-hostinger.ps1` are PowerShell. There's no cross-platform verify, no SEO diff, no number check. The deploy method is a zip upload; nobody has confirmed that Hostinger Git auto-deploy is connected for this repo. | tools/ |
| F11 | Small: `obra_safe_return()` falls back to `/contacto/` (a 301) instead of `/cotizar/` (`app/helpers.php:142`). Sitemap `lastmod` is the same global date for all 56 URLs. The audit file now lives in `docs/audit/` (blocked by .htaccess), so it's never publicly served. | code |

---

## 2. SEO division (what obra owns)

- **obra = build and execution**: construcción, constructora, llave en mano, obra gruesa, piscinas, quinchos, quintas, reformas, ampliaciones, tinglados, muros, patios, supervisión/fiscalización, presupuesto/cómputo, crédito *para construir*. **Pérgolas, decks and machimbre/techos de madera also live on obra** (carpinteria routes them here).
- **arq = design** (no repo yet): planos, diseño, anteproyecto, renders, carpeta municipal, aprobación de planos, regularización, cálculo estructural, interiores, paisajismo, and **all style terms** (casas minimalistas, casas modernas, fachadas modernas, casas de dos pisos, planos de dúplex, diseño de quinchos/piscinas).
- **carpinteria = wood and aluminium products only**: muebles, cocinas a medida (muebles), placares, puertas, aberturas, aluminio, blindex. Its `/pergolas/`, `/decks/` and `/machimbre/` pages must route to obra. That's a carpinteria-repo change: flag it, don't edit that repo.
- **Exactly one contextual cross-link per page at most**, and only where the visitor's next need is truly the sibling's. Brand and competitor phrases never get a page.

---

## 3. Keyword map (meaning group → page)

Vol = Paraguay monthly volume from the keyword-library MCP. **To fill in Phase 0; the build window doesn't create any new page whose Vol is empty or ~0.**
Status: **KEEP** = the page already matches, **REWRITE** = keep URL/H1, deepen or reposition content, **NEW** = candidate page, **ROUTE** = belongs to a sibling (link, don't duplicate).

### 3.1 Groups that map to existing obra pages
| Meaning group (KWP terms) | Page | Status | Action |
|---|---|---|---|
| constructora, constructoras, empresa constructora, construccion, construccion paraguay, constructora asuncion, obras civiles | `/` | KEEP | Home carries the head terms. Add one "obras civiles" line in the home services intro. |
| casas llave en mano, llave en mano, construccion de casas, construir casa, construccion de viviendas, plano y construccion | `/casas/` | KEEP + deepen | Add "Qué pasa si ya tengo planos" (plano y construccion) → cross-link arq `/planos/`. |
| duplex, townhouse | `/casas/duplex/` | REWRITE | Enrich to 700+ words; townhouse as an H2 section (investor angle), not a page. |
| casas prefabricadas, casas premoldeadas | `/casas/prefabricadas/` | REWRITE | Add a "premoldeadas" H2 and a comparison table (no prices). |
| casas modernas, casas minimalistas (**style → arq**) | `/casas/minimalistas/` | REWRITE (reposition) | **Decision D1.** Recommended: keep the URL, title and H1 (it may already rank). Rewrite the body to the execution angle (sistemas, losas, aberturas grandes, terminaciones, what makes a minimalist house expensive to *build*). Add one cross-link to arq `/minimalista/` for design. Don't add more style pages to obra. |
| construccion por etapas | `/casas/etapas/` | REWRITE | Enrich. |
| cuanto cuesta construir, costo de construccion, precio construccion | `/guias/costo-casa/` | KEEP + deepen | No prices, ever. Add a "cómo leer un presupuesto por rubro" section and link `/presupuesto/`. |
| presupuesto de obra, computo metrico | `/presupuesto/` | REWRITE | A "Cómputo métrico: qué es" H2 section. Cross-link prestamo (text only until live). |
| piscinas, construccion de piscinas, piletas, construccion de piletas, piscinas de hormigon, piscinas paraguay | `/piscinas/` | KEEP + deepen | Use "piletas" naturally in the copy and one FAQ. Seasonal: publish before the Oct–Dec peak. **This is the most time-sensitive page.** |
| piscinas pequeñas / para patio chico | `/piscinas/chicas/` | REWRITE | Enrich. |
| piscinas para quintas | `/piscinas/quinta/` | REWRITE | Enrich. |
| piscinas desbordantes / infinity | `/piscinas/desbordante/` | REWRITE | Enrich. |
| reparacion / renovacion de piscinas | `/piscinas/renovacion/` | REWRITE | Enrich. |
| quincho, quinchos, construccion de quincho, quincho con parrilla | `/quinchos/` | KEEP + fix link | Replace the carpinteria machimbre link with carpinteria `/aberturas/` or `/aluminio/` (cerramiento del quincho). |
| parrillas, asadores | `/quinchos/parrillas/` | REWRITE | Enrich. |
| quinchos cerrados | `/quinchos/cerrados/` | REWRITE | Enrich; the natural home for the carpinteria aluminium/blindex link. |
| machimbre, techos de madera, techado de quincho, quincho de madera (**from carpinteria**) | `/quinchos/techo-madera/` | REWRITE | Now obra-owned: widen to "techos de madera y machimbre" (quincho + galería + casa). Remove the "se fabrican en carpinteria" line. |
| quintas, construccion de quintas | `/quintas/` | KEEP | Keep the pozo link as text until pozo is live. |
| casas de campo | `/quintas/casa-campo/` | REWRITE | Differentiate from the hub (hub = whole quinta; child = the house). |
| refaccion de quintas | `/quintas/refaccion/` | REWRITE | Enrich. |
| reformas, remodelaciones, reforma de casa, remodelacion de casa, refaccion, refacciones | `/reformas/` | KEEP + deepen | |
| remodelacion de cocina (obra civil) | `/reformas/cocinas/` | REWRITE | Obra = demolición, instalaciones, revestimientos. Muebles → one link to carpinteria `/cocinas/`. |
| remodelacion de baños | `/reformas/banos/` | REWRITE | Enrich. |
| renovacion de fachadas (execution) | `/reformas/fachadas/` | REWRITE | "Fachadas modernas" (design) → link arq. |
| cambio / reparacion de techos, (impermeabilizacion) | `/reformas/techos/` | REWRITE | Add an impermeabilización section unless NEW-5 has enough volume to be its own page. |
| ampliaciones, ampliacion de casa | `/ampliaciones/` | KEEP | |
| ampliacion planta alta / dormitorio / galeria | 3 children | REWRITE | Enrich. |
| patios | `/patios/` | KEEP | |
| veredas, contrapiso | `/patios/veredas/` | REWRITE | Enrich. |
| decks, deck de madera (**from carpinteria**) | `/patios/decks/` | REWRITE | Now obra-owned. |
| pergolas, pergolas de madera (**from carpinteria**) | `/patios/pergolas/` | REWRITE | Now obra-owned. |
| tinglados, construccion de tinglados | `/tinglados/` | KEEP | |
| galpones | `/tinglados/galpones/` | REWRITE | Enrich (B2B). |
| cocheras, techo para autos | `/tinglados/cocheras/` | REWRITE | Enrich. |
| muros, muro perimetral, murallas | `/muros/` | KEEP | |
| portones (metálicos, de acceso) | `/muros/portones/` | REWRITE | Wood portones → one link to carpinteria `/portones/`. |
| obras comerciales, locales | `/comerciales/`, `/comerciales/locales/` | KEEP / REWRITE | Arq `/comercial/` = design; link once from the hub. |
| oficinas, consultorios | `/comerciales/oficinas/` | REWRITE | The thinnest specialty (276 words). |
| supervision de obra, fiscalizacion de obra, ingeniero civil | `/supervision/` | KEEP + deepen | Add an "ingeniero civil" H2 section. |
| direccion de obra | `/supervision/direccion/` | REWRITE | Enrich. |
| albañil, albañileria, maestro de obra | `/guias/albanil/` | KEEP | |
| platea (zapatas, fundaciones) | `/guias/platea/` | KEEP | |
| mamposteria (ladrillo, bloque) | `/guias/ladrillo-bloque/` | KEEP | |
| construir en terreno | `/guias/terreno/` | KEEP | |
| plazos de obra | `/guias/plazos/` | KEEP | |
| permiso de construccion (**arq owns the service**) | `/guias/permisos/` | KEEP as info | Execution-side "what the builder needs before starting"; one link to arq `/carpeta/`. |
| credito para construir, financiacion vivienda | `/credito/` | KEEP | **Decision D3**: the pure loan terms (afd, credito afd, che roga, credito vivienda) move to prestamo.com.py once live. Until then `/credito/` holds them. |

### 3.2 Groups that belong to a sibling (route, never duplicate)
| Group | Owner | Where obra links from |
|---|---|---|
| planos, planos de casas, diseño de casas, anteproyecto, proyecto arquitectonico | arq `/planos/`, `/diseno/` | `/casas/` (only link on that page) |
| carpeta municipal, aprobacion de planos, permiso de construccion, habilitacion | arq `/carpeta/` | `/guias/permisos/` |
| regularizacion de obra, construccion irregular | arq `/regularizacion/` | `/reformas/` (hub) |
| casas minimalistas, casas modernas, fachadas modernas, casas de dos pisos, planos de duplex | arq `/estilos/`, `/minimalista/`, `/moderna/` | `/casas/minimalistas/`, `/reformas/fachadas/` |
| calculo estructural, ingeniero estructural | arq `/estructural/` | `/ampliaciones/planta-alta/` |
| diseño de interiores, paisajismo | arq | none (no execution page is the natural source) |
| cocinas a medida (muebles), placares, puertas, aberturas, aluminio, blindex | carpinteria | `/reformas/cocinas/`, `/quinchos/cerrados/`, `/muros/portones/` |
| pozo artesiano | pozo.com.py (not live) | `/quintas/` (text only) |
| credito afd, che roga, credito vivienda | prestamo.com.py (not live) | `/credito/`, `/presupuesto/` (text only) |
| terrenos | terreno.com.py | none until live |
| price/free intent (precio m2, presupuesto gratis) | nobody | FAQ copy only, no landing, no prices |

### 3.3 Missing pages worth building (only if Phase 0 volume confirms)
Same shape as existing guides or specialties. Each one is its own meaning group, so it doesn't cannibalize.
| ID | URL (≤15 chars/segment) | Group | Type | Links to |
|---|---|---|---|---|
| NEW-1 | `/guias/costo-piscina/` | cuanto cuesta una piscina / pileta | guide (factors, no prices) | `/piscinas/` |
| NEW-2 | `/guias/costo-quincho/` | cuanto cuesta un quincho | guide | `/quinchos/` |
| NEW-3 | `/guias/reforma/` | reformar una casa: por dónde empezar | guide | `/reformas/` |
| NEW-4 | `/guias/techos/` | tipos de techo (losa, teja, chapa, madera) | guide | `/reformas/techos/`, `/quinchos/techo-madera/` |
| NEW-5 | `/reformas/humedad/` | humedad en paredes / impermeabilización | specialty | `/reformas/` |
| NEW-6 | `/guias/contrato/` | contrato / presupuesto de obra: qué revisar | guide | `/presupuesto/` |
| NEW-7 | `/piscinas/climatizadas/` | piscina climatizada | specialty | `/piscinas/` |
| NEW-8 | `/patios/rejas/` | rejas y cerramientos metálicos | specialty | `/muros/` |
| NEW-9 | `/obras/` | portfolio | index | **Only with real, authorized project photos** (IMAGE-PRODUCTION rule: no generated images as proof). **Decision D4.** |
| NEW-10 | city/zone pages (`/zonas/luque/` …) | constructora + ciudad | fan-out template | **Decision D5.** The current rule forbids near-identical city pages. Only zones truly served, each with local content (soil, municipal process, obras). Not in the default build. |

Rule for adding any page: a distinct meaning group, PY volume > 0, its own copy (not a synonym swap), and it lives in the hub's `children`/`guides` data so the sitemap, menu, breadcrumbs and schema come automatically.

### 3.4 Fan-out plan for many similar pages
1. **Opus (Phase 1)** splits the content data so parallel agents never touch the same file: `app/content-sub.php` → `app/content/sub/{hub}.php` (12 files), `app/content-guides.php` → `app/content/guides/{slug}.php`. The loader globs them in a fixed order (same order as today). **Gate: the rendered HTML of all 56 URLs is byte-identical before and after** (except the `?v=` asset stamp).
2. Opus writes one **page spec** per template (specialty v2, guide v2): required fields, the H2 outline, 700 to 1,000 words of unique copy, 4 to 6 FAQs, "qué incluye", "cómo es el proceso", "materiales y opciones", "errores comunes", "cuándo conviene", one cross-link max, voseo, no prices, PYG only, no invented years, stats or reviews. **Title, H1 and URL of existing pages are frozen.**
3. **Sonnet 5.5 subagents at medium effort**, one per hub group, each owning only its files (≤6 agents at once):
   A casas (4) · B quintas+piscinas (6) · C quinchos+patios (6) · D reformas+ampliaciones (7) · E tinglados+muros+comerciales (5) · F supervision+guides deepen (1+8).
   New pages (§3.3), if approved: one Sonnet medium agent per 2 to 3 pages, a new file each.
4. Opus reviews every diff (voice, rules, cannibalization, frozen fields), then runs verify once for the whole batch and makes one PR.

---

## 4. Protect SEO

### 4.1 URLs that must stay (200, self-canonical, in the sitemap)
All 56 in `docs/audit/audit-before.json → pages`:
`/ /servicios/ /guias/ /como-trabajamos/ /cotizar/ /nosotros/ /privacidad/`
`/casas/ (+duplex, minimalistas, etapas, prefabricadas) /quintas/ (+refaccion, casa-campo) /piscinas/ (+chicas, quinta, desbordante, renovacion) /quinchos/ (+cerrados, parrillas, techo-madera) /reformas/ (+cocinas, banos, fachadas, techos) /ampliaciones/ (+planta-alta, dormitorio, galeria) /patios/ (+veredas, decks, pergolas) /tinglados/ (+galpones, cocheras) /muros/ (+portones) /comerciales/ (+locales, oficinas) /supervision/ (+direccion) /presupuesto/`
`/guias/costo-casa/ /guias/terreno/ /guias/plazos/ /guias/permisos/ /guias/platea/ /guias/ladrillo-bloque/ /guias/albanil/ /credito/`

Existing 301s that must keep working: `/contacto/→/cotizar/`, `/cocinas-banos/→/reformas/cocinas/`, and all 10 `/servicios/<old>/` entries in `obra_legacy_redirects()`; `/X → /X/`; `/sitemap.php → /sitemap.xml`.

### 4.2 URLs that would change
**None in the default plan.** The only candidate is D1 option B (`/casas/minimalistas/` → 301 `/casas/`), and it's not recommended. `/obras/` is new, not changed. If any URL ever changes: add it to `obra_legacy_redirects()`, update internal links, and keep the old URL out of the sitemap.

### 4.3 Frozen per page (no change without an entry in the plan's change log)
The URL, `<title>`, H1, canonical, robots and schema `@type`s. Meta descriptions **may** be shortened (F7) but must keep the primary keyword. Word count and inbound internal links may only go **up**.

### 4.4 Before/after check (build window, before the PR and again on live after deploy)
`tools/seo-diff` compares `docs/audit/audit-before.json` with a fresh `audit-after.json` and **fails** on:
- any before-URL that isn't 200, is missing from the sitemap, or has a non-self canonical or noindex
- a changed title or H1 that isn't in the approved list (`docs/audit/approved-changes.json`)
- word count or internal-links-in going down on any page; schema types not a superset
- any legacy 301 missing or pointing to a new target; robots.txt changed
- a new sitemap URL that returns non-200, has ≠1 H1, or duplicates a title or description
It also prints the list of new URLs and of changed descriptions for the report.

---

## 5. Conversion layer

### 5.1 WhatsApp message map (one file: `app/wa-messages.php`)
- Only number: `595992279599` → `https://wa.me/595992279599?text=…`, `tel:+595992279599`, display `+595 992 279 599`. `config/site.php` keeps the default; a `local.php` override to another number must make QA fail.
- Shape: `'pages' => [path => ['hero' => msg, 'band' => msg]]` plus `'services' => [slug => msg]` (used on service cards, the form's service preselect, and the default for that hub's children), plus `'placements' => ['header','footer','sticky','thanks','404']` fallbacks per page type. **Every sitemap path has its own entry**; child pages have their own text naming the specialty. The helper `obra_wa_text($path, $placement, $serviceSlug = null)` resolves in the order page+placement → page → service → type fallback, and **throws in dev** if the result is empty.
- Voice: voseo, short, no prices, no "gratis", no plazos, PYG only if money ever comes up (it shouldn't). The visitor states what they want and invites the next question. Examples:
  - `/piscinas/` hero: "Hola, quiero construir una piscina de hormigón en mi casa. ¿Qué datos necesitan para pasarme un presupuesto?"
  - `/piscinas/chicas/`: "Hola, tengo un patio chico y quiero saber si entra una piscina. ¿Les puedo mandar las medidas por acá?"
  - `/quinchos/techo-madera/`: "Hola, quiero un quincho con techo de madera y machimbre. ¿Cómo arrancamos?"
  - `/casas/`: "Hola, quiero construir mi casa llave en mano. Ya tengo terreno. ¿Qué necesitan para empezar?"
  - `/credito/`: "Hola, quiero construir con crédito y necesito el presupuesto de obra para el banco. ¿Me ayudan?"
  - `/guias/costo-casa/`: "Hola, leí la guía de costos y quiero un presupuesto por rubro para mi casa."
  - `/privacidad/` and the other utility pages use the generic type fallback ("Hola, quiero hacer una consulta sobre una obra.").
- **The picker in `site.js` (F3)**: **Decision D2.** Recommended: remove it, so every link goes straight to WhatsApp with the mapped text (one tap; the map carries the intent). Alternative: keep it, but read its options from the map instead of splitting on `' y quiero '`.
- **QA `tools/check-wa`** (fails the build): render every sitemap URL plus `/gracias/` and the 404 page; every `wa.me` number must be `595992279599` and every `tel:` must be `+595992279599`; every text must be non-empty, ≥25 characters, contain no digits run that looks like a price, `Gs`, `₲`, `USD` or `$`, and match the voseo lint (no "usted", "puede usted", "tienes", "quieres"); texts must be unique per (page, placement) except for listed fallbacks. It also greps the **whole repo** (code and docs, excluding `.git`) for any Paraguayan mobile number (`595\D?9\d{2}` followed by 6 digits, any spacing; `wa.me/<digits>`; `tel:`) that isn't `595992279599`. That catches the retired `595 995 …` number without the tool or the docs ever containing it.

### 5.2 Form (`form.php`)
Keep the flow: validate → VenderCRM (via `OBRA_CRM_MOCK` in tests: `success`, `fail`, unset) → `mail()` best effort → `303` to wa.me with the full lead text. Changes:
- Hidden `origin_path` and `placement` fields: the WA text and CRM `fields` say which page the lead came from (today `page_url` is filled by JS only).
- Preselect the service from the page (hubs and children link to `/cotizar/?servicio=slug`).
- The WA text after the form is built from the map's `form` template (voseo), not a hard-coded sprintf.
- `obra_safe_return` fallback → `/cotizar/` (F11).
- Test matrix (automated in `tools/verify`): mock success, fail and unset each go to wa.me 595992279599; honeypot → `/gracias/?estado=enviado`; too fast → `error=tiempo`; each missing field → `error=campos` with the service kept; a non-PY phone fails. **Never use real CRM keys.** `config/local.php` stays out of git, and only `config/local.example.php` and `.env.example` are versioned.

### 5.3 CTA placement (per page type)
| Page type | Hero | Mid | End | Other |
|---|---|---|---|---|
| Home | WA (primary) + "Ver servicios" | After the services bento: "Cotizar por WhatsApp" | Contact band: WA + form | |
| Hub | WA + "Completar el formulario" | After "Qué incluye" | Contact band | Specialty cards each have a small "Consultar" WA link with that child's text |
| Specialty | WA + form | After "Cuándo conviene" | Contact band | |
| Guide | none in the hero (reader intent) | After the 2nd H2 section: soft box "¿Querés que lo veamos para tu terreno?" | CTA box + related service | Sticky TOC keeps a WA link on desktop |
| /cotizar/ | WA + form + `tel:` | | | The sticky bar is hidden here |
| /gracias/ | "Seguir por WhatsApp" | | | No sticky bar |

### 5.4 Mobile sticky bar (≤ 760 px)
- A fixed bottom bar with 2 equal buttons: **WhatsApp** (green, mapped `sticky` text) and **Cotizar** (→ `/cotizar/?servicio=…`). Height 56 px + `env(safe-area-inset-bottom)`, `body{padding-bottom}` to match, so no content is hidden.
- It replaces the round FAB on mobile (the FAB stays on desktop, moved so it doesn't cover the hero "Imagen referencial" label).
- Hidden on `/cotizar/` and `/gracias/`, while any form field has focus (the keyboard is open), and while the mobile menu is open. It's in the HTML (no JS required to show it).
- GA4 `whatsapp_click` with `placement=sticky`, `page_path` and `service`.
- Playwright checks: visible at 390 on every page type except the two above; no overlap with the cookie banner (the banner sits above the bar); no horizontal scroll; tap targets ≥ 44 px.

---

## 6. Ranked work items

Model key: **O** = Opus 5.5 medium (session 1 director). Items 9–11 are directed by session 2 (Sonnet 5.5 medium), which reviews its own subagents' work. **S-L** / **S-M** = Sonnet 5.5 subagent at low or medium effort. Risk = risk to current rankings.

| # | Item | Effort | Risk | Model | Human decision? |
|---|---|---|---|---|---|
| 1 | Cross-platform tools: `tools/audit.mjs` (crawl → audit JSON, same schema as audit-before), `tools/seo-diff.mjs`, `tools/check-wa.mjs`, `tools/verify.sh` + `verify.ps1` wrappers (php -l on all, routes, form matrix, check-wa, seo-diff, Playwright). Local gate only, **no GitHub Actions** (budget policy). | M | none | O | no |
| 2 | Remove the old number everywhere (F1); reconcile the docs (F2): one structure doc (`docs/seo/obra-com-py-site-structure.md`, the other becomes a pointer), `/guias/` documented, `/obras/` marked "deferred until real photos", division rules from §2 added. | S | none | S-L, O reviews | no |
| 3 | WhatsApp map + helper + QA + remove or rework the picker (F3, §5.1). Wire all 6 call sites. | M | low | O writes the helper and QA; S-L drafts the ~70 message texts; O reviews | D2 |
| 4 | Mobile sticky bar + FAB fix + `tel:` link (F4, §5.4). | S | low | O | no |
| 5 | Form tweaks + test matrix (§5.2). | S | none | O | no |
| 6 | Cross-link fixes (F6, §3.1/3.2): quinchos → carpinteria aluminio, techo-madera widened and link removed, cocinas/portones → carpinteria, permisos/minimalistas/fachadas/planta-alta → arq, one per page max. Needs the exact arq/carpinteria target URLs to be live (check each with a HEAD request; if one isn't live, use text only). | S | low | O | arq target URLs (D6) |
| 7 | Meta descriptions ≤ 155 characters on the 30 long ones (F7), primary keyword first. | S | low | S-L, O reviews | no |
| 8 | Content data split (§3.4 step 1) with the byte-identical HTML gate. | M | none if the gate passes | O | no |
| 9 | **Deepen the 29 specialties** to 700 to 1,000 words (F5), `/casas/minimalistas/` repositioned (D1), `/quinchos/techo-madera/`, `/patios/decks/` and `/patios/pergolas/` widened as the obra-owned wood-structure pages. **Piscinas group first** (season). | L | low–medium (content changes on ranking pages: frozen title, H1 and URL, only additions) | 6 × S-M in parallel, O reviews | D1 |
| 10 | Deepen the hubs and the 8 guides (+ "piletas", "ingeniero civil", "cómputo métrico", "townhouse" sections), and add guide → service and service → guide contextual links (in-links for the specialties). | M | low | S-M, O reviews | no |
| 11 | New pages from §3.3 that pass Phase 0 volume (probably 3 to 6). | M | none (additive) | S-M per 2 to 3 pages | approve the list (D7) |
| 12 | Responsive images: `srcset` 480/960/1600 for the 4 WebPs, a mobile hero ≤ 70 KB, delete the unused `og-obra.png`. | S | none | S-L | no |
| 13 | Trust pages: `/nosotros/`, `/como-trabajamos/`, `/cotizar/` with **real** facts; NAP and `tel` in the footer and schema (`telephone`, `address` if given). | M | low | O | D8 (facts, RUC, address, email) |
| 14 | New imagery per hub (Higgsfield, labelled "referencial") or real photos. | M | none | per the higgsfield/webimg pipeline skills | D9 (credits, AI vs real) |
| 15 | Per-page sitemap `lastmod` from the content-file mtime (F11). | S | none | S-L | no |
| 16 | `/obras/` portfolio (NEW-9). | M | none | O | D4 (only with real photos) |
| 17 | Zone pages (NEW-10). | L | medium (thin/duplicate risk) | not in this build | D5 |

**Build order.** Session 1 (Opus): 1 → 2 → 8 → 3 → 4 → 5 → 6 → 7 → 12 → 15 → 13 (if facts arrive) → content spec + briefs → verify → PR → merge → live verify. Session 2 (Sonnet), after that merge: group B piscinas (item 9) → PR → merge → live verify; then the rest of 9, 10, 11 → PR → merge → live verify. Items 14, 16 and 17 wait for Anton.

---

## 7. Git flow (Claude owns it end to end in the build window)
- Claude creates the branch, commits per work item (clear messages, no model names), pushes, opens **one PR** to `main`, and reads the PR checks. The repo has no CI, and none is added (budget policy): "checks" = any installed review bots (Claude Code Review / Approvals) plus the local `tools/verify` gate, whose output goes in the PR body.
- Claude fixes review comments, CI or bot findings, lint, build errors, broken links and merge conflicts itself (merge `main` in, no force-push on shared branches), and re-runs verify after every fix.
- **Merge only after local verification is green.** A merge to `main` may auto-deploy on Hostinger. After merging, Claude checks the live URLs: runs `tools/audit.mjs` against `https://obra.com.py` → `audit-live-after.json`, then `seo-diff` against before, `check-wa` against live, and spot-checks Playwright on 6 URLs. If a live check fails: fix forward in a new PR at once, or revert the merge commit if it's a ranking-critical regression (a 404 or noindex on an existing URL).
- If Git deploy is **not** connected (today's deploy is a zip), Claude builds the zip with the package script, and the upload is Anton's step. Claude then runs the live verification after Anton confirms the upload.
- Claude fixes anything it finds along the way, and stops only for Anton's decisions (§8).
- It never commits secrets or `config/local.php` / `.env`; only `*.example` files. It never prints keys.

## 8. What a human must decide (Anton)
D1 `/casas/minimalistas/`: reposition to execution (recommended) or 301. · D2 the WA picker: remove (recommended) or keep. · D3 whether the credit/AFD terms stay on `/credito/` until prestamo.com.py is live (recommended yes). · D4 `/obras/`: only with real photos. · D5 zone pages: which zones are truly served. · D6 which arq URLs are live now (arq has no repo). · D7 approve the new pages after the volume pull. · D8 public business facts. · D9 image budget.

## 9. Open questions for Anton (only real decisions)
1. **Is Hostinger Git auto-deploy connected to `main` of this repo, or is it still a manual zip upload?** (This decides whether the merge is the deploy.)
2. **`/casas/minimalistas/`**: OK to keep the URL and rewrite it as "building" a modern house, with one link to arq for design? (Recommended.)
3. **WhatsApp picker ("¿Cómo seguimos?")**: remove it so every button opens WhatsApp in one tap with the page's own message? (Recommended.)
4. **Public business facts** for Nosotros, the footer and schema: razón social, RUC, address or "zona", email, years building, and whether a "Llamar" (`tel:`) link is wanted next to WhatsApp.
5. **Images**: spend Higgsfield credits on hub-specific "referencial" images now, or wait for real obra photos? Do real photos exist for `/obras/`?
6. **arq.com.py**: which URLs are live today (`/planos/`, `/carpeta/`, `/minimalista/`, `/estructural/`…), so the cross-links don't point at 404s?

## Status after finishing session (2026-09-30)
- O1 live verification: NOT RUN (obra, carpinteria and arq return a proxy 403 from the cloud container). Commands are in the content build report.
- O2: carpinteria `/aberturas/` link changed to `/ventanas/`. The arq repo has no `docs/seo/arq-urls.md` and is a builders directory (`/obras/`, `/arquitectos/`, `/nosotros/`, `/contacto/`), so none of the design URLs (`/carpeta/`, `/minimalista/`, `/estructural/`, `/estilos/`) exist; those links stay plain text. `live_paths` stay empty until HEAD 200 is confirmed live.
- O3: Q2 and Q3 were already in place (minimalistas is a construction page with one arq link; no picker). Q4 (business facts): NOT RUN, no facts given.
- O4: NOT RUN, the keyword-library MCP is not connected.
- Deploy mode (Git vs zip) was not answered; assume zip until Anton confirms.
