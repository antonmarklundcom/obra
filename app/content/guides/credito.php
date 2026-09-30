<?php
declare(strict_types=1);

// Guia informativa: /guias/{slug}/ salvo 'path' explicito. Sin cifras de precio, sin plazos fijos,
// sin datos legales o bancarios que no podamos verificar.
return [
    'path' => '/credito/',
    'name' => 'Construí con crédito',
    'title' => 'Construir una casa con crédito bancario o AFD en Paraguay | Obra',
    'description' => 'Cómo construir tu casa con crédito en Paraguay: qué documentación de obra pide el banco, cómo funcionan los desembolsos por etapa, el rol del presupuesto y del profesional responsable.',
    'h1' => 'Construí tu casa con crédito',
    'kicker' => 'Financiación',
    'intro' => [
        'Buena parte de las casas que se construyen en Gran Asunción se financian con crédito bancario, muchas veces con fondos de la AFD a través de los bancos. Construir con crédito tiene sus reglas: el banco desembolsa por etapas, exige un presupuesto con formato y un profesional que certifique avances. Acá explicamos cómo se acomoda la obra a eso.',
    ],
    'sections' => [
        ['Qué te va a pedir el banco de la obra', ['Además de tus requisitos como cliente, el banco pide documentación de la obra: título del terreno, planos aprobados, presupuesto detallado por rubro, cronograma y un profesional responsable. Cada entidad tiene su lista; conviene pedirla antes de proyectar.']],
        ['Desembolsos por etapa', ['El crédito no se cobra de una vez. El banco libera fondos según el avance certificado: por ejemplo, una parte al inicio, otra con la obra gruesa, otra con el techo y la última con las terminaciones. La obra tiene que planificarse con ese ritmo para no quedarse sin fondos entre desembolsos.']],
        ['El presupuesto que sirve', ['Un presupuesto por rubro en guaraníes, con cantidades, cronograma y el mismo alcance que los planos. Es el documento que el banco compara con la obra en cada visita. Lo preparamos con ese formato, y es la base del contrato si construís con nosotros.']],
        ['El profesional responsable', ['El banco necesita que alguien certifique que la obra avanza según lo presupuestado. Puede ser el director técnico de la obra o un profesional que contratás para eso. Ofrecemos ambas cosas.']],
        ['Combinar ahorro y crédito', ['Muchas familias arrancan con fondos propios (terreno, platea, mampostería) y toman el crédito para terminar. Bien planificado funciona: cada etapa se cierra y documenta para que el banco la reconozca.']],
    ],
    'faqs' => [
        ['¿Ustedes gestionan el crédito?', 'No. El crédito lo gestionás vos con el banco. Nosotros preparamos la documentación de obra que te piden y adaptamos la ejecución a los desembolsos.'],
        ['¿Puedo empezar la obra antes de que se apruebe el crédito?', 'Podés arrancar con fondos propios etapas que después el banco reconozca, pero conviene consultarlo con la entidad antes para que ese avance cuente.'],
        ['¿Qué pasa si un desembolso se atrasa?', 'La obra se programa con margen y los pagos por etapa se acuerdan por escrito. Un atraso del banco se conversa; no lo absorbe la obra a ciegas.'],
    ],
    'related' => ['/presupuesto/', '/casas/etapas/', '/supervision/direccion/'],
    'link' => ['site' => 'prestamo', 'text' => 'Las opciones de crédito de bancos y AFD las explicamos con más detalle en prestamo.com.py.'],
];
