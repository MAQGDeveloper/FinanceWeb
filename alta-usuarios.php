<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Alta Usuario</title>
  <?php
    //Validar si existe cookie de sesion
    session_start();
    if(!isset($_COOKIE['key_sesion'])){
      header('Location: login.php');
      die();
    }
    include_once 'librarys.php';
    include_once 'centinel.php';
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
            <h1 class="m-0">Alta de Usuarios</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Alta Usuarios</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
      <form autocomplete="off" onsubmit="guardarUsuario(); return false;">
        <br>
          <div class="row">
        <div class= 'col-sm-3'>
          <div class="form-group">
            <label for="exampleInputName1">Nombre de Usuario</label>
            <input type="Name" class="form-control" id="txtNombre" placeholder=" Introduzca su Nombre de Usuario">
          </div>
        </div>
        <div class= 'col-sm-3'>
          <div class="form-group">
            <label for="exampleInputEmail1">Correo</label>
            <input type="email" class="form-control" id="txtEmail"  placeholder=" Introduzca un correo electronico">
          </div>
        </div>
          <div class= 'col-sm-2'>
            <div class="form-group">
              <label for="exampleInputEmail1">Contrase&ntilde;a</label>
              <input type="password" class="form-control" id="txtPassword" placeholder="Contrase&ntilde;a">
            </div>
          </div>
          <div class= 'col-sm-2'>
            <div class="form-group">
              <label for="exampleInputEmail1">Confirmar Contrase&ntilde;a</label>
              <input type="password" class="form-control" id="txtConfirmarPassword" placeholder="Confirmar Contrase&ntilde;a">
            </div>
          </div>
          <div class= 'col-sm-2'>
          <div class="form-group">
          <label for="exampleFormControlStand1">Puesto</label>
          <select class="form-control" id="selPuesto">
          </select>
        </div>
        </div>
        <div class= 'col-sm-2'>
          <div class="form-group">
            <label for="exampleFormControlActive1">Activo</label>
            <select class="form-control" id="selActivo">
              <option value='1'>Si</option>
              <option value='0'>No</option>
            </select>
          </div>
        </div>
        <div class= 'col-sm-2' hidden>
          <div class="form-group">
            <label for="exampleFormControlPerfil-Select1">Perfil</label>
            <select class="form-control" id="selPerfil">
              <option>Perfil 1</option>
              <option>Perfil 2</option>
            </select>
          </div>
        </div>
        <button class="btn btn-primary" type='submit'>Guardar</button>
      </form>
  </div>
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
    echo '<script type="text/javascript" src="assets/js/alta-usuarios.js?token='.date('YmdHis').'"></script>';
?>
</body>
</html>
