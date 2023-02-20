$(function() {
    //Agrega propiedad a la clase para que se muestre el icono de menu principal
    $('#sdMantenUsuario').addClass('menu-open');
    //Se agrega color a la opcion elegida
    $('#linkAltaUsuario').css('background-color', 'cornflowerblue');
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
                select.append('<option value="" selected disabled>Seleccione un puesto</option>');
                for (var i = 0; i < data.message.length; i++) {
                    select.append('<option value="' + data.message[i].id_perfil + '">' + data.message[i].perfil + '</option>');
                }
            }else{
                swal.fire("Oops...", response.message, "error");
            }
        }
    });
    //Se cambia a selected el valor del select cuando cambie el seleccionado
    $('#selPuesto').change(function() {
        //Se resetea el selected del select
        $('#selPuesto option').each(function() {
            $(this).removeAttr('selected');
        });
        //Si se selecciona el valor 0 se quita el selected
        if($(this).val() == 0) {
            $(this).find('option:selected').removeAttr('selected');
        }else{
            $(this).find('option:selected').attr('selected', 'selected');
        }
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
});
const guardarUsuario = () => {
    waitingDialog.show('Guardando usuario...');
    const nombre = document.getElementById('txtNombre').value;
    const correo = $('#txtEmail').val();

    const password = document.getElementById('txtPassword').value;
    const passwordConfirm = document.getElementById('txtConfirmarPassword').value;
    //obtener el valor del select
    const selectPuesto = document.getElementById('selPuesto');
    const puesto = selectPuesto.options[selectPuesto.selectedIndex].value;

    const selectActivo = document.getElementById('selActivo');
    const activo = selectActivo.options[selectActivo.selectedIndex].value;

    const selectPerfil = document.getElementById('selPerfil');
    const perfil = selectPerfil.options[selectPerfil.selectedIndex].value;

    //validar que los campos no esten vacios
    if (nombre === '' || correo === '' || password === '' || passwordConfirm === '' || puesto === '' || activo === '' || perfil === '') {
      waitingDialog.hide();
      swal.fire("Oops...", "Todos los campos son obligatorios", "error");
      return;
    }
    //verificar que el password y el passwordConfirm sean iguales
    if (password !== passwordConfirm) {
        waitingDialog.hide();
        swal.fire("Oops...", "Las contraseñas no coinciden", "error");
        return;
    }
    const data = {
        'nombre': nombre,
        'correo': correo,
        'password': password,
        'puesto': puesto,
        'activo': activo,
        'perfil': perfil
    };
    //enviar la informacion al servidor ajax
    $.ajax({
        url: 'scripts/guardar-usuario.php',
        type: 'POST',
        data: JSON.stringify(data),
        dataType: "json",
        contentType: 'application/json',
        success: function (response) {
            if (response.status == 200) {
                waitingDialog.hide();
                //Swal con mensaje de exito con redireccion
                swal.fire({
                    title: "Exito",
                    text: response.message,
                    type: "success",
                    confirmButtonText: "Aceptar",
                    confirmButtonColor: "#3c8dbc"
                }).then(function () {
                    window.location.href = "alta-usuarios.php";
                });
            } else {
                waitingDialog.hide();
                swal.fire("Oops...", response.message, "error");
            }
        }
    });
}
