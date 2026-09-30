<?php
declare(strict_types=1);

// Nombre legible de una ruta interna (para listas de "relacionados").
function obra_label_for_path(array $content, string $path): string
{
    $parts = array_values(array_filter(explode('/', $path)));
    if ($parts === []) { return 'Inicio'; }
    if ($parts[0] === 'guias' && isset($parts[1], $content['guides'][$parts[1]])) { return $content['guides'][$parts[1]]['name']; }
    foreach ($content['guides'] as $guide) { if (($guide['path'] ?? '') === $path) { return $guide['name']; } }
    if (isset($content['services'][$parts[0]])) {
        if (isset($parts[1], $content['children'][$parts[0]][$parts[1]])) { return $content['children'][$parts[0]][$parts[1]]['name']; }
        return $content['services'][$parts[0]]['name'];
    }
    return match ($path) { '/como-trabajamos/' => 'Cómo trabajamos', '/cotizar/' => 'Cotizar', '/servicios/' => 'Servicios', '/guias/' => 'Guías', default => trim($path, '/') };
}

function obra_partner_note(array $config, ?array $link): void
{
    if ($link === null) { return; }
    $site = $config['partner_sites'][$link['site']] ?? null;
    $text = h($link['text']);
    // Con 'path' (una pagina concreta del sitio hermano) solo se enlaza si esa ruta figura en live_paths
    // (comprobada con HEAD 200). Si no, queda como texto. Sin 'path' se enlaza la portada si el sitio esta vivo.
    $url = $site !== null ? (string) $site['url'] : '';
    $live = $site !== null && !empty($site['live']);
    if ($live && isset($link['path'])) {
        $live = in_array($link['path'], $site['live_paths'] ?? [], true);
        $url = rtrim($url, '/') . $link['path'];
    }
    if ($live) {
        $host = preg_replace('#^https?://#', '', rtrim((string) $site['url'], '/'));
        $text = str_replace(h($host), '<a href="' . h($url) . '" rel="noopener">' . h($host) . '</a>', $text);
    }
    ?><aside class="partner-note"><p class="eyebrow">Del mismo grupo</p><p><?= $text ?></p></aside><?php
}

function obra_related_list(array $content, array $paths, string $title = 'El proyecto puede necesitar más de un rubro.'): void
{
    ?><section class="related section"><div><p class="eyebrow">Relacionado</p><h2><?= h($title) ?></h2></div><div><?php foreach ($paths as $p): ?><a href="<?= h($p) ?>"><span><?= h(obra_label_for_path($content, $p)) ?></span><b aria-hidden="true">↗</b></a><?php endforeach; ?></div></section><?php
}

function obra_specialties(array $content, string $slug, array $service): void
{
    $children = $content['children'][$slug] ?? [];
    if ($children === []) { return; }
    ?><section class="specialties section"><div class="section-head"><div><p class="eyebrow">Especialidades</p><h2>Dentro de <?= h(function_exists('mb_strtolower') ? mb_strtolower($service['name'], 'UTF-8') : strtolower($service['name'])) ?>, lo que más nos piden.</h2></div><p>Cada especialidad tiene su propia página con qué incluye, cuándo conviene y preguntas frecuentes.</p></div><div class="spec-grid"><?php foreach ($children as $child => $page): ?><a href="/<?= h($slug) ?>/<?= h($child) ?>/"><span><?= h($page['kicker']) ?></span><h3><?= h($page['name']) ?></h3><p><?= h($page['summary'] ?? $page['description']) ?></p><b>Ver más <i aria-hidden="true">↗</i></b></a><?php endforeach; ?></div></section><?php
}

// Contenido v2 (docs/seo/CONTENT-SPEC.md). Todos los campos son opcionales: una pagina sin ellos se ve igual que antes.
//   'process'   => [[titulo, texto], ...]  Como es el proceso
//   'materials' => [[titulo, texto], ...]  Materiales y opciones
//   'sections'  => [[H2, [parrafo, ...]], ...] secciones de texto propias de la pagina
//   'mistakes'  => [[error, como se evita], ...]  Errores comunes
function obra_v2_sections(array $page): void
{
    if (!empty($page['process'])): ?><section class="process section"><div><p class="eyebrow">Cómo es el proceso</p><h2>Paso a paso, de la visita a la entrega.</h2></div><ol><?php foreach ($page['process'] as $i => $step): ?><li><span><?= sprintf('%02d', $i + 1) ?></span><div><h3><?= h($step[0]) ?></h3><p><?= h($step[1]) ?></p></div></li><?php endforeach; ?></ol></section><?php endif;
    if (!empty($page['materials'])): ?><section class="who-builds section"><div><p class="eyebrow">Materiales y opciones</p><h2>Qué se puede elegir.</h2></div><div class="who-grid"><?php foreach ($page['materials'] as $item): ?><article><h3><?= h($item[0]) ?></h3><p><?= h($item[1]) ?></p></article><?php endforeach; ?></div></section><?php endif;
    if (!empty($page['sections'])): ?><div class="legal-copy v2-copy"><?php foreach ($page['sections'] as $section): ?><section><h2><?= h($section[0]) ?></h2><?php foreach ($section[1] as $p): ?><p><?= h($p) ?></p><?php endforeach; ?></section><?php endforeach; ?></div><?php endif;
    if (!empty($page['mistakes'])): ?><section class="who-builds section"><div><p class="eyebrow">Errores comunes</p><h2>Lo que conviene evitar.</h2></div><div class="who-grid"><?php foreach ($page['mistakes'] as $item): ?><article><h3><?= h($item[0]) ?></h3><p><?= h($item[1]) ?></p></article><?php endforeach; ?></div></section><?php endif;
}

