<?php
declare(strict_types=1);

// Presentation data is separate from the existing SEO manuscripts and route metadata.
function obra_conversion_profiles(): array
{
    return [
        'casas' => ['Planificá tu casa', 'Una casa lista para habitar, con el alcance y las etapas definidos antes de construir.', ['Terreno y acceso', 'Planos o idea inicial', 'Metros y terminaciones'], 'Elegí cómo querés construir.', 'Planos, estructura, instalaciones y entrega con una sola coordinación.'],
        'quintas' => ['Planificá tu quinta', 'Casa, quincho y exteriores pensados juntos, aunque los construyas por etapas.', ['Ubicación y acceso', 'Construcciones existentes', 'Sectores y prioridades'], 'Ordená el conjunto de tu quinta.', 'Un plan general evita rehacer instalaciones y accesos entre una etapa y la siguiente.'],
        'piscinas' => ['Consultá por tu piscina', 'Una piscina a la medida de tu patio, con estructura, filtrado y terminaciones coordinados.', ['Medidas del patio', 'Acceso para la obra', 'Tipo de piscina'], 'Encontrá la piscina para tu espacio.', 'El espacio disponible, el uso y el acceso ayudan a elegir la solución.'],
        'quinchos' => ['Consultá por tu quincho', 'Parrilla, techo y área social integrados para disfrutar mejor tu patio.', ['Fotos y medidas', 'Abierto o cerrado', 'Parrilla y servicios'], 'Pensá el quincho que vas a usar.', 'Elegí el ambiente y sus componentes; resolvemos juntos cómo se conectan.'],
        'reformas' => ['Consultá por tu reforma', 'Renová lo que ya tenés con una secuencia de trabajo pensada para tu casa.', ['Fotos del estado actual', 'Ambientes a intervenir', 'Si la casa está habitada'], '¿Qué parte de tu casa querés renovar?', 'Empezá por el ambiente o el problema que necesitás resolver.'],
        'ampliaciones' => ['Consultá tu ampliación', 'Sumá espacio a tu casa con la estructura y las conexiones existentes revisadas.', ['Fotos de la casa', 'Planos si los tenés', 'Espacio que querés sumar'], 'Más espacio, bien conectado.', 'La ampliación empieza por entender lo existente y cómo se unirá lo nuevo.'],
        'patios' => ['Consultá por tu patio', 'Sombra, pisos y circulación para aprovechar mejor el espacio exterior.', ['Fotos y medidas', 'Sol y escurrimiento', 'Uso del patio'], 'Dale un uso a cada parte del patio.', 'Pisos, sombra y niveles se resuelven como un conjunto.'],
        'tinglados' => ['Consultá tu cubierta', 'Una estructura y cubierta pensadas para vehículos, almacenamiento o trabajo.', ['Uso y medidas', 'Altura y acceso', 'Fotos del lugar'], 'Elegí según el uso de la cubierta.', 'Las dimensiones, los apoyos y el uso definen la estructura.'],
        'techos' => ['Consultá por tu techo', 'Construcción y reparación de techos, con estructura, aislación y desagüe según tu caso.', ['Tipo de techo', 'Medidas aproximadas', 'Fotos desde un lugar seguro'], '¿Qué necesitás resolver en tu techo?', 'Elegí una cubierta nueva, una reparación o los componentes que necesitás mejorar.'],
        'muros' => ['Consultá tu cerramiento', 'Límites, muralla y acceso resueltos según el terreno y el uso de tu propiedad.', ['Ubicación y límites', 'Metros de cerramiento', 'Portón y accesos'], 'Cerramiento y acceso, juntos.', 'El suelo, los límites y el drenaje se revisan antes de ejecutar.'],
        'comerciales' => ['Planificá tu local', 'Un espacio preparado para operar, con el alcance y la secuencia de obra coordinados.', ['Uso del negocio', 'Fecha de apertura prevista', 'Estado e instalaciones'], 'Prepará el espacio para tu actividad.', 'La obra se organiza alrededor del uso, las instalaciones y la apertura.'],
        'supervision' => ['Consultá tu obra', 'Una revisión profesional de la obra, con controles y observaciones documentados.', ['Planos y contrato', 'Estado de avance', 'Controles que necesitás'], 'Conocé qué se va a controlar.', 'Documentación, visitas y reportes definidos según la etapa de tu obra.'],
        'presupuesto' => ['Consultá tu presupuesto', 'Un presupuesto por rubro para entender el alcance antes de comprometerte.', ['Planos disponibles', 'Metros y terminaciones', 'Objetivo del presupuesto'], 'Entendé qué vas a recibir.', 'Cantidades, rubros y decisiones pendientes en un documento para comparar.'],
    ];
}

