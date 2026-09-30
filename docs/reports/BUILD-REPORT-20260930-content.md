# Build report: content session (round 1 + round 2)

Date: 2026-09-30. Director and subagents worked from `docs/seo/content-briefs/A.md` to `F.md`. Decisions D1 to D9: defaults used.

## Pull requests
- Round 1 (piscinas + quintas): https://github.com/antonmarklundcom/obra/pull/4, merge SHA `a84a39cd13e4828f1fe22b3ac2c96200a17183fb`.
- Round 2 (everything else + this report): https://github.com/antonmarklundcom/obra/pull/5, merge SHA `2920d9a0fce328a72473a4203cb0a9d31b57eef6`.

## Pages: words before (docs/audit/audit-before.json) and after, links in
Words are main-content words from `tools/audit.mjs`; "links in" counts internal links pointing at the page. Frozen fields (URL, title, H1, canonical, robots, schema types) are unchanged on all pages; 0 new URLs.

| Page | Words before | Words after | Links in before | Links in after |
|---|---|---|---|---|
| / | 982 | 1005 | 56 | 56 |
| /cotizar/ | 246 | 252 | 56 | 56 |
| /casas/ | 717 | 1026 | 56 | 56 |
| /casas/duplex/ | 369 | 1120 | 6 | 6 |
| /casas/minimalistas/ | 380 | 1065 | 7 | 7 |
| /casas/etapas/ | 385 | 1057 | 7 | 8 |
| /casas/prefabricadas/ | 370 | 983 | 5 | 5 |
| /quintas/ | 566 | 874 | 56 | 56 |
| /quintas/refaccion/ | 332 | 1033 | 5 | 5 |
| /quintas/casa-campo/ | 370 | 1063 | 4 | 5 |
| /piscinas/ | 607 | 912 | 56 | 56 |
| /piscinas/chicas/ | 375 | 1153 | 5 | 5 |
| /piscinas/quinta/ | 355 | 1176 | 6 | 6 |
| /piscinas/desbordante/ | 352 | 1079 | 6 | 6 |
| /piscinas/renovacion/ | 348 | 965 | 6 | 6 |
| /quinchos/ | 573 | 935 | 56 | 56 |
| /quinchos/cerrados/ | 320 | 1141 | 4 | 4 |
| /quinchos/parrillas/ | 325 | 1067 | 4 | 4 |
| /quinchos/techo-madera/ | 337 | 1071 | 4 | 4 |
| /reformas/ | 618 | 969 | 56 | 56 |
| /reformas/cocinas/ | 324 | 1089 | 5 | 5 |
| /reformas/banos/ | 324 | 1002 | 6 | 6 |
| /reformas/fachadas/ | 322 | 1017 | 7 | 7 |
| /reformas/techos/ | 320 | 960 | 6 | 6 |
| /ampliaciones/ | 593 | 881 | 56 | 56 |
| /ampliaciones/planta-alta/ | 337 | 957 | 5 | 5 |
| /ampliaciones/dormitorio/ | 309 | 878 | 5 | 5 |
| /ampliaciones/galeria/ | 316 | 886 | 6 | 6 |
| /patios/ | 567 | 894 | 56 | 56 |
| /patios/veredas/ | 324 | 956 | 5 | 5 |
| /patios/decks/ | 338 | 959 | 7 | 7 |
| /patios/pergolas/ | 319 | 923 | 7 | 7 |
| /tinglados/ | 513 | 798 | 56 | 56 |
| /tinglados/galpones/ | 303 | 1163 | 4 | 5 |
| /tinglados/cocheras/ | 319 | 1101 | 7 | 7 |
| /muros/ | 469 | 753 | 56 | 56 |
| /muros/portones/ | 324 | 1180 | 4 | 4 |
| /comerciales/ | 520 | 830 | 56 | 56 |
| /comerciales/locales/ | 313 | 1067 | 3 | 3 |
| /comerciales/oficinas/ | 276 | 991 | 3 | 3 |
| /supervision/ | 535 | 814 | 56 | 56 |
| /supervision/direccion/ | 323 | 1102 | 4 | 6 |
| /presupuesto/ | 476 | 762 | 56 | 56 |
| /guias/costo-casa/ | 611 | 1035 | 56 | 56 |
| /guias/terreno/ | 429 | 918 | 56 | 56 |
| /guias/plazos/ | 404 | 892 | 56 | 56 |
| /guias/permisos/ | 325 | 858 | 56 | 56 |
| /guias/platea/ | 377 | 893 | 56 | 56 |
| /guias/ladrillo-bloque/ | 341 | 838 | 56 | 56 |
| /guias/albanil/ | 416 | 862 | 56 | 56 |
| /credito/ | 483 | 917 | 56 | 56 |

Notes: `/piscinas/chicas/` was already v2 from session 1 (its "before" is the pre-foundation audit). The home page gained the "obras civiles" sentence (K-01) in the services intro. Guide-to-service and service-to-guide links were added through `related` on all guides and specialties.

## Verify
`tools/verify` green on the round 2 branch: php -l 32 files, routes (56 sitemap URLs 200, 14 301s), form matrix 15 cases, check-wa (79 files), audit (56 URLs, 0 non-200, words median 959), seo-diff (56 before, 56 after, 0 new, 51 pages with word delta, no frozen-field change), pw-check 114 runs.

## New URLs
None. Every NEW-x in `docs/seo/content-briefs/NEW.md` is "skip (no data)": the keyword-library MCP was not connected, so no volumes exist and D7 approval is outstanding.

## Live check
Pending Anton: `obra.com.py` was not reachable from the build container (HTTP status 000). Run on his PC after deploy:
```
node tools/audit.mjs https://obra.com.py https://obra.com.py docs/audit/audit-live-after-content.json
node tools/seo-diff.mjs docs/audit/audit-before.json docs/audit/audit-live-after-content.json
node tools/check-wa.mjs https://obra.com.py --no-repo
node tools/pw-check.mjs https://obra.com.py --paths=/,/casas/,/piscinas/quinta/,/quinchos/cerrados/,/reformas/cocinas/
```
Also open `/sitemap.xml`. Sibling cross-links (arq, carpinteria) render as plain text until each target path returns HTTP 200 and is added to `partner_sites[...]['live_paths']` in `config/site.php`.

## Skipped and why
- NEW pages: no volume data (above).
- WhatsApp map: existing texts fit every page; only the `/piscinas/` band text changed (seasonal angle).
- Hub `related` accepts service slugs only, so hubs got service slugs, not guide paths.

## Open decisions for Anton
D7 (approve new pages after the keyword volumes are pulled), D4/D5 (`/obras/`, zone pages: not built), D8 (public business facts), D9 (image budget), D6 (which arq and carpinteria URLs are live).

## Addendum: finishing session
- Live results: none. obra.com.py, carpinteria.com.py and arq.com.py return HTTP 403 from the container proxy, so audit, seo-diff, check-wa and pw-check against live are NOT RUN; the route, 301 and 404 curls are NOT RUN.
- Link changes: carpinteria `/aberturas/` -> `/ventanas/` in `app/content/sub/quinchos.php`. No arq remap possible (see IMPROVE-PLAN status). `live_paths` unchanged (empty).
- NOT RUN: O1, Q4 trust pages, O4 keyword map.
- `tools/verify.sh` green on this branch.
