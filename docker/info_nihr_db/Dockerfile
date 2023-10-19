# @todo we aim to load these stages in paralell, see https://github.com/nihruk/console/issues/75
FROM mcr.microsoft.com/mssql/server:2017-latest as mssql

ENV SA_PASSWORD = "Ff4rtB4gsFTWasl0IH8s3qu3ls3"
ENV MSSQL_SA_PASSWORD = "Ff4rtB4gsFTWasl0IH8s3qu3ls3"
ENV ACCEPT_EULA=y

RUN mkdir -m 770 -p /var/opt/mssql
RUN mkdir /usr/src/sql

COPY tests/assets/mssql/init/setupTestDB.sql /usr/src/sql
COPY tests/assets/mssql/mssql.conf var/opt/mssql