function obra_page_home(array $config, array $content, array $route): void
{
    $wa = obra_whatsapp($config, obra_wa_text('/', 'hero'));
    $count = count($content['services']);
    $subCount = array_sum(array_map('count', $content['children']));
    ?>
<section class="home-hero">
  <div class="hero-copy" data-reveal>
    <p class="eyebrow">Constructora · <?= h($config['area']) ?></p>
    <h1><?= h($route['h1']) ?></h1>
    <p class="hero-deck">Casas, quintas, piscinas, quinchos y reformas con una sola empresa a cargo: del terreno al presupuesto por escrito, y de la obra a la entrega.</p>
    <div class="action-row"><a class="btn btn-primary" href="<?= h($wa ?: '/cotizar/') ?>"<?= $wa ? obra_wa_attrs('hero') : '' ?>>Cotizar por WhatsApp <span aria-hidden="true">↗</span></a><a class="text-link" href="#servicios">Ver qué construimos</a></div>
    <ul class="hero-notes"><li>Presupuesto por rubro, por escrito</li><li>Un solo responsable de obra</li><li>Sin precios por m² a ciegas</li></ul>
  </div>
  <figure class="hero-media" data-reveal><img src="/assets/images/hero-casa.webp" srcset="/assets/images/hero-casa-480.webp 480w, /assets/images/hero-casa-960.webp 960w, /assets/images/hero-casa.webp 1600w" sizes="(min-width: 1024px) 55vw, 100vw" alt="Casa contemporánea de ladrillo visto con galería y jardín, estilo paraguayo moderno" width="1600" height="900" fetchpriority="high"><figcaption><span>Casa · galería · exterior</span><small>Imagen referencial</small></figcaption></figure>
</section>

<section class="trust-band" aria-label="Forma de trabajo"><span>Llave en mano: planos, obra y entrega</span><span>Presupuesto por escrito en guaraníes</span><span>Materiales y terminaciones definidos</span><span>Reportes de avance por etapa</span></section>

<section class="services section" id="servicios">
  <div class="section-head"><div><p class="eyebrow">Lo que construimos</p><h2>Obra completa, del terreno a la entrega.</h2></div><p>Cada proyecto empieza por entender el lugar, el uso y el nivel de terminación que necesitás. Después se cotiza por rubro, no con un precio genérico por metro cuadrado.</p></div>
  <div class="service-bento">
  <?php $i = 0; foreach (array_slice($content['services'], 0, 6, true) as $slug => $service): $i++; ?>
    <a class="service-card" href="/<?= h($slug) ?>/" data-reveal><span><?= sprintf('%02d', $i) ?></span><h3><?= h($service['name']) ?></h3><p><?= h($service['short']) ?></p><b>Ver servicio <i aria-hidden="true">↗</i></b></a>
  <?php endforeach; ?>
  </div>
  <div class="all-services-link"><a class="text-link" href="/servicios/">Ver los <?= $count ?> servicios y <?= $subCount ?> especialidades</a></div>
</section>

<section class="image-band">
  <img src="/assets/images/servicio-quincho.webp" srcset="/assets/images/servicio-quincho-480.webp 480w, /assets/images/servicio-quincho-960.webp 960w, /assets/images/servicio-quincho.webp 1000w" sizes="(min-width: 1024px) 50vw, 100vw" alt="Quincho abierto con parrilla de ladrillo, mesa y jardín" width="1000" height="750" loading="lazy">
  <div><p class="eyebrow">Espacios que se conectan</p><h2>Casa, quincho, piscina y patio pueden pensarse como una sola obra.</h2><p>Coordinar todo desde el inicio resuelve niveles, instalaciones, drenajes y recorridos sin improvisar entre gremios. Es la lógica de una quinta completa o de una casa con patio pensado.</p><a class="btn btn-light" href="/quintas/">Ver quintas y casas de campo <span aria-hidden="true">↗</span></a><small>Imagen referencial</small></div>
</section>

<?php obra_process_section($content['process']); ?>

<section class="who-builds section">
  <div><p class="eyebrow">Quién construye</p><h2>Equipo de obra propio y una red de subcontratistas de confianza.</h2></div>
  <div class="who-grid">
    <article><h3>Responsable de obra</h3><p>Una sola persona coordina albañilería, instalaciones, compras y terminaciones, y es tu punto de contacto durante toda la obra.</p></article>
    <article><h3>Oficios coordinados</h3><p>Trabajamos con cuadrillas y subcontratistas que ya conocemos de obras anteriores: electricistas, plomeros, herreros, carpinteros y techistas.</p></article>
    <article><h3>Un grupo, tres oficios</h3><p>Diseño en <?= !empty($config['partner_sites']['arq']['live']) ? '<a href="' . h($config['partner_sites']['arq']['url']) . '" rel="noopener">arq.com.py</a>' : 'arq.com.py' ?>, carpintería en <?= !empty($config['partner_sites']['carpinteria']['live']) ? '<a href="' . h($config['partner_sites']['carpinteria']['url']) . '" rel="noopener">carpinteria.com.py</a>' : 'carpinteria.com.py' ?> y la obra acá. Cuando el proyecto lo necesita, los tres trabajan juntos.</p></article>
  </div>
</section>

<section class="proof-replacement section">
  <div><p class="eyebrow">Antes de cotizar</p><h2>Lo que necesitamos saber.</h2><p>Un buen presupuesto no empieza con un precio por metro cuadrado. Empieza con información suficiente para comparar el mismo alcance.</p></div>
  <div class="brief-list"><article><span>01</span><h3>Ubicación</h3><p>Ciudad, barrio y condiciones de acceso.</p></article><article><span>02</span><h3>Terreno y medidas</h3><p>Si ya tenés terreno, sus medidas. Si es una reforma, el sector a intervenir.</p></article><article><span>03</span><h3>Estado actual</h3><p>Obra nueva, construcción existente o proyecto en marcha. Fotos ayudan.</p></article><article><span>04</span><h3>Financiación</h3><p>Fondos propios o crédito. Cambia el cronograma y el formato del presupuesto.</p></article></div>
</section>

<section class="project-gallery section">
  <div class="section-head"><div><p class="eyebrow">Tres escalas de obra</p><h2>Desde una mejora puntual hasta un proyecto completo.</h2></div><p>Estas imágenes muestran los tipos de espacios que construimos. Son referenciales, no obras propias: las fotos de obras reales se suman con autorización de cada cliente.</p></div>
  <div class="gallery-grid"><figure><img src="/assets/images/servicio-piscina.webp" srcset="/assets/images/servicio-piscina-480.webp 480w, /assets/images/servicio-piscina-960.webp 960w, /assets/images/servicio-piscina.webp 1000w" sizes="(min-width: 1024px) 50vw, 100vw" alt="Piscina de hormigón con vereda y jardín" width="1000" height="750" loading="lazy"><figcaption>Piscinas y exteriores <small>Imagen referencial</small></figcaption></figure><figure><img src="/assets/images/servicio-cochera.webp" srcset="/assets/images/servicio-cochera-480.webp 480w, /assets/images/servicio-cochera-960.webp 960w, /assets/images/servicio-cochera.webp 1000w" sizes="(min-width: 1024px) 50vw, 100vw" alt="Cochera con estructura metálica y piso de adoquines" width="1000" height="750" loading="lazy"><figcaption>Tinglados y accesos <small>Imagen referencial</small></figcaption></figure><figure><img src="/assets/images/hero-casa.webp" srcset="/assets/images/hero-casa-480.webp 480w, /assets/images/hero-casa-960.webp 960w, /assets/images/hero-casa.webp 1600w" sizes="(min-width: 1024px) 50vw, 100vw" alt="Casa de una planta con galería integrada al jardín" width="1600" height="900" loading="lazy"><figcaption>Casas y ampliaciones <small>Imagen referencial</small></figcaption></figure></div>
</section>

<section class="guides-teaser section">
  <div class="section-head"><div><p class="eyebrow">Antes de decidir</p><h2>Guías para construir sin sorpresas.</h2></div><p>Lo que conviene saber antes de pedir un presupuesto: costos, terreno, permisos, fundaciones y crédito.</p></div>
  <div class="guide-grid"><?php foreach (array_slice($content['guides'], 0, 4, true) as $slug => $guide): ?><a href="<?= h(obra_guide_path($slug, $guide)) ?>"><span><?= h($guide['kicker']) ?></span><h3><?= h($guide['name']) ?></h3><p><?= h($guide['summary'] ?? $guide['description']) ?></p></a><?php endforeach; ?></div>
  <div class="all-services-link"><a class="text-link" href="/guias/">Ver todas las guías</a></div>
</section>

<?php obra_faq_section($content['home_faqs']); ?>
<?php obra_contact_band($config, '/');
}

