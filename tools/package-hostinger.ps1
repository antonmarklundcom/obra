# Empaqueta el sitio para public_html/ (la logica vive en package.mjs, multiplataforma).
node (Join-Path $PSScriptRoot 'package.mjs') @args; exit $LASTEXITCODE
