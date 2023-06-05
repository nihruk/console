FROM php:8.1-fpm
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer