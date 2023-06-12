#!/usr/bin/env bash

# clear the cache which we couldn't run during the build
# php bin/console cache:clear

docker compose up --build
docker exec  ioda_php composer run test


#exec "$@"