# New pages (NEW-x from docs/IMPROVE-PLAN.md §3.3)

Decision rule (D7): a NEW page is built only if its meaning group has PY volume > 0 in the keyword-library, is distinct from existing pages, and is not a brand or competitor phrase.

**Session 1 result: the keyword-library MCP was not connected, so no volume could be confirmed. Every NEW-x is "skip (no data)". Session 2 builds none of them.**

| ID | URL | Group | Status | Where the topic is covered meanwhile |
|---|---|---|---|---|
| NEW-1 | /guias/costo-piscina/ | cuanto cuesta una piscina | skip (no data) | `/piscinas/` FAQ + section |
| NEW-2 | /guias/costo-quincho/ | cuanto cuesta un quincho | skip (no data) | `/quinchos/` FAQ |
| NEW-3 | /guias/reforma/ | reformar una casa: por dónde empezar | skip (no data) | `/reformas/` hub section (brief F) |
| NEW-4 | /guias/techos/ | tipos de techo | skip (no data) | `/reformas/techos/`, `/quinchos/techo-madera/` |
| NEW-5 | /reformas/humedad/ | humedad / impermeabilización | skip (no data) | H2 section on `/reformas/techos/` (brief D) |
| NEW-6 | /guias/contrato/ | contrato / presupuesto: qué revisar | skip (no data) | `/presupuesto/` + `/guias/costo-casa/` |
| NEW-7 | /piscinas/climatizadas/ | piscina climatizada | skip (no data) | FAQ on `/piscinas/chicas/` and hub |
| NEW-8 | /patios/rejas/ | rejas y cerramientos metálicos | skip (no data) | `/muros/` hub |
| NEW-9 | /obras/ | portfolio | skip (D4: only with real authorized photos) | none |
| NEW-10 | /zonas/... | constructora + ciudad | skip (D5) | none |

## If volumes arrive later
Re-run the pull (list_projects → project_overview → list_groups → get_group / keyword_lookup, Paraguay only), fill `docs/seo/obra-keyword-map.md`, and mark rows "build" here with: URL, meaning group, parent hub, the file to create (`app/content/sub/<hub>.php` new key, or `app/content/guides/<slug>.php`), and 5 WA texts (hero, band, sticky, header, footer) for `app/wa-messages.php`. A new guide file is picked up automatically (appended after the ordered guides); a new specialty is a new key in its hub file.
