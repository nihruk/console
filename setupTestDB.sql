CREATE DATABASE infonihr;
USE infonihr;

CREATE TABLE staff(
ID INT not null AUTO_INCREMENT,
Name VARCHAR(40)  ,
Occupation  VARCHAR(40),
PRIMARY KEY ID
);

    INSERT INTO staff( name, occupation)
    VALUES ('Bob', 'Builder', 'Lara', 'Tomb Raider', 'Pat', 'Postman', 'Dora', 'Explorer' )