<?php
declare(strict_types=1);

// Medicion propia sin cookies ni datos personales: una linea por evento (fecha, evento, ubicacion, pagina, servicio).
// Sin IP, sin user agent, sin identificadores. Archivo mensual en storage/ (bloqueado por .htaccess).
function obra_storage_dir(): string
{
    $dir = getenv('OBRA_STORAGE');
    return ($dir !== false && $dir !== '') ? rtrim($dir, '/\\') : dirname(__DIR__) . '/storage';
}

function obra_event_clean(string $value, string $pattern, int $max): string
{
    $value = substr($value, 0, $max);
    return preg_match($pattern, $value) === 1 ? $value : '';
}

// Devuelve true si el evento se acepto (aunque no se pueda escribir el archivo: medir nunca rompe la pagina).
function obra_event_log(string $event, string $placement, string $path, string $service): bool
{
    if (!in_array($event, ['whatsapp_click', 'tel_click', 'form_lead'], true)) { return false; }
    $placement = obra_event_clean($placement, '/^[a-z0-9-]*$/', 24);
    $path = obra_event_clean($path, '#^/[a-z0-9/-]*$#', 120);
    $service = obra_event_clean($service, '/^[a-z0-9-]*$/', 40);
    if ($path === '') { return false; }
    $dir = obra_storage_dir();
    if (!is_dir($dir)) { return true; }
    $line = gmdate('Y-m-d') . "\t" . $event . "\t" . $placement . "\t" . $path . "\t" . $service . "\n";
    @file_put_contents($dir . '/events-' . gmdate('Y-m') . '.log', $line, FILE_APPEND | LOCK_EX);
    return true;
}
