<?php
declare(strict_types=1);

// Servicio (hub) /reformas/. Sin precios, sin plazos fijos, sin datos inventados.
return [
        'name' => 'Reformas y remodelaciones',
        'updated' => '2026-10-01',
        'short' => 'Reorganizá ambientes, renová instalaciones y terminaciones sobre lo que ya tenés.',
        'title' => 'Reformas y remodelación de casas en Paraguay | Obra',
        'description' => 'Reformas y remodelación de casas en Asunción y Gran Asunción: demoliciones, albañilería, instalaciones y terminaciones con alcance claro y un responsable.',
        'h1' => 'Reformas y remodelación de casas en Paraguay',
        'kicker' => 'Hacé que la casa acompañe una nueva etapa',
        'includes' => ['Relevamiento de lo existente', 'Demoliciones y retiro de escombros', 'Albañilería e instalaciones nuevas', 'Revestimientos, pisos y pintura', 'Plan de trabajo para reducir molestias si la casa está habitada'],
        'ideal' => ['La distribución actual ya no funciona para tu familia.', 'Querés integrar ambientes o abrir la casa hacia el patio.', 'Compraste una casa y querés renovarla antes de mudarte.', 'Querés poner en valor una casa antes de alquilarla o venderla.'],
        'faqs' => [
            ['¿Cuánto cuesta remodelar una casa?', 'Depende del sector, el estado de la estructura y las instalaciones, las demoliciones y el nivel de terminación. Una visita inicial permite definir el alcance y presupuestar por rubro.'],
            ['¿Se puede remodelar sin salir de la casa?', 'Muchas veces sí, por etapas y aislando sectores. Algunas intervenciones requieren desocupar áreas temporalmente por seguridad.'],
            ['¿Hacen demoliciones y retiro de escombros?', 'Sí, cuando forman parte de la reforma. Quedan detallados en la propuesta.'],
            ['¿Necesito planos para una reforma?', 'Para cambios estructurales o de fachada suele hacer falta documentación municipal. Lo revisamos en el relevamiento y te decimos qué corresponde.'],
            ['¿Cuál es la diferencia entre reforma, refacción y remodelación?', 'En la práctica se usan casi como sinónimos. Refacción suele hablar de reparar y renovar lo existente; remodelación, de cambiar la distribución o el uso de los ambientes. En la visita definimos qué necesita tu casa.'],
            ['¿Qué pasa si aparece algo inesperado al abrir una pared?', 'Se detiene ese frente, se te muestra y se propone una solución con su costo aparte antes de seguir. Por eso el relevamiento previo intenta anticipar lo que se pueda.'],
        ],
        'sections' => [
            ['Cómo se ordena una reforma de casa', ['Una reforma empieza mirando lo que hay: estructura, humedades, instalaciones viejas y qué paredes se pueden tocar. Con ese relevamiento se decide qué se demuele, qué se conserva y qué se rehace. Sin esa mirada previa, la remodelación se llena de sorpresas cuando se abre una pared.', 'Después viene la secuencia: demoliciones y retiro, albañilería, instalaciones nuevas, revoques, pisos y revestimientos, y por último pintura y detalles. Se trabaja sector por sector para poder seguir usando el resto de la casa.']],
            ['Vivir en la casa durante la remodelación', ['Se puede, con planificación. Se aíslan los sectores en obra con cerramientos provisorios, se define qué baño y qué cocina siguen funcionando y se ordenan los horarios. Cuando una intervención toca instalaciones principales, puede haber cortes de agua o luz que se avisan antes.', 'Si la reforma es grande, a veces conviene desocupar una parte por seguridad. Lo hablamos en la visita, sin apuro.']],
            ['Humedad, revoques y refacción de lo viejo', ['Una refacción seria no tapa la humedad con pintura. Se busca el origen: una cañería que pierde, un desnivel del patio, falta de aislación en cimientos o un techo con filtraciones. Recién corregida la causa se reparan revoques y terminaciones.', 'Lo mismo pasa con instalaciones eléctricas y sanitarias antiguas: si las paredes ya están abiertas, es el momento de cambiarlas y no de dejar un parche.']],
        ],
        'related' => ['ampliaciones', 'patios', 'casas', 'comerciales', 'presupuesto'],
        'link' => ['site' => 'arq', 'path' => '/regularizacion/', 'text' => 'Si la construcción existente no tiene planos aprobados, la regularización la hace nuestro estudio en arq.com.py antes o durante la reforma.'],
];
