#!/bin/sh
set -e

cd /var/www/html

# Create .env if missing
if [ ! -f .env ]; then
  cp -n .env.example .env 2>/dev/null || true
fi

# If using sqlite (default), ensure database file exists
DB_CONNECTION_ENV="${DB_CONNECTION:-}"
if [ -z "$DB_CONNECTION_ENV" ]; then
  if [ -f .env ]; then
    DB_CONNECTION_ENV=$(grep -E '^DB_CONNECTION=' .env | sed -e 's/DB_CONNECTION=//' -e 's/\"//g')
  fi
fi

if [ "$DB_CONNECTION_ENV" = "sqlite" ] || [ -z "$DB_CONNECTION_ENV" ]; then
  mkdir -p database
  if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
  fi
fi

# Ensure app key exists
if ! grep -qE '^APP_KEY=.+$' .env 2>/dev/null; then
  php artisan key:generate --force || true
fi

# Run migrations by default (can disable with RUN_MIGRATIONS=0)
if [ "${RUN_MIGRATIONS:-1}" = "1" ]; then
  # Generate tables for session/cache/queue if configured to use database
  php artisan session:table --no-interaction || true
  php artisan cache:table --no-interaction || true
  php artisan queue:table --no-interaction || true
  php artisan migrate --force || true
fi

exec php artisan serve --host=0.0.0.0 --port="${APP_PORT:-8000}"
