<?php
//API Key: 0a497969dcb2f9f6c0f1007683a8df67
include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/magicquotes.inc.php';
if (isset($_GET['add']))
{
  //echo "add in countries.index.php";
  $pageTitle = 'New Country';
  $action = 'addform';
  $name = '';
  $id = '';
  $button = 'Add country';
  include 'form.html.php';
  exit(); 
}
if (isset($_GET['addform']))
{
  //echo "addform in countries.index.php";
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
  try {
    $sql = 'INSERT INTO country SET
        name = :name';
    $s = $pdo->prepare($sql);
    $s->bindValue(':name', $_POST['name']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error adding submitted country.';
    include 'error.html.php';
    exit();
  }
  header('Location: .');
  exit(); 
}




if (isset($_POST['action']) and $_POST['action'] == 'Edit')
{
  //echo "Edit in countries.index.php";
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
  try {
    $sql = 'SELECT id, name FROM country WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching country details.';
    include 'error.html.php';
    exit();
  }
  $row = $s->fetch();
  $pageTitle = 'Edit Country';
  $action = 'editform';
  $name = $row['name'];
  $id = $row['id'];
  $button = 'Update country';
  include 'form.html.php';
  exit(); 
}
if (isset($_GET['editform']))
{
  //echo "editform in countries.index.php";
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
  try {
    $sql = 'UPDATE country SET
        name = :name
        WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->bindValue(':name', $_POST['name']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error updating submitted country.';
    include 'error.html.php';
    exit();
  } 
  header('Location: .');
  exit(); 
}
if (isset($_POST['action']) and $_POST['action'] == 'Delete')
{
  //echo "Delete country " . $_POST['id'] . " in countries.index.php";
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
  // Delete movie associations with this country
  try
  {
    $sql = 'DELETE FROM moviecountry WHERE countryid = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error removing movies from country.';
    include 'error.html.php';
    exit();
}
  // Delete the country
  try
  {
    $sql = 'DELETE FROM country WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error deleting country.';
    include 'error.html.php';
    exit();
  }
  header('Location: .');
  exit(); 
}

// Display country list
include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
try {
  $result = $pdo->query('SELECT id, name FROM country ORDER BY name ASC');
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
include 'countries.html.php';