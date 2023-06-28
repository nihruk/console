CREATE DATABASE infonihr;
GO

USE infonihr;

CREATE TABLE staff(
ID INT not null IDENTITY(1,1) PRIMARY KEY,
Name VARCHAR(40)  ,
Occupation  VARCHAR(40)
);

    INSERT INTO staff( name, occupation)
    VALUES ('Bob', 'Builder'), ('Lara', 'Tomb Raider'), ('Pat', 'Postman'), ('Dora', 'Explorer' )

GO