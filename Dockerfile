FROM php:8.1-fpm
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer
COPY composer.json composer.lock symfony.lock  ./
RUN apt-get update
RUN apt-get install -y libzip-dev
RUN docker-php-ext-install zip
RUN composer install --no-scripts
#RUN ["bin/console cache:clear"]
CMD  ["/usr/bin/symfony", "local:server:start" , "--port=8000", "--no-tls"]