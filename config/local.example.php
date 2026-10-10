<?php
// Copiar a config/local.php en el servidor y completar con datos reales.
// config/local.php esta bloqueado por .htaccess y no se incluye en el paquete.
return [
    'whatsapp' => '',          // 5959XXXXXXXX, solo digitos
    'email' => '',
    'legal_operator' => '',
    'ruc' => '',
    'legal_address' => '',
    'privacy_email' => '',
    // Legacy CRM fields below are fallback only. New setup: private/vendercrm.php
    // with VENDERCRM_URL (base origin) and VENDERCRM_API_KEY.
    'crm_endpoint' => 'https://crm.clientes.com.py/api/v1/leads', // POST JSON, cabecera X-Api-Key (ya es el valor por defecto)
    'crm_api_key' => '',        // vc_live_... de obra.com.py: SOLO en el servidor, nunca en git
    'stats_token' => '',       // 16+ caracteres al azar: abre /stats.php?token=...
    'analytics_id' => '',      // G-XXXXXXX
    'area' => 'Asunción y Gran Asunción',
    // Complete only with real, verified information. Empty entries are not displayed.
    'team' => ['name' => '', 'role' => '', 'background' => '', 'credentials' => '', 'portrait' => ''],
    // Authorized projects: service, title, scope, location, image (/assets/images/...), authorized=true.
    // Record author/date/permission outside the public site. Never use illustrations as project evidence.
    'projects' => [],
];
