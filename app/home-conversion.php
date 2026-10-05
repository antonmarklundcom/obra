<?php
declare(strict_types=1);

function obra_home_intents(): void
{
    $choices = [
        ['casas', 'Construir desde cero', 'Casas, quintas y proyectos completos.', '/servicios/#grupo-nueva'],
        ['reformas', 'Mejorar lo que ya tenés', 'Reformas y ampliaciones en tu casa.', '/servicios/#grupo-reforma'],
        ['techos', 'Resolver tu techo', 'Cubiertas nuevas, filtraciones y desagües.', '/techos/'],
    ];
    ?><section class="home-intents section" id="elegi"><div class="section-head"><div><p class="eyebrow">Elegí por dónde empezar</p><h2>¿Qué querés hacer en tu propiedad?</h2></div><p>Empezá por tu necesidad. En cada servicio te contamos qué revisar y qué datos mandar para consultar.</p></div><div class="home-intent-grid"><?php foreach ($choices as [$slug, $title, $summary, $url]): ?><a class="home-intent-card" href="<?= h($url) ?>"><img src="<?= h(obra_service_image($slug)) ?>" srcset="<?= h(obra_reference_srcset($slug)) ?>" sizes="(min-width:760px) 33vw, 100vw" width="1200" height="900" alt="" loading="lazy"><div><h3><?= h($title) ?></h3><p><?= h($summary) ?></p><span>Ver opciones ↗</span></div></a><?php endforeach; ?></div><a class="text-link" href="/servicios/">Explorar todos los servicios →</a></section><?php
}

function obra_home_start(array $config): void
{
    $wa = obra_whatsapp($config, obra_wa_text('/', 'hero'));
    ?><section class="home-start section" id="empezar"><div class="home-start-copy"><p class="eyebrow">Antes de cotizar</p><h2>Lo que necesitamos saber.</h2><p>Un buen presupuesto no empieza con un precio por metro cuadrado. Empieza con información suficiente para comparar el mismo alcance.</p><p>No hace falta tener todo decidido: contanos qué querés hacer y dónde queda.</p><div class="action-row"><a class="btn btn-primary" href="<?= h($wa ?: '/cotizar/') ?>"<?= $wa ? obra_wa_attrs('mid') : '' ?>>Consultar mi proyecto ↗</a><a class="text-link" href="/cotizar/?origen=%2F">Prefiero el formulario</a></div><a class="hero-method" href="/como-trabajamos/">Conocé el proceso y las etapas →</a></div><div class="home-brief"><p class="eyebrow">Tu consulta, en cuatro puntos</p><div class="brief-list"><article><span>01</span><h3>Ubicación</h3><p>Ciudad, barrio y condiciones de acceso.</p></article><article><span>02</span><h3>Terreno y medidas</h3><p>Si ya tenés terreno, sus medidas. Si es una reforma, el sector a intervenir.</p></article><article><span>03</span><h3>Estado actual</h3><p>Obra nueva, construcción existente o proyecto en marcha. Fotos ayudan.</p></article><article><span>04</span><h3>Financiación</h3><p>Fondos propios o crédito. Cambia el cronograma y el formato del presupuesto.</p></article></div></div></section><?php
}