function obra_page_services(array $config, array $content, array $route): void
{
    $count = count($content['services']);
    ?><header class="page-hero"><div><p class="eyebrow">Servicios de obra</p><h1><?= h($route['h1']) ?></h1><p>Elegí el servicio más parecido a tu proyecto. Si combina varios rubros, lo ordenamos como una obra integral con un solo presupuesto.</p></div><div class="hero-index" aria-hidden="true"><strong><?= $count ?></strong><span>Servicios<br>coordinados</span></div></header>
<?php foreach ($content['groups'] as $group): ?>
<section class="service-group section"><div class="section-head"><div><p class="eyebrow"><?= h($group['name']) ?></p></div></div><div class="service-directory"><?php foreach ($group['services'] as $slug): $service = $content['services'][$slug]; $children = $content['children'][$slug] ?? []; ?><div class="directory-row"><a class="directory-main" href="/<?= h($slug) ?>/"><div><h2><?= h($service['name']) ?></h2><p><?= h($service['short']) ?></p></div><b aria-hidden="true">↗</b></a><?php if ($children !== []): ?><ul class="directory-children"><?php foreach ($children as $child => $page): ?><li><a href="/<?= h($slug) ?>/<?= h($child) ?>/"><?= h($page['name']) ?></a></li><?php endforeach; ?></ul><?php endif; ?></div><?php endforeach; ?></div></section>
<?php endforeach; ?>
<?php obra_contact_band($config, '/servicios/');
}

