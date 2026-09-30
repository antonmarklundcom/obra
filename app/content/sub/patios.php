<?php
declare(strict_types=1);

// Especialidades de este hub: /{hub}/{slug}/. Una intencion de busqueda distinta a la del hub.
// 'related' son rutas completas. Sin precios, sin plazos fijos, sin datos inventados.
return [
    'veredas' => [
        'name' => 'Veredas y contrapisos',
        'title' => 'Veredas, contrapisos y pisos exteriores en Paraguay | Obra',
        'description' => 'Veredas, contrapisos y pisos exteriores en Asunción y Gran Asunción: base compactada, hormigón, juntas y pendientes para que no se agrieten ni junten agua.',
        'summary' => 'Construcción de veredas, contrapisos y pisos exteriores en Asunción y Gran Asunción: base compactada, hormigón, juntas y pendientes para que no se agrieten ni junten agua.',
        'h1' => 'Veredas, contrapisos y pisos exteriores',
        'kicker' => 'Base bien hecha, piso que dura',
        'intro' => [
            'La vereda o el patio de hormigón que se agrieta o junta agua casi siempre falla por la base, no por la terminación. Suelo mal compactado, sin juntas y sin pendiente: el resultado se ve al primer año.',
            'Hacemos veredas, contrapisos y pisos exteriores con base compactada, malla, juntas de dilatación y pendientes hacia los desagües, listos para recibir cerámica, adoquín o piedra.',
        ],
        'includes' => ['Movimiento de suelo y compactación', 'Contrapiso de hormigón con malla y juntas', 'Pendientes y desagües pluviales', 'Terminación: cerámica, adoquín, piedra o alisado', 'Cordones, escalones y rampas'],
        'ideal' => ['Tu patio es de tierra o de un contrapiso roto.', 'Necesitás una vereda de acceso o perimetral.', 'Querés un piso para cochera o circulación de vehículos.'],
        'faqs' => [
            ['¿Por qué se agrietó mi contrapiso anterior?', 'Casi siempre por falta de compactación, de malla o de juntas. Un contrapiso bien hecho lleva las tres cosas.'],
            ['¿Qué terminación conviene para el sol?', 'Materiales claros y rugosos: se calientan menos y no resbalan. Lo vemos según el uso.'],
            ['¿Hacen pisos para vehículos pesados?', 'Sí, con espesor y armadura calculados para la carga.'],
        ],
        'related' => ['/patios/', '/muros/', '/tinglados/cocheras/'],
    ],
    'decks' => [
        'name' => 'Decks de madera y compuesto',
        'title' => 'Construcción de decks de madera y WPC en Paraguay | Obra',
        'description' => 'Construcción de decks de madera dura y compuesto (WPC) en Asunción y Gran Asunción, para piscina, galería o patio, con estructura ventilada y anclajes ocultos.',
        'h1' => 'Construcción de decks de madera y compuesto',
        'kicker' => 'Un piso cálido alrededor de la piscina o la galería',
        'intro' => [
            'El deck cambia un patio: es cálido a la vista, agradable para pisar descalzo y resuelve desniveles sin hormigón. El secreto está debajo: una estructura ventilada, anclajes que no oxidan y madera o compuesto elegidos según el uso.',
            'Construimos decks de madera dura tratada y de compuesto (WPC) alrededor de piscinas, en galerías y como terrazas elevadas.',
        ],
        'includes' => ['Estructura de apoyo ventilada y nivelada', 'Madera dura tratada o tablas de compuesto WPC', 'Anclajes ocultos y herrajes inoxidables', 'Bordes, escalones y encuentro con la piscina', 'Tratamiento y terminación'],
        'ideal' => ['Querés un piso agradable alrededor de la piscina.', 'Tenés un desnivel en el patio que el deck puede resolver.', 'Buscás renovar una galería sin obra húmeda.'],
        'faqs' => [
            ['¿Madera o compuesto?', 'La madera es más noble y necesita mantenimiento; el compuesto casi no lo necesita pero se calienta más al sol. Depende del uso y de cuánto lo querés cuidar.'],
            ['¿El deck aguanta el clima paraguayo?', 'Sí, con madera dura bien tratada o compuesto de calidad y una estructura ventilada que no acumule agua.'],
            ['¿Se puede hacer sobre un piso existente?', 'Sí, si el piso está nivelado y tiene desagüe. Es una forma rápida de renovar.'],
        ],
        'related' => ['/piscinas/', '/patios/pergolas/', '/patios/'],
    ],
    'pergolas' => [
        'name' => 'Pérgolas y galerías livianas',
        'title' => 'Construcción de pérgolas en Paraguay | Obra',
        'description' => 'Pérgolas de madera, metal y hormigón en Asunción y Gran Asunción: sombra para el patio, cochera o piscina con cubierta de policarbonato, chapa o vegetal.',
        'h1' => 'Construcción de pérgolas y galerías livianas',
        'kicker' => 'Sombra sin cerrar el patio',
        'intro' => [
            'Una pérgola da sombra sin encerrar. Sirve para el sector de la piscina, el acceso, la cochera o una galería que no justifica un techo completo. Puede quedar abierta o llevar cubierta de policarbonato, chapa o enredadera.',
            'Construimos pérgolas de madera dura, metal y hormigón, con fundaciones que aguantan viento y una cubierta elegida según lo que querés: sombra, protección de lluvia o las dos.',
        ],
        'includes' => ['Fundaciones y columnas', 'Estructura de madera, metal o hormigón', 'Cubierta: abierta, policarbonato, chapa o vegetal', 'Desagües cuando la cubierta es cerrada', 'Iluminación y ventiladores'],
        'ideal' => ['Necesitás sombra en el patio o en la piscina.', 'Querés un acceso cubierto sin obra pesada.', 'Buscás una cochera liviana.'],
        'faqs' => [
            ['¿Una pérgola protege de la lluvia?', 'Solo si lleva cubierta cerrada (policarbonato o chapa) y desagües. Una pérgola abierta filtra el sol, no el agua.'],
            ['¿Qué material dura más?', 'Metal galvanizado y hormigón casi no necesitan mantenimiento; la madera necesita tratamiento periódico pero es más cálida.'],
            ['¿Necesita permiso?', 'Una pérgola abierta en general no. Con cubierta cerrada suma superficie y puede requerirlo. Lo revisamos.'],
        ],
        'related' => ['/patios/decks/', '/ampliaciones/galeria/', '/tinglados/cocheras/'],
    ],
];
