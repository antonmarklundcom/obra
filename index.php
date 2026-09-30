<?php
declare(strict_types=1);

$config = require __DIR__ . '/config/site.php';
require_once __DIR__ . '/app/helpers.php';
$content = require __DIR__ . '/app/content.php';
require_once __DIR__ . '/app/routes.php';
require_once __DIR__ . '/app/layout.php';
require_once __DIR__ . '/app/pages.php';

obra_security_headers();
$routes = obra_routes($content, $config);
$path = obra_path();
$query = (string) ($_SERVER['QUERY_STRING'] ?? '');
$suffix = $query !== '' ? '?' . $query : '';

// URLs de versiones anteriores (301 permanente).
$legacy = obra_legacy_redirects();
if (isset($legacy[$path])) {
    header('Location: ' . $legacy[$path] . $suffix, true, 301);
    exit;
}

// Una sola URL por pagina: /piscinas -> /piscinas/ (301).
if (isset($routes[$path]) && obra_raw_path() !== $path) {
    header('Location: ' . $path . $suffix, true, 301);
    exit;
}

if (!isset($routes[$path])) {
    http_response_code(404);
    $route = ['title' => 'Página no encontrada | Obra', 'description' => 'La página solicitada no existe.', 'h1' => 'Esta página no está en obra.', 'indexable' => false];
    // Registro de 404 para detectar enlaces rotos y URLs viejas (solo ruta y dominio de origen, sin datos personales).
    error_log('obra-404 ' . substr(preg_replace('/[^\x21-\x7e]/', '', $path), 0, 200) . ' ref=' . substr((string) parse_url((string) ($_SERVER['HTTP_REFERER'] ?? ''), PHP_URL_HOST), 0, 80));
    obra_head($config, $route, $path);
    obra_header($config, $content, $path, $route);
    ?><main id="contenido"><section class="error-page"><span aria-hidden="true">404</span><div><p class="eyebrow">Ruta no encontrada</p><h1><?= h($route['h1']) ?></h1><p>La dirección puede estar mal escrita o la página ya no existe. Volvé al inicio o revisá los servicios.</p><div class="action-row"><a class="btn btn-primary" href="/">Ir al inicio</a><a class="text-link" href="/servicios/">Ver servicios</a></div><nav class="error-links" aria-label="Páginas útiles"><strong>Lo que más se busca</strong><?php foreach (array_slice($content['services'], 0, 6, true) as $es => $esv): ?><a href="/<?= h($es) ?>/"><?= h($esv['name']) ?></a><?php endforeach; ?><?php foreach (array_slice($content['guides'], 0, 3, true) as $eg => $egv): ?><a href="<?= h(obra_guide_path($eg, $egv)) ?>"><?= h($egv['name']) ?></a><?php endforeach; ?></nav><?php $ewa = obra_whatsapp($config, 'Hola, no encontré la página que buscaba en obra.com.py y quiero consultar por mi obra. ¿Me ayudan?'); if ($ewa): ?><p><a class="btn btn-whatsapp" href="<?= h($ewa) ?>"<?= obra_wa_attrs('hero') ?>>Escribinos por WhatsApp</a></p><?php endif; ?></div></section></main><?php
    obra_footer($config, $content, $route);
    exit;
}

$route = $routes[$path];
$areaServed = [['@type' => 'Country', 'name' => 'Paraguay']];
if (($config['area'] ?? '') !== '' && $config['area'] !== 'Paraguay') {
    array_unshift($areaServed, ['@type' => 'AdministrativeArea', 'name' => $config['area']]);
}
$businessId = obra_url($config) . '#empresa';
$business = [
    '@context' => 'https://schema.org',
    '@type' => 'GeneralContractor',
    '@id' => $businessId,
    'name' => 'Obra',
    'url' => obra_url($config),
    'image' => obra_url($config, '/assets/images/og-obra.jpg'),
    'description' => 'Constructora en ' . $config['area'] . ': casas llave en mano, quintas, piscinas, quinchos, reformas y obras comerciales construidas de principio a fin.',
    'areaServed' => $areaServed,
    'knowsLanguage' => 'es',
    'priceRange' => 'PYG',
];
if (obra_phone_ready($config)) { $business['telephone'] = '+' . $config['whatsapp']; }
if ($config['email'] !== '') { $business['email'] = $config['email']; }
if ($config['legal_address'] !== '') { $business['address'] = ['@type' => 'PostalAddress', 'streetAddress' => $config['legal_address'], 'addressLocality' => 'Asunción', 'addressCountry' => 'PY']; }
if ($config['legal_operator'] !== '') { $business['legalName'] = $config['legal_operator']; }
if ($config['ruc'] !== '') { $business['taxID'] = $config['ruc']; }
$schemas = [$business];
$provider = ['@type' => 'GeneralContractor', '@id' => $businessId, 'name' => 'Obra', 'url' => obra_url($config)];

