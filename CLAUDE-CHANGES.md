# CLAUDE-CHANGES — Auditoría y correcciones de obra-com-py-manual

Fecha: 2026-09-01. Original intacto en `../obra-com-py` (comparar con `diff -r`).
Todo sigue siendo PHP/HTML/CSS/JS vanilla, sin build step ni base de datos. Se despliega descomprimiendo el zip en `public_html/`.

A mitad de la auditoría se recibió `obra-com-py-site-structure.md` (copiado a `docs/`). Define slugs cortos, posicionamiento llave en mano, número de WhatsApp de etapa 1, dos preguntas de calificación en el formulario y los límites de marca con arq.com.py y carpinteria.com.py. El sitio se alineó a ese documento además de corregir lo encontrado.

Nota sobre el encargo: el brief mencionaba "pozos artesianos". Ni el contenido ni los docs del sitio ofrecen ese servicio; en el documento de estructura los pozos van a pozo.com.py. Se dejó como enlace cruzado desde `/quintas/` (desactivado hasta que el dominio exista), no como servicio propio.

## 1. Técnico

- **Sitemap estático que tapaba al dinámico.** `sitemap.xml` (lastmod fijo 2026-08-29) se servía antes que `sitemap.php` por la regla `-f` de `.htaccess`, y `router.php` hacía lo mismo en local. Se eliminó el archivo; `.htaccess` reescribe `/sitemap.xml` → `sitemap.php`, `/sitemap.php` redirige 301 a `/sitemap.xml`, `sitemap.php` agrega `lastmod` (fecha de modificación real de los archivos de contenido) y `X-Robots-Tag: noindex`. El empaquetador falla si reaparece un `sitemap.xml` estático.
- **CSP rompía el salto a WhatsApp en Chrome.** `form-action 'self'` bloquea el 303 de `form.php` hacia `wa.me` (Chrome aplica form-action a las redirecciones de un envío). Se añadió `https://wa.me`. También se permitieron los hosts de GA4 en `img-src` y `connect-src`.
- **URLs duplicadas.** `/piscinas` y `/piscinas/` devolvían 200 ambas. Ahora 301 a la versión con barra. Las URLs viejas (`/servicios/<slug>/`, `/contacto/`) redirigen 301 a las nuevas.
- **`.htaccess`:** eliminada la regla muerta `^form\.php$`; orden correcto de condiciones HTTPS/www; 404 para `app/`, `config/`, `docs/`, `tools/`; `AddDefaultCharset UTF-8`; `mod_expires` para estáticos; cabeceras de seguridad solo para estáticos (las páginas PHP ya las emiten, se evitaba duplicarlas); `router.php`, `local.php` y `.env*` denegados.
- **`router.php` / `index.php`:** el bloque `cli-server` de `index.php` (que nunca se ejecutaba vía router) se movió a `router.php`, que ahora imita todas las reglas de Apache.
- **Configuración desplegable sin editar código:** `config/site.php` fusiona `config/local.php` (plantilla en `config/local.example.php`, bloqueado por `.htaccess`). Hostinger compartido no siempre expone variables de entorno.
- **Formulario:**
  - Nuevos campos obligatorios `terrain` y `financing` (según el documento de estructura); viajan en `fields` del payload al CRM (contrato del endpoint sin cambios) y en el mensaje de WhatsApp.
  - Tercer canal: aviso por `mail()` al email configurado (mejor esfuerzo, nunca bloquea). Estado `enviado` ahora es alcanzable.
  - Longitud mínima con `mb_strlen` (antes `strlen` contaba bytes de acentos), `page_url` validada contra el origen, el nombre va en el mensaje de WhatsApp, el servicio elegido se conserva al volver con error, mensajes de error distintos para `tiempo` y `campos`.
  - Inputs ocultos `kind` y `source` (ignorados por el servidor) eliminados.
