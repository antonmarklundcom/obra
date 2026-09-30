<?php
declare(strict_types=1);

// Especialidades de este hub: /{hub}/{slug}/. Una intencion de busqueda distinta a la del hub.
// 'related' son rutas completas. Sin precios, sin plazos fijos, sin datos inventados.
return [
    'portones' => [
        'name' => 'Portones y accesos',
        'title' => 'Construcción de portones y accesos en Paraguay | Obra',
        'description' => 'Portones corredizos, batientes y automatizados con su obra civil en Asunción y Gran Asunción: columnas, guías, fundaciones, muro de frente y acceso vehicular.',
        'h1' => 'Construcción de portones y accesos',
        'kicker' => 'La obra civil que hace funcionar el portón',
        'intro' => [
            'Un portón que se traba o se descuelga casi nunca falla por el portón: falla la columna, la guía o la fundación. La obra civil del acceso es tan importante como el herraje.',
            'Hacemos columnas, fundaciones, guías, muro de frente y rampas de acceso, y coordinamos la herrería y la automatización para que el conjunto funcione desde el primer día.',
            'Ya sea un portón metálico de acceso a la casa, un portón corredizo para la cochera o un acceso vehicular de un local, lo primero es mirar el vano y cómo se comporta el suelo y la pared que lo sostiene.',
        ],
        'includes' => ['Fundaciones y columnas de mampostería u hormigón', 'Guía y contrapeso para portones corredizos', 'Rampa y piso de acceso vehicular', 'Muro de frente y pilares con iluminación', 'Coordinación de herrería y automatización', 'Previsión de cámaras, portero y cerradura eléctrica'],
        'process' => [
            ['Visita al frente', 'Medimos el ancho del vano, el desnivel de la vereda, el estado de las columnas existentes y el espacio libre lateral. Vemos también si hay tierra blanda o raíces que compliquen la fundación.'],
            ['Definición del tipo de portón', 'Batiente, corredizo o mixto con puerta peatonal. Se elige según el espacio, el uso diario y si querés automatizar. Un batiente necesita radio de apertura; un corredizo necesita tramo lateral libre.'],
            ['Presupuesto por rubro', 'Demolición si hace falta, fundaciones, columnas, riel o guía, rampa y piso, herrería y automatización por separado. Así se sabe qué se coordina con terceros y qué hace la obra.'],
            ['Fundaciones y columnas', 'Se excavan las bases, se arman y hormigonan las columnas con los anclajes del herraje ya previstos. Se respetan los tiempos de fragüe antes de colgar la hoja.'],
            ['Instalación y ajuste', 'Se coloca el portón, se ajusta la guía y los topes y se conecta el equipo eléctrico. Probamos apertura, cierre y trabas varias veces antes de dar la obra por terminada.'],
        ],
        'materials' => [
            ['Columnas de hormigón armado', 'Son la opción más firme para portones pesados o de gran ancho, porque resisten el empuje y el golpe de un vehículo. Llevan armadura y fundación proporcional al peso de la hoja.'],
            ['Columnas de mampostería reforzada', 'Adecuadas para portones livianos o peatonales, con encadenado y refuerzo. Se terminan con revoque, revestimiento o piedra para que combinen con el muro.'],
            ['Portón metálico', 'Hierro o chapa, con o sin rejas, según cuánta visibilidad querés. Se protege con pintura anticorrosiva y se define el herraje para que soporte el uso diario y el peso.'],
            ['Riel, guía y contrapeso', 'En corredizos, el riel embutido en el piso o la guía aérea determinan la suavidad y la vida útil. Se ubica y nivela con cuidado, porque un riel torcido trae problemas que ningún motor arregla.'],
            ['Automatización', 'Motor, control remoto, portero y sensores. Se elige un equipo acorde al peso de la hoja y se deja toda la instalación eléctrica lista desde la obra civil.'],
        ],
        'sections' => [
            ['Portones metálicos y de acceso: qué se resuelve en la obra', ['Un portón metálico es la parte visible, pero lo que lo sostiene es una fundación, dos columnas alineadas y un piso de acceso bien nivelado. Cuando alguno de esos elementos falla, la hoja roza, se abre sola o exige empujarla con fuerza.', 'Por eso revisamos siempre el conjunto: si las columnas existentes están plomadas, si la viga de arriba es necesaria para cerrar el marco y si el piso del acceso tiene pendiente hacia la calle o hacia adentro.']],
            ['Automatizar sin complicaciones', ['Automatizar un portón es más fácil si se piensa desde la obra. La canalización eléctrica, el tomacorriente cercano al motor, el punto para el portero y la ubicación de las fotocélulas se dejan previstos antes de revocar y de hacer el piso.', 'Si tu portón ya existe, se puede agregar la automatización, siempre que la estructura y el riel estén en buen estado. Lo revisamos antes de instalar el equipo, porque un motor sobre un portón torcido solo agrava el problema.']],
            ['Seguridad del acceso', ['Un acceso seguro no depende solo de la altura del portón. Cuenta la visibilidad desde la calle, la iluminación de las columnas, el espacio de espera del vehículo y la ubicación de cámaras y portero. Todo eso se puede dejar previsto en la obra, con cañerías embutidas.']],
        ],
        'mistakes' => [
            ['Colgar el portón sobre columnas viejas', 'Si no están plomadas ni reforzadas, la hoja se descuelga. Se verifican y, si hace falta, se rehacen.'],
            ['Elegir el portón sin medir el espacio lateral', 'Un corredizo sin tramo libre no se puede instalar. Se mide antes de decidir el tipo.'],
            ['Riel sin nivelar', 'Un riel con desnivel hace que la hoja se atasque o se abra sola. Se nivela y se fija con cuidado.'],
            ['Dejar la instalación eléctrica para después', 'Abrir paredes y piso para pasar cables lleva más trabajo que dejarlo previsto. Se prevé desde el principio.'],
        ],
        'ideal' => ['Tu portón se traba o la columna se movió.', 'Querés cambiar un portón batiente por corredizo.', 'Estás haciendo el muro de frente y querés resolver el acceso a la vez.'],
        'faqs' => [
            ['¿Hacen el portón de hierro también?', 'Coordinamos la herrería con talleres que conocemos. Nosotros hacemos la obra civil y la integración.'],
            ['¿Cuánto espacio necesita un portón corredizo?', 'El ancho del vano más un tramo libre lateral por donde corre la hoja. Lo verificamos sobre tu frente.'],
            ['¿La automatización se puede agregar después?', 'Sí, si se dejó la instalación eléctrica prevista. Lo hacemos siempre.'],
            ['¿Cuánto espacio necesita un portón batiente?', 'El radio de apertura de cada hoja, libre de obstáculos, y un piso sin desnivel fuerte. Si no hay lugar, conviene un corredizo.'],
            ['¿Se puede cambiar un portón sin tocar las columnas?', 'A veces sí, si las columnas están firmes y bien alineadas. Las revisamos primero para no colgar un portón nuevo sobre una base dudosa.'],
            ['¿Hacen la puerta peatonal junto al portón?', 'Sí, se integra en el mismo vano o al costado, con su pilar y su cerradura, y se coordina con el portón vehicular.'],
        ],
        'related' => ['/muros/', '/tinglados/cocheras/', '/reformas/fachadas/', '/guias/permisos/'],
        'link' => ['site' => 'carpinteria', 'path' => '/portones/', 'text' => 'Si preferís un portón de madera, lo fabrica carpinteria.com.py y nosotros preparamos los pilares, los rieles y la obra civil del acceso.'],
    ],
];
