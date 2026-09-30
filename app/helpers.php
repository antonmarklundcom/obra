<?php
declare(strict_types=1);

function h(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// Version por mtime para /assets/*: evita que un navegador sirva un site.js/site.css viejo desde cache tras un deploy.
function obra_asset(string $path): string
{
    $file = __DIR__ . '/../' . ltrim($path, '/');
    $v = is_file($file) ? (string) filemtime($file) : '0';
    return $path . '?v=' . $v;
}

function obra_len(string $value): int
{
    return function_exists('mb_strlen') ? mb_strlen($value, 'UTF-8') : strlen($value);
}

function obra_cut(string $value, int $max): string
{
    return function_exists('mb_substr') ? mb_substr($value, 0, $max, 'UTF-8') : substr($value, 0, $max);
}

function obra_raw_path(): string
{
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    return '/' . ltrim($path, '/');
}

function obra_path(): string
{
    $path = obra_raw_path();
    if ($path !== '/' && !str_contains(basename($path), '.')) {
        $path = rtrim($path, '/') . '/';
    }
    return $path;
}

function obra_url(array $config, string $path = '/'): string
{
    return rtrim($config['origin'], '/') . ($path === '/' ? '/' : '/' . ltrim($path, '/'));
}

function obra_phone_ready(array $config): bool
{
    return (bool) preg_match('/^5959\d{8}$/', (string) $config['whatsapp']);
}

function obra_phone_display(array $config): string
{
    if (!obra_phone_ready($config)) { return ''; }
    $n = $config['whatsapp'];
    return '+595 ' . substr($n, 3, 3) . ' ' . substr($n, 6, 3) . ' ' . substr($n, 9);
}

function obra_whatsapp(array $config, string $message): ?string
{
    return obra_phone_ready($config)
        ? 'https://wa.me/' . $config['whatsapp'] . '?text=' . rawurlencode($message)
        : null;
}

// Mensajes de WhatsApp: todos viven en app/wa-messages.php (uno por pagina y ubicacion).
function obra_wa_messages(): array
{
    static $messages = null;
    if ($messages === null) {
        $file = __DIR__ . '/wa-messages.php';
        $messages = is_file($file) ? (array) require $file : [];
    }
    return $messages;
}

// Ubicacion efectiva: /gracias/ usa 'thanks' y la pagina 404 (ruta sin tipo) usa '404' en todos sus enlaces.
function obra_wa_placement(array $route, string $placement): string
{
    $type = (string) ($route['type'] ?? '');
    if ($type === 'thanks') { return 'thanks'; }
    if ($type === '') { return '404'; }
    return $placement;
}

// Texto para un enlace de WhatsApp: pagina+ubicacion -> servicio -> respaldo por ubicacion -> respaldo general.
function obra_wa_text(string $path, string $placement, ?string $serviceSlug = null): string
{
    $m = obra_wa_messages();
    $text = (string) ($m['pages'][$path][$placement]
        ?? ($serviceSlug !== null ? ($m['services'][$serviceSlug] ?? null) : null)
        ?? $m['fallbacks'][$placement]
        ?? $m['fallbacks']['hero']
        ?? '');
    if (trim($text) === '') {
        if (PHP_SAPI === 'cli-server') { throw new RuntimeException("WhatsApp text missing for $path [$placement]"); }
        $text = 'Hola, quiero hacer una consulta sobre una obra.';
    }
    return $text;
}

// Atributos comunes de un enlace de WhatsApp (medicion GA4: ubicacion y servicio).
function obra_wa_attrs(string $placement, ?string $serviceSlug = null): string
{
    return ' target="_blank" rel="noopener" data-wa="' . h($placement) . '"' . ($serviceSlug !== null && $serviceSlug !== '' ? ' data-wa-service="' . h($serviceSlug) . '"' : '');
}

// Mensaje final del formulario, armado con la plantilla 'form' del mapa.
function obra_wa_form_text(array $values): string
{
    $template = (string) (obra_wa_messages()['form'] ?? "Hola, soy {name}. Completé el formulario de obra.com.py desde {page}.\nObra: {service}\nUbicación: {location}\nTerreno: {terrain}\nFinanciación: {financing}\nProyecto: {project}");
    $pairs = [];
    foreach ($values as $key => $value) { $pairs['{' . $key . '}'] = (string) $value; }
    return strtr($template, $pairs);
}

function obra_tel_href(array $config): string
{
    return obra_phone_ready($config) ? 'tel:+' . $config['whatsapp'] : '';
}

// Carga un archivo de contenido por clave desde app/content/{dir}/{clave}.php.
// Primero las claves de $order (orden fijo de menu, sitemap y footer); despues cualquier archivo nuevo, en orden alfabetico.
// Asi cada agente de contenido edita o agrega solo su propio archivo.
function obra_load_content_dir(string $dir, array $order): array
{
    $base = __DIR__ . '/content/' . $dir . '/';
    $files = glob($base . '*.php') ?: [];
    sort($files);
    $keys = array_map(fn($f) => basename($f, '.php'), $files);
    $data = [];
    foreach (array_merge(array_values(array_intersect($order, $keys)), array_diff($keys, $order)) as $key) {
        $data[$key] = require $base . $key . '.php';
    }
    return $data;
}

function obra_json(array $data): string
{
    return (string) json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
}

function obra_faq_schema(array $faqs): array
{
    $entities = [];
    foreach ($faqs as $faq) {
        $entities[] = ['@type' => 'Question', 'name' => $faq[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq[1]]];
    }
    return ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $entities];
}

