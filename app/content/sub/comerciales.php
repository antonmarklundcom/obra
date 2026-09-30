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
            'Cada rubro tiene su lógica: una cafetería necesita cocina, extracción y desagües especiales; una tienda, buena iluminación y vidriera; un local de servicios, atención cómoda y baño accesible. Empezamos por ahí.',
        ],
        'includes' => ['Relevamiento del local y del contrato de alquiler', 'Demoliciones, divisiones y obra civil', 'Instalaciones eléctricas, sanitarias, datos y climatización', 'Vidriera, fachada y cartelería (obra civil)', 'Pisos, cielorrasos e iluminación', 'Puntos de caja, mostradores y tableros de servicio'],
        'process' => [
            ['Relevamiento del local', 'Vamos al local, revisamos el estado de pisos, paredes, techo e instalaciones, y leemos con vos lo que dice el contrato de alquiler sobre qué obras están permitidas. Ahí aparecen las restricciones que condicionan el proyecto.'],
            ['Definición del alcance', 'Con lo que necesita tu rubro, se arma una lista de trabajos: qué se demuele, qué se divide, qué instalaciones hay que rehacer. También se marca lo que puede esperar para una segunda etapa.'],
            ['Presupuesto por rubro', 'Demolición, mampostería, instalaciones, pisos, cielorrasos, vidriera, baños y terminaciones, cada uno por separado. Sabés en qué se va cada parte y qué podés ajustar sin comprometer la apertura.'],
            ['Obra y coordinación', 'Se ordenan los trabajos para que las instalaciones se hagan antes de cerrar paredes y cielorrasos, y para que quien fabrica el mostrador o los muebles trabaje en paralelo. Se acuerdan horarios de obra con el edificio y los vecinos.'],
            ['Prueba y entrega', 'Se prueban electricidad, agua, desagües, extracción y climatización, se limpia la obra y se recorre el local con vos punto por punto, antes de que llegue la mercadería.'],
        ],
        'materials' => [
            ['Pisos comerciales', 'Porcelanato, cerámica antideslizante, cemento alisado o microcemento. Se elige según tránsito, limpieza diaria y aspecto. En cocinas y baños, siempre con pendiente y antideslizante.'],
            ['Cielorrasos', 'Placa de yeso, PVC o paneles desmontables. El cielorraso oculta cañerías y luces, pero tiene que dejar acceso para mantenimiento. Se define junto con la iluminación.'],
            ['Vidriera y frente', 'Vidrio templado con marco, o paños fijos con puerta de acceso. La vidriera es la presentación del negocio, así que se decide con calma la altura, la visibilidad y la seguridad.'],
            ['Instalaciones del rubro', 'Eléctrica con tablero acorde a los equipos, sanitaria con las bocas necesarias, datos y climatización. En gastronomía, extracción y grasa; en salud, lavamanos y ventilación.'],
        ],
        'sections' => [
            ['Habilitación: qué conviene preguntar antes de obrar', ['Muchos rubros necesitan habilitación municipal para abrir, y las exigencias cambian según la actividad, la zona y el tamaño del local. Consultá con tu municipio qué documentos y qué condiciones físicas piden para tu rubro, y hacelo antes de cerrar el alcance de la obra.', 'Nosotros relevamos lo que corresponde a la parte constructiva, como salidas, baños, ventilación, y lo incorporamos al proyecto para que la obra no tenga que rehacerse cuando llega la inspección.']],
            ['Vidriera, baños y horarios de obra', ['La vidriera y el frente son lo primero que ve el cliente, y lo primero que hay que cuidar durante la obra. Muchas veces se protege con un cierre provisorio y se termina al final, con el cartel y la iluminación.', 'Los baños suelen ser el punto crítico: hay que ver dónde está la salida de desagüe existente, si el local tiene baño para el público y cómo es el acceso para personas con movilidad reducida. Y el horario de trabajo se acuerda con el edificio o el centro comercial, porque el ruido y la entrada de materiales tienen reglas propias.']],
        ],
        'mistakes' => [
            ['Firmar el alquiler sin revisar el estado', 'Instalaciones viejas o un techo con filtración cambian el alcance de la obra. Conviene relevar el local antes de comprometerte.'],
            ['Cerrar el diseño sin consultar la habilitación', 'Si después piden otra salida o un baño adicional, hay que romper lo hecho. Se consulta al municipio antes.'],
            ['Dejar las instalaciones para el final', 'Abrir cielorrasos y pisos ya terminados es rehacer trabajo. Las instalaciones van primero.'],
            ['Subestimar la iluminación', 'Un local con luz mal ubicada se ve apagado aunque el resto sea bueno. Se define junto con el cielorraso y las vitrinas.'],
        ],
        'ideal' => ['Firmaste el alquiler y tenés fecha de apertura.', 'El local necesita baños o cocina que no tiene.', 'Querés un solo responsable para no coordinar diez proveedores.'],
        'faqs' => [
            ['¿Pueden cumplir una fecha de apertura?', 'Sí, cuando el alcance se cierra a tiempo y las decisiones se toman en fecha. La planificación se hace hacia atrás desde la apertura.'],
            ['¿Trabajan de noche o fines de semana?', 'Se acuerda según el edificio, los vecinos y la seguridad. No lo damos por hecho.'],
            ['¿Hacen locales gastronómicos?', 'Sí. Coordinamos extracción, gas, desagües con interceptor de grasa y las instalaciones que exige el rubro.'],
            ['¿Se puede obrar en un local dentro de un centro comercial?', 'Sí, pero se sigue el reglamento del centro: horarios, accesos, protección de pasillos y retiro de escombros. Lo consultamos antes de empezar.'],
            ['¿Qué pasa si el local necesita más potencia eléctrica?', 'Se calcula la carga real de los equipos y se coordina con la empresa distribuidora. Es un tema que conviene resolver al principio.'],
            ['¿Pueden fabricar el mostrador y los muebles?', 'Los coordinamos con carpinteros que conocemos, o trabajamos con lo que vos ya tengas contratado, para que todo esté listo cuando termina la obra.'],
        ],
        'related' => ['/comerciales/oficinas/', '/comerciales/', '/tinglados/galpones/', '/guias/permisos/'],
    ],
    'oficinas' => [
        'name' => 'Oficinas y consultorios',
        'title' => 'Remodelación de oficinas y consultorios en Paraguay | Obra',
        'description' => 'Remodelación de oficinas y consultorios en Asunción: divisiones, cableado de datos, climatización, baños y terminaciones con mínima interrupción.',
        'summary' => 'Remodelación y adecuación de oficinas y consultorios en Asunción: divisiones, cableado de datos, climatización, baños y terminaciones con mínima interrupción de la actividad.',
        'h1' => 'Remodelación de oficinas y consultorios',
        'kicker' => 'Un lugar listo para trabajar y atender',
        'intro' => [
            'Oficinas y consultorios tienen exigencias propias: privacidad acústica, cableado de datos, climatización por ambiente, baños accesibles y, en salud, requisitos de habilitación.',
            'Remodelamos y adecuamos oficinas y consultorios, muchas veces con la actividad en marcha, organizando la obra por sectores y horarios.',
            'Una oficina productiva es la que se recorre bien, tiene buena luz y no deja pasar el ruido de la sala de al lado. Un consultorio agrega privacidad al paciente, higiene fácil y una recepción que ordene la espera.',
        ],
        'includes' => ['Divisiones con aislación acústica', 'Cableado eléctrico y de datos', 'Climatización por ambiente', 'Baños y sala de espera', 'Pisos, cielorrasos e iluminación de trabajo', 'Recepción y puestos de atención', 'Piso y revestimientos lavables en zonas de atención'],
        'process' => [
            ['Conversación sobre cómo trabajás', 'Empezamos por entender quién usa el espacio: cuántas personas, qué reuniones, qué equipos y qué pacientes o clientes reciben. Con eso se define cuántos ambientes se necesitan y cómo se conectan.'],
            ['Visita y relevamiento', 'Recorremos el lugar, medimos, revisamos el estado del tablero eléctrico, las cañerías y el cielorraso, y vemos qué paredes pueden moverse y cuáles son estructurales.'],
            ['Presupuesto por rubro', 'Divisiones, cielorrasos, electricidad y datos, climatización, baños, pisos y pintura, cada rubro por separado. Podés elegir hacerlo por sectores y ver cuánto se puede resolver primero.'],
            ['Obra por sectores', 'Si hay actividad, se trabaja por partes: un sector se cierra, se termina y se entrega antes de pasar al siguiente. El polvo y el ruido se contienen con cierres provisorios, y los cortes de luz o agua se avisan.'],
            ['Entrega y puesta en marcha', 'Se prueban cableado, tomas, aire acondicionado, luces y puertas. Se limpia y se recorre todo con vos antes de que vuelvan los escritorios y los equipos.'],
        ],
        'materials' => [
            ['Divisiones livianas con aislación', 'Placas de yeso con lana mineral o doble placa, para dividir sin obra pesada y con buena atenuación del ruido. Se rematan hasta la losa cuando la privacidad importa, como en un consultorio.'],
            ['Cableado estructurado', 'Canalización para datos, teléfono y electricidad, con puntos en cada puesto y espacio para sumar más. Se deja un rack o tablero accesible y ordenado.'],
            ['Climatización por ambiente', 'Split individuales o un sistema central, según la cantidad de ambientes y el uso. Se ubican las unidades para que no soplen sobre los puestos ni hagan ruido en la consulta.'],
            ['Pisos y revestimientos', 'Vinílico, porcelanato o piso flotante. En consultorios se prefiere una superficie continua y fácil de limpiar, con zócalo sanitario en las uniones.'],
        ],
        'sections' => [
            ['Consultorios: privacidad, higiene y accesos', ['Un consultorio se organiza en torno al paciente: una recepción con espacio de espera, una sala de atención con privacidad acústica y visual, un baño accesible y una zona para lavarse las manos. Los materiales se eligen para que se limpien fácil y no acumulen humedad.', 'Los requisitos de habilitación dependen de la especialidad y de cada institución, así que consultá con tu municipio y con el organismo que corresponda a tu rubro. Nosotros llevamos esas condiciones a la obra.']],
            ['Obra con la oficina abierta', ['Remodelar sin cerrar es posible con planificación. Se divide la oficina en zonas, se ejecuta una a la vez, y los trabajos más ruidosos se hacen fuera del horario de atención, temprano o al cierre, según lo que acordemos con vos.', 'El objetivo es que tu equipo y tus clientes sigan usando el espacio con las menores molestias posibles. Cada semana se conversa qué zona sigue y qué se necesita mover.']],
        ],
        'mistakes' => [
            ['No prever el cableado para crecer', 'Un puesto más suele significar abrir paredes. Se deja canalización con margen desde el inicio.'],
            ['Divisiones que no llegan a la losa', 'El ruido pasa por arriba y la privacidad se pierde. Se rematan hasta arriba donde importa.'],
            ['Elegir el aire acondicionado sin ver la distribución', 'Una unidad mal ubicada enfría un lugar y deja otro caliente. Se planifica junto con las divisiones.'],
            ['Dejar el baño y la recepción para el final', 'Son lo primero que percibe el visitante. Se definen desde el proyecto, no como sobrante.'],
        ],
        'ideal' => ['Alquilaste una oficina y hay que dividirla.', 'Vas a abrir un consultorio y necesitás cumplir requisitos.', 'Querés remodelar sin cerrar la oficina.'],
        'faqs' => [
            ['¿Pueden trabajar con la oficina funcionando?', 'Sí, por sectores y fuera del horario más crítico. Lo planificamos con vos.'],
            ['¿Conocen los requisitos para consultorios?', 'Relevamos los requisitos del rubro y de la habilitación local y los incorporamos al proyecto.'],
            ['¿Incluyen el mobiliario?', 'Podemos coordinarlo con nuestra carpintería. La propuesta aclara qué provee Obra y qué contratás vos.'],
            ['¿Puedo remodelar una oficina alquilada?', 'Depende del contrato y del propietario. Se revisa qué obras están permitidas y se acuerda antes de empezar.'],
            ['¿Se puede dejar preparado el cableado para más puestos?', 'Sí. Se canaliza con espacio extra y se dejan cajas de paso para sumar puntos sin romper.'],
            ['¿Hacen consultorios odontológicos o de imágenes?', 'Se adecuan las instalaciones que necesita el equipo: agua, desagüe, electricidad y, si corresponde, blindaje o ventilación especial. Se consulta con el fabricante del equipo.'],
        ],
        'related' => ['/comerciales/locales/', '/comerciales/', '/reformas/', '/guias/plazos/'],
    ],
];
