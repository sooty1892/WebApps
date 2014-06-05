CREATE TABLE users (idUser bigserial PRIMARY KEY NOT NULL,
					username varchar(20) NOT NULL,
					password varchar(256) NOT NULL,
					name varchar(100),
					email varchar(256) NOT NULL);

CREATE TABLE projects (idProject bigserial PRIMARY KEY NOT NULL,
					   name varchar(50),
					   description text,
					   completed boolean NOT NULL);

CREATE TABLE projectUsers (idUser int NOT NULL,
						   idProject int NOT NULL,
						   owner boolean NOT NULL,
						   PRIMARY KEY(idUser, idProject));

CREATE TABLE skillList (idSkill bigserial PRIMARY KEY NOT NULL,
						skill varchar(100) NOT NULL);

CREATE TABLE userSkills (idUser int NOT NULL,
						 idSkill int NOT NULL,
						 PRIMARY KEY(idUser, idSkill));

CREATE TABLE genreList (idGenre bigserial PRIMARY KEY NOT NULL,
						genre varchar(100) NOT NULL);

CREATE TABLE projectGenres (idProject int NOT NULL,
							idGenre int NOT NULL,
							PRIMARY KEY(idProject, idGenre));

INSERT INTO skillList (skill) VALUES ('drums');
INSERT INTO skillList (skill) VALUES ('lyricist');
INSERT INTO skillList (skill) VALUES ('guitar');
INSERT INTO skillList (skill) VALUES ('vocals');
INSERT INTO skillList (skill) VALUES ('piano');
INSERT INTO skillList (skill) VALUES ('triangle');
INSERT INTO skillList (skill) VALUES ('massive');
INSERT INTO skillList (skill) VALUES ('sound engineer');
INSERT INTO skillList (skill) VALUES ('reason');
INSERT INTO skillList (skill) VALUES ('keyboard');
INSERT INTO skillList (skill) VALUES ('trombone');
INSERT INTO skillList (skill) VALUES ('album designer');
INSERT INTO skillList (skill) VALUES ('bagpipes');
INSERT INTO skillList (skill) VALUES ('banjo');
INSERT INTO skillList (skill) VALUES ('bass drum');
INSERT INTO skillList (skill) VALUES ('bassoon');
INSERT INTO skillList (skill) VALUES ('bell');
INSERT INTO skillList (skill) VALUES ('bongo');
INSERT INTO skillList (skill) VALUES ('castanets');
INSERT INTO skillList (skill) VALUES ('cello');
INSERT INTO skillList (skill) VALUES ('clarinet');
INSERT INTO skillList (skill) VALUES ('clavichord');
INSERT INTO skillList (skill) VALUES ('conga drum');
INSERT INTO skillList (skill) VALUES ('contrabassoon');
INSERT INTO skillList (skill) VALUES ('cornet');
INSERT INTO skillList (skill) VALUES ('cymbals');
INSERT INTO skillList (skill) VALUES ('double bass');
INSERT INTO skillList (skill) VALUES ('duclian');
INSERT INTO skillList (skill) VALUES ('dynamophone');
INSERT INTO skillList (skill) VALUES ('flute');
INSERT INTO skillList (skill) VALUES ('flutophone');
INSERT INTO skillList (skill) VALUES ('glockenspiel');
INSERT INTO skillList (skill) VALUES ('gongs');
INSERT INTO skillList (skill) VALUES ('guitar');
INSERT INTO skillList (skill) VALUES ('harmonica');
INSERT INTO skillList (skill) VALUES ('harp');
INSERT INTO skillList (skill) VALUES ('harpsichord');
INSERT INTO skillList (skill) VALUES ('lute');
INSERT INTO skillList (skill) VALUES ('mandolin');
INSERT INTO skillList (skill) VALUES ('maracas');
INSERT INTO skillList (skill) VALUES ('mettallophone');
INSERT INTO skillList (skill) VALUES ('musical box');
INSERT INTO skillList (skill) VALUES ('oboe');
INSERT INTO skillList (skill) VALUES ('recorder');
INSERT INTO skillList (skill) VALUES ('saxophone');
INSERT INTO skillList (skill) VALUES ('shawm');
INSERT INTO skillList (skill) VALUES ('snare drum');
INSERT INTO skillList (skill) VALUES ('steel drum');
INSERT INTO skillList (skill) VALUES ('tambourine');
INSERT INTO skillList (skill) VALUES ('theremin');
INSERT INTO skillList (skill) VALUES ('trombone');
INSERT INTO skillList (skill) VALUES ('trumpet');
INSERT INTO skillList (skill) VALUES ('tuba');
INSERT INTO skillList (skill) VALUES ('ukulele');
INSERT INTO skillList (skill) VALUES ('viola');
INSERT INTO skillList (skill) VALUES ('violin');
INSERT INTO skillList (skill) VALUES ('xylophone');
INSERT INTO skillList (skill) VALUES ('zither');
INSERT INTO skillList (skill) VALUES ('fl studio');
INSERT INTO skillList (skill) VALUES ('adobe audition');
INSERT INTO skillList (skill) VALUES ('ardour');
INSERT INTO skillList (skill) VALUES ('ableton live');
INSERT INTO skillList (skill) VALUES ('tuxguitar');
INSERT INTO skillList (skill) VALUES ('reaper');
INSERT INTO skillList (skill) VALUES ('garageband');
INSERT INTO skillList (skill) VALUES ('hydrogen');
INSERT INTO skillList (skill) VALUES ('rosegarden');
INSERT INTO skillList (skill) VALUES ('sony ascid pro');
INSERT INTO skillList (skill) VALUES ('avid pro tools');
INSERT INTO skillList (skill) VALUES ('logic pro');
INSERT INTO skillList (skill) VALUES ('qtractor');
INSERT INTO skillList (skill) VALUES ('linuxsampler');
INSERT INTO skillList (skill) VALUES ('denemo');
INSERT INTO skillList (skill) VALUES ('cubase');
INSERT INTO skillList (skill) VALUES ('openmpt');
INSERT INTO skillList (skill) VALUES ('audiotool');
INSERT INTO skillList (skill) VALUES ('traverso daw');
INSERT INTO skillList (skill) VALUES ('guitar rig');
INSERT INTO skillList (skill) VALUES ('studio one');
INSERT INTO skillList (skill) VALUES ('audiomulch');
INSERT INTO skillList (skill) VALUES ('cakewalk sonar');
INSERT INTO skillList (skill) VALUES ('ohm studio');
INSERT INTO skillList (skill) VALUES ('synthfont');