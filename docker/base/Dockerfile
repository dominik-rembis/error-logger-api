FROM php:8.1.8-apache-buster AS error-logger-api-base

WORKDIR /var/www/error-logger-api/

RUN a2enmod rewrite

RUN apt update && apt install -y unzip libicu-dev libxml2-dev

RUN docker-php-ext-install opcache intl pdo xml pdo_mysql
RUN docker-php-ext-enable pdo_mysql

COPY --from=composer:2.3.9 /usr/bin/composer /usr/bin/composer