if ($path === '/') {
    $schemas[] = ['@context' => 'https://schema.org', '@type' => 'WebSite', 'name' => 'Obra.com.py', 'url' => obra_url($config), 'inLanguage' => 'es-PY'];
    $schemas[] = obra_faq_schema($content['home_faqs']);
} elseif ($path !== '/gracias/') {
    $schemas[] = obra_breadcrumb_schema($config, obra_breadcrumbs($content, $route, $path));
}
if ($route['type'] === 'service') {
    $service = $content['services'][$route['slug']];
    $schemas[] = ['@context' => 'https://schema.org', '@type' => 'Service', 'name' => $service['name'], 'serviceType' => $service['h1'], 'description' => $service['description'], 'url' => obra_url($config, $path), 'image' => obra_url($config, '/assets/images/' . $service['image']), 'areaServed' => $areaServed, 'provider' => $provider];
    $schemas[] = obra_faq_schema($service['faqs']);
} elseif ($route['type'] === 'child') {
    $parent = $content['services'][$route['slug']];
    $page = $content['children'][$route['slug']][$route['child']];
    $schemas[] = ['@context' => 'https://schema.org', '@type' => 'Service', 'name' => $page['name'], 'serviceType' => $page['h1'], 'description' => $page['description'], 'url' => obra_url($config, $path), 'image' => obra_url($config, '/assets/images/' . $parent['image']), 'areaServed' => $areaServed, 'provider' => $provider, 'isRelatedTo' => ['@type' => 'Service', 'name' => $parent['name'], 'url' => obra_url($config, '/' . $route['slug'] . '/')]];
    $schemas[] = obra_faq_schema($page['faqs']);
} elseif (in_array($route['type'], ['guides', 'services'], true)) {
    $items = [];
    if ($route['type'] === 'guides') {
        foreach ($content['guides'] as $gslug => $g) { $items[] = [obra_guide_path($gslug, $g), $g['name']]; }
    } else {
        foreach ($content['services'] as $sslug => $sv) { $items[] = ['/' . $sslug . '/', $sv['name']]; }
    }
    $list = [];
    foreach ($items as $i => [$ip, $in]) { $list[] = ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $in, 'url' => obra_url($config, $ip)]; }
    $schemas[] = ['@context' => 'https://schema.org', '@type' => 'CollectionPage', 'name' => $route['h1'], 'url' => obra_url($config, $path), 'inLanguage' => 'es-PY', 'mainEntity' => ['@type' => 'ItemList', 'itemListElement' => $list]];
} elseif ($route['type'] === 'guide') {
    $guide = $content['guides'][$route['slug']];
    $schemas[] = ['@context' => 'https://schema.org', '@type' => 'Article', 'headline' => $guide['h1'], 'description' => $guide['description'], 'url' => obra_url($config, $path), 'inLanguage' => 'es-PY', 'image' => obra_url($config, '/assets/images/og-obra.jpg'), 'author' => $provider, 'publisher' => $provider, 'mainEntityOfPage' => obra_url($config, $path), 'datePublished' => $guide['published'] ?? gmdate('Y-m-d'), 'dateModified' => $guide['updated'] ?? $guide['published'] ?? gmdate('Y-m-d')];
    $route['og_type'] = 'article';
    $route['modified'] = (string) ($guide['updated'] ?? $guide['published'] ?? '');
    $schemas[] = obra_faq_schema($guide['faqs']);
}

obra_head($config, $route, $path, $schemas);
obra_header($config, $content, $path, $route);
?><main id="contenido"><?php
match ($route['type']) {
    'home' => obra_page_home($config, $content, $route),
    'services' => obra_page_services($config, $content, $route),
    'service' => obra_page_service($config, $content, $route),
    'child' => obra_page_child($config, $content, $route),
    'guides' => obra_page_guides($config, $content, $route),
    'guide' => obra_page_guide($config, $content, $route),
    'process' => obra_page_process($config, $content, $route),
    'contact' => obra_page_contact($config, $content, $route),
    'about' => obra_page_about($config, $content, $route),
    'privacy' => obra_page_privacy($config, $route),
    'thanks' => obra_page_thanks($config, $route),
};
?></main><?php obra_footer($config, $content, $route); ?>
