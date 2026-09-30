<?php
declare(strict_types=1);

// Especialidades de este hub: /{hub}/{slug}/. Una intencion de busqueda distinta a la del hub.
// 'related' son rutas completas. Sin precios, sin plazos fijos, sin datos inventados.
return [
    'chicas' => [
        'name' => 'Piscinas pequeñas para patios chicos',
        'title' => 'Piscinas pequeñas para patios chicos en Paraguay | Obra',
        'description' => 'Piscinas pequeñas de hormigón para patios chicos en Asunción y Gran Asunción: medidas a la medida del espacio, acceso de obra resuelto y vereda integrada.',
        'summary' => 'Construcción de piscinas pequeñas de hormigón para patios chicos en Asunción y Gran Asunción: medidas a la medida del espacio, acceso de obra resuelto y vereda integrada.',
        'h1' => 'Piscinas pequeñas para patios chicos',
        'kicker' => 'Una piscina real en pocos metros',
        'intro' => [
            'En Asunción, Fernando de la Mora, Luque o San Lorenzo los patios suelen ser chicos. Eso no impide tener una piscina de hormigón: cambia el diseño, no la calidad. Una piscina compacta bien ubicada aprovecha mejor el patio que una grande que no deja lugar para nada más.',
            'El desafío real en patios chicos es el acceso: por dónde entra la excavadora, dónde va la tierra, cómo se protege lo que ya existe. Lo resolvemos antes de cotizar.',
        ],
        'includes' => ['Diseño de medidas y forma según el patio real', 'Excavación manual o con máquina chica según el acceso', 'Estructura de hormigón armado y filtrado compacto', 'Vereda perimetral y unión con la galería', 'Iluminación y previsión de climatización'],
        'ideal' => ['Tu patio tiene pocos metros y querés aprovecharlos.', 'La casa ya está construida y el acceso es angosto.', 'Querés piscina sin renunciar a un sector de quincho o jardín.'],
        'faqs' => [
            ['¿Cuál es la medida mínima razonable?', 'Depende del uso. Para refrescarse y jugar con chicos alcanza con medidas muy compactas; para nadar hace falta más largo. Lo definimos con vos sobre el plano del patio.'],
            ['¿Cómo entra la máquina si el pasillo es angosto?', 'Con equipos chicos o excavación manual. Es más lento pero habitual. El método se decide en la visita.'],
            ['¿Se puede hacer una piscina elevada?', 'Sí, cuando el suelo o el acceso lo justifican. Cambia la estructura y la terminación exterior.'],
        ],
        'related' => ['/piscinas/quinta/', '/patios/decks/', '/quinchos/'],
    ],
    'quinta' => [
        'name' => 'Piscinas para quintas',
        'title' => 'Construcción de piscinas para quintas en Paraguay | Obra',
        'description' => 'Piscinas de hormigón para quintas y casas de campo en Paraguay: mayor tamaño, agua de pozo, filtrado dimensionado y área de quincho y solárium integrada.',
        'h1' => 'Piscinas para quintas y casas de campo',
        'kicker' => 'Tamaño, agua propia y todo alrededor',
        'intro' => [
            'En una quinta la piscina es el centro del fin de semana. Suele ser más grande, se llena con agua de pozo y convive con quincho, galería y jardín. Eso cambia el filtrado, la vereda y la forma de cuidarla entre visita y visita.',
            'Proyectamos la piscina junto con el quincho y el solárium, y dimensionamos la instalación para agua de pozo y para períodos sin uso.',
        ],
        'includes' => ['Piscina de hormigón de mayor tamaño y profundidad variable', 'Filtrado dimensionado para agua de pozo y uso intermitente', 'Solárium, vereda amplia y ducha exterior', 'Unión con quincho y galería', 'Casilla de máquinas y previsión de climatización'],
        'ideal' => ['Tenés una quinta y querés la piscina como centro del espacio exterior.', 'Vas a llenar con agua de pozo.', 'Querés hacer piscina y quincho como una sola obra.'],
        'faqs' => [
            ['¿El agua de pozo sirve para la piscina?', 'Sí, con un análisis previo y un tratamiento adecuado. A veces hace falta un filtro adicional por hierro o dureza.'],
            ['¿Cómo se mantiene si voy solo los fines de semana?', 'Con un filtrado bien dimensionado, un temporizador y una rutina simple. Te dejamos el instructivo al entregar.'],
            ['¿Pueden hacer una piscina con zona para chicos?', 'Sí. Se proyecta con un sector de baja profundidad o escalones amplios.'],
        ],
        'related' => ['/quintas/', '/quinchos/', '/piscinas/desbordante/'],
    ],
    'desbordante' => [
        'name' => 'Piscinas desbordantes',
        'title' => 'Piscinas desbordantes e infinity en Paraguay | Obra',
        'description' => 'Piscinas desbordantes (infinity) en Paraguay: borde perdido, canaleta, tanque de compensación y estructura calculada para que el efecto no filtre.',
        'summary' => 'Construcción de piscinas desbordantes (infinity) en Paraguay: borde perdido, canaleta, tanque de compensación y estructura calculada para el efecto sin filtraciones.',
        'h1' => 'Piscinas desbordantes e infinity',
        'kicker' => 'El borde perdido bien resuelto',
        'intro' => [
            'Una piscina desbordante se ve simple y es técnicamente la más exigente: el agua tiene que pasar el borde de forma pareja, caer a una canaleta y volver desde un tanque de compensación. Un desnivel de milímetros en el borde se nota.',
            'Ejecutamos piscinas desbordantes de uno o varios lados, con la nivelación del borde controlada y la instalación hidráulica dimensionada para el caudal real.',
        ],
        'includes' => ['Estructura con muro de desborde y canaleta', 'Tanque de compensación y bombas dimensionadas', 'Nivelación de precisión del borde', 'Revestimiento continuo y borde de terminación', 'Iluminación y automatización de nivel'],
        'ideal' => ['Tu terreno tiene desnivel o vista y querés aprovecharlos.', 'Buscás una piscina de diseño con terminación de alto nivel.', 'Ya tenés un proyecto de arquitectura con piscina desbordante.'],
        'faqs' => [
            ['¿Una desbordante gasta más agua?', 'Pierde algo más por evaporación y salpicadura, pero el tanque de compensación recupera el agua del desborde. Con una instalación bien hecha, el consumo es razonable.'],
            ['¿Se puede hacer en un patio plano?', 'Sí. El efecto de borde perdido funciona con un desnivel construido; no hace falta una barranca.'],
            ['¿Es mucho más cara que una piscina común?', 'Suma estructura, tanque y bombas. Cuánto más depende del tamaño y de cuántos lados desbordan. Se ve en el cómputo por rubro.'],
        ],
        'related' => ['/piscinas/quinta/', '/casas/minimalistas/', '/patios/decks/'],
    ],
    'renovacion' => [
        'name' => 'Renovación y reparación de piscinas',
        'title' => 'Renovación y reparación de piscinas en Paraguay | Obra',
        'description' => 'Renovación de piscinas en Asunción y Gran Asunción: pérdidas de agua, revestimiento, vereda, filtrado e iluminación renovados sin construir de nuevo.',
        'h1' => 'Renovación y reparación de piscinas',
        'kicker' => 'Recuperá la piscina que ya tenés',
        'intro' => [
            'Una piscina de hormigón vieja casi siempre se puede recuperar: se detecta la pérdida, se repara la estructura o la cañería, se cambia el revestimiento y se renueva el filtrado. Sale mucho menos que hacer una nueva.',
            'Empezamos con una prueba de pérdida y una revisión de la instalación. Con eso sabemos si el problema es de estructura, de cañería o de equipos, y cotizamos lo que corresponde.',
        ],
        'includes' => ['Detección de pérdidas en vaso y cañerías', 'Reparación estructural y sellado', 'Cambio de revestimiento: venecitas, cerámica o pintura', 'Renovación de filtro, bomba e iluminación', 'Vereda nueva y bordes'],
        'ideal' => ['La piscina pierde agua y no sabés por dónde.', 'El revestimiento está roto o manchado.', 'Compraste una casa con piscina en mal estado.'],
        'faqs' => [
            ['¿Cómo saben si pierde por la estructura o por la cañería?', 'Con pruebas de nivel con y sin el circuito de filtrado, y presurizando las cañerías. Es el primer paso antes de cotizar.'],
            ['¿Se puede cambiar la forma de una piscina existente?', 'Dentro de ciertos límites: reducir profundidad, agregar escalones o un sector para chicos. Ampliar el vaso es más complejo.'],
            ['¿Cuánto tiempo queda sin uso?', 'Depende del alcance. Un cambio de revestimiento es distinto a una reparación estructural. Lo detallamos en la propuesta.'],
        ],
        'related' => ['/piscinas/', '/quintas/refaccion/', '/patios/veredas/'],
    ],
];
