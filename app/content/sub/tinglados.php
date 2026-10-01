<?php
declare(strict_types=1);

// Especialidades de este hub: /{hub}/{slug}/. Una intencion de busqueda distinta a la del hub.
// 'related' son rutas completas. Sin precios, sin plazos fijos, sin datos inventados.
return [
    'galpones' => [
        'name' => 'Galpones y depósitos',
        'title' => 'Construcción de galpones y depósitos en Paraguay | Obra',
        'description' => 'Construcción de galpones industriales y depósitos en Gran Asunción: estructura metálica de gran luz, piso para carga, portones y oficinas anexas.',
        'h1' => 'Construcción de galpones y depósitos',
        'kicker' => 'Área cubierta para operar',
        'intro' => [
            'Un galpón se proyecta por lo que va a pasar adentro: qué se guarda, qué vehículos entran, cuánta altura hace falta y cuánta carga soporta el piso. Con eso se define la luz de la estructura, el piso y los accesos.',
            'Construimos galpones y depósitos para comercios, logística y producción liviana, con oficinas, baños y áreas de carga integradas.',
            'Antes de hablar de metros cuadrados conviene hablar de operación: por dónde entra la mercadería, dónde maniobra un camión, cuántas personas trabajan adentro y qué necesita cada una. Un galpón que se piensa desde la operación cuesta menos de corregir después.',
        ],
        'includes' => ['Fundaciones y piso de hormigón para carga', 'Estructura metálica de gran luz', 'Cubierta y cerramientos laterales', 'Portones, muelles y accesos', 'Oficinas, baños e instalaciones', 'Canaletas, bajadas y drenaje del predio', 'Iluminación natural y ventilación'],
        'process' => [
            ['Reunión sobre la operación', 'Empezamos por entender el uso: mercadería, maquinaria, turnos de trabajo, tipo de vehículos y cómo circulan. Con esos datos se fija la altura útil, la luz libre entre columnas y la ubicación de los accesos.'],
            ['Visita y estudio del terreno', 'Vamos al predio, miramos el nivel del suelo, hacia dónde escurre el agua, el ancho de la calle de acceso y el radio de giro que necesita un camión. En terrenos bajos o arcillosos esto define cuánto relleno y qué fundación hacen falta.'],
            ['Presupuesto por rubro', 'Movimiento de suelo, fundaciones, piso, estructura metálica, cubierta, cerramientos, portones, instalaciones y oficinas, cada uno por separado. Así podés decidir qué se hace ahora y qué queda para una segunda etapa.'],
            ['Fundaciones, piso y estructura', 'Se ejecutan las bases de las columnas, se prepara la sub-base y se hormigona el piso con su armadura y sus juntas. Después se monta la estructura metálica, se coloca la cubierta y se cierran los laterales.'],
            ['Instalaciones, terminaciones y entrega', 'Electricidad de fuerza e iluminación, agua, desagües, baños, oficina y portones. Recorremos el galpón con vos, probamos los accesos y te dejamos claro cómo se mantienen canaletas y cubierta.'],
        ],
        'materials' => [
            ['Estructura metálica de gran luz', 'Perfiles armados o reticulados que cubren grandes espacios con pocas columnas, lo que deja libre el sector de maniobra y de estanterías. La luz se define según lo que se almacena y cómo se circula.'],
            ['Cubierta de chapa o panel aislado', 'La chapa simple es liviana y directa; el panel con aislación baja el calor de adentro, cosa que se agradece en verano y en talleres donde se trabaja todo el día. La pendiente y las canaletas se dimensionan para lluvias fuertes.'],
            ['Piso industrial de hormigón', 'Se elige el espesor, la armadura y el acabado según lo que lo va a recorrer: pallets, montacargas, camiones o solo estanterías. Puede terminarse alisado, con endurecedor superficial o con juntas selladas.'],
            ['Portones y muelles de carga', 'Portones corredizos o de enrollar según el ancho de entrada, y muelle a la altura de la caja del camión cuando el trabajo es de carga y descarga frecuente.'],
        ],
        'sections' => [
            ['Depósito, taller o producción: qué cambia en cada caso', ['Un depósito de mercadería pide altura para estanterías, piso plano y accesos amplios. Un taller suma energía trifásica, ventilación, a veces fosa o puente grúa liviano y piso resistente a golpes y aceites. Un local de producción liviana necesita además sectores separados, vestuarios y oficina técnica.', 'Por eso no existe un galpón estándar: la misma superficie se resuelve distinto según la actividad. Con lo que nos contás armamos una propuesta que respete la operación real y deje previsto lo que podrías necesitar más adelante.']],
            ['Accesos para camiones, luces y canaletas', ['El acceso es lo que más se subestima. Hay que ver el ancho y el estado de la calle, el radio de giro, la altura libre en la entrada y dónde espera un vehículo mientras otro carga. Un portón bien ubicado evita maniobras dentro de la calle y accidentes en el predio.', 'Con la luz de la estructura pasa algo parecido: más luz libre significa menos columnas, pero perfiles más grandes. Y las canaletas y bajadas se calculan según la superficie de cubierta, porque una techumbre grande junta muchísima agua en una tormenta y tiene que salir sin inundar el piso ni el vecino.']],
        ],
        'mistakes' => [
            ['Definir el piso por el precio y no por la carga', 'Un piso fino que después soporta un montacargas se fisura y se hunde. Se calcula para la carga real y se dejan juntas bien ubicadas.'],
            ['Olvidar el drenaje del predio', 'Un galpón grande impermeabiliza mucho suelo. Sin un plan para el agua de lluvia, el fondo se encharca y el piso sufre. Se resuelve con pendientes, canaletas y desagües desde el inicio.'],
            ['Acceso justo para el camión', 'Si el portón o el giro son ajustados, cada carga se vuelve una maniobra. Se mide con el vehículo más grande que vaya a entrar, no con el promedio.'],
        ],
        'ideal' => ['Tu negocio necesita depósito propio.', 'Alquilás un galpón y querés construir el tuyo.', 'Necesitás un espacio de producción o taller.'],
        'faqs' => [
            ['¿Qué altura conviene?', 'Depende de lo que se almacena y de las maquinarias. Se define con vos antes de proyectar la estructura.'],
            ['¿El piso aguanta montacargas?', 'Se calcula para la carga real: espesor, armadura y juntas. Es uno de los puntos más importantes del galpón.'],
            ['¿Trabajan con fecha de operación?', 'Sí. La fecha objetivo entra en la planificación y las etapas se ordenan para cumplirla.'],
            ['¿Se puede hacer un galpón por etapas?', 'Sí. Se puede empezar con la estructura y el piso y dejar oficinas o cerramientos para después, siempre que la primera etapa ya quede pensada para recibir lo que sigue.'],
            ['¿Hacen las oficinas y baños dentro del mismo galpón?', 'Sí. Se construyen dentro o pegadas al galpón, con sus instalaciones, y se resuelven en la misma obra para que no haya que abrir el piso después.'],
            ['¿Qué necesito para empezar a hablar de un galpón?', 'Alcanza con contarnos qué vas a guardar o producir, qué vehículos entran y qué terreno tenés. Con eso ya se puede armar un alcance y una visita.'],
        ],
        'related' => ['/tinglados/', '/comerciales/', '/tinglados/cocheras/', '/guias/permisos/'],
    ],
    'cocheras' => [
        'name' => 'Cocheras y techos para autos',
        'title' => 'Construcción de cocheras y techos para autos en Paraguay | Obra',
        'description' => 'Cocheras cubiertas y techos para autos en Asunción y Gran Asunción: estructura metálica o de hormigón, cubierta aislada, piso y portón al frente.',
        'summary' => 'Cocheras cubiertas y techos para autos en Asunción y Gran Asunción: estructura metálica o de hormigón, cubierta aislada, piso y portón integrados al frente de la casa.',
        'h1' => 'Cocheras y techos para autos',
        'kicker' => 'El auto a la sombra, el frente mejor',
        'intro' => [
            'El sol paraguayo castiga los autos y las cocheras improvisadas afean el frente. Una cochera bien hecha protege el vehículo y mejora la fachada: se proyecta con el portón, el muro y el acceso como un conjunto.',
            'Construimos cocheras con estructura metálica o de hormigón, cubierta de chapa aislada, teja o losa, piso de hormigón o adoquines y portón integrado.',
            'Si lo que buscás es un techo para autos sencillo, también se resuelve: una estructura liviana, bien anclada y con desagüe pensado, que cubre del sol y de la tormenta sin complicar el resto de la casa.',
        ],
        'includes' => ['Estructura metálica, de hormigón o mixta', 'Cubierta aislada con canaletas', 'Piso de hormigón o adoquines para vehículos', 'Portón manual o automatizado', 'Iluminación y previsión de cargador eléctrico', 'Desagüe pluvial hacia la calle o el jardín'],
        'process' => [
            ['Visita y medidas reales', 'Medimos el frente, el ancho del acceso, el nivel de la vereda y el largo disponible. También vemos cuántos autos entran y cuánto espacio necesita cada puerta para abrirse sin chocar con una columna.'],
            ['Elección del sistema', 'Se define si la estructura es metálica, de hormigón o mixta, y si la cubierta va inclinada, plana o con losa. Esto depende del estilo de la casa, de cuánto voladizo se quiere y de si arriba se va a usar el espacio.'],
            ['Presupuesto por rubro', 'Fundaciones, estructura, cubierta, desagües, piso, portón e iluminación, cada uno por separado. Así ves qué cambia entre una opción sencilla y una más terminada.'],
            ['Fundaciones y estructura', 'Se excavan las bases, se hormigonan y se montan columnas y vigas, con las anclas bien resueltas. Si el techo se apoya en una pared existente, se verifica antes que aguante la carga.'],
            ['Cubierta, piso y terminaciones', 'Se coloca la cubierta con su pendiente y sus canaletas, se hace el piso, se pinta o protege la estructura y se conecta la iluminación. Te mostramos cómo funciona el desagüe con agua real.'],
        ],
        'materials' => [
            ['Estructura metálica', 'Es la opción más rápida de ejecutar y admite grandes luces con columnas finas. Necesita protección anticorrosiva y buena pintura, sobre todo con la humedad del clima local.'],
            ['Estructura de hormigón', 'Más maciza y durable, se integra bien con casas de mampostería y admite losa arriba. Requiere encofrado y más trabajo de obra, pero prácticamente no pide mantenimiento.'],
            ['Cubierta de chapa aislada, teja o losa', 'La chapa con aislación es liviana y rinde bien contra el calor; la teja acompaña una casa de estilo tradicional; la losa suma una terraza o un espacio utilizable arriba.'],
            ['Piso para vehículos', 'Hormigón alisado o con textura, o adoquines. El hormigón es continuo y fácil de lavar; el adoquín deja pasar algo de agua y se repara por sectores. En ambos casos se cuida la pendiente hacia el desagüe.'],
        ],
        'sections' => [
            ['Techo metálico o de hormigón: cómo elegir', ['El techo metálico rinde cuando querés cubrir rápido, con un aspecto liviano y moderno, o cuando la cochera es una ampliación posterior a la casa. El de hormigón conviene si querés algo permanente, que combine con la fachada y que pueda servir de base para una terraza.', 'En ambos casos importa el largo del voladizo y el peso de la cubierta. Un techo muy liviano se levanta con el viento fuerte, y uno muy pesado exige fundaciones mayores. Lo resolvemos con cálculo y no a ojo.']],
            ['Cubiertas, desagües y piso', ['Una cochera cubierta junta bastante agua. Las canaletas y bajadas se ubican para que el agua no caiga sobre la entrada ni corra hacia la casa del vecino, y el piso lleva pendiente para que no quede charco frente al portón.', 'Otro detalle es la altura libre: el techo tiene que dejar pasar cómodamente una camioneta o un vehículo con portaequipajes, y el acceso tiene que permitir entrar sin raspar la rampa de la vereda.']],
        ],
        'mistakes' => [
            ['Hacer la cochera justa', 'Si las puertas del auto no abren del todo, se usa poco. Se mide con el vehículo real y se deja espacio para abrir y circular.'],
            ['Ignorar la pendiente del piso', 'Sin pendiente el agua se queda o entra a la casa. Se prevé el escurrimiento desde el plano de obra.'],
            ['Cubierta demasiado liviana en zona ventosa', 'Una chapa mal fijada se levanta con la primera tormenta. Se calculan los anclajes y la estructura para el viento.'],
            ['Separar cochera y portón', 'Cuando cada uno se hace por su lado, el acceso queda desalineado con la vereda. Se proyectan juntos, con la instalación eléctrica lista para automatizar.'],
        ],
        'ideal' => ['Tu auto queda al sol o a la lluvia.', 'Querés renovar el frente junto con la cochera.', 'Necesitás cochera para dos o más vehículos.'],
        'faqs' => [
            ['¿Chapa, teja o losa?', 'Chapa aislada es la más económica, teja continúa el estilo de la casa, losa permite usar el espacio arriba. Depende del proyecto.'],
            ['¿Pueden automatizar el portón?', 'Sí. Dejamos la instalación eléctrica y coordinamos el equipo de automatización.'],
            ['¿Se puede hacer una cochera sin columnas al frente?', 'Sí, con una estructura en voladizo calculada. Es más costosa pero deja el acceso libre.'],
            ['¿Sirve un techo de chapa para proteger del calor?', 'Con aislación y una buena altura, sí, y baja bastante la temperatura debajo. La chapa simple protege del sol directo pero calienta más.'],
            ['¿Puedo hacer la cochera pegada a la pared de mi casa?', 'Se puede, verificando que la pared aguante y cuidando la unión de la cubierta para que no filtre. A veces conviene que la cochera tenga estructura propia.'],
            ['¿Dejan preparado el cargador para auto eléctrico?', 'Sí, dejamos la canalización y el tablero previstos para que el equipo se instale cuando lo necesites.'],
        ],
        'related' => ['/techos/chapa/', '/muros/portones/', '/reformas/fachadas/', '/tinglados/', '/guias/costo-casa/'],
    ],
];
