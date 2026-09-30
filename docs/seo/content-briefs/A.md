# Content brief A: casas (4 specialties)

Session 2, round 2. One Sonnet agent at medium effort owns this brief.

## Files you may edit (only these)
- `app/content/sub/casas.php`

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
| `/casas/duplex/` | `app/content/sub/casas.php` → `duplex` | K-03: duplex, townhouse | 217 → 700–1,000 | 3 → 4–6 | none | Townhouse as an H2 in `sections` (investor angle: two units, rent one), not a separate page. "Planos de dúplex" is arq's term: don't optimize design. |
| `/casas/minimalistas/` | `app/content/sub/casas.php` → `minimalistas` | K-05: casas modernas, casas minimalistas (estilo, arq) - decision D1 | 229 → 700–1,000 | 3 → 4–6 | arq `/minimalista/` (text, already set) | **D1 default**: keep URL, title, H1. Rewrite the body to the execution angle: losas planas and their waterproofing, ladrillo visto and junta, large openings (dinteles, vigas), hidden gutters, terminaciones that show every error, what makes it expensive *to build* (no prices). Style/design terms stay with arq; one note says the design is done by the estudio. |
| `/casas/etapas/` | `app/content/sub/casas.php` → `etapas` | K-06: construccion por etapas | 225 → 700–1,000 | 3 → 4–6 | none | How to split obra gruesa / techo / terminaciones so nothing is redone; how stages match bank desembolsos (link `/credito/` in related). |
| `/casas/prefabricadas/` | `app/content/sub/casas.php` → `prefabricadas` | K-04: casas prefabricadas, casas premoldeadas | 210 → 700–1,000 | 3 → 4–6 | none | Add an H2 section "Casas premoldeadas" (the second term of the group). Comparison prefabricada vs premoldeada vs tradicional as `materials` items (no table, no prices). Honest: we build traditional. |

## Page notes
- Hub `/casas/` is deepened by brief F (it lives in `app/content.php`); don't edit it.
- Suggested guide links: `/guias/costo-casa/`, `/guias/plazos/`, `/credito/`, `/guias/platea/`.

## Done when
- Every page above: 700–1,000 words of own copy (hubs: +250–450) and 4–6 FAQs per `php tools/content-words.php`, the v2 H2 outline, `related` includes at least one guide (specialties) or two services (guides).
- `php -l` clean; `node tools/seo-diff.mjs` OK against `docs/audit/audit-before.json` (see CONTENT-SPEC §7).
- Reply: per page, words before → after, FAQs, the related paths you added, and any proposed WA text changes.
