param(
  [string]$Destination = (Join-Path (Split-Path $PSScriptRoot -Parent | Split-Path -Parent) ("obra-com-py-hostinger-ready-" + (Get-Date -Format 'yyyy-MM-dd') + ".zip"))
)
# Empaqueta el sitio para subir a public_html/ de Hostinger.
# Usa siempre "/" como separador en las entradas del zip: con "\" Linux crea archivos
# llamados literalmente "includes\config.php" y el sitio devuelve 500.
$ErrorActionPreference = 'Stop'
$siteRoot = (Split-Path $PSScriptRoot -Parent)
$workspaceRoot = (Split-Path $siteRoot -Parent)
$destinationPath = [System.IO.Path]::GetFullPath($Destination)
if (-not $destinationPath.StartsWith([System.IO.Path]::GetFullPath($workspaceRoot), [StringComparison]::OrdinalIgnoreCase)) {
  throw 'Destination must remain inside the workspace.'
}
$files = @(
  '.htaccess', 'favicon.svg', 'form.php', 'index.php', 'robots.txt', 'sitemap.php',
  'app/content.php', 'app/helpers.php', 'app/layout.php', 'app/pages.php', 'app/routes.php',
  'config/site.php', 'config/local.example.php',
  'assets/css/site.css', 'assets/js/site.js',
  'assets/images/hero-casa.webp', 'assets/images/og-obra.jpg', 'assets/images/servicio-cochera.webp',
  'assets/images/servicio-piscina.webp', 'assets/images/servicio-quincho.webp'
)
# Contenido partido por archivo: app/content/sub/{hub}.php y app/content/guides/{slug}.php (y app/wa-messages.php si existe).
foreach ($dir in @('app/content/sub', 'app/content/guides')) {
  $full = Join-Path $siteRoot ($dir -replace '/', [System.IO.Path]::DirectorySeparatorChar)
  if (-not (Test-Path -LiteralPath $full -PathType Container)) { throw "Missing content folder: $dir" }
  foreach ($item in (Get-ChildItem -LiteralPath $full -Filter '*.php' | Sort-Object Name)) { $files += "$dir/$($item.Name)" }
}
foreach ($optional in @('app/wa-messages.php')) {
  if (Test-Path -LiteralPath (Join-Path $siteRoot ($optional -replace '/', [System.IO.Path]::DirectorySeparatorChar))) { $files += $optional }
}
# Nunca empaquetar: sitemap.xml estatico (taparia a sitemap.php), config/local.php (datos reales), router.php (solo local).
foreach ($forbidden in @('sitemap.xml', 'config/local.php', 'router.php', '.env')) {
  if ($files -contains $forbidden) { throw "Refusing to package $forbidden" }
}
if (Test-Path -LiteralPath (Join-Path $siteRoot 'sitemap.xml')) {
  throw 'A static sitemap.xml exists in the site root. Delete it: Apache would serve it instead of the dynamic sitemap.php.'
}
Add-Type -AssemblyName System.IO.Compression
Add-Type -AssemblyName System.IO.Compression.FileSystem
if (Test-Path -LiteralPath $destinationPath) { Remove-Item -LiteralPath $destinationPath -Force }
$stream = [System.IO.File]::Open($destinationPath, [System.IO.FileMode]::CreateNew)
try {
  $archive = [System.IO.Compression.ZipArchive]::new($stream, [System.IO.Compression.ZipArchiveMode]::Create, $false)
  try {
    foreach ($relative in $files) {
      $source = Join-Path $siteRoot ($relative -replace '/', [System.IO.Path]::DirectorySeparatorChar)
      if (-not (Test-Path -LiteralPath $source -PathType Leaf)) { throw "Missing package file: $relative" }
      [System.IO.Compression.ZipFileExtensions]::CreateEntryFromFile($archive, $source, $relative, [System.IO.Compression.CompressionLevel]::Optimal) | Out-Null
    }
  } finally { $archive.Dispose() }
} finally { $stream.Dispose() }
# Verificacion: ninguna entrada con backslash
$check = [System.IO.Compression.ZipFile]::OpenRead($destinationPath)
try {
  $bad = @($check.Entries | Where-Object { $_.FullName -like '*\*' })
  if ($bad.Count -gt 0) { throw "Zip contains backslash entries: $($bad.FullName -join ', ')" }
  Write-Output ("Entries: " + $check.Entries.Count)
} finally { $check.Dispose() }
Write-Output $destinationPath
