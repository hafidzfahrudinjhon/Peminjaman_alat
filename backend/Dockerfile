FROM php:8.4-cli

RUN apt-get update && apt-get install -y libzip-dev zip unzip git && docker-php-ext-install pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --no-progress --no-scripts --optimize-autoloader

COPY . .
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache