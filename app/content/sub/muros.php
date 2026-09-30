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
        ],
        'includes' => ['Fundaciones y columnas de mampostería u hormigón', 'Guía y contrapeso para portones corredizos', 'Rampa y piso de acceso vehicular', 'Muro de frente y pilares con iluminación', 'Coordinación de herrería y automatización'],
        'ideal' => ['Tu portón se traba o la columna se movió.', 'Querés cambiar un portón batiente por corredizo.', 'Estás haciendo el muro de frente y querés resolver el acceso a la vez.'],
        'faqs' => [
            ['¿Hacen el portón de hierro también?', 'Coordinamos la herrería con talleres que conocemos. Nosotros hacemos la obra civil y la integración.'],
            ['¿Cuánto espacio necesita un portón corredizo?', 'El ancho del vano más un tramo libre lateral por donde corre la hoja. Lo verificamos sobre tu frente.'],
            ['¿La automatización se puede agregar después?', 'Sí, si se dejó la instalación eléctrica prevista. Lo hacemos siempre.'],
        ],
        'related' => ['/muros/', '/tinglados/cocheras/', '/reformas/fachadas/'],
        'link' => ['site' => 'carpinteria', 'path' => '/portones/', 'text' => 'Si preferís un portón de madera, lo fabrica carpinteria.com.py y nosotros preparamos los pilares, los rieles y la obra civil del acceso.'],
    ],
];
