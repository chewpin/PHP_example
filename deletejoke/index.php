<?php
if (get_magic_quotes_gpc())
{
  	function stripslashes_deep($value)
  	{
    		$value = is_array($value) ?
    				array_map('stripslashes_deep', $value) :
    				stripslashes($value);

    		return $value;
  	}

  	$_POST = array_map('stripslashes_deep', $_POST);
  	$_GET = array_map('stripslashes_deep', $_GET);
  	$_COOKIE = array_map('stripslashes_deep', $_COOKIE);
  	$_REQUEST = array_map('stripslashes_deep', $_REQUEST);
}

if (isset($_GET['addjoke']))
{
  	include 'form.html.php';
  	exit();
}

$link = mysqli_connect('localhost', 'root', 'root');

if (!$link)
{
  	$error = 'Unable to connect to the database server.';
  	include 'error.html.php';
  	exit();
}

if (!mysqli_set_charset($link, 'utf8'))
{
  	$output = 'Unable to set database connection encoding.';
  	include 'output.html.php';
  	exit();
}

if (!mysqli_select_db($link, 'ijdb'))
{
  	$error = 'Unable to locate the joke database.';
  	include 'error.html.php';
  	exit();
}



if (isset($_POST['joketext']))
{
  	$joketext = mysqli_real_escape_string($link, $_POST['joketext']);
    // With the damage done by magic quotes reversed, you must now prepare 
    // those values that you do intend to use in your SQL query. Just as it 
    // provides htmlspecialchars for outputting user-submitted values into 
    // HTML code, PHP provides a function that prepares a user-submitted value 
    // so that you can use it safely in your SQL query: mysqli_real_escape_string. 
    // Not the most elegant name, but it does the trick. Here's how you use it:
  	$sql = 'INSERT INTO joke SET
  			joketext="' . $joketext . '",
  			jokedate=CURDATE()';
  	if (!mysqli_query($link, $sql))
  	{
    		$error = 'Error adding submitted joke: ' . mysqli_error($link);
    		include 'error.html.php';
    		exit();
  	}
    
    // Instead, we want the browser to treat the updated list of jokes as 
    // a normal web page, able to be reloaded without resubmitting the form. 
    // The way to do this is to answer the browser's form submission with an HTTP 
    // redirect (HTTP stands for HyperText Transfer Protocol, and is the language 
    //   that describes the request/response communications that are exchanged 
    //   between the visitor's web browser and your web server.) - a special 
    // response that tells the browser "the page you're looking for is over here."
    // The PHP header function provides the means of sending special server responses 
    // like this one, by letting you insert special headers into the response sent 
    // to the server. In order to signal a redirect, you must send a Location header 
    // with the URL of the page to which you wish to direct the browser:
  	header('Location: .');
    // In this case, we want to send the browser back to the very same page - 
    // our controller. We're asking the browser to submit another request - 
    // this time, without a form submission attached to it - rather than sending 
    // the browser to another location. Since we want to point the browser at our 
    // controller (index.php) using the URL of the parent directory, we can simply 
    // tell the browser to reload the current directory, which is expressed as a period (.)
  	exit();
}

if (isset($_GET['deletejoke']))
{
  	$id = mysqli_real_escape_string($link, $_POST['id']);
  	$sql = "DELETE FROM joke WHERE id='$id'";
  	if (!mysqli_query($link, $sql))
  	{
    		$error = 'Error deleting joke: ' . mysqli_error($link);
    		include 'error.html.php';
    		exit();
  	}

  	header('Location: .');
  	exit();
}

//echo "before select all";
// select all


//$result = mysqli_query($link, 'SELECT id, joketext FROM joke');
$result = mysqli_query($link, 'SELECT joke.id, joketext, name, email FROM joke INNER JOIN author ON authorid = author.id');
if (!$result)
{
  	$error = 'Error fetching jokes: ' . mysqli_error($link);
  	include 'error.html.php';
  	exit();
}

while ($row = mysqli_fetch_array($result))
{
	  $jokes[] = array('id' => $row['id'], 'text' => $row['joketext']
      , 'name' => $row['name'], 'email' => $row['email']);
    // $jokes[] 是 array
}
//With the jokes pulled out of the database, we can now pass them along 
//to a PHP template (jokes.html.php) for display.

include 'jokes.html.php';
?>