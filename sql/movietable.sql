# Code to create a simple movie table

CREATE TABLE movie (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	moviename TEXT,
	moviedate DATE NOT NULL
) DEFAULT CHARACTER SET utf8;


# Adding jokes to the table

INSERT INTO movie SET
moviename = 'Inception',
moviedate = '2009-04-01';

INSERT INTO movie
(moviename, moviedate) VALUES (
'Spy',
"2009-04-02"
);