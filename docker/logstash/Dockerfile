ARG STACK_VERSION

FROM docker.elastic.co/logstash/logstash:${STACK_VERSION}
USER root
RUN apt-get install apt-utils
RUN apt-get install wget
RUN wget https://github.com/microsoft/mssql-jdbc/releases/download/v12.2.0/mssql-jdbc-12.2.0.jre8.jar -O /mssql-jdbc-12.2.0.jre8.jar
RUN chmod 777 /mssql-jdbc-12.2.0.jre8.jar
RUN mkdir -p /usr/share/logstash/drv
RUN mv /mssql-jdbc-12.2.0.jre8.jar /usr/share/logstash/drv/mssql-jdbc-12.2.0.jre8.jar
RUN chmod 0444 /usr/share/logstash/drv/mssql-jdbc-12.2.0.jre8.jar

ENTRYPOINT logstash