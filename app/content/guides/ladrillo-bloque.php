<?php
declare(strict_types=1);

// Guia informativa: /guias/{slug}/ salvo 'path' explicito. Sin cifras de precio, sin plazos fijos,
// sin datos legales o bancarios que no podamos verificar.
return [
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
];
