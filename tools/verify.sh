#!/usr/bin/env bash
# Puerta de calidad local (Linux/macOS). Requiere PHP 8.1+ y Node 20+.
# Uso: bash tools/verify.sh [--skip-pw]
set -euo pipefail
cd "$(dirname "$0")"
[ -d node_modules/playwright ] || npm install --no-fund --no-audit
exec node verify.mjs "$@"
