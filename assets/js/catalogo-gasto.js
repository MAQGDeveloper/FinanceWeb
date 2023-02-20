$(function() {
  //Agrega propiedad a la clase para que se muestre el icono de menu principal
  $('#sdMantenReporte').addClass('menu-open');
  //Se agrega color a la opcion elegida
  $('#linkCatGasto').css('background-color', 'cornflowerblue');
  //Se llena el listado del catalogo de gastos
  llenarTablaGasto();
});

const guardarTipoGasto = () => {
  //Se obtienen los valores de los inputs
  var tipoGasto = $('#txtNombreGasto').val();
  //Se guarda el valor del select tipo de puesto
  var selectTipoGasto = $('#selTipo').val();
  //Se guarda el valor del select tipo de descripcion
  var selectDescripcion = $('#selDescripcion').val();

  //Se genera un objeto con los valores de los inputs
  var data = {
    tipoGasto: tipoGasto,
    selectTipoGasto: selectTipoGasto,
    selectDescripcion: selectDescripcion
  };
  //Se envia el objeto por ajax
  $.ajax({
    url: 'scripts/guardar-tipo-gasto.php',
    type: 'POST',
    data: JSON.stringify(data),
    dataType: 'json',
    success: function(response) {
      waitingDialog.hide();
      llenarTablaGasto();
      //Se limpian los inputs
      $('#txtNombreGasto').val('');
      swal.fire("Exito", response.message, "success");
    },
    error: function(error) {
      waitingDialog.hide();
      swal.fire("Oops...", error.responseJSON.message, "error");
    }
  });
}
//Funcion para buscar tipo de gasto mediante el filtro de tipo y descripcion
const buscarTipoGasto = () => {
  //Se obtiene el valor del select tipo de puesto
  var selectTipoGasto = $('#selTipo').val();
  //Se obtiene el valor del select tipo de descripcion
  var selectDescripcion = $('#selDescripcion').val();
  //Se genera un objeto con los valores de los inputs
  var data = {
    selectTipoGasto: selectTipoGasto,
    selectDescripcion: selectDescripcion
  };
  //Se envia el objeto por ajax
  $.ajax({
    url: 'scripts/buscar-tipo-gasto.php',
    type: 'POST',
    data: JSON.stringify(data),
    dataType: 'json',
    success: function(response) {
      waitingDialog.hide();
      //Se limpian los inputs
      $('#txtNombreGasto').val('');
      swal.fire("Exito", response.message, "success");
    },
    error: function(error) {
      waitingDialog.hide();
      swal.fire("Oops...", error.responseJSON.message, "error");
    }
  });
}
//Funcion para obtener el listado de los tipos de gasto
const llenarTablaGasto = () => {
  waitingDialog.show('Buscando Registros...');
  $("#tblListadoCatGastos").empty();
  $("#tblListadoCatGastos").append(`<div class="row">
    <div class="input-field col-sm-12">
        <div class="box box-solid box-primary">
            <div class="box-body" >
     <br><table class='table table-bordered table-hover' id="tableModules">
     <thead>
     <tr class='bg-primary' >
     <th>ID</th>
     <th>Tipo</th>
     <th>Descripcion</th>
     <th>Nombre</th>
     <th>Acciones</th>
     </tr>
     </thead>
     <tbody id="bodyTable">`);
  //Se envia el objeto por ajax
  $.ajax({
    url: 'scripts/obtener-tipo-gasto.php',
    type: 'GET',
    dataType: 'json',
    success: function(data) {
      waitingDialog.hide();
      //Se recorre el array de datos
      for (var i = 0; i < data.length; i++) {
        let tipo = '';
        let descripcion = '';
        switch(data[i].tipo) {
          case '1':
            tipo = 'Operativo';
            break;
          case '0':
            tipo = 'Interno';
            break;
        }
        switch(data[i].descripcion) {
          case '1':
            descripcion = 'IVA';
            break;
          case '2':
            descripcion = 'ISR';
            break;
          case '0':
            descripcion = 'ISN';
            break;
        }
        $('#bodyTable').append('<tr><td>' + data[i].id_gasto + '</td><td>' + tipo + '</td><td>' + descripcion + '</td><td>' + data[i].nombre + '</td><td><button class="btn btn-success" data-toggle="modal" data-target="#myModal" onclick="editarCATG('+data[i].id_gasto+')">Editar</button></td></tr>');
      }
    },
    error: function(error) {
      waitingDialog.hide();
      //Se agrega body de no hay registros
      $('#bodyTable').append('<tr><td colspan="4" style="color: red">No se encontraron registros.</td></tr>');
    }
  });
}
//Funcion modal para editar el catalogo de gastos
const editarCATG = (id) => {
  let data = {
    id: id
  }
  $("#modalEditarCATG").empty();
  $("#modalEditarCATG").append(`<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModal">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #00004f">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-left: 0;"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"> Editar Tipo Gasto</h4>
      </div>
      <div class="modal-body" style="background-color: #514aac" id="bodyModal">`);
  //Se envia el objeto por ajax
  $.ajax({
    url: 'scripts/obtener-gasto-especifico.php',
    type: 'POST',
    dataType: 'json',
    data: JSON.stringify(data),
    success: function(data) {
      waitingDialog.hide();
      //Se recorre el array de datos
      for (var i = 0; i < data.length; i++) {
        $("#modalEditarCATG").find(".modal-body").append(`<div class="row">
              <div class="col-sm-2">
                <input class="form-control" id="txtIDGI" value="`+data[i].id_gasto+`" disabled>
                <label for="txtIDGI" style="color: black;">ID</label>
              </div>
              <div class="col-sm-3">
                <select class="form-control" id="selTipoGI">
                  <option value='-' disabled selected>Selecciona una opci&oacute;n</option>
                  <option value='1'>Operativo</option>
                  <option value='0'>Interno</option>
                </select>
                <label for="txtTipoGI" style="color: black;">Tipo</label>
              </div>
              <div class="col-sm-3">
              <select class="form-control" id="selDescripcionGI">
                <option value='-' disabled selected>Selecciona una opci&oacute;n</option>
                <option value='2'>ISR</option>
                <option value='1'>IVA</option>
                <option value='0'>ISN</option>
              </select>
                <label for="txtDescripcionGI" style="color: black;">Descripcion</label>
              </div>
              <div class="col-sm-5">
                <input type='text' class="form-control" id="txtNombreGI" value="`+data[i].nombre+`">
                <label for="txtNombreGI" style="color: black;">Nombre</label>
              </div></div>`);
        //Se selecciona el tipo de gasto
        $("#selTipoGI").val(data[i].tipo);
        //Se selecciona la descripcion del gasto
        $("#selDescripcionGI").val(data[i].descripcion);
      }
      $("#modalEditarCATG").find(".modal-body").append(`</div><div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="guardarCatGa()" style="background-color: #64dd17; color: black;"><i class="fa fa-floppy-o" aria-hidden="true"></i> GUARDAR CAMBIOS</button>
          <button type="button" class="btn btn-danger"  style="background-color: #dd2c00; color: white;" onclick="eliminarPago()">Eliminar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal" style=" color: white;">Cerrar</button>
          </div>
          </div>
          </div>
          </div>`);
    },
    error: function(error) {
      waitingDialog.hide();
      //Se agrega body de no hay registros
      swal.fire("Oops...", error.responseJSON.message, "error");
    }
  });
}
//Funcion para eliminar registro del catalogo por el id
const eliminarPago = () => {
  //Se crea mensaje de confirmacion
  swal.fire({
    title: '¿Estas seguro?',
    text: "Esta accion no se puede deshacer.",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si',
    cancelButtonText: 'No'
  }).then((result) => {
    if(result.value) {
      let data = {
        id: $("#txtIDGI").val()
      }
      //Se envia el objeto por ajax
      $.ajax({
        url: 'scripts/eliminar-gasto.php',
        type: 'POST',
        dataType: 'json',
        data: JSON.stringify(data),
        success: function(data) {
          waitingDialog.hide();
          swal.fire("Exito", "Se elimino el registro correctamente.", "success");
          $("#myModal").modal("hide");
          llenarTablaGasto();
        },
        error: function(error) {
          waitingDialog.hide();
          swal.fire("Oops...", error.responseJSON.message, "error");
        }
      });
    }
  });
}
//Funcion para guardar los cambios del catalogo de gastos
const guardarCatGa = () => {
  let id = $("#txtIDGI").val();
  let tipo = $("#selTipoGI").val();
  let descripcion = $("#selDescripcionGI").val();
  let nombre = $("#txtNombreGI").val();
  //Se valida que ningun campo este vacio
  if (tipo == null || descripcion == null || nombre == "") {
    swal.fire("Oops...", "Debes llenar todos los campos.", "error");
    return;
  }
  //Se crea objeto con los datos
  let data = {
    id: id,
    tipo: tipo,
    descripcion: descripcion,
    nombre: nombre
  }
  //Se envia el objeto por ajax
  $.ajax({
    url: 'scripts/guardar-cat-gasto.php',
    type: 'POST',
    dataType: 'json',
    data: JSON.stringify(data),
    success: function(data) {
      waitingDialog.hide();
      swal.fire("Exito", "Se guardaron los cambios correctamente.", "success");
      $("#myModal").modal("hide");
      llenarTablaGasto();
    },
    error: function(error) {
      waitingDialog.hide();
      swal.fire("Oops...", error.responseJSON.message, "error");
    }
  });
}
