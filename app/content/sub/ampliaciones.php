<?php
declare(strict_types=1);

// Especialidades de este hub: /{hub}/{slug}/. Una intencion de busqueda distinta a la del hub.
// 'related' son rutas completas. Sin precios, sin plazos fijos, sin datos inventados.
return [
    'planta-alta' => [
        'name' => 'Ampliación en planta alta',
        'title' => 'Ampliación en planta alta en Paraguay | Obra',
        'description' => 'Ampliación en planta alta en Asunción y Gran Asunción: verificación de estructura, losa, escalera e instalaciones para sumar un piso sin perder el patio.',
        'summary' => 'Ampliación de casas en planta alta en Asunción y Gran Asunción: verificación de estructura, losa, escalera e instalaciones para sumar un piso sin perder el patio.',
        'h1' => 'Ampliación en planta alta',
        'kicker' => 'Crecer hacia arriba cuando el terreno no da más',
        'intro' => [
            'Construir un piso arriba es la ampliación más deseada en terrenos chicos y la que más verificación técnica exige. La pregunta no es si se puede, sino qué aguanta la estructura existente y qué hay que reforzar.',
            'Verificamos fundaciones, columnas y losa antes de proponer una solución. Después proyectamos la escalera, las instalaciones que suben y la forma de trabajar con la casa habitada.',
        ],
        'includes' => ['Verificación estructural de lo existente', 'Refuerzos de columnas o fundaciones si hacen falta', 'Losa nueva, escalera e instalaciones', 'Techo nuevo y aislación', 'Terminaciones y protección de la planta baja durante la obra'],
        'process' => [
            ['Visita y relevamiento', 'Recorremos la casa y anotamos fundaciones visibles, columnas, vigas, tipo de losa o techo y el estado general. También vemos por dónde puede subir una escalera y qué instalaciones hay que extender.'],
            ['Verificación de lo existente', 'Se revisa con quien corresponde si la estructura aguanta una planta más o qué refuerzos necesita. Sin esa verificación no se define nada.'],
            ['Alcance y presupuesto por rubro', 'Se separan refuerzos, losa, escalera, mampostería, instalaciones, techo y terminaciones. Así ves cuánto pesa cada parte y qué se puede ajustar.'],
            ['Refuerzos, losa y escalera', 'Se ejecutan los refuerzos, se construye la losa y se abre el hueco de la escalera. La planta baja se protege durante estas etapas.'],
            ['Mampostería, techo y entrega', 'Se levantan las paredes del nivel nuevo, se cubre, se hacen instalaciones y terminaciones, y se limpia todo antes de mudarte al piso nuevo.'],
        ],
        'materials' => [
            ['Estructura de hormigón armado', 'Columnas y vigas nuevas que apoyan sobre lo que ya existe, con refuerzo donde haga falta. Es la base del piso que sumás.'],
            ['Losa', 'Losa maciza, de viguetas o alivianada. Se elige según luces, cargas y facilidad de ejecución, y también según lo que la estructura de abajo puede soportar.'],
            ['Mampostería', 'Ladrillos comunes o bloques huecos. Los bloques alivianan el peso sobre la planta baja, lo que en una ampliación en altura es una ventaja real.'],
            ['Escalera', 'De hormigón, metálica o mixta. Se define por espacio disponible, comodidad y terminación.'],
        ],
        'sections' => [
            ['Verificar lo que hay antes de subir', ['En una casa ya construida no siempre se sabe cómo se hicieron las fundaciones o cuánta carga admiten las columnas. Por eso se hacen cateos, se miden secciones y se compara con lo que vas a sumar.', 'Si la estructura es suficiente, se sigue; si no, se refuerza o se propone otra solución, como una ampliación en planta baja. Conviene saberlo antes de empezar.']],
            ['Escalera, losa y vivir en la casa durante la obra', ['La escalera define el recorrido de la casa: dónde arranca, por dónde sube y cuánto espacio le quita a la planta baja. Se ubica pensando en el uso diario y en no cortar ambientes por la mitad.', 'La familia puede seguir viviendo abajo en la mayor parte del trabajo. Se cubre la losa y los muebles, se hace la demolición del hueco de escalera en una etapa acotada y se limpia a diario.']],
        ],
        'mistakes' => [
            ['Suponer que la casa aguanta', 'Sumar peso sin verificar puede causar fisuras o algo peor. Se verifica siempre.'],
            ['Improvisar la escalera', 'Una escalera mal ubicada complica toda la casa. Se define al inicio.'],
            ['Olvidar las instalaciones', 'Agua, desagüe y electricidad necesitan recorridos hacia arriba. Se prevén antes de hacer la losa.'],
            ['No proteger la planta baja', 'Polvo y agua de obra dañan muebles y pisos. Se cubre todo lo que queda en uso.'],
        ],
        'ideal' => ['Tu terreno es chico y necesitás más ambientes.', 'Querés un dormitorio en suite o un estudio arriba.', 'Preferís no perder el patio ni la cochera.'],
        'faqs' => [
            ['¿Cómo saben si mi casa aguanta un piso más?', 'Con un relevamiento de la estructura existente y, si hace falta, cateos en fundaciones. Con eso el ingeniero define refuerzos o confirma que se puede construir.'],
            ['¿Puedo seguir viviendo abajo?', 'En general sí. La planta baja se protege y se programa la obra para las etapas más invasivas.'],
            ['¿Necesito planos?', 'Sí. Una planta alta requiere proyecto y aprobación municipal. Lo incluimos en el alcance.'],
            ['¿Puedo sumar solo un dormitorio arriba o tiene que ser un piso entero?', 'Se puede sumar una parte, pero la estructura nueva debe apoyarse bien sobre lo de abajo. Lo definimos con la verificación estructural.'],
            ['¿Cómo se sube el material sin arruinar la casa?', 'Por el frente o por el patio con andamios, roldanas o grúas chicas, según el acceso, y se protegen las zonas de paso.'],
            ['¿Qué pasa con el techo actual?', 'Se retira o se reutiliza según el caso, con la casa cubierta por sectores para que no entre agua.'],
        ],
        'related' => ['/casas/duplex/', '/ampliaciones/dormitorio/', '/ampliaciones/', '/guias/permisos/'],
        'link' => ['site' => 'arq', 'path' => '/estructural/', 'text' => 'Antes de sumar un piso hace falta un cálculo estructural de lo existente; ese estudio lo hace arq.com.py y nosotros ejecutamos la ampliación.'],
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
        'process' => [
            ['Visita y medición', 'Vamos a la casa, medimos el lugar disponible y miramos cómo se conecta con lo existente: niveles, techos, patio, instalaciones y ventilación de los ambientes vecinos. También vemos por dónde va a entrar el material.'],
            ['Propuesta y alcance por rubro', 'Definimos medidas, ubicación de puertas y ventanas, y qué instalaciones se extienden. Se detallan fundaciones, mampostería, techo, baño y terminaciones por separado.'],
            ['Fundaciones y mampostería', 'Se replantea el sector, se excava y se hacen fundaciones y contrapiso. Después se levantan las paredes con su unión al muro existente.'],
            ['Techo, instalaciones y baño', 'Se empalma el techo nuevo al de la casa, se hacen las instalaciones eléctricas y sanitarias y se conecta el baño a los desagües existentes.'],
            ['Terminaciones y entrega', 'Revoques, pisos, aberturas y pintura, a tono con la casa. Se limpia y se revisa el conjunto antes de la entrega.'],
        ],
        'materials' => [
            ['Fundaciones y estructura', 'Zapatas o cimientos corridos con vigas de encadenado, según el suelo. Se coordinan con lo existente para evitar asentamientos diferenciales.'],
            ['Mampostería', 'Ladrillos o bloques, con revoque interior y exterior. Se busca que las juntas y la altura queden en línea con la casa.'],
            ['Techo', 'Teja, chapa o losa, según lo que ya tiene la casa. Lo importante es el empalme con el techo existente.'],
            ['Instalaciones del baño', 'Cañerías de agua y desagüe, ventilación y electricidad. Se prevé desde el inicio para no romper paredes después.'],
        ],
        'sections' => [
            ['Unión con la casa existente', ['La parte más delicada de una ampliación es donde lo nuevo se encuentra con lo viejo. Se dejan juntas o trabas de mampostería según el caso, para que las diferencias de asentamiento no abran una fisura en el encuentro.', 'También se revisa cómo se resuelve el nivel del piso, para que no quede un escalón donde no debería haberlo, y cómo se une el revoque para que la pared se vea continua.']],
            ['Instalaciones, techo y ventilación', ['El dormitorio nuevo tiene que tener luz natural y ventilación, y el baño necesita ventilación propia. Si se cierra una ventana de un ambiente existente, hay que reubicar ese aire y esa luz.', 'El techo se empalma con una babeta bien sellada y con la pendiente hacia una canaleta. Los desagües nuevos se conectan con la pendiente que corresponde, sin contrapendientes que tapen el conducto.']],
        ],
        'mistakes' => [
            ['Ampliar sin revisar los niveles', 'Un piso desnivelado con la casa crea escalones y problemas de accesibilidad. Se marca el nivel antes de excavar.'],
            ['Empalmar el techo a la ligera', 'Es la primera fuente de filtraciones. Se ejecuta con babetas y pendiente.'],
            ['Dejar los desagües para el final', 'Si no se prevén antes del contrapiso, hay que romper. Se ubican al inicio.'],
            ['Olvidar ventilación y luz', 'Un dormitorio sin ventana adecuada es incómodo. Se define en la propuesta.'],
        ],
        'ideal' => ['Necesitás un dormitorio más.', 'Va a vivir con ustedes un familiar mayor.', 'Querés una suite independiente con acceso propio.'],
        'faqs' => [
            ['¿Se puede conectar el baño nuevo a la instalación existente?', 'En general sí, respetando pendientes y ventilación. Lo verificamos en el relevamiento.'],
            ['¿Cuánto dura una ampliación de dormitorio?', 'Es una obra de pocas semanas comparada con una casa completa. El plazo se define con el alcance cerrado.'],
            ['¿Puedo hacerla independiente para alquilar?', 'Sí. Se proyecta con acceso propio, kitchenette y medidor separado si corresponde.'],
            ['¿Necesito permiso municipal?', 'Una ampliación suele requerir aprobación. Consultá con tu municipio los requisitos que aplican a tu terreno; te ayudamos a armar la información.'],
            ['¿Se puede hacer pegada a la medianera?', 'Depende de las normas del municipio y de la relación con el vecino. Se verifica antes de definir la ubicación.'],
            ['¿Puedo seguir usando la casa durante la obra?', 'Sí. Se separa el sector con una protección y se coordina el ingreso de materiales para molestar poco.'],
        ],
        'related' => ['/ampliaciones/', '/reformas/banos/', '/ampliaciones/galeria/', '/guias/permisos/'],
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
        'process' => [
            ['Visita y elección del lugar', 'Miramos el sol y las sombras a lo largo del día, la relación con la cocina y el living y el acceso al patio. El lugar de la galería se elige pensando en cómo se usa: para tereré, para comer, para la parrilla.'],
            ['Propuesta y alcance por rubro', 'Definimos medidas, cubierta, piso, iluminación y conexión con la casa, cada uno por rubro. Vos decidís qué entra ahora y qué se deja para más adelante.'],
            ['Fundaciones y columnas', 'Se hacen las bases de las columnas y el contrapiso. Se controlan las alineaciones y los niveles con respecto a la casa y al patio.'],
            ['Techo y estructura', 'Se arma la estructura del techo y se coloca la cubierta con canaletas y bajadas. La unión con la casa se sella con cuidado.'],
            ['Piso, instalaciones y entrega', 'Piso, iluminación, tomas y ventiladores, y remates. Se limpia y se deja lista para usar.'],
        ],
        'materials' => [
            ['Cubierta', 'Teja, chapa o losa. La teja mantiene la continuidad con la casa; la chapa aislada es más liviana y rápida; la losa da un aspecto más moderno y pide más estructura.'],
            ['Columnas', 'Hormigón, mampostería o metal. Definen el aspecto de la galería, y la sección se elige según la luz que cubren.'],
            ['Piso', 'Porcelanato antideslizante, cerámica, cemento alisado o deck de madera. Elegimos algo que no se caliente demasiado al sol y que resista el agua.'],
            ['Techos de madera y machimbre', 'Vigas de madera y cielorraso de machimbre. Los trabajamos como parte de la obra, con tratamiento y ventilación para que duren.'],
        ],
        'sections' => [
            ['Cómo se une el techo de la galería con la casa', ['La unión con el techo de la casa es lo que más se descuida. Puede apoyar sobre una viga contra la pared, con una babeta que evite que el agua se meta entre ambos, y con pendiente hacia afuera.', 'Si se ignora este detalle, las lluvias fuertes hacen entrar agua por el encuentro. Se resuelve una vez y bien, con material de sellado y remates.']],
            ['Orientación, sol y cerramiento futuro', ['En Paraguay el sol de la tarde es el que más pega. Una galería orientada al oeste sin protección se vuelve inutilizable en verano; se puede corregir con aleros más largos, pérgola, plantas o cerramientos.', 'Si más adelante querés cerrarla con vidrio o con paredes, hay que prever desde el inicio las alturas, las columnas y las fundaciones. Es una ampliación por etapas que se decide al principio.']],
        ],
        'mistakes' => [
            ['Techo demasiado bajo', 'Una galería baja acumula calor y da sensación de encierro. Se define la altura con la casa como referencia.'],
            ['Pendiente insuficiente', 'El agua se acumula. Se traza la pendiente en el diseño.'],
            ['Piso resbaladizo', 'Con agua el piso puede ser peligroso. Se elige un acabado antideslizante.'],
            ['No prever tomas y luz', 'Agregarlas después obliga a romper. Se dejan las cañerías desde el inicio.'],
        ],
        'ideal' => ['Tu casa no tiene un espacio exterior cubierto.', 'Querés conectar el living con el patio.', 'Buscás un lugar para la parrilla sin construir un quincho completo.'],
        'faqs' => [
            ['¿Necesita fundaciones?', 'Sí, para las columnas y el contrapiso. Son menores que las de un ambiente cerrado, pero necesarias.'],
            ['¿Se puede cerrar después?', 'Sí, si se prevé desde el inicio. Una galería bien pensada se convierte en quincho cerrado más adelante.'],
            ['¿Qué techo conviene?', 'Depende del techo de la casa y del presupuesto. Teja para continuidad estética, chapa aislada por economía, losa para diseño moderno.'],
            ['¿Se necesita permiso para una galería?', 'Depende del municipio y de si suma superficie cubierta. Consultá con tu municipio; nosotros te orientamos con la información.'],
            ['¿Puedo agregar una parrilla?', 'Sí. Se prevé el lugar, la chimenea y la ventilación desde el inicio.'],
            ['¿Se puede hacer con deck?', 'Sí, el deck es parte de nuestro trabajo. Se levanta del suelo y se protege la madera.'],
        ],
        'related' => ['/patios/pergolas/', '/quinchos/', '/ampliaciones/', '/guias/permisos/'],
    ],
];
