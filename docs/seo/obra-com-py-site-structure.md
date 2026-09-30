# obra.com.py — Page & SEO Structure

**Positioning:** the family building operation's flagship — "construimos de principio a fin, llave en mano."
Not a directory. Sells full builds: casas, piscinas, quinchos, quintas, reformas. 

**Brand boundary:** obra = execution (concrete, brick, delivery). arq.com.py = design (planos, renders, carpeta municipal).
Obra pages can say "incluye planos y aprobación" inside the llave-en-mano offer, but plan/design keywords are optimized on arq, not here.
Supervision/fiscalización/ingeniería de obra = construction-side services → they DO belong here.

**URL rule:** short slugs, max 2 levels, Ads display-path friendly (≤15 chars/segment).

**Conventions:** WhatsApp-first (+595 992 279 599, único número), no prices, PYG only, Gran Asunción coverage language,
imagery de obras/equipo sin nombres. Every form asks: ¿Ya tenés terreno? + ¿Cómo pensás financiar?

---

## Site architecture (sitio en vivo: 56 URLs)

Fuente: app/routes.php, app/content.php, app/content/sub/{hub}.php, app/content/guides/{slug}.php. /gracias/ existe pero es noindex y no cuenta.

**7 páginas fijas**
```
/                    Home
/servicios/          Índice de servicios
/guias/              Índice de guías
/como-trabajamos/    Proceso: terreno, proyecto, presupuesto, obra, entrega
/cotizar/            Cotización por WhatsApp / formulario
/nosotros/           Sobre Obra
/privacidad/         Política de privacidad
```

**12 hubs con 29 especialidades**
```
/casas/              ★ /casas/duplex/ /casas/minimalistas/ /casas/etapas/ /casas/prefabricadas/
/quintas/            /quintas/refaccion/ /quintas/casa-campo/
/piscinas/           ★ /piscinas/chicas/ /piscinas/quinta/ /piscinas/desbordante/ /piscinas/renovacion/
/quinchos/           ★ /quinchos/cerrados/ /quinchos/parrillas/ /quinchos/techo-madera/
/reformas/           /reformas/cocinas/ /reformas/banos/ /reformas/fachadas/ /reformas/techos/
/ampliaciones/       /ampliaciones/planta-alta/ /ampliaciones/dormitorio/ /ampliaciones/galeria/
/patios/             /patios/veredas/ /patios/decks/ /patios/pergolas/
/tinglados/          /tinglados/galpones/ /tinglados/cocheras/
/muros/              /muros/portones/
/comerciales/        /comerciales/locales/ /comerciales/oficinas/
/supervision/        /supervision/direccion/
/presupuesto/        (sin especialidades)
```

**/guias/ con 7 guías**
```
/guias/costo-casa/  /guias/terreno/  /guias/plazos/  /guias/permisos/
/guias/platea/  /guias/ladrillo-bloque/  /guias/albanil/
/credito/            Guía cuyo path es /credito/ (financiar la obra; enlaza prestamo.com.py como texto hasta que esté vivo)
```

Total: 7 + 12 + 29 + 8 = 56.

**/obras/ (portfolio): diferido: solo con fotos reales autorizadas de obras propias.** No está en vivo, no construir.

## Page template (service pages)

1. H1: primary keyword + "en Paraguay" / "en Asunción"
2. Hero: llave-en-mano promise + WhatsApp CTA
3. Qué incluye (for /casas/: platea, mampostería, techo, instalaciones, terminaciones, planos y aprobación incluidos)
4. Proceso en 4–5 pasos (no prices, no fixed plazos)
5. "Quién construye": equipo y red de subcontratistas (sin nombres)
6. FAQ + FAQPage schema: plazos, zonas, financiación, materiales
7. WhatsApp CTA repeated; /cotizar/ form with the two qualifying questions

## Service priority & routing

