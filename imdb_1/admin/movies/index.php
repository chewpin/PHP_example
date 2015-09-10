<?php

if (isset($_GET['add']))
{
  //echo "add";
  $pageTitle = 'New Movie';
  $action = 'addform';
  $moviename = '';
  $directorid = '';
  $id = '';
  $button = 'Add movie';
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
  // Build the list of directos
  try
  {
    $result = $pdo->query('SELECT id, name FROM director');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of directors.';
    include 'error.html.php';
    exit();
  }
  foreach ($result as $row)
  {
    $directors[] = array('id' => $row['id'], 'name' => $row['name']);
  }
  // Build the list of countries
  try
  {
    $result = $pdo->query('SELECT id, name FROM country');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of countries.';
    include 'error.html.php';
    exit();
  }
  foreach ($result as $row)
  {
    $countries[] = array(
    'id' => $row['id'], 'name' => $row['name'], 'selected' => FALSE);
  }
  include 'form.html.php';
  exit(); 
} // END if (isset($_GET['add']))




if (isset($_POST['action']) and $_POST['action'] == 'Edit')
{
  //echo "Edit";
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
  try {
    $sql = 'SELECT id, moviename, directorid FROM movie WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching movie details.';
    include 'error.html.php';
    exit();
  }
  $row = $s->fetch();
  $pageTitle = 'Edit Movie';
  $action = 'editform';
  $moviename = $row['moviename'];
  $directorid = $row['directorid'];
  $id = $row['id'];
  $button = 'Update movie';
  // Build the list of directors
  try
  {
    $result = $pdo->query('SELECT id, name FROM director');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of directors.';
    include 'error.html.php';
    exit();
  }
  foreach ($result as $row)
  {
    $directors[] = array('id' => $row['id'], 'name' => $row['name']);
  }
  // Get list of countries containing this movie
  try
  {
  $sql = 'SELECT countryid FROM moviecountry WHERE movieid = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $id);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of selected countries.';
    include 'error.html.php';
    exit(); }
  foreach ($s as $row)
  {
    $selectedCountries[] = $row['countryid'];
  }
  // Build the list of all countries
  try
  {
    $result = $pdo->query('SELECT id, name FROM country');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of countries.';
    include 'error.html.php';
    exit();
  }
  foreach ($result as $row)
  {
    $countries[] = array(
        'id' => $row['id'],
        'name' => $row['name'],
        'selected' => in_array($row['id'], $selectedCountries));
  }
  include 'form.html.php';
  exit(); 
} // END if (isset($_POST['action']) and $_POST['action'] == 'Edit')





if (isset($_GET['addform']))
{
  //echo "add form";
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
  if ($_POST['director'] == '')
  {
    $error = 'You must choose a director for this movie.
        Click &lsquo;back&rsquo; and try again.';
    include 'error.html.php';
    exit(); 
  }
  try {
    $sql = 'INSERT INTO movie SET
        moviename = :moviename,
        moviedate = CURDATE(),
        directorid = :directorid';
    $s = $pdo->prepare($sql);
    $s->bindValue(':moviename', $_POST['moviename']); // ahhhhhhhiuhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh
    $s->bindValue(':directorid', $_POST['director']); // ahhhhhhhiuhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh
    $s->execute();
    }
  catch (PDOException $e)
  {
    $error = 'Error adding submitted movie.';
    include 'error.html.php';
    exit();
  }
  $movieid = $pdo->lastInsertId();
  if (isset($_POST['countries']))
  {
    try {
      $sql = 'INSERT INTO moviecountry SET
          movieid = :movieid,
          countryid = :countryid';
      $s = $pdo->prepare($sql);
      foreach ($_POST['countries'] as $countryid)
      {
        $s->bindValue(':movieid', $movieid); $s->bindValue(':countryid', $countryid); $s->execute();
      } 
    }
    catch (PDOException $e)
    {
      $error = 'Error inserting movie into selected countries.';
      include 'error.html.php';
      exit();
    } 
  }
  header('Location: .');
  exit(); 
} // END if (isset($_GET['addform']))




