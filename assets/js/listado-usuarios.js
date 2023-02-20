$(function() {
    //Agrega propiedad a la clase para que se muestre el icono de menu principal
    $('#sdMantenUsuario').addClass('menu-open');
    //Se agrega color a la opcion elegida
    $('#linkListUsuarios').css('background-color', 'cornflowerblue');
    //Se obtienen los roles para el select
    obtenerRoles();
    //Se obtienen los usuarios
    obtenerUsuarios();
    //Se cambia el selected del valor de activo cuando cambie de opcion
    $('#selectPerfil').change(function() {
        //Se resetea el selected del select
        $('#selectPerfil option').each(function() {
            $(this).removeAttr('selected');
        });
        $(this).find('option:selected').attr('selected', 'selected');
    });
    //Se cambia el selected del valor de activo cuando cambie de opcion
    $('#selectEstatus').change(function() {
        //Se resetea el selected del select
        $('#selectEstatus option').each(function() {
            $(this).removeAttr('selected');
        });
        $(this).find('option:selected').attr('selected', 'selected');
    });
});

const obtenerUsuarios = () => {
    waitingDialog.show('Cargando usuarios...');
  //Se obtienen los usuarios y se pinta la tabla
  $("#tblUsuarios").empty();
  $("#tblUsuarios").append(`<div class="row">
    <div class="input-field col-sm-12">
        <div class="box box-solid box-primary">
            <div class="box-body" >
     <br><table class='table table-bordered table-hover' id="tableModules">
     <thead>
     <tr class='bg-primary' >
     <th>id</th>
     <th>Usuario</th>
     <th>Correo</th>
     <th>Perfil</th>
     <th>Activo</th>
     <th>Acciones</th>
     </tr>
     </thead>
     <tbody id="bodyTable">`);
  $.ajax({
    type: "GET",
    url: 'scripts/obtener-usuarios.php',
    dataType: "json",
    success: function(data){
      waitingDialog.hide();
      for (var i = 0; i < data.message.length; i++) {
        let activo = data.message[i].activo == 1 ? 'Si' : 'No';
        let btnActivo = data.message[i].activo == 1 ? 'btn-danger' : 'btn-success'
        let btnActivoText = data.message[i].activo == 1 ? 'Desactivar' : 'Activar'
        $("#bodyTable").append(`
                 <tr style="text-align: center">
                 <input type="hidden" id='idUsuario' value = "`+data.message[i].id+`"/>
                 <td>`+data.message[i].id+`</td>
                 <td>`+data.message[i].usuario+`</td>
                 <td>`+data.message[i].correo+`</td>
                 <td>`+data.message[i].perfil+`</td>
                 <td>`+activo+`</td>
                 <td><button class="btn `+btnActivo+`" onclick="actualizarEstatusUsuario('`+data.message[i].id+`','`+data.message[i].activo+`','`+this+`')">${btnActivoText}</button></td>
                 </tr>
                 `);
      }
      $("#bodyTable").append(`</div></div></div></div></tbody>
           </table>`);
    },
    error: function() {
      waitingDialog.hide();
      $("#bodyTable").append(`<p style="color: red;">No Hay Resultados Para Mostrar.</p>`);
    }
  });

}

const obtenerRoles = () => {
    //Se crea opcion por defecto
    $('#selectPerfil').append(`<option value="" disabled selected>Seleccione un rol</option>`);
    $.ajax({
        type: "GET",
        url: `scripts/obtener-roles.php`,
        dataType: "json",
        success: function(data){
            for (var i = 0; i < data.message.length; i++) {
                $("#selectPerfil").append(`<option value="`+data.message[i].id_perfil+`">`+data.message[i].perfil+`</option>`);
            }
        },
        error: function() {
            $("#selectPerfil").append(`<option value="0">No hay roles disponibles</option>`);
        }
    });
}

