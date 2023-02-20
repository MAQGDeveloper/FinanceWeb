$(function() {
  //Agrega propiedad a la clase para que se muestre el icono de menu principal
  $('#sdMantenReporte').addClass('menu-open');
  //Se agrega color a la opcion elegida
  $('#linkCatEmp').css('background-color', 'cornflowerblue');
  obtenerEmpresa();
});
//Funcion para obtener la informacion de la empresa
const obtenerEmpresa = () => {
  $("#tblCatalogoEmpresas").empty();
  $("#tblCatalogoEmpresas").append(`<div class="row">
    <div class="input-field col-sm-12">
        <div class="box box-solid box-primary">
            <div class="box-body" >
     <br><table class='table table-bordered table-hover' id="tableModules">
     <thead>
     <tr class='bg-primary' >
     <th>ID</th>
     <th>Nombre de empresa</th>
     <th>Acciones</th>
     </tr>
     </thead>
     <tbody id="bodyTable">`);
  //Se genera la peticion ajax
  $.ajax({
    url: 'scripts/obtener-empresa.php',
    type: 'POST',
    dataType: 'json',
    success: function(data) {
      waitingDialog.hide();
      //Se recorre el array de datos
      for (var i = 0; i < data.length; i++) {
        $("#bodyTable").append(`<tr>
          <td>${data[i].id_empresa}</td>
          <td>${data[i].nombre}</td>
          <td><a href="#" class="btn btn-danger" onclick="eliminarTipoEmpresa(${data[i].id_empresa})"><i class="fa fa-trash"></i></a>&nbsp;<a href="#" class="btn btn-success" onclick="editarEmpresa(${data[i].id_empresa})"><i class="fa fa-edit"></i></a></td>
          </tr>`);
      }
    },
    error: function(error) {
      waitingDialog.hide();
      //Se agrega body de no hay registros
      $('#bodyTable').append('<tr><td colspan="3" style="color: red">No se encontraron registros.</td></tr>');
    }
  });
}
//Funcion para editar la informacion de la empresa
const editarEmpresa = (id) => {
//Se muestra swal con input para editar el nombre del servicio
  swal.fire({
    title: 'Escriba el nuevo nombre de la empresa',
    input: 'text',
    inputAttributes: {
      autocapitalize: 'off'
    },
    showCancelButton: true,
    confirmButtonText: 'Guardar',
    showLoaderOnConfirm: true,
    cancelButtonText: 'Cancelar',
    preConfirm: (nombre) => {
      if(nombre == ''){
        swal.fire('Error', 'Ingresa un nombre para guardar cambios', 'error');
        return false;
      }
      //Se genera objeto para enviar al controlador
      let data = {
        'id': id,
        'nombre': nombre
      };
      //Se genera la peticion ajax
      $.ajax({
        url: 'scripts/guardar-edicion-empresa.php',
        type: 'POST',
        data: JSON.stringify(data),
        dataType: 'json',
        success: function(response) {
          waitingDialog.hide();
          obtenerEmpresa();
          swal.fire("Exito", response.message, "success");
        },
        error: function(error) {
          waitingDialog.hide();
          swal.fire("Oops...", error.responseJSON.message, "error");
        }
      });
    }
  });
}

//Funcion para guardar la informacion de la empresa
const guardarEmpresa = () => {
 //Se obtiene el valor del input
  let nombre = $('#txtNombreEmpresa').val();
  //Se valida que el campo no este vacio
  if (nombre == '') {
    swal.fire('Error', 'Ingresa un nombre para guardar', 'error');
    return false;
  }
  waitingDialog.show('Guardando...');
  //Se genera objeto para enviar al controlador
  let data = {
    'nombre': nombre
  }

  //Se genera la peticion ajax
  $.ajax({
    url: 'scripts/guardar-empresa.php',
    type: 'POST',
    data: JSON.stringify(data),
    dataType: 'json',
    success: function(response) {
      waitingDialog.hide();
      //Se limpia el input
      $('#txtNombreEmpresa').val('');
      obtenerEmpresa();
      swal.fire("Exito", "Se ha registrado correctamente la empresa", "success");
    },
    error: function(error) {
      waitingDialog.hide();
      swal.fire("Oops...", error.responseJSON.message, "error");
    }
  });
}

//Funcion para eliminar la empresa
const eliminarTipoEmpresa = (id) => {
  swal.fire({
    title: '¿Estas seguro de eliminar la empresa?',
    text: "No podras revertir los cambios",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.value) {
      //Se genera objeto para enviar al controlador
      let data = {
        'id': id
      };
      //Se genera la peticion ajax
      $.ajax({
        url: 'scripts/eliminar-empresa.php',
        type: 'POST',
        data: JSON.stringify(data),
        dataType: 'json',
        success: function(response) {
          waitingDialog.hide();
          obtenerEmpresa();
          swal.fire("Exito", response.message, "success");
        },
        error: function(error) {
          waitingDialog.hide();
          swal.fire("Oops...", error.responseJSON.message, "error");
        }
      });
    }
  });
}
