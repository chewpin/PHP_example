<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Manage Countries</title>
  </head>
  <body>
    <h1>Manage Country</h1>
    <p><a href="?add">Add new country</a></p>
    <p><a href="?gotoapipage">Add api</a></p>
    <ul>
      <?php foreach ($countries as $country): ?>
        <li>
          <form action="" method="post">
            <div>
              <?php htmlout($country['name']); ?>
              <input type="hidden" name="id" value="<?php
              echo $country['id']; ?>">
              <input type="submit" name="action" value="Edit">
              <input type="submit" name="action" value="Delete">
            </div>
          </form>
        </li>
      <?php endforeach; ?>
</ul>
    <p><a href="..">Return to JMS home</a></p>
  </body>
</html>