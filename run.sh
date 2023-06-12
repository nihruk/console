#!/usr/bin/env bash

docker compose up --build -d
docker exec  ioda_php composer run test

#exec "$@"