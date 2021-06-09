drop database attendances;

CREATE DATABASE IF NOT EXISTS attendances;	

USE attendances;

CREATE TABLE users (
 fn INT,
 email VARCHAR(255) UNIQUE,
 name VARCHAR(255),
 username VARCHAR(255) NOT NULL UNIQUE,
 year INT,
 yeargroup INT,
 faculty  VARCHAR(255),
 spec VARCHAR(255),
 pass VARCHAR(255),
 role VARCHAR(255),
 PRIMARY KEY (username)
);

CREATE TABLE userAttends (
 username VARCHAR(255),
 courseID INT,
 mandatory INT,
 PRIMARY KEY (username, courseID)
);


CREATE TABLE attendanceCheck (
 checkID INT NOT NULL UNIQUE AUTO_INCREMENT,
 checktime DATETIME NOT NULL,
 eventID INT,
 courseID INT,
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

drop table `events`;

CREATE TABLE events(
  id INT NOT NULL UNIQUE AUTO_INCREMENT,
  eventDate date NOT NULL,
  topic VARCHAR(255),
  courseID INT,
  PRIMARY KEY (id)
);

CREATE TABLE subevents(
	eventID INT NOT NULL,
  	startTime DATETIME NOT NULL,
  	endTime DATETIME NOT NULL,
	topic VARCHAR(255),
	PRIMARY KEY(eventID, topic)
);

insert into subevents(eventID,startTime,endTime,topic) values(2,"2021-02-06 08:36:00","2021-02-06 08:42:00","fuck");
insert into subevents(eventID,startTime,endTime,topic) values(2,"2021-02-06 08:42:00","2021-02-06 08:48:00","fuck2");

INSERT INTO courses(name) VALUES
	("Web технологии, летен семестър 2020/2021 "),
	("Фрактали, летен семестър 2020/2021 "),
	("Интернет на нещата, летен семестър 2020/2021 "),
	("Анализ на софтуерните изисквания, летен семестър 2020/2021");


INSERT INTO userattends(username, courseID, mandatory) VALUES
	("62351", 1, 1),
	("62351", 4, 0),
	("62351", 3, 0),
	("62330", 1, 1),
	("62330", 3, 0),
	("62330", 2, 0),
	("62323", 1, 1),
	("62323", 2, 0),
	("62281", 1, 1),
	("62281", 4, 0);

INSERT INTO userattends(username, courseID, mandatory) VALUES
	("milen", 1, 1),
	("milko", 2, 1),
	("irena", 4, 1),
	("stoqn", 3, 1);