function obra_conversion_profile(string $slug): array
{
    $p = obra_conversion_profiles()[$slug];
    return ['cta' => $p[0], 'summary' => $p[1], 'brief' => $p[2], 'heading' => $p[3], 'explain' => $p[4]];
}

function obra_quote_url(?string $slug = null, ?string $child = null, string $origin = ''): string
{
    $query = [];
    if ($slug !== null && $slug !== '') { $query['servicio'] = $slug; }
    if ($child !== null && $child !== '') { $query['especialidad'] = $child; }
    if ($origin !== '') { $query['origen'] = $origin; }
    return '/cotizar/' . ($query ? '?' . http_build_query($query) : '');
}

function obra_is_small_enquiry(string $slug, string $child = ''): bool
{
    return in_array($slug, ['techos', 'reformas', 'patios', 'muros', 'supervision', 'presupuesto'], true)
        || in_array($child, ['renovacion', 'refaccion', 'parrillas'], true);
}

function obra_service_image(string $slug, string $child = ''): string
{
    return '/assets/images/reference/' . $slug . ($child !== '' ? '-' . $child : '') . '-960.webp';
}

function obra_reference_srcset(string $slug, string $child = ''): string
{
    $base = '/assets/images/reference/' . $slug . ($child !== '' ? '-' . $child : '');
    return $base . '-480.webp 480w, ' . $base . '-960.webp 960w, ' . $base . '-1200.webp 1200w';
}

function obra_service_media(array $page, string $slug, string $child = ''): void
{
    ?><figure class="conversion-media"><img src="<?= h(obra_service_image($slug, $child)) ?>" srcset="<?= h(obra_reference_srcset($slug, $child)) ?>" sizes="(min-width:1024px) 45vw, 100vw" alt="<?= h($page['name']) ?>" width="1200" height="900" fetchpriority="high"></figure><?php
}

function obra_service_hero(array $config, array $content, array $route, array $page): void
{
    $slug = $route['slug']; $child = $route['child'] ?? '';
    $path = '/' . $slug . '/' . ($child !== '' ? $child . '/' : '');
    $p = obra_conversion_profile($slug);
    $wa = obra_whatsapp($config, obra_wa_text($path, 'hero', $slug));
    $summary = $child === '' ? $page['short'] : ($page['summary'] ?? $page['description']);
    ?><header class="service-hero conversion-hero"><div class="conversion-copy"><?php obra_breadcrumb_nav(obra_breadcrumbs($content, $route, $path)); ?><p class="eyebrow"><?= h($page['kicker']) ?></p><h1><?= h($page['h1']) ?></h1><p class="hero-deck"><?= h($summary) ?></p><div class="action-row"><a class="btn btn-primary" href="<?= h($wa ?: obra_quote_url($slug, $child, $path)) ?>"<?= $wa ? obra_wa_attrs('hero', $slug) : '' ?>><?= h($child === 'goteras' || $child === 'renovacion' ? 'Consultar la reparación' : $p['cta']) ?> <span aria-hidden="true">↗</span></a><a class="text-link" href="<?= h(obra_quote_url($slug, $child, $path)) ?>">Completar el formulario</a></div><p class="hero-response">Mandanos ubicación y fotos. Respondemos en horario comercial.</p><ul class="conversion-trust"><li>Alcance por escrito</li><li>Un responsable de obra</li><li><?= h($config['area']) ?></li></ul><a class="hero-method" href="/como-trabajamos/">Conocé cómo trabajamos →</a></div><?php obra_service_media($page, $slug, $child); ?></header><?php
}

