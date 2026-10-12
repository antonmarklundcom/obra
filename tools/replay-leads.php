<?php
declare(strict_types=1);

// Reenvia al CRM los leads que quedaron en storage/leads-pending/ (form.php los guarda cuando el CRM falla).
// Solo por consola: php tools/replay-leads.php   (Hostinger: cron semanal, ver docs/LAUNCH-CHECKLIST.md)
// Borra cada archivo aceptado (2xx); los demas quedan para el proximo intento. Mismo idempotency_key: el CRM no duplica.
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }

$root = dirname(__DIR__);
$config = require $root . '/config/site.php';
require_once $root . '/app/helpers.php';
require_once $root . '/app/crm.php';

$dir = obra_crm_pending_dir();
$files = is_dir($dir) ? (glob($dir . '/*.json') ?: []) : [];
$sent = 0; $kept = 0; $invalid = 0;
foreach ($files as $file) {
    $payload = json_decode((string) file_get_contents($file), true);
    if (!is_array($payload) || !preg_match('/^[a-f0-9]{32}$/', (string) ($payload['idempotency_key'] ?? ''))) { $invalid++; continue; }
    $result = obra_crm_send($config, $payload);
    if ($result['ok']) { @unlink($file); $sent++; } else { $kept++; }
}
echo 'replay-leads: ' . count($files) . ' pending, ' . $sent . ' sent, ' . $kept . ' kept, ' . $invalid . ' invalid (' . $dir . ")\n";
exit($kept + $invalid > 0 ? 1 : 0);
