<?php
declare(strict_types=1);

// Especialidades de este hub: /{hub}/{slug}/. Una intencion de busqueda distinta a la del hub.
// 'related' son rutas completas. Sin precios, sin plazos fijos, sin datos inventados.
return [
    'planta-alta' => [
        'name' => 'Ampliación en planta alta',
        'title' => 'Ampliación en planta alta en Paraguay | Obra',
        'description' => 'Ampliación de casas en planta alta en Asunción y Gran Asunción: verificación de estructura, losa, escalera e instalaciones para sumar un piso sin perder el patio.',
        'h1' => 'Ampliación en planta alta',
        'kicker' => 'Crecer hacia arriba cuando el terreno no da más',
        'intro' => [
            'Construir un piso arriba es la ampliación más deseada en terrenos chicos y la que más verificación técnica exige. La pregunta no es si se puede, sino qué aguanta la estructura existente y qué hay que reforzar.',
            'Verificamos fundaciones, columnas y losa antes de proponer una solución. Después proyectamos la escalera, las instalaciones que suben y la forma de trabajar con la casa habitada.',
        ],
        'includes' => ['Verificación estructural de lo existente', 'Refuerzos de columnas o fundaciones si hacen falta', 'Losa nueva, escalera e instalaciones', 'Techo nuevo y aislación', 'Terminaciones y protección de la planta baja durante la obra'],
        'ideal' => ['Tu terreno es chico y necesitás más ambientes.', 'Querés un dormitorio en suite o un estudio arriba.', 'Preferís no perder el patio ni la cochera.'],
        'faqs' => [
            ['¿Cómo saben si mi casa aguanta un piso más?', 'Con un relevamiento de la estructura existente y, si hace falta, cateos en fundaciones. Con eso el ingeniero define refuerzos o confirma que se puede construir.'],
            ['¿Puedo seguir viviendo abajo?', 'En general sí. La planta baja se protege y se programa la obra para las etapas más invasivas.'],
            ['¿Necesito planos?', 'Sí. Una planta alta requiere proyecto y aprobación municipal. Lo incluimos en el alcance.'],
        ],
        'related' => ['/casas/duplex/', '/ampliaciones/dormitorio/', '/ampliaciones/'],
    ],
    'dormitorio' => [
        'name' => 'Ampliación de dormitorio y baño',
        'title' => 'Ampliación de dormitorio y baño en Paraguay | Obra',
        'description' => 'Ampliación de un dormitorio con baño en Asunción y Gran Asunción: la ampliación más común, resuelta con fundaciones, techo e instalaciones empalmadas a la casa.',
        'h1' => 'Ampliación de dormitorio y baño',
        'kicker' => 'La ampliación más pedida, bien hecha',
        'intro' => [
            'La familia crece, llega un familiar mayor o hace falta un espacio propio: un dormitorio con baño es la ampliación más común en Paraguay. Parece chica, pero toca todo: fundaciones, techo, desagües y electricidad.',
            'La hacemos como una obra completa, con el empalme al techo existente resuelto para que no filtre y las instalaciones conectadas correctamente.',
        ],
        'includes' => ['Fundaciones y mampostería del sector nuevo', 'Empalme de techos sin filtraciones', 'Baño con instalaciones conectadas a las existentes', 'Aberturas y terminaciones a tono con la casa', 'Protección y limpieza del sector habitado'],
        'ideal' => ['Necesitás un dormitorio más.', 'Va a vivir con ustedes un familiar mayor.', 'Querés una suite independiente con acceso propio.'],
        'faqs' => [
            ['¿Se puede conectar el baño nuevo a la instalación existente?', 'En general sí, respetando pendientes y ventilación. Lo verificamos en el relevamiento.'],
            ['¿Cuánto dura una ampliación de dormitorio?', 'Es una obra de pocas semanas comparada con una casa completa. El plazo se define con el alcance cerrado.'],
            ['¿Puedo hacerla independiente para alquilar?', 'Sí. Se proyecta con acceso propio, kitchenette y medidor separado si corresponde.'],
        ],
        'related' => ['/ampliaciones/', '/reformas/banos/', '/ampliaciones/galeria/'],
    ],
    'galeria' => [
        'name' => 'Galerías cubiertas',
        'title' => 'Construcción de galerías cubiertas en Paraguay | Obra',
        'description' => 'Construcción de galerías cubiertas en Asunción y Gran Asunción: la ampliación que más se usa, con techo, piso y conexión a la casa y al patio.',
        'h1' => 'Construcción de galerías cubiertas',
        'kicker' => 'El ambiente que más se usa en Paraguay',
        'intro' => [
            'En Paraguay se vive en la galería: es donde se toma tereré, donde comen los chicos, donde se recibe. Una galería bien hecha suma metros útiles a un costo mucho menor que un ambiente cerrado.',
            'Construimos galerías con techo de teja, chapa o losa, piso continuo con el interior, iluminación y previsión de ventilador o parrilla.',
        ],
        'includes' => ['Columnas y estructura del techo', 'Cubierta con aislación y canaletas', 'Piso exterior continuo o deck', 'Iluminación, tomas y ventiladores', 'Unión con la casa: aberturas y niveles'],
        'ideal' => ['Tu casa no tiene un espacio exterior cubierto.', 'Querés conectar el living con el patio.', 'Buscás un lugar para la parrilla sin construir un quincho completo.'],
        'faqs' => [
            ['¿Necesita fundaciones?', 'Sí, para las columnas y el contrapiso. Son menores que las de un ambiente cerrado, pero necesarias.'],
            ['¿Se puede cerrar después?', 'Sí, si se prevé desde el inicio. Una galería bien pensada se convierte en quincho cerrado más adelante.'],
            ['¿Qué techo conviene?', 'Depende del techo de la casa y del presupuesto. Teja para continuidad estética, chapa aislada por economía, losa para diseño moderno.'],
        ],
        'related' => ['/patios/pergolas/', '/quinchos/', '/ampliaciones/'],
    ],
];
