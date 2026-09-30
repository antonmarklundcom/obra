<?php
declare(strict_types=1);
// Cuenta las palabras propias de una pagina de contenido (docs/seo/CONTENT-SPEC.md).
// Uso: php tools/content-words.php piscinas/chicas   |   php tools/content-words.php guides/platea   |   php tools/content-words.php hub/casas
// Excluye campos que no son copy propio: name, title, description, summary, h1, kicker, image*, related, link, path, short.
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
[$kind, $slug] = array_pad(explode('/', (string) ($argv[1] ?? '')), 2, '');
$root = dirname(__DIR__);
require $root . '/app/helpers.php';
if ($kind === 'guides') { $page = require "$root/app/content/guides/$slug.php"; }
elseif ($kind === 'hub') { $content = require "$root/app/content.php"; $page = $content['services'][$slug] ?? null; }
else { $sub = require "$root/app/content/sub/$kind.php"; $page = $sub[$slug] ?? null; }
if (!is_array($page)) { fwrite(STDERR, "not found: {$argv[1]}\n"); exit(2); }
foreach (['name', 'title', 'description', 'summary', 'h1', 'kicker', 'image', 'image_alt', 'related', 'link', 'path', 'short'] as $k) { unset($page[$k]); }
$n = 0;
array_walk_recursive($page, function ($v) use (&$n) { $n += preg_match_all('/[\p{L}\p{N}]+/u', (string) $v); });
$faqs = count($page['faqs'] ?? []);
echo "$n words of own copy, $faqs FAQs\n";
