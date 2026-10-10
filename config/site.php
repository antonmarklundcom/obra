<?php
declare(strict_types=1);

function obra_env(string $key, string $default = ''): string
{
    $value = getenv($key);
    return $value === false ? $default : trim((string) $value);
}

$config = [
    'name' => 'Obra',
    'domain' => obra_env('OBRA_DOMAIN', 'obra.com.py'),
    'origin' => rtrim(obra_env('OBRA_ORIGIN', 'https://obra.com.py'), '/'),
    // WhatsApp etapa 1 (docs/seo/obra-com-py-site-structure.md). Solo digitos: 5959XXXXXXXX.
    'whatsapp' => obra_env('OBRA_WHATSAPP', '595992279599'),
    'email' => obra_env('OBRA_EMAIL'),
    'legal_operator' => obra_env('OBRA_LEGAL_OPERATOR'),
    'ruc' => obra_env('OBRA_RUC'),
    'legal_address' => obra_env('OBRA_LEGAL_ADDRESS'),
    'privacy_email' => obra_env('OBRA_PRIVACY_EMAIL'),
    'crm_endpoint' => obra_env('OBRA_CRM_ENDPOINT', 'https://crm.clientes.com.py/api/v1/leads'),
    'crm_api_key' => obra_env('OBRA_CRM_API_KEY'),
    'analytics_id' => obra_env('OBRA_ANALYTICS_ID'),
    // Google Ads: id de cuenta (AW-123456789) y etiquetas de conversion (docs/ads/GOOGLE-ADS-SETUP.md). Vacio = sin etiqueta.
    'ads_id' => obra_env('OBRA_ADS_ID'),
    'ads_label_wa' => obra_env('OBRA_ADS_LABEL_WA'),
    'ads_label_form' => obra_env('OBRA_ADS_LABEL_FORM'),
    'ads_label_tel' => obra_env('OBRA_ADS_LABEL_TEL'),
    // Token (16+ caracteres) para ver /stats.php?token=... (medicion propia). Vacio = la pagina no existe.
    'stats_token' => obra_env('OBRA_STATS_TOKEN'),
    // Zona principal que aparece en titulos, textos y schema.
    'area' => obra_env('OBRA_AREA', 'Asunción y Gran Asunción'),
    'territory' => obra_env('OBRA_TERRITORY', 'Paraguay'),
    // Sitios hermanos del grupo. 'live' => false imprime el texto sin enlace hasta que el dominio este publicado.
    // Verified facts and authorized real project evidence only; configured privately on the server.
    'team' => [],
    'projects' => [],
    'partner_sites' => [
        // live_paths: paginas internas confirmadas con HEAD 200. Un enlace contextual con 'path' fuera de esta lista queda como texto.
        'arq' => ['url' => 'https://arq.com.py/', 'live' => true, 'live_paths' => []],
        'carpinteria' => ['url' => 'https://carpinteria.com.py/', 'live' => true, 'live_paths' => []],
        'pozo' => ['url' => 'https://pozo.com.py/', 'live' => false],
        'prestamo' => ['url' => 'https://prestamo.com.py/', 'live' => false],
    ],
];

// Hostinger compartido no siempre permite variables de entorno: config/local.php
// (no versionado, bloqueado por .htaccess) puede devolver un array con los valores reales.
// OBRA_LOCAL_CONFIG=0 lo ignora (tools/verify: las pruebas del formulario nunca usan claves reales).
$localFile = __DIR__ . '/local.php';
if (is_file($localFile) && obra_env('OBRA_LOCAL_CONFIG', '1') !== '0') {
    $local = require $localFile;
    if (is_array($local)) { $config = array_replace_recursive($config, $local); }
}

require_once dirname(__DIR__) . '/lib/vendercrm-config.php';
try { $canonicalCrm = \VenderCRM\Config::optional(dirname(__DIR__)); }
catch (RuntimeException $error) {
    error_log('obra: invalid server CRM configuration');
    $canonicalCrm = null;
    $config['crm_endpoint'] = '';
    $config['crm_api_key'] = '';
}
if ($canonicalCrm) { $config['crm_endpoint'] = $canonicalCrm->endpoint(); $config['crm_api_key'] = $canonicalCrm->apiKey(); }
$config['origin'] = rtrim((string) $config['origin'], '/');
$config['whatsapp'] = preg_replace('/\D+/', '', (string) $config['whatsapp']) ?: '';
$config['privacy_email'] = (string) ($config['privacy_email'] ?: $config['email']);

return $config;
