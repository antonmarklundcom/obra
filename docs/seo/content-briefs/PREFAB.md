# Plan: casas prefabricadas + precios por m² (obra.com.py)

Date: 2026-10-01. Status: **PLAN, waiting on 2 decisions from Anton (section 1)**. Pattern: copy the `/techos/` build (`TECHOS.md`, commit 866fbae): one hub file, one file per specialty, WhatsApp texts, Ads-ready exact phrases.

## 0. What the KWP list really says (PY monthly volume)

| Cluster | Terms (vol) | Total | Intent |
|---|---|---|---|
| **P1 Prefab head** | casas prefabricadas en paraguay 390, casas prefabricadas paraguay precios 40, casa prefabricada paraguay precio 20, casa prefabricada precio paraguay 10 | **460** | commercial: "show me models and prices" |
| P2 Container | casa container paraguay precio 50, casa container paraguay precios 50 | 100 | commercial + price |
| P3 Madera | casa de madera economicas en paraguay 40 | 40 | price-sensitive |
| P4 Cuotas | casas prefabricadas en cuotas en paraguay 40 | 40 | financing |
| P5 Villarrica | casas prefabricadas en villarrica 10, …villarrica precios 10, casa prefabricada modelo villarrica 10 | 30 | local + a model name (likely a competitor's catalogue model) |
| P6 Modular buildings | edificio modular prefabricado 10, edificios modulares 10 | 20 | B2B |
| **M1 Precio por m² (rubros)** | pared 210, techo de chapa 40, techo de tejas 40, losa 20, losa rap 10, durlock 20, revoque 10, pintura 10 | **360** | informational price lookup, people mid-project |
| M2 Precio m² construcción | precio de construcción por m² 30, precio del metro cuadrado de construcción 10, precio m2 construcción edificio 10 | 50 | overlaps `/guias/costo-casa/` |
| M3 Vidrio | vidrio 40, vidrio espejo 10 | 50 | **carpinteria.com.py's product** (aberturas/blindex), not obra |
| E Edificios | constructora de edificios 10, construcción de un edificio paso a paso 10 | 20 | B2B / informational |

Two facts drive the whole plan:
1. The head term (390) is **"casas prefabricadas en paraguay"** and the existing page `/casas/prefabricadas/` is a "prefab vs tradicional, we don't build prefab" comparison. That angle cannot win a 390 commercial query where Google shows catalogues with models and prices.
2. **8 of the 28 terms contain "precio"** and the biggest non-prefab term is "precio de pared por metro cuadrado" (210). The site's HARD RULE is *no prices*. A price page without a number will not rank and will annoy the visitor.

## 1. Decisions for Anton (blocking)

**D1. Who sells the prefab house?**
- (a) **Honest buyer's guide + what obra does around a prefab** (recommended if obra does not build prefab): the hub answers "casas prefabricadas en Paraguay" fully (types, what the catalogue price leaves out, how to compare, cuotas, container, madera) and sells obra's real work: platea/base, conexiones de agua/luz/cloaca, cámara séptica, galería, quincho, ampliación tradicional pegada a la prefabricada, cochera. Lead = "I bought/am buying a prefab and need the base and the rest".
- (b) Obra (or a partner) **sells/builds prefab or steel-frame/container** houses: then the hub gets models, sizes, "desde Gs" prices and a cuotas offer. Needs real models, photos, prices and the partner name.
- (c) Lead resale to a prefab partner: like (a) plus a partner note (same pattern as the `link` field for sibling sites).

**D2. May we publish prices?** (changes the HARD RULE "no prices" for a defined set of pages)
- (a) **Yes, referential unit prices with a date** (recommended): only on `/precios/*` pages and the prefab hub's "qué incluye el precio" table. One data file `app/content/prices.php` with `as_of` date, unit (Gs/m²), low-high range, what is included, and Anton's source (own budgets). Rendered with "Precios referenciales a <mes año>, sin IVA/con IVA, varían según…". Verify gets an allowlist: digits+Gs allowed only on those paths and only from `prices.php`, so no price leaks into other copy.
- (b) No numbers: pages explain what makes up the m² price of each rubro. Weaker, likely page 2-3 for "precio de … por metro cuadrado".

## 2. Site structure (recommended: D1 = a, D2 = a)

### Hub A: `/prefabricadas/` (new hub, group "construcción nueva")
`/casas/prefabricadas/` **301 →** `/prefabricadas/` (its copy and FAQs move into the hub, word count only goes up). Add the redirect to `obra_legacy_redirects()`, `tools/seo-diff.mjs` LEGACY and `tools/audit.mjs` ROUTE_CHECKS.

| URL | H1 (exact phrase first) | Targets | Notes |
|---|---|---|---|
| `/prefabricadas/` | Casas prefabricadas en Paraguay: tipos, precios y qué incluye | P1 (460) | 900-1,200 words. Sections: types (madera, paneles/steel frame, premoldeada de hormigón, container, modular); **"lo que el precio de catálogo no incluye"** (platea, flete, montaje, conexiones, baño/cocina, permisos) as the money section; how to compare quotes by rubro; prefab vs tradicional (moved from the old page); what obra does around it. 6 FAQs incl. "¿cuánto cuesta una casa prefabricada en Paraguay?" |
| `/prefabricadas/container/` | Casas container en Paraguay: precio y qué hay que resolver | P2 (100) | heat (aislación, ventilación, techo doble), corrosion, platea/pilotes, connections. Links `/techos/termoacusticos/`. |
| `/prefabricadas/madera/` | Casas de madera económicas en Paraguay | P3 (40) | termites, humidity, elevated base, treatment, maintenance; honest when it is cheap and when not. |
| `/prefabricadas/cuotas/` | Casas prefabricadas en cuotas en Paraguay | P4 (40) | how cuotas/credit work in general (no rates, "consultá con tu banco/financiera"), what a bank accepts, what the cuota usually leaves out (base, conexiones). Links `/credito/`. |
| `/prefabricadas/platea/` | Platea y base para casa prefabricada | obra's money page (no KWP row; supports Ads) | the lead page for D1(a): platea, pilotes, contrapiso, desagüe, conexiones. Links `/guias/platea/`. |
| `/prefabricadas/modulares/` | Edificios modulares prefabricados | P6 (20) | phase 3, only if obra/partner does B2B; otherwise one H2 on the hub. |

Villarrica (P5, 30): no doorway page. Only build `/zonas/villarrica/` if Anton truly serves Villarrica (ties into round 4 Phase A zones). "modelo villarrica" is a model name, skip.

### Hub B: `/precios/` (new hub "Precios de construcción por m²")
Requires D2 = a. Each page: H1 = exact phrase, price table from `prices.php` (as_of date), "qué incluye el m²" (material + mano de obra + what is not included), how to measure your m², common mistakes, WhatsApp CTA "mandanos las medidas". Schema `Article` + `FAQPage` (no `Offer`).

| URL | H1 | Targets |
|---|---|---|
| `/precios/` | Precios de construcción por metro cuadrado en Paraguay | hub, M2 (50), links to every rubro |
| `/precios/pared/` | Precio de pared por metro cuadrado en Paraguay | **210** (ladrillo común, ladrillo hueco, bloque; 0.15 vs 0.30; con/sin revoque) |
| `/precios/techo-chapa/` | Precio de techo de chapa por metro cuadrado | 40 (links `/techos/chapa/`) |
| `/precios/techo-tejas/` | Precio de techo de tejas por metro cuadrado | 40 (links `/techos/tejas/`) |
| `/precios/losa/` | Precio de losa por metro cuadrado en Paraguay | 20 + losa rap 10 (links `/techos/losa/`) |
| `/precios/durlock/` | Precio de durlock por metro cuadrado en Paraguay | 20 (tabique y cielorraso) |
| `/precios/revoque-pintura/` | Precio de revoque y pintura por metro cuadrado | 10 + 10 ("2021" in the query = people want a *current* date: show `as_of` prominently) |

`/guias/costo-casa/` stays the "cuánto cuesta construir una casa" guide and links to `/precios/`; `/precios/` takes the "precio m² construcción" phrases. Edificio terms (E, M2 edificio, 40 total): one H2 + FAQ on `/comerciales/` now; a guide `/guias/construccion-edificio/` only if Anton wants B2B.

Vidrio / vidrio espejo (50): **not obra**. Hand to carpinteria.com.py as `/precios/vidrio/` there.

Total captured: ~460 + 100 + 40 + 40 + 20 + 360 + 50 + 20 ≈ **1,090/month** of the 1,330 in the list (rest: vidrio → carpinteria, Villarrica → zone decision).

## 3. Page design ("amazing", within the existing template)

Hub template additions (one-time code, Opus phase):
- **Price/scope table component** (`prices` field): rows = item, unit, range, includes; caption with `as_of`; mobile = stacked cards. Reused by every `/precios/` page and the prefab hub.
- **"Lo que incluye vs no incluye" checklist** for the prefab hub (two columns: catálogo / lo que falta), each "falta" item links to the obra service that does it. This is the conversion block.
- **Type comparison cards** (madera / steel frame / premoldeada / container / tradicional): clima, montaje, financiación, ampliación, mantenimiento as short words, not scores.
- **m² helper** on `/precios/pared/` (progressive enhancement, no JS needed): largo x alto − aberturas = m², then "mandanos estas medidas" pre-filled WhatsApp. Never computes a total price (keeps us out of quote liability) unless Anton wants it.
- Everything else (hero, sticky WhatsApp, FAQ schema, breadcrumbs, cards, sitemap) is already generated by the template.

## 4. Images (Higgsfield, gpt_image_2_5 "sunburst", quality high)

Per `higgsfield-image-pipeline`: preflight cost and balance, one batch, record job IDs in `docs/imagery-manifest.json`, convert with webimg (webp 480/960/full, SEO filename, alt). **Known blocker:** last session could not download from `*.cloudfront.net` (proxy 403), so the 9 roofing images are still not in the repo. Fix first: add `*.cloudfront.net` to the environment allowlist, or run `webimg` on Anton's PC. All images labelled "Imagen referencial", never presented as obra's work.

| File | Prompt idea |
|---|---|
| `casas-prefabricadas-paraguay.webp` (hub hero, 16:9) | single-storey prefab panel house on a fresh concrete platea, red soil, lapacho tree, Paraguayan suburb light |
| `casa-container-paraguay.webp` | converted 40ft container home with double roof and shade, wide eaves, Central department yard |
| `casa-de-madera-elevada.webp` | timber house on raised concrete piers, galería, rural lot |
| `platea-casa-prefabricada.webp` | concrete platea with plumbing stubs ready for a modular house |
| `pared-ladrillo-metro-cuadrado.webp` | bricklayer raising a ladrillo común wall, string line, level |
| `durlock-tabique-cielorraso.webp` | drywall partition and ceiling being installed |
| `revoque-pintura-pared.webp` | plastered wall half painted, roller and tray |
| `/precios/` hub + losa/chapa/tejas | reuse the roofing images already generated (once downloaded) |

~8 new images; cost per image at high quality must be read from `models_explore` before generating.

## 5. Build plan (who does what)

Recommendation: **Opus director in this session for phase 1, Sonnet subagents for the content fan-out (phase 2)**, per `fable-directs-sonnet-builds`. Never Fable.

| Phase | Model | Work | PR |
|---|---|---|---|
| 1 Foundation | Opus | `prefabricadas` + `precios` hubs registered in `app/content.php` groups and `children`; 301 `/casas/prefabricadas/` → `/prefabricadas/`; `prices.php` + table/checklist/comparison components in `pages.php` + CSS; verify rule: prices only on allowlisted paths; update `CONTENT-SPEC.md` §6 and `NEXT-WINDOW-PROMPT.md` HARD RULES with the D2 exception | 1 |
| 2 Content | 6-8 Sonnet subagents in parallel, one file each | hub + 4-5 prefab specialties, `/precios/` hub + 6 rubro pages; each runs `php -l`, `content-words.php`; replies with 5 WhatsApp lines | 1 |
| 3 Wire-up | Opus | WhatsApp texts in `app/wa-messages.php`, reverse links (techos, casas, guías → new pages), images, `docs/ads/GOOGLE-ADS-SETUP.md` ad groups for "casas prefabricadas en paraguay" and "precio de pared por metro cuadrado", keyword map rows K-04 + new | 1 |
| Gate | Opus | `bash tools/verify.sh` green (seo-check, seo-diff, check-wa, events, pw-check 390/1366), IndexNow after merge | — |

## 6. What Anton must provide
- D1 and D2 answers.
- If D2 = a: current unit prices per rubro (Gs/m², material + mano de obra, with/without IVA) and the month they are valid for. Without them, D2 falls back to (b).
- If D1 = b/c: partner name, models, photos with permission, financing terms.
- Whether Villarrica is a served zone.
