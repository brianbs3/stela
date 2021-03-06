<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="public/css/jquery-ui.min.css">
    <link rel="stylesheet" href="public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/toastr.css">
    <link rel="stylesheet" href="public/css/stela.css">
<!--      <link rel="stylesheet" href="public/css/bulma.css">-->


<?php
    $autocomplete_loading_img = base_url('public_html/jquery_ui/images/ui-anim_basic_16x16.gif');
  //$progress_bar_img = base_url('public_html/jquery_ui/images/pbar-ani.gif');
  echo"
    <style>
      .ui-autocomplete-loading { background: white url(\"$autocomplete_loading_img\") right center no-repeat; }
    </style>
  ";
?>
    <title>Shear Inspirations</title>
  </head>
  <body>
  <?php
//   echo" user: {$data['user']}";
//    echo"<br>admin: {$data['admin']}";
  ?>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Shear Inspirations, LLC</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-item nav-link active" href="#">Home <span class="sr-only">(current)</span></a>
        <a class="nav-item nav-link" onClick='clientClick()' href="#">Clients</a>
         <a class="nav-item nav-link" onClick='productClick()' href="#">Product</a>
        <a class="nav-item nav-link" onClick='tanningClick()' href="#">Tanning</a>
        <a class="nav-item nav-link" onClick='appointmentsClick()' href="#">Appointments</a>

        <div class="dropdown">
          <?php
          print"<button class='btn btn-secondary dropdown-toggle' type='button' id='dropdownMenu2' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
              ?>
            Forms
          </button>
          <div class="dropdown-menu" align="right" aria-labelledby="dropdownMenu2">
            <?php

//
              ?>
              <button type='button' class='btn btn-outline-secondary' id='clientDataFormButton' onClick='uvRadiationForm()'>UV Radiation Consumer Statement Form</button>
              <button type='button' class='btn btn-outline-secondary' id='clientDataFormButton' onClick='checkInForm()'>CheckIn Form</button>
              <button type='button' class='btn btn-outline-secondary' id='clientDataFormButton' onClick='clientDataForm()'>Client Data Form</button>
              <button type='button' class='btn btn-outline-secondary' id='clientDataFormButton' onClick='printElecLabels()'>Elec. Labels</button>
              <?php
            ?>
          </div>
        </div>
      </div>
    </div>
  </nav>
    <div id=stelaMain>
        <br><br>
        <h1>Welcome to Shear Inspirations!</h1>
        <i>
        <?php echo($randomInspiration); ?>
        </i>
    </div>
    <div id="clientNotes"></div>
    <div id="clientFormDiv"></div>
    <div id="clientProfileFormDiv"></div>
    <div id="productFormDiv"></div>
    <div id="appointmentReceiptDiv"></div>
    <div id="spinner">
        <div class="spin"></div>
    </div>

    <script src="public/js/jquery.min.js"></script>
    <script src="public/js/popper.min.js"></script>
    <script src="public/js/bootstrap.min.js"></script>
    <script src="public/js/toastr.min.js"></script>
    <script src="public/js/stela/stela.js"></script>
    <script src="public/js/stela/stelaClient.js"></script>
    <script src="public/js/stela/stelaProduct.js"></script>
    <script src="public/js/stela/stelaTanning.js"></script>
    <script src="public/js/stela/stelaAppointments.js"></script>
    <script src="public/js/moment.min.js"></script>
    <script src="public/js/jquery-ui.min.js"></script>


  </body>
</html>
