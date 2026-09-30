<?php
declare(strict_types=1);

// Especialidades de este hub: /{hub}/{slug}/. Una intencion de busqueda distinta a la del hub.
// 'related' son rutas completas. Sin precios, sin plazos fijos, sin datos inventados.
return [
    'refaccion' => [
        'name' => 'Refacción de quintas',
        'title' => 'Refacción y puesta a punto de quintas en Paraguay | Obra',
        'description' => 'Refacción de quintas en Paraguay: techos, instalaciones, piscina, quincho y cerramiento renovados con un solo responsable y un plan por sectores.',
        'h1' => 'Refacción y puesta a punto de quintas',
        'kicker' => 'Recuperar lo que ya está construido',
        'intro' => [
            'Comprar una quinta usada casi siempre significa heredar problemas: techos con filtraciones, instalaciones viejas, piscina con pérdidas, muros caídos. Refaccionar bien es más barato que demoler, pero solo si se relevan los problemas antes de presupuestar.',
            'Hacemos un relevamiento por sectores (casa, exteriores, agua, electricidad, perímetro) y armamos un plan de intervención con prioridades: primero lo que protege la construcción, después lo que la mejora.',
        ],
        'includes' => ['Relevamiento del estado por sector con fotos', 'Techos, cielorrasos y humedades', 'Renovación de instalaciones eléctricas y sanitarias', 'Recuperación de piscina, quincho y galerías', 'Muros, portones y accesos'],
        'ideal' => ['Compraste una quinta y no sabés por dónde empezar.', 'La quinta familiar quedó abandonada varios años.', 'Querés alquilarla y necesita estar en condiciones.'],
        'faqs' => [
            ['¿Conviene refaccionar o demoler?', 'Depende del estado de la estructura y las fundaciones. Si están sanas, refaccionar suele ser más económico. Lo evaluamos en el relevamiento.'],
            ['¿Pueden trabajar por prioridades?', 'Sí. Ordenamos la obra para que lo urgente (techo, agua, electricidad) vaya primero y el resto se programe según presupuesto.'],
            ['¿Trabajan en quintas lejos de Asunción?', 'Evaluamos cada caso según distancia, tamaño de la obra y logística de materiales.'],
        ],
        'related' => ['/quintas/casa-campo/', '/piscinas/renovacion/', '/reformas/techos/'],
    ],
    'casa-campo' => [
        'name' => 'Casas de campo',
        'title' => 'Construcción de casas de campo en Paraguay | Obra',
        'description' => 'Construcción de casas de campo en Paraguay: galerías amplias, techos altos, materiales que aguantan el clima y servicios propios de agua y electricidad.',
        'h1' => 'Construcción de casas de campo',
        'kicker' => 'Pensada para el calor, la lluvia y el fin de semana',
        'intro' => [
            'Una casa de campo no es una casa de ciudad puesta en una quinta. Tiene otra lógica: galería grande porque la vida pasa afuera, techos altos y aleros para el calor, materiales que no necesitan cuidado semanal y servicios que funcionan sin red pública.',
            'Construimos casas de campo con esa lógica desde el proyecto, coordinando agua (pozo, bomba, tanque), electricidad, desagües y accesos como parte de la misma obra.',
        ],
        'includes' => ['Implantación según sombra, viento y accesos', 'Galería perimetral y techos con aleros', 'Pozo, tanque elevado y presión de agua', 'Pozo ciego o cámara séptica según el terreno', 'Materiales de bajo mantenimiento'],
        'ideal' => ['Tenés una quinta sin construir y querés una casa para usar todo el año.', 'Querés una casa de descanso con galería y quincho integrados.', 'El terreno no tiene agua ni cloaca y hay que resolverlo.'],
        'faqs' => [
            ['¿Qué materiales convienen para una casa de campo?', 'Los que aguantan sin mantenimiento constante: ladrillo visto o revoque, techos de teja o chapa con aislación, aberturas de aluminio o madera dura tratada.'],
            ['¿Pueden resolver el agua si no hay red?', 'Sí. Coordinamos la perforación del pozo, la bomba, el tanque y la instalación interna como parte de la obra.'],
            ['¿Se puede empezar por el quincho y después la casa?', 'Sí. Es una secuencia habitual en quintas: quincho con baño primero, casa principal después, con servicios previstos para ambos.'],
        ],
        'related' => ['/quintas/refaccion/', '/quinchos/', '/piscinas/quinta/'],
    ],
];
