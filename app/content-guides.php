<?php
declare(strict_types=1);

// Guias informativas: capturan busquedas de investigacion ("cuanto cuesta construir", "platea o zapata",
// "albañil o constructora") y las llevan a cotizar. Viven en /guias/{slug}/, salvo 'path' explicito.
// Sin cifras de precio, sin plazos fijos, sin datos legales o bancarios que no podamos verificar.
return [
    'costo-casa' => [
        'name' => 'Qué define cuánto cuesta construir una casa',
        'title' => 'Cuánto cuesta construir una casa en Paraguay | Obra',
        'description' => 'Qué define el costo de construir una casa en Paraguay: metros, terreno, sistema constructivo, instalaciones y terminaciones. Cómo leer un presupuesto por rubro y comparar propuestas.',
        'h1' => 'Cuánto cuesta construir una casa en Paraguay: qué define el precio',
        'kicker' => 'Guía',
        'intro' => [
            'Todos preguntan lo mismo: cuánto cuesta el metro cuadrado. Y todos reciben cifras distintas, porque un precio por metro sin alcance no dice nada. Esta guía explica qué define el costo real de una casa y cómo comparar presupuestos sin que te sorprendan a mitad de obra.',
        ],
        'sections' => [
            ['Los metros cuadrados no son todos iguales', ['Una casa de 120 m² con galería, cochera y quincho no cuesta lo mismo que una de 120 m² cerrados. La superficie cubierta, la semicubierta y la descubierta tienen costos muy distintos, y cada presupuesto debería separarlas.', 'Por eso, antes de comparar precios, pedí que cada propuesta detalle qué metros son cubiertos, cuáles semicubiertos y qué incluye cada uno.']],
            ['El terreno cambia el presupuesto', ['Un terreno con desnivel necesita movimiento de suelo y muros de contención. Un suelo blando pide fundaciones más profundas. Un terreno sin agua ni cloaca necesita pozo y cámara séptica. Un terreno con acceso angosto encarece la logística.', 'Nada de esto aparece en un precio por metro cuadrado, y todo esto aparece en la obra.']],
            ['Sistema constructivo e instalaciones', ['La mampostería de ladrillo con estructura de hormigón es el sistema tradicional en Paraguay: aguanta el clima, lo aceptan los bancos y cualquier albañil lo conoce. Otros sistemas pueden ser más rápidos pero cambian el costo de terminación y la reventa.', 'Las instalaciones (agua, desagüe, electricidad, aire acondicionado, datos) pesan cada vez más en el presupuesto. Una casa con aire en cada ambiente y muchos puntos eléctricos no cuesta lo mismo que una básica.']],
            ['Las terminaciones deciden el precio final', ['Piso cerámico o porcelanato grande, aberturas de aluminio común o de línea reforzada, grifería estándar o de diseño, pintura o revestimiento: las terminaciones pueden mover el presupuesto más que la obra gruesa. Por eso conviene definirlas antes de cotizar, no después.']],
            ['Cómo leer un presupuesto por rubro', ['Un presupuesto serio se divide por rubros: movimiento de suelo, fundaciones, mampostería, estructura, techo, instalaciones, aberturas, revestimientos, pintura, terminaciones. Cada rubro tiene cantidades y precio unitario en guaraníes.', 'Con ese detalle podés comparar propuestas rubro por rubro, ver qué incluye cada una y qué no, y decidir dónde ajustar. Un precio global por metro cuadrado no permite ninguna de esas cosas.']],
            ['Lo que no conviene hacer', ['Elegir la propuesta más barata sin verificar el alcance. Firmar sin lista de exclusiones. Cambiar terminaciones a mitad de obra sin repasar el presupuesto. Suponer que el precio incluye planos, permisos y conexiones si no lo dice.']],
        ],
        'faqs' => [
            ['¿Por qué no publican un precio por metro cuadrado?', 'Porque sería una cifra inventada. El costo real sale del terreno, el proyecto, las instalaciones y las terminaciones de cada casa. Preferimos darte un presupuesto por rubro que puedas comparar.'],
            ['¿Cuánto cuesta un presupuesto de obra?', 'La estimación inicial sobre tus datos se conversa sin compromiso. Un cómputo métrico completo se cotiza según el proyecto y se confirma antes de empezar.'],
            ['¿El presupuesto sirve para pedir un crédito?', 'Sí, si tiene el detalle por rubro y el cronograma que suelen pedir los bancos. Lo preparamos con ese formato.'],
        ],
        'related' => ['/presupuesto/', '/casas/', '/credito/'],
    ],
    'terreno' => [
        'name' => 'Qué revisar antes de construir en tu terreno',
        'title' => 'Qué revisar antes de construir en un terreno en Paraguay | Obra',
        'description' => 'Antes de construir en tu terreno: títulos, medidas reales, suelo, desnivel, servicios, retiros municipales y accesos. La lista que evita sorpresas caras en obra.',
        'h1' => 'Qué revisar antes de construir en tu terreno',
        'kicker' => 'Guía',
        'intro' => [
            'Tener el terreno es el primer paso, pero construir sobre él sin revisarlo es la forma más común de gastar de más. Estas son las cosas que verificamos antes de proyectar y presupuestar, y que vos podés adelantar.',
        ],
        'sections' => [
            ['Papeles y medidas', ['Título de propiedad a tu nombre o en trámite, plano de mensura y medidas reales del terreno. Es habitual que las medidas del título y las del terreno físico no coincidan exactamente. Una mensura actualizada evita conflictos con vecinos y con el municipio.']],
            ['El suelo y el agua', ['El tipo de suelo define las fundaciones. Un suelo arcilloso o con napa alta pide otra solución que uno firme. Si hay dudas, un estudio de suelo es una inversión chica frente al costo de una fundación mal dimensionada.', 'Revisá también hacia dónde escurre el agua de lluvia: un terreno más bajo que la calle o que los vecinos necesita resolver el drenaje antes de construir.']],
            ['Servicios disponibles', ['Agua corriente, cloaca, electricidad y, si corresponde, gas y datos. Cuando no hay red, hay que prever pozo, cámara séptica, y a veces un transformador. Eso entra en el presupuesto desde el principio.']],
            ['Retiros, alturas y usos', ['Cada municipio define retiros de frente y laterales, altura máxima y usos permitidos. Un proyecto que no los respeta no se aprueba. Lo verificamos con el municipio correspondiente antes de proyectar.']],
            ['Accesos y vecinos', ['Por dónde entran los materiales y las máquinas, dónde se acopia, qué medianeras existen y en qué estado están. Un acceso angosto no impide construir, pero cambia la logística y hay que saberlo antes.']],
        ],
        'faqs' => [
            ['¿Puedo construir sin tener el título definitivo?', 'Depende del tipo de tenencia. Para permisos y créditos se suele exigir el título. Conviene regularizarlo antes de invertir en obra.'],
            ['¿Hace falta estudio de suelo para una casa?', 'No siempre, pero es recomendable cuando el suelo es blando, hay napa alta o se proyecta más de una planta.'],
            ['¿Ustedes visitan el terreno antes de cotizar?', 'Sí. La visita es parte del relevamiento y define gran parte del presupuesto.'],
        ],
        'related' => ['/casas/', '/guias/platea/', '/guias/permisos/'],
    ],
    'plazos' => [
        'name' => 'Cuánto tarda una obra: etapas y plazos',
        'title' => 'Cuánto tarda construir una casa en Paraguay | Obra',
        'description' => 'Las etapas de una obra y qué define su duración: fundaciones, mampostería, techo, instalaciones, terminaciones. Por qué no hay plazo sin alcance cerrado y qué lo atrasa.',
        'h1' => 'Cuánto tarda construir una casa: etapas y plazos de obra',
        'kicker' => 'Guía',
        'intro' => [
            'La segunda pregunta después del precio es cuánto tarda. La respuesta honesta es que depende del alcance, del clima y de las decisiones que se toman a tiempo. Acá explicamos las etapas de una obra y qué las acelera o las atrasa.',
        ],
        'sections' => [
            ['Las etapas de una obra', ['Movimiento de suelo y fundaciones. Mampostería y estructura. Techo. Instalaciones embutidas. Revoques y contrapisos. Aberturas. Revestimientos y pisos. Pintura y terminaciones. Artefactos, limpieza y entrega.', 'Cada etapa depende de la anterior y algunas necesitan tiempos de secado que no se pueden apurar.']],
            ['Qué define la duración', ['El tamaño y la complejidad del proyecto. El sistema constructivo. La cantidad de gremios que trabajan en paralelo. Los tiempos de provisión de aberturas, muebles y mesadas. El clima: la lluvia frena la obra gruesa y el calor extremo afecta el hormigón.']],
            ['Qué atrasa una obra', ['Las decisiones tardías del cliente son la causa más común: elegir el piso cuando ya hay que colocarlo, cambiar la ubicación de un toma cuando la pared está revocada. Después vienen los cambios de alcance, los pagos fuera de fecha y los problemas de terreno que no se relevaron.']],
            ['Cómo trabajamos los plazos', ['Definimos el plazo con el alcance cerrado y lo detallamos por etapas en la propuesta. Durante la obra enviamos reportes de avance y te avisamos con tiempo cada decisión que necesitamos. Así el plazo se cumple o se ajusta con explicación, no con sorpresa.']],
        ],
        'faqs' => [
            ['¿Pueden dar un plazo antes de ver el terreno?', 'No con seriedad. Podemos dar un rango orientativo por tipo de obra en la primera conversación, pero el plazo real sale con el alcance cerrado.'],
            ['¿Trabajan en época de lluvias?', 'Sí. Se planifica la obra gruesa para las épocas más secas cuando es posible y se protege lo ejecutado.'],
            ['¿Qué pasa si la obra se atrasa?', 'Los motivos y las consecuencias quedan escritos en el contrato. Preferimos avisar antes que explicar después.'],
        ],
        'related' => ['/como-trabajamos/', '/casas/etapas/', '/supervision/'],
    ],
    'permisos' => [
        'name' => 'Permisos municipales para construir',
        'title' => 'Permisos municipales para construir una casa en Paraguay | Obra',
        'description' => 'Qué permisos hacen falta para construir o ampliar en Paraguay: planos aprobados, profesional responsable, retiros y habilitación final. Qué pasa si se construye sin permiso.',
        'h1' => 'Permisos municipales para construir',
        'kicker' => 'Guía',
        'intro' => [
            'Construir sin permiso es común y sale caro: multas, obras paradas, problemas para vender o hipotecar. Esta guía resume qué suele exigir un municipio del Gran Asunción y cómo lo incluimos en el alcance llave en mano.',
        ],
        'sections' => [
            ['Qué se necesita en general', ['Planos firmados por un profesional matriculado, título o documentación del terreno, y el pago de las tasas municipales. El municipio revisa que el proyecto respete retiros, alturas, usos y superficie máxima. Los requisitos exactos cambian según el municipio y el tipo de obra.']],
            ['Quién firma', ['Un arquitecto o ingeniero matriculado firma el proyecto y, en muchos casos, la dirección técnica. Ese profesional es responsable ante el municipio. En una obra llave en mano lo coordinamos nosotros, con nuestro estudio o con el profesional que elijas.']],
            ['Ampliaciones y reformas', ['Sumar superficie cubierta, cambiar la fachada o tocar estructura suele requerir permiso. Cambiar pisos, pintura o revestimientos no. En la duda, se consulta antes de empezar.']],
            ['Al terminar', ['Algunos municipios exigen una habilitación o final de obra. Conviene tramitarla: es la que después permite regularizar la propiedad, venderla o usarla como garantía.']],
        ],
        'faqs' => [
            ['¿Ustedes gestionan el permiso?', 'Sí. En una obra llave en mano la documentación y la aprobación municipal forman parte del alcance.'],
            ['¿Puedo empezar la obra mientras se aprueba el plano?', 'No es recomendable. Una observación del municipio puede obligar a modificar lo construido.'],
            ['¿Qué pasa si mi casa actual no tiene permiso?', 'Se puede regularizar en muchos casos. Lo evaluamos con el profesional responsable antes de ampliar o reformar.'],
        ],
        'related' => ['/casas/', '/ampliaciones/', '/supervision/direccion/'],
    ],
    'platea' => [
        'name' => 'Platea o zapatas: fundaciones para tu casa',
        'title' => 'Platea o zapatas: qué fundación conviene | Obra',
        'description' => 'Platea de hormigón o zapatas y vigas de fundación: cuándo conviene cada una según el suelo, la casa y el presupuesto. Errores comunes en fundaciones en Paraguay.',
        'h1' => 'Platea o zapatas: qué fundación conviene para tu casa',
        'kicker' => 'Guía',
        'intro' => [
            'La fundación es la parte de la casa que nadie ve y la que más cuesta corregir. En Paraguay se usan dos soluciones principales: la platea de hormigón armado y las zapatas con vigas de fundación. Ninguna es mejor en abstracto; depende del suelo y del proyecto.',
        ],
        'sections' => [
            ['Qué es una platea', ['Una losa de hormigón armado que ocupa toda la superficie de la casa y reparte el peso sobre el suelo. Se ejecuta rápido, deja el contrapiso resuelto y funciona bien en suelos uniformes y proyectos de una planta.']],
            ['Qué son las zapatas', ['Bases aisladas bajo cada columna, unidas por vigas de fundación que sostienen las paredes. Permiten bajar a suelo firme cuando el terreno superficial es blando, y son la solución habitual para casas de dos plantas o cargas concentradas.']],
            ['Cómo se elige', ['Por el suelo, primero: un estudio o al menos un cateo dice qué hay debajo. Por el proyecto, después: cantidad de plantas, luces de la estructura, cargas. Y por el presupuesto, al final, comparando ambas soluciones con el mismo nivel de seguridad.']],
            ['Errores comunes', ['Platea sin compactar el suelo debajo. Zapatas demasiado superficiales sobre relleno. Falta de armadura o de recubrimiento. Hormigón mal curado por el calor. Todos se evitan con proyecto, dirección técnica y control en obra.']],
        ],
        'faqs' => [
            ['¿La platea es más barata?', 'Suele serlo en suelos firmes y casas de una planta, porque resuelve fundación y contrapiso a la vez. En suelos blandos puede no ser suficiente.'],
            ['¿Se puede construir una planta alta sobre platea?', 'Depende de cómo fue calculada. Si no se previó, hay que verificarla y probablemente reforzarla.'],
            ['¿Necesito estudio de suelo?', 'Es recomendable siempre y necesario cuando hay dudas sobre el terreno o se proyecta más de una planta.'],
        ],
        'related' => ['/guias/terreno/', '/casas/', '/guias/ladrillo-bloque/'],
    ],
    'ladrillo-bloque' => [
        'name' => 'Ladrillo o bloque: qué mampostería conviene',
        'title' => 'Ladrillo o bloque: qué mampostería conviene | Obra',
        'description' => 'Ladrillo común, ladrillo hueco o bloque de hormigón: comparación de aislación térmica, velocidad de obra, terminación y costo para construir en el clima paraguayo.',
        'h1' => 'Ladrillo o bloque: qué mampostería conviene',
        'kicker' => 'Guía',
        'intro' => [
            'En Paraguay se construye con ladrillo común, ladrillo hueco y bloque de hormigón. Cada uno cambia la aislación térmica, la velocidad de obra, el revoque y el costo. Esta guía compara los tres para el clima y la forma de construir de acá.',
        ],
        'sections' => [
            ['Ladrillo común', ['El material tradicional: macizo, pesado, con buena inercia térmica y la opción de dejarlo a la vista. Es más lento de levantar y consume más mortero, pero es el más versátil y el más valorado en terminación vista.']],
            ['Ladrillo hueco', ['Más liviano y rápido, con cámaras de aire que ayudan a la aislación. Requiere revoque y un buen dintel en aberturas. Es el más usado en obra corriente por su relación entre velocidad y costo.']],
            ['Bloque de hormigón', ['Muy rápido de levantar y con módulos grandes. Aísla menos del calor si no se combina con aislación o cámara de aire. Se usa mucho en muros perimetrales, galpones y obras donde la velocidad importa más que la terminación.']],
            ['Cómo elegimos', ['Por el uso del muro (exterior, interior, perimetral), por la terminación buscada, por la velocidad requerida y por el presupuesto. Una misma casa puede combinar los tres.']],
        ],
        'faqs' => [
            ['¿Cuál aísla mejor del calor?', 'El ladrillo macizo y el hueco se comportan mejor que el bloque sin aislación. Con aislación adicional, los tres pueden funcionar bien.'],
            ['¿El bloque es más barato?', 'Por metro cuadrado de muro suele serlo, pero el revoque, la aislación y la terminación pueden compensar la diferencia.'],
            ['¿Se puede dejar el ladrillo hueco a la vista?', 'No es recomendable. Para terminación vista se usa ladrillo común seleccionado.'],
        ],
        'related' => ['/casas/minimalistas/', '/muros/', '/guias/platea/'],
    ],
    'albanil' => [
        'name' => 'Albañil, maestro de obra o constructora',
        'title' => 'Albañil, maestro de obra o constructora: qué conviene | Obra',
        'description' => 'Diferencias entre contratar un albañil, un maestro de obra o una empresa constructora en Paraguay: responsabilidad, coordinación, presupuesto, garantía y qué conviene según la obra.',
        'h1' => 'Albañil, maestro de obra o constructora: qué conviene',
        'kicker' => 'Guía',
        'intro' => [
            'La mayoría de las obras en Paraguay se hacen con un albañil o un maestro de obra de confianza. Muchas salen bien. Otras terminan con el cliente coordinando gremios, comprando materiales y sin nadie que responda. Esta guía explica qué cambia con cada opción.',
        ],
        'sections' => [
            ['Albañil por jornal o por metro', ['Cobra por día o por metro cuadrado de trabajo. Vos comprás los materiales, coordinás plomero y electricista, y controlás la calidad. Funciona para trabajos chicos y definidos, cuando tenés tiempo y conocimiento para coordinar.']],
            ['Maestro de obra', ['Coordina a los albañiles y a veces a otros gremios, y suele cotizar mano de obra completa. La compra de materiales y las decisiones técnicas suelen quedar del lado del cliente. Es la forma más habitual de construir casas y también la que más conflictos genera por alcances que no quedan escritos.']],
            ['Empresa constructora', ['Asume la obra completa: materiales, mano de obra, gremios, dirección técnica, cronograma y responsabilidad por lo ejecutado. Cotiza por rubro con alcance escrito y responde ante el municipio y el banco. Cuesta más que la mano de obra suelta, pero incluye todo lo que en las otras opciones queda de tu lado.']],
            ['Qué conviene según la obra', ['Para un trabajo puntual y chico, un buen albañil. Para una obra mediana con varios gremios, un maestro de obra con alcance escrito y dirección técnica. Para una casa, una quinta o una obra con crédito, una constructora que asuma el conjunto.']],
        ],
        'faqs' => [
            ['¿Puedo contratar solo la supervisión si ya tengo albañil?', 'Sí. Ofrecemos supervisión y dirección técnica para obras que ejecuta otro. Es una forma de sumar control profesional sin cambiar de equipo.'],
            ['¿La constructora es siempre más cara?', 'La cifra final suele ser mayor porque incluye lo que con un albañil pagás aparte: materiales, gremios, dirección, imprevistos. Comparado el mismo alcance, la diferencia es menor de lo que parece.'],
            ['¿Trabajan con un maestro de obra que ya conozco?', 'Podemos integrarlo al equipo cuando el proyecto lo permite, bajo nuestra dirección técnica.'],
        ],
        'related' => ['/supervision/', '/como-trabajamos/', '/presupuesto/'],
    ],
    'credito' => [
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
    ],
];
