<?php
declare(strict_types=1);

// Resumen privado de eventos propios. Solo responde con ?token=... igual a stats_token (config/local.php); si no, 404.
$config = require __DIR__ . '/config/site.php';
require_once __DIR__ . '/app/helpers.php';
require_once __DIR__ . '/app/events.php';
obra_security_headers();
$token = (string) ($config['stats_token'] ?? '');
$given = (string) ($_GET['token'] ?? '');
if ($token === '' || strlen($token) < 16 || !hash_equals($token, $given)) { http_response_code(404); echo 'No encontrado.'; exit; }
header('X-Robots-Tag: noindex, nofollow');
header('Cache-Control: no-store');

$days = 30;
$since = gmdate('Y-m-d', time() - $days * 86400);
$files = [obra_storage_dir() . '/events-' . gmdate('Y-m', time() - 32 * 86400) . '.log', obra_storage_dir() . '/events-' . gmdate('Y-m') . '.log'];
$by = ['event' => [], 'page' => [], 'placement' => [], 'service' => [], 'day' => []];
$total = 0;
foreach (array_unique($files) as $file) {
    if (!is_file($file)) { continue; }
    foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
        $f = explode("\t", $line);
        if (count($f) < 5 || $f[0] < $since) { continue; }
        [$d, $e, $pl, $pg, $sv] = $f;
        $total++;
        foreach (['event' => $e, 'page' => $e . ' ' . $pg, 'placement' => $e . ' ' . ($pl ?: '-'), 'service' => $sv !== '' ? $e . ' ' . $sv : null, 'day' => $d . ' ' . $e] as $k => $v) {
            if ($v !== null) { $by[$k][$v] = ($by[$k][$v] ?? 0) + 1; }
        }
    }
}
$table = static function (string $title, array $rows, int $limit = 15): void {
    arsort($rows);
    echo '<h2>' . h($title) . '</h2><table>';
    foreach (array_slice($rows, 0, $limit, true) as $k => $n) { echo '<tr><td>' . h((string) $k) . '</td><td>' . (int) $n . '</td></tr>'; }
    echo $rows === [] ? '<tr><td>Sin datos</td><td></td></tr>' : '';
    echo '</table>';
};
krsort($by['day']);
?><!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex,nofollow"><title>Estadísticas</title>
<style>body{font:16px system-ui;margin:2rem auto;max-width:720px;padding:0 1rem}table{border-collapse:collapse;width:100%}td{border-bottom:1px solid #ddd;padding:.35rem .5rem}td+td{text-align:right}</style></head><body>
<h1>Eventos de los últimos <?= $days ?> días</h1><p><?= $total ?> eventos. Sin cookies ni datos personales.</p>
<?php
$table('Por tipo', $by['event']);
$table('Páginas con más acciones', $by['page']);
$table('Ubicación del botón', $by['placement']);
$table('Por servicio', $by['service']);
$table('Por día', $by['day'], 60);
?></body></html>