function obra_service_nav(bool $hasOptions): void
{
    ?><nav class="service-jumps" aria-label="Contenido del servicio"><?php if ($hasOptions): ?><a href="#opciones">Opciones</a><?php else: ?><a href="#tu-caso">Tu caso</a><?php endif; ?><a href="#propuesta">Cómo empezar</a><a href="#incluye">Qué incluye</a><a href="#detalles">Detalles y proceso</a><a href="#preguntas">Preguntas</a></nav><?php
}

function obra_choice_overview(array $content, string $slug): void
{
    $children = $content['children'][$slug] ?? [];
    $p = obra_conversion_profile($slug);
    $choices = [];
    if ($slug === 'techos') {
        $choices = [
            ['Cubierta nueva', 'Chapa, teja, losa o aislación térmica.', '#especialidades', 'chapa'],
            ['Goteras y filtraciones', 'Encontrar el origen y definir la reparación.', '/techos/goteras/', 'goteras'],
            ['Estructura y desagüe', 'Apoyos, canaletas y conducción del agua.', '/techos/canaletas/', 'canaletas'],
        ];
    } else {
        foreach (array_slice($children, 0, 3, true) as $child => $page) {
            $choices[] = [$page['name'], $page['kicker'], '/' . $slug . '/' . $child . '/', $child];
        }
    }
    ?><section class="choice-overview section" id="opciones"><div class="section-head"><div><p class="eyebrow">Elegí tu solución</p><h2><?= h($p['heading']) ?></h2></div><p><?= h($p['explain']) ?></p></div><div class="choice-grid"><?php foreach ($choices as [$name, $summary, $url, $child]): ?><a class="choice-card" href="<?= h($url) ?>"><img src="<?= h(obra_service_image($slug, $child)) ?>" srcset="<?= h(obra_reference_srcset($slug, $child)) ?>" sizes="(min-width:760px) 33vw, 120px" alt="" width="1200" height="900" loading="lazy"><div><h3><?= h($name) ?></h3><p><?= h($summary) ?></p><span aria-hidden="true">↗</span></div></a><?php endforeach; ?></div><a class="text-link" href="#especialidades">Ver todas las especialidades →</a></section><?php
}

function obra_case_section(array $page, string $slug): void
{
    $p = obra_conversion_profile($slug);
    ?><section class="case-section section" id="tu-caso"><div class="section-head"><div><p class="eyebrow">Tu caso</p><h2><?= h($p['heading']) ?></h2></div><p><?= h($p['explain']) ?></p></div><div class="case-grid"><?php foreach (array_slice($page['ideal'], 0, 3) as $i => $item): ?><article><span class="case-number"><?= sprintf('%02d', $i + 1) ?></span><p><?= h($item) ?></p></article><?php endforeach; ?></div></section><?php
}

