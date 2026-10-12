<?php
declare(strict_types=1);

// Contenido editorial del sitio. Slugs cortos de un nivel (regla: <=15 caracteres, aptos para
// la ruta visible de Google Ads). El orden define la prioridad en home, footer y sitemap.
// 'link' = un solo enlace contextual por pagina hacia otro sitio del grupo (ver config partner_sites).
return [
    'services' => obra_load_content_dir('services', ['casas', 'quintas', 'piscinas', 'quinchos', 'reformas', 'ampliaciones', 'patios', 'tinglados', 'techos', 'muros', 'comerciales', 'supervision', 'presupuesto']),

    // Proceso: terreno -> proyecto -> presupuesto -> obra -> entrega
    // Grupos para el menu de servicios y el indice /servicios/
    'groups' => [
        'nueva' => ['name' => 'Construcción nueva', 'services' => ['casas', 'quintas', 'comerciales']],
        'exterior' => ['name' => 'Exteriores y patio', 'services' => ['piscinas', 'quinchos', 'patios', 'muros']],
        'cubiertas' => ['name' => 'Techos y cubiertas', 'services' => ['techos', 'tinglados']],
        'reforma' => ['name' => 'Reformas y ampliaciones', 'services' => ['reformas', 'ampliaciones']],
        'tecnico' => ['name' => 'Servicios técnicos', 'services' => ['supervision', 'presupuesto']],
    ],
    // Subpaginas por servicio y guias (/credito/, /obras/) quedan pendientes:
    // necesitan datos reales (financiacion AFD verificada, obras concretas) antes de construirse.

    // Subpaginas por servicio (/{servicio}/{sub}/) y guias (/guias/{slug}/, /credito/)
    // Especialidades: app/content/sub/{hub}.php, en el orden de los hubs de arriba.
    'children' => obra_load_content_dir('sub', ['casas', 'quintas', 'piscinas', 'quinchos', 'reformas', 'ampliaciones', 'patios', 'tinglados', 'techos', 'muros', 'comerciales', 'supervision', 'presupuesto']),
    // Guias: app/content/guides/{slug}.php. El orden fija el menu y el sitemap; una guia nueva sin orden va al final.
    'guides' => obra_load_content_dir('guides', ['costo-casa', 'terreno', 'plazos', 'permisos', 'platea', 'ladrillo-bloque', 'albanil', 'credito', 'costo-quincho', 'costo-piscina', 'techo-losa-chapa', 'elegir-constructora', 'costo-ampliacion', 'costo-muro-perimetral', 'costo-tinglado', 'humedad-paredes', 'impermeabilizar-losa']),

    'process' => [
        ['01', 'Terreno y consulta', 'Nos contás qué querés construir, dónde queda el terreno o la casa y cómo pensás financiarlo. Podés mandarnos fotos por WhatsApp.'],
        ['02', 'Proyecto y relevamiento', 'Visitamos el lugar, revisamos planos o los coordinamos, y ordenamos prioridades, rubros y decisiones pendientes.'],
        ['03', 'Presupuesto por escrito', 'Presupuesto por rubro en guaraníes, con trabajos incluidos, exclusiones, provisiones y forma de ejecución.'],
        ['04', 'Obra coordinada', 'Un responsable de obra coordina equipos, materiales y avances. Vos recibís reportes y tomás decisiones con tiempo.'],
        ['05', 'Entrega', 'Recorrido final, lista de pendientes resueltos y documentación de lo ejecutado.'],
    ],

    'home_faqs' => [
        ['¿Cuánto cuesta construir o remodelar en Paraguay?', 'Depende de medidas, estado actual, ubicación, estructura, instalaciones, materiales y terminaciones. Con esos datos preparamos un presupuesto por rubro en guaraníes, sin precios por metro cuadrado aislados.'],
        ['¿El presupuesto tiene costo?', 'La primera conversación y la estimación inicial son sin compromiso. Si el proyecto requiere relevamiento técnico o cómputo métrico completo, te lo confirmamos antes de cualquier visita.'],
        ['¿En qué zonas trabajan?', 'Principalmente en Asunción y Gran Asunción. Para otras zonas del país evaluamos cada caso según tamaño del proyecto y logística.'],
        ['¿Puedo construir con crédito bancario o AFD?', 'Sí. Preparamos el presupuesto y el cronograma con el formato que suelen pedir los bancos y ajustamos la obra a los desembolsos.'],
        ['¿Puedo pedir solamente mano de obra?', 'Podemos evaluar distintas modalidades. La propuesta deja claro quién compra, recibe y controla cada material.'],
        ['¿Dan garantía?', 'Las condiciones de garantía dependen del rubro, los materiales y el contrato, y quedan por escrito en la propuesta final.'],
    ],

    'financing' => [
        'propios' => 'Fondos propios',
        'credito' => 'Crédito bancario o AFD',
        'mixto' => 'Una parte propia y otra con crédito',
        'indefinido' => 'Todavía no lo definí',
    ],
    'terrain' => [
        'si' => 'Sí, ya tengo terreno',
        'no' => 'No, todavía busco terreno',
        'existente' => 'Es una obra sobre una construcción existente',
    ],
];
