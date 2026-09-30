<?php
declare(strict_types=1);

// Especialidades de este hub: /{hub}/{slug}/. Una intencion de busqueda distinta a la del hub.
// 'related' son rutas completas. Sin precios, sin plazos fijos, sin datos inventados.
return [
    'cocinas' => [
        'name' => 'Remodelación de cocinas',
        'title' => 'Remodelación de cocinas en Paraguay | Obra',
        'description' => 'Remodelación de cocinas en Asunción y Gran Asunción: obra civil con demolición, instalaciones de agua, gas y electricidad, y revestimientos.',
        'summary' => 'Remodelación de cocinas en Asunción y Gran Asunción: distribución, instalaciones de agua, gas y electricidad, revestimientos, mesadas y muebles coordinados en una sola obra.',
        'h1' => 'Remodelación de cocinas',
        'kicker' => 'Distribución, instalaciones y terminación en una sola obra',
        'intro' => [
            'Remodelar la cocina es la reforma con más gremios por metro cuadrado: albañil, plomero, electricista, gasista, mueblero, marmolero. Cuando cada uno viene por su lado, el resultado se nota en los encuentros y en los tiempos.',
            'Nosotros coordinamos todo el proceso, desde la demolición hasta la instalación de la mesada y los artefactos, con una secuencia definida antes de empezar.',
        ],
        'includes' => ['Nueva distribución y demoliciones', 'Instalación de agua, desagüe, gas y electricidad', 'Revestimientos, pisos y cielorraso', 'Coordinación de muebles, mesadas y griferías', 'Iluminación y tomas donde se usan'],
        'ideal' => ['Tu cocina tiene una distribución que ya no funciona.', 'Querés integrar cocina y comedor.', 'Vas a renovar muebles y necesitás mover instalaciones.'],
        'faqs' => [
            ['¿Cuánto tiempo queda sin cocina?', 'Depende del alcance y de los tiempos de fabricación de muebles y mesadas. Lo secuenciamos para reducir los días sin uso.'],
            ['¿Incluyen los muebles?', 'Podemos coordinarlos con nuestra carpintería o con el proveedor que elijas. Lo que sí hacemos siempre es dejar la obra lista para su instalación.'],
            ['¿Puedo mover la cocina a otro ambiente?', 'Sí, si los desagües y la ventilación lo permiten. Lo verificamos en el relevamiento.'],
        ],
        'related' => ['/reformas/banos/', '/reformas/', '/ampliaciones/'],
        'link' => ['site' => 'carpinteria', 'path' => '/cocinas/', 'text' => 'Los muebles de cocina a medida los fabrica carpinteria.com.py; nosotros hacemos la demolición, las instalaciones y los revestimientos para que lleguen a una cocina lista.'],
    ],
    'banos' => [
        'name' => 'Remodelación de baños',
        'title' => 'Remodelación de baños en Paraguay | Obra',
        'description' => 'Remodelación de baños en Asunción y Gran Asunción: impermeabilización, instalaciones, revestimientos, ducha a nivel y sanitarios nuevos con un solo responsable.',
        'h1' => 'Remodelación de baños',
        'kicker' => 'Sin humedades y con la ducha bien resuelta',
        'intro' => [
            'Un baño mal remodelado se descubre a los meses: humedad en la pared del vecino, ducha que no drena, azulejos que se sueltan. La diferencia está en lo que no se ve: impermeabilización, pendientes y cañerías.',
            'Remodelamos baños completos o parciales, con ducha a nivel del piso, revestimientos grandes y sanitarios nuevos, cuidando la parte técnica antes que la estética.',
        ],
        'includes' => ['Demolición y retiro de revestimientos', 'Cañerías de agua y desagüe nuevas', 'Impermeabilización y pendientes de ducha', 'Revestimientos, piso y cielorraso', 'Sanitarios, grifería, mampara y accesorios'],
        'ideal' => ['El baño tiene humedad o pérdidas.', 'Querés una ducha a nivel del piso, más segura y moderna.', 'Vas a hacer un baño adaptado para una persona mayor.'],
        'faqs' => [
            ['¿Se puede cambiar la bañera por ducha a nivel?', 'Sí. Es una de las reformas más pedidas. Requiere rehacer el desagüe y la pendiente del piso.'],
            ['¿Cuántos días queda sin baño?', 'Depende del alcance. Si hay otro baño en la casa, la obra se organiza sin apuro; si es el único, priorizamos dejarlo usable cuanto antes.'],
            ['¿Hacen baños adaptados?', 'Sí: sin escalones, barrales, espacio de giro y grifería accesible.'],
        ],
        'related' => ['/reformas/cocinas/', '/ampliaciones/dormitorio/', '/reformas/'],
    ],
    'fachadas' => [
        'name' => 'Renovación de fachadas',
        'title' => 'Renovación de fachadas de casas en Paraguay | Obra',
        'description' => 'Renovación de fachadas en Asunción y Gran Asunción: revoque, revestimientos, aberturas y muro frontal para cambiar la cara de la casa sin tocar adentro.',
        'summary' => 'Renovación de fachadas en Asunción y Gran Asunción: revoque, revestimientos, aberturas, techo de acceso y muro frontal para cambiar la cara de la casa sin tocar el interior.',
        'h1' => 'Renovación de fachadas',
        'kicker' => 'Otra casa desde la calle',
        'intro' => [
            'La fachada es lo primero que se ve y lo último que se renueva. Cambiar revoque, aberturas, el techo del acceso y el muro frontal transforma la casa sin tocar el interior, y suma valor si pensás vender o alquilar.',
            'Trabajamos la fachada como una obra completa: humedades, revoques, revestimientos, aberturas, iluminación y muro de frente, con andamios y protección de la vereda.',
        ],
        'includes' => ['Reparación de humedades y revoques', 'Revestimientos: piedra, ladrillo visto o texturas', 'Cambio de aberturas de frente', 'Techo o pérgola de acceso y cochera', 'Muro frontal, portón e iluminación'],
        'ideal' => ['La casa está bien adentro pero se ve vieja desde afuera.', 'Vas a vender o alquilar y querés que impacte.', 'Querés sumar cochera cubierta y portón nuevo.'],
        'faqs' => [
            ['¿Puedo cambiar la fachada sin permiso?', 'Cambios de terminación no suelen requerirlo; cambios estructurales o de superficie cubierta sí. Lo revisamos.'],
            ['¿Cuánto dura una obra de fachada?', 'Depende del alcance y del clima, porque gran parte se hace a la intemperie. Se define en la propuesta.'],
            ['¿Incluyen la pintura?', 'Sí, cuando forma parte del alcance. Recomendamos definirla junto con el revestimiento.'],
        ],
        'related' => ['/muros/portones/', '/tinglados/cocheras/', '/reformas/'],
        'link' => ['site' => 'arq', 'path' => '/estilos/', 'text' => 'Si todavía no está definido el diseño de la nueva fachada, el proyecto lo prepara nuestro estudio en arq.com.py y nosotros lo ejecutamos en obra.'],
    ],
    'techos' => [
        'name' => 'Cambio y reparación de techos',
        'title' => 'Cambio y reparación de techos en Paraguay | Obra',
        'description' => 'Reparación y cambio de techos de tejas, chapa y losa en Asunción y Gran Asunción: filtraciones, estructura, aislación térmica y canaletas resueltas de raíz.',
        'h1' => 'Cambio y reparación de techos',
        'kicker' => 'Filtraciones resueltas de raíz',
        'intro' => [
            'Una filtración se parcha una vez. La segunda vez conviene entender la causa: tejas rotas, pendiente insuficiente, estructura vencida, canaletas tapadas o una losa sin membrana. Cada caso tiene una solución distinta.',
            'Reparamos y cambiamos techos completos: estructura, cubierta, aislación térmica, cielorraso y canaletas, con protección de la casa mientras dura la obra.',
        ],
        'includes' => ['Diagnóstico de la causa de la filtración', 'Cambio de tejas, chapa o membrana de losa', 'Refuerzo o reemplazo de estructura', 'Aislación térmica y cielorraso', 'Canaletas, bajadas y desagües'],
        'ideal' => ['El techo filtra y ya lo parchaste varias veces.', 'La casa es muy calurosa y el techo no tiene aislación.', 'Querés cambiar teja por chapa aislada o al revés.'],
        'faqs' => [
            ['¿Conviene reparar o cambiar todo el techo?', 'Depende del estado de la estructura y de cuánta cubierta está dañada. Lo evaluamos y te damos las dos opciones cuando existen.'],
            ['¿Se puede hacer con la casa habitada?', 'Sí. Trabajamos por sectores y protegemos con lonas cada tramo abierto.'],
            ['¿Qué aislación recomiendan?', 'Depende del tipo de cubierta y del presupuesto. Lo importante es que exista y esté bien colocada.'],
        ],
        'related' => ['/reformas/', '/tinglados/', '/quintas/refaccion/'],
    ],
];
