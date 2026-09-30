<?php
declare(strict_types=1);

// Servicio (hub) de la ruta, para el texto de WhatsApp, el formulario y GA4.
function obra_route_service(array $route): ?string
{
    return in_array($route['type'] ?? '', ['service', 'child'], true) ? (string) $route['slug'] : null;
}

// Barra fija movil: en todas las paginas salvo /cotizar/ y /gracias/.
function obra_has_sticky(array $route, string $path): bool
{
    return !in_array($route['type'] ?? '', ['contact', 'thanks'], true) && $path !== '/cotizar/' && $path !== '/gracias/';
}

// Dimensiones reales de las imagenes en assets/images (evita saltos de layout y avisos de Lighthouse).
function obra_image_size(string $file): array
{
    return match ($file) {
        'hero-casa.webp' => [1600, 900],
        default => [1000, 750],
    };
}

function obra_srcset(string $file): string
{
    $base = preg_replace('/\.webp$/', '', $file);
    [$w] = obra_image_size($file);
    return "/assets/images/{$base}-480.webp 480w, /assets/images/{$base}-960.webp 960w, /assets/images/{$file} {$w}w";
}

function obra_head(array $config, array $route, string $path, array $schemas = []): void
{
    $canonical = obra_url($config, $path);
    $index = (bool) ($route['indexable'] ?? true);
    $og = obra_url($config, '/assets/images/og-obra.jpg');
    ?><!doctype html>
<html lang="es-PY">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= h($route['title']) ?></title>
<meta name="description" content="<?= h($route['description']) ?>">
<meta name="robots" content="<?= $index ? 'index,follow,max-image-preview:large' : 'noindex,follow' ?>">
<meta name="theme-color" content="#f5f2eb">
<link rel="canonical" href="<?= h($canonical) ?>">
<meta property="og:type" content="<?= h($route['og_type'] ?? 'website') ?>"><meta property="og:locale" content="es_PY"><meta property="og:site_name" content="Obra">
<meta property="og:title" content="<?= h($route['title']) ?>"><meta property="og:description" content="<?= h($route['description']) ?>"><meta property="og:url" content="<?= h($canonical) ?>">
<meta property="og:image" content="<?= h($og) ?>"><meta property="og:image:type" content="image/jpeg"><meta property="og:image:width" content="1200"><meta property="og:image:height" content="630"><meta property="og:image:alt" content="Obra: constructora en Paraguay, casas llave en mano">
<?php if (!empty($route['modified'])): ?><meta property="article:modified_time" content="<?= h($route['modified']) ?>"><?php endif; ?>
<meta name="twitter:card" content="summary_large_image"><meta name="twitter:title" content="<?= h($route['title']) ?>"><meta name="twitter:description" content="<?= h($route['description']) ?>"><meta name="twitter:image" content="<?= h($og) ?>">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" href="<?= h(obra_asset('/assets/css/site.css')) ?>">
<?php foreach ($schemas as $schema): ?><script type="application/ld+json"><?= obra_json($schema) ?></script>
<?php endforeach; ?>
<?php if (preg_match('/^G-[A-Z0-9]+$/', (string) $config['analytics_id'])): ?><meta name="obra-analytics" content="<?= h($config['analytics_id']) ?>"><?php endif; ?>
</head><body<?= obra_has_sticky($route, $path) ? ' class="has-sticky"' : '' ?>><a class="skip-link" href="#contenido">Saltar al contenido</a><?php
}