| # | Page | Note |
|---|------|------|
| 1 | /casas/ | Core family-operation offer |
| 2 | /quintas/ | Cross-sell pozo + piscina + quincho |
| 3 | /piscinas/ | Seasonal spike Sep–Dec |
| 4 | /quinchos/ | Classic second project; techos de madera y machimbre son de obra |
| 5 | /reformas/ /ampliaciones/ | Different search language than new build |
| 6 | /tinglados/ /patios/ | Volume + B2B (tinglados) |
| 7 | /supervision/ /presupuesto/ | Catches people mid-project; presupuesto = lead magnet |

## Lead routing (per form answers)

- Tiene terreno + fondos propios → family WhatsApp same day (hottest)
- Tiene terreno + crédito → /credito/ nurture track, hand over at pre-approval
- Sin terreno → terreno.com.py / inmobiliaria inventory, tag + 30/60/90-day follow-up
- Fuera de zona / bajo ticket / sobre capacidad → surplus pool (sell only once partner builders signed)

## KWP check list (70 terms, 1–3 words)

construccion, constructora, constructoras, empresa constructora, construccion de casas, casas llave en mano, llave en mano, construir casa, construccion paraguay, constructora asuncion
casas prefabricadas, casas premoldeadas, construccion de viviendas, cuanto cuesta construir, costo de construccion, precio construccion, presupuesto de obra, computo metrico, piscinas, construccion de piscinas
piletas, construccion de piletas, piscinas de hormigon, piscinas paraguay, quincho, quinchos, construccion de quincho, quincho con parrilla, parrillas, quintas
casas de campo, construccion de quintas, reformas, remodelaciones, reforma de casa, remodelacion de casa, ampliaciones, ampliacion de casa, refaccion, refacciones
tinglados, galpones, construccion de tinglados, patios, veredas, muros, muro perimetral, contrapiso, platea, mamposteria
albañil, albañileria, maestro de obra, ingeniero civil, supervision de obra, fiscalizacion de obra, direccion de obra, obras civiles, credito para construir, credito vivienda
afd, credito afd, che roga, financiacion vivienda, construir en terreno, casas modernas, casas minimalistas, duplex, townhouse, plano y construccion

*Terms 59–62 (credito/AFD) inform /credito/ page copy; if volumes are big they may justify pages on prestamo.com.py instead — decide after KWP.*

## SEO notes

- "construccion", "constructora", "casas llave en mano" are the head terms — home + /casas/ carry them.
- /piscinas/ and /quinchos/ compete with future dedicated EMDs (piscinas.com.py, quincho.com.py). If you later buy those, they become satellite lead-gen feeding the same pipeline; obra keeps the full-service angle. Don't duplicate content between them.
- Cross-links: /quintas/ → pozo.com.py; /quinchos/cerrados/ → carpinteria.com.py (aberturas/aluminio); el machimbre y los techos de madera son de obra; /credito/ → prestamo.com.py; "necesitás planos" mention → arq.com.py. One contextual link per page.
- Schema: LocalBusiness + Service; FAQPage.
- Imagery: obra en construcción con ladrillo visto, equipo paraguayo en obra (sin nombres), casa terminada estilo PY moderno, piscina de hormigón en quinta.

## División SEO entre sitios del grupo

- **obra = construcción y ejecución**: construcción, constructora, llave en mano, obra gruesa, piscinas, quinchos, quintas, reformas, ampliaciones, tinglados, muros, patios, supervisión/fiscalización, presupuesto/cómputo, crédito para construir. Pérgolas, decks y machimbre/techos de madera también viven en obra.
- **arq.com.py = diseño**: planos, diseño, anteproyecto, renders, carpeta municipal, aprobación de planos, regularización, cálculo estructural, interiores, paisajismo y todos los términos de estilo (casas minimalistas, casas modernas, fachadas modernas, casas de dos pisos, planos de dúplex, diseño de quinchos/piscinas).
- **carpinteria.com.py = solo productos de madera y aluminio**: muebles, cocinas a medida, placares, puertas, aberturas, aluminio, blindex. Sus páginas de pérgolas, decks y machimbre se enrutan a obra.
- Como máximo un enlace contextual a un sitio hermano por página, solo donde la siguiente necesidad del visitante es realmente del hermano. Las frases de marca y de competidores nunca tienen página.