- **JS:** el botón "Enviando…" se restaura con `pageshow` (antes quedaba deshabilitado al volver atrás); `localStorage` envuelto en try/catch; eventos GA4 `whatsapp_click`, `generate_lead`, `form_confirmed`; foco al primer enlace al abrir el menú; Escape solo cierra si está abierto.
- **HTML:** `width`/`height` reales por imagen (los `servicio-*.webp` son 1000×750, se declaraban 1600×900); `fetchpriority="high"` en imágenes de hero; `theme-color`; breadcrumbs como `<ol>` con `aria-current`; flechas decorativas con `aria-hidden`; `Contacto/Cotizar` presente en el menú móvil (antes no había forma de llegar al formulario desde el menú en móvil).
- **OG image:** `og-obra.png` (729 KB, sin usar) convertido a `og-obra.jpg` (65 KB, 1200×630) y usado como `og:image`; WhatsApp no previsualiza bien WebP ni imágenes pesadas. `og-construccion.webp` eliminado por quedar sin uso.
- **Copia interna filtrada al público** (corregido): "Datos comerciales pendientes / antes de publicar…", "Pendiente de configuración", "El servidor solo confirma una captura cuando…", "Configurá WhatsApp o CRM antes de usar este formulario en producción". Ahora los datos legales solo se muestran si existen y los estados de `/gracias/` hablan al visitante.
- **CSS:** eliminados los parches al final del archivo (`.image-band` con `100vw` sobrescrito, segundo bloque `.site-nav`), variable `--radius` sin uso, transición de visibilidad del menú móvil, estilos de impresión.
- **`tools/qa.ps1`:** archivo sin BOM con patrones acentuados → Windows PowerShell 5.1 lo leía como ANSI y el patrón `Construcción de piscinas de hormigón` nunca podía coincidir. Ahora se guarda con BOM, los patrones son ASCII, el HTML se decodifica explícitamente como UTF-8, las redirecciones se comprueban con `HttpWebRequest` (Invoke-WebRequest 5.1 lanza excepción con `-MaximumRedirection 0`), se evita la variable reservada `$home`, y cubre 301, 404 de `app/`, schemas, sitemap completo, robots y tres escenarios de POST al formulario. Ejecutado: 22 rutas, guardrails OK.
- **`tools/package-hostinger.ps1`:** fecha dinámica en el nombre, lista de archivos actualizada (sin `sitemap.xml`, con `og-obra.jpg` y `local.example.php`), verificación de que ninguna entrada usa `\`. Ejecutado: 20 entradas, zip válido.

## 2. SEO

- **Estructura de URLs** según el documento: `/casas/`, `/quintas/`, `/piscinas/`, `/quinchos/`, `/reformas/`, `/ampliaciones/`, `/patios/`, `/tinglados/`, `/muros/`, `/cocinas-banos/`, `/comerciales/`, `/supervision/`, `/presupuesto/`, `/cotizar/`. Tres páginas nuevas (ampliaciones, supervisión, presupuesto). `/credito/` y `/obras/` quedan pendientes (necesitan datos de AFD verificados y obras reales).
- **Titles y H1:** patrón "keyword + en Paraguay"; home "Construcción llave en mano en Paraguay | Constructora Obra" con H1 "Construimos tu casa de principio a fin, llave en mano." Descriptions con "constructora en Asunción y Gran Asunción" y CTA de WhatsApp.
- **Schema:** `GeneralContractor` con `@id`, `image`, `areaServed` (Gran Asunción + Paraguay), `legalName`/`taxID` cuando existen; `Service` con `serviceType`, `image` y `provider` por `@id`; `FAQPage` de la home ahora generado desde el mismo array que se muestra (antes el schema tenía 2 preguntas con texto distinto al visible); `BreadcrumbList` sin cambios.
- **Sitemap dinámico con `lastmod`**, `/gracias/` excluido; `robots.txt` con `Disallow: /form.php` y `/gracias/`.
- **Enlazado interno:** menú con las tres anclas (Casas, Piscinas, Quinchos) + Cotizar; home muestra los 6 servicios prioritarios y el contador real; relacionados por servicio; un solo enlace contextual por página a arq / carpinteria / pozo / prestamo (los dos últimos sin enlace hasta activarlos en `config/site.php`).
- **Alt text** reescrito donde era genérico y sin keyword stuffing.

## 3. Copy (español paraguayo, voseo)

- Home: H1 y bajada con la promesa llave en mano; banda de confianza con hechos verificables (presupuesto por escrito en guaraníes, reportes por etapa); sección nueva "Quién construye" (responsable de obra, oficios coordinados, grupo de tres sitios) sin años ni nombres inventados.
- Proceso pasa a 5 pasos (terreno → proyecto → presupuesto → obra → entrega) sin plazos inventados.
- FAQ: se eliminaron respuestas meta ("No publicamos una condición que todavía no fue configurada comercialmente"); se añadieron preguntas de financiación (crédito/AFD), zona y temporada de piscinas.
- Formulario: etiquetas en pregunta ("¿Qué querés construir?"), consentimiento con enlace a privacidad, botón "Enviar y seguir por WhatsApp", pie explicando qué pasa al enviar.
- `/cotizar/`, `/nosotros/`, `/privacidad/`, `/gracias/`, 404: reescritos para hablarle al cliente y no al desarrollador. Privacidad ahora cubre cookies, sitios del grupo y derechos.
- Sin precios, sin estadísticas, sin reseñas, sin garantías concretas.

## 4. Oferta y mercado

- Servicios del contenido real (construcción/remodelación) alineados con `docs/SEO-RESEARCH.md` y con la tabla de prioridad del documento de estructura. Se sumaron supervisión/fiscalización y presupuesto/cómputo métrico (servicios de obra que captan leads a mitad de proyecto).
- Cobertura: "Asunción y Gran Asunción, resto del país según proyecto" (config `area`).
- WhatsApp configurado por defecto con el número oficial (+595 992 279 599; el número de etapa 1 anterior, reemplazado), por lo que todos los CTA van a WhatsApp con mensaje contextual; el formulario queda como alternativa ("Prefiero el formulario").
- Calificación de leads: las dos preguntas del documento están en el formulario y llegan al CRM.
- Sin páginas de ciudad; sin categoría de "reparaciones varias".

## 5. Diseño

- Contraste: rust `#bb4b22` → `#a63f1c` (4.5 → 5.6 sobre papel, 6.3 con texto blanco); texto de la banda de contacto `#f8ddd3` → `#fff4ef` (3.9 → 5.8); borde de campos `#aaa69e` → `#8a867d` (2.4 → 3.6); muted ligeramente más oscuro.
- Tamaños mínimos subidos (eyebrows, botones, navegación, pie: de 11–12 px a 12–14 px); h1 móvil bajado a 2.6 rem para evitar cortes de palabra; `text-wrap: balance` en títulos.
- Bento de servicios: la sexta tarjeta ocupa dos columnas (antes quedaba una celda vacía en escritorio).
- Menú móvil con CTA verde "Cotizar", icono hamburguesa animado, enlace activo subrayado en escritorio, hovers consistentes, botón claro con borde, estado visible del foco en `summary`.
- Nuevos bloques: nota "Del mismo grupo", "Quién construye", "Un grupo, tres oficios" en Nosotros, "Contacto directo" en Cotizar.
- Verificado en el navegador a 1280 y 390 px: sin scroll horizontal, sin errores de consola.

