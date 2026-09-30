<?php
declare(strict_types=1);

// Guia informativa: /guias/{slug}/ salvo 'path' explicito. Sin cifras de precio, sin plazos fijos,
// sin datos legales o bancarios que no podamos verificar.
return [
    'name' => 'Platea o zapatas: fundaciones para tu casa',
    'title' => 'Platea o zapatas: qué fundación conviene | Obra',
    'description' => 'Platea o zapatas: qué fundación conviene según el suelo, la casa y el presupuesto. Errores comunes en fundaciones de casas en Paraguay.',
    'summary' => 'Platea de hormigón o zapatas y vigas de fundación: cuándo conviene cada una según el suelo, la casa y el presupuesto. Errores comunes en fundaciones en Paraguay.',
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
];
