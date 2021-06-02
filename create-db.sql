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
 courseID VARCHAR(255),
 mandatory INT,
 PRIMARY KEY (username, courseID)
);


CREATE TABLE attendanceCheck (
 checkID INT NOT NULL UNIQUE AUTO_INCREMENT,
 checktime DATETIME NOT NULL,
 eventName VARCHAR(255),
 course VARCHAR(255),
 PRIMARY KEY (checkID)
);

CREATE TABLE peopleAtEventCheck (
 attendanceCheckID INT NOT NULL,
 username VARCHAR(255) NOT NULL,
 PRIMARY KEY (attendanceCheckID, username)
);

CREATE TABLE courses (
 id INT NOT NULL UNIQUE AUTO_INCREMENT,
 name VARCHAR(255),
 PRIMARY KEY (id)
);