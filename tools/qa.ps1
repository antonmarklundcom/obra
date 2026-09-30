param([string]$Base = 'http://127.0.0.1:8787')
# QA de rutas y guardrails. Este archivo se guarda en UTF-8 CON BOM: Windows PowerShell 5.1 lee
# los .ps1 sin BOM como ANSI y convierte los acentos en basura, con lo que los patrones nunca
# coinciden. Los patrones de abajo evitan igualmente caracteres acentuados por seguridad.
$ErrorActionPreference = 'Stop'
# Las rutas indexables se leen del sitemap dinamico, asi el QA cubre toda pagina nueva sin editar esta lista.
$sitemapXml = [System.Text.Encoding]::UTF8.GetString((Invoke-WebRequest -Uri ($Base + '/sitemap.xml') -UseBasicParsing).RawContentStream.ToArray())
$fromSitemap = @([regex]::Matches($sitemapXml, '<loc>https://obra\.com\.py(/[^<]*)</loc>') | ForEach-Object { $_.Groups[1].Value })
if ($fromSitemap.Count -lt 20) { throw "Sitemap lists only $($fromSitemap.Count) URLs" }
$routes = @($fromSitemap + @('/gracias/', '/sitemap.xml', '/robots.txt'))
function Get-Status([string]$Url) {
  # HttpWebRequest directo: Invoke-WebRequest en PowerShell 5.1 lanza excepcion con -MaximumRedirection 0
  $req = [System.Net.HttpWebRequest]::Create($Url)
  $req.AllowAutoRedirect = $false
  $req.Method = 'GET'
  try {
    $resp = $req.GetResponse()
  } catch [System.Net.WebException] {
    $resp = $_.Exception.Response
    if ($null -eq $resp) { throw }
  }
  try {
    $loc = [string]$resp.Headers['Location']
    return @{ Status = [int]$resp.StatusCode; Location = $loc; Bytes = [int]$resp.ContentLength }
  } finally { $resp.Close() }
}
function Get-Html([string]$Url) {
  $r = Invoke-WebRequest -Uri $Url -UseBasicParsing
  # Decodificar siempre como UTF-8, sin depender del charset que interprete PowerShell 5.1
  $bytes = $r.RawContentStream.ToArray()
  return [System.Text.Encoding]::UTF8.GetString($bytes)
}

$results = foreach ($route in $routes) {
  $s = Get-Status ($Base + $route)
  [pscustomobject]@{ Route = $route; Status = $s.Status }
}
Write-Host ($results | Format-Table -AutoSize | Out-String)
$bad = @($results | Where-Object Status -ne 200)
if ($bad.Count -gt 0) { throw "$($bad.Count) routes failed" }

# Redirecciones
$redirects = @{
  '/piscinas' = '/piscinas/'
  '/contacto/' = '/cotizar/'
  '/servicios/piscinas/' = '/piscinas/'
  '/sitemap.php' = '/sitemap.xml'
}
foreach ($from in $redirects.Keys) {
  $s = Get-Status ($Base + $from)
  if ($s.Status -ne 301 -or -not $s.Location.EndsWith($redirects[$from])) { throw "Expected 301 $from -> $($redirects[$from]), got $($s.Status) $($s.Location)" }
}
if ((Get-Status ($Base + '/no-existe/')).Status -ne 404) { throw 'Unknown route must return 404' }
if ((Get-Status ($Base + '/app/content.php')).Status -ne 404) { throw 'app/ must not be served' }

