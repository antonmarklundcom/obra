<?php
declare(strict_types=1);
// Sitemap dinamico: Apache reescribe /sitemap.xml a este archivo (ver .htaccess).
$config = require __DIR__ . '/config/site.php';
require_once __DIR__ . '/app/helpers.php';
$content = require __DIR__ . '/app/content.php';
require_once __DIR__ . '/app/routes.php';
$routes = obra_routes($content);
$lastmod = 0;
foreach (['app/content.php', 'app/pages.php', 'app/routes.php', 'app/layout.php'] as $file) {
    $lastmod = max($lastmod, (int) @filemtime(__DIR__ . '/' . $file));
}
$lastmod = $lastmod > 0 ? gmdate('Y-m-d', $lastmod) : gmdate('Y-m-d');
header('Content-Type: application/xml; charset=utf-8');
header('X-Robots-Tag: noindex');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach ($routes as $path => $route) {
    if (!$route['indexable']) { continue; }
    echo '  <url><loc>' . h(obra_url($config, $path)) . '</loc><lastmod>' . $lastmod . '</lastmod></url>' . "\n";
}
echo '</urlset>' . "\n";
