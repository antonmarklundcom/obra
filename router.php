<?php
declare(strict_types=1);
// Router para el servidor embebido de PHP (solo desarrollo local).
// Imita las reglas de .htaccess: estaticos directos, /sitemap.xml dinamico, resto a index.php.
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
if ($path === '/sitemap.xml') { require __DIR__ . '/sitemap.php'; return true; }
if ($path === '/sitemap.php') { header('Location: /sitemap.xml', true, 301); return true; }
if (preg_match('#^/(app|config|docs|tools)(/|$)#', $path)) { http_response_code(404); return true; }
$file = __DIR__ . str_replace('/', DIRECTORY_SEPARATOR, $path);
if ($path !== '/' && is_file($file)) { return false; }
require __DIR__ . '/index.php';
