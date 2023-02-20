$(function() {
  //Agrega propiedad a la clase para que se muestre el icono de menu principal
  $('#sdFormatos').addClass('menu-open');
  //Se agrega color a la opcion elegida
  $('#linkRegInt').css('background-color', 'cornflowerblue');
  obtenerultimoid();
  //Obtener listado de registros de gastos
  listadoGI();
  //Obtener el listado de semanas
  listadoSemanas();
});
$('#txtMonto').keydown(function(e) {
  setTimeout(() => {
    let parts = $(this).val().split(".");
    let v = parts[0].replace(/\D/g, ""),
      dec = parts[1]
    let calc_num = Number((dec !== undefined ? v + "." + dec : v));
    let n = new Intl.NumberFormat('es-MX').format(v);
    n = dec !== undefined ? n + "." + dec : n;
    $(this).val(n);
  })
})
//Funcion para obtener el ultimo id de la tabla de gastos internos
function obtenerultimoid() {
  $.ajax({
    url: 'scripts/obtener-ultimo-id-gastos-internos.php',
    type: 'POST',
    dataType: 'json',
    success: function(data) {
        //Se agrega el id al input
        document.getElementById('txtGastoID').value = data.id;
    },
    error: function(response) {
      swal.fire("Oops...", response.message, "error");
    }
  });
}
//Funcion para guardar los datos del gasto interno
function guardarGastoInterno() {
  //Se obtienen los valores de los inputs
  const gastoID = document.getElementById('txtGastoID').value;
  const monto = document.getElementById('txtMonto').value;
  //Se quitan comas y puntos del monto
  const montoSinFormato = monto.replace(/,/g, '').replace(/\./g, '');
  const fecha = document.getElementById('txtFechaPago').value;
  const semana_pago = document.getElementById('selSemanas').value;
  //Se valida que ninguno de los campos este vacio
  if(gastoID == ''  || monto == '' || fecha == '' || semana_pago == '-') {
    swal.fire("Oops...", "Llene todos los campos antes de guardar", "error");
    return;
  }
  //Se genera el objeto con los datos
  const data = {
    gastoID: gastoID,
    monto: montoSinFormato,
    fecha: fecha,
    semana_pago: semana_pago
  };
  //Se envia la informacion al servidor
  $.ajax({
    url: 'scripts/guardar-gasto-interno.php',
    type: 'POST',
    data: JSON.stringify(data),
    dataType: 'json',
    success: function(data) {
      //swal con mensaje de exito y redireccion a la pagina de gastos internos
      swal.fire("Exito", data.message, "success").then(function() {
        location.reload();
      });
    },
    error: function(response) {
      swal.fire("Oops...", response.message, "error");
    }
  });
}
//Funcion para obtener gastos internos y mostrarlos en la tabla
function listadoGI() {
  $("#tblGastosInternos").empty();
  $("#tblGastosInternos").append(`<div class="row">
    <div class="input-field col-sm-12">
        <div class="box box-solid box-primary">
            <div class="box-body" >
     <br><table class='table table-bordered table-hover' id="tableModules">
     <thead>
     <tr class='bg-primary' >
     <th>Estatus</th>
     <th>Folio</th>
     <th>Monto</th>
     <th>Fecha Pago</th>
     <th>Semana de pago</th>
     <th>Acciones</th>
     </tr>
     </thead>
     <tbody id="bodyTable">`);
  $.ajax({
    url: 'scripts/listado-gastos-internos.php',
    type: 'POST',
    dataType: 'json',
    success: function(data) {
      //Se recorre el array de datos
      for (var i = 0; i < data.length; i++) {
        //Se agrega el registro a la tabla
        let estatus = '';
        let styleTD = '';
        if(data[i].estatus == 1) {
          estatus = 'Registrado';
          //Se cambia color de la celda
          styleTD = 'style="background-color: #00a65a; color: white;"';
          button = '';
        }
        else if(data[i].estatus == 2) {
          estatus = 'Cancelado';
          //Se cambia color de la celda
          styleTD = 'style="background-color: #dd4b39; color: white;"';
        }else{
          estatus = 'Borrador';
          //Se cambia color de la celda
          styleTD = 'style="background-color: #6C3BDC; color: white;"';
        }
        //Se da formato numerico al monto
        let monto = new Intl.NumberFormat("es-MX", {style: "currency", currency: "MXN"}).format(data[i].monto);
        $('#bodyTable').append('<tr><td '+styleTD+'>' + estatus + '</td><td>' + data[i].id_gasto_interno + '</td><td>' + monto + '</td><td>' + data[i].fecha_pago + '</td><td>SEMANA ' +data[i].numero_semana+': '+data[i].semana_periodo+ '</td><td><button class="btn btn-success" data-toggle="modal" data-target="#myModal" onclick="editarGI('+data[i].id_gasto_interno+')">Editar</button></td></tr>');
      }
    },
    error: function(response) {
      //Se muestra tabla no hay registros
      $('#tblGastosInternos').append('<tr><td colspan="6">No hay registros en la Base de datos</td></tr>');
    }
  });
}
//Funcion para crear modal de edicion del registro
const editarGI = (id) => {
  //Se llena el select de semanas de pago
  let d = {
    flag: true
  }
  //Variable donde se guardara el html del select
  let select = '';
  $.ajax({
    type: "POST",
    url: 'scripts/obtener-semana-guardada.php',
    dataType: "json",
    data: JSON.stringify(d),
    async: false,
    success: function(data){
      for (var i = 0; i < data.length; i++) {
        select += '<option value="'+data[i].id_catalogo_semana+'">SEMANA '+data[i].numero_semana+': '+data[i].semana_periodo+'</option>';
      }
    },
    error: function() {
    }
  });
  let data ={
    id: id
  }
  $("#modalEditarGI").empty();
  $("#modalEditarGI").append(`<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModal">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #00004f">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-left: 0;"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"> Editar Gasto Interno</h4>
      </div>
      <div class="modal-body" style="background-color: #514aac" id="bodyModal">`);
  $.ajax({
    type: "POST",
    url: 'scripts/obtener-gasto-interno.php',
    dataType: "json",
    async: true,
    data: JSON.stringify(data),
    success: function(data){
      let habilitar = '';
      let visible = '';
      let visibleRechazo = '';
      let visibleGuardar = '';
      for (var i = 0; i < data.length; i++) {
        let estatus = '';
        let styleTD = '';

        let button = '';
        if(data[i].estatus == 1) {
          estatus = 'Registrado';
          //Se cambia color de la celda
          styleTD = 'style="background: #00a65a; color: white; pointer-events:none;"';
          habilitar = 'disabled = disabled';
          visibleGuardar ='hidden';
        }
        else if(data[i].estatus == 2) {
          estatus = 'Cancelado';
          //Se cambia color de la celda
          styleTD = 'style="background: #dd4b39; color: white;"';
          habilitar = 'disabled';
          //Se oculta el boton de rechazar
          visibleRechazo = 'hidden';
        }else{
          estatus = 'Borrador';
          //Se cambia color de la celda
          styleTD = 'style="background: #6C3BDC; color: white; cursor: pointer;"';
          habilitar = '';
          visible = 'style="background-color: #64dd17; color: black; display: none;"';

        }
        //Se da formato numerico al monto
        let monto = new Intl.NumberFormat("es-MX", {style: "currency", currency: "MXN"}).format(data[i].monto);
        $("#modalEditarGI").find(".modal-body").append(`<div class="row">
              <div class="col-sm-2" "`+styleTD+`">
                <input class="form-control" id="txtEstatus" value="`+estatus+`" `+styleTD+` disabled>
                <label for="txtEstatus" style="color: black;">Estatus</label>
              </div>
              <div class="col-sm-2">
                <input class="form-control" id="txtFolioGI" value="`+data[i].id_gasto_interno+`" disabled style="cursor: pointer;">
                <label for="txtFolioGI" style="color: black;">Folio</label>
              </div>
              <div class="col-sm-3">
                <input type='number' class="form-control" id="txtMontoGI" value="`+data[i].monto+`" `+habilitar+` style="cursor: pointer;">
                <label for="txtMontoGI" style="color: black;">Monto</label>
              </div>
              <div class="col-sm-3">
                <input type='date' class="form-control" id="txtFechaGI" value="`+data[i].fecha_pago+`" `+habilitar+` style="cursor: pointer;">
                <label for="txtFechaGI" style="color: black;">Fecha Pago</label>
              </div>
              <div class="col-sm-5">
              <select class="form-control" id="selSemanasGI" style="cursor: pointer" `+habilitar+`>`+select+`</select>
                <label for="txtSemanaPagoGI" style="color: black;">Semana de Pago</label>
              </div>
</div>`);
        //Se setea el valor del select a partir del id de la semana
        $("#selSemanasGI").val(data[i].semana_pago);
      }
      $("#modalEditarGI").find(".modal-body").append(`</div><div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="regresarBorrador()" `+visible+`><i class="fa fa-floppy-o" aria-hidden="true"></i> Regresar a Borrador</button>
          <button type="button" class="btn btn-danger"  style="background-color: #dd2c00; color: white;" onclick="rechazarFormato()"`+visibleRechazo+`>Rechazar</button>
          <button type="button" class="btn btn-primary" onclick="guardarReporte()" style="background-color: #64dd17; color: black;" `+habilitar+` `+visibleRechazo+` `+visibleGuardar+`><i class="fa fa-floppy-o" aria-hidden="true"></i> GUARDAR CAMBIOS</button>
          <button type="button" class="btn btn-default" data-dismiss="modal" style=" color: white;">Cerrar</button>
          </div>
          </div>
          </div>
          </div>`);
    },
    error: function() {
    }
    });
}
//Funcion para regresar a borrador el registro
const regresarBorrador = () => {
  let data = {
    id: $("#txtFolioGI").val(),
    estatus: 0
  }
  $.ajax({
    type: "POST",
    url: 'scripts/regresar-borrador-GI.php',
    dataType: "json",
    async: true,
    data: JSON.stringify(data),
    success: function(data){
      swal.fire("Exito", data.message, "success").then(function() {
        location.reload();
      });
    },
    error: function() {
      swal.fire("Error", "Error al regresar a borrador", "error");
    }
    });
}
//Funcion para guardar los cambios del reporte y cambiar a estatus Registrado
const guardarReporte = () => {
  let data = {
    id: $("#txtFolioGI").val(),
    monto: $("#txtMontoGI").val(),
    fecha: document.getElementById('txtFechaGI').value,
    semana: $("#selSemanasGI").val(),
    estatus: 1
  }

  $.ajax({
    type: "POST",
    url: 'scripts/guardar-cambios-GI.php',
    dataType: "json",
    async: true,
    data: JSON.stringify(data),
    success: function(data){
      swal.fire("Exito", data.message, "success").then(function() {
        location.reload();
      });
    },
    error: function() {
      swal.fire("Error", "Error al guardar cambios", "error");
    }
    });
}
//Funcion para rechazar formato
const rechazarFormato = () => {
  let data = {
    id: $("#txtFolioGI").val(),
    estatus: 2
  }
  $.ajax({
    type: "POST",
    url: 'scripts/rechazar-GI.php',
    dataType: "json",
    async: true,
    data: JSON.stringify(data),
    success: function(data){
      swal.fire("Exito", data.message, "success").then(function() {
        location.reload();
      });
    },
    error: function() {
      swal.fire("Error", "Error al rechazar formato", "error");
    }
    });
}
//Funcion para obtener el listado de semanas
const listadoSemanas = () => {
  $.ajax({
    type: "POST",
    url: 'scripts/obtener-semana-guardada.php',
    dataType: "json",
    async: true,
    success: function(data){
      for (var i = 0; i < data.length; i++) {
        $("#selSemanas").append(`<option value="`+data[i].id_catalogo_semana+`">SEMANA: `+data[i].numero_semana+` - `+data[i].semana_periodo+`</option>`);
      }
    },
    error: function() {
    }
    });
}
//Funcion para buscar gastos especificos
const buscarGastos = () => {
  waitingDialog.show('Buscando Registros...');
 //Se obtienen los valores de los filtros
  const semana = $("#selSemanas").val();
  const fechaPago = document.getElementById('txtFechaPago').value;
  if(semana == "" && fechaPago == ""){
    waitingDialog.hide();
    swal.fire("Error", "Debe seleccionar al menos un filtro", "error");
    return;
  }
  let data = {
    fechaPago: document.getElementById('txtFechaPago').value,
    semana: $("#selSemanas").val(),
  }
    $("#tblGastosInternos").empty();
    $("#tblGastosInternos").append(`<div class="row">
    <div class="input-field col-sm-12">
        <div class="box box-solid box-primary">
            <div class="box-body" >
     <br><table class='table table-bordered table-hover' id="tableModules">
     <thead>
     <tr class='bg-primary' >
     <th>Estatus</th>
     <th>Folio</th>
     <th>Monto</th>
     <th>Fecha Pago</th>
     <th>Semana de pago</th>
     <th>Acciones</th>
     </tr>
     </thead>
     <tbody id="bodyTable">`);
    //Se envia la peticion
    $.ajax({
      type: "POST",
      url: 'scripts/buscar-gastos-internos.php',
      dataType: "json",
      async: true,
      data: JSON.stringify(data),
      success: function(data){
        waitingDialog.hide();
        //Se recorre el array de datos
        for (var i = 0; i < data.length; i++) {
          //Se agrega el registro a la tabla
          let estatus = '';
          let styleTD = '';
          if(data[i].estatus == 1) {
            estatus = 'Registrado';
            //Se cambia color de la celda
            styleTD = 'style="background-color: #00a65a; color: white;"';
            button = '';
          }
          else if(data[i].estatus == 2) {
            estatus = 'Cancelado';
            //Se cambia color de la celda
            styleTD = 'style="background-color: #dd4b39; color: white;"';
          }else{
            estatus = 'Borrador';
            //Se cambia color de la celda
            styleTD = 'style="background-color: #c3a1fa; color: white;"';
          }
          //Se da formato numerico al monto
          let monto = new Intl.NumberFormat("es-MX", {style: "currency", currency: "MXN"}).format(data[i].monto);
          $('#bodyTable').append('<tr><td '+styleTD+'>' + estatus + '</td><td>' + data[i].id_gasto_interno + '</td><td>' + monto + '</td><td>' + data[i].fecha_pago + '</td><td>SEMANA ' +data[i].numero_semana+': '+data[i].semana_periodo+ '</td><td><button class="btn btn-success" data-toggle="modal" data-target="#myModal" onclick="editarGI('+data[i].id_gasto_interno+')">Editar</button></td></tr>');
        }
      },
      error: function() {
        waitingDialog.hide();
        //Se agrega body de no hay registros
        $('#bodyTable').append('<tr><td colspan="6" style="color: red">No se encontraron registros.</td></tr>');
      }
      });
}
//Funcion para reiniciar los filtros
const resetFiltros = () => {
  $("#txtMonto").val("");
  $("#txtFechaPago").val("");
  //Setear selected -
  $("#selSemanas").val($("#selSemanas option:first").val());
  listadoGI();
}
