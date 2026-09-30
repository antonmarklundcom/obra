<?php
declare(strict_types=1);

// Especialidades de este hub: /{hub}/{slug}/. Una intencion de busqueda distinta a la del hub.
// 'related' son rutas completas. Sin precios, sin plazos fijos, sin datos inventados.
return [
    'direccion' => [
        'name' => 'Dirección técnica de obra',
        'title' => 'Dirección técnica de obra en Paraguay | Obra',
        'description' => 'Dirección técnica de obra en Asunción y Gran Asunción: ingeniero a cargo de la ejecución, certificaciones y responsabilidad ante el municipio y el banco.',
        'summary' => 'Dirección técnica y profesional responsable de obra en Asunción y Gran Asunción: ingeniero a cargo de la ejecución, certificaciones y responsabilidad ante el municipio y el banco.',
        'h1' => 'Dirección técnica de obra',
        'kicker' => 'Un profesional responsable de tu obra',
        'intro' => [
            'La dirección técnica es más que supervisar: el profesional toma las decisiones de ejecución, firma como responsable ante el municipio y certifica avances para el banco. Es lo que exigen muchos permisos y la mayoría de los créditos de construcción.',
            'Ofrecemos dirección técnica para obras que ejecuta otro constructor o un maestro de obra, con visitas programadas, informes y certificaciones.',
        ],
        'includes' => ['Profesional responsable ante el municipio', 'Decisiones técnicas de ejecución en obra', 'Certificaciones de avance para desembolsos', 'Informes con fotos y observaciones', 'Recepción final y documentación'],
        'ideal' => ['El municipio o el banco te piden un profesional responsable.', 'Contrataste un maestro de obra y querés dirección técnica.', 'Necesitás certificaciones para los desembolsos del crédito.'],
        'faqs' => [
            ['¿Qué diferencia hay con la supervisión?', 'La supervisión controla; la dirección técnica decide y asume la responsabilidad profesional. Muchas veces hace falta la segunda por exigencia legal o bancaria.'],
            ['¿Pueden dirigir una obra con planos de otro arquitecto?', 'Sí. Revisamos el proyecto y dirigimos su ejecución.'],
            ['¿Qué pasa si la obra ya empezó sin dirección?', 'Hacemos un relevamiento del estado y asumimos la dirección desde ese punto, documentando lo previo.'],
        ],
        'related' => ['/supervision/', '/presupuesto/', '/credito/'],
    ],
];
