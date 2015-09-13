<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php htmlout($pageTitle); ?></title>
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
              <li>
                <a href="../directors"> Director </a>
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
      <div class = "row">  
        <div class = "col-md-8 col-md-offset-2">
          <div class = "panel panel-default">
            <div class = "panel-body">
              <div class = "page-header col-md-offset-2">
                <h3 ><?php htmlout($pageTitle); ?> 
                </h3>
              </div>
              <form action="?<?php htmlout($action); ?>" method="post" class = "form-horizontal">
                <div class = "form-group">
                  <label for="moviename" class = "col-lg-4 control-label">Country name:</label>
                  <div class = "col-lg-6">
                     <input type="text" name="name"
                      id="name" value="<?php htmlout($name); ?>" placeholder = "France" class = "form-control" >
                    
                  </div>
                </div> 

                <div>
                  <input type="hidden" name="id" value="<?php
                    htmlout($id); ?>">
                  <input type="submit" value="<?php htmlout($button); ?>" class="btn btn-success pull-right"> 
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>



    <div class='wrapper'>
      <div class = "navbar  navbar-default navbar-fixed-bottom">
        <div class = "container">
          <a href = ".." class = "navbar-btn btn-info btn pull-right "> Return to homepage </a>
          <a href = "?goview" class = "navbar-btn btn-default btn pull-right"> Return to view movies </a>
        </div>
      </div> 
    </div>  
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="../../../boot/js/bootstrap.js"></script>
  </body>
</html>