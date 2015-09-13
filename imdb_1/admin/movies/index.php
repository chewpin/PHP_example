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



if (isset($_GET['addformimdb'])) {

  $moviename =preg_replace("/\s/","",$_POST['moviename']);
  $url1 = file_get_contents("http://www.imdb.com/xml/find?json=1&nr=1&tt=on&q=" . $moviename );
  $json1 = json_decode($url1, true); //This will convert it to an array
  echo $url1;
  if( isset( $json1['title_popular'] ) ){
   // do something

    $json_get = $json1['title_popular'];
    $moviename = $json_get[0]['title'];
    $overview = $json_get[0]['title_description'];
    $imdbid = $json_get[0]['id'];
    echo "<br/>id: " . $json_get[0]['id'];
    echo "<br/>moviename: " . $json_get[0]['title'];
    echo "<br/>overview: " . $json_get[0]['title_description'];
  }
  else if( isset( $json1['title_approx'] ) ){
   // do something

    $json_get = $json1['title_approx'];
    $moviename = $json_get[0]['title'];
    $overview = $json_get[0]['title_description'];
    $imdbid = $json_get[0]['id'];
    echo "<br/>id: " . $json_get[0]['id'];
    echo "<br/>moviename: " . $json_get[0]['title'];

    echo "<br/>overview: " . $json_get[0]['title_description'];
  }


  
  

  
  $pageTitle = 'Suggestion result';
  $action = 'addformimdbreturns';
  $directorid = '';
  $button = 'Yes, add this movie';

  include "searchimdbresult.html.php";

  exit();
}

if (isset($_GET['addformimdbreturns'])) {
  echo "Returns!!!";
  $moviename = $_POST['moviename'];
  $overview = $_POST['overview'];
  $imdbid = $_POST['imdbid'];
  echo "Moviename: ". $_POST['moviename'];
  echo "Overview: ". $_POST['overview'] ;
  echo "Imdbid: ". $_POST['imdbid'] ;

  $overview_array = explode(',', $overview);
  print_r($overview_array);
  $moviedate = $overview_array[0];
  $directorname = $overview_array[1];
  echo "<br/>movie year: " . $moviedate;
  echo "<br/>movie director: " . $directorname;

  $directorname = preg_replace('/<a href=\'(.*?)\'>(.*?)<\/a>/', "\\2", $directorname);
  echo "after tranform: " . $directorname;
  echo htmlspecialchars($directorname, ENT_QUOTES, 'UTF-8');

  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
  try {
    echo "Adding...";
    $sql = 'INSERT INTO movie SET
        moviename = :moviename,
        moviedate = :moviedate,
        imdbid = :imdbid,
        directorname = :directorname';
    $s = $pdo->prepare($sql);
    $s->bindValue(':moviename', $moviename); // ahhhhhhhiuhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh
    $s->bindValue(':moviedate', $moviedate); // ahhhhhhhiuhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh
    $s->bindValue(':directorname', $directorname); // ahhhhhhhiuhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh
    $s->bindValue(':imdbid', $imdbid); // ahhhhhhhiuhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh
    $s->execute();
    }
  catch (PDOException $e)
  {
    echo "error";
    $error = 'Error adding submitted movie.';
    include 'error.html.php';
    exit();
  }



  // The basic SELECT statement
  $select = 'SELECT id, name';
  $from   = ' FROM director';
  $where  = ' WHERE TRUE';
  $placeholders = array();
  
  if ($directorname != '') // Some search text was specified
  {
    $where .= " AND name LIKE :directorname";
    $placeholders[':directorname'] = '%' . $directorname . '%';
  }
  try {
    $sql = $select . $from . $where; 
    $s = $pdo->prepare($sql); 
    $s->execute($placeholders);
  }
  catch (PDOException $e)
  {
    echo "error";
    $error = 'Error fetching directors.';
    include 'error.html.php';
    exit();
  }
  foreach ($s as $row)
  {
      $directors[] = array('id' => $row['id'], 'name' => $row['name']);
  }
  echo "<br/>search director result: director id: " . $directors[0]['id'] . ", <br/> name: " . $directors[0]['name'];


  include "movies.html.php";

  exit();
}


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
    $s->bindValue(':moviename', $_POST['moviename']);
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
  if (isset($_POST['countries']))
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




