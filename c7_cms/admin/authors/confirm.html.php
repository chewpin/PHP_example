<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Confirm</title>
  </head>
  <body>
    <!-- <h1>Manage Authors</h1> -->
    <!-- <p><a href="?add">Add new author</a></p> -->
    <ul>
      <li>
          <form action="" method="post">
            <div>
              Confirm 
              <?php htmlout($author['name']); ?>
              <input type="hidden" name="id" value="<?php
                  echo $author['id']; ?>">
              ?
              <input type="submit" name="action_confirm" value="Confirm">
            </div>
          </form>
        </li>
</ul>
  </body>
</html>