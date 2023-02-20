$(function() {
  //Agrega propiedad a la clase para que se muestre el icono de menu principal
  $('#sdFormatos').addClass('menu-open');
  //Se agrega color a la opcion elegida
  $('#linkRegGasOp').css('background-color', 'cornflowerblue');
  obtenerultimoid();
  //Obtener listado de registros de gastos
  //listadoGI();
  //Obtener el listado de semanas
  listadoSemanas();
});
//Funcion para obtener el ultimo id de la tabla de gastos operativos
function obtenerultimoid() {
  $.ajax({
    url: 'scripts/obtener-ultimo-id-gastos-operativos.php',
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