if (isset($_GET['gopopular']) ) {

  $url1 = file_get_contents("http://api.themoviedb.org/3/movie/popular?api_key=0a497969dcb2f9f6c0f1007683a8df67");
  $json1 = json_decode($url1, true); //This will convert it to an array
  $json_gopopular = $json1['results'];
  include 'popular.html.php';
  exit();

}

if (isset($_GET['goupcoming']) ) {

  $url1 = file_get_contents("http://api.themoviedb.org/3/movie/upcoming?api_key=0a497969dcb2f9f6c0f1007683a8df67");
  $json1 = json_decode($url1, true); //This will convert it to an array
  $json_upcoming = $json1['results'];
  include 'upcoming.html.php';
  exit();

}

//if (isset($_GET['addapi'])) {

 //  echo "Submit!!";
 //  echo ($_POST['name']);
 // $id = "tt0133093"; // the matrix

 //  $url = file_get_contents("https://api.themoviedb.org/3/find/" . $id . "?external_source=imdb_id&api_key=0a497969dcb2f9f6c0f1007683a8df67");
 //  $json = json_decode($url, true); //This will convert it to an array
 //  echo "<br/>url returns " . $url;
 //  $moviename = $json['movie_results'][0]['title'];
 //  $moviedate = $json['movie_results'][0]['release_date']; 
 //  $overview = $json['movie_results'][0]['overview']; 
 //  $posterpath = $json['movie_results'][0]['poster_path']; 
 //  $posterpath = $json['movie_results'][0]['poster_path']; 
 //  $score = $json['movie_results'][0]['vote_average']; 
  // $genre = $json['movie_results'][0]['genre_ids']; 
  // echo $json['movie_results'][0]['genre_ids'][0]; 
  // foreach ($genre as $row)
  // {
  //   echo "1";
  //   $genres[] = array('genre' => $row);
  //   echo $row;
  // }
 


  //   $url1 = file_get_contents("http://api.themoviedb.org/3/movie/popular?api_key=0a497969dcb2f9f6c0f1007683a8df67");
  // $json1 = json_decode($url1, true); //This will convert it to an array
  // echo "<br/><br/>url returns " . $url1;



  // $i = 0;
  // $json2 = $json1['results'];
  // foreach($json2 as $item) { //foreach element in $arr
  //   $moviename = $item['title'];
  //   $moviedate = $item['release_date']; 
  //   $overview = $item['overview']; 
  //   $moviedate = $item['release_date'];
  //   $posterpath = $item['poster_path']; 
  //   $score = $item['vote_average'];
  //   echo "<br/><br/>" . $i .": The movie '$moviename' was made in $moviedate, 
  //     <br/>overview: $overview, <br/>poster path: $posterpath, <br/>score: $score";  
  //   $i = $i + 1;  
  // }

  // $moviename = $json1['results'][0]['title'];
  // $moviedate = $json1['results'][0]['release_date']; 
  // $overview = $json1['results'][0]['overview']; 
  // $posterpath = $json1['results'][0]['poster_path']; 
  // $posterpath = $json1['results'][0]['poster_path']; 
  // $score = $json1['results'][0]['vote_average']; 
  
  // echo "<br/><br/>The movie '$moviename' was made in $moviedate, 
  //   <br/>overview: $overview, <br/>poster path: $posterpath, <br/>score: $score, <br/>genre: $genre";              
             
  //exit();
//}







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

if (isset($_GET['gosearchimdb'])) {
  $pageTitle = 'New Movie';
  $action = 'addformimdb';
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
  include 'searchimdb.html.php';
  exit();
}


