# Brief: /techos/ hub and 8 specialties (roofing)

Decision (Anton, 2026-10-01): **obra owns roofing leads** (new roofs, changes, waterproofing, leaks, gutters, roof structure). carpinteria.com.py keeps only the wood product (`/machimbre/`: machimbre ceilings and finishes). Pages must be ready for **Google Ads exact-match traffic**: the H1 and the opening paragraph repeat the exact phrase a person types, the page answers that one need, and the WhatsApp CTA is above the fold (already provided by the template).

Read `docs/seo/CONTENT-SPEC.md` first (template, voice, banned words). Reference page: `app/content/sub/piscinas.php`, key `chicas`. Do not copy its sentences.

## Where each agent writes (one file each, nothing else)
| Page | File | Shape |
|---|---|---|
| `/techos/` hub | `app/content/hub/techos.php` | hub entry (see "Hub fields") |
| `/techos/<slug>/` | `app/content/sub/techos/<slug>.php` | the file returns ONE specialty array (not keyed by slug) |

Check yourself: `php -l <file>` and `php tools/content-words.php techos/<slug>` (hub: `php tools/content-words.php hub/techos`). Specialty: **700-1,000 words, 4-6 FAQs**. Hub: **500-800 words, 6 FAQs**.

## Pages, exact phrases, boundaries
| Slug | Title (<=65 chars, keep the phrase first) | H1 | Exact phrases the page must contain naturally (H1, intro, one H2, one FAQ) | Boundary: do NOT target |
|---|---|---|---|---|
| hub `techos` | Construcción de techos en Paraguay: chapa, tejas y losa \| Obra | Construcción de techos en Paraguay | construcción de techos, techos para casas, techista, techos de chapa, de tejas y de losa, cubierta | goteras (own page), cambio de techo completo (that is `/reformas/techos/`) |
| `chapa` | Techos de chapa en Paraguay: colocación y estructura \| Obra | Techos de chapa en Paraguay | techo de chapa, techos de chapa, colocación de chapas, chapa trapezoidal, chapa galvanizada, techo de chapa para cochera/quincho/casa | termoacústico (own page), tinglados grandes (`/tinglados/`) |
| `termoacusticos` | Techos termoacústicos en Paraguay \| Obra | Techos termoacústicos en Paraguay | techo termoacústico, chapa termoacústica, panel sándwich, techo aislado, techo para el calor | chapa simple (own page) |
| `tejas` | Techos de tejas en Paraguay \| Obra | Techos de tejas en Paraguay | techo de tejas, techos de tejas, colocación de tejas, tejas cerámicas, tejas coloniales, tejado | chapa, losa |
| `losa` | Techos de losa en Paraguay \| Obra | Techos de losa en Paraguay | techo de losa, losa de viguetas, losa de hormigón armado, losa premoldeada, losa de techo | impermeabilización (own page; mention and point to it), ampliación de planta alta |
| `impermeabilizar` | Impermeabilización de techos en Paraguay \| Obra | Impermeabilización de techos en Paraguay | impermeabilización de techos, impermeabilizar un techo, impermeabilizar una losa, membrana asfáltica, pintura asfáltica | goteras en techos de chapa/teja (own page) |
| `goteras` | Goteras en el techo: cómo se reparan en Paraguay \| Obra | Goteras y filtraciones en el techo | goteras en el techo, arreglar goteras, techo que gotea, filtración de agua en el techo, humedad por el techo | "reparación de techos" and "cambio de techo" (that is `/reformas/techos/`; point to it for a full replacement) |
| `canaletas` | Canaletas y bajadas pluviales para techos \| Obra | Canaletas y bajadas pluviales para techos | canaletas para techo, colocación de canaletas, bajadas pluviales, canaletas de chapa, canaletas de PVC, desagüe del techo | goteras |
| `estructuras` | Estructuras para techos: metálicas y de madera \| Obra | Estructuras para techos: metálicas y de madera | estructura de techo, estructura metálica para techo, estructura de madera para techo, cabriadas, tirantes, vigas, pendiente del techo | tinglados completos (`/tinglados/`), machimbre (carpinteria's product, do not use the word as a target) |

## Ground rules specific to this topic
- Obra = execution. No design terms as targets (planos, cálculo estructural = arq). Never write "machimbre" in a title, H1, description or H2 (carpinteria's group); a body mention is fine.
- Talk in Paraguayan terms: calor fuerte, tormentas, chapas, tejas, losa, tinglado, quincho, cochera. No statistics, prices, plazos, "garantía", "mejor", brand names, years, percentages.
- Each page tells the reader what to send for a quote (photos from below and above, measures, pendiente, access) once, in `sections` or a FAQ.
- `related`: 3-4 full paths. Always include one existing guide among: `/guias/techo-losa-chapa/`, `/guias/impermeabilizar-losa/`, `/guias/humedad-paredes/`, `/guias/costo-tinglado/`, `/guias/costo-ampliacion/`. Other entries: sibling `/techos/<slug>/` pages, `/reformas/techos/`, `/tinglados/cocheras/`, `/quinchos/techo-madera/`. Never link to another domain: no `link` field.
- Every page ends up with its own `summary` (the title's promise in one sentence), `kicker` (short eyebrow), `description` (<=155 chars, phrase first, ends with a soft CTA like "Mandá fotos por WhatsApp").
- Anything you are not sure is true for all cases ("siempre", "nunca", "garantiza") gets softened ("suele", "depende de").

## Hub fields (`app/content/hub/techos.php`)
Return an array with: `name` ("Techos y cubiertas"), `short` (<=120 chars), `title`, `description`, `h1`, `kicker`, `image` = `servicio-cochera.webp`, `image_alt` ("Cochera con cubierta liviana y estructura metálica"), `includes` (5-6), `ideal` (3-4), `faqs` (6), `sections` (2-3 x `[H2, [paragraphs]]`), `related` = list of **hub slugs** (`['tinglados', 'reformas', 'ampliaciones', 'quinchos']`). The 8 specialty cards are generated automatically.

## WhatsApp texts (proposal, not a file edit)
Do not edit `app/wa-messages.php`. Put the proposal in your final reply as 5 lines: `hero | band | sticky | header | footer`, each starting with "Hola,", voseo, 25-160 characters, no prices or plazos or "gratis", unique and specific to the page's phrase (for example "Hola, necesito techo de chapa para mi cochera. ¿Qué medidas les paso?").

## Final reply format (short)
Files written, word count line, FAQ count, the 5 WhatsApp lines, and any phrase you could not fit naturally.