# Guardrails por pagina: un solo H1, lang, canonical, sin avisos PHP, sin textos internos
foreach ($route in ($routes | Where-Object { $_ -notmatch '\.(xml|txt)$' })) {
  $html = Get-Html ($Base + $route)
  if (($html | Select-String -Pattern '<h1' -AllMatches).Matches.Count -ne 1) { throw "$route must contain exactly one H1" }
  if ($html -notmatch '<html lang="es-PY">') { throw "$route language declaration missing" }
  if ($html -notmatch '<link rel="canonical" href="https://obra\.com\.py') { throw "$route canonical missing" }
  if ($html -match 'Warning:|Notice:|Deprecated:|Fatal error|Parse error') { throw "$route contains a PHP warning" }
  if ($html -match 'Pendiente de configuraci|pendiente de configuraci|antes de publicar|antes del lanzamiento') { throw "$route leaks internal setup copy" }
  if ($html -match '595XXXXXXXX|0981 000 000</a>|RUC 80000000') { throw "$route possible fabricated public contact data" }
  if ($html -match 'plataforma t.cnica|profesionales independientes') { throw "$route legacy marketplace copy found" }
}
$homeHtml = Get-Html ($Base + '/')
if ($homeHtml -match '<meta name="robots" content="noindex') { throw 'Homepage contains noindex' }
if ($homeHtml -notmatch '"@type":"GeneralContractor"') { throw 'GeneralContractor schema missing on home' }
if ($homeHtml -notmatch '"@type":"FAQPage"') { throw 'FAQ schema missing on home' }
$service = Get-Html ($Base + '/piscinas/')
if ($service -notmatch 'piscinas de hormig') { throw 'Service route content mismatch' }
if ($service -notmatch '"@type":"FAQPage"') { throw 'FAQ schema missing on service route' }
if ($service -notmatch '"@type":"Service"') { throw 'Service schema missing on service route' }
if ($service -notmatch '"@type":"BreadcrumbList"') { throw 'Breadcrumb schema missing on service route' }
$thanks = Get-Html ($Base + '/gracias/')
if ($thanks -notmatch '<meta name="robots" content="noindex') { throw '/gracias/ must be noindex' }

# Sitemap dinamico y robots
$sitemap = Get-Html ($Base + '/sitemap.xml')
if ($sitemap -notmatch '<urlset') { throw 'Sitemap is not an urlset' }
if ($sitemap -match 'gracias') { throw 'Sitemap must not list /gracias/' }
foreach ($route in ($routes | Where-Object { $_ -notmatch '\.(xml|txt)$' -and $_ -ne '/gracias/' })) {
  if ($sitemap -notmatch ('<loc>https://obra\.com\.py' + [regex]::Escape($route) + '</loc>')) { throw "Sitemap missing $route" }
}
$robots = Get-Html ($Base + '/robots.txt')
if ($robots -notmatch 'Sitemap: https://obra\.com\.py/sitemap\.xml') { throw 'robots.txt sitemap line missing' }

# Formulario: metodo, honeypot y validacion
if ((Get-Status ($Base + '/form.php')).Status -ne 405) { throw 'form.php must reject GET with 405' }
function Post-Form([string]$Url, [string]$Body) {
  $req = [System.Net.HttpWebRequest]::Create($Url)
  $req.AllowAutoRedirect = $false
  $req.Method = 'POST'
  $req.ContentType = 'application/x-www-form-urlencoded'
  $bytes = [System.Text.Encoding]::UTF8.GetBytes($Body)
  $req.ContentLength = $bytes.Length
  $stream = $req.GetRequestStream(); $stream.Write($bytes, 0, $bytes.Length); $stream.Close()
  try { $resp = $req.GetResponse() } catch [System.Net.WebException] { $resp = $_.Exception.Response; if ($null -eq $resp) { throw } }
  try { return @{ Status = [int]$resp.StatusCode; Location = [string]$resp.Headers['Location'] } } finally { $resp.Close() }
}
$stale = Post-Form ($Base + '/form.php') 'name=x&started_at=1'
if ($stale.Status -ne 303 -or $stale.Location -notmatch 'error=tiempo') { throw 'form.php must bounce a stale submission back with error=tiempo' }
$ts = [int][double]::Parse((Get-Date -UFormat %s)) - 10
$empty = Post-Form ($Base + '/form.php') ("name=x&started_at=" + $ts)
if ($empty.Status -ne 303 -or $empty.Location -notmatch 'error=campos') { throw 'form.php must bounce an incomplete submission back with error=campos' }
$ok = Post-Form ($Base + '/form.php') ("name=QA&phone=0981123456&service=casas&location=Luque&terrain=si&financing=propios&consent=1&message=Prueba+automatica+de+veinte+caracteres+o+mas&started_at=" + $ts)
if ($ok.Status -ne 303 -or ($ok.Location -notmatch '^https://wa\.me/' -and $ok.Location -notmatch '/gracias/')) { throw "form.php valid submission must redirect to WhatsApp or /gracias/, got $($ok.Status) $($ok.Location)" }

Write-Host "Routes checked: $($routes.Count). Guardrails passed."
