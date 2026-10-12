<?php
declare(strict_types=1);

// Envio al CRM (VenderCRM, POST JSON con X-Api-Key). Lo usan form.php y tools/replay-leads.php con las mismas cabeceras.
// Nunca registra nombres, telefonos ni texto del mensaje: solo estado HTTP y error de curl.
require_once __DIR__ . '/events.php';

/**
 * @param array<string, mixed> $config
 * @param array<string, mixed> $payload
 * @return array{ok: bool, status: int}
 */
function obra_crm_send(array $config, array $payload): array
{
    $mock = strtolower((string) (getenv('OBRA_CRM_MOCK') ?: ''));
    if ($mock !== '') { return $mock === 'success' ? ['ok' => true, 'status' => 201] : ['ok' => false, 'status' => 503]; }
    if ($config['crm_endpoint'] === '' || $config['crm_api_key'] === '') { error_log('obra-crm status=0 curl=not-configured'); return ['ok' => false, 'status' => 0]; }
    if (!filter_var($config['crm_endpoint'], FILTER_VALIDATE_URL) || !str_starts_with($config['crm_endpoint'], 'https://') || !function_exists('curl_init')) { error_log('obra-crm status=0 curl=invalid-endpoint-or-no-curl'); return ['ok' => false, 'status' => 0]; }
    $ch = curl_init($config['crm_endpoint']);
    curl_setopt_array($ch, [CURLOPT_POST => true, CURLOPT_RETURNTRANSFER => true, CURLOPT_CONNECTTIMEOUT => 5, CURLOPT_TIMEOUT => 12, CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Accept: application/json', 'X-Api-Key: ' . $config['crm_api_key']], CURLOPT_POSTFIELDS => obra_json($payload)]);
    curl_exec($ch); $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE); $curlError = curl_error($ch); curl_close($ch);
    $ok = in_array($status, [200, 201, 202], true);
    if (!$ok) { error_log('obra-crm status=' . $status . ' curl=' . substr(preg_replace('/[^\x20-\x7e]/', '', $curlError) ?? '', 0, 200)); }
    return ['ok' => $ok, 'status' => $status];
}

// Cola de leads que el CRM no acepto: storage/leads-pending/<idempotency_key>.json. tools/replay-leads.php los reenvia.
function obra_crm_pending_dir(): string
{
    return obra_storage_dir() . '/leads-pending';
}

// Mejor esfuerzo: un fallo al escribir nunca cambia lo que ve la persona.
/** @param array<string, mixed> $payload */
function obra_crm_spool(array $payload): bool
{
    $key = (string) ($payload['idempotency_key'] ?? '');
    if (!preg_match('/^[a-f0-9]{32}$/', $key)) { return false; }
    $dir = obra_crm_pending_dir();
    if (!is_dir($dir) && !@mkdir($dir, 0700, true) && !is_dir($dir)) { error_log('obra-crm spool=mkdir-failed'); return false; }
    $file = $dir . '/' . $key . '.json';
    if (@file_put_contents($file, obra_json($payload), LOCK_EX) === false) { error_log('obra-crm spool=write-failed'); return false; }
    @chmod($file, 0600);
    return true;
}
