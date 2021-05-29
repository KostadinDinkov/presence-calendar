drop database attendances;

CREATE DATABASE IF NOT EXISTS attendances;	

USE attendances;

CREATE TABLE users (
 fn INT UNIQUE,
 email VARCHAR(255) UNIQUE,
 name VARCHAR(255),
 username VARCHAR(255) NOT NULL UNIQUE,
 year INT,
 yeargroup INT,
 spec VARCHAR(255),
 pass VARCHAR(255),
 role VARCHAR(255),
 PRIMARY KEY (username)
);

CREATE TABLE userAttends (
 username VARCHAR(255),
 class VARCHAR(255),
 PRIMARY KEY (username, class)
);


CREATE TABLE attendanceCheck (
 checkID INT NOT NULL UNIQUE AUTO_INCREMENT,
 checktime DATETIME NOT NULL,
 eventName VARCHAR(255),
 class VARCHAR(255),
 PRIMARY KEY (checkID)
);

CREATE TABLE peopleAtEvent (
 attendanceCheckID INT NOT NULL,
 username VARCHAR(255) NOT NULL,
 PRIMARY KEY (attendanceCheckID, username)
);