function obra_page_service(array $config, array $content, array $route): void
{
    $service = $content['services'][$route['slug']];
    $path = '/' . $route['slug'] . '/';
    $wa = obra_whatsapp($config, obra_wa_text($path, 'hero', $route['slug']));
    [$w, $hgt] = obra_image_size($service['image']);
    ?><header class="service-hero"><div><?php obra_breadcrumb_nav(obra_breadcrumbs($content, $route, '/' . $route['slug'] . '/')); ?><p class="eyebrow"><?= h($service['kicker']) ?></p><h1><?= h($service['h1']) ?></h1><p class="hero-deck"><?= h($service['short']) ?></p><div class="action-row"><a class="btn btn-primary" href="<?= h($wa ?: '/cotizar/?servicio=' . $route['slug']) ?>"<?= $wa ? obra_wa_attrs('hero', $route['slug']) : '' ?>>Cotizar por WhatsApp <span aria-hidden="true">↗</span></a><a class="text-link" href="/cotizar/?servicio=<?= h($route['slug']) ?>">Completar el formulario</a></div></div><figure><img src="/assets/images/<?= h($service['image']) ?>" srcset="<?= h(obra_srcset($service['image'])) ?>" sizes="(min-width: 1024px) 45vw, 100vw" alt="<?= h($service['image_alt']) ?>" width="<?= $w ?>" height="<?= $hgt ?>" fetchpriority="high"><figcaption>Imagen referencial</figcaption></figure></header>
<section class="include section" id="incluye"><div><p class="eyebrow">Qué incluye</p><h2>Qué puede incluir la obra.</h2><p>El alcance se ajusta a tu proyecto. Estos puntos sirven para empezar la conversación; lo contractual queda en la propuesta por escrito.</p></div><ul><?php foreach ($service['includes'] as $i => $item): ?><li><span><?= sprintf('%02d', $i + 1) ?></span><?= h($item) ?></li><?php endforeach; ?></ul></section>
<?php obra_specialties($content, $route['slug'], $service); ?>
<?php obra_v2_sections($service); ?>
<section class="situations section"><div class="section-head"><div><p class="eyebrow">Cuándo consultar</p><h2>Este servicio es para vos si…</h2></div><p>No hace falta llegar con todo resuelto. Sí ayuda contar qué existe hoy y qué querés lograr.</p></div><div class="situation-grid"><?php foreach ($service['ideal'] as $i => $item): ?><article><span><?= sprintf('%02d', $i + 1) ?></span><p><?= h($item) ?></p></article><?php endforeach; ?></div></section>
<?php obra_process_section($content['process']); ?>
<?php obra_partner_note($config, $service['link'] ?? null); ?>
<?php obra_related_list($content, array_map(fn($s) => '/' . $s . '/', $service['related'])); ?>
<?php obra_faq_section($service['faqs']); obra_contact_band($config, $path, $route['slug']);
}

