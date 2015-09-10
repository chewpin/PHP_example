<?php
//Display director 
include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';

if (isset($_GET['add']))
{
  //echo "add in director.index.php";
  $pageTitle = 'New Director';
  $action = 'addform';
  $name = '';
  $countryid = '';
  $id = '';
  $button = 'Add director';
  try {
    $result = $pdo->query('SELECT id, name FROM country');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching countries from database!';
    include 'error.html.php';
    exit();
  }
  foreach ($result as $row)
  {
    //echo "1";
    $countries[] = array('id' => $row['id'], 'name' => $row['name']);
  }
  include 'form.html.php';
  exit(); 
}

if (isset($_GET['addform']))
{
  //echo "addform in director.index.php";
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
  try {
    $sql = 'INSERT INTO director SET
        name = :name,
        countryid = :countryid';
    $s = $pdo->prepare($sql);
    $s->bindValue(':name', $_POST['name']);
    $s->bindValue(':countryid', $_POST['countryid']);
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
  //echo "edit in director.index.php";
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
  try {
    $sql = 'SELECT id, name, countryid FROM director WHERE id = :id';
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
  $countryid = $row['countryid'];
  $id = $row['id'];
  $button = 'Update director';
  include 'form.html.php';
  exit(); 
}

if (isset($_GET['editform']))
{
  //echo "editform in director.index.php";
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
  try {
    $sql = 'UPDATE director SET
        name = :name,
        countryid = :countryid
        WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->bindValue(':name', $_POST['name']);
    $s->bindValue(':countryid', $_POST['countryid']);
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
  //echo "Deleting director " . $_POST['id'] ." inside function";
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
    } 
  }
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
} // END if (isset($_POST['action']) and $_POST['action'] == 'Delete')

?>