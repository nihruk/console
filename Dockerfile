FROM php:8.1-fpm as php

WORKDIR /srv/ioda

# install composer
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

# install the symfony cli
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony #this is v5 of the symphony cli, not symfony

# install php extensions @todo keeping this readable for now, but optimisation will be needed, see https://github.com/nihruk/console/issues/75
RUN apt-get update
RUN apt-get install -y libzip-dev gnupg2 wget
RUN docker-php-ext-install zip

# set up the microsoft repo
RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add -
RUN curl https://packages.microsoft.com/config/debian/10/prod.list > /etc/apt/sources.list.d/mssql-release.list

# install MSSQL drivers
RUN apt-get update && ACCEPT_EULA=Y apt-get install -y unixodbc-dev msodbcsql18
RUN pecl install sqlsrv
RUN pecl install pdo_sqlsrv

#enable mssql extensions
RUN docker-php-ext-enable sqlsrv
RUN echo "extension=pdo_sqlsrv.so" >> /usr/local/etc/php/conf.d/docker_pdo_sqlsrv.ini
RUN echo "pdo_sqlsrv.pooling_enabled = 0" >> /usr/local/etc/php/conf.d/docker_pdo_sqlsrv.ini

#enable opcache
RUN docker-php-ext-enable opcache

#configure opcache with recommended general settings as per symfony performance docs
RUN echo "opcache.memory_consumption=256" >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini
RUN echo "opcache.interned_strings_buffer=8" >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini
RUN echo "opcache.max_accelerated_files=20000" >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini
RUN echo "opcache.revalidate_freq=60" >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini
RUN echo "opcache.enable_cli=1" >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini

#enable jit
RUN echo "opcache.jit_buffer_size=100M" >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini



ENV COMPOSER_ALLOW_SUPERUSER=1

# @todo we aim to load these stages in paralell, see https://github.com/nihruk/console/issues/75
FROM mcr.microsoft.com/mssql/server:2017-latest as mssql

ENV SA_PASSWORD = "Ff4rtB4gsFTWasl0IH8s3qu3ls3"
ENV MSSQL_SA_PASSWORD = "Ff4rtB4gsFTWasl0IH8s3qu3ls3"
ENV ACCEPT_EULA=y

RUN mkdir -m 770 -p /var/opt/mssql
RUN mkdir /usr/src/sql

COPY tests/assets/mssql/init/setupTestDB.sql /usr/src/sql
COPY tests/assets/mssql/mssql.conf var/opt/mssql



