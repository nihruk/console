FROM php:8.1-fpm-alpine as upstream
FROM mlocati/php-extension-installer:2 AS php_extension_installer
FROM composer:latest AS composer_upstream


FROM upstream as installers_build
RUN apk add --no-cache curl gnupg bash

# download mssql packages
RUN curl -O https://download.microsoft.com/download/3/5/5/355d7943-a338-41a7-858d-53b259ea33f5/msodbcsql18_18.3.1.1-1_amd64.apk
RUN curl -O https://download.microsoft.com/download/3/5/5/355d7943-a338-41a7-858d-53b259ea33f5/mssql-tools18_18.3.1.1-1_amd64.apk

# verify mssql packages
RUN curl -O https://download.microsoft.com/download/3/5/5/355d7943-a338-41a7-858d-53b259ea33f5/msodbcsql18_18.3.1.1-1_amd64.sig
RUN curl -O https://download.microsoft.com/download/3/5/5/355d7943-a338-41a7-858d-53b259ea33f5/mssql-tools18_18.3.1.1-1_amd64.sig
RUN curl https://packages.microsoft.com/keys/microsoft.asc  | gpg --import -
RUN gpg --verify msodbcsql18_18.3.1.1-1_amd64.sig msodbcsql18_18.3.1.1-1_amd64.apk
RUN gpg --verify mssql-tools18_18.3.1.1-1_amd64.sig mssql-tools18_18.3.1.1-1_amd64.apk

# install symfony cli
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony #this is v5 of the symphony cli, not symfony


# the base php image for both prod and dev environments
FROM upstream as base
WORKDIR /opt

# alpine packages common to all environments - use no-cache instead of APK update
RUN apk add --no-cache fcgi git file acl gettext

# copy the verified mssql odbc installers from previous stage
COPY --from=installers_build --link /var/www/html/msodbcsql18_18.3.1.1-1_amd64.apk .
COPY --from=installers_build --link /var/www/html/mssql-tools18_18.3.1.1-1_amd64.apk .

# install mssql packages
RUN apk add --allow-untrusted msodbcsql18_18.3.1.1-1_amd64.apk  mssql-tools18_18.3.1.1-1_amd64.apk

# install a base set of php extensions for all environments
# using https://hub.docker.com/r/mlocati/php-extension-installer \
WORKDIR /usr/bin/
COPY --from=php_extension_installer --link /usr/bin/install-php-extensions .
RUN set -euxo pipefail;   \
    install-php-extensions \
        opcache \
        sqlsrv \
    ;

# add composer
COPY --from=composer_upstream /usr/bin/composer /usr/bin/composer


FROM base as php_dev

ENV COMPOSER_ALLOW_SUPERUSER=1


# add config to set up JIT and opchache
COPY docker/php/opcache_jit_dev.ini /usr/local/etc/php/conf.d

# copy in the symfony cli
WORKDIR /usr/local/
COPY --from=installers_build --link /usr/local/bin/symfony bin/

# start symfony's built in webserver
ENTRYPOINT ["symfony", "server:start" ]