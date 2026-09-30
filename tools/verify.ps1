# Puerta de calidad local (Windows). Requiere PHP 8.1+ (C:\php) y Node 20+.
# Uso: powershell -ExecutionPolicy Bypass -File tools\verify.ps1 [-SkipPw]
param([switch]$SkipPw)
$ErrorActionPreference = 'Stop'
if (Test-Path 'C:\php\php.exe') { $env:Path = "C:\php;$env:Path" }
Push-Location $PSScriptRoot
try {
  if (-not (Test-Path 'node_modules\playwright')) {
    npm install --no-fund --no-audit
    npx playwright install chromium
  }
  $verifyArgs = @()
  if ($SkipPw) { $verifyArgs += '--skip-pw' }
  node verify.mjs @verifyArgs
  exit $LASTEXITCODE
} finally { Pop-Location }
