#!/usr/bin/env bash

# clear the cache which we couldn't run during the build
php bin/console cache:clear

# start the webserver
symfony server:start