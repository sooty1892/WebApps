CREATE TABLE chat (
idmessage bigserial PRIMARY KEY,
idproject int,
datesent timestamp,
username varchar(20),
message text);

CREATE TABLE following (
follower varchar(20),
followee varchar(20),
PRIMARY KEY(follower, followee)
);


CREATE TABLE genres (idGenre bigserial PRIMARY KEY NOT NULL,
					 genre varchar(100) NOT NULL);

CREATE TABLE notifications (
usersend varchar(20),
useraccept varchar(20),
idproject int,
description text,
PRIMARY KEY (usersend, useraccept, idproject)
);

CREATE TABLE projectGenres (idProject int NOT NULL,
							idGenre int NOT NULL,
							PRIMARY KEY(idProject, idGenre));

CREATE TABLE projects (idProject bigserial PRIMARY KEY NOT NULL,
					   name varchar(100) NOT NULL,
					   description text,
					   private boolean NOT NULL,
					   license varchar(100) NOT NULL,
					   datecreated timestamp,
					   sectionorder varchar(256));

CREATE TABLE projectSkills (idProject int NOT NULL,
							idSkill int NOT NULL,
							PRIMARY KEY(idProject, idSkill));


CREATE TABLE projectUsers (username varchar(20) NOT NULL,
						   idProject int NOT NULL,
						   owner boolean NOT NULL,
						   PRIMARY KEY(username, idProject));

CREATE TABLE raters(
	idmusic int,
	username varchar(20),
	rated boolean,
	PRIMARY KEY(idmusic, username)
);

CREATE TABLE sectionmusic(
	idmusic bigserial PRIMARY KEY,
	idsection int,
	path varchar(256),
	name varchar(256),
	extension varchar(10),
	username varchar(20),
	chosen boolean,
	dateadded timestamp
);


CREATE TABLE sections(
	idsection bigserial PRIMARY KEY,
	description text,
	name varchar(100),
	idproject int
);

CREATE TABLE skills (idSkill bigserial PRIMARY KEY NOT NULL,
					 skill varchar(100) NOT NULL);

CREATE TABLE userImageFiles (username varchar(20) NOT NULL,
							 path varchar(256) NOT NULL,
							 PRIMARY KEY(username, path));

CREATE TABLE userMusicFiles (username varchar(20) NOT NULL,
							 path varchar(256) NOT NULL,
							 name varchar(256),
							 PRIMARY KEY(username, path));



CREATE TABLE users (username varchar(20) PRIMARY KEY NOT NULL,
					password varchar(256) NOT NULL,
					email varchar(256) NOT NULL,
					name varchar(100),
					about text,
					path varchar(256));



CREATE TABLE userSkills (username varchar(20) NOT NULL,
						 idSkill int NOT NULL,
						 PRIMARY KEY(username, idSkill));





