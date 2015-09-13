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
                  <a href=".."> Home </a>
              </li>
              <li class = "dropdown active">
                  <a href="#" class= "dropdown-toggle " data-toggle="dropdown"> Movies <b class = "caret"></b> </a>
                  <ul class = "dropdown-menu">
                      <li> <a href="../movies"> Movies </a> </li>
                      <li> <a href="popular.html.php"> Popular now </a> </li>
                      <li> <a href="popular.html.php"> Upcoming </a> </li>
                      <li> <a href="#"> Reserved </a> </li>
                  </ul>
              </li>
              <li class = "dropdown">
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
      <div class = "row">  

        <div class = "col-md-6 col-md-offset-3">
          <div class = "panel panel-default">
            <div class = "panel-body">
              <div class = "page-header">
                <h3> View movies with the following criteria:  </h3>
              </div>
              <form action="" method="get" class = "form-horizontal">
                <div class = "form-group">

                  <label for="director" class = "col-lg-5 control-label">By director:</label>
                  <div class = "col-lg-6">
                    <select name="director" id="director" class = "form-control">
                      <option value="">Any director</option>
                      <?php foreach ($directors as $director): ?>
                        <option value="<?php htmlout($director['id']); ?>"><?php
                            htmlout($director['name']); ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>


                </div> 
                <div class = "form-group">
                  <label for="country" class = "col-lg-5 control-label">By country:</label>
                  <div class = "col-lg-6">
                    <select name="country" id="country" class = "form-control">
                      <option value="">Any country</option>
                      <?php foreach ($countries as $country): ?>
                        <option value="<?php htmlout($country['id']); ?>"><?php
                            htmlout($country['name']); ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div> 
                <div class = "form-group">
                  

                  <label for="text" class = "col-lg-5 control-label">Containing text:</label>
                  <div class = "col-lg-6">
                    <input type="text" name="text" id="text" placeholder = "Pulp Fiction" class = "form-control">
                  </div>
                </div>
                <div>  

                  <input type="hidden" name="action" value="search" >
                  <input type="submit" value="Search" class="btn btn-default pull-right">
                </div>
              </form>
            </div>
          </div>
        </div>

      </div>

    </div>













    <div class="modal fade" id = "contact" role="dialog">
      <div class="modal-dialog"> 

        <div class="modal-content">
          
          <form class = "form-horizontal">
            <div class="modal-header">
              <h4> Contact my site </h4>
            </div>

            <div class= "modal-body">
              
              <div class = "form-group">
                <label for = "contact-name" class = "col-lg-2 control-label"> Name: </label>
                <div class = "col-lg-10">
                  <input type = "text" class = "form-control" id = "contact-name" placeholder = "Full Name">
                </div>
              </div>

              <div class = "form-group">
                <label for = "contact-email" class = "col-lg-2 control-label"> Email: </label>
                <div class = "col-lg-10">
                  <input type = "email" class = "form-control" id = "contact-email" placeholder = "you@example.com">
                </div>
              </div>

              <div class = "form-group">
                <label for = "contact-msg" class = "col-lg-2 control-label"> Email: </label>
                <div class = "col-lg-10">
                  <textarea class = "form-control" rows = 8> </textarea>
                </div>
              </div>

            </div>

            <div class = "modal-footer">
              <a class="btn btn-default" data-dismiss="modal"> Close </a>
              <button class = "btn btn-primary" type = "submit"> Send </button>
            </div>
          </form>

        </div>
      </div>
    </div>









    <div class = "navbar navbar-default navbar-fixed-bottom">
      <div class = "container">
        <a href = ".." class = "navbar-btn btn-info btn pull-right "> Return to homepage </a>
        <a href = "?goview" class = "navbar-btn btn-default btn pull-right"> Return to view movies </a>
      </div>
    </div>
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="../../../boot/js/bootstrap.js"></script>
  </body>
</html>