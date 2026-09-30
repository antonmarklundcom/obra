# SEO y Google Ads — Obra.com.py

La fuente de verdad para páginas, keywords y límites de marca del grupo es `obra-com-py-site-structure.md` (misma carpeta). Este archivo resume las decisiones aplicadas en el sitio.

## Decisión de arquitectura

La home posiciona los términos de cabecera: "construcción", "constructora", "casas llave en mano" con la promesa "construimos de principio a fin, llave en mano". Cada servicio tiene una URL propia de un nivel (`/casas/`, `/piscinas/`, …) que funciona como landing orgánica y como URL final de un grupo de anuncios. Slugs de máximo 15 caracteres para la ruta visible de Ads.

Google Ads recomienda alinear estrechamente palabra clave, anuncio, CTA y landing. Por eso no se envía todo el tráfico a la home.

## Arquitectura hub-and-spoke (ampliación sobre el documento base)

El documento base preveía ~15 páginas. Para capturar más tráfico sin perder la regla de URLs cortas, cada servicio es un **hub** con **especialidades** debajo (`/{servicio}/{sub}/`), y las búsquedas informativas van a **guías** (`/guias/{slug}/` y `/credito/`):

- Hub = keyword de cabecera ("construcción de piscinas"). Especialidad = intención distinta que el hub no puede cubrir sin diluirse ("piscinas pequeñas para patios chicos", "piscinas desbordantes", "renovación de piscinas").
- Cada especialidad tiene copy propio (intro, qué incluye, cuándo conviene, 3 FAQ) y enlaza a sus hermanas y a su hub; el hub enlaza a todas sus especialidades. Así el hub concentra autoridad y las especialidades captan long tail.
- Las guías atacan los términos de investigación de la lista KWP (cuánto cuesta construir, presupuesto de obra, albañil/maestro de obra/constructora, platea, mampostería, crédito/AFD) y terminan siempre en cotizar. Sin cifras de precio ni plazos.
- Menú "Servicios" en tres niveles (grupo > servicio > especialidad) y menú "Guías", ambos HTML real rastreable. `/servicios/` es el índice agrupado.

Regla para agregar páginas: solo cuando la intención de búsqueda es distinta y hay copy propio. No crear variantes por ciudad ni por sinónimo (piletas/piscinas se resuelve en el mismo texto).

Total actual: 12 hubs, 29 especialidades, 8 guías, 7 páginas fijas = 56 URLs indexables.

## Límites de marca dentro del grupo

- **obra.com.py = ejecución** (platea, mampostería, techo, instalaciones, entrega). Supervisión, fiscalización y presupuesto de obra son servicios de obra y viven acá.
- **arq.com.py = diseño** (planos, renders, carpeta municipal). Obra puede decir "planos y aprobación incluidos" dentro de llave en mano, pero no optimiza keywords de diseño.
- **carpinteria.com.py = madera** (techos de madera, machimbre, aberturas, muebles).
- Un solo enlace contextual por página: `/casas/` → arq, `/quinchos/` → carpinteria, `/quintas/` → pozo.com.py, `/presupuesto/` → prestamo.com.py. Los dos últimos se activan en `config/site.php` cuando los dominios estén publicados.

## Servicios y prioridad

| Página | Ticket | Nota |
|---|---|---|
| `/casas/` | Máximo | Oferta central; H1 con "llave en mano en Paraguay" |
| `/quintas/` | Muy alto | Cross-sell pozo + piscina + quincho |
| `/piscinas/` | Alto | Pico estacional sep–dic; FAQ recomienda consultar antes de septiembre |
| `/quinchos/` | Alto | Segundo proyecto clásico; techo de madera → carpinteria |
| `/reformas/` `/ampliaciones/` | Medio-alto | Lenguaje de búsqueda distinto al de obra nueva |
| `/tinglados/` `/patios/` `/muros/` | Medio | Volumen + B2B (tinglados) |
| `/cocinas-banos/` `/comerciales/` | Medio | Intención clara, cotizable |
| `/supervision/` `/presupuesto/` | Bajo directo, alta calificación | Captan gente a mitad de proyecto; presupuesto = lead magnet |

No se abre una categoría amplia de "reparaciones varias": mezcla intenciones y atrae trabajos pequeños.

## Calificación de leads

El formulario pregunta siempre **¿Ya tenés terreno?** y **¿Cómo pensás financiar?** y las respuestas viajan al CRM en `fields.terrain` y `fields.financing`. Ruteo previsto:

- Tiene terreno + fondos propios → WhatsApp familiar el mismo día.
- Tiene terreno + crédito → seguimiento de financiación (futura `/credito/` y prestamo.com.py).
- Sin terreno → inventario de terrenos / inmobiliaria, seguimiento 30/60/90 días.
- Fuera de zona o bajo ticket → bolsa de excedentes.

## Estructura sugerida de Google Ads

- Un grupo/campaña por servicio prioritario; la palabra clave principal aparece en el anuncio y en el H1 de la landing.
- CTA consistente: `Cotizar por WhatsApp`.
- Mensaje de WhatsApp contextual por landing (ya implementado).
- Concordancia exacta y de frase al inicio; revisar términos de búsqueda y agregar negativas.
- Conversiones: `whatsapp_click`, `generate_lead` (envío) y `form_confirmed`, separadas.

No usar afirmaciones como "mejor", "garantizado", "presupuesto gratis" ni plazos fijos hasta que sean hechos comerciales verificables. Sin precios publicados; moneda siempre guaraníes.

## Próxima investigación con datos reales

Correr Keyword Planner para Paraguay con la lista de 70 términos del documento de estructura y decidir con datos: `/credito/` (AFD, Che Róga) en obra o en prestamo.com.py, y si conviene separar más `/reformas/` de `/ampliaciones/`.

Las páginas de ciudad se crean solo para zonas realmente atendidas y con contenido local propio. No crear series de páginas casi idénticas por ciudad.
