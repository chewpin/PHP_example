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



if (isset($_GET['gotoapipage']) ) {


  echo "gogogo";
  echo "real go";
  //echo "add api";
  $pageTitle = 'Add api';
  $action = 'addapi';
  $name = 'sushi';
  $id = '';
  $button = 'Add api search!';
    include 'api.html.php';
    exit();

}

if (isset($_GET['addapi'])) {
  echo "Submit!!";
  echo ($_POST['name']);
 $id = "tt0133093"; // the matrix

  $url = file_get_contents("https://api.themoviedb.org/3/find/" . $id . "?external_source=imdb_id&api_key=0a497969dcb2f9f6c0f1007683a8df67");
  $json = json_decode($url, true); //This will convert it to an array
  echo "<br/>url returns " . $url;
  $moviename = $json['movie_results'][0]['title'];
  $moviedate = $json['movie_results'][0]['release_date']; 
  $overview = $json['movie_results'][0]['overview']; 
  $posterpath = $json['movie_results'][0]['poster_path']; 
  $posterpath = $json['movie_results'][0]['poster_path']; 
  $score = $json['movie_results'][0]['vote_average']; 
  // $genre = $json['movie_results'][0]['genre_ids']; 
  // echo $json['movie_results'][0]['genre_ids'][0]; 
  // foreach ($genre as $row)
  // {
  //   echo "1";
  //   $genres[] = array('genre' => $row);
  //   echo $row;
  // }
  echo "<br/><br/>The movie '$moviename' was made in $movie_year, 
    <br/>overview: $overview, <br/>poster path: $posterpath, <br/>score: $score, <br/>genre: $genre";  




    $url1 = file_get_contents("http://api.themoviedb.org/3/movie/popular?api_key=0a497969dcb2f9f6c0f1007683a8df67");
  $json1 = json_decode($url1, true); //This will convert it to an array
  echo "<br/><br/>url returns " . $url1;



  $i = 0;
  $json2 = $json1['results'];
  foreach($json2 as $item) { //foreach element in $arr
    $moviename = $item['title'];
    $moviedate = $item['release_date']; 
    $overview = $item['overview']; 
    $moviedate = $item['release_date'];
    $posterpath = $item['poster_path']; 
    $score = $item['vote_average'];
    echo "<br/><br/>" . $i .": The movie '$moviename' was made in $moviedate, 
      <br/>overview: $overview, <br/>poster path: $posterpath, <br/>score: $score";  
    $i = $i + 1;  
  }

  // $moviename = $json1['results'][0]['title'];
  // $moviedate = $json1['results'][0]['release_date']; 
  // $overview = $json1['results'][0]['overview']; 
  // $posterpath = $json1['results'][0]['poster_path']; 
  // $posterpath = $json1['results'][0]['poster_path']; 
  // $score = $json1['results'][0]['vote_average']; 
  
  // echo "<br/><br/>The movie '$moviename' was made in $moviedate, 
  //   <br/>overview: $overview, <br/>poster path: $posterpath, <br/>score: $score, <br/>genre: $genre";              
             
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