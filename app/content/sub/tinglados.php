<?php
declare(strict_types=1);

// Especialidades de este hub: /{hub}/{slug}/. Una intencion de busqueda distinta a la del hub.
// 'related' son rutas completas. Sin precios, sin plazos fijos, sin datos inventados.
return [
    'galpones' => [
        'name' => 'Galpones y depósitos',
        'title' => 'Construcción de galpones y depósitos en Paraguay | Obra',
        'description' => 'Construcción de galpones industriales y depósitos en Gran Asunción: estructura metálica de gran luz, piso para carga, portones y oficinas anexas.',
        'h1' => 'Construcción de galpones y depósitos',
        'kicker' => 'Área cubierta para operar',
        'intro' => [
            'Un galpón se proyecta por lo que va a pasar adentro: qué se guarda, qué vehículos entran, cuánta altura hace falta y cuánta carga soporta el piso. Con eso se define la luz de la estructura, el piso y los accesos.',
            'Construimos galpones y depósitos para comercios, logística y producción liviana, con oficinas, baños y áreas de carga integradas.',
        ],
        'includes' => ['Fundaciones y piso de hormigón para carga', 'Estructura metálica de gran luz', 'Cubierta y cerramientos laterales', 'Portones, muelles y accesos', 'Oficinas, baños e instalaciones'],
        'ideal' => ['Tu negocio necesita depósito propio.', 'Alquilás un galpón y querés construir el tuyo.', 'Necesitás un espacio de producción o taller.'],
        'faqs' => [
            ['¿Qué altura conviene?', 'Depende de lo que se almacena y de las maquinarias. Se define con vos antes de proyectar la estructura.'],
            ['¿El piso aguanta montacargas?', 'Se calcula para la carga real: espesor, armadura y juntas. Es uno de los puntos más importantes del galpón.'],
            ['¿Trabajan con fecha de operación?', 'Sí. La fecha objetivo entra en la planificación y las etapas se ordenan para cumplirla.'],
        ],
        'related' => ['/tinglados/', '/comerciales/', '/tinglados/cocheras/'],
    ],
    'cocheras' => [
        'name' => 'Cocheras y techos para autos',
        'title' => 'Construcción de cocheras y techos para autos en Paraguay | Obra',
        'description' => 'Cocheras cubiertas y techos para autos en Asunción y Gran Asunción: estructura metálica o de hormigón, cubierta aislada, piso y portón integrados al frente de la casa.',
        'h1' => 'Cocheras y techos para autos',
        'kicker' => 'El auto a la sombra, el frente mejor',
        'intro' => [
            'El sol paraguayo castiga los autos y las cocheras improvisadas afean el frente. Una cochera bien hecha protege el vehículo y mejora la fachada: se proyecta con el portón, el muro y el acceso como un conjunto.',
            'Construimos cocheras con estructura metálica o de hormigón, cubierta de chapa aislada, teja o losa, piso de hormigón o adoquines y portón integrado.',
        ],
        'includes' => ['Estructura metálica, de hormigón o mixta', 'Cubierta aislada con canaletas', 'Piso de hormigón o adoquines para vehículos', 'Portón manual o automatizado', 'Iluminación y previsión de cargador eléctrico'],
        'ideal' => ['Tu auto queda al sol o a la lluvia.', 'Querés renovar el frente junto con la cochera.', 'Necesitás cochera para dos o más vehículos.'],
        'faqs' => [
            ['¿Chapa, teja o losa?', 'Chapa aislada es la más económica, teja continúa el estilo de la casa, losa permite usar el espacio arriba. Depende del proyecto.'],
            ['¿Pueden automatizar el portón?', 'Sí. Dejamos la instalación eléctrica y coordinamos el equipo de automatización.'],
            ['¿Se puede hacer una cochera sin columnas al frente?', 'Sí, con una estructura en voladizo calculada. Es más costosa pero deja el acceso libre.'],
        ],
        'related' => ['/muros/portones/', '/reformas/fachadas/', '/tinglados/'],
    ],
];
