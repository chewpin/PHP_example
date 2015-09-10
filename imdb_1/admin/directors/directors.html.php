<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Manage Directors</title>
  </head>
  <body>
    <h1>Manage Directors</h1>
    <p><a href="?add">Add new director</a></p>
    <ul>
      <?php foreach ($directors as $director): ?>
      <li>
          <form action="" method="post">
            <div>
              <?php htmlout($director['name']); ?>
              <input type="hidden" name="id" value="<?php
                  echo $director['id']; ?>">
              <input type="submit" name="action" value="Edit">
              <input type="submit" name="action" value="Delete">
            </div>
          </form>
        </li>
      <?php endforeach; ?>
</ul>
    <p><a href="..">Return to home</a></p>
  </body>
</html>