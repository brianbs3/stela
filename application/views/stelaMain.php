<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/toastr.css">
    <link rel="stylesheet" href="public/css/stela.css">


    <title>Hello, world!</title>
  </head>
  <body>
  <?php
//   echo" user: {$data['user']}";
//    echo"<br>admin: {$data['admin']}";
  ?>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">La Dolce Vita</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-item nav-link active" href="#">Home <span class="sr-only">(current)</span></a>
        <a class="nav-item nav-link" onClick='clientClick()' href="#">Clients</a>
        <a class="nav-item nav-link" onClick='productClick()' href="#">Products</a>
        <a class="nav-item nav-link" onClick='appointmentsClick()' href="#">Appointments</a>

        <div class="dropdown">
          <?php
          print"<button class='btn btn-secondary dropdown-toggle' type='button' id='dropdownMenu2' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
              ?>
            Forms
          </button>
          <div class="dropdown-menu" align="right" aria-labelledby="dropdownMenu2">
            <?php

//              $link = "http://" . base_url('index.php/CheckIn');
            $link = "index.php/CheckIn";
              print"<a class='nav-item nav-link' href='$link'>CheckIn</a>";
            ?>
          </div>
        </div>
      </div>
    </div>
  </nav>
    <div id=stelaMain>
      <h1>Hello!</h1>
    </div>

    <script src="public/js/jquery.min.js"></script>
    <script src="public/js/popper.min.js"></script>
    <script src="public/js/bootstrap.min.js"></script>
    <script src="public/js/toastr.min.js"></script>
    <script src="public/js/stela-min.js"></script>


  </body>
</html>
