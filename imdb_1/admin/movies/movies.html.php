<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- <meta charset="utf-8"> -->
    <title>Manage Movies: Search Results</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../boot/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../../../boot/css/style.css" rel="stylesheet">
  </head>
  <body>



    <h1>Search Results</h1>
    <?php if (isset($movies)): ?>
<table>
<tr><th>Movie Name</th><th>Options</th></tr> <?php foreach ($movies as $movie): ?>
<tr>
<td><?php htmlout($movie['moviename']); ?></td> <td>
            <form action="?" method="post">
              <div>
<input type="hidden" name="id" value="<?php htmlout($movie['id']); ?>">
                <input type="submit" name="action" value="Edit">
                <input type="submit" name="action" value="Delete">
              </div>
            </form>
          </td>
</tr>
        <?php endforeach; ?>
      </table>
    <?php endif; ?>
    <p><a href="?">New search</a></p>
    <p><a href="..">Return to JMS home</a></p>



    <div class = "navbar navbar-default navbar-fixed-bottom">
      <div class = "container">
        <p class = "navbar-text pull-left"> Site built by Jessica 
        </p>
        <a href = "../../homepage" class = "navbar-btn btn-default btn pull-right"> Visit my website </a>
      </div>
    </div>

    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>

    <script src="../../../boot/js/bootstrap.js"></script>

  </body>
</html>