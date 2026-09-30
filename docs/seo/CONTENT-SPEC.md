# Content spec v2: specialties, hubs and guides (obra.com.py)

For session 2 (content fan-out). Every content agent reads this file, its brief in `docs/seo/content-briefs/`, and nothing else is needed to write a page. The reference page is **/piscinas/chicas/**: it already has the full v2 shape (975 words of own copy, 5 FAQs). Copy its shape, never its sentences.

## 1. Where content lives (one file per agent)

| Page type | File | Key |
|---|---|---|
| Specialty `/hub/child/` | `app/content/sub/<hub>.php` | the child slug, e.g. `'chicas' => [...]` |
| Hub `/hub/` | `app/content.php` | `'services' => ['<hub>' => [...]]` |
| Guide `/guias/<slug>/` and `/credito/` | `app/content/guides/<slug>.php` | the whole file returns one array |
| WhatsApp texts | `app/wa-messages.php` | **director only**; agents propose texts in their reply |

Menus, sitemap, breadcrumbs, schema (Service/Article + FAQPage) and the card grids are generated from these arrays. Never edit `app/pages.php`, `app/layout.php`, `app/routes.php`, `index.php` or CSS/JS in a content task.

## 2. Frozen fields (never change)

`name`, `title`, `description`, `summary`, `h1`, `path`, `image`, `image_alt`, and the array key (the URL slug). Also frozen: the URL, canonical, robots and schema types (all generated). Titles and H1s of existing pages stay exactly as they are, even if you would phrase them differently. `description` was already shortened in session 1 and is approved; don't touch it.

Word count of every page and its internal links-in may only go **up** (`tools/seo-diff.mjs` fails otherwise). Only add or rewrite copy fields; don't delete FAQs or `related` entries.

## 3. Specialty v2 template

### Fields
| Field | Required | Shape | Renders as |
|---|---|---|---|
| `kicker` | exists | string | eyebrow above the H1 (may be improved) |
| `intro` | yes | 2–3 paragraphs | hero text under the H1 |
| `includes` | yes | 5–7 short items | H2 "Qué puede incluir." |
| `process` | **new** | 4–5 × `[step title, 1–3 sentences]` | H2 "Paso a paso, de la visita a la entrega." |
| `materials` | **new** | 3–5 × `[option, 1–3 sentences]` | H2 "Qué se puede elegir." (Materiales y opciones) |
| `sections` | **new** | 1–3 × `[H2 text, [paragraph, ...]]` | page-specific H2 sections (the meaning group's own questions) |
| `mistakes` | **new** | 3–5 × `[mistake, how it's avoided]` | H2 "Lo que conviene evitar." (Errores comunes) |
| `ideal` | yes | 3–4 items | H2 "Te conviene si…" (Cuándo conviene) |
| `faqs` | yes | **4–6** × `[question, answer]` | FAQ section + FAQPage schema |
| `related` | yes | 3–4 full paths | "Otras especialidades…" list. **Must include 1 guide** (`/guias/...` or `/credito/`) |
| `link` | optional | `['site' => 'arq'\|'carpinteria'\|'pozo'\|'prestamo', 'path' => '/x/', 'text' => '...']` | the one sibling note; **only as allowed in the brief** |

### H2 outline (rendered order)
intro (hero) → Qué incluye → Cómo es el proceso → Materiales y opciones → own `sections` → Errores comunes → Cuándo conviene (`ideal`) → sibling note (if any) → Relacionados → FAQ → contact band.

### Length and uniqueness
- **700–1,000 words of own copy**, measured with `php tools/content-words.php <hub>/<child>` (counts every copy field except name/title/description/summary/h1/kicker/image/related/link).
- No sentence may be copied from a sibling page, the hub, or the reference page. Swapping synonyms is copying.
- The page answers **its own meaning group** (see the brief's keyword rows). If a paragraph fits a sibling better, it belongs there.

## 4. Hub deepen (group F, and B for its two hubs)

Hubs keep their fields (`short`, `includes`, `ideal`, `faqs`, `related`, `link`) and may gain `sections` (1–3 H2 sections, rendered after the specialty cards) and `materials`/`mistakes` if useful. Target: +250–450 words per hub, 5–6 FAQs. The terms named in the brief (e.g. "piletas", "ingeniero civil", "cómputo métrico", "obras civiles", "townhouse") appear naturally in a section and in one FAQ.

## 5. Guide v2 template

| Field | Shape |
|---|---|
| `intro` | 1–2 paragraphs |
| `sections` | **5–7** × `[H2, [paragraph, ...]]`; the table of contents is generated from them. A soft WhatsApp box renders after the 2nd section automatically. |
| `faqs` | 4–6 |
| `related` | 3 paths, **at least 2 services or specialties** (guide → service links) |
| `link` | only as the brief allows |

Length: **700–1,000 words of own copy** (`php tools/content-words.php guides/<slug>`). Include one section that tells the reader how to read or compare a presupuesto *by rubro* for that topic, never with numbers. No prices, no plazos in days/weeks/months, no legal or bank requirements we can't verify (say "consultá con tu banco / tu municipio").

## 6. Voice rules

- Spanish from Paraguay, **voseo**: querés, tenés, podés, contanos, consultá, pedí. Never tú forms (quieres, tienes, puedes) or "usted".
- Concrete and practical: what gets built, in what order, what goes wrong, what to decide. Local references are fine (Asunción, Central, Luque, calor, lluvias, suelo arcilloso) if not presented as statistics.
- **Never**: prices or price ranges, "Gs"/"₲"/"USD"/"$", "gratis", fixed plazos ("en 60 días", "3 meses"), invented years ("desde 1998"), statistics or percentages, reviews or testimonials, guarantees or "garantizado", "mejor" as a claim ("la mejor constructora"), team or client names, brand or competitor names.
- Images are "Imagen referencial"; never describe a photo as one of our obras.
- obra = build and execution. Design (planos, renders, estilos, carpeta municipal, cálculo estructural) belongs to arq.com.py and is mentioned only as "lo hace el estudio" (at most one sibling note per page). Wood/aluminium products (muebles, placares, puertas, aberturas, aluminio, blindex) belong to carpinteria.com.py. **Pérgolas, decks, machimbre and techos de madera are obra's own work**: write them as built by us.

## 7. Checks each agent runs before replying

```
php -l <every file you edited>
php tools/content-words.php <hub>/<child>      # 700–1,000 and 4–6 FAQs for each page
php -S localhost:8081 router.php               # in another terminal, if not running
node tools/audit.mjs http://localhost:8081 https://obra.com.py /tmp/audit-after.json
node tools/seo-diff.mjs docs/audit/audit-before.json /tmp/audit-after.json   # must print "seo-diff OK"
```
The director then runs the full `bash tools/verify.sh` (or `tools\verify.ps1`).

## 8. WhatsApp texts for new or changed pages

Agents don't edit `app/wa-messages.php`. For a **new** page, the reply lists 5 proposed texts (hero, band, sticky, header, footer) following `docs/IMPROVE-PLAN.md` §5.1: start with "Hola,", voseo, 25–160 characters, no prices/plazos/"gratis", unique across the file. Existing pages already have texts; propose a change only if the page's angle changed (e.g. /casas/minimalistas/).

## 9. Reference entry (copy the shape, not the words)

`app/content/sub/piscinas.php`, key `chicas`:

```php
    'chicas' => [
        'name' => 'Piscinas pequeñas para patios chicos',
        'title' => 'Piscinas pequeñas para patios chicos en Paraguay | Obra',
        'description' => 'Piscinas pequeñas de hormigón para patios chicos en Asunción y Gran Asunción: medidas a la medida del espacio, acceso de obra resuelto y vereda integrada.',
        'summary' => 'Construcción de piscinas pequeñas de hormigón para patios chicos en Asunción y Gran Asunción: medidas a la medida del espacio, acceso de obra resuelto y vereda integrada.',
        'h1' => 'Piscinas pequeñas para patios chicos',
        'kicker' => 'Una piscina real en pocos metros',
        'intro' => [
            'En Asunción, Fernando de la Mora, Luque o San Lorenzo los patios suelen ser chicos. Eso no impide tener una piscina de hormigón: cambia el diseño, no la calidad. Una piscina compacta bien ubicada aprovecha mejor el patio que una grande que no deja lugar para nada más.',
            'El desafío real en patios chicos es el acceso: por dónde entra la excavadora, dónde va la tierra, cómo se protege lo que ya existe. Lo resolvemos antes de cotizar.',
        ],
        'includes' => ['Diseño de medidas y forma según el patio real', 'Excavación manual o con máquina chica según el acceso', 'Estructura de hormigón armado y filtrado compacto', 'Vereda perimetral y unión con la galería', 'Iluminación y previsión de climatización'],
        'process' => [
            ['Visita y medición', 'Vamos al patio, medimos el espacio libre, los retiros a medianeras y la casa, y revisamos por dónde puede entrar un equipo. También miramos dónde caen el sol y la sombra a lo largo del día, porque eso define la ubicación más que la forma.'],
            ['Propuesta de medidas y ubicación', 'Con el relevamiento te proponemos una o dos alternativas de medidas, profundidad y forma, dibujadas sobre el plano real del patio. Ahí se ve cuánto espacio queda para vereda, reposeras, jardín o quincho.'],
            ['Presupuesto por rubro', 'Excavación y retiro de tierra, estructura, instalación hidráulica, equipo de filtrado, terminación interior, vereda e iluminación, cada uno por separado y en guaraníes. Así sabés qué cambia si achicás o agrandás algo.'],
            ['Excavación y estructura', 'Se excava con máquina chica o a mano según el acceso, se arma la estructura de hormigón y se dejan las cañerías previstas antes de hormigonar. En patios chicos se protege lo que ya existe: pisos, paredes y plantas.'],
            ['Terminaciones, prueba y entrega', 'Revestimiento interior, bordes, vereda y equipo. Se llena, se prueba la estanqueidad y el filtrado, y te explicamos el uso y el mantenimiento básico del equipo.'],
        ],
        'materials' => [
            ['Estructura de hormigón armado', 'Es la base de cualquier piscina que dure. En un patio chico conviene todavía más, porque la piscina queda cerca de paredes y medianeras y no admite movimientos.'],
            ['Terminación interior', 'Venecitas, cerámica para piscinas o revestimientos cementicios. Cambian el aspecto, la textura al pisar y el mantenimiento; te mostramos muestras antes de decidir.'],
            ['Bordes y vereda', 'Piedra, porcelanato antideslizante o cemento alisado. En poco espacio la vereda cumple doble función: circulación y lugar para sentarse, así que conviene elegir un material que no queme al sol.'],
            ['Filtrado compacto', 'Bomba y filtro dimensionados para el volumen real, en una casilla chica o un nicho junto a una pared. Se ubica donde no moleste por ruido y se pueda llegar para el mantenimiento.'],
            ['Opciones que suman', 'Escalón o banco interno para sentarse, iluminación sumergida y previsión de climatización para estirar la temporada. Se definen al principio para dejar las cañerías y la electricidad listas.'],
        ],
        'mistakes' => [
            ['Elegir la forma antes que el acceso', 'Si la máquina no entra, la excavación cambia de método y de ritmo. Por eso el acceso se resuelve en la visita, no el día que llega el equipo.'],
            ['Pegar la piscina a la medianera', 'Dejar poca distancia complica la estructura, el drenaje y la relación con el vecino. Se respeta un retiro y se prevé cómo escurre el agua de lluvia.'],
            ['Olvidar dónde va la tierra', 'Una excavación genera más volumen de tierra del que parece. Hay que prever dónde se acopia y cómo se retira sin trabar la calle ni el patio.'],
            ['Achicar la vereda al mínimo', 'Una piscina sin espacio alrededor se usa menos y ensucia más el agua. Mejor unos centímetros menos de espejo de agua y un borde cómodo.'],
            ['Dejar el equipo para después', 'Si no se define el lugar del filtro y las cañerías antes de hormigonar, después aparecen roturas y parches.'],
        ],
        'sections' => [
            ['Qué medidas tiene sentido considerar', ['No hay una medida única. Para refrescarse y jugar con chicos funciona una piscina compacta y poco profunda; para nadar unas brazadas conviene priorizar el largo sobre el ancho. En patios angostos, una forma rectangular alineada con el lado más largo del terreno suele aprovechar mejor el espacio que una forma curva.', 'También cuenta la profundidad: una parte baja con escalón y banco hace la piscina más usable para toda la familia, y una profundidad pareja simplifica la obra. Lo definimos con vos según quién la va a usar y cómo.']],
            ['Piscina chica y el resto del patio', ['En un patio chico la piscina no está sola: convive con la galería, el quincho, la parrilla, el tendedero o un sector de juego. Por eso la pensamos junto con los recorridos y las sombras, y si hace falta coordinamos en la misma obra la vereda, un deck o una pérgola para que todo quede resuelto de una vez.']],
        ],
        'ideal' => ['Tu patio tiene pocos metros y querés aprovecharlos.', 'La casa ya está construida y el acceso es angosto.', 'Querés piscina sin renunciar a un sector de quincho o jardín.'],
        'faqs' => [
            ['¿Cuál es la medida mínima razonable?', 'Depende del uso. Para refrescarse y jugar con chicos alcanza con medidas muy compactas; para nadar hace falta más largo. Lo definimos con vos sobre el plano del patio.'],
            ['¿Cómo entra la máquina si el pasillo es angosto?', 'Con equipos chicos o excavación manual. Es más lento pero habitual. El método se decide en la visita.'],
            ['¿Se puede hacer una piscina elevada?', 'Sí, cuando el suelo o el acceso lo justifican. Cambia la estructura y la terminación exterior.'],
            ['¿Una piscina chica necesita el mismo filtrado que una grande?', 'Necesita un equipo dimensionado para su volumen, que suele ser más chico y más fácil de ubicar. Lo importante es que el agua recircule bien; eso se define con la forma y la ubicación de las bocas.'],
            ['¿Se puede climatizar una piscina chica?', 'Sí, y en poco volumen de agua la climatización rinde más. Conviene dejar la previsión de cañerías y electricidad desde el principio, aunque el equipo se instale después.'],
        ],
        'related' => ['/piscinas/quinta/', '/patios/decks/', '/quinchos/'],
    ],
```
