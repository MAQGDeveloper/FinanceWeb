$(function() {
  //Agrega propiedad a la clase para que se muestre el icono de menu principal
  $('#sdMantenReporte').addClass('menu-open');
  //Se agrega color a la opcion elegida
  $('#linkCatCli').css('background-color', 'cornflowerblue');
  //Se obtienen los clientes
  listadoClientes();
});
//Se cambia el selected del valor de activo cuando cambie de opcion
$('#selActivo').change(function() {
    //Se resetea el selected del select
    $('#selActivo option').each(function() {
        $(this).removeAttr('selected');
    });
    $(this).find('option:selected').attr('selected', 'selected');
});
//Se setea el valor de activo a 1 por default
$('#selActivo').find('option[value="1"]').attr('selected', 'selected');

const listadoClientes = () => {
  waitingDialog.show('Cargando Clientes...');
  //Se obtienen los usuarios y se pinta la tabla
  $("#tblClientes").empty();
  $("#tblClientes").append(`<div class="row">
    <div class="input-field col-sm-12">
        <div class="box box-solid box-primary">
            <div class="box-body" >
     <br><table class='table table-bordered table-hover' id="tableModules">
     <thead>
     <tr class='bg-primary' >
        <th>id</th>
        <th>Nombre</th>
        <th>RFC</th>
        <th>Servicio</th>
        <th>Empresa</th>
        <th>Dias Cr&eacute;dito</th>
        <th>Carga Social</th>
        <th>Fee</th>
        <th>Activo</th>
        <th>Acciones</th>
     </tr>
     </thead>
     <tbody id="bodyTable">`);

  $.ajax({
    url: 'scripts/obtener-clientes.php',
    type: 'GET',
    dataType: 'json',
    success: function(data) {
      console.log(data);
      waitingDialog.hide();
      for (var i = 0; i < data.message.length; i++) {
        var activo = "";
        if (data.message[i].activo == 1) {
          activo = "Si";
        } else {
          activo = "No";
        }
        $("#bodyTable").append(`
                 <tr style="text-align: center">
                    <input type="hidden" id="folioId" value="`+data.message[i].id_cliente+`"/>
                      <td id = id`+data.message[i].id_cliente+`>`+data.message[i].id_cliente+`</td>
                      <td id = nombre`+data.message[i].id_cliente+`>`+data.message[i].nombre+`</td>
                      <td id = rfc`+data.message[i].id_cliente+`>`+data.message[i].rfc+`</td>
                      <td id = servicio`+data.message[i].id_cliente+`>`+data.message[i].servicio+`</td>
                      <td id = empresa`+data.message[i].id_cliente+`>`+data.message[i].empresa+`</td>
                      <td id = dias_credito`+data.message[i].id_cliente+`>`+data.message[i].dias_credito+`</td>
                      <td id = carga_social`+data.message[i].id_cliente+`>`+data.message[i].carga_social+`</td>
                      <td id = fee`+data.message[i].id_cliente+`>`+data.message[i].fee+`</td>
                      <td id = activo`+data.message[i].id_cliente+`>`+activo+`</td>
                    <td>
                        <button class="btn btn-success" id = btnEditar`+data.message[i].id_cliente+` onclick="editarCliente('`+data.message[i].id_cliente+`','`+this+`')">✍️ Editar</button>
                        <button class="btn btn-danger" id = btnInactivar`+data.message[i].id_cliente+` onclick="borrarCliente('`+data.message[i].id_cliente+`','`+this+`')" hidden>💥 Inactivar</button>
                    </td>
                 </tr>
                 `);
      }
      $("#bodyTable").append(`</div></div></div></div></tbody>
           </table>`);

    },
    error: function(err) {
      waitingDialog.hide();
      waitingDialog.hide();
      $("#bodyTable").append(`<p style="color: red;">No Hay Resultados Para Mostrar.</p>`);
    }
  });
}

