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
  <title>Listado de Usuarios</title>
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
            <h1 class="m-0">Listado de Usuarios</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin. Usuarios</a></li>
              <li class="breadcrumb-item active">Listado de Usuarios</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
      <br>
      <div class='form-group'>
      <form action="#" autocomplete="off">
        <div class='row'>
            <div class='col-md-3'>
              <label for='nombre'>Nombre de Usuario</label>
              <input type='text' class='form-control' id='txtNombreSearch' name='txtNombreSearch' placeholder='Escriba el nombre de usuario' onchange='buscarUsuario()'>
            </div>
            <div class='col-md-3'>
              <label for='correo'>Correo</label>
              <input type='text' class='form-control' id='txtCorreoSearch' name='txtCorreoSearch' placeholder='Escriba el correo' onchange='buscarUsuario()'>
            </div>
            <div class='col-md-2'>
              <label for='rol'>Rol</label>
              <select class='form-control' id='selectPerfil' name='selectPerfil' onchange='buscarUsuario()'>
              </select>
            </div>
            <div class='col-md-2'>
              <label for='estado'>Estatus</label>
              <select class='form-control' id='selectEstatus' name='selectEstatus' onchange='buscarUsuario()'>
                <option value='' disabled selected>Seleccione un Estatus</option>
                <option value='1'>Activo</option>
                <option value='0'>Inactivo</option>
              </select>
            </div>
          <div class='col-md-2'>
            <br>
            <button type='button' class='btn btn-primary' id='btnBuscar' onclick='buscarUsuario()'>Buscar</button>
            <button type='button' class='btn btn-secondary' id='btnResetFiltro' onclick='resetFiltros()'>Reiniciar filtros</button>
          </div>
          </div>
        </form>
      </div>
      <span id='tblUsuarios'></span>
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
    echo '<script async src="assets/js/listado-usuarios.js?token='.date('YmdHis').'"></script>';
?>

</body>
</html>
