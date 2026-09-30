<?php
declare(strict_types=1);

// Especialidades de este hub: /{hub}/{slug}/. Una intencion de busqueda distinta a la del hub.
// 'related' son rutas completas. Sin precios, sin plazos fijos, sin datos inventados.
return [
    'direccion' => [
        'name' => 'Dirección técnica de obra',
        'title' => 'Dirección técnica de obra en Paraguay | Obra',
        'description' => 'Dirección técnica de obra en Asunción y Gran Asunción: ingeniero a cargo de la ejecución, certificaciones y responsabilidad ante el municipio y el banco.',
        'summary' => 'Dirección técnica y profesional responsable de obra en Asunción y Gran Asunción: ingeniero a cargo de la ejecución, certificaciones y responsabilidad ante el municipio y el banco.',
        'h1' => 'Dirección técnica de obra',
        'kicker' => 'Un profesional responsable de tu obra',
        'intro' => [
            'La dirección técnica es más que supervisar: el profesional toma las decisiones de ejecución, firma como responsable ante el municipio y certifica avances para el banco. Es lo que exigen muchos permisos y la mayoría de los créditos de construcción.',
            'Ofrecemos dirección técnica para obras que ejecuta otro constructor o un maestro de obra, con visitas programadas, informes y certificaciones.',
        ],
        'includes' => ['Profesional responsable ante el municipio', 'Decisiones técnicas de ejecución en obra', 'Certificaciones de avance para desembolsos', 'Informes con fotos y observaciones', 'Recepción final y documentación'],
        'process' => [
            ['Revisión del proyecto y del contrato', 'Antes de la primera visita leemos los planos, el presupuesto por rubro y el contrato con quien ejecuta. Buscamos incoherencias entre documentos, rubros sin definir y puntos que van a necesitar una decisión técnica.'],
            ['Acta de inicio y plan de visitas', 'Se deja escrito quién es el responsable de cada tarea, cómo se comunican los cambios y cada cuánto se visita la obra. Las visitas se concentran en los momentos donde un error es caro de corregir: fundaciones, armaduras, instalaciones antes de tapar.'],
            ['Visitas, decisiones y libro de obra', 'En cada visita se controla lo ejecutado contra lo proyectado y se resuelven consultas del maestro o del constructor. Lo decidido queda anotado en el libro de obra, con fecha, para que no dependa de la memoria de nadie.'],
            ['Certificación de avances', 'Con lo verificado en obra se prepara la certificación de cada etapa: qué está terminado, qué está a medias y qué corresponde pagar. Es el documento que también suele pedir el banco cuando hay crédito.'],
            ['Recepción y documentación final', 'Al terminar se recorre la obra con una lista de observaciones, se verifica que se corrijan y se entrega la documentación que quedó de la obra, para que la propiedad pueda regularizarse o usarse como garantía.'],
        ],
        'materials' => [
            ['Dirección sobre obra de otro constructor', 'Trabajamos con tu maestro o tu constructora. No cambia el equipo: suma a un profesional que decide, controla y firma como responsable.'],
            ['Dirección en obra que ejecutamos nosotros', 'La dirección forma parte del alcance y se coordina con los gremios desde el inicio, con el mismo cronograma y el mismo presupuesto por rubro.'],
            ['Dirección por etapas', 'Cuando la obra empezó con fondos propios y se completa con crédito, podés contratar la dirección solo desde cierto punto, previo relevamiento de lo ya hecho.'],
            ['Certificación puntual', 'Si solo necesitás informes o certificaciones para un desembolso, se puede acordar esa parte sin una dirección completa. Lo que corresponda lo define el municipio o el banco.'],
        ],
        'sections' => [
            ['Qué es la dirección de obra y qué responsabilidades tiene', ['La dirección de obra es la conducción técnica de la construcción: asegurarse de que lo que se levanta coincide con el proyecto, con las normas de buena práctica y con lo que se contrató. Quien dirige toma decisiones cuando aparece algo que el plano no previó y responde por ellas.', 'No es lo mismo que estar todos los días con la cuchara en la mano. El director define, controla y firma; la ejecución diaria la hace el constructor o el maestro. Esa separación es justamente lo que da tranquilidad: quien construye no es quien se controla a sí mismo.']],
            ['Libro de obra, informes y certificaciones', ['El libro de obra es el registro cronológico de la construcción: visitas, órdenes, consultas, cambios y observaciones. Cuando hay una discusión sobre quién dijo qué, o cuándo se hizo algo, ahí está la respuesta.', 'Los informes con fotos y las certificaciones de avance complementan el libro. Sirven para que vos entiendas cómo va la obra sin estar presente, y para que el banco, si hay crédito, libere cada etapa con respaldo. Consultá con tu banco y tu municipio qué formato piden.']],
        ],
        'mistakes' => [
            ['Contratar la dirección cuando la obra ya está tapada', 'Lo que quedó enterrado o detrás del revoque ya no se puede ver. Conviene sumar al director antes de fundaciones o, si ya empezó, pedir un relevamiento de lo ejecutado.'],
            ['Confundir dirección con presencia diaria', 'Una visita bien programada en los puntos críticos rinde más que una presencia constante sin criterio. Se define el ritmo de visitas según la obra.'],
            ['Dejar los cambios de palabra', 'Un cambio sin registro genera discusiones sobre costo y responsabilidad. Se anota en el libro de obra y se acuerda por escrito.'],
            ['No pedir la documentación final', 'Sin planos conforme a obra y actas, después cuesta regularizar, vender o hipotecar. La recepción incluye ese paquete.'],
        ],
        'ideal' => ['El municipio o el banco te piden un profesional responsable.', 'Contrataste un maestro de obra y querés dirección técnica.', 'Necesitás certificaciones para los desembolsos del crédito.'],
        'faqs' => [
            ['¿Qué diferencia hay con la supervisión?', 'La supervisión controla; la dirección técnica decide y asume la responsabilidad profesional. Muchas veces hace falta la segunda por exigencia legal o bancaria.'],
            ['¿Pueden dirigir una obra con planos de otro arquitecto?', 'Sí. Revisamos el proyecto y dirigimos su ejecución.'],
            ['¿Qué pasa si la obra ya empezó sin dirección?', 'Hacemos un relevamiento del estado y asumimos la dirección desde ese punto, documentando lo previo.'],
            ['¿Cada cuánto visitan la obra?', 'Se acuerda según el tamaño y el momento de la obra. Las visitas se concentran en las etapas críticas, y entre una y otra la comunicación sigue con el constructor por los canales acordados.'],
            ['¿Qué es el libro de obra?', 'Es el registro fechado de visitas, decisiones, cambios y observaciones. Consultá en tu municipio si exige un formato particular para tu tipo de obra.'],
            ['¿Puedo contratar la dirección solo para las certificaciones del banco?', 'Se puede acordar una intervención acotada. Antes conviene preguntarle al banco qué profesional y qué documentos acepta para certificar avances.'],
        ],
        'related' => ['/supervision/', '/presupuesto/', '/credito/', '/guias/permisos/'],
    ],
];
