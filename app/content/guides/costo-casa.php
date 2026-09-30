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
    'published' => '2026-09-30',
    'updated' => '2026-09-30',
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
        ['Lo que queda afuera, las etapas y los imprevistos', ['Hay gastos que rara vez entran en una propuesta de obra si nadie los nombra: los planos y la aprobación municipal, las conexiones de agua y electricidad a la red, el cerco, el paisajismo, los muebles y las cortinas. Ninguno es un secreto, pero si no figuran en el alcance escrito aparecen después como un costo aparte.', 'Pedí la lista de exclusiones por escrito y compará que dos propuestas excluyan lo mismo. Una que parece más barata a veces solo dejó afuera más cosas.', 'Cuando el presupuesto total no alcanza de una vez, una casa puede planificarse para crecer: primero la parte habitable y después el resto. Eso solo funciona si desde el inicio se dejan previstas las instalaciones y la estructura de lo que viene, porque abrir paredes o refundar más tarde sale más caro que haberlo pensado antes.', 'Al comparar propuestas conviene preguntar qué queda terminado en cada etapa y qué queda esperando, para que cada tramo se pueda usar sin depender del siguiente.', 'Ninguna obra está libre de sorpresas: un suelo que responde distinto a lo esperado, una instalación existente en mal estado, un cambio de idea a mitad de camino. Lo sano es que el presupuesto diga cómo se tratan esos casos: qué se avisa, cómo se cotiza el adicional y quién lo aprueba antes de ejecutarlo.', 'Un adicional acordado por escrito antes de hacerse es parte normal de la obra. Uno que aparece en la factura final sin aviso es señal de que el alcance estaba mal cerrado.']],
    ],
    'faqs' => [
        ['¿Por qué no publican un precio por metro cuadrado?', 'Porque sería una cifra inventada. El costo real sale del terreno, el proyecto, las instalaciones y las terminaciones de cada casa. Preferimos darte un presupuesto por rubro que puedas comparar.'],
        ['¿Cuánto cuesta un presupuesto de obra?', 'La estimación inicial sobre tus datos se conversa sin compromiso. Un cómputo métrico completo se cotiza según el proyecto y se confirma antes de empezar.'],
        ['¿El presupuesto sirve para pedir un crédito?', 'Sí, si tiene el detalle por rubro y el cronograma que suelen pedir los bancos. Lo preparamos con ese formato.'],
        ['¿Qué datos necesitan para estimar el costo de mi casa?', 'Los metros que imaginás, si ya tenés terreno y dónde queda, si hay planos, cuántos ambientes y baños querés y qué nivel de terminaciones tenés en mente. Con eso se arma una primera orientación que después se ajusta con la visita.'],
        ['¿Conviene cotizar con los planos terminados?', 'Sí. Un presupuesto sobre planos definidos se puede medir rubro por rubro; sobre una idea suelta solo se puede estimar, y la diferencia se paga en ajustes durante la obra.'],
        ['¿Por qué dos presupuestos de la misma casa difieren tanto?', 'Casi siempre por el alcance: materiales incluidos o no, calidad de las terminaciones, gremios, dirección técnica y exclusiones. Ponelos lado a lado por rubro y la diferencia se explica sola.'],
    ],
    'related' => ['/presupuesto/', '/casas/', '/credito/', '/casas/etapas/'],
];