const buscarCliente = () => {
  waitingDialog.show('Buscando Cliente...');
  const nombre = document.getElementById('txtNombreCliente').value;
  //valor de rfc
  const rfc = document.getElementById('txtRfcCliente').value;
  //valor de servicio
  const Servicio = document.getElementById('txtServicioCliente').value;
  //valor de empresa
  const Empresa = document.getElementById('txtEmpresaCliente').value;
  //valor de dias de credito
  const diasCredito = document.getElementById('txtDiascreditoCliente').value;
  //valor de carga social
  const cargaSocial = document.getElementById('txtCargasocialCliente').value;
  //valor de fee
  const fee = document.getElementById('txtFeeCliente').value;
  //valor del select activo
  const selectActivo = document.getElementById('selActivoCliente');
  const activo = selectActivo.options[selectActivo.selectedIndex].value;
  //Valida el RFC sea valido
  const pattern = new RegExp("^[a-zA-Z]{3,4}[0-9]{6}[a-zA-Z0-9]{3}$");
  if (!pattern.test(rfc) && rfc != "") {
    waitingDialog.hide();
    swal.fire("Oops...", "El RFC no es valido", "error");
    return;
  }
  const data = {
      'nombre': nombre,
      'rfc': rfc,
      'servicio': Servicio,
      'empresa': Empresa,
      'diasCredito': diasCredito,
      'cargaSocial': cargaSocial,
      'fee': fee,
      'activo': activo
  };
  $("#tblClientes").empty();
  $("#tblClientes").append(`<div class="row">
    <div class="input-field col-sm-12">
        <div class="box box-solid box-primary">
            <div class="box-body" >
     <br><table class='table table-bordered table-hover' id="tableModules">
     <thead>
     <tr class='bg-primary' >
        <th>id</th>
        <th>Nombre</th>
        <th>RFC</th>
        <th>Servicio</th>
        <th>Empresa</th>
        <th>Dias Cr&eacute;dito</th>
        <th>Carga Social</th>
        <th>Fee</th>
        <th>Activo</th>
        <th>Acciones</th>
     </tr>
     </thead>
     <tbody id="bodyTable">`);
  //Envia los datos al servidor
  $.ajax({
      url: 'scripts/buscar-cliente.php',
      type: 'POST',
      dataType: 'json',
      data: JSON.stringify(data),
      success: function(data) {
          waitingDialog.hide();
          $("#bodyTable").empty();
          for (var i = 0; i < data.message.length; i++) {
            //Si es activo o inactivo
            var activo = "";
            if (data.message[i].activo == 1) {
              activo = "Si";
            } else {
              activo = "No";
            }
              $("#bodyTable").append(`
                   <tr style="text-align: center">
                      <td id = id'`+data.message[i].id_cliente+`'>`+data.message[i].id_cliente+`</td>
                      <td id = nombre`+data.message[i].id_cliente+`>`+data.message[i].nombre+`</td>
                      <td id = rfc`+data.message[i].id_cliente+`>`+data.message[i].rfc+`</td>
                      <td id = servicio`+data.message[i].id_cliente+`>`+data.message[i].servicio+`</td>
                      <td id = empresa`+data.message[i].id_cliente+`>`+data.message[i].empresa+`</td>
                      <td id = dias_credito`+data.message[i].id_cliente+`>`+data.message[i].dias_credito+`</td>
                      <td id = carga_social`+data.message[i].id_cliente+`>`+data.message[i].carga_social+`</td>
                      <td id = fee`+data.message[i].id_cliente+`>`+data.message[i].fee+`</td>
                      <td id = activo`+data.message[i].id_cliente+`>`+activo+`</td>
                      <td>
                        <button class="btn btn-success" id = btnEditar`+data.message[i].id_cliente+` onclick="editarCliente('`+data.message[i].id_cliente+`','`+this+`')">✍️ Editar</button>
                        <button class="btn btn-danger" id = btnInactivar`+data.message[i].id_cliente+` onclick="borrarCliente('`+data.message[i].id_cliente+`','`+this+`')" hidden>💥 Inactivar</button>
                    </td>
                   </tr>
                   `);
          }
        $("#bodyTable").append(`</div></div></div></div></tbody>
             </table>`);
      },
      error: function(err) {
          waitingDialog.hide();
          $("#bodyTable").append(`<p style="color: red;">No Hay Resultados Para Mostrar.</p>`);
      }
  });
}