function obra_page_child(array $config, array $content, array $route): void
{
    $parent = $content['services'][$route['slug']];
    $page = $content['children'][$route['slug']][$route['child']];
    $path = '/' . $route['slug'] . '/' . $route['child'] . '/';
    $wa = obra_whatsapp($config, obra_wa_text($path, 'hero', $route['slug']));
    [$w, $hgt] = obra_image_size($parent['image']);
    $siblings = array_diff_key($content['children'][$route['slug']], [$route['child'] => true]);
    ?><header class="service-hero child-hero"><div><?php obra_breadcrumb_nav(obra_breadcrumbs($content, $route, $path)); ?><p class="eyebrow"><?= h($page['kicker']) ?></p><h1><?= h($page['h1']) ?></h1><?php foreach ($page['intro'] as $p): ?><p class="hero-deck"><?= h($p) ?></p><?php endforeach; ?><div class="action-row"><a class="btn btn-primary" href="<?= h($wa ?: '/cotizar/?servicio=' . $route['slug']) ?>"<?= $wa ? obra_wa_attrs('hero', $route['slug']) : '' ?>>Cotizar por WhatsApp <span aria-hidden="true">↗</span></a><a class="text-link" href="/cotizar/?servicio=<?= h($route['slug']) ?>">Completar el formulario</a></div></div><figure><img src="/assets/images/<?= h($parent['image']) ?>" srcset="<?= h(obra_srcset($parent['image'])) ?>" sizes="(min-width: 1024px) 45vw, 100vw" alt="<?= h($parent['image_alt']) ?>" width="<?= $w ?>" height="<?= $hgt ?>" fetchpriority="high"><figcaption>Imagen referencial</figcaption></figure></header>
<section class="include section"><div><p class="eyebrow">Qué incluye</p><h2>Qué puede incluir.</h2><p>Puntos habituales de este tipo de obra. El alcance final queda por escrito en la propuesta.</p></div><ul><?php foreach ($page['includes'] as $i => $item): ?><li><span><?= sprintf('%02d', $i + 1) ?></span><?= h($item) ?></li><?php endforeach; ?></ul></section>
<?php obra_v2_sections($page); ?>
<section class="situations section"><div class="section-head"><div><p class="eyebrow">Cuándo consultar</p><h2>Te conviene si…</h2></div><p>Si tu caso se parece a alguno de estos, contanos y te decimos cómo seguir.</p></div><div class="situation-grid situation-grid-3"><?php foreach ($page['ideal'] as $i => $item): ?><article><span><?= sprintf('%02d', $i + 1) ?></span><p><?= h($item) ?></p></article><?php endforeach; ?></div></section>
<?php obra_partner_note($config, $page['link'] ?? null); ?>
<section class="related section"><div><p class="eyebrow">Dentro de <?= h($parent['name']) ?></p><h2>Otras especialidades y servicios relacionados.</h2><p><a class="text-link" href="/<?= h($route['slug']) ?>/">Volver a <?= h($parent['name']) ?></a></p></div><div><?php foreach ($siblings as $child => $sib): ?><a href="/<?= h($route['slug']) ?>/<?= h($child) ?>/"><span><?= h($sib['name']) ?></span><b aria-hidden="true">↗</b></a><?php endforeach; ?><?php foreach ($page['related'] as $p): if (str_starts_with($p, '/' . $route['slug'] . '/')) { continue; } ?><a href="<?= h($p) ?>"><span><?= h(obra_label_for_path($content, $p)) ?></span><b aria-hidden="true">↗</b></a><?php endforeach; ?></div></section>
<?php obra_faq_section($page['faqs']); obra_contact_band($config, $path, $route['slug']);
}

function obra_page_guides(array $config, array $content, array $route): void
{
    ?><header class="page-hero"><div><p class="eyebrow">Guías</p><h1><?= h($route['h1']) ?></h1><p>Respuestas directas a lo que la gente pregunta antes de construir. Sin precios inventados, sin plazos mágicos: lo que define cada decisión y cómo la trabajamos.</p></div><div class="hero-index" aria-hidden="true"><strong><?= count($content['guides']) ?></strong><span>Guías<br>prácticas</span></div></header>
<section class="section"><div class="guide-grid guide-grid-wide"><?php foreach ($content['guides'] as $slug => $guide): ?><a href="<?= h(obra_guide_path($slug, $guide)) ?>"><span><?= h($guide['kicker']) ?></span><h2><?= h($guide['name']) ?></h2><p><?= h($guide['summary'] ?? $guide['description']) ?></p><b>Leer la guía <i aria-hidden="true">↗</i></b></a><?php endforeach; ?></div></section>
<?php obra_contact_band($config, '/guias/');
}

