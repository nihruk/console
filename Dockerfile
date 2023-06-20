FROM php:8.1-fpm as php

WORKDIR /srv/ioda

# install composer
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

# install the symfony cli
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony #this is v5 of the symphony cli, not symfony

# install php extensions @todo we're keeping this readable during development but all the extensions install steps need to be optimised into 1 RUN layer.
RUN apt-get update
RUN apt-get install -y libzip-dev gnupg2 wget
RUN docker-php-ext-install zip

# set up the microsoft repo
RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add -
RUN curl https://packages.microsoft.com/config/debian/10/prod.list > /etc/apt/sources.list.d/mssql-release.list

# install MSSQL drivers
RUN apt-get update && ACCEPT_EULA=Y apt-get install -y unixodbc-dev msodbcsql18 # @todo not sure we need unixodbc-dev
#RUN wget https://pecl.php.net/get/sqlsrv-5.11.tgz
RUN pecl install sqlsrv
RUN pecl install pdo_sqlsrv


#enable mssql extensions
RUN docker-php-ext-enable sqlsrv

#RUN docker-php-ext-enable pdo_sqlsrv
RUN echo "extension=pdo_sqlsrv.so" >> /usr/local/etc/php/conf.d/docker_pdo_sqlsrv.ini
RUN echo "pdo_sqlsrv.pooling_enabled = 0" >> /usr/local/etc/php/conf.d/docker_pdo_sqlsrv.ini





ENV COMPOSER_ALLOW_SUPERUSER=1


ENTRYPOINT ["symfony", "server:start" ]

# @todo we should be able to load these stages in paralell
FROM mcr.microsoft.com/mssql/server:2019-latest as mssql


ENV SA_PASSWORD = "password1234LoL"
ENV ACCEPT_EULA=y

RUN mkdir -m 770 -p /var/opt/mssql