// Cabecera con menu de servicios en tres niveles (grupo > servicio > especialidad) y menu de guias.
// Escritorio: desplegable por hover/foco/click. Movil: panel con acordeones. Todo HTML real y rastreable.
function obra_header(array $config, array $content, string $path, array $route = []): void
{
    $waService = obra_route_service($route);
    $placement = obra_wa_placement($route, 'header');
    $wa = obra_whatsapp($config, obra_wa_text($path, $placement, $waService));
    $inServices = $path === '/servicios/' || (isset($content['services'][trim(explode('/', $path)[1] ?? '', '/')]));
    $inGuides = str_starts_with($path, '/guias/') || $path === '/credito/';
    ?><header class="site-header" data-header>
  <a class="brand" href="/" aria-label="Obra, ir al inicio"><span class="brand-mark" aria-hidden="true"><i></i><i></i></span><span>OBRA</span><small>.com.py</small></a>
  <button class="menu-toggle" type="button" aria-label="Abrir menú" aria-expanded="false" aria-controls="site-nav" data-menu-toggle><span></span><span></span></button>
  <nav id="site-nav" class="site-nav" aria-label="Navegación principal" data-menu>
    <div class="nav-item has-menu" data-dropdown>
      <a<?= $inServices ? ' aria-current="true"' : '' ?> href="/servicios/">Servicios</a><button type="button" class="nav-caret" aria-expanded="false" aria-label="Abrir servicios" data-dropdown-toggle><span aria-hidden="true">▾</span></button>
      <div class="mega" data-dropdown-panel>
        <?php foreach ($content['groups'] as $group): ?><div class="mega-col"><p class="mega-title"><?= h($group['name']) ?></p><ul><?php foreach ($group['services'] as $slug): $service = $content['services'][$slug]; ?><li><a<?= str_starts_with($path, '/' . $slug . '/') ? ' aria-current="page"' : '' ?> href="/<?= h($slug) ?>/"><?= h($service['name']) ?></a></li><?php endforeach; ?></ul></div><?php endforeach; ?>
        <a class="mega-all" href="/servicios/">Ver todos los servicios <span aria-hidden="true">↗</span></a>
      </div>
    </div>
    <div class="nav-item has-menu" data-dropdown>
      <a<?= $inGuides ? ' aria-current="true"' : '' ?> href="/guias/">Guías</a><button type="button" class="nav-caret" aria-expanded="false" aria-label="Abrir guías" data-dropdown-toggle><span aria-hidden="true">▾</span></button>
      <div class="mega mega-narrow" data-dropdown-panel><div class="mega-col"><p class="mega-title">Antes de construir</p><ul><?php foreach ($content['guides'] as $slug => $guide): $gp = obra_guide_path($slug, $guide); ?><li><a<?= $path === $gp ? ' aria-current="page"' : '' ?> href="<?= h($gp) ?>"><?= h($guide['name']) ?></a></li><?php endforeach; ?></ul></div></div>
    </div>
    <a class="nav-item"<?= $path === '/como-trabajamos/' ? ' aria-current="page"' : '' ?> href="/como-trabajamos/">Cómo trabajamos</a>
    <a class="nav-item"<?= $path === '/nosotros/' ? ' aria-current="page"' : '' ?> href="/nosotros/">Nosotros</a>
    <a class="nav-item nav-cta"<?= $path === '/cotizar/' ? ' aria-current="page"' : '' ?> href="/cotizar/">Cotizar</a>
  </nav>
  <a class="header-action" href="<?= h($wa ?: '/cotizar/') ?>"<?= $wa ? obra_wa_attrs($placement, $waService) : '' ?>><?= $wa ? 'WhatsApp' : 'Cotizar' ?> <span aria-hidden="true">↗</span></a>
</header><?php
}