## 6. Ampliación: más páginas para SEO (segunda pasada, mismo día)

Pedido: más páginas, menú de servicios con submenú/sub-submenú, mejorar el documento de estructura si se puede sacar más valor del tráfico.

- **Arquitectura hub-and-spoke**, respetando la regla de URLs cortas (máximo dos niveles, ≤15 caracteres por segmento):
  - 12 hubs de servicio agrupados en cuatro familias (`groups` en `app/content.php`): construcción nueva, exteriores y patio, reformas y ampliaciones, servicios técnicos.
  - 29 especialidades en `app/content-sub.php` (`/casas/duplex/`, `/casas/minimalistas/`, `/casas/etapas/`, `/casas/prefabricadas/`, `/quintas/refaccion/`, `/quintas/casa-campo/`, `/piscinas/chicas/`, `/piscinas/quinta/`, `/piscinas/desbordante/`, `/piscinas/renovacion/`, `/quinchos/cerrados/`, `/quinchos/parrillas/`, `/quinchos/techo-madera/`, `/reformas/cocinas/`, `/reformas/banos/`, `/reformas/fachadas/`, `/reformas/techos/`, `/ampliaciones/planta-alta/`, `/ampliaciones/dormitorio/`, `/ampliaciones/galeria/`, `/patios/veredas/`, `/patios/decks/`, `/patios/pergolas/`, `/tinglados/galpones/`, `/tinglados/cocheras/`, `/muros/portones/`, `/comerciales/locales/`, `/comerciales/oficinas/`, `/supervision/direccion/`). Cada una con intro propia, qué incluye, cuándo conviene, 3 FAQ, hermanas y relacionados. `cocinas-banos` dejó de ser hub y pasó a `/reformas/cocinas/` + `/reformas/banos/` (301 desde la URL vieja).
  - 8 guías en `app/content-guides.php`: `/guias/costo-casa/`, `/guias/terreno/`, `/guias/plazos/`, `/guias/permisos/`, `/guias/platea/`, `/guias/ladrillo-bloque/`, `/guias/albanil/` y `/credito/` (la página de financiación del documento, escrita como explicación general de desembolsos, presupuesto para el banco y profesional responsable, sin tasas ni requisitos concretos de AFD). Cubren los términos informativos de la lista KWP (cuanto cuesta construir, presupuesto de obra, albañil/maestro de obra, platea, mampostería, crédito/AFD).
  - Total: 56 URLs indexables (antes 20). `/obras/` sigue pendiente hasta tener obras reales.
