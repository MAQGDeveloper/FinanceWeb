<?php
 //Validar si existe cookie de sesion
 session_start();
 if(!isset($_COOKIE['key_sesion'])){
  header('Location: login.php');
  die();
 }
 include_once 'centinel.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cat&aacute;logo Servicio</title>
  <?php
    include_once 'librarys.php';
  ?>
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <?php
    include_once 'navbar.php';
    include_once 'navbarRight.php';
  ?>

    <?php
      include_once 'sidebar.php';
    ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Cat&aacute;logo Servicio</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin. Reportes</a></li>
              <li class="breadcrumb-item active">Cat&aacute;logo Servicio</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
      <h4>Registro </h4><br>
      <div class="row">
        <div class= 'col-sm-4'>
          <input type="text" id="txtNombreTipo" class="form-control" placeholder="Escribe nombre del nuevo servicio" style="cursor: pointer">
        </div>
        <div class="col-sm-4" id="groupGuardar">
          <button type="button" class="btn btn-primary" id="btnGuardarServicio" onclick="guardarTipoServicio()">Guardar</button>
        </div>
      </div>
      <br><br>
      <h1>Listado del cat&aacute;logo de servicios</h1>
      <span id="tblCatalogoServicio"></span>
    </div>
    <!-- /.content-header -->
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  <?php
    include_once 'footer.php';
  ?>

</div>
<!-- ./wrapper -->
<?php
    echo '<script async src="assets/js/catalogo-servicio.js?token='.date('YmdHis').'"></script>';
?>
</body>
</html>
