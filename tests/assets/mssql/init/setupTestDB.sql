DROP DATABASE IF EXISTS infonihr_test;
DROP USER IF EXISTS ioda ;
DROP LOGIN ioda;
GO


CREATE DATABASE infonihr_test;
GO

USE infonihr_test;

CREATE TABLE staff(
ID INT not null IDENTITY(1,1) PRIMARY KEY,
Name VARCHAR(40)  ,
Occupation  VARCHAR(40)
);

    INSERT INTO staff( name, occupation)
    VALUES ('Bob', 'Builder'), ('Lara', 'Tomb Raider'), ('Pat', 'Postman'), ('Dora', 'Explorer' )

GO

USE [master]
GO
CREATE LOGIN [ioda] WITH PASSWORD=N'g4t3sC4n34tMySh0rtz', DEFAULT_DATABASE=[infonihr_test]
ALTER SERVER ROLE [dbcreator] ADD MEMBER [ioda]
GO

USE [infonihr_test]
GO
CREATE USER [ioda] FOR LOGIN [ioda] WITH DEFAULT_SCHEMA=[dbo]
ALTER ROLE [db_owner] ADD MEMBER [ioda]
GO
