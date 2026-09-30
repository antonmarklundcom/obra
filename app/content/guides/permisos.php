<?php
declare(strict_types=1);

// Guia informativa: /guias/{slug}/ salvo 'path' explicito. Sin cifras de precio, sin plazos fijos,
// sin datos legales o bancarios que no podamos verificar.
return [
    'name' => 'Permisos municipales para construir',
    'title' => 'Permisos municipales para construir una casa en Paraguay | Obra',
    'description' => 'Permisos municipales para construir una casa en Paraguay: planos aprobados, profesional responsable, retiros y habilitación final. Riesgos de no tenerlos.',
    'summary' => 'Qué permisos hacen falta para construir o ampliar en Paraguay: planos aprobados, profesional responsable, retiros y habilitación final. Qué pasa si se construye sin permiso.',
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
    'link' => ['site' => 'arq', 'path' => '/carpeta/', 'text' => 'La carpeta municipal y la aprobación de planos las prepara nuestro estudio en arq.com.py; con eso aprobado, arrancamos la obra.'],
];