function obra_security_headers(): void
{
    if (headers_sent()) { return; }
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
    // form-action incluye wa.me porque form.php responde con un 303 hacia WhatsApp
    // y Chrome aplica form-action tambien a las redirecciones de un envio.
    header("Content-Security-Policy: default-src 'self'; base-uri 'self'; form-action 'self' https://wa.me; frame-ancestors 'self'; object-src 'none'; img-src 'self' data: https://*.google-analytics.com https://*.googletagmanager.com; style-src 'self' 'unsafe-inline'; script-src 'self' https://www.googletagmanager.com; connect-src 'self' https://*.google-analytics.com https://*.analytics.google.com https://*.googletagmanager.com; font-src 'self'");
}

function obra_breadcrumb_schema(array $config, array $items): array
{
    $elements = [];
    foreach ($items as $index => $item) {
        $elements[] = ['@type' => 'ListItem', 'position' => $index + 1, 'name' => $item['label'], 'item' => obra_url($config, $item['path'])];
    }
    return ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $elements];
}

// Migas de pan de cualquier ruta: Inicio > Servicios > Servicio > Especialidad, o Inicio > Guías > Guía.
function obra_breadcrumbs(array $content, array $route, string $path): array
{
    $items = [['label' => 'Inicio', 'path' => '/']];
    switch ($route['type']) {
        case 'service':
            $items[] = ['label' => 'Servicios', 'path' => '/servicios/'];
            $items[] = ['label' => $content['services'][$route['slug']]['name'], 'path' => $path];
            break;
        case 'child':
            $items[] = ['label' => 'Servicios', 'path' => '/servicios/'];
            $items[] = ['label' => $content['services'][$route['slug']]['name'], 'path' => '/' . $route['slug'] . '/'];
            $items[] = ['label' => $content['children'][$route['slug']][$route['child']]['name'], 'path' => $path];
            break;
        case 'guide':
            $items[] = ['label' => 'Guías', 'path' => '/guias/'];
            $items[] = ['label' => $content['guides'][$route['slug']]['name'], 'path' => $path];
            break;
        default:
            $items[] = ['label' => $route['h1'], 'path' => $path];
    }
    return $items;
}

function obra_safe_return(string $value, string $fallback = '/cotizar/'): string
{
    // Solo rutas internas relativas: nada con esquema, host o caracteres raros.
    $parts = parse_url($value);
    if ($parts === false || isset($parts['scheme']) || isset($parts['host'])) { return $fallback; }
    $path = (string) ($parts['path'] ?? '');
    return preg_match('#^/(?!/)[a-z0-9/_-]*$#', $path) ? $path : $fallback;
}

function obra_add_query(string $path, array $query): string
{
    return $path . (str_contains($path, '?') ? '&' : '?') . http_build_query($query);
}
