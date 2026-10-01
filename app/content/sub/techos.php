<?php
declare(strict_types=1);

// Especialidades de /techos/: una intencion de busqueda por archivo en app/content/sub/techos/<slug>.php.
$children = [];
foreach (['chapa', 'termoacusticos', 'tejas', 'losa', 'impermeabilizar', 'goteras', 'canaletas', 'estructuras'] as $slug) {
    $children[$slug] = require __DIR__ . '/techos/' . $slug . '.php';
}
return $children;
