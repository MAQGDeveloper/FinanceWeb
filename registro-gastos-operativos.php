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
  <title>Men&uacute; Principal</title>
  <?php
  include_once 'librarys.php';
  ?>
</head>
<style>
  .vl {
    border-left: thick solid #7C9FEC;
  }
</style>
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
            <h1 class="m-0">Registro Gastos Operativos</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Registro Gastos Operativos</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
      <form autocomplete="off" onsubmit="guardarUsuario(); return false;">
        <p style="color: red">* Para realizar una b&uacute;squeda puede filtrar por fecha de pago y semana de pago.</p>
        <br>
        <div class="row">
          <div class= 'col-sm-1'>
            <div class="form-group">
              <label for="exampleInputID1">Estatus</label>
              <input type="text" class="form-control" id="txtEstatus"  placeholder="" style="background-color: #0F192A;" value="Borrador" disabled>
            </div>
          </div>
          <div class= 'col-sm-1'>
            <div class="form-group">
              <label for="exampleInputID1">Folio:</label>
              <input type="text" class="form-control" id="txtGastoID"  placeholder="" style="background-color: #0a001f;" disabled>
            </div>
          </div>

          <div class= 'col-sm-1'>
            <div class="form-group">
              <label for="exampleInputID1">N&uacute;mero Factura:</label>
              <input type="text" class="form-control" id="txtGastoID"  placeholder="" style="background-color: #004c40; cursor: pointer">
            </div>
          </div>

          <div class= 'col-sm-2'>
            <div class="form-group">
              <label for="exampleFormControlStand1">Empresa o Servicio</label>
              <select class="form-control" id="selEmpServ" style="cursor: pointer">
                <option value='-' selected disabled>Selecciona una Opci&oacute;n</option>
                <option value="0">Empresa</option>
                <option value="1">Servicio</option>
              </select>
            </div>
          </div>

          <span id="selectOpcionSel"></span>

          <div class= 'col-sm-4'>
            <div class="form-group">
              <label for="exampleInputID1">Nombre Gasto:</label>
              <input type="text" class="form-control" id="txtGastoID"  placeholder="" style="cursor: pointer">
            </div>
          </div>


          <div class= 'col-sm-2'>
            <div class="form-group">
              <label for="exampleInputMonto1">Monto:</label>
              <input type="text" min="1" step="any" pattern="[0-9.,]+" data-type="number" class="form-control" id="txtMonto" placeholder="$ Importe" style="cursor: pointer" mask="numeric">
            </div>
          </div>
          <div class= 'col-sm-2'>
            <div class="form-group">
              <label for="exampleInputFecha1">Fecha de pago</label>
              <input type="date" class="form-control" id="txtFechaPago" placeholder="Clic para seleccionar fecha" style="cursor: pointer">
            </div>
          </div>
          <div class= 'col-sm-3'>
            <div class="form-group">
              <label for="exampleFormControlStand1">Semana de pago</label>
              <select class="form-control" id="selSemanas" style="cursor: pointer">
                <option value='-' selected disabled>Selecciona una Opci&oacute;n</option>
              </select>
            </div>
          </div>
          <button type='button' class='btn btn-primary' id='btnRegistro' onclick='guardarGastoInterno()'>Registrar Gasto</button>&nbsp;&nbsp;
          <div class="vl"></div>&nbsp;&nbsp;
          <button type='button' class='btn btn-secondary' id='btnBuscarGastos' onclick='buscarGastos()'>Buscar</button>&nbsp;&nbsp;
          <button type='button' class='btn btn-secondary' id='btnBuscarGastos' onclick='resetFiltros()'>Reiniciar Filtros</button>
      </form>
    </div>
    <h2>Listado de Gastos Operativos:</h2>
    <span id="tblGastosInternos"></span>
    <span id="modalEditarGI"></span>
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
echo '<script async src="assets/js/registro-gastos-operativos.js?token='.date('YmdHis').'"></script>';
?>
</body>
</html>
