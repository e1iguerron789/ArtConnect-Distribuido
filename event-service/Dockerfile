FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev zip curl libpng-dev libonig-dev libxml2-dev libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip mbstring bcmath

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-interaction --prefer-dist

RUN mkdir -p storage bootstrap/cache \
  && chmod -R 775 storage bootstrap/cache || true

EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000
