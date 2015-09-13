<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- <meta charset="utf-8"> -->
    <title>Upcoming</title>
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
                      <li> <a href="#"> Upcoming </a> </li>
                      <li> <a href="highrated.html.php"> Highly rated </a> </li>
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
      <div class="jumbotron">
        <center><h1>  </h1>
        <h3> Live feed of upcoming films 
        <a href="../movies" class="btn btn-default"> Movies </a>
        <a href="popular.html.php" class="btn btn-warning">  Popular now </a>
        <a href="highrated.html.php" class="btn btn-success">  Highly rated </a>
      </center>
      </div>
    </div>
    


    <div class="container">
      <div class ="row">
        

        <div class = "col-md-8 col-md-offset-2">
          <div class = "panel panel-default">
            <div class = "panel-body">
              
              <form action="" method="get">
                <div>
                  <?php 
                  if (!isset($json_upcoming)) {
                    //echo "not setttt";
                    $url1 = file_get_contents("http://api.themoviedb.org/3/movie/upcoming?api_key=0a497969dcb2f9f6c0f1007683a8df67");
                    $json1 = json_decode($url1, true); //This will convert it to an array
                    $json_upcoming = $json1['results'];
                  }
                  ?>
                  <table class="table table-striped">
                    <tr>
                      <th>Movie Name</th>
                      <th>Release date</th>
                      <th>Vote Avg</th>
                      <th>Popularity</th>
                      <th>Vote count</th>
                      <th></th>
                    </tr> 

                    

                    <?php foreach ($json_upcoming as $item): ?>
                    <tr>
                      <td class = "col-md-4"><?php htmlout($item['title']); ?></td> 

                      <td class = "col-md-2"><?php htmlout($item['release_date']); ?></td> 
                      <td class = "col-md-2"><?php htmlout($item['vote_average']); ?></td> 
                      <td class = "col-md-2"><?php htmlout(intval($item['popularity'])); ?></td> 
                      <td class = "col-md-2"><?php htmlout($item['vote_count']); ?></td> 
                      
                      <!-- <td>
                        <form action="?" method="post">
                          <div>
                            <input type="hidden" name="id" value="<?php htmlout($movie['id']); ?>">
                            <input type="submit" name="action" value="Edit" class="btn btn-default ">
                            <input type="submit" name="action" value="Delete" class="btn btn-danger">
                          </div>
                        </form>
                      </td> -->
                    </tr>
                    <?php endforeach; ?>
                  </table>
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
          <p class = "navbar-text pull-left"> 
          </p>
          <a href = ".." class = "navbar-btn btn-default btn pull-right"> Return to homepage </a>
        </div>
      </div>  
    </div>  
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="../../../boot/js/bootstrap.js"></script>
  </body>
</html>