if (isset($_GET['editform']))
{
  //echo "edit form";
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
  if ($_POST['director'] == '')
  {
    $error = 'You must choose an director for this joke.
        Click &lsquo;back&rsquo; and try again.';
    include 'error.html.php';
    exit(); 
  }
  try {
    $sql = 'UPDATE movie SET
        moviename = :moviename,
        directorid = :directorid
        WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->bindValue(':moviename', $_POST['text']);
    $s->bindValue(':directorid', $_POST['director']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error updating submitted movie.';
    include 'error.html.php';
    exit();
  }
  try {
    $sql = 'DELETE FROM moviecountry WHERE movieid = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error removing obsolete movie country entries.';
    include 'error.html.php';
    exit();
  }
  if (isset($_POST['coutries']))
  {
    try {
      $sql = 'INSERT INTO moviecountry SET
          movieid = :movieid,
          countryid = :countryid';
      $s = $pdo->prepare($sql);
      foreach ($_POST['countries'] as $countryid)
      {
        $s->bindValue(':movieid', $_POST['id']);
        $s->bindValue(':countryid', $countryid);
        $s->execute();
      } 
    }
    catch (PDOException $e)
    {
      $error = 'Error inserting movie into selected countries.';
      include 'error.html.php';
      exit();
    }   
  }
  header('Location: .');
  exit(); 
} // END if (isset($_GET['editform']))





if (isset($_POST['action']) and $_POST['action'] == 'Delete')
{
  //echo "Deleting movie " . $_POST['id'];
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
  // Delete country assignments for this movie
  try
  {
    $sql = 'DELETE FROM moviecountry WHERE movieid = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error removing movie from countries.';
    include 'error.html.php';
    exit();
  }
  // Delete the movie
  try
  {
    $sql = 'DELETE FROM movie WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error deleting movie.';
    include 'error.html.php';
    exit();
  }
  header('Location: .');
  exit(); 
} // END if (isset($_POST['action']) and $_POST['action'] == 'Delete')







if (isset($_GET['action']) and $_GET['action'] == 'search')
{
  //echo "Searching start";
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
  // The basic SELECT statement
  $select = 'SELECT id, moviename';
  $from   = ' FROM movie';
  $where  = ' WHERE TRUE';
  $placeholders = array();
  if ($_GET['director'] != '') // A director is selected
  {
    echo "A director is selected";
    $where .= " AND directorid = :directorid";
    $placeholders[':directorid'] = $_GET['director'];
  }
  if ($_GET['country'] != '') // A country is selected
  {
    echo "A country is selected";
    $from  .= ' INNER JOIN moviecountry ON id = movieid';
    $where .= " AND countryid = :countryid";
    $placeholders[':countryid'] = $_GET['country'];
  }
  if ($_GET['text'] != '') // Some search text was specified
  {
    echo "Some search text was specified";
    $where .= " AND movietext LIKE :movietext";
    $placeholders[':movietext'] = '%' . $_GET['text'] . '%';
  }
  try {
    $sql = $select . $from . $where; 
    $s = $pdo->prepare($sql); 
    $s->execute($placeholders);
  }
  catch (PDOException $e)
  {
      $error = 'Error fetching movies.';
      include 'error.html.php';
      exit();
  }
  foreach ($s as $row)
  {
      $movies[] = array('id' => $row['id'], 'moviename' => $row['moviename']);
  }
  include 'movies.html.php';
  exit(); 
} // END if (isset($_GET['action']) and $_GET['action'] == 'search')






// Display search form
include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
try {
  $result = $pdo->query('SELECT id, name FROM director');
}
catch (PDOException $e)
{
  $error = 'Error fetching directors from database!';
  include 'error.html.php';
  exit(); 
}
foreach ($result as $row)
{
  $directors[] = array('id' => $row['id'], 'name' => $row['name']);
}
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
  $countries[] = array('id' => $row['id'], 'name' => $row['name']);
}
include 'searchform.html.php';



?>











