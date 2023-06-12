FROM php:8.1-fpm as php8

WORKDIR /srv/ioda

# install composer
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

# these files are needed at build time so copy them now
COPY composer.json composer.lock symfony.lock docker_start.sh ./




#make sure docker_start.sh is executable
#RUN chmod +x docker_start.sh

# install the symfony cli
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony #this is v5 of the symphony cli, not symfony

# install php extensions
RUN apt-get update
RUN apt-get install -y libzip-dev
RUN docker-php-ext-install zip

ENV COMPOSER_ALLOW_SUPERUSER=1
#ENV PATH="${PATH}:/root/.composer/vendor/bin"

# install dependencies with composer, use noscripts flag to prevent the cache clearing causing falure
RUN composer install --no-scripts

# run a bash script to clear the cache
#RUN ./docker_start.sh
