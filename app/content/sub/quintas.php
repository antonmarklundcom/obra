<?php
declare(strict_types=1);

// Especialidades de este hub: /{hub}/{slug}/. Una intencion de busqueda distinta a la del hub.
// 'related' son rutas completas. Sin precios, sin plazos fijos, sin datos inventados.
return [
    'refaccion' => [
        'name' => 'Refacción de quintas',
        'title' => 'Refacción y puesta a punto de quintas en Paraguay | Obra',
        'description' => 'Refacción de quintas en Paraguay: techos, instalaciones, piscina, quincho y cerramiento renovados con un solo responsable y un plan por sectores.',
        'h1' => 'Refacción y puesta a punto de quintas',
        'kicker' => 'Recuperar lo que ya está construido',
        'intro' => [
            'Comprar una quinta usada casi siempre significa heredar problemas: techos con filtraciones, instalaciones viejas, piscina con pérdidas, muros caídos. Refaccionar bien es más barato que demoler, pero solo si se relevan los problemas antes de presupuestar.',
            'Hacemos un relevamiento por sectores (casa, exteriores, agua, electricidad, perímetro) y armamos un plan de intervención con prioridades: primero lo que protege la construcción, después lo que la mejora.',
        ],
        'includes' => ['Relevamiento del estado por sector con fotos', 'Techos, cielorrasos y humedades', 'Renovación de instalaciones eléctricas y sanitarias', 'Recuperación de piscina, quincho y galerías', 'Muros, portones y accesos'],
        'process' => [
            ['Recorrido y relevamiento', 'Recorremos la quinta sector por sector con vos: casa, galerías, quincho, piscina, cercos, instalaciones y accesos. Anotamos y fotografiamos lo que vemos, y preguntamos qué historia tiene cada cosa, porque una quinta usada suele tener parches viejos.'],
            ['Mapa de prioridades', 'Con el relevamiento armamos un orden: primero lo que deja entrar agua o pone en riesgo la seguridad, después lo que afecta el uso diario, al final lo que solo mejora el aspecto. Ese orden es el que decide por dónde empezar.'],
            ['Presupuesto por rubro y sector', 'Cada sector con sus rubros: cubierta, humedades, electricidad, sanitarios, piscina, cercos. Podés aprobar todo o ir etapa por etapa sin perder la coherencia.'],
            ['Ejecución por etapas', 'Se trabaja de arriba hacia abajo y de lo estructural a lo superficial: techo, luego humedades y muros, después instalaciones y por último terminaciones. Así no se pisa lo que ya se hizo.'],
            ['Cierre y entrega', 'Repasamos cada sector con vos, probamos las instalaciones y dejamos anotado qué se hizo y qué queda pendiente para una próxima etapa.'],
        ],
        'materials' => [
            ['Cubiertas', 'Teja, chapa o losa, según lo que exista. A veces alcanza con reemplazar las piezas rotas y rehacer las aislaciones; otras hay que cambiar la estructura de apoyo.'],
            ['Tratamiento de humedades', 'Se busca el origen: una cañería, una cubierta o el suelo. Recién entonces se elige entre impermeabilizar, cambiar revoques o hacer un drenaje exterior.'],
            ['Instalaciones eléctricas y sanitarias', 'Renovación total o parcial de cableado, tablero, cañerías y desagües. En una quinta vieja conviene revisar el circuito completo y no solo el tramo que falla.'],
            ['Muros, cercos y portones', 'Reparación de muros caídos, reposición de tramos de cerco y portones nuevos o restaurados, según el estado.'],
            ['Exteriores', 'Galerías, veredas y quincho recuperados con materiales que aguantan el sol y la lluvia sin mucho cuidado.'],
        ],
        'sections' => [
            ['Qué revisar primero en una quinta usada', ['Antes de gastar en pintura, mirá el techo desde adentro: manchas en el cielorraso, madera oscura o partes hundidas cuentan más que cualquier fisura del muro. Después, el tablero eléctrico y los cables a la vista, y la presión y el color del agua en las canillas.', 'También cuenta el terreno: por dónde escurre la lluvia, si hay charcos junto a la casa y si los árboles grandes están cerca de las paredes o de las cañerías.']],
            ['Humedad, techos e instalaciones viejas', ['La humedad en una quinta rara vez tiene una sola causa. Puede venir de un techo con filtraciones, de una cañería que pierde dentro del muro o de la tierra pegada a la pared. Si se pinta sin encontrar el origen, vuelve a salir.', 'Las instalaciones viejas son otro punto delicado: cableados sin protección, cañerías de material que ya no se usa y desagües que se tapan. Se reemplazan en el orden que marca el relevamiento, para que la quinta quede usable en cada etapa.']],
        ],
        'mistakes' => [
            ['Empezar por la pintura', 'Pintar sobre humedad o un techo con filtraciones es tirar la obra. Se arranca por lo que protege la construcción.'],
            ['Refaccionar sin relevar', 'Presupuestar sin haber recorrido cada sector deja sorpresas a mitad de obra. El relevamiento previo las reduce.'],
            ['Renovar solo lo visible', 'Cambiar revestimientos y dejar las instalaciones viejas detrás obliga a romper después. Se revisa lo oculto antes de terminar.'],
            ['Querer hacer todo a la vez', 'Abrir todos los frentes a la vez complica el uso de la quinta y el orden de la obra. Con etapas claras se avanza más ordenado.'],
        ],
        'ideal' => ['Compraste una quinta y no sabés por dónde empezar.', 'La quinta familiar quedó abandonada varios años.', 'Querés alquilarla y necesita estar en condiciones.'],
        'faqs' => [
            ['¿Conviene refaccionar o demoler?', 'Depende del estado de la estructura y las fundaciones. Si están sanas, refaccionar suele ser más económico. Lo evaluamos en el relevamiento.'],
            ['¿Pueden trabajar por prioridades?', 'Sí. Ordenamos la obra para que lo urgente (techo, agua, electricidad) vaya primero y el resto se programe según presupuesto.'],
            ['¿Trabajan en quintas lejos de Asunción?', 'Evaluamos cada caso según distancia, tamaño de la obra y logística de materiales.'],
            ['¿Cómo sé por dónde empezar?', 'Con el relevamiento. Ahí aparece qué es urgente por el riesgo o por el deterioro, y qué puede esperar. No conviene decidirlo a ojo.'],
            ['¿Se puede seguir usando la quinta durante la obra?', 'Depende de la etapa y del sector. Se ordena el trabajo para dejar libres los espacios que necesites, y si no se puede, lo hablamos antes de empezar.'],
            ['¿Recuperan también la piscina y el quincho?', 'Sí. Los incluimos en el mismo relevamiento y en el mismo plan, cada uno como su propio rubro.'],
        ],
        'related' => ['/quintas/casa-campo/', '/piscinas/renovacion/', '/reformas/techos/', '/guias/costo-casa/'],
    ],
    'casa-campo' => [
        'name' => 'Casas de campo',
        'title' => 'Construcción de casas de campo en Paraguay | Obra',
        'description' => 'Construcción de casas de campo en Paraguay: galerías amplias, techos altos, materiales que aguantan el clima y servicios propios de agua y electricidad.',
        'h1' => 'Construcción de casas de campo',
        'kicker' => 'Pensada para el calor, la lluvia y el fin de semana',
        'intro' => [
            'Una casa de campo no es una casa de ciudad puesta en una quinta. Tiene otra lógica: galería grande porque la vida pasa afuera, techos altos y aleros para el calor, materiales que no necesitan cuidado semanal y servicios que funcionan sin red pública.',
            'Construimos casas de campo con esa lógica desde el proyecto, coordinando agua (pozo, bomba, tanque), electricidad, desagües y accesos como parte de la misma obra.',
        ],
        'includes' => ['Implantación según sombra, viento y accesos', 'Galería perimetral y techos con aleros', 'Pozo, tanque elevado y presión de agua', 'Pozo ciego o cámara séptica según el terreno', 'Materiales de bajo mantenimiento'],
        'process' => [
            ['Visita y lectura del terreno', 'Vamos a la quinta y miramos dónde sale y se pone el sol, de dónde viene el viento, qué árboles dan sombra y por dónde se llega. Esa lectura decide la orientación de la casa y el lugar de la galería.'],
            ['Programa y servicios', 'Definimos con vos cuántos ambientes, quién la usa y en qué épocas, y de dónde salen el agua, la electricidad y el desagüe. Sin red pública, cada servicio se piensa como parte de la casa.'],
            ['Presupuesto por rubro', 'Fundaciones, estructura, mampostería, techo, galerías, instalaciones, terminaciones y servicios propios, cada uno por separado. Así ves dónde está el peso de la obra y qué alternativas hay.'],
            ['Construcción', 'Se ejecuta la estructura y el techo primero para proteger la obra de la lluvia, y después se avanza con instalaciones, revoques y terminaciones. Se cuida el acopio de materiales, que en el campo es más delicado.'],
            ['Pruebas y entrega', 'Se prueban agua, electricidad y desagües, se revisan los techos y las galerías, y te explicamos cómo operar bomba, tanque y tablero.'],
        ],
        'materials' => [
            ['Techo y aleros', 'Teja o chapa con buena aislación y aleros generosos que dan sombra a las paredes y protegen de la lluvia. En pendiente, el agua se conduce lejos de los muros.'],
            ['Muros', 'Ladrillo visto o revocado, según cómo se quiera ver la casa y cuánto mantenimiento se acepte. En el campo el ladrillo visto suele envejecer bien.'],
            ['Galería', 'Piso resistente al sol y al agua, con columnas y techo integrados a la casa. Puede ser de hormigón, cerámica o madera dura tratada en pérgola.'],
            ['Pisos', 'Cerámica, porcelanato o cemento alisado. Conviene que resistan el calor, la tierra que entra y el lavado frecuente.'],
            ['Aberturas y ventilación', 'Ventanas y puertas ubicadas para que corra el aire cruzado.'],
        ],
        'sections' => [
            ['Orientación, sombra y ventilación', ['En Paraguay el sol de la tarde es el que más calienta. Por eso conviene que los dormitorios miren hacia donde entra el sol de la mañana y que el lado oeste tenga galería, alero o vegetación que lo proteja.', 'La ventilación cruzada hace más que cualquier equipo: ventanas enfrentadas, techos altos y galerías que dejan pasar el aire. Se resuelve con la ubicación de las aberturas y la altura de los cielorrasos, no con ornamento.']],
            ['Agua, electricidad y desagües sin red', ['Una casa de campo depende de sus propias instalaciones. El pozo, la bomba y el tanque elevado definen la presión del agua; el desagüe se resuelve con pozo ciego o cámara séptica según el suelo; la electricidad puede necesitar tablero propio y protecciones.', 'Estos servicios se ubican pensando en el mantenimiento y en el crecimiento: el día que se agregue un quincho o una piscina, tienen que poder soportarlo sin rehacer todo.']],
        ],
        'mistakes' => [
            ['Copiar el plano de una casa de ciudad', 'En la quinta la vida ocurre afuera. Sin galería grande y sombra, la casa se vuelve incómoda en verano.'],
            ['Dejar el agua para el final', 'Sin pozo y tanque definidos, la obra depende de camiones de agua. Se resuelve desde el principio.'],
            ['Techos sin aleros', 'Sin protección, las paredes se mojan y se calientan. Un alero bien dimensionado cambia el confort y el mantenimiento.'],
            ['Ubicar la casa sin mirar el suelo', 'Un bajo del terreno junta agua y humedad. Se elige una zona firme y con buen escurrimiento.'],
        ],
        'ideal' => ['Tenés una quinta sin construir y querés una casa para usar todo el año.', 'Querés una casa de descanso con galería y quincho integrados.', 'El terreno no tiene agua ni cloaca y hay que resolverlo.'],
        'faqs' => [
            ['¿Qué materiales convienen para una casa de campo?', 'Los que aguantan sin mantenimiento constante: ladrillo visto o revoque, techos de teja o chapa con aislación, aberturas de aluminio o madera dura tratada.'],
            ['¿Pueden resolver el agua si no hay red?', 'Sí. Coordinamos la perforación del pozo, la bomba, el tanque y la instalación interna como parte de la obra.'],
            ['¿Se puede empezar por el quincho y después la casa?', 'Sí. Es una secuencia habitual en quintas: quincho con baño primero, casa principal después, con servicios previstos para ambos.'],
            ['¿Cuál es la diferencia con construir toda la quinta?', 'La casa de campo es la vivienda en sí: orientación, galerías, ventilación y servicios. La quinta completa suma quincho, piscina, cerco y accesos, y se planifica por sectores.'],
            ['¿La casa puede ser para uso solo de fin de semana?', 'Sí, y se piensa distinto: materiales que aguantan la casa cerrada, instalaciones fáciles de cortar y encender, y espacios que se airean solos.'],
            ['¿Cómo se elige dónde ubicarla en el terreno?', 'Con el sol, el viento, el acceso, el suelo y las vistas. Lo vemos en la visita y se marca en el plano antes de cavar.'],
        ],
        'related' => ['/quintas/refaccion/', '/quinchos/', '/piscinas/quinta/', '/guias/terreno/'],
    ],
];
