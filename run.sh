#!/usr/bin/env bash

docker compose up --build
docker exec  ioda_php composer run test