function obra_page_guide(array $config, array $content, array $route): void
{
    $guide = $content['guides'][$route['slug']];
    $path = obra_guide_path($route['slug'], $guide);
    $wa = obra_whatsapp($config, obra_wa_text($path, 'hero'));
    ?><header class="legal-hero guide-hero"><?php obra_breadcrumb_nav(obra_breadcrumbs($content, $route, $path)); ?><p class="eyebrow"><?= h($guide['kicker']) ?></p><h1><?= h($guide['h1']) ?></h1><?php foreach ($guide['intro'] as $p): ?><p><?= h($p) ?></p><?php endforeach; ?></header>
<div class="guide-layout">
<nav class="toc" aria-label="Contenido de la guía"><strong>En esta guía</strong><ol><?php foreach ($guide['sections'] as $i => $section): ?><li><a href="#s<?= $i + 1 ?>"><?= h($section[0]) ?></a></li><?php endforeach; ?><li><a href="#faq">Preguntas frecuentes</a></li></ol><a class="btn btn-primary" href="<?= h($wa ?: '/cotizar/') ?>"<?= $wa ? obra_wa_attrs('hero') : '' ?>>Cotizar por WhatsApp <span aria-hidden="true">↗</span></a></nav>
<article class="guide-copy"><?php foreach ($guide['sections'] as $i => $section): ?><section id="s<?= $i + 1 ?>"><h2><?= h($section[0]) ?></h2><?php foreach ($section[1] as $p): ?><p><?= h($p) ?></p><?php endforeach; ?></section><?php if ($i === 1 && $wa): ?><aside class="partner-note guide-cta"><p class="eyebrow">Tu caso</p><p>¿Querés que lo veamos para tu terreno o tu obra? Contanos qué tenés y te decimos cómo seguir.</p><p><a class="text-link" href="<?= h(obra_whatsapp($config, obra_wa_text($path, 'mid'))) ?>"<?= obra_wa_attrs('mid') ?>>Consultar por WhatsApp</a></p></aside><?php endif; ?><?php endforeach; ?>
<?php obra_partner_note($config, $guide['link'] ?? null); ?>
<section id="faq" class="guide-faq"><h2>Preguntas frecuentes</h2><div class="accordion"><?php foreach ($guide['faqs'] as $faq): ?><details><summary><?= h($faq[0]) ?><span aria-hidden="true">+</span></summary><p><?= h($faq[1]) ?></p></details><?php endforeach; ?></div></section>
</article>
</div>
<?php obra_related_list($content, $guide['related'], 'Para seguir.'); ?>
<?php obra_contact_band($config, $path);
}

function obra_page_process(array $config, array $content, array $route): void
{
    $steps = count($content['process']);
    ?><header class="page-hero dark"><div><p class="eyebrow">Método de trabajo</p><h1><?= h($route['h1']) ?></h1><p>Ordenamos alcance, responsabilidades y decisiones antes de mover materiales y equipos. Así el presupuesto se cumple y las sorpresas se conversan antes, no después.</p></div><div class="process-line" aria-hidden="true"><?php for ($i = 0; $i < $steps; $i++): ?><i></i><?php endfor; ?></div></header>
<?php obra_process_section($content['process']); ?>
<section class="boundary section"><div><p class="eyebrow">La propuesta</p><h2>Lo que queda por escrito.</h2><ul><li>Trabajos incluidos y excluidos</li><li>Quién provee cada material</li><li>Forma de pago y cronograma de desembolsos</li><li>Secuencia y condiciones de ejecución</li><li>Decisiones que quedan de tu lado</li></ul></div><div><p class="eyebrow">Antes de empezar</p><h2>Lo que no conviene suponer.</h2><ul><li>Que todo cambio mantiene el mismo precio</li><li>Que una foto define una solución técnica</li><li>Que todos los materiales rinden igual</li><li>Que el acceso y el terreno no afectan la obra</li><li>Que hay un plazo sin un alcance cerrado</li></ul></div></section>
<?php obra_related_list($content, ['/guias/plazos/', '/guias/costo-casa/', '/supervision/'], 'Leé más antes de empezar.'); ?>
<?php obra_contact_band($config, '/como-trabajamos/');
}

function obra_page_contact(array $config, array $content, array $route): void
{
    $wa = obra_whatsapp($config, obra_wa_text('/cotizar/', 'hero'));
    $tel = obra_tel_href($config);
    $hasDetails = $wa || $config['email'] !== '' || $config['legal_address'] !== '';
    ?><header class="contact-hero"><div><p class="eyebrow">Cotizar</p><h1><?= h($route['h1']) ?></h1><p>Decinos qué querés hacer, dónde queda y cómo pensás financiarlo. No hace falta tener todas las decisiones tomadas: con eso ya te decimos cómo seguir.</p><?php if ($wa): ?><div class="action-row"><a class="btn btn-whatsapp" href="<?= h($wa) ?>"<?= obra_wa_attrs('hero') ?>>Escribinos por WhatsApp <span aria-hidden="true">↗</span></a><?php if ($tel !== ''): ?><a class="btn btn-call" href="<?= h($tel) ?>">Llamar <span aria-hidden="true">☎</span></a><?php endif; ?></div><?php endif; ?></div><aside><strong>Lo que ayuda tener a mano</strong><span>01 · Tipo de obra</span><span>02 · Ciudad y barrio</span><span>03 · Medidas aproximadas o planos</span><span>04 · Fotos del terreno o del estado actual</span><span>05 · Cómo pensás financiar y para cuándo</span></aside></header>
<section class="contact-layout section"><div><p class="eyebrow">Formulario</p><h2>Contanos tu proyecto.</h2><?php obra_contact_form($config, $content); ?></div><aside class="contact-details"><h2>Contacto directo</h2><?php if ($hasDetails): ?><dl><?php if ($wa): ?><div><dt>WhatsApp</dt><dd><a href="<?= h($wa) ?>"<?= obra_wa_attrs('contact-aside') ?>><?= h(obra_phone_display($config)) ?></a></dd></div><?php if ($tel !== ''): ?><div><dt>Teléfono</dt><dd><a href="<?= h($tel) ?>"><?= h(obra_phone_display($config)) ?></a></dd></div><?php endif; ?><?php endif; ?><?php if ($config['email'] !== ''): ?><div><dt>Email</dt><dd><a href="mailto:<?= h($config['email']) ?>"><?= h($config['email']) ?></a></dd></div><?php endif; ?><?php if ($config['legal_address'] !== ''): ?><div><dt>Dirección</dt><dd><?= h($config['legal_address']) ?></dd></div><?php endif; ?><div><dt>Zona</dt><dd><?= h($config['area']) ?>. Otras zonas, según proyecto.</dd></div></dl><?php else: ?><p>Por ahora atendemos consultas únicamente a través de este formulario.</p><?php endif; ?><p class="contact-note">Respondemos en horario comercial. Si tu obra es urgente, decilo en el mensaje y lo priorizamos.</p></aside></section><?php
}

