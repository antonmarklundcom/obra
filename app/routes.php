<?php
declare(strict_types=1);

function obra_routes(array $content, array $config = []): array
{
    $area = (string) ($config['area'] ?? 'Paraguay');
    $routes = [
        '/' => ['type' => 'home', 'title' => 'Construcción llave en mano en Paraguay | Constructora Obra', 'description' => 'Constructora llave en mano en ' . $area . ': casas, quintas, piscinas, quinchos y reformas con un responsable. Contanos tu obra por WhatsApp.', 'h1' => 'Construimos tu casa de principio a fin, llave en mano.', 'indexable' => true],
        '/servicios/' => ['type' => 'services', 'title' => 'Servicios de construcción en ' . $area . ' | Obra', 'description' => 'Servicios de construcción en ' . $area . ': casas llave en mano, piscinas, quinchos, reformas, ampliaciones, tinglados y obras comerciales.', 'h1' => 'Una sola empresa para toda la obra.', 'indexable' => true],
        '/guias/' => ['type' => 'guides', 'title' => 'Guías para construir en Paraguay | Obra', 'description' => 'Guías para construir en Paraguay: costo de una casa, terreno, plazos, permisos, fundaciones, mampostería y cómo construir con crédito bancario.', 'h1' => 'Guías para decidir antes de construir.', 'indexable' => true],
        '/como-trabajamos/' => ['type' => 'process', 'title' => 'Cómo trabajamos: del terreno a la entrega | Obra', 'description' => 'Así construimos: terreno, proyecto, presupuesto por escrito, obra coordinada y entrega. Alcance claro, rubros ordenados y decisiones con tiempo.', 'h1' => 'Del terreno a la entrega, sin que tengas que coordinar gremios.', 'indexable' => true],
        '/cotizar/' => ['type' => 'contact', 'title' => 'Cotizá tu obra por WhatsApp | Obra', 'description' => 'Contanos qué querés construir, dónde queda el terreno y cómo pensás financiarlo. Te respondemos por WhatsApp con los pasos para cotizar.', 'h1' => 'Contanos qué querés construir.', 'indexable' => true],
        '/nosotros/' => ['type' => 'about', 'title' => 'Sobre Obra | Constructora en ' . $area, 'description' => 'Constructora en ' . $area . ' de un grupo familiar con diseño en arq.com.py y carpintería en carpinteria.com.py. Un solo responsable de obra.', 'h1' => 'Una obra sale mejor cuando alguien ve el conjunto.', 'indexable' => true],
        '/privacidad/' => ['type' => 'privacy', 'title' => 'Política de privacidad | Obra', 'description' => 'Qué datos recibe Obra a través del sitio y cómo los usa para responder consultas y solicitudes de presupuesto.', 'h1' => 'Política de privacidad', 'indexable' => true],
        '/gracias/' => ['type' => 'thanks', 'title' => 'Estado de tu consulta | Obra', 'description' => 'Estado del envío de tu consulta a Obra.', 'h1' => 'Estado de tu consulta', 'indexable' => false],
    ];
    foreach ($content['services'] as $slug => $service) {
        $routes['/' . $slug . '/'] = ['type' => 'service', 'slug' => $slug, 'title' => $service['title'], 'description' => $service['description'], 'h1' => $service['h1'], 'indexable' => true];
        foreach ($content['children'][$slug] ?? [] as $child => $page) {
            $routes['/' . $slug . '/' . $child . '/'] = ['type' => 'child', 'slug' => $slug, 'child' => $child, 'title' => $page['title'], 'description' => $page['description'], 'h1' => $page['h1'], 'indexable' => true];
        }
    }
    foreach ($content['guides'] as $slug => $guide) {
        $routes[obra_guide_path($slug, $guide)] = ['type' => 'guide', 'slug' => $slug, 'title' => $guide['title'], 'description' => $guide['description'], 'h1' => $guide['h1'], 'indexable' => true];
    }
    return $routes;
}

function obra_guide_path(string $slug, array $guide): string
{
    return $guide['path'] ?? '/guias/' . $slug . '/';
}

// URLs de versiones anteriores del sitio -> URL actual (301).
function obra_legacy_redirects(): array
{
    return [
        '/contacto/' => '/cotizar/',
        '/cocinas-banos/' => '/reformas/cocinas/',
        '/servicios/casas-llave-en-mano/' => '/casas/',
        '/servicios/piscinas/' => '/piscinas/',
        '/servicios/quinchos/' => '/quinchos/',
        '/servicios/quintas/' => '/quintas/',
        '/servicios/remodelaciones/' => '/reformas/',
        '/servicios/decks-y-pergolas/' => '/patios/',
        '/servicios/cocinas-y-banos/' => '/reformas/cocinas/',
        '/servicios/techos-cocheras-y-tinglados/' => '/tinglados/',
        '/servicios/murallas-y-cerramientos/' => '/muros/',
        '/servicios/obras-comerciales/' => '/comerciales/',
    ];
}
