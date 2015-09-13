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
    $result = $pdo->query('SELECT id, name FROM director ORDER BY name ASC');
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
    $result = $pdo->query('SELECT id, name FROM country ORDER BY name ASC');
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
    $result = $pdo->query('SELECT id, name FROM director ORDER BY name ASC');
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
    $result = $pdo->query('SELECT id, name FROM country ORDER BY name ASC');
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
    $json2 = $json1['title_popular'];
    foreach ($json2 as $row) {
      $movies[] = array('moviename' => $row['title'], 'overview' => $row['title_description'], 'imdbid' => $row['id']);
      $pageTitle = 'Suggestion result';
      $action = 'addformimdbreturns';
      $directorid = '';
      $button = 'Yes, add this movie';
      $moviename = $row['title'];
      $overview = $row['title_description'];
      $imdbid = $row['id'];
      echo "<br/>id: " . $row['id'];
      echo "<br/>moviename: " . $row['title'];
      echo "<br/>overview: " . $row['title_description'];
    }
  }
  else if( isset( $json1['title_approx'] ) ){
   // do something
    $json2 = $json1['title_approx'];
    foreach ($json2 as $row) {
      $movies[] = array('moviename' => $row['title'], 'overview' => $row['title_description'], 'imdbid' => $row['id']);
      $pageTitle = 'Suggestion result';
      $action = 'addformimdbreturns';
      $directorid = '';
      $button = 'Yes, add this movie';
      $moviename = $row['title'];
      $overview = $row['title_description'];
      $imdbid = $row['id'];
      echo "<br/>id: " . $row['id'];
      echo "<br/>moviename: " . $row['title'];

      echo "<br/>overview: " . $row['title_description'];
    }
  }
  else {
    $pageTitle = 'No result found sorry!';
    $action = 'gosearchimdb';
    $directorid = '';
    $button = 'Go back to add movie';
  }
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
  //print_r($overview_array);
  $moviedate = $overview_array[0];
  $directorname = $overview_array[1];
  echo "<br/>movie year: " . $moviedate;
  echo "<br/>movie director: " . $directorname . "<br/>[";

  echo htmlspecialchars($directorname, ENT_QUOTES, 'UTF-8');
  $directorname = trim($directorname, " ");
  $directorname = preg_replace('/<a href=\'(.*?)\'>(.*?)<\/a>/', "\\2", $directorname);
  echo "]<br/>after tranform: [" . $directorname . "]<br/>";

  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
  


  $director_parse_array = explode(' ', $directorname);
  $directorfirstname = $director_parse_array[0];
  $directorlastname = $director_parse_array[1];
  $directorid = 0;
  echo "<br/>director first name: [" . $directorfirstname . "].";
  echo "<br/>director last name: [" . $directorlastname . "].";
  // The basic SELECT statement
  $select = 'SELECT id, name';
  $from   = ' FROM director';
  $where  = ' WHERE TRUE';
  $placeholders = array();


  
  if ($directorname != '') // Some search text was specified
  {
    echo "and!!!";
    $where .= " AND name LIKE :directorfirstname AND name LIKE :directorlastname";
    $placeholders[':directorfirstname'] = '%' . $directorfirstname . '%';
    $placeholders[':directorlastname'] = '%' . $directorlastname . '%';
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
    echo "111";
    $directors[] = array('id' => $row['id'], 'name' => $row['name']);
    echo "<br/>search director result: director id: " . $directors[0]['id'] . ", <br/> name: " . $directors[0]['name'];
    $directorid = $directors[0]['id'];
    break;
  }
    
  if ( $directorid == 0 ) {
    echo "<br/>director not found! adding director " . $directorname ;
    try {
      $sql = 'INSERT INTO director SET
          name = :directorname';
      $s = $pdo->prepare($sql);
      $s->bindValue(':directorname', $directorname);
      $result = $s->execute();
    }
    catch (PDOException $e)
    {
      echo "error"; 
      $error = 'Error adding submitted director.';
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
      echo "and!!!";
      $where .= " AND name LIKE :directorfirstname AND name LIKE :directorlastname";
      $placeholders[':directorfirstname'] = '%' . $directorfirstname . '%';
      $placeholders[':directorlastname'] = '%' . $directorlastname . '%';
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
      echo "111";
      $directors[] = array('id' => $row['id'], 'name' => $row['name']);
      echo "<br/>search director result: director id: " . $directors[0]['id'] . ", <br/> name: " . $directors[0]['name'];
      $directorid = $directors[0]['id'];
      break;
    }
  }
  echo "<br/moviename: " . $moviename;
  echo "<br/>moviedate: " . $moviedate;
  echo "<br/>directorname: " . $directorname;
  echo "<br/>imdbid: " . $imdbid;
  echo "<br/>directorid: " . $directorid;
  
  try {
    echo "trying to check duplicate";
    $sql = 'SELECT id, imdbid, moviename FROM movie WHERE moviename LIKE :moviename';
    $s = $pdo->prepare($sql);
    $s->bindValue(':moviename', $_POST['moviename']);
    $s->execute();
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
    echo "Error this movie already exists!!!!";
    exit();
  }

  $score = getscore($imdbid);
  echo "<br/>Score: " . $score;

  try {
    echo "Adding...";
    $sql = 'INSERT INTO movie SET
        moviename = :moviename,
        moviedate = :moviedate,
        imdbid = :imdbid,
        directorid = :directorid,
        directorname = :directorname,
        score = :score';
    $s = $pdo->prepare($sql);
    $s->bindValue(':moviename', $moviename); 
    $s->bindValue(':moviedate', $moviedate); 
    $s->bindValue(':directorname', $directorname);
    $s->bindValue(':imdbid', $imdbid);
    $s->bindValue(':directorid', $directorid); 
    $s->bindValue(':score', $score); 
    $s->execute();
    }
  catch (PDOException $e)
  {
    echo "error";
    $error = 'Error adding submitted movie.';
    include 'error.html.php';
    exit();
  }
  getallinfo ($movies, $directors, $countries);
  include "movies.html.php";

  exit();
} // END if (isset($_GET['addformimdbreturns']))


