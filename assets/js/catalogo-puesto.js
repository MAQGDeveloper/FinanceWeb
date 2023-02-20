$(function() {
    //Agrega propiedad a la clase para que se muestre el icono de menu principal
    $('#sdMantenUsuario').addClass('menu-open');
    //Se agrega color a la opcion elegida
    $('#linkCatPuesto').css('background-color', 'cornflowerblue');
    //Si se selecciona un nivel diferente se deshabilita el input de puesto y su boton y se limpia
    $('#selPuesto').change(function() {
      document.getElementById('spanPuesto').innerHTML = 'El puesto seleccionado es: ____________';
      document.getElementById('txtNombrePuesto').disabled = true;
      //Se vacia el input puesto
      document.getElementById('txtNombrePuesto').value = '';
      document.getElementById('btnGuardarPuesto').disabled = true;
    });
});
//Se obtienen los puestos y se agregan al select
    $.ajax({
        url: 'scripts/obtener-puestos.php',
        type: 'POST',
        dataType: 'json',
        success: function(data) {
            //Se valida si se obtuvieron datos
            if(data.status == 200) {
                var select = $('#selPuesto');
                select.empty();
                select.append('<option value="0" disabled>Seleccione un nivel</option>');
                for (var i = 0; i < data.message.length; i++) {
                    select.append('<option value="' + data.message[i].id_perfil + '">' + data.message[i].perfil + '</option>');
                }
            }else{
                swal.fire("Oops...", response.message, "error");
            }
        }
    });
const BuscarPuesto = () => {
  waitingDialog.show('Buscando puesto...');
  // se obtiene el valor del select
  const selectPuesto = document.getElementById('selPuesto');
  const puesto = selectPuesto.options[selectPuesto.selectedIndex].value;
  //Obtener el nombre del select puesto
  const puestoNombre = selectPuesto.options[selectPuesto.selectedIndex].text;

  //Se valida que se haya seleccionado un puesto
  if(puesto == 0) {
      swal.fire("Oops...", "Seleccione un puesto", "error");
      waitingDialog.hide();
      return;
  }
  //Se edita el html para mostrar el puesto seleccionado
  document.getElementById('spanPuesto').innerHTML = 'El puesto seleccionado es: '+puestoNombre;
  //Se habilitan para agregar nuevo puesto
  document.getElementById('txtNombrePuesto').disabled = false;
  document.getElementById('btnGuardarPuesto').disabled = false;
  const data = {
      puesto: puesto
  };

  // enviar la informacion al servidor ajax
  $.ajax({
      url: 'scripts/obtener-puesto-nivel.php',
      type: 'POST',
      dataType: 'json',
      data: JSON.stringify(data),
      success: function(data) {
        console.log(data);
        waitingDialog.hide();
        //Se crea listado de los resultados con un boton para eliminar
        var listado = '<br><br><br><h1>Listado de puestos</h1></h1>';
        for (var i = 0; i < data.message.length; i++) {
          console.log(data.message[i]);
          listado += '<li class="list-group-item">'+data.message[i].puesto+' <button type="button" class="btn btn-danger btn-sm" onclick="eliminarPuesto('+data.message[i].id_puesto+', `'+data.message[i].puesto+'`)">Eliminar</button></li>';
        }
        document.getElementById('tblPuestos').innerHTML = listado;

        //$('#txtPuesto').val(data.message[0].perfil);
      },
      error: function(error) {
        waitingDialog.hide();
          //Se agrega html p en rojo con el error
          $('#tblPuestos').html('<p style="color:red;">'+error.responseJSON.message+'</p>');
      }
  });
}

const guardarPuesto = () => {
  waitingDialog.show('Guardando puesto...');
  // se obtiene el valor del select
  const selectPuesto = document.getElementById('selPuesto');
  const puesto = selectPuesto.options[selectPuesto.selectedIndex].value;
  //Obtener el nombre del select puesto
  const puestoNombre = selectPuesto.options[selectPuesto.selectedIndex].text;
  //Se valida que se haya seleccionado un puesto
  if(puesto == 0) {
      swal.fire("Oops...", "Seleccione un puesto", "error");
      waitingDialog.hide();
      return;
  }
  //Se valida que se haya ingresado un nombre de puesto
  if(document.getElementById('txtNombrePuesto').value == '') {
      swal.fire("Oops...", "Ingrese un nombre de puesto", "error");
      waitingDialog.hide();
      return;
  }
  const data = {
      puesto: puesto,
      puestoNombre: document.getElementById('txtNombrePuesto').value
  };

  // enviar la informacion al servidor ajax
  $.ajax({
      url: 'scripts/guardar-puesto-nivel.php',
      type: 'POST',
      dataType: 'json',
      data: JSON.stringify(data),
      success: function(data) {
        waitingDialog.hide();
        //Se valida si se obtuvieron datos
        swal.fire("Exito", "Puesto guardado correctamente", "success");
      },
      error: function(error) {
        waitingDialog.hide();
        swal.fire("Oops...", response.message, "error");
      }
  });
}
//Funcion para eliminar un puesto
const eliminarPuesto = (id, puesto) => {
  const data = {
      id: id,
      puesto: puesto
  };
  // enviar la informacion al servidor ajax
  $.ajax({
      url: 'scripts/eliminar-puesto-nivel.php',
      type: 'POST',
      dataType: 'json',
      data: JSON.stringify(data),
      success: function(data) {
        //Se valida si se obtuvieron datos
        swal.fire("Exito", "Puesto eliminado correctamente", "success");
        BuscarPuesto();
      },
      error: function(error) {
        waitingDialog.hide();
        swal.fire("Oops...", response.message, "error");
      }
  });
}


