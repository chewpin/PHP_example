<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Manage Movie</title>
  </head>
  <body>
<h1>Manage Movies</h1>
<p><a href="?add">Add new movie</a></p> <form action="" method="get">
<p>View movies satisfying the following criteria:</p>
      <div>
        <label for="director">By director:</label>
        <select name="director" id="director">
          <option value="">Any director</option>
          <?php foreach ($directors as $director): ?>
            <option value="<?php htmlout($director['id']); ?>"><?php
                htmlout($director['name']); ?></option>
          <?php endforeach; ?>
        </select>
</div> <div>
        <label for="country">By country:</label>
        <select name="country" id="country">
          <option value="">Any country</option>
          <?php foreach ($countries as $country): ?>
            <option value="<?php htmlout($country['id']); ?>"><?php
                htmlout($country['name']); ?></option>
          <?php endforeach; ?>
        </select>
</div> <div>
        <label for="text">Containing text:</label>
        <input type="text" name="text" id="text">
      </div>
      <div>
        <input type="hidden" name="action" value="search">
        <input type="submit" value="Search">
      </div>
    </form>
    <p><a href="..">Return to JMS home</a></p>
  </body>
</html>