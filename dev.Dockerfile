FROM php:8.1-fpm

RUN apt-get update && apt-get install -y --no-install-recommends \
    curl git wget zip unzip libzip-dev libxml2-dev libpng-dev \
    && docker-php-ext-install pdo_mysql soap zip opcache gd intl

RUN pecl install xdebug && docker-php-ext-enable xdebug

