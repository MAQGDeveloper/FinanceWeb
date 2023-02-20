$(function() {
  //Agrega propiedad a la clase para que se muestre el icono de menu principal
  $('#sdMantenReporte').addClass('menu-open');
  //Se agrega color a la opcion elegida
  $('#linkCatSem').css('background-color', 'cornflowerblue');
  //Se llama funcion para verificar si hay una semana guardada
  obtenerSemanaGuardada();
});
const obtenerSemana = () => {
  //Se obtiene el numero de semana de la fecha seleccionada
  let fecha = $('#txtFecha').val();
  let data = {
    fecha: fecha
  }
  $.ajax({
    type: "POST",
    url: 'scripts/obtener-semana.php',
    data: JSON.stringify(data),
    dataType: "json",
    success: function(data){
      console.log(data);
      $('#txtNumeroSemana').empty();
      //Se muestra el html con el numero de semana
      $('#txtNumeroSemana').append(`
        <div class="col-sm-12">
          <div class="form-group">
            <label for="txtNumeroSemana">N&uacute;mero de semana</label>
            <input type="text" class="form-control" id="txtNumeroSemana" value="`+data.semana+`" disabled></br>
            <button type="button" class="btn btn-primary" id="btnGuardarSemana" onclick="guardarSemana(${data.semana})">Guardar con semana: ${data.semana}</button>
          </div>
        </div>
      `);
    }
  });
}
//Guardar el numero de semana en la base de datos
const guardarSemana = (numeroSemana) => {
  let data = {
    semana: numeroSemana
  }
  $.ajax({
    type: "POST",
    url: 'scripts/guardar-semana.php',
    data: JSON.stringify(data),
    dataType: "json",
    success: function(data){
      console.log(data);
      if(data.status == 200){
        Swal.fire({
          title: 'Semana guardada',
          text: 'La semana se guardo correctamente',
          icon: 'success',
          timer: 2000,
          timerProgressBar: true,
          showConfirmButton: false
        }).then((result) => {
          if (result.dismiss === Swal.DismissReason.timer) {
            location.reload();
          }
        });
      }else{
        Swal.fire({
          title: 'Error',
          text: data.message,
          icon: 'success',
          timer: 2000,
          timerProgressBar: true,
          showConfirmButton: false
        }).then((result) => {
          if (result.dismiss === Swal.DismissReason.timer) {
            location.reload();
          }
        });
      }
    }
  });
}
//Funcion para obtener el numero de semana guardado en la base de datos
const obtenerSemanaGuardada = () => {
  //Se inicializa la tabla con bootstrap

  $.ajax({
    type: "GET",
    url: 'scripts/obtener-semana-guardada.php',
    dataType: "json",
    success: function(data){
      if(data.status == 200){
        $('#txtNumeroSemana').empty();
        //Se muestra el html con el numero de semana
        $('#txtNumeroSemanaActual').append(`La semana actual guardada es: ${data.semana}`);
      }else{
        //No hay registros aun
      }
    }
  });
}