- **Menú:** "Servicios" abre un panel de tres niveles (grupo > servicio > especialidad, 42 enlaces) y "Guías" abre la lista de guías. Escritorio: hover, foco de teclado o clic en la flecha (`aria-expanded`), cierre con Escape o clic fuera. Móvil: panel con acordeones. Todo HTML real, rastreable sin JS. Footer con todos los hubs y todas las guías.
- **Páginas:** los hubs muestran una sección "Especialidades" enlazando a sus subpáginas; `/servicios/` es un índice agrupado con chips de especialidades; `/guias/` es el índice de guías; la home tiene un bloque de guías. Las guías usan un layout de artículo con índice lateral pegajoso y CTA.
- **SEO:** schema `Service` con `isRelatedTo` al hub en especialidades, `Article` + `FAQPage` en guías, `BreadcrumbList` de tres niveles, sitemap automático (56 URLs), títulos únicos y ≤65 caracteres, todos los enlaces internos verificados (58 destinos, 0 rotos).
- **Herramientas:** `tools/qa.ps1` ahora lee las URLs del sitemap (cubre páginas nuevas sin editar la lista); `tools/package-hostinger.ps1` incluye los dos archivos de contenido nuevos.
- **Compatibilidad:** `mb_strtolower` protegido con `function_exists` (el PHP local no tiene mbstring; Hostinger sí).

Nota: durante esta pasada aparecieron cambios en disco en `app/content.php` y `app/routes.php` que no hice yo (se perdieron dos líneas del array de contenido y cambió una redirección). Otra sesión parece estar trabajando en la misma carpeta. Los reapliqué y verifiqué; conviene no editar la carpeta desde dos sesiones a la vez.

## Verificación

- `php -l` sin errores en todos los archivos; las 56 URLs del sitemap devuelven 200 con un solo H1 y sin avisos PHP; 301 desde URLs viejas y sin barra final; 58 enlaces internos comprobados.
- `tools/qa.ps1`: 59 rutas, guardrails OK (incluye POST al formulario).
- `tools/package-hostinger.ps1`: zip generado en `../obra-com-py-hostinger-ready-2026-09-01.zip`, 22 entradas, sin barras invertidas.
- Navegador: mega menú en escritorio (1280 px), acordeón en móvil (390 px, sin scroll horizontal), hub `/casas/`, guía `/guias/costo-casa/` e índice `/servicios/` revisados; consola sin errores.

## Pendiente para el usuario

- Crear `config/local.php` en Hostinger con email, RUC, razón social, domicilio y CRM.
- Confirmar que el número de WhatsApp de etapa 1 es el que atenderá.
- Activar `pozo` y `prestamo` en `partner_sites` cuando existan.
- Decidir `/credito/` y `/obras/` tras el Keyword Planner y con obras reales.
