<?php
//Display director 
include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';

if (isset($_GET['add']))
{
  $pageTitle = 'New Director';
  $action = 'addform';
  $name = '';
  $country = '';
  $id = '';
  $button = 'Add director';
  include 'form.html.php';
  exit(); 
}

if (isset($_GET['addform']))
{
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
  try {
    $sql = 'INSERT INTO director SET
        name = :name,
        country = :country';
    $s = $pdo->prepare($sql);
    $s->bindValue(':name', $_POST['name']);
    $s->bindValue(':country', $_POST['country']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error adding submitted director.';
    include 'error.html.php';
    exit();
}
  header('Location: .');
exit(); 
}





if (isset($_POST['action']) and $_POST['action'] == 'Edit')
{
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
try {
    $sql = 'SELECT id, name, country FROM director WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching director details.';
    include 'error.html.php';
    exit();
  }
  $row = $s->fetch();
  $pageTitle = 'Edit director';
  $action = 'editform';
  $name = $row['name'];
  $country = $row['country'];
  $id = $row['id'];
  $button = 'Update director';
  include 'form.html.php';
  exit(); 
}

if (isset($_GET['editform']))
{
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
  try {
    $sql = 'UPDATE director SET
        name = :name,
        country = :country
        WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->bindValue(':name', $_POST['name']);
    $s->bindValue(':country', $_POST['country']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error updating submitted director.';
    include 'error.html.php';
    exit();
  }
  header('Location: .');
  exit(); 
}






try {
  $result = $pdo->query('SELECT id, name FROM director');
}
catch (PDOException $e)
{
  $error = 'Error fetching directors from the database!';
  include 'error.html.php';
  exit();
}
foreach ($result as $row)
{
  $directors[] = array('id' => $row['id'], 'name' => $row['name']);
}
include 'directors.html.php';





if (isset($_POST['action']) and $_POST['action'] == 'Delete')
{
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
  // Get movies belonging to director
  try
  {
    $sql = 'SELECT id FROM movie WHERE directorid = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
}

catch (PDOException $e)
{
  $error = 'Error getting list of movies to delete.';
  include 'error.html.php';
  exit();
}
$result = $s->fetchAll();
// Delete movie country entries
try
{
  $sql = 'DELETE FROM moviecountry WHERE movieid = :id';
  $s = $pdo->prepare($sql);
  // For each movie
  foreach ($result as $row)
  {
    $movieId = $row['id'];
    $s->bindValue(':id', $movieId);
    $s->execute();
} }
catch (PDOException $e)
{
  $error = 'Error deleting country entries for movie.';
  include 'error.html.php';
  exit();
}
// Delete movies belonging to director
try
{
  $sql = 'DELETE FROM movie WHERE directorid = :id';
  $s = $pdo->prepare($sql);
  $s->bindValue(':id', $_POST['id']);
  $s->execute();
}
catch (PDOException $e)
{
  $error = 'Error deleting movies for director.';
  include 'error.html.php';
  exit();
}
// Delete the director
  try
  {
    $sql = 'DELETE FROM director WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error deleting director.';
    include 'error.html.php';
    exit();
}
  header('Location: .');
  exit(); 
}






//include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/magicquotes.inc.php';



?>