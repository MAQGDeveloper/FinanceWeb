      <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index.php" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Administrador</span>
      </a>
      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="info">
            <a href="#" class="d-block">Bienvenid@</a>
            <code id="txtPuesto"></code><br>
            <span id="txtUsuario"></span><br><small id="txtCorreo"></small>
          </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
            <li id="sdMenuPrincipal" style="visibility: hidden;">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="index.php" class="nav-link active" id='linkMenuPrincipal'>
                    <i class="fas fa-home nav-icon"></i>
                    <p>Men&uacute; Principal</p>
                  </a>
                </li>
              </ul>
            </li>

            <!-- Configuracion de usuarios -->
            <li id="sdMantenUsuario" style="visibility: hidden;">
              <a href="#" class="nav-link active">
                <i class="nav-icon fa fa-user-alt"></i>
                <p>
                  Admin. Usuarios
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="alta-usuarios.php" class="nav-link active" id='linkAltaUsuario'>
                    <i class="fas fa-user nav-icon"></i>
                    <p>Alta de Usuario</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="listado-usuarios.php" class="nav-link active" id='linkListUsuarios'>
                    <i class="fas fa-user nav-icon"></i>
                    <p>Listado de Usuario</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="catalogo-puesto.php" class="nav-link active" id='linkCatPuesto'>
                    <i class="fas fa-user nav-icon"></i>
                    <p>Cat&aacute;logo Puesto</p>
                  </a>
                </li>
              </ul>
            </li>
          <!-- Configuracion de reporte -->
          <li id="sdMantenReporte" style="visibility: hidden;">
              <a href="#" class="nav-link active">
                <i class="nav-icon fa fa-user-alt"></i>
                <p>
                  Admin. Reportes
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
<!--              <ul class="nav nav-treeview">-->
<!--                <li class="nav-item">-->
<!--                  <a href="catalogo-semanas.php" class="nav-link active" id='linkCatSem'>-->
<!--                    <i class="fas fa-user nav-icon"></i>-->
<!--                    <p>Cat&aacute;logo Semanas</p>-->
<!--                  </a>-->
<!--                </li>-->
<!--              </ul>-->
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="catalogo-clientes.php" class="nav-link active" id='linkCatCli'>
                    <i class="fas fa-user nav-icon"></i>
                    <p>Cat&aacute;logo Clientes</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="catalogo-servicio.php" class="nav-link active" id='linkCatServ'>
                    <i class="fas fa-user nav-icon"></i>
                    <p>Cat&aacute;logo Servicios</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="catalogo-gasto.php" class="nav-link active" id='linkCatGasto'>
                    <i class="fas fa-user nav-icon"></i>
                    <p>Cat&aacute;logo Gastos</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="catalogo-empresa.php" class="nav-link active" id='linkCatEmp'>
                    <i class="fas fa-user nav-icon"></i>
                    <p>Cat&aacute;logo Empresa</p>
                  </a>
                </li>
              </ul>
            </li>

            <!-- Formatos de Registro -->
            <li id="sdFormatos" style="visibility: hidden;">
              <a href="#" class="nav-link active">
                <i class="nav-icon fa fa-user-alt"></i>
                <p>
                  Registros
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="registro-gastos-internos.php" class="nav-link active" id='linkRegInt'>
                    <i class="fas fa-user nav-icon"></i>
                    <p>Registro Gastos Internos</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="registro-gastos-operativos.php" class="nav-link active" id='linkRegGasOp'>
                    <i class="fas fa-user nav-icon"></i>
                    <p>Registro Gastos Operativos</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="registro-gastos.php" class="nav-link active" id='linkRegGas'>
                    <i class="fas fa-user nav-icon"></i>
                    <p>Registro Gastos</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="registro-factura-pagos.php" class="nav-link active" id='linkRegFacPa'>
                    <i class="fas fa-user nav-icon"></i>
                    <p>Registro Factura y Pagos</p>
                  </a>
                </li>
              </ul>
            </li>




          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
</aside>
<?php
    echo '<script async src="assets/js/sidebar.js?token='.date('YmdHis').'"></script>';
?>
