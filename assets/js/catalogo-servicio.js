$(function() {
  //Agrega propiedad a la clase para que se muestre el icono de menu principal
  $('#sdMantenReporte').addClass('menu-open');
  //Se agrega color a la opcion elegida
  $('#linkCatServ').css('background-color', 'cornflowerblue');
  //Listado de servicios registrados
  listadoServicios();
});

const guardarTipoServicio = () => {
    //Se obtiene el valor del select
    let txtNombreTipo = $('#txtNombreTipo').val();
    if (txtNombreTipo == '') {
        swal.fire({
            title: 'Error',
            text: 'Debe escribir el nombre del nuevo servicio',
            icon: 'error',
            button: 'Aceptar'
        });
        return false;
    }
    //Se genera objeto para enviar al controlador
    let data = {
        'nombre': txtNombreTipo
    };
   //Se genera la peticion ajax
    $.ajax({
      url: 'scripts/guardar-servicio.php',
      type: 'POST',
      data: JSON.stringify(data),
      dataType: 'json',
      success: function(response) {
        waitingDialog.hide();
        //Se limpia el input
        $('#txtNombreTipo').val('');
        listadoServicios();
        swal.fire("Exito", "Se ha registrado correctamente el servicio", "success");
      },
      error: function(error) {
        waitingDialog.hide();
        swal.fire("Oops...", error.responseJSON.message, "error");
      }
    });
}
//Funcion donde se obtiene el listado de servicios
const listadoServicios = () => {
  $("#tblCatalogoServicio").empty();
  $("#tblCatalogoServicio").append(`<div class="row">
    <div class="input-field col-sm-12">
        <div class="box box-solid box-primary">
            <div class="box-body" >
     <br><table class='table table-bordered table-hover' id="tableModules">
     <thead>
     <tr class='bg-primary' >
     <th>ID</th>
     <th>Nombre del servicio</th>
     <th>Acciones</th>
     </tr>
     </thead>
     <tbody id="bodyTable">`);
  //Se genera la peticion ajax
  $.ajax({
    url: 'scripts/listado-servicios.php',
    type: 'POST',
    dataType: 'json',
    success: function(data) {
      waitingDialog.hide();
      //Se recorre el array de datos
      for (var i = 0; i < data.length; i++) {
        $("#bodyTable").append(`<tr>
          <td>${data[i].id_servicio}</td>
          <td>${data[i].nombre}</td>
          <td><a href="#" class="btn btn-danger" onclick="eliminarTipoServicio(${data[i].id_servicio})"><i class="fa fa-trash"></i></a>&nbsp;<a href="#" class="btn btn-success" onclick="editarServicio(${data[i].id_servicio})"><i class="fa fa-edit"></i></a></td>
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
//Funcion para editar el nombre del servicio
const editarServicio = (id) => {
  //Se muestra swal con input para editar el nombre del servicio
  swal.fire({
    title: 'Escriba el nuevo nombre del servicio',
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
        url: 'scripts/guardar-edicion-servicio.php',
        type: 'POST',
        data: JSON.stringify(data),
        dataType: 'json',
        success: function(response) {
          waitingDialog.hide();
          listadoServicios();
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
//Funcion para eliminar el servicio
const eliminarTipoServicio = (id) => {
  swal.fire({
    title: '¿Estas seguro de eliminar el servicio?',
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
        url: 'scripts/eliminar-servicio.php',
        type: 'POST',
        data: JSON.stringify(data),
        dataType: 'json',
        success: function(response) {
          waitingDialog.hide();
          listadoServicios();
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
