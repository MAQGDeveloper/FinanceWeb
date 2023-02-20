<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
    include('librarys.php');
?>
<link rel="stylesheet" href="assets/css/login.css">
<link rel="stylesheet" href="assets/css/owl.carousel.min.css">
<link rel="stylesheet" href="assets/css/libs/mac-osx.css">
</head>
<body style="overflow: hidden; background: linear-gradient(to right, #2B32B2, #1488CC);" ng-app="">
<div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6" id="splashImage">
          <img src="assets/img/undraw_remotely_2j6y.svg" alt="Image" class="img-fluid">
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="mb-4">
              <h3 style="color: white;">Iniciar Sesi&oacute;n</h3>
              <p class="mb-4">Ingresa tus credenciales de acceso:</p>
            </div>
            <form action="#" method="post" autocomplete="off">
              <div class="form-group first" style="background: linear-gradient(80deg, aqua, transparent); border-bottom-width: 0px">
                <input type="text" class="form-control" id="txtCorreo" placeholder="Correo o Usuario" style="font-weight: bold;">
              </div>
              <div class="form-group last mb-4" style="background: linear-gradient(80deg, aqua, transparent); border-bottom-width: 0px">
                <input type="password" class="form-control" id="password" placeholder="Contrase&ntilde;a" style="font-weight: bold;">
              </div>
              <button type="button" onclick="userLogIn()"class="btn btn-block btn-primary" style = "background: linear-gradient(to right, #85C9F5 , #37A8F1);color: black; border-radius: 100px;"> <b>Iniciar Sesion</b></button>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
    echo '<script src="assets/js/login.js?token='.date('YmdHis').'"></script>';
  ?>
</body>
</html>