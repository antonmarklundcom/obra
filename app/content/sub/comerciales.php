<?php
declare(strict_types=1);

// Especialidades de este hub: /{hub}/{slug}/. Una intencion de busqueda distinta a la del hub.
// 'related' son rutas completas. Sin precios, sin plazos fijos, sin datos inventados.
return [
    'locales' => [
        'name' => 'Adecuación de locales comerciales',
        'title' => 'Adecuación de locales comerciales en Paraguay | Obra',
        'description' => 'Adecuación de locales comerciales en Asunción y Gran Asunción: obra civil, instalaciones, vidriera, baños y terminaciones con fecha de apertura comprometida.',
        'h1' => 'Adecuación de locales comerciales',
        'kicker' => 'Del local vacío a la apertura',
        'intro' => [
            'Un local alquilado empieza a costar desde el primer día. Por eso la adecuación se planifica con la fecha de apertura como meta: qué permisos hacen falta, qué instalaciones exige el rubro, qué se puede fabricar mientras se hace la obra.',
            'Adecuamos locales de gastronomía, retail, salud y servicios: divisiones, instalaciones, vidriera, baños, pisos, cielorrasos e iluminación.',
        ],
        'includes' => ['Relevamiento del local y del contrato de alquiler', 'Demoliciones, divisiones y obra civil', 'Instalaciones eléctricas, sanitarias, datos y climatización', 'Vidriera, fachada y cartelería (obra civil)', 'Pisos, cielorrasos e iluminación'],
        'ideal' => ['Firmaste el alquiler y tenés fecha de apertura.', 'El local necesita baños o cocina que no tiene.', 'Querés un solo responsable para no coordinar diez proveedores.'],
        'faqs' => [
            ['¿Pueden cumplir una fecha de apertura?', 'Sí, cuando el alcance se cierra a tiempo y las decisiones se toman en fecha. La planificación se hace hacia atrás desde la apertura.'],
            ['¿Trabajan de noche o fines de semana?', 'Se acuerda según el edificio, los vecinos y la seguridad. No lo damos por hecho.'],
            ['¿Hacen locales gastronómicos?', 'Sí. Coordinamos extracción, gas, desagües con interceptor de grasa y las instalaciones que exige el rubro.'],
        ],
        'related' => ['/comerciales/oficinas/', '/comerciales/', '/tinglados/galpones/'],
    ],
    'oficinas' => [
        'name' => 'Oficinas y consultorios',
        'title' => 'Remodelación de oficinas y consultorios en Paraguay | Obra',
        'description' => 'Remodelación y adecuación de oficinas y consultorios en Asunción: divisiones, cableado de datos, climatización, baños y terminaciones con mínima interrupción de la actividad.',
        'h1' => 'Remodelación de oficinas y consultorios',
        'kicker' => 'Un lugar listo para trabajar y atender',
        'intro' => [
            'Oficinas y consultorios tienen exigencias propias: privacidad acústica, cableado de datos, climatización por ambiente, baños accesibles y, en salud, requisitos de habilitación.',
            'Remodelamos y adecuamos oficinas y consultorios, muchas veces con la actividad en marcha, organizando la obra por sectores y horarios.',
        ],
        'includes' => ['Divisiones con aislación acústica', 'Cableado eléctrico y de datos', 'Climatización por ambiente', 'Baños y sala de espera', 'Pisos, cielorrasos e iluminación de trabajo'],
        'ideal' => ['Alquilaste una oficina y hay que dividirla.', 'Vas a abrir un consultorio y necesitás cumplir requisitos.', 'Querés remodelar sin cerrar la oficina.'],
        'faqs' => [
            ['¿Pueden trabajar con la oficina funcionando?', 'Sí, por sectores y fuera del horario más crítico. Lo planificamos con vos.'],
            ['¿Conocen los requisitos para consultorios?', 'Relevamos los requisitos del rubro y de la habilitación local y los incorporamos al proyecto.'],
            ['¿Incluyen el mobiliario?', 'Podemos coordinarlo con nuestra carpintería. La propuesta aclara qué provee Obra y qué contratás vos.'],
        ],
        'related' => ['/comerciales/locales/', '/comerciales/', '/reformas/'],
    ],
];
