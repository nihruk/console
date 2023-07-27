apt-get install apt-utils
apt-get install wget
wget https://github.com/microsoft/mssql-jdbc/releases/download/v12.2.0/mssql-jdbc-12.2.0.jre8.jar -O mssql-jdbc-12.2.0.jre8.jar
mv /usr/share/logstash/mssql-jdbc-12.2.0.jre8.jar /usr/share/logstash/drv/mssql-jdbc-12.2.0.jre8.jar
chmod 0444 /usr/share/logstash/drv/mssql-jdbc-12.2.0.jre8.jar
logstash
done