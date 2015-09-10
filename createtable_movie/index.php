<?php
$link = mysqli_connect('localhost', 'root', 'root');
if (!$link)
{
	$output = 'Unable to connect to the database server.';
	include 'output.html.php';
	exit();
}

if (!mysqli_set_charset($link, 'utf8'))
{
	$output = 'Unable to set database connection encoding.';
	include 'output.html.php';
	exit();
}

if (!mysqli_select_db($link, 'imdb_1'))
{
	$output = 'Unable to locate the movie database.';
	include 'output.html.php';
	exit();
}

$sql = 'CREATE TABLE movie (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			moviename TEXT,
			moviedate DATE NOT NULL,
			directorid INT
		) DEFAULT CHARACTER SET utf8';
if (!mysqli_query($link, $sql))
{
	$output = 'Error creating movie table: ' . mysqli_error($link);
	include 'output.html.php';
	//exit();
}
$output = 'Movie table successfully created.';
include 'output.html.php';


$sql = 'CREATE TABLE country (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(255)
		) DEFAULT CHARACTER SET utf8';
if (!mysqli_query($link, $sql))
{
	$output = 'Error creating country table: ' . mysqli_error($link);
	include 'output.html.php';
	//exit();
}

$output = 'Country table successfully created.';
include 'output.html.php';





$sql = 'CREATE TABLE director (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(255),
			country VARCHAR(255) 
		) DEFAULT CHARACTER SET utf8';
if (!mysqli_query($link, $sql))
{
	$output = 'Error creating director table: ' . mysqli_error($link);
	include 'output.html.php';
	//exit();
}
$output = 'Director table successfully created.';
include 'output.html.php';








$sql = 'CREATE TABLE moviecountry (
			movieid INT NOT NULL,
			countryid INT NOT NULL
		) DEFAULT CHARACTER SET utf8';
if (!mysqli_query($link, $sql))
{
	$output = 'Error creating moviecountry table: ' . mysqli_error($link);
	include 'output.html.php';
	//exit();
}
$output = 'Moviecountry table successfully created.';
include 'output.html.php';






?>