function obra_page_about(array $config, array $content, array $route): void
{
    $hasLegal = $config['legal_operator'] !== '' || $config['ruc'] !== '' || $config['legal_address'] !== '' || $config['email'] !== '';
    $partners = $config['partner_sites'] ?? [];
    ?><header class="page-hero"><div><p class="eyebrow">Sobre Obra</p><h1><?= h($route['h1']) ?></h1><p>Cuando construís, no deberías terminar coordinando vos al albañil, al electricista, al plomero y las compras. Obra toma el proyecto completo y lo lleva de principio a fin con un solo responsable.</p></div><figure class="about-mark" aria-hidden="true"><span>O</span><i></i><i></i></figure></header>
<section class="about-principles section"><article><span>01</span><h2>Alcance por escrito</h2><p>Lo incluido, lo excluido y lo pendiente se entiende antes de ejecutar, no durante.</p></article><article><span>02</span><h2>Un solo responsable</h2><p>Ordenamos rubros y decisiones para evitar cruces, esperas e improvisaciones entre gremios.</p></article><article><span>03</span><h2>Obra real, no catálogo</h2><p>La propuesta se arma para tu lugar, tu uso y las terminaciones que necesitás, en guaraníes y sin precios genéricos.</p></article></section>
<section class="group section"><div><p class="eyebrow">Un grupo, tres oficios</p><h2>Diseño, carpintería y obra bajo el mismo techo.</h2></div><div class="group-grid"><article><h3><?= !empty($partners['arq']['live']) ? '<a href="' . h($partners['arq']['url']) . '" rel="noopener">arq.com.py</a>' : 'arq.com.py' ?></h3><p>Proyecto, planos, renders y carpeta municipal. Si tu obra necesita diseño, empieza ahí.</p></article><article><h3><?= !empty($partners['carpinteria']['live']) ? '<a href="' . h($partners['carpinteria']['url']) . '" rel="noopener">carpinteria.com.py</a>' : 'carpinteria.com.py' ?></h3><p>Techos de madera, machimbre, aberturas y muebles a medida fabricados para la obra.</p></article><article><h3>obra.com.py</h3><p>La ejecución: platea, mampostería, techo, instalaciones, terminaciones y entrega llave en mano.</p></article></div></section>
<?php if ($hasLegal): ?><section class="legal-identity section"><div><p class="eyebrow">Identidad comercial</p><h2>Quién está detrás de Obra.</h2></div><dl><?php if ($config['legal_operator'] !== ''): ?><div><dt>Razón social</dt><dd><?= h($config['legal_operator']) ?></dd></div><?php endif; ?><?php if ($config['ruc'] !== ''): ?><div><dt>RUC</dt><dd><?= h($config['ruc']) ?></dd></div><?php endif; ?><?php if ($config['legal_address'] !== ''): ?><div><dt>Domicilio</dt><dd><?= h($config['legal_address']) ?></dd></div><?php endif; ?><?php if ($config['email'] !== ''): ?><div><dt>Email</dt><dd><a href="mailto:<?= h($config['email']) ?>"><?= h($config['email']) ?></a></dd></div><?php endif; ?></dl></section><?php endif; ?>
<?php obra_contact_band($config, '/nosotros/');
}

