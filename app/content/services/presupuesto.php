<?php
declare(strict_types=1);

// Servicio (hub) /presupuesto/. Sin precios, sin plazos fijos, sin datos inventados.
return [
        'name' => 'Presupuesto de obra y cómputo métrico',
        'updated' => '2026-10-01',
        'short' => 'Sabé cuánto cuesta tu proyecto por rubro antes de comprometerte.',
        'title' => 'Presupuesto de obra y cómputo métrico en Paraguay | Obra',
        'description' => 'Presupuesto de obra y cómputo métrico en Paraguay: cantidades, rubros y costos en guaraníes desde tus planos, para comparar propuestas o pedir crédito.',
        'h1' => 'Presupuesto de obra y cómputo métrico en Paraguay',
        'kicker' => 'Números antes de decisiones',
        'includes' => ['Revisión de planos y especificaciones', 'Cómputo métrico por rubro', 'Presupuesto detallado en guaraníes', 'Cronograma estimado por etapas', 'Versión apta para presentar al banco'],
        'ideal' => ['Tenés planos y querés saber cuánto cuesta construir.', 'Necesitás un presupuesto para gestionar un crédito de vivienda.', 'Querés comparar propuestas con el mismo alcance.', 'Vas a construir por etapas y necesitás ordenar prioridades.'],
        'faqs' => [
            ['¿Qué necesito para pedir un presupuesto de obra?', 'Planos o croquis con medidas, ubicación del terreno y el nivel de terminación que buscás. Si no tenés planos, empezamos con una estimación por metro cuadrado orientativa.'],
            ['¿El presupuesto sirve para el banco?', 'Sí. Lo preparamos con el detalle por rubro y el cronograma que suelen pedir los bancos y la AFD para créditos de construcción.'],
            ['¿El presupuesto tiene costo?', 'La estimación inicial sobre tus datos se conversa sin compromiso. Un cómputo métrico completo se cotiza según el tamaño del proyecto y te lo confirmamos antes de empezar.'],
            ['¿Puedo construir con ustedes después?', 'Sí. Si contratás la obra llave en mano, el presupuesto pasa a ser la base del contrato.'],
            ['¿Qué diferencia hay entre presupuesto y cómputo métrico?', 'El cómputo es la medición de cantidades; el presupuesto es esa medición con los costos aplicados. Uno sin el otro queda incompleto.'],
            ['¿Por qué dos presupuestos del mismo plano dan distinto?', 'Por las terminaciones supuestas, lo incluido o excluido, la provisión de materiales y cómo se midió. Leerlos por rubro muestra dónde está la diferencia.'],
        ],
        'sections' => [
            ['Cómputo métrico: qué es', ['El cómputo métrico es la medición ordenada de todo lo que hay que construir: metros cuadrados de mampostería, metros cúbicos de hormigón, kilos de hierro, metros de cañería, cantidad de aberturas. Se saca del plano, rubro por rubro, y es la base sobre la que se ponen los costos.', 'Un presupuesto sin cómputo es una estimación. Con cómputo, cada línea tiene una cantidad detrás y podés ver qué cambia si modificás una medida o una terminación.']],
            ['Cómo se lee un presupuesto de obra por rubro', ['Un presupuesto por rubro separa los grandes capítulos: trabajos preliminares, fundaciones, estructura, mampostería, techo, instalaciones, revoques, pisos, aberturas, pintura y limpieza. Cada rubro indica qué incluye, quién provee el material y qué queda afuera.', 'Al comparar dos propuestas, hacelo rubro contra rubro. Una diferencia grande casi siempre está en algo que uno incluye y el otro no.']],
            ['Presupuesto para el banco o para decidir', ['Si vas a pedir un crédito, el presupuesto tiene que mostrar el detalle por rubro y un cronograma por etapas, porque los desembolsos se atan al avance. Consultá con tu banco el formato exacto que piden.', 'Si todavía estás decidiendo, un presupuesto ordenado te permite priorizar: qué se hace ahora, qué queda para después y qué se puede simplificar sin comprometer la estructura.']],
        ],
        'related' => ['casas', 'supervision', 'ampliaciones', 'reformas', 'tinglados'],
        'link' => ['site' => 'prestamo', 'text' => 'Si vas a financiar la obra con crédito, en prestamo.com.py explicamos las opciones de bancos y AFD.'],
];
