FROM php:8.1-fpm as php8

WORKDIR /srv/ioda

# install composer
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer


## these files are needed at build time so copy them now @todo tidyup
#COPY composer.json composer.lock symfony.lock docker_start.sh ./

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
ENV PATH="${PATH}:/srv/ioda/vendor/bin"



# run a bash script to clear the cache
#RUN ./docker_start.sh


