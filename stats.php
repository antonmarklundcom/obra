<?php
declare(strict_types=1);

// Resumen privado de eventos propios. Acceso: formulario POST con el token (stats_token, 16+ caracteres) que abre
// una sesion de 1 hora. Sin token configurado, token incorrecto o GET sin sesion: 404 (con el formulario si hay token).
$config = require __DIR__ . '/config/site.php';
require_once __DIR__ . '/app/helpers.php';
require_once __DIR__ . '/app/events.php';
require_once __DIR__ . '/app/form-state.php';
obra_security_headers();
header('Referrer-Policy: no-referrer');
header('X-Robots-Tag: noindex, nofollow');
$token = (string) ($config['stats_token'] ?? '');
if ($token === '' || strlen($token) < 16) { http_response_code(404); echo 'No encontrado.'; exit; }
obra_form_session();
$meses = max(1, min(13, (int) ($_GET['meses'] ?? 1)));
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $given = $_POST['token'] ?? '';
    if (is_string($given) && hash_equals($token, $given)) {
        session_regenerate_id(true);
        $_SESSION['obra_stats'] = time();
        header('Location: /stats.php' . ($meses > 1 ? '?meses=' . $meses : ''), true, 303);
        exit;
    }
    unset($_SESSION['obra_stats']);
}
if ((int) ($_SESSION['obra_stats'] ?? 0) < time() - 3600) {
    unset($_SESSION['obra_stats']);
    http_response_code(404);
    ?><!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex,nofollow"><title>No encontrado</title>
<link rel="stylesheet" href="<?= h(obra_asset('/assets/css/stats.css')) ?>"></head><body><p>No encontrado.</p>
<form method="post" action="/stats.php<?= $meses > 1 ? '?meses=' . $meses : '' ?>"><label>Token <input type="password" name="token" autocomplete="current-password" required></label> <button type="submit">Entrar</button></form></body></html><?php
    exit;
}

// Retencion: se borran los archivos de eventos de mas de 13 meses (se conservan el mes actual y los 12 anteriores).
$monthIndex = static fn(string $ym): int => (int) substr($ym, 0, 4) * 12 + (int) substr($ym, 5, 2) - 1;
$current = $monthIndex(gmdate('Y-m'));
foreach (glob(obra_storage_dir() . '/events-*.log') ?: [] as $old) {
    if (preg_match('/events-(\d{4}-\d{2})\.log$/', $old, $m) && $monthIndex($m[1]) < $current - 12) { @unlink($old); }
}

$sinceTs = (int) strtotime(gmdate('Y-m-d') . ' -' . $meses . ' months');
$days = (int) round((time() - $sinceTs) / 86400);
$since = gmdate('Y-m-d', $sinceTs);
$files = [];
for ($i = $monthIndex(gmdate('Y-m', $sinceTs)); $i <= $current; $i++) { $files[] = obra_storage_dir() . sprintf('/events-%04d-%02d.log', intdiv($i, 12), $i % 12 + 1); }
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
<link rel="stylesheet" href="<?= h(obra_asset('/assets/css/stats.css')) ?>"></head><body>
<h1>Eventos de los últimos <?= $days ?> días</h1><p>Período: <?php foreach ([1, 3, 6, 12, 13] as $n): ?><?= $n === $meses ? '<strong>' . $n . ' ' . ($n === 1 ? 'mes' : 'meses') . '</strong>' : '<a href="/stats.php?meses=' . $n . '">' . $n . ' ' . ($n === 1 ? 'mes' : 'meses') . '</a>' ?> <?php endforeach; ?></p><p><?= $total ?> eventos. Sin cookies ni datos personales.</p>
<h2>Consultas y entrega por página</h2>
<p>Vistas = cargas de página, no personas únicas. Los clics no son mensajes enviados. Una consulta confirmada se cuenta cuando CRM o email acepta la entrega; la calificación comercial se revisa en el CRM.</p>
<div class="table-scroll"><table><thead><tr><th>Página</th><th>Vistas</th><th>Clics WhatsApp</th><th>Formularios válidos</th><th>Entregados</th><th>Fallos</th><th>Entrega / vistas</th></tr></thead><tbody>
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