function obra_page_privacy(array $config, array $route): void
{
    $email = (string) ($config['privacy_email'] ?: $config['email']);
    ?><header class="legal-hero"><p class="eyebrow">Datos personales</p><h1><?= h($route['h1']) ?></h1><p>Qué datos recibimos a través de obra.com.py y para qué los usamos.</p></header><article class="legal-copy"><section><h2>Datos que recibimos</h2><p>Cuando completás el formulario o nos escribís por WhatsApp podemos recibir tu nombre, número de teléfono, ciudad o barrio, tipo de obra, situación del terreno, forma de financiación prevista y la descripción de tu proyecto.</p></section><section><h2>Para qué los usamos</h2><p>Para responder tu consulta, evaluar el alcance de la obra, preparar un presupuesto y hacer seguimiento comercial. Los datos pueden guardarse en nuestro sistema de gestión de clientes y compartirse con las empresas del mismo grupo (arq.com.py y carpinteria.com.py) solo cuando tu proyecto lo requiera.</p></section><section><h2>Datos sensibles</h2><p>No envíes cédula, datos bancarios, títulos de propiedad ni documentos confidenciales por el formulario. Si hacen falta, los pedimos por un canal acordado con vos.</p></section><section><h2>Cookies y medición</h2><p>Usamos Google Analytics para medir visitas únicamente si aceptás las cookies en el aviso del sitio. Podés rechazarlas y el sitio funciona igual.</p></section><section><h2>Tus derechos</h2><p>Podés pedir que corrijamos o eliminemos tus datos en cualquier momento. <?= $email !== '' ? 'Escribinos a <a href="mailto:' . h($email) . '">' . h($email) . '</a>.' : 'Escribinos por el mismo canal por el que nos contactaste.' ?></p></section></article><?php
}

function obra_page_thanks(array $config, array $route): void
{
    $state = (string) ($_GET['estado'] ?? '');
    $wa = obra_whatsapp($config, obra_wa_text('/gracias/', 'thanks'));
    $messages = [
        'enviado' => ['Recibimos tu consulta.', 'Te respondemos por WhatsApp o email en horario comercial.', true],
        'crm-confirmado' => ['Recibimos tu consulta.', 'Quedó registrada y te contactamos por WhatsApp en horario comercial.', true],
        'sin-canales' => ['No pudimos registrar tu consulta.', 'Hubo un problema al enviar el formulario. Escribinos directamente por WhatsApp o intentá de nuevo en unos minutos.', false],
    ];
    $message = $messages[$state] ?? ['No pudimos confirmar el envío.', 'Volvé al formulario o escribinos directamente por WhatsApp.', false];
    ?><section class="thanks" data-thanks="<?= h($state) ?>"><span aria-hidden="true"><?= $message[2] ? 'OK' : '?' ?></span><div><p class="eyebrow">Resultado del envío</p><h1><?= h($message[0]) ?></h1><p><?= h($message[1]) ?></p><div class="action-row"><?php if ($wa): ?><a class="btn btn-whatsapp" href="<?= h($wa) ?>"<?= obra_wa_attrs('thanks') ?>>Seguir por WhatsApp <span aria-hidden="true">↗</span></a><?php else: ?><a class="btn btn-primary" href="/cotizar/">Volver al formulario</a><?php endif; ?><a class="text-link" href="/">Ir al inicio</a></div></div></section><?php
}

function obra_process_section(array $process): void
{
    ?><section class="process section"><div><p class="eyebrow">Cómo trabajamos</p><h2>Del terreno a la entrega en <?= count($process) ?> pasos.</h2><p>La profundidad de cada etapa cambia según el tamaño y la complejidad del proyecto. El orden, no.</p></div><ol><?php foreach ($process as $step): ?><li><span><?= h($step[0]) ?></span><div><h3><?= h($step[1]) ?></h3><p><?= h($step[2]) ?></p></div></li><?php endforeach; ?></ol></section><?php
}

function obra_faq_section(array $faqs): void
{
    ?><section class="faq section"><div><p class="eyebrow">Preguntas frecuentes</p><h2>Lo que conviene aclarar antes de empezar.</h2></div><div class="accordion"><?php foreach ($faqs as $faq): ?><details><summary><?= h($faq[0]) ?><span aria-hidden="true">+</span></summary><p><?= h($faq[1]) ?></p></details><?php endforeach; ?></div></section><?php
}

function obra_contact_band(array $config, string $path, ?string $serviceSlug = null): void
{
    $wa = obra_whatsapp($config, obra_wa_text($path, 'band', $serviceSlug));
    ?><section class="contact-band"><div><p class="eyebrow">Tu próxima obra</p><h2>Contanos qué querés construir.</h2><p>Ubicación, medidas aproximadas y una breve descripción alcanzan para empezar. Te respondemos por WhatsApp.</p></div><div class="action-row"><a class="btn btn-light" href="<?= h($wa ?: '/cotizar/') ?>"<?= $wa ? obra_wa_attrs('band', $serviceSlug) : '' ?>><?= $wa ? 'Cotizar por WhatsApp' : 'Pedí presupuesto' ?> <span aria-hidden="true">↗</span></a><?php if ($wa): ?><a class="text-link text-link-light" href="/cotizar/">Prefiero el formulario</a><?php endif; ?></div></section><?php
}
