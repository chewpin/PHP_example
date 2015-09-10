<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php htmlout($pageTitle); ?></title>
    <style type="text/css">
    textarea {
      display: block;
      width: 100%;
    }
    </style>
  </head>
  <body>
    <h1><?php htmlout($pageTitle); ?></h1>
    <form action="?<?php htmlout($action); ?>" method="post">
      <div>
        <label for="moviename">Type your movie name here:</label>
        <textarea id="moviename" name="moviename" rows="3" cols="40"><?php
            htmlout($moviename); ?></textarea>
      </div>

      <div>
        <label for="director">Director:</label>
        <select name="director" id="director">
          <option value="">Select one</option>
          <?php foreach ($directors as $director): ?>
            <option value="<?php htmlout($director['id']); ?>"
              <?php
                if ($director['id'] == $directorid)
                {
                  echo ' selected';
                }
              ?>
              >
              <?php htmlout($director['name']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <fieldset>
        <legend>Countries:</legend>
        <?php foreach ($countries as $country): ?>
          <div>
            <label for="country<?php htmlout($country['id']);?>">
            <input type="checkbox" name="countries[]"
              id="country<?php htmlout($country['id']); ?>"
              value="<?php htmlout($country['id']); ?>"
              <?php
                if ($country['selected'])
                {
                  echo ' checked';
                }
              ?>
            >
            <?php htmlout($country['name']); ?>
            </label>
          </div>
        <?php endforeach; ?>
      </fieldset>

      <div>
        <input type="hidden" name="id" value="<?php
            htmlout($id); ?>">
        <input type="submit" value="<?php htmlout($button); ?>">
      </div>
    </form>
  </body>
</html>