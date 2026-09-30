<?php
declare(strict_types=1);

$config = require __DIR__ . '/config/site.php';
require_once __DIR__ . '/app/helpers.php';
$content = require __DIR__ . '/app/content.php';
obra_security_headers();

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    header('Allow: POST'); http_response_code(405); echo 'Método no permitido.'; exit;
}

function obra_post(string $key, int $max = 500): string
{
    $value = $_POST[$key] ?? '';
    if (!is_scalar($value)) { return ''; }
    return obra_cut(trim((string) $value), $max);
}

function obra_phone(string $value): string
{
    $digits = preg_replace('/\D+/', '', $value) ?: '';
    if (str_starts_with($digits, '0')) { $digits = '595' . substr($digits, 1); }
    elseif (strlen($digits) === 9 && str_starts_with($digits, '9')) { $digits = '595' . $digits; }
    return $digits;
}

function obra_crm_send(array $config, array $payload): array
{
    $mock = strtolower((string) (getenv('OBRA_CRM_MOCK') ?: ''));
    if ($mock !== '') { return $mock === 'success' ? ['ok' => true, 'status' => 201] : ['ok' => false, 'status' => 503]; }
    if ($config['crm_endpoint'] === '' || $config['crm_api_key'] === '') { return ['ok' => false, 'status' => 0]; }
    if (!filter_var($config['crm_endpoint'], FILTER_VALIDATE_URL) || !str_starts_with($config['crm_endpoint'], 'https://') || !function_exists('curl_init')) { return ['ok' => false, 'status' => 0]; }
    $ch = curl_init($config['crm_endpoint']);
    curl_setopt_array($ch, [CURLOPT_POST => true, CURLOPT_RETURNTRANSFER => true, CURLOPT_CONNECTTIMEOUT => 5, CURLOPT_TIMEOUT => 12, CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Accept: application/json', 'X-Api-Key: ' . $config['crm_api_key']], CURLOPT_POSTFIELDS => obra_json($payload)]);
    curl_exec($ch); $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE); curl_close($ch);
    return ['ok' => in_array($status, [200, 201, 202], true), 'status' => $status];
}

// Tercer canal: aviso por email al buzon configurado (mail() de Hostinger). Mejor esfuerzo, nunca bloquea.
function obra_mail_send(array $config, array $payload, array $labels): bool
{
    $to = (string) ($config['email'] ?? '');
    if ($to === '' || !filter_var($to, FILTER_VALIDATE_EMAIL) || !function_exists('mail')) { return false; }
    $f = $payload['fields'];
    $body = "Nueva consulta desde " . $config['domain'] . "\n\n"
        . "Nombre: " . $payload['name'] . "\n"
        . "WhatsApp: " . $payload['phone'] . "\n"
        . "Servicio: " . $labels['service'] . "\n"
        . "Ubicación: " . $f['location'] . "\n"
        . "Terreno: " . $labels['terrain'] . "\n"
        . "Financiación: " . $labels['financing'] . "\n"
        . "Página: " . $payload['page_url'] . "\n"
        . "Origen: " . $f['origin_path'] . " (" . $f['placement'] . ")\n\n"
        . "Proyecto:\n" . $f['project'] . "\n";
    $subject = '=?UTF-8?B?' . base64_encode('Consulta web: ' . $labels['service']) . '?=';
    $headers = "From: Obra <no-reply@" . $config['domain'] . ">\r\nReply-To: " . $to . "\r\nContent-Type: text/plain; charset=UTF-8\r\nX-Mailer: obra-site";
    return @mail($to, $subject, $body, $headers);
}

$returnPath = obra_safe_return(obra_post('return_path', 300), '/cotizar/');
if (obra_post('website', 200) !== '') { header('Location: /gracias/?estado=enviado', true, 303); exit; }
$started = (int) obra_post('started_at', 20);
if ($started <= 0 || time() - $started < 2 || time() - $started > 86400) { header('Location: ' . obra_add_query($returnPath, ['error' => 'tiempo']), true, 303); exit; }

$name = obra_post('name', 100);
$phone = obra_phone(obra_post('phone', 40));
$service = obra_post('service', 80);
$location = obra_post('location', 120);
$terrain = obra_post('terrain', 20);
$financing = obra_post('financing', 20);
$messageText = obra_post('message', 1600);
$consent = obra_post('consent', 5) === '1';
$serviceValid = isset($content['services'][$service]) || $service === 'otro';
if ($name === '' || !preg_match('/^5959\d{8}$/', $phone) || !$serviceValid || $location === ''
    || !isset($content['terrain'][$terrain]) || !isset($content['financing'][$financing])
    || obra_len($messageText) < 20 || !$consent) {
    header('Location: ' . obra_add_query($returnPath, ['error' => 'campos', 'servicio' => $serviceValid ? $service : '']), true, 303); exit;
}

$pageUrl = obra_post('page_url', 500);
if ($pageUrl === '' || !str_starts_with($pageUrl, $config['origin'] . '/')) { $pageUrl = obra_url($config, '/cotizar/'); }

$labels = [
    'service' => $service === 'otro' ? 'otro tipo de obra' : $content['services'][$service]['name'],
    'terrain' => $content['terrain'][$terrain],
    'financing' => $content['financing'][$financing],
];
$originPath = obra_safe_return(obra_post('origin_path', 300), '/cotizar/');
$placement = preg_replace('/[^a-z0-9-]/', '', obra_post('placement', 20)) ?: 'form';
$message = obra_wa_form_text([
    'name' => $name, 'service' => $labels['service'], 'location' => $location, 'terrain' => $labels['terrain'],
    'financing' => $labels['financing'], 'project' => $messageText, 'page' => $originPath,
]);
$payload = [
    'name' => $name,
    'phone' => '+' . $phone,
    'message' => $message,
    'source' => 'site:obra-com-py',
    'page_url' => $pageUrl,
    'idempotency_key' => bin2hex(random_bytes(16)),
    'fields' => ['service' => $service, 'location' => $location, 'terrain' => $terrain, 'financing' => $financing, 'project' => $messageText, 'origin_path' => $originPath, 'placement' => $placement, 'submitted_at' => gmdate('c')],
];
$crm = obra_crm_send($config, $payload);
$mailed = obra_mail_send($config, $payload, $labels);
$wa = obra_whatsapp($config, $message);
if ($wa !== null) { header('Location: ' . $wa, true, 303); exit; }
$state = $crm['ok'] ? 'crm-confirmado' : ($mailed ? 'enviado' : 'sin-canales');
header('Location: /gracias/?estado=' . $state, true, 303); exit;
