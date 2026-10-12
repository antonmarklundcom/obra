<?php
declare(strict_types=1);

// Limite simple por IP y ventana fija, en archivos: <storage>/ratelimit/<sha256(ip + fecha + bucket)>.
// Nunca guarda la IP en claro. Si storage/ no existe o no se puede escribir, no limita (medir y consultar nunca se rompen).
require_once __DIR__ . '/events.php';

function obra_rate_limited(string $bucket, int $limit, int $windowSeconds): bool
{
    $dir = obra_storage_dir() . '/ratelimit';
    if (!is_dir($dir) && (!is_dir(obra_storage_dir()) || (!@mkdir($dir, 0700) && !is_dir($dir)))) { return false; }
    $now = time();
    // Poda: archivos sin uso durante mas de una ventana.
    foreach (glob($dir . '/*') ?: [] as $old) {
        if ((int) @filemtime($old) < $now - $windowSeconds) { @unlink($old); }
    }
    $ip = (string) ($_SERVER['REMOTE_ADDR'] ?? '');
    $file = $dir . '/' . hash('sha256', $ip . gmdate('Y-m-d') . $bucket);
    $fh = @fopen($file, 'c+');
    if ($fh === false) { return false; }
    try {
        if (!flock($fh, LOCK_EX)) { return false; }
        [$start, $count] = array_map('intval', explode(' ', trim((string) stream_get_contents($fh)) . ' 0 0'));
        if ($start <= 0 || $now - $start >= $windowSeconds) { $start = $now; $count = 0; }
        $count++;
        ftruncate($fh, 0); rewind($fh); fwrite($fh, $start . ' ' . $count);
        fflush($fh);
        return $count > $limit;
    } finally {
        flock($fh, LOCK_UN);
        fclose($fh);
    }
}

// Rechaza pedidos de otros sitios cuando el navegador manda Sec-Fetch-Site (sin la cabecera se acepta: navegadores viejos, curl).
function obra_cross_site_request(): bool
{
    $site = strtolower((string) ($_SERVER['HTTP_SEC_FETCH_SITE'] ?? ''));
    return $site !== '' && $site !== 'same-origin' && $site !== 'none';
}