const guardarCliente = () => {
  waitingDialog.show('Guardando Cliente...');
  const nombre = document.getElementById('txtNombreCliente').value;
//valor de rfc
  const rfc = document.getElementById('txtRfcCliente').value;
//valor de servicio
  const Servicio = document.getElementById('txtServicioCliente').value;
//valor de empresa
  const Empresa = document.getElementById('txtEmpresaCliente').value;
//valor de dias de credito
  const diasCredito = document.getElementById('txtDiascreditoCliente').value;
//valor de carga social
  const cargaSocial = document.getElementById('txtCargasocialCliente').value;
//valor de fee
  const fee = document.getElementById('txtFeeCliente').value;
//valor del select activo
  const selectActivo = document.getElementById('selActivoCliente');
  const activo = selectActivo.options[selectActivo.selectedIndex].value;
//validar que los campos no esten vacios
  if (nombre === '' || rfc === '' || Servicio === '' || Empresa === '' || diasCredito === '' || cargaSocial === '' || fee === ''|| activo === '') {
    waitingDialog.hide();
    swal.fire("Oops...", "Todos los campos son obligatorios", "error");
    return;
  }
//Valida el RFC sea valido
  const pattern = new RegExp("^[a-zA-Z]{3,4}[0-9]{6}[a-zA-Z0-9]{3}$");
  if (!pattern.test(rfc)) {
    waitingDialog.hide();
    swal.fire("Oops...", "El RFC no es valido", "error");
    return;
  }
  const data = {
    'nombre': nombre,
    'rfc': rfc,
    'servicio': Servicio,
    'empresa': Empresa,
    'diasCredito': diasCredito,
    'cargaSocial': cargaSocial,
    'fee': fee,
    'activo': activo
  };
  //Se envia la peticion al servidor
  $.ajax({
    url: 'scripts/guardar-cliente.php',
    type: 'POST',
    data: JSON.stringify(data),
    dataType: 'json',
    success: function(response) {
      waitingDialog.hide();
      swal.fire("Exito", response.message, "success");
      console.log(response);
    },
    error: function(error) {
      waitingDialog.hide();
      console.log(error);
      swal.fire("Oops...", error.responseJSON.message, "error");
      //Limpiar campos
      limpiarCampos();
    }
  });
}
//Funcion para limpiar los campos
const limpiarCampos = () => {
  document.getElementById('txtNombreCliente').value = '';
  document.getElementById('txtRfcCliente').value = '';
  document.getElementById('txtServicioCliente').value = '';
  document.getElementById('txtEmpresaCliente').value = '';
  document.getElementById('txtDiascreditoCliente').value = '';
  document.getElementById('txtCargasocialCliente').value = '';
  document.getElementById('txtFeeCliente').value = '';
  document.getElementById('selActivoCliente').selectedIndex = 0;
}
//Funcion donde trasnforma los td en input para poder editarlos
const editarCliente = (id) => {
  const nombre = document.getElementById('nombre'+id).innerHTML;
  const rfc = document.getElementById('rfc'+id).innerHTML;
  const servicio = document.getElementById('servicio'+id).innerHTML;
  const empresa = document.getElementById('empresa'+id).innerHTML;
  const diasCredito = document.getElementById('dias_credito'+id).innerHTML;
  const cargaSocial = document.getElementById('carga_social'+id).innerHTML;
  const fee = document.getElementById('fee'+id).innerHTML;
  const activo = document.getElementById('activo'+id).innerHTML;
  document.getElementById('nombre'+id).innerHTML = `<input type="text" class="form-control" id="txtNombreCliente${id}" value="${nombre}">`;
  document.getElementById('rfc'+id).innerHTML = `<input type="text" class="form-control" id="txtRfcCliente${id}" value="${rfc}">`;
  document.getElementById('servicio'+id).innerHTML = `<input type="text" class="form-control" id="txtServicioCliente${id}" value="${servicio}">`;
  document.getElementById('empresa'+id).innerHTML = `<input type="text" class="form-control" id="txtEmpresaCliente${id}" value="${empresa}">`;
  document.getElementById('dias_credito'+id).innerHTML = `<input type="text" class="form-control" id="txtDiascreditoCliente${id}" value="${diasCredito}">`;
  document.getElementById('carga_social'+id).innerHTML = `<input type="text" class="form-control" id="txtCargasocialCliente${id}" value="${cargaSocial}">`;
  document.getElementById('fee'+id).innerHTML = `<input type="text" class="form-control" id="txtFeeCliente${id}" value="${fee}">`;
  document.getElementById('activo'+id).innerHTML = `<select class="form-control" id="selActivoCliente${id}">
    <option value="1" ${activo == 1 ? 'selected' : ''}>Si</option>
    <option value="0" ${activo == 0 ? 'selected' : ''}>No</option>
  </select>`;
  //Se oculta el boton de editar y se muestra el de guardar
  document.getElementById('btnEditar'+id).style.display = 'none';
  //Se oculta el boton de inactivar
  document.getElementById('btnInactivar'+id).style.display = 'none';
  //Se crea el boton de guardar y se agrega al DOM debajo del boton de editar
  const btnGuardar = document.createElement('button');
  btnGuardar.setAttribute('class', 'btn btn-success');
  btnGuardar.setAttribute('id', 'btnGuardar'+id);
  btnGuardar.setAttribute('onclick', `guardarCambios(${id})`);
  btnGuardar.innerHTML = 'Guardar';
  document.getElementById('btnEditar'+id).parentNode.appendChild(btnGuardar);
}

