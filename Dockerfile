FROM php:8.1-fpm as php

WORKDIR /srv/ioda

# install composer
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

# install the symfony cli
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony #this is v5 of the symphony cli, not symfony

# install php extensions
RUN apt-get update
RUN apt-get install -y libzip-dev
RUN docker-php-ext-install zip

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY ./composer.json ./
RUN composer install

ENTRYPOINT ["symfony", "server:start" ]