function obra_start_section(array $config, string $slug, array $page, string $child = ''): void
{
    $path = '/' . $slug . '/' . ($child !== '' ? $child . '/' : '');
    $p = obra_conversion_profile($slug);
    $wa = obra_whatsapp($config, obra_wa_text($path, 'hero', $slug));
    ?><section class="start-section section" id="propuesta"><div class="proposal-example"><p class="eyebrow">Una propuesta que se entiende</p><div class="proposal-sheet"><div class="proposal-title"><strong>OBRA<span>.com.py</span></strong><span>Alcance por rubro</span></div><p class="proposal-caption">Ejemplo de estructura · sin importes</p><ol><?php foreach (array_slice($page['includes'], 0, 3) as $item): ?><li><span><?= h($item) ?></span><b aria-hidden="true">✓</b></li><?php endforeach; ?></ol><div class="proposal-tags"><span>Incluidos y exclusiones</span><span>Materiales</span><span>Etapas</span></div></div><p class="proposal-note">El alcance final se ajusta a tu proyecto y queda por escrito. Los plazos y las condiciones se definen en la propuesta.</p></div><div class="start-copy"><p class="eyebrow">El primer paso</p><h2>Contanos tu caso.<br>Ordenamos cómo seguir.</h2><p>No hace falta tener todo resuelto para consultar.</p><ul class="brief-checks"><?php foreach ($p['brief'] as $item): ?><li><?= h($item) ?></li><?php endforeach; ?></ul><ol class="start-steps"><li><b>01</b> Nos mandás los datos</li><li><b>02</b> Revisamos el caso y la visita necesaria</li><li><b>03</b> Definimos alcance y propuesta</li></ol><details class="early-answer"><summary>Visita, presupuesto y condiciones</summary><p>La primera conversación y la estimación inicial son sin compromiso. Si el proyecto requiere relevamiento técnico o cómputo métrico completo, te lo confirmamos antes de cualquier visita. Las condiciones de garantía dependen del rubro, los materiales y el contrato, y quedan por escrito en la propuesta final.</p></details><div class="action-row"><a class="btn btn-primary" href="<?= h($wa ?: obra_quote_url($slug, $child, $path)) ?>"<?= $wa ? obra_wa_attrs('mid', $slug) : '' ?>>Consultar por WhatsApp <span aria-hidden="true">↗</span></a><a class="text-link" href="<?= h(obra_quote_url($slug, $child, $path)) ?>">Prefiero el formulario</a></div><p class="hero-response"><?= $slug === 'techos' || $child === 'techos' ? 'Fotos desde un lugar seguro. No hace falta subir al techo.' : 'El alcance y los tiempos se acuerdan después de revisar tu proyecto.' ?></p></div></section><?php
}

function obra_roof_comparison(): void
{
    ?><section class="roof-comparison section"><div class="section-head"><div><p class="eyebrow">Para elegir</p><h2>Chapa, teja o losa.</h2></div><p>La cubierta se elige junto con su estructura, aislación y desagüe. El uso del espacio y lo que ya existe cambian la decisión.</p></div><div class="table-scroll" role="region" aria-label="Comparación de cubiertas" tabindex="0"><table><caption>Una orientación inicial; la solución se define al revisar tu proyecto.</caption><thead><tr><th scope="col">Cubierta</th><th scope="col">Uso habitual</th><th scope="col">Qué revisar</th><th scope="col">Calor y mantenimiento</th></tr></thead><tbody><tr><th scope="row"><a href="/techos/chapa/">Chapa</a></th><td>Casas, cocheras, quinchos y galpones</td><td>Estructura, pendiente y fijaciones</td><td>Aislación, ventilación, tornillos y encuentros</td></tr><tr><th scope="row"><a href="/techos/tejas/">Tejas</a></th><td>Viviendas y quinchos con tejado inclinado</td><td>Peso, apoyos, pendiente y cumbreras</td><td>Ventilación, piezas y remates</td></tr><tr><th scope="row"><a href="/techos/losa/">Losa</a></th><td>Terrazas o proyectos con crecimiento previsto</td><td>Estructura calculada, cargas y desagües</td><td>Impermeabilización y terminación expuesta al sol</td></tr></tbody></table></div></section><?php
}

// Only authorized, attributable projects are rendered. Empty data is never replaced with invented proof.
function obra_project_evidence(array $config, string $slug): void
{
    $projects = array_filter($config['projects'] ?? [], fn($p) => is_array($p) && !empty($p['authorized']) && ($p['service'] ?? '') === $slug && !empty($p['title']) && !empty($p['scope']) && !empty($p['image']) && str_starts_with($p['image'], '/assets/images/') && !str_starts_with($p['image'], '/assets/images/reference/') && !str_contains($p['image'], '..') && is_file(__DIR__ . '/..' . $p['image']));
    if (!$projects) { return; }
    ?><section class="project-evidence section"><p class="eyebrow">Obras realizadas</p><h2>Del proyecto al resultado.</h2><div class="evidence-grid"><?php foreach ($projects as $project): ?><figure><img src="<?= h($project['image']) ?>" alt="<?= h($project['title']) ?>" width="1000" height="750" loading="lazy"><figcaption><h3><?= h($project['title']) ?></h3><p><?= h($project['scope']) ?></p><small><?= h($project['location'] ?? '') ?></small></figcaption></figure><?php endforeach; ?></div></section><?php
}
