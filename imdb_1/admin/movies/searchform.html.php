<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Manage Movie</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../boot/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../../../boot/css/style.css" rel="stylesheet">
  </head>
  <body>
    <div class="navbar navbar-inverse navbar-static-top">
            <div class = "container">

                <div class="navbar-header">

                    <a href=".." class = "navbar-brand"> My IMDB </a>
                    <button class = "navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse navHeaderCollapse">

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="#"> Home </a>
                        </li>
                        <li class = "active"  >
                            <a href="movies/"> Movies </a>
                        </li>
                        <li class = "dropdown">
                            <a href="#" class= "dropdown-toggle" data-toggle="dropdown"> Director <b class = "caret"></b> </a>
                            <ul class = "dropdown-menu">
                                <li> <a href="directors/"> Director </a> </li>
                                <li> <a href="#"> Reserved </a> </li>
                                <li> <a href="#"> Reserved+ </a> </li>
                                <li> <a href="#"> Reserved </a> </li>
                            </ul>
                        </li>
                        <li>
                            <a href="countries/"> Country </a>
                        </li>
                        <li>
                            <a href="#contact" data-toggle="modal"> Contact </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

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