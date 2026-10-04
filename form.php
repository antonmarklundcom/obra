<?php
declare(strict_types=1);

$config = require __DIR__ . '/config/site.php';
require_once __DIR__ . '/app/helpers.php';
require_once __DIR__ . '/app/conversion.php';
require_once __DIR__ . '/app/form-state.php';
$content = require __DIR__ . '/app/content.php';
obra_security_headers();

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    header('Allow: POST'); http_response_code(405); echo 'Método no permitido.'; exit;
}

obra_form_session();

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
        . "Origen: " . $f['origin_path'] . " (" . $f['placement'] . ")\n"
        . (isset($f['gclid']) || isset($f['utm_campaign']) ? "Anuncio: " . ($f['utm_campaign'] ?? '-') . " / " . ($f['utm_term'] ?? '-') . (isset($f['gclid']) ? " (Google Ads)" : '') . "\n" : '')
        . "\n"
        . "Proyecto:\n" . $f['project'] . "\n";
    $subject = '=?UTF-8?B?' . base64_encode('Consulta web: ' . $labels['service']) . '?=';
    $headers = "From: Obra <no-reply@" . $config['domain'] . ">\r\nReply-To: " . $to . "\r\nContent-Type: text/plain; charset=UTF-8\r\nX-Mailer: obra-site";
    return @mail($to, $subject, $body, $headers);
}

$returnPath = obra_safe_return(obra_post('return_path', 300), '/cotizar/');
if (obra_post('website', 200) !== '') { header('Location: /gracias/', true, 303); exit; }
$values = [];
foreach (['name', 'phone', 'service', 'specialty', 'location', 'terrain', 'financing', 'message', 'consent', 'origin_path'] as $key) { $values[$key] = obra_post($key, $key === 'message' ? 1600 : 300); }
$started = (int) obra_post('started_at', 20);
if ($started <= 0 || time() - $started < 2 || time() - $started > 86400) { obra_form_save($values); header('Location: ' . obra_add_query($returnPath, ['error' => 'tiempo']), true, 303); exit; }
$name = obra_post('name', 100); $phone = obra_phone(obra_post('phone', 40));
$service = obra_post('service', 80); $specialty = obra_post('specialty', 80);
$location = obra_post('location', 120); $terrain = obra_post('terrain', 20); $financing = obra_post('financing', 20); $messageText = obra_post('message', 1600);
$consent = obra_post('consent', 5) === '1'; $serviceValid = isset($content['services'][$service]) || $service === 'otro';
if (!isset($content['children'][$service][$specialty])) { $specialty = ''; }
$small = obra_is_small_enquiry($service, $specialty); $errors = [];
if ($name === '') { $errors['name'] = 'Completá tu nombre.'; }
if (!preg_match('/^5959\d{8}$/', $phone)) { $errors['phone'] = 'Usá un WhatsApp paraguayo válido, por ejemplo 0981 123 456.'; }
if (!$serviceValid) { $errors['service'] = 'Elegí el servicio que necesitás.'; }
if ($location === '') { $errors['location'] = 'Indicá ciudad o barrio.'; }
if ((!$small || $terrain !== '') && !isset($content['terrain'][$terrain])) { $errors['terrain'] = 'Indicá la situación del terreno.'; }
if ((!$small || $financing !== '') && !isset($content['financing'][$financing])) { $errors['financing'] = 'Elegí una opción de financiación.'; }
if (obra_len($messageText) < 20) { $errors['message'] = 'Describí el proyecto en al menos 20 caracteres.'; }
if (!$consent) { $errors['consent'] = 'Aceptá el uso de tus datos para responder la consulta.'; }
$values['service'] = $serviceValid ? $service : ''; $values['specialty'] = $specialty;
if ($errors) { obra_form_save($values, $errors); header('Location: ' . obra_add_query($returnPath, ['error' => 'campos', 'servicio' => $values['service'], 'especialidad' => $specialty]), true, 303); exit; }
$pageUrl = obra_post('page_url', 500);
if ($pageUrl === '' || !str_starts_with($pageUrl, $config['origin'] . '/')) { $pageUrl = obra_url($config, '/cotizar/'); }
// Strip query strings: form contents and private receipt IDs never go to CRM attribution.
$pageUrl = strtok($pageUrl, '?') ?: obra_url($config, '/cotizar/');
$labels = ['service' => $service === 'otro' ? 'otro tipo de obra' : $content['services'][$service]['name'], 'terrain' => $content['terrain'][$terrain] ?? 'No indicado', 'financing' => $content['financing'][$financing] ?? 'No indicado'];
if ($specialty !== '') { $labels['service'] .= ' · ' . $content['children'][$service][$specialty]['name']; }
$originPath = obra_safe_return(obra_post('origin_path', 300), '/cotizar/');
$placement = preg_replace('/[^a-z0-9-]/', '', obra_post('placement', 20)) ?: 'form';
$message = obra_wa_form_text(['name' => $name, 'service' => $labels['service'], 'location' => $location, 'terrain' => $labels['terrain'], 'financing' => $labels['financing'], 'project' => $messageText, 'page' => $originPath]);
$attribution = [];
foreach (obra_attribution_keys() as $key) { $v = preg_replace('/[^A-Za-z0-9_\-\.\/%+ ]/', '', obra_post($key, 200)) ?? ''; if ($v !== '') { $attribution[$key] = $v; } }
$payload = ['name' => $name, 'phone' => '+' . $phone, 'message' => $message, 'source' => 'site:obra-com-py', 'page_url' => $pageUrl, 'idempotency_key' => bin2hex(random_bytes(16)), 'fields' => ['service' => $service, 'specialty' => $specialty, 'location' => $location, 'terrain' => $terrain, 'financing' => $financing, 'project' => $messageText, 'origin_path' => $originPath, 'placement' => $placement, 'submitted_at' => gmdate('c')] + $attribution];
require_once __DIR__ . '/app/events.php';
obra_event_log('form_attempt', $placement, $originPath, $service === 'otro' ? '' : $service);
$crm = obra_crm_send($config, $payload); $mailed = obra_mail_send($config, $payload, $labels);
$state = $crm['ok'] ? 'crm-confirmado' : ($mailed ? 'enviado' : 'sin-canales');
obra_event_log($state === 'sin-canales' ? 'form_delivery_failed' : 'form_lead', $placement, $originPath, $service === 'otro' ? '' : $service);
if ($crm['ok']) { obra_event_log('crm_delivered', $placement, $originPath, $service === 'otro' ? '' : $service); }
if ($mailed) { obra_event_log('email_delivered', $placement, $originPath, $service === 'otro' ? '' : $service); }
obra_form_save($state === 'sin-canales' ? $values : []);
$receipt = bin2hex(random_bytes(16));
$_SESSION['obra_form']['receipt'] = ['id' => $receipt, 'state' => $state, 'wa' => obra_whatsapp($config, $message), 'service' => $service, 'specialty' => $specialty, 'origin' => $originPath];
header('Location: /gracias/?recibo=' . $receipt, true, 303); exit;
