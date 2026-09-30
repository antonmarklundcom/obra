<?php
declare(strict_types=1);

// Receptor de eventos del navegador (clic en WhatsApp o telefono). POST JSON pequeno, responde 204.
require_once __DIR__ . '/app/events.php';
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') { header('Allow: POST'); http_response_code(405); exit; }
header('Cache-Control: no-store');
$ua = strtolower((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''));
if ($ua === '' || preg_match('/bot|crawl|spider|slurp|headless|curl|python|wget/', $ua)) { http_response_code(204); exit; }
$raw = file_get_contents('php://input', false, null, 0, 600);
$data = json_decode((string) $raw, true);
if (is_array($data)) {
    obra_event_log((string) ($data['e'] ?? ''), (string) ($data['p'] ?? ''), (string) ($data['u'] ?? ''), (string) ($data['s'] ?? ''));
}
http_response_code(204);
