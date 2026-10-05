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
$funnel = [];
foreach (array_unique($files) as $file) {
    if (!is_file($file)) { continue; }
    foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
        $f = explode("\t", $line);
        if (count($f) < 5 || $f[0] < $since) { continue; }
        [$d, $e, $pl, $pg, $sv] = $f;
        $total++;
        $funnel[$pg][$e] = ($funnel[$pg][$e] ?? 0) + 1;
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
<h2>Consultas y entrega por página</h2>
<p>Vistas = cargas de página, no personas únicas. Los clics no son mensajes enviados. Una consulta confirmada se cuenta cuando CRM o email acepta la entrega; la calificación comercial se revisa en el CRM.</p>
<div style="overflow:auto"><table><thead><tr><th>Página</th><th>Vistas</th><th>Clics WhatsApp</th><th>Formularios válidos</th><th>Entregados</th><th>Fallos</th><th>Entrega / vistas</th></tr></thead><tbody>
<?php uasort($funnel, fn($a, $b) => ($b['page_view'] ?? 0) <=> ($a['page_view'] ?? 0)); foreach ($funnel as $path => $row): $views = $row['page_view'] ?? 0; $leads = $row['form_lead'] ?? 0; ?>
<tr><td><?= h($path) ?></td><td><?= $views ?></td><td><?= $row['whatsapp_click'] ?? 0 ?></td><td><?= $row['form_attempt'] ?? 0 ?></td><td><?= $leads ?></td><td><?= $row['form_delivery_failed'] ?? 0 ?></td><td><?= $views > 0 ? number_format(100 * $leads / $views, 1) . '%' : '—' ?></td></tr>
<?php endforeach; ?></tbody></table></div>
<p>La atribución de un formulario usa su página de origen. Las vistas del formulario también se muestran por separado. Compará períodos completos: recargas, navegación y bloqueadores pueden cambiar los conteos.</p>
<?php
$table('Por tipo', $by['event']);
$table('Páginas con más acciones', $by['page']);
$table('Ubicación del botón', $by['placement']);
$table('Por servicio', $by['service']);
$table('Por día', $by['day'], 60);
?></body></html>
