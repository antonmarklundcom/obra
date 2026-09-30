# Content brief B: quintas + piscinas (pool season first)

Session 2, round 1 (its own PR). One Sonnet agent at medium effort owns this brief.

## Files you may edit (only these)
- `app/content/sub/quintas.php`
- `app/content/sub/piscinas.php`
- `app/content.php`: **only** the `'quintas'` and `'piscinas'` entries inside `services` (add `sections`, FAQs, maybe `materials`). This brief runs alone in round 1, so it doesn't collide with F.

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
| `/piscinas/` | `app/content.php` → `piscinas` | K-09: piscinas, construccion de piscinas, piletas, construccion de piletas, piscinas de hormigon, piscinas paraguay | 164 → +250–450 | 4 → 4–6 | none | Hub deepen: use **"piletas"** naturally in a section and in one FAQ; seasonal note without dates ("conviene consultar antes del calor"). Most time-sensitive page. |
| `/piscinas/chicas/` | `app/content/sub/piscinas.php` → `chicas` | K-10: piscinas pequeñas / patio chico | 975 → 700–1,000 | 5 → 4–6 | none | **Already v2 (reference page). Don't rewrite.** Only add a guide to `related` if you create a better match; otherwise leave it. |
| `/piscinas/quinta/` | `app/content/sub/piscinas.php` → `quinta` | K-11: piscinas para quintas | 206 → 700–1,000 | 3 → 4–6 | none | Large pools for quintas: water source (pozo mentioned as text only), access for trucks, family use, drainage on open land. |
| `/piscinas/desbordante/` | `app/content/sub/piscinas.php` → `desbordante` | K-12: piscinas desbordantes / infinity | 206 → 700–1,000 | 3 → 4–6 | none | Infinity/desbordante: canaleta, tanque de compensación, level precision, terrain slope. No design talk; execution. |
| `/piscinas/renovacion/` | `app/content/sub/piscinas.php` → `renovacion` | K-13: reparacion / renovacion de piscinas | 203 → 700–1,000 | 3 → 4–6 | none | Leaks, fisuras, revestimiento, equipo nuevo, when to repair vs rebuild (no prices). |
| `/quintas/` | `app/content.php` → `quintas` | K-18: quintas, construccion de quintas | 166 → +250–450 | 4 → 4–6 | pozo (text, already set) | Hub deepen: whole-quinta planning by sectors; keep the pozo note. |
| `/quintas/refaccion/` | `app/content/sub/quintas.php` → `refaccion` | K-20: refaccion de quintas | 184 → 700–1,000 | 3 → 4–6 | none | Recovering an existing quinta: relevamiento, humedad, techos, instalaciones viejas, by priority. |
| `/quintas/casa-campo/` | `app/content/sub/quintas.php` → `casa-campo` | K-19: casas de campo | 223 → 700–1,000 | 3 → 4–6 | none | Differentiate from the hub: hub = whole quinta; this page = **the house** (orientation, galerías, ventilation, materials for the countryside, services). |

## Page notes
- Piscinas first: finish and review the 4 piscinas pages + hub before quintas.
- Suggested guide links: `/guias/terreno/`, `/guias/costo-casa/`, `/credito/`.

## Done when
- Every page above: 700–1,000 words of own copy (hubs: +250–450) and 4–6 FAQs per `php tools/content-words.php`, the v2 H2 outline, `related` includes at least one guide (specialties) or two services (guides).
- `php -l` clean; `node tools/seo-diff.mjs` OK against `docs/audit/audit-before.json` (see CONTENT-SPEC §7).
- Reply: per page, words before → after, FAQs, the related paths you added, and any proposed WA text changes.
