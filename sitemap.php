<?php
declare(strict_types=1);
// Sitemap dinamico: Apache reescribe /sitemap.xml a este archivo (ver .htaccess).
$config = require __DIR__ . '/config/site.php';
require_once __DIR__ . '/app/helpers.php';
$content = require __DIR__ . '/app/content.php';
require_once __DIR__ . '/app/routes.php';
$routes = obra_routes($content);
// lastmod por pagina: mtime del archivo que guarda su contenido.
$fecha = static function (array $archivos): string {
    $t = 0;
    foreach ($archivos as $f) {
        $t = max($t, (int) @filemtime(__DIR__ . '/' . $f));
    }
    return $t > 0 ? gmdate('Y-m-d', $t) : gmdate('Y-m-d');
};
$lastmodDe = static function (array $route) use ($fecha): string {
    switch ($route['type']) {
        case 'service': return $fecha(['app/content.php']);
        case 'child':   return $fecha(['app/content/sub/' . $route['slug'] . '.php']);
        case 'guide':   return $fecha(['app/content/guides/' . $route['slug'] . '.php']);
        case 'home':    return $fecha(['app/pages.php', 'app/routes.php', 'app/content.php']);
        default:        return $fecha(['app/pages.php', 'app/routes.php']); // paginas fijas
    }
};
header('Content-Type: application/xml; charset=utf-8');
header('X-Robots-Tag: noindex');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach ($routes as $path => $route) {
    if (!$route['indexable']) { continue; }
    echo '  <url><loc>' . h(obra_url($config, $path)) . '</loc><lastmod>' . $lastmodDe($route) . '</lastmod></url>' . "\n";
}
echo '</urlset>' . "\n";
