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
  <title>Cat&aacute;logo Clientes</title>
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
            <h1 class="m-0">Cat&aacute;logo Clientes</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin. Reportes</a></li>
              <li class="breadcrumb-item active">Cat&aacute;logo Clientes</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
      <br>
      <div class="row">
      <div class= 'col-sm-3'>
          <div class="form-group">
            <label for="exampleInputName1">Nombre</label>
            <input type="text" class="form-control" id="txtNombreCliente" placeholder=" Introduzca su Nombre">
          </div>
        </div>
        <div class= 'col-sm-3'>
          <div class="form-group">
            <label for="exampleInputRfc">RFC</label>
            <input type="text" class="form-control" id="txtRfcCliente"  placeholder=" Introduzca su RFC">
          </div>
        </div>
          <div class= 'col-sm-2'>
            <div class="form-group">
              <label for="exampleInputEmail1">Servicio</label>
              <input type="text" class="form-control" id="txtServicioCliente" placeholder="Introduzca el Servicio">
            </div>
          </div>
          <div class= 'col-sm-2'>
            <div class="form-group">
              <label for="exampleInputEmail1">Empresa</label>
              <input type="text" class="form-control" id="txtEmpresaCliente" placeholder="Introduzca la Empresa">
            </div>
          </div>
          <div class= 'col-sm-2'>
            <div class="form-group">
              <label for="exampleInputEmail1">D&iacute;as credito</label>
              <input type="number" class="form-control" id="txtDiascreditoCliente" placeholder="Introduzca los D&iacute;as credito">
            </div>
          </div>
          <div class= 'col-sm-2'>
            <div class="form-group">
              <label for="exampleInputEmail1">Carga social</label>
              <input type="text" class="form-control" id="txtCargasocialCliente" placeholder="Introduzca la Carga social">
            </div>
          </div>
          <div class= 'col-sm-2'>
            <div class="form-group">
              <label for="exampleInputEmail1">Fee</label>
              <input type="number" class="form-control" id="txtFeeCliente" placeholder="Introduzca Fee">
            </div>
          </div>
        <div class= 'col-sm-2'>
          <div class="form-group">
            <label for="exampleFormControlActive1">Activo</label>
            <select class="form-control" id="selActivoCliente">
              <option value='1'>Si</option>
              <option value='0'>No</option>
            </select>
          </div>
        </div>
        <button class='btn btn-secondary' id='btnBuscar' onclick='buscarCliente()'>Buscar Cliente</button>&nbsp;&nbsp;
        <button class='btn btn-primary' id='btnGuardar' onclick='guardarCliente()'>Guardar Cliente</button>&nbsp;&nbsp;
        <button class='btn btn-primary' id='btnLimpiar' onclick='limpiarCampos()'>Reiniciar Filtros</button>
        </form>
      </form>
      </div>
      <span id='tblClientes'></span>
      <span id='modalEditar'></span>
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
    echo '<script async src="assets/js/catalogo-clientes.js?token='.date('YmdHis').'"></script>';
?>
</body>
</html>
