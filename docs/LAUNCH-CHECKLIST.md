# Checklist de lanzamiento — Obra.com.py

## Identidad y contacto

- [x] WhatsApp etapa 1 configurado por defecto (`595992279599`, según `obra-com-py-site-structure.md`). Confirmar que es el número que atenderá los leads.
- [ ] Crear `config/local.php` en el servidor con email, razón social, RUC y domicilio reales.
- [ ] Confirmar la zona principal (`area`, por defecto "Asunción y Gran Asunción").
- [ ] Documentar condiciones reales de pago y garantía antes de publicarlas.

## Leads y medición

- [ ] Crear la entrada del sitio en VenderCRM y guardar la API key solo en `config/local.php`.
- [ ] Enviar un lead real y verificar contacto, negocio y los campos `terrain` y `financing` en `fields`.
- [ ] Verificar que llega el aviso por email (`mail()` de Hostinger) al buzón configurado.
- [ ] Configurar GA4 y marcar `whatsapp_click`, `generate_lead` y `form_confirmed` como conversiones.
- [ ] Probar el envío desde Chrome: la redirección a `wa.me` depende de `form-action` en la CSP.

## Contenido y prueba

- [ ] Reemplazar imágenes referenciales con obras reales autorizadas cuando existan (ver `IMAGE-PRODUCTION.md`).
- [ ] Agregar reseñas únicamente con fuente y permiso.
- [ ] Confirmar que los 13 servicios se ofrecen realmente (supervisión y presupuesto son nuevos).
- [ ] Pasar `partner_sites.pozo` y `partner_sites.prestamo` a `live => true` cuando esos dominios estén publicados.
- [ ] Decidir `/credito/` y `/obras/` después del Keyword Planner y con obras reales.

## Hostinger

- [ ] Subir el contenido del zip a `public_html/` (`index.php` y `.htaccess` en la raíz). No subir `sitemap.xml` estático ni `router.php`.
- [ ] Verificar PHP 8.1+ y extensiones `curl` y `mbstring`.
- [ ] Abrir todas las rutas y las redirecciones 301 (`/contacto/`, `/servicios/piscinas/`, `/piscinas`) en el dominio real.
- [ ] Verificar canonical, `/sitemap.xml` (dinámico) y `/robots.txt` en producción; `/app/` y `/config/` deben dar 404.
- [ ] Purgar caché y volver a comprobar el HTML servido.
- [ ] Confirmar redirección HTTPS y dominio sin `www`.
- [ ] Enviar el sitemap en Search Console.

## Estado de esta entrega

- [x] 56 URLs indexables renderizadas (12 hubs + 29 especialidades + 8 guías + 7 páginas fijas), sin avisos PHP; todos los enlaces internos verificados.
- [x] Menú de servicios en tres niveles y menú de guías, verificados en escritorio y móvil.
- [x] SEO técnico: canonical, 301 sin barra final y desde URLs viejas, sitemap dinámico con lastmod, schemas `GeneralContractor` + `Service` + `FAQPage` + `BreadcrumbList`.
- [x] Responsive verificado a 390 y 1280 px, sin scroll horizontal.
- [x] Formulario con validación, honeypot, dos preguntas de calificación y salto a CRM + email + WhatsApp.
- [x] `tools/qa.ps1` y `tools/package-hostinger.ps1` ejecutados con éxito.
- [ ] Publicación en Hostinger no realizada ni verificada.