function obra_footer(array $config, array $content, array $route = []): void
{
    $path = obra_path();
    $waService = obra_route_service($route);
    $placement = obra_wa_placement($route, 'footer');
    $wa = obra_whatsapp($config, obra_wa_text($path, $placement, $waService));
    $stickyPlacement = obra_wa_placement($route, 'sticky');
    $waSticky = obra_whatsapp($config, obra_wa_text($path, $stickyPlacement, $waService));
    $tel = obra_tel_href($config);
    $partners = $config['partner_sites'] ?? [];
    ?><footer class="site-footer">
  <div class="footer-grid">
    <div><a class="brand footer-brand" href="/" aria-label="Obra, ir al inicio"><span class="brand-mark" aria-hidden="true"><i></i><i></i></span><span>OBRA</span><small>.com.py</small></a><p>Constructora en <?= h($config['area']) ?>. Casas llave en mano, quintas, piscinas, quinchos y reformas construidas de principio a fin.</p><p class="footer-group">Parte del mismo grupo: <?php if (!empty($partners['arq']['live'])): ?><a href="<?= h($partners['arq']['url']) ?>" rel="noopener">arq.com.py</a><?php else: ?>arq.com.py<?php endif; ?> (proyecto y planos) · <?php if (!empty($partners['carpinteria']['live'])): ?><a href="<?= h($partners['carpinteria']['url']) ?>" rel="noopener">carpinteria.com.py</a><?php else: ?>carpinteria.com.py<?php endif; ?> (carpintería y madera).</p></div>
    <nav aria-label="Servicios"><strong>Servicios</strong><?php foreach ($content['services'] as $slug => $service): ?><a href="/<?= h($slug) ?>/"><?= h($service['name']) ?></a><?php endforeach; ?><a href="/servicios/"><b>Todos los servicios →</b></a></nav>
    <nav aria-label="Guías y empresa"><strong>Guías</strong><?php foreach ($content['guides'] as $slug => $guide): ?><a href="<?= h(obra_guide_path($slug, $guide)) ?>"><?= h($guide['name']) ?></a><?php endforeach; ?><strong class="footer-sub">Obra</strong><a href="/como-trabajamos/">Cómo trabajamos</a><a href="/nosotros/">Nosotros</a><a href="/cotizar/">Cotizar</a><a href="/privacidad/">Privacidad</a></nav>
    <div><strong>Contacto</strong><?php if ($wa): ?><a class="footer-wa" href="<?= h($wa) ?>"<?= obra_wa_attrs($placement, $waService) ?>>WhatsApp <?= h(obra_phone_display($config)) ?></a><?php if ($tel !== ''): ?><a class="footer-tel" href="<?= h($tel) ?>">Llamar <?= h(obra_phone_display($config)) ?></a><?php endif; ?><?php else: ?><a href="/cotizar/">Formulario de cotización</a><?php endif; ?><?php if ($config['email'] !== ''): ?><a href="mailto:<?= h($config['email']) ?>"><?= h($config['email']) ?></a><?php endif; ?><?php if ($config['legal_address'] !== ''): ?><p><?= h($config['legal_address']) ?></p><?php endif; ?><?php if ($config['legal_operator'] !== ''): ?><p><?= h($config['legal_operator']) ?></p><?php endif; ?><?php if ($config['ruc'] !== ''): ?><p>RUC <?= h($config['ruc']) ?></p><?php endif; ?></div>
  </div>
  <div class="footer-base"><span>© <?= date('Y') ?> Obra.com.py</span><span><?= h($config['area']) ?> · resto del país según proyecto</span><span>Imágenes referenciales, no son obras propias</span></div>
</footer>
<?php if ($waSticky && obra_has_sticky($route, $path)): ?><nav class="sticky-cta" aria-label="Contacto rápido" data-sticky-cta><a class="sticky-wa" href="<?= h($waSticky) ?>"<?= obra_wa_attrs($stickyPlacement, $waService) ?>>WhatsApp</a><a class="sticky-quote" href="/cotizar/<?= $waService !== null ? '?servicio=' . h($waService) : '' ?>">Cotizar</a></nav><?php endif; ?>
<?php if ($waSticky): ?><a class="wa-fab" href="<?= h($waSticky) ?>"<?= obra_wa_attrs($stickyPlacement === 'sticky' ? 'fab' : $stickyPlacement, $waService) ?> aria-label="Escribinos por WhatsApp"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 3.5A11.8 11.8 0 0 0 1.9 17.7L.3 23.6l6-1.6A11.7 11.7 0 0 0 12 23.4h.1A11.8 11.8 0 0 0 20.5 3.5Zm-8.4 17.9h-.1a9.7 9.7 0 0 1-5-1.4l-.4-.2-3.5.9.9-3.4-.2-.4a9.8 9.8 0 1 1 8.3 4.5Zm5.4-7.3c-.3-.2-1.8-.9-2.1-1-.3-.1-.5-.2-.7.2-.2.3-.8 1-.9 1.2-.2.2-.3.2-.6.1a8 8 0 0 1-2.4-1.5 9.2 9.2 0 0 1-1.7-2.1c-.2-.3 0-.5.1-.6l.5-.5.3-.5c.1-.2 0-.4 0-.5l-1-2.4c-.3-.6-.6-.5-.8-.5h-.7c-.2 0-.6.1-.9.4-.3.4-1.3 1.3-1.3 3.1s1.3 3.6 1.5 3.8c.2.2 2.6 4 6.3 5.6.9.4 1.6.6 2.1.8.9.3 1.7.2 2.3.1.7-.1 1.8-.8 2.1-1.5.3-.8.3-1.4.2-1.5-.1-.2-.3-.2-.6-.4Z"/></svg></a><?php endif; ?>
<div class="cookie-banner" data-cookie hidden><p>Usamos Google Analytics para medir visitas solo si aceptás las cookies. <a href="/privacidad/">Más información</a>.</p><div><button type="button" data-cookie-deny>Solo necesarias</button><button type="button" data-cookie-accept>Aceptar</button></div></div>
<script src="<?= h(obra_asset('/assets/js/site.js')) ?>" defer></script></body></html><?php
}