if (isset($_GET['addform']))
{
  //echo "add form";
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php'; 
  
  try {
    //echo "trying to check duplicate";
    $sql = 'SELECT id, imdbid, moviename FROM movie WHERE moviename LIKE :moviename';
    $s = $pdo->prepare($sql);
    $s->bindValue(':moviename', $_POST['moviename']);
    $s->execute();
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
    echo "Error this movie already exists!!!!";
    exit();
  }
    



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
        moviedate = "2016",
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
    $result = $pdo->query('SELECT id, name FROM director ORDER BY name ASC');
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
    $result = $pdo->query('SELECT id, name FROM country ORDER BY name ASC');
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
    $result = $pdo->query('SELECT id, moviename, directorid, score FROM movie ORDER BY moviename ASC');
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
    $result = $pdo->query('SELECT id, name FROM director ORDER BY name ASC');
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
    //echo "unsuccesssful";
    $noresult = 1;
    //$movies[] = array('moviename' => "no result");

  }
  include 'movies.html.php';
  exit(); 
} // END if (isset($_GET['action']) and $_GET['action'] == 'search')






// Display search form
include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
try {
  $result = $pdo->query('SELECT id, moviename, directorid, score FROM movie ORDER BY moviename ASC');
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
    $result = $pdo->query('SELECT id, moviename, directorid, score FROM movie ORDER BY moviename ASC ');
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
    $result = $pdo->query('SELECT id, name FROM director ORDER BY name ASC');
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
}

function getallinfo (&$movies, &$directors, &$countries) {
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db_imdb.inc.php';
  getmovieinfo ($movies);
  getdirectorinfo ($directors);
  getcountryinfo ($countries);
}

function getscore($imdbid) {
  echo "getting score!";
  $url1 = file_get_contents("https://api.themoviedb.org/3/find/$imdbid?external_source=imdb_id&api_key=0a497969dcb2f9f6c0f1007683a8df67");
  $json1 = json_decode($url1, true); //This will convert it to an array
  $json_getscore = $json1['movie_results'];
  echo "<br/>" . $url;
  echo "<br/>score: " . $json_getscore[0]['vote_average'];
  return $json_getscore[0]['vote_average'];
}

?>











