<?php
declare(strict_types=1);

// Especialidades de este hub: /{hub}/{slug}/. Una intencion de busqueda distinta a la del hub.
// 'related' son rutas completas. Sin precios, sin plazos fijos, sin datos inventados.
return [
    'duplex' => [
        'name' => 'Dúplex y casas de dos plantas',
        'title' => 'Construcción de dúplex en Paraguay | Obra',
        'description' => 'Construcción de dúplex y casas de dos plantas en Asunción y Gran Asunción: estructura, losa, escalera e instalaciones resueltas para aprovechar terrenos chicos.',
        'h1' => 'Construcción de dúplex y casas de dos plantas',
        'kicker' => 'Más metros en el mismo terreno',
        'intro' => [
            'Un dúplex resuelve un problema muy común en Asunción y Central: terrenos angostos o compartidos donde una casa de una planta no alcanza. Construimos dúplex para vivienda propia, para dos familias y como unidades para alquilar.',
            'La diferencia con una casa de una planta está en la estructura: losa, columnas, escalera y las instalaciones que suben. Eso se define en el proyecto, no en la obra, para que el presupuesto sea real desde el principio.',
        ],
        'includes' => ['Estructura de hormigón armado y losa', 'Escalera interior o exterior según el uso', 'Instalaciones independientes por unidad cuando son dos viviendas', 'Aislación acústica entre unidades', 'Cochera, acceso y medidores separados'],
        'ideal' => ['Tu terreno es angosto o querés dejar patio libre.', 'Querés dos unidades: una para vivir y otra para alquilar.', 'Construís sobre un terreno familiar compartido.'],
        'faqs' => [
            ['¿Un dúplex es más caro por metro cuadrado que una casa de una planta?', 'La estructura y la escalera suman costo, pero se ahorra en techo, fundaciones y terreno por metro construido. La comparación real sale del cómputo por rubro de cada proyecto.'],
            ['¿Puedo hacer dos unidades con medidores separados?', 'Sí. Se proyectan instalaciones independientes y se coordina la habilitación de medidores con las prestadoras.'],
            ['¿Se puede construir el dúplex por etapas?', 'Sí, siempre que la estructura de la segunda planta quede prevista desde la primera etapa.'],
        ],
        'related' => ['/casas/minimalistas/', '/casas/etapas/', '/ampliaciones/planta-alta/'],
    ],
    'minimalistas' => [
        'name' => 'Casas modernas y minimalistas',
        'title' => 'Construcción de casas modernas y minimalistas en Paraguay | Obra',
        'description' => 'Construcción de casas modernas y minimalistas en Asunción y Gran Asunción: losa plana, ladrillo visto, grandes aberturas y galería integrada, ejecutadas con terminaciones limpias.',
        'h1' => 'Construcción de casas modernas y minimalistas',
        'kicker' => 'Líneas simples, bien ejecutadas',
        'intro' => [
            'El estilo moderno paraguayo tiene códigos claros: losa plana o techo oculto, ladrillo visto, hormigón a la vista, aberturas grandes hacia el patio y galería como extensión de la casa. Es un estilo que perdona poco: cada junta, cada encuentro y cada nivel se ve.',
            'Por eso lo tratamos como una obra de precisión. Definimos con vos y con el proyectista qué terminaciones quedan a la vista, qué materiales las logran y cómo se protegen del calor y la lluvia.',
        ],
        'includes' => ['Losa plana con aislación y pendientes de desagüe ocultas', 'Ladrillo visto o revoque fino según el proyecto', 'Aberturas de gran luz con dinteles y vigas calculadas', 'Galería integrada con piso continuo', 'Detalles de terminación: bordes, zócalos y encuentros'],
        'ideal' => ['Querés una casa de líneas limpias sin sobresaltos en la terminación.', 'Ya tenés un proyecto moderno y necesitás quien lo ejecute con precisión.', 'Buscás una casa con galería y patio integrados.'],
        'faqs' => [
            ['¿La losa plana da problemas de filtración?', 'Da problemas cuando está mal ejecutada. Con pendientes correctas, desagües bien ubicados, membrana y aislación térmica funciona bien en el clima paraguayo.'],
            ['¿El ladrillo visto necesita mantenimiento?', 'Necesita un sellado periódico y una buena ejecución de juntas desde el inicio. Lo incluimos en el alcance y te explicamos el mantenimiento al entregar.'],
            ['¿Hacen el proyecto también?', 'El diseño lo hace nuestro estudio en arq.com.py o el arquitecto que elijas. Nosotros construimos.'],
        ],
        'related' => ['/casas/duplex/', '/patios/decks/', '/piscinas/desbordante/'],
    ],
    'etapas' => [
        'name' => 'Construcción por etapas',
        'title' => 'Construcción de casas por etapas en Paraguay | Obra',
        'description' => 'Construí tu casa por etapas en Asunción y Gran Asunción: obra gruesa primero, terminaciones después, con un plan que evita rehacer y mantiene el presupuesto controlado.',
        'h1' => 'Construcción de casas por etapas',
        'kicker' => 'Empezá con lo que tenés, sin cerrar puertas',
        'intro' => [
            'Muchas familias construyen a medida que pueden: primero la platea y la mampostería, después el techo, más adelante las terminaciones. Bien planificado funciona. Mal planificado se paga dos veces: se rompe lo hecho para pasar caños o se levantan paredes que después estorban.',
            'Nuestro trabajo es ordenar la secuencia técnica para que cada etapa deje la siguiente preparada, y que cada etapa tenga su propio presupuesto cerrado.',
        ],
        'includes' => ['Plan de etapas con lo que debe quedar previsto en cada una', 'Etapa 1: fundaciones, mampostería y estructura', 'Etapa 2: techo, instalaciones embutidas y aberturas', 'Etapa 3: revestimientos, pisos, pintura y artefactos', 'Presupuesto independiente por etapa'],
        'ideal' => ['Tenés terreno y fondos para arrancar, pero no para toda la casa.', 'Vas a combinar ahorro propio con un crédito más adelante.', 'Querés habitar una parte de la casa mientras se termina el resto.'],
        'faqs' => [
            ['¿Cuál es el orden correcto de las etapas?', 'Fundaciones y estructura, después techo y cerramiento, después instalaciones y terminaciones. Lo que nunca conviene es dejar la obra gruesa expuesta a la lluvia sin techo por mucho tiempo.'],
            ['¿Puedo cambiar de constructor entre etapas?', 'Podés. Por eso cada etapa se entrega con un detalle de lo ejecutado y de lo que quedó previsto para la siguiente.'],
            ['¿Se puede vivir en la casa entre etapas?', 'Sí, cuando una parte está habitable y la obra restante se aísla de forma segura.'],
        ],
        'related' => ['/credito/', '/guias/costo-casa/', '/ampliaciones/'],
    ],
    'prefabricadas' => [
        'name' => 'Casas prefabricadas vs construcción tradicional',
        'title' => 'Casas prefabricadas vs construcción tradicional | Obra',
        'description' => 'Casas prefabricadas y premoldeadas frente a la construcción tradicional en Paraguay: durabilidad, clima, financiación, reventa y en qué casos conviene cada una.',
        'h1' => 'Casas prefabricadas o construcción tradicional: qué conviene',
        'kicker' => 'Una comparación honesta antes de decidir',
        'intro' => [
            'Las casas prefabricadas y premoldeadas se venden como la opción rápida y económica. En algunos casos lo son. Pero en Paraguay pesan tres cosas que conviene mirar antes: el calor, la humedad y la financiación bancaria.',
            'Obra construye con sistema tradicional (mampostería de ladrillo y estructura de hormigón). Acá te contamos sin vueltas cuándo una prefabricada puede ser mejor para vos y cuándo no.',
        ],
        'includes' => ['Comportamiento térmico en el verano paraguayo', 'Durabilidad, mantenimiento y humedad', 'Qué acepta un banco o la AFD como garantía', 'Valor de reventa y ampliaciones futuras', 'Costo total: casa, platea, instalaciones y terreno preparado'],
        'ideal' => ['Estás comparando presupuestos de prefabricadas con los de obra tradicional.', 'Necesitás construir rápido y querés saber el costo real de esa velocidad.', 'Vas a financiar con crédito y no sabés qué acepta el banco.'],
        'faqs' => [
            ['¿Una casa prefabricada es más barata?', 'El precio de catálogo suele no incluir platea, instalaciones, conexiones ni terminaciones. Comparado el mismo alcance, la diferencia se achica y a veces se invierte.'],
            ['¿Los bancos financian casas prefabricadas?', 'Depende del sistema y de la entidad. Muchas líneas hipotecarias exigen construcción tradicional o sistemas certificados. Consultá antes de firmar.'],
            ['¿Se puede ampliar una prefabricada?', 'Es más difícil integrar una ampliación tradicional a un sistema modular. Con mampostería, ampliar es parte del oficio.'],
        ],
        'related' => ['/casas/etapas/', '/guias/costo-casa/', '/guias/ladrillo-bloque/'],
    ],
];
