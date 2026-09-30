<?php
declare(strict_types=1);

// Guia informativa: /guias/{slug}/ salvo 'path' explicito. Sin cifras de precio, sin plazos fijos,
// sin datos legales o bancarios que no podamos verificar.
return [
    'name' => 'Qué define cuánto cuesta construir una casa',
    'title' => 'Cuánto cuesta construir una casa en Paraguay | Obra',
    'description' => 'Cuánto cuesta construir una casa en Paraguay: qué define el costo (metros, terreno, sistema, terminaciones) y cómo leer un presupuesto por rubro.',
    'summary' => 'Qué define el costo de construir una casa en Paraguay: metros, terreno, sistema constructivo, instalaciones y terminaciones. Cómo leer un presupuesto por rubro y comparar propuestas.',
    'h1' => 'Cuánto cuesta construir una casa en Paraguay: qué define el precio',
    'kicker' => 'Guía',
    'intro' => [
        'Todos preguntan lo mismo: cuánto cuesta el metro cuadrado. Y todos reciben cifras distintas, porque un precio por metro sin alcance no dice nada. Esta guía explica qué define el costo real de una casa y cómo comparar presupuestos sin que te sorprendan a mitad de obra.',
    ],
    'sections' => [
        ['Los metros cuadrados no son todos iguales', ['Una casa de 120 m² con galería, cochera y quincho no cuesta lo mismo que una de 120 m² cerrados. La superficie cubierta, la semicubierta y la descubierta tienen costos muy distintos, y cada presupuesto debería separarlas.', 'Por eso, antes de comparar precios, pedí que cada propuesta detalle qué metros son cubiertos, cuáles semicubiertos y qué incluye cada uno.']],
        ['El terreno cambia el presupuesto', ['Un terreno con desnivel necesita movimiento de suelo y muros de contención. Un suelo blando pide fundaciones más profundas. Un terreno sin agua ni cloaca necesita pozo y cámara séptica. Un terreno con acceso angosto encarece la logística.', 'Nada de esto aparece en un precio por metro cuadrado, y todo esto aparece en la obra.']],
        ['Sistema constructivo e instalaciones', ['La mampostería de ladrillo con estructura de hormigón es el sistema tradicional en Paraguay: aguanta el clima, lo aceptan los bancos y cualquier albañil lo conoce. Otros sistemas pueden ser más rápidos pero cambian el costo de terminación y la reventa.', 'Las instalaciones (agua, desagüe, electricidad, aire acondicionado, datos) pesan cada vez más en el presupuesto. Una casa con aire en cada ambiente y muchos puntos eléctricos no cuesta lo mismo que una básica.']],
        ['Las terminaciones deciden el precio final', ['Piso cerámico o porcelanato grande, aberturas de aluminio común o de línea reforzada, grifería estándar o de diseño, pintura o revestimiento: las terminaciones pueden mover el presupuesto más que la obra gruesa. Por eso conviene definirlas antes de cotizar, no después.']],
        ['Cómo leer un presupuesto por rubro', ['Un presupuesto serio se divide por rubros: movimiento de suelo, fundaciones, mampostería, estructura, techo, instalaciones, aberturas, revestimientos, pintura, terminaciones. Cada rubro tiene cantidades y precio unitario en guaraníes.', 'Con ese detalle podés comparar propuestas rubro por rubro, ver qué incluye cada una y qué no, y decidir dónde ajustar. Un precio global por metro cuadrado no permite ninguna de esas cosas.']],
        ['Lo que no conviene hacer', ['Elegir la propuesta más barata sin verificar el alcance. Firmar sin lista de exclusiones. Cambiar terminaciones a mitad de obra sin repasar el presupuesto. Suponer que el precio incluye planos, permisos y conexiones si no lo dice.']],
    ],
    'faqs' => [
        ['¿Por qué no publican un precio por metro cuadrado?', 'Porque sería una cifra inventada. El costo real sale del terreno, el proyecto, las instalaciones y las terminaciones de cada casa. Preferimos darte un presupuesto por rubro que puedas comparar.'],
        ['¿Cuánto cuesta un presupuesto de obra?', 'La estimación inicial sobre tus datos se conversa sin compromiso. Un cómputo métrico completo se cotiza según el proyecto y se confirma antes de empezar.'],
        ['¿El presupuesto sirve para pedir un crédito?', 'Sí, si tiene el detalle por rubro y el cronograma que suelen pedir los bancos. Lo preparamos con ese formato.'],
    ],
    'related' => ['/presupuesto/', '/casas/', '/credito/'],
];
