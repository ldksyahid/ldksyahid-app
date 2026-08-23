#!/usr/bin/env bash
#
# Dijalankan DI SERVER PRODUCTION oleh GitHub Actions (lihat .github/workflows/deploy-production.yml).
# Bisa juga dijalankan manual oleh admin untuk test/rollback-check:
#   bash deploy-remote.sh /home/ldksyah1/public_html
#
set -euo pipefail

DEPLOY_PATH="${1:?Usage: deploy-remote.sh <path-to-deployment>}"
PHP_BIN="${PHP_BIN:-php}"
COMPOSER_BIN="${COMPOSER_BIN:-composer}"
HEALTHCHECK_URL="${HEALTHCHECK_URL:-https://ldksyah.id}"

log() { echo "[deploy] $(date '+%Y-%m-%d %H:%M:%S') - $*"; }
fail() { log "FAILED: $*"; exit 1; }

cd "$DEPLOY_PATH" || fail "cannot cd to $DEPLOY_PATH"

log "Step 0/6: Pre-flight checks"
git rev-parse --is-inside-work-tree > /dev/null 2>&1 || fail "$DEPLOY_PATH is not a git repository"
[ -f .env ] || fail ".env not found before deployment even started — aborting to avoid masking a bigger problem"

CURRENT_BRANCH="$(git branch --show-current)"
if [ "$CURRENT_BRANCH" != "main" ]; then
  fail "production branch is '$CURRENT_BRANCH', expected 'main'. Selesaikan Phase 1 (switch ke main) secara manual dulu sebelum pipeline ini dipakai."
fi

log "Step 1/6: Fetch & sync source code to origin/main"
git fetch origin main || fail "git fetch origin main failed"
BEFORE_COMMIT="$(git rev-parse HEAD)"
git reset --hard origin/main || fail "git reset --hard origin/main failed"
AFTER_COMMIT="$(git rev-parse HEAD)"
log "Source synced: $BEFORE_COMMIT -> $AFTER_COMMIT"

log "Step 2/6: Install PHP dependencies (production, no-dev)"
"$COMPOSER_BIN" install --no-dev --optimize-autoloader --no-interaction || fail "composer install failed"

log "Step 3/6: Run database migrations"
"$PHP_BIN" artisan migrate --force || fail "php artisan migrate --force failed"

log "Step 4/6: Run kirimdev account status check"
"$PHP_BIN" artisan kirimdev:check-account-status || fail "php artisan kirimdev:check-account-status failed"

log "Step 5/6: Clear cached config/route/view (does NOT touch .env)"
"$PHP_BIN" artisan optimize:clear || fail "php artisan optimize:clear failed"

log "Step 6/6: Verification"
LOCAL_HEAD="$(git rev-parse HEAD)"
REMOTE_HEAD="$(git rev-parse origin/main)"
[ "$LOCAL_HEAD" = "$REMOTE_HEAD" ] || fail "HEAD mismatch after deploy: local=$LOCAL_HEAD remote=$REMOTE_HEAD"
[ -f .env ] || fail ".env missing AFTER deployment! Investigate immediately, do not assume deploy succeeded."

if command -v curl > /dev/null 2>&1; then
  HTTP_CODE="$(curl -s -o /dev/null -w '%{http_code}' --max-time 15 "$HEALTHCHECK_URL" || echo "000")"
  if [ "$HTTP_CODE" -ge 200 ] 2>/dev/null && [ "$HTTP_CODE" -lt 400 ] 2>/dev/null; then
    log "Healthcheck OK: $HEALTHCHECK_URL responded HTTP $HTTP_CODE"
  else
    log "WARNING: healthcheck to $HEALTHCHECK_URL responded HTTP $HTTP_CODE (deploy not rolled back automatically — check manually)"
  fi
else
  log "curl not available, skipping HTTP healthcheck"
fi

log "Deployment SUCCESS - commit $LOCAL_HEAD is now live at $DEPLOY_PATH"