if (isset($_GET['gosearchpage']) || isset($_GET['goview']) || $wantsearch == true )
{
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
  try {
    $result = $pdo->query('SELECT id, moviename, directorid, score FROM movie');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching movies from database!';
    include 'error.html.php';
    exit(); 
  }
  foreach ($result as $row)
  {
    $movies[] = array('id' => $row['id'], 'moviename' => $row['moviename'], 'directorid' => $row['directorid'], 'score' => $row['score']);
  }
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
  if (isset($_GET['gosearchpage'])|| $wantsearch == true) include 'searchform.html.php';
  if ( isset($_GET['goview']) ) include 'movies.html.php';
  exit(); 
}




if ( (isset($_GET['action']) and $_GET['action'] == 'search') )
{
  //echo "Searching start";
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
  // The basic SELECT statement
  $select = 'SELECT id, moviename, directorid, score';
  $from   = ' FROM movie';
  $where  = ' WHERE TRUE';
  $placeholders = array();
  if ($_GET['director'] != '') // A director is selected
  {
    //echo "A director is selected";
    $where .= " AND directorid = :directorid";
    $placeholders[':directorid'] = $_GET['director'];
  }
  if ($_GET['country'] != '') // A country is selected
  {
    //echo "A country is selected";
    $from  .= ' INNER JOIN moviecountry ON id = movieid';
    $where .= " AND countryid = :countryid";
    $placeholders[':countryid'] = $_GET['country'];
  }
  if ($_GET['text'] != '') // Some search text was specified
  {
    $where .= " AND moviename LIKE :moviename";
    $placeholders[':moviename'] = '%' . $_GET['text'] . '%';
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
      $movies[] = array('id' => $row['id'], 'moviename' => $row['moviename'], 'directorid' => $row['directorid'], 'score' => $row['score']);
  }
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
  if (!isset($movies)) {
    echo "unsuccesssful";
    $noresult = 1;
  }
  include 'movies.html.php';
  exit(); 
} // END if (isset($_GET['action']) and $_GET['action'] == 'search')






// Display search form
include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
try {
  $result = $pdo->query('SELECT id, moviename, directorid, score FROM movie ');
}
catch (PDOException $e)
{
  $error = 'Error fetching movies from database!';
  include 'error.html.php';
  exit(); 
}
foreach ($result as $row)
{
  $movies[] = array('id' => $row['id'], 'moviename' => $row['moviename'], 'directorid' => $row['directorid'], 'score' => $row['score']);
}
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
//echo "Bfore including main movies";
include 'movies.html.php';


function getdirector($directorid)
{
  getallinfo ($movies, $directors, $countries);
  searchinarray($directors, 'id', $directorid, $ret);
  return $ret;
}


function searchinarray($array, $key, $value, &$ret)
{
  $result = array();
  if (is_array($array)) {
    if (isset($array[$key]) && $array[$key] == $value) {
        $result = $array;
        $ret = $array['name'];
    }
    foreach ($array as $subarray) {
      $result = searchinarray($subarray, $key, $value, $ret);
      $i = $i + 1;
    }
  }
  return;
}


function getmovieinfo (&$movies) {
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
  try {
    $result = $pdo->query('SELECT id, moviename, directorid, score FROM movie ');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching movies from database!';
    include 'error.html.php';
    exit(); 
  }
  foreach ($result as $row)
  {
    $movies[] = array('id' => $row['id'], 'moviename' => $row['moviename'], 'directorid' => $row['directorid'], 'score' => $row['score']);
  }
}

function getdirectorinfo (&$directors) {
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
}

function getcountryinfo (&$countries) {
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php'; 
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
}

function getallinfo (&$movies, &$directors, &$countries) {
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
  getmovieinfo ($movies);
  getdirectorinfo ($directors);
  getcountryinfo ($countries);
}

?>