//Funcion para guardar los cambios
const guardarCambios = (id) => {
  //Se obtienen los valores de los inputs
  const nombre = document.getElementById('txtNombreCliente'+id).value;
  const rfc = document.getElementById('txtRfcCliente'+id).value;
  const servicio = document.getElementById('txtServicioCliente'+id).value;
  const empresa = document.getElementById('txtEmpresaCliente'+id).value;
  const diasCredito = document.getElementById('txtDiascreditoCliente'+id).value;
  const cargaSocial = document.getElementById('txtCargasocialCliente'+id).value;
  const fee = document.getElementById('txtFeeCliente'+id).value;
  const activo = document.getElementById('selActivoCliente'+id).value;
  //Se valida que no este vacio
  if (nombre == '' || rfc == '' || servicio == '' || empresa == '' || diasCredito == '' || cargaSocial == '' || fee == '' || activo == '') {
    swal.fire("Oops...", "Todos los campos son obligatorios", "error");
    return;
  }
  //Se valida que el rfc sea valido
  const pattern = new RegExp("^[a-zA-Z]{3,4}[0-9]{6}[a-zA-Z0-9]{3}$");
  if (!pattern.test(rfc)) {
    swal.fire("Oops...", "El RFC no es valido", "error");
    return;
  }
  //Se crea el objeto con los datos
  const data = {
    'id': id,
    'nombre': nombre,
    'rfc': rfc,
    'servicio': servicio,
    'empresa': empresa,
    'diasCredito': diasCredito,
    'cargaSocial': cargaSocial,
    'fee': fee,
    'activo': activo
  };
  //Se envia la peticion al servidor
  $.ajax({
    url: 'scripts/guardar-cambios-cliente.php',
    type: 'POST',
    data: JSON.stringify(data),
    dataType: 'json',
    success: function(response) {
      swal.fire("Exito", response.message, "success");
      console.log(response);
    },
    error: function(error) {
      //Swal con recarga de pagina
      swal.fire({
        title: "Informaci&oacute;n",
        text: error.responseJSON.message,
        icon: "info",
        confirmButtonText: "Ok",
        confirmButtonColor: "#d33"
      }).then((result) => {
        if (result.value) {
          location.reload();
        }
      });
    }
  });
}









