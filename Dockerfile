FROM php:8.1-fpm
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer
RUN composer install
#CMD ["/usr/local/bin/symfony", "local:server:start" , "--port=8000", "--no-tls"]