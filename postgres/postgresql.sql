CREATE TABLE users (username varchar(20) PRIMARY KEY NOT NULL,
					password varchar(256) NOT NULL,
					email varchar(256) NOT NULL,
					name varchar(100),
					about text,
					path varchar(256));

CREATE TABLE projects (idProject bigserial PRIMARY KEY NOT NULL,
					   name varchar(50) NOT NULL,
					   description text,
					   private boolean NOT NULL,
					   license varchar(100) NOT NULL);

CREATE TABLE projectUsers (username varchar(20) NOT NULL,
						   idProject int NOT NULL,
						   owner boolean NOT NULL,
						   PRIMARY KEY(username, idProject));

CREATE TABLE skills (idSkill bigserial PRIMARY KEY NOT NULL,
					 skill varchar(100) NOT NULL);

CREATE TABLE userSkills (username varchar(20) NOT NULL,
						 idSkill int NOT NULL,
						 PRIMARY KEY(username, idSkill));

CREATE TABLE projectSkills (idProject int NOT NULL,
							idSkill int NOT NULL,
							PRIMARY KEY(idProject, idSkill));

CREATE TABLE genres (idGenre bigserial PRIMARY KEY NOT NULL,
					 genre varchar(100) NOT NULL);

CREATE TABLE projectGenres (idProject int NOT NULL,
							idGenre int NOT NULL,
							PRIMARY KEY(idProject, idGenre));

CREATE TABLE userImageFiles (username varchar(20) NOT NULL,
							 path varchar(256) NOT NULL,
							 PRIMARY KEY(username, path));

CREATE TABLE userMusicFiles (username varchar(20) NOT NULL,
							 path varchar(256) NOT NULL,
							 name varchar(256),
							 extension varchar(10),
							 PRIMARY KEY(username, path));