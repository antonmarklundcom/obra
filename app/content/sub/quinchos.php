<?php
declare(strict_types=1);

// Especialidades de este hub: /{hub}/{slug}/. Una intencion de busqueda distinta a la del hub.
// 'related' son rutas completas. Sin precios, sin plazos fijos, sin datos inventados.
return [
    'cerrados' => [
        'name' => 'Quinchos cerrados',
        'title' => 'Construcción de quinchos cerrados en Paraguay | Obra',
        'description' => 'Quinchos cerrados con aberturas, aire acondicionado y baño en Asunción y Gran Asunción: para usarlos en verano con calor y en invierno con frío.',
        'h1' => 'Construcción de quinchos cerrados',
        'kicker' => 'Un ambiente más, todo el año',
        'intro' => [
            'El quincho cerrado se convirtió en el ambiente más usado de muchas casas: comedor de fin de semana, sala de juegos, lugar para recibir. Cerrarlo bien exige resolver el humo de la parrilla, la ventilación y la climatización.',
            'Construimos quinchos cerrados con aberturas corredizas para abrirlos en los días lindos, extracción de humo dimensionada y previsión de aire acondicionado.',
        ],
        'includes' => ['Cerramiento con aberturas corredizas de aluminio o PVC', 'Campana y extracción de humo dimensionadas', 'Previsión de aire acondicionado e instalación eléctrica', 'Baño y kitchenette', 'Aislación térmica en el techo'],
        'ideal' => ['Usás el quincho todo el año y el calor o el frío lo limitan.', 'Querés un ambiente de recepción separado de la casa.', 'Tenés un quincho abierto y querés cerrarlo.'],
        'faqs' => [
            ['¿La parrilla funciona bien en un quincho cerrado?', 'Sí, con una campana correcta, un ducto bien dimensionado y una entrada de aire. Sin eso, el humo se queda adentro.'],
            ['¿Se puede cerrar un quincho existente?', 'Sí. Revisamos la estructura, el techo y el piso y proponemos el cerramiento que corresponde.'],
            ['¿Necesita permiso municipal?', 'Un quincho cerrado suma superficie cubierta. Lo revisamos y coordinamos la documentación si corresponde.'],
        ],
        'related' => ['/quinchos/parrillas/', '/quinchos/techo-madera/', '/ampliaciones/galeria/'],
        'link' => ['site' => 'carpinteria', 'path' => '/aberturas/', 'text' => 'Las aberturas de aluminio, el blindex y las puertas del quincho cerrado las fabrica carpinteria.com.py, del mismo grupo; la obra civil y la colocación quedan a nuestro cargo.'],
    ],
    'parrillas' => [
        'name' => 'Parrillas y asadores',
        'title' => 'Construcción de parrillas y asadores en Paraguay | Obra',
        'description' => 'Construcción de parrillas de ladrillo, asadores y hornos en Asunción y Gran Asunción: tiro correcto, mesada, bacha y fogón a la altura justa.',
        'h1' => 'Construcción de parrillas y asadores',
        'kicker' => 'El corazón del quincho',
        'intro' => [
            'Una parrilla que tira mal arruina el quincho. El tiro, la altura del fogón, el ancho de la boca y la campana se calculan, no se improvisan. Construimos parrillas de ladrillo refractario con mesada, bacha y espacio para leña o carbón.',
            'Podemos hacer la parrilla sola, dentro de un quincho existente, o como parte de un quincho nuevo.',
        ],
        'includes' => ['Parrilla de ladrillo refractario con tiro calculado', 'Campana y chimenea', 'Mesada de granito u hormigón con bacha', 'Horno de barro o de ladrillo opcional', 'Leñero y espacio de guardado'],
        'ideal' => ['Tu parrilla actual llena el quincho de humo.', 'Querés sumar una parrilla a una galería existente.', 'Buscás una parrilla con horno y mesada integrada.'],
        'faqs' => [
            ['¿Por qué mi parrilla tira mal?', 'Casi siempre por una campana mal proporcionada, una chimenea corta o sin salida libre, o una boca demasiado alta. Se puede corregir.'],
            ['¿Hacen parrillas a gas o eléctricas?', 'Preparamos la obra civil y las instalaciones para equipos a gas; el equipo lo elegís vos.'],
            ['¿Cuánto tarda construir una parrilla?', 'Es una obra corta comparada con un quincho completo. El plazo se define con el alcance y el secado de los materiales refractarios.'],
        ],
        'related' => ['/quinchos/', '/quinchos/cerrados/', '/patios/pergolas/'],
    ],
    'techo-madera' => [
        'name' => 'Quinchos con techo de madera',
        'title' => 'Quinchos con techo de madera y machimbre en Paraguay | Obra',
        'description' => 'Quinchos con techo de madera y machimbre en Asunción y Gran Asunción: estructura, cielorraso de machimbre y tejas construidos de principio a fin.',
        'summary' => 'Construcción de quinchos con estructura de madera, cielorraso de machimbre y tejas en Asunción y Gran Asunción, con la madera y la obra civil a cargo del mismo equipo.',
        'h1' => 'Quinchos con techo de madera y machimbre',
        'kicker' => 'Madera vista, bien tratada',
        'intro' => [
            'El techo de madera con machimbre es el clásico del quincho paraguayo: cálido, fresco y con un olor que ningún otro material da. Requiere madera bien estacionada, tratamiento contra insectos y humedad, y una estructura calculada para el peso de la teja.',
            'La estructura de madera, el machimbre y la cubierta los resolvemos dentro de la misma obra, junto con la obra civil del quincho: un solo responsable para todo el techo, desde los apoyos hasta la última tabla, y una sola conversación para coordinar medidas, madera y terminaciones.',
        ],
        'includes' => ['Estructura de madera dura: tijeras, cabriadas o vigas vistas', 'Cielorraso de machimbre con aislación', 'Cubierta de teja colonial, francesa o chapa', 'Tratamiento y terminación de la madera', 'Columnas de mampostería o madera'],
        'ideal' => ['Querés un quincho de estilo tradicional con madera a la vista.', 'Buscás un techo fresco para el verano.', 'Preferís coordinar carpintería y obra con un solo responsable.'],
        'faqs' => [
            ['¿Qué madera conviene para el techo?', 'Maderas duras bien estacionadas. Te asesoramos sobre las especies disponibles y cómo se comportan con el calor y la humedad.'],
            ['¿El machimbre necesita mantenimiento?', 'Un barnizado o aceitado periódico. Lo explicamos al entregar.'],
            ['¿Se puede combinar madera con chapa?', 'Sí. Estructura y cielorraso de madera con cubierta de chapa aislada es una combinación habitual y económica.'],
        ],
        'related' => ['/quinchos/', '/patios/pergolas/', '/quintas/casa-campo/'],
    ],
];
