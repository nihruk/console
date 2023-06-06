FROM php:8.1-fpm

# install composer
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer
# these files are needed at build time so copy them now
COPY composer.json composer.lock symfony.lock  ./

# install the symfony cli
RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

# install php extensions
RUN apt-get update
RUN apt-get install -y libzip-dev
RUN docker-php-ext-install zip

# install dependencies with composer, use noscripts flag to prevent the cache clearing causing falure #todo investigate
RUN composer install --no-scripts
#RUN ["bin/console cache:clear"]

# start the symfony binary webserver
CMD  ["symfony", "local:server:start" , "--port=8000", "--no-tls"]