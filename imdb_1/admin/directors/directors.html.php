<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Manage Directors</title>
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
                  <a href=".."> Home </a>
              </li>
              <li class = "dropdown ">
                  <a href="#" class= "dropdown-toggle " data-toggle="dropdown"> Movies <b class = "caret"></b> </a>
                  <ul class = "dropdown-menu">
                    <li> <a href="../movies/"> Movies </a> </li>
                    <li> <a href="../movies/popular.html.php"> Popular now </a> </li>
                    <li> <a href="../movies/upcoming.html.php"> Upcoming </a> </li>
                    <li> <a href="#"> Reserved </a> </li>
                  </ul>
              </li>
              <li class = "dropdown active">
                  <a href="#" class= "dropdown-toggle" data-toggle="dropdown"> Director <b class = "caret"></b> </a>
                  <ul class = "dropdown-menu">
                      <li> <a href="../directors/"> Director </a> </li>
                      <li> <a href="#"> Reserved </a> </li>
                      <li> <a href="#"> Reserved+ </a> </li>
                      <li> <a href="#"> Reserved </a> </li>
                  </ul>
              </li>
              <li>
                  <a href="../countries/"> Country </a>
              </li>
              <li>
                  <a href="#contact" data-toggle="modal"> Contact </a>
              </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="jumbotron">
        <center><h2> Missing director? 
        <a href="?add" class="btn btn-info">  Add director </a> 
      </center>
      </div>
    </div>



    <div class="container">
      <div class ="row">
        <div class = "col-md-7 col-md-offset-3">
          <div class = "panel panel-default">
            <div class = "panel-body"> 
              <table class="table table-striped"> 

                <tr>
                    <h2></h2>
                    <th>Director</th>
                    <th>Country</th>
                    <th></th>
                    <th></th>
                </tr>

                          
                      <?php foreach ($directors as $director): ?>
                    <tr>
                          <form action="" method="post">
                            <div>
                              <td class = "col-md-4">
                                  <?php htmlout($director['name']); ?>
                              </td>
                              <td class = "col-md-3"><?php htmlout( getcountryfromdirector($director['countryid']) ); ?></td> 
                              <td></table-striped>
                              <td class = "col-md-4">
                                  <input type="hidden" name="id" value="<?php
                                      echo $director['id']; ?>">
                                  <input type="submit" name="action" value="Edit" class = "btn btn-default">
                                  <input type="submit" name="action" value="Delete" class = "btn btn-danger">
                              </td>
                            </div>
                          </form>
                      <?php endforeach; ?>

                    </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>





    <div class = "wrapper">
      <div class = "navbar navbar-default navbar-fixed-bottom">
        <div class = "container">
          <a href = ".." class = "navbar-btn btn-default btn pull-right "> Return to homepage </a>
        </div>
      </div>
    </div>
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="../../../boot/js/bootstrap.js"></script>
  </body>
</html>