function obra_breadcrumb_nav(array $items): void
{
    ?><nav class="breadcrumbs" aria-label="Ubicación en el sitio"><ol><?php foreach ($items as $i => $item): $last = $i === count($items) - 1; ?><li><?php if ($last): ?><span aria-current="page"><?= h($item['label']) ?></span><?php else: ?><a href="<?= h($item['path']) ?>"><?= h($item['label']) ?></a><?php endif; ?></li><?php endforeach; ?></ol></nav><?php
}

function obra_contact_form(array $config, array $content): void
{
    $error = (string) ($_GET['error'] ?? '');
    $selected = preg_replace('/[^a-z0-9-]/', '', (string) ($_GET['servicio'] ?? ''));
    // Pagina desde la que llega la visita (mismo sitio), para que el lead diga de donde vino.
    $referer = (string) ($_SERVER['HTTP_REFERER'] ?? '');
    $refHost = (string) (parse_url($referer, PHP_URL_HOST) ?? '');
    $origin = $refHost !== '' && $refHost === (string) ($_SERVER['HTTP_HOST'] ?? '') ? obra_safe_return((string) parse_url($referer, PHP_URL_PATH), '/cotizar/') : '/cotizar/';
    if ($selected === '' && preg_match('#^/([a-z0-9-]+)/#', $origin, $m) && isset($content['services'][$m[1]])) { $selected = $m[1]; }
    $wa = obra_phone_ready($config);
    if ($error === 'tiempo'): ?><p class="form-error" role="alert">El formulario quedó abierto demasiado tiempo o se envió demasiado rápido. Revisá los datos y volvé a enviarlo.</p><?php elseif ($error !== ''): ?><p class="form-error" role="alert">Faltó completar algún dato o el número de WhatsApp no es válido (usá el formato 0981 123 456). Revisá y volvé a enviar.</p><?php endif; ?>
<form class="contact-form" action="/form.php" method="post" data-form>
  <input type="hidden" name="return_path" value="/cotizar/"><input type="hidden" name="origin_path" value="<?= h($origin) ?>"><input type="hidden" name="placement" value="form"><input type="hidden" name="page_url" value="" data-page-url><input type="hidden" name="started_at" value="<?= time() ?>">
  <label class="trap" aria-hidden="true">Sitio web<input name="website" tabindex="-1" autocomplete="off"></label>
  <div class="field-grid">
    <label>Nombre<input name="name" required maxlength="100" autocomplete="name" placeholder="Tu nombre"></label>
    <label>WhatsApp<input name="phone" required maxlength="30" inputmode="tel" autocomplete="tel" placeholder="0981 123 456" pattern="[\-0-9+\(\)\s]{9,}"></label>
  </div>
  <div class="field-grid">
    <label>¿Qué querés construir?<select name="service" required><option value="">Seleccioná</option><?php foreach ($content['services'] as $slug => $service): ?><option value="<?= h($slug) ?>"<?= $selected === $slug ? ' selected' : '' ?>><?= h($service['name']) ?></option><?php endforeach; ?><option value="otro"<?= $selected === 'otro' ? ' selected' : '' ?>>Otro tipo de obra</option></select></label>
    <label>Ciudad o barrio<input name="location" required maxlength="120" placeholder="Ej. Luque, Central" autocomplete="address-level2"></label>
  </div>
  <div class="field-grid">
    <label>¿Ya tenés terreno?<select name="terrain" required><option value="">Seleccioná</option><?php foreach ($content['terrain'] as $key => $label): ?><option value="<?= h($key) ?>"><?= h($label) ?></option><?php endforeach; ?></select></label>
    <label>¿Cómo pensás financiar la obra?<select name="financing" required><option value="">Seleccioná</option><?php foreach ($content['financing'] as $key => $label): ?><option value="<?= h($key) ?>"><?= h($label) ?></option><?php endforeach; ?></select></label>
  </div>
  <label>Contanos el proyecto<textarea name="message" required minlength="20" maxlength="1600" rows="6" placeholder="Qué existe hoy, medidas aproximadas y qué resultado buscás"></textarea></label>
  <label class="check"><input type="checkbox" name="consent" value="1" required><span>Acepto que Obra use estos datos para responder mi consulta, según la <a href="/privacidad/">política de privacidad</a>.</span></label>
  <button class="btn btn-primary" type="submit"><?= $wa ? 'Enviar y seguir por WhatsApp' : 'Enviar consulta' ?> <span aria-hidden="true">↗</span></button>
  <p class="form-foot"><?= $wa ? 'Al enviar se abre WhatsApp con tu consulta ya escrita, para seguir la conversación desde tu teléfono.' : 'Te respondemos al WhatsApp que dejes en el formulario.' ?></p>
</form><?php
}
