# Checklist de lanzamiento — Obra.com.py

## Identidad y contacto

- [x] WhatsApp configurado por defecto (`595992279599`, único número; ver `docs/seo/obra-com-py-site-structure.md`). `tools/check-wa.mjs` falla ante cualquier otro número en el sitio o el repo.
- [ ] Crear `config/local.php` en el servidor con email, razón social, RUC y domicilio reales.
- [ ] Confirmar la zona principal (`area`, por defecto "Asunción y Gran Asunción").
- [ ] Documentar condiciones reales de pago y garantía antes de publicarlas.

## Leads y medición

- [ ] Crear la entrada del sitio en VenderCRM y guardar la API key solo en `config/local.php`.
- [ ] Enviar un lead real y verificar contacto, negocio y los campos `terrain` y `financing` en `fields`.
- [ ] Verificar que llega el aviso por email (`mail()` de Hostinger) al buzón configurado.
- [-] GA4: omitido por decisión de Anton (`analytics_id` queda vacío; no se carga Google Analytics).
- [ ] Probar el envío desde Chrome: la redirección a `wa.me` depende de `form-action` en la CSP.

## Contenido y prueba

- [ ] Reemplazar imágenes referenciales con obras reales autorizadas cuando existan (ver `IMAGE-PRODUCTION.md`).
- [ ] Agregar reseñas únicamente con fuente y permiso.
- [ ] Confirmar que los 13 servicios se ofrecen realmente (supervisión y presupuesto son nuevos).
- [ ] Pasar `partner_sites.pozo` y `partner_sites.prestamo` a `live => true` cuando esos dominios estén publicados.
- [ ] Agregar a `partner_sites.arq.live_paths` / `partner_sites.carpinteria.live_paths` (config/site.php) cada ruta hermana confirmada con HEAD 200 (`/minimalista/`, `/carpeta/`, `/estructural/`, `/regularizacion/`, `/estilos/`, `/comercial/`, `/aluminio/`, `/ventanas/`, `/cocinas/`, `/portones/`). Hasta entonces se muestran como texto.
- [ ] Decidir `/credito/` y `/obras/` después del Keyword Planner y con obras reales.

## Hostinger

- [ ] Subir el contenido del zip a `public_html/` (`index.php` y `.htaccess` en la raíz). No subir `sitemap.xml` estático ni `router.php`.
- [ ] Verificar PHP 8.1+ y extensiones `curl` y `mbstring`.
- [ ] Abrir todas las rutas y las redirecciones 301 (`/contacto/`, `/servicios/piscinas/`, `/piscinas`) en el dominio real.
- [ ] Verificar canonical, `/sitemap.xml` (dinámico) y `/robots.txt` en producción; `/app/` y `/config/` deben dar 404.
- [ ] Purgar caché y volver a comprobar el HTML servido.
- [ ] Confirmar redirección HTTPS y dominio sin `www`.
- [-] Search Console: omitido por decisión de Anton.

## Estado de esta entrega

- [x] 56 URLs indexables renderizadas (12 hubs + 29 especialidades + 8 guías + 7 páginas fijas), sin avisos PHP; todos los enlaces internos verificados.
- [x] Menú de servicios en tres niveles y menú de guías, verificados en escritorio y móvil.
- [x] SEO técnico: canonical, 301 sin barra final y desde URLs viejas, sitemap dinámico con lastmod, schemas `GeneralContractor` + `Service` + `FAQPage` + `BreadcrumbList`.
- [x] Responsive verificado a 390 y 1280 px, sin scroll horizontal.
- [x] Formulario con validación, honeypot, dos preguntas de calificación y salto a CRM + email + WhatsApp.
- [x] `tools/qa.ps1` y `tools/package-hostinger.ps1` ejecutados con éxito.
- [ ] Publicación en Hostinger no realizada ni verificada.

## Fundación 2026-09-30 (sesión 1)

- [x] `tools/verify.sh` / `tools/verify.ps1` en verde: php -l, 56 rutas 200, 14 redirecciones 301, rutas internas 404, matriz del formulario (mock success/fail/sin definir), check-wa, audit + seo-diff contra `docs/audit/audit-before.json`, Playwright 1366 y 390.
- [x] Mapa de mensajes de WhatsApp (`app/wa-messages.php`), sin selector "¿Cómo seguimos?", barra fija móvil, enlace `tel:`.
- [x] Contenido partido en `app/content/sub/` y `app/content/guides/` (HTML idéntico antes/después).
- [x] 30 meta descriptions ≤155 caracteres (`docs/audit/approved-changes.json`).
- [x] Imágenes con `srcset` 480/960; `og-obra.png` eliminado.
- [x] Sitemap con `lastmod` por página.
- [x] Especificación de contenido y briefs para la sesión 2 (`docs/seo/CONTENT-SPEC.md`, `docs/seo/content-briefs/`).
- [ ] Páginas de confianza (/nosotros/, /como-trabajamos/, /cotizar/) con datos reales: esperan los datos públicos del negocio (D8).
- [ ] Verificación en vivo después del deploy (el entorno de nube no llega a obra.com.py): ver los comandos en `docs/reports/BUILD-REPORT-20260930-foundation.md`.
- [ ] Si el deploy es por zip: al subir, los archivos viejos `app/content-sub.php` y `app/content-guides.php` pueden borrarse del servidor (ya no se usan; igual quedan bloqueados por .htaccess).

## Sesión de cierre 2026-09-30
- [x] Enlace a carpinteria corregido: `/aberturas/` no existe; ahora `/ventanas/` (quinchos cerrados).
- [x] `/casas/minimalistas/` ya es una página de construcción con un solo enlace a arq; el selector "¿Cómo seguimos?" ya no existe (un toque a WhatsApp).
- [ ] Verificación en vivo (O1): NO EJECUTADA, obra.com.py no es alcanzable desde el contenedor (403 del proxy).
- [ ] `live_paths` de arq y carpinteria: siguen vacíos hasta confirmar HEAD 200 en vivo (`/aluminio/ /ventanas/ /cocinas/ /portones/` en carpinteria).
- [ ] Datos públicos del negocio (D8) y páginas de confianza: sin datos, NO EJECUTADO.
- [x] Deploy: Git auto-deploy desde `main` (confirmado por Anton): cada merge publica.
- [x] Endpoint de VenderCRM por defecto en `config/site.php` (`https://crm.clientes.com.py/api/v1/leads`). Falta solo `crm_api_key` en `config/local.php` del servidor (archivo no versionado; Git deploy no lo toca).
- [ ] Imágenes con Higgsfield (presupuesto 50 créditos): NO EJECUTADO, el contenedor no descarga de `*.cloudfront.net` (403). Ver `higgsfield-image-pipeline`, Rule 2.
- [x] /nosotros/ y /como-trabajamos/: experiencia del responsable de obra (más de 20 años) y equipo propio numeroso, sin cifras ni nombres inventados. Razón social, RUC, email y domicilio siguen vacíos hasta `config/local.php`.
