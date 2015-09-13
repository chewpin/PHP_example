

			<form method="post" action="<?php echo $PHP_SELF;?>"> 
				 Type in a search:<input type="text" id="searchText" name="searchText" value="<?php 
				 if (isset($_POST['searchText'])){
				  echo($_POST['searchText']); }
				  else { echo('sushi');}
				  ?>"/>

				  <input type="hidden" name="submitapi" value="search" >
                  <input type="submit" value="Search!">

			</form>

<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>gotoapi</title>
  </head>
  <body>
    <h1>PHP Bing</h1>

    echo "gotoapipage";
    
    <form action="addapi" method="post">
      <div>
        <label for="name">
        	Name: <input type="text" name="searchText" id="searchText" value="">
        </label>
      </div>
      <div>
        <input type="hidden" name="id" value="">
        <input type="submit" value="Search!">
      </div>
    </form>
  </body>
</html>