FROM composer:2 AS vendor
WORKDIR /app

# Copy only composer files first for better layer caching
COPY composer.json composer.lock ./

# Install PHP dependencies (no scripts because they expect full app)
RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --no-scripts

######################################################################
# Runtime image
######################################################################
FROM php:8.2-cli-alpine AS app

WORKDIR /var/www/html

# Required libs/exts for a basic Laravel app on sqlite
RUN apk add --no-cache \
      bash \
      sqlite sqlite-dev \
      oniguruma-dev \
    && docker-php-ext-install \
      pdo_sqlite \
      mbstring

# Copy application code
COPY . .

# Bring in vendor from composer stage
COPY --from=vendor /app/vendor ./vendor

# Ensure storage and cache are writable
RUN mkdir -p storage/framework/{cache,data,sessions,views} \
    && chmod -R 775 storage bootstrap/cache || true

# Entry script handles .env, key, sqlite DB, migrate, then serves
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENV APP_PORT=8000
EXPOSE 8000

ENTRYPOINT ["/entrypoint.sh"]