const buscarUsuario = () => {
    waitingDialog.show('Buscando usuarios...');
    //Se obtienen los valores de los campos
    var usuario = $('#txtNombreSearch').val();
    var correo = $('#txtCorreoSearch').val();
    var perfil = $('#selectPerfil').val();
    var estatus = $('#selectEstatus').val();
    //Se crea json con los datos
    var datos = {
        usuario: usuario,
        correo: correo,
        perfil: perfil,
        estatus: estatus
    };
    //Se obtienen los usuarios y se pinta la tabla
    $("#tblUsuarios").empty();
    $("#tblUsuarios").append(`<div class="row">
    <div class="input-field col-sm-12">
        <div class="box box-solid box-primary">
            <div class="box-body" >
     <br><table class='table table-bordered table-hover' id="tableModules">
     <thead>
     <tr class='bg-primary' >
     <th>id</th>
     <th>Usuario</th>
     <th>Correo</th>
     <th>Perfil</th>
      <th>Activo</th>
     <th>Acciones</th>
     </tr>
     </thead>
     <tbody id="bodyTable">`);
     $.ajax({
         type: "POST",
         url: 'scripts/buscar-usuarios.php',
         dataType: "json",
         data: JSON.stringify(datos),
         success: function(data){
             waitingDialog.hide();
             for (var i = 0; i < data.message.length; i++) {
               let activo = data.message[i].activo == 1 ? 'Si' : 'No';
               let btnActivo = data.message[i].activo == 1 ? 'btn-danger' : 'btn-success'
               let btnActivoText = data.message[i].activo == 1 ? 'Desactivar' : 'Activar'
                 $("#bodyTable").append(`
                 <tr style="text-align: center">
                 <input type="hidden" id='idUsuario' value = "`+data.message[i].id+`"/>
                 <td>`+data.message[i].id+`</td>
                 <td>`+data.message[i].usuario+`</td>
                 <td>`+data.message[i].correo+`</td>
                 <td>`+data.message[i].perfil+`</td>
                 <td>`+activo+`</td>
                 <td><button class="btn `+btnActivo+`" onclick="actualizarEstatusUsuario('`+data.message[i].id+`','`+data.message[i].activo+`','`+this+`')">${btnActivoText}</button></td>
                 </tr>
                 `);
             }
           $("#bodyTable").append(`</div></div></div></div></tbody>
           </table>`);
         },
         error: function() {
            waitingDialog.hide();
             $("#bodyTable").append(`<p style="color: red;">No Hay Resultados Para Mostrar.</p>`);
         }
     });
}

const actualizarEstatusUsuario = (id,status,btn) => {
  var datos = {
    id: id
  };
  let mensaje = '';
  if(status != '1'){
    mensaje = '¿Desea desactivar el usuario?';
  }else{
    mensaje = '¿Desea activar el usuario?';
  }
  Swal.fire({
    title: '¿Está seguro?',
    text: mensaje,
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, estoy seguro!',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.value) {
      waitingDialog.show('Actualizando estatus...');
      $.ajax({
        type: "POST",
        url: 'scripts/actualizar-estatus-usuario.php',
        dataType: "json",
        data: JSON.stringify({id: id}),
        success: function(data){
          if(data.success){
            waitingDialog.hide();
            Swal.fire(
              '¡Éxito!',
              data.message,
              'success'
            ).then((result) => {
              if (result.value) {
                location.reload();
              }
            })
          }else{
            waitingDialog.hide();
            Swal.fire(
              '¡Error!',
              data.message,
              'error'
            )
          }
        },
        error: function(err) {
          waitingDialog.hide();
          Swal.fire(
            '¡Error!',
            err.responseJSON.message,
            'error'
          )
        }
      });
    }
  })
}

const resetFiltros = () => {
    $('#txtNombreSearch').val('');
    $('#txtCorreoSearch').val('');
    $('#selectPerfil').val('');
    $('#selectEstatus').val('');
    obtenerUsuarios();
}
