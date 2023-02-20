$(function() {
    //Agrega propiedad a la clase para que se muestre el icono de menu principal
    $('#sdMantenUsuario').addClass('menu-open');
    //Se agrega color a la opcion elegida
    $('#linkBajaUsuario').css('background-color', 'cornflowerblue');
});

const bajaUsuario = () => {
    let usuario = $('#txtNombreBaja').val();
    let correo = $('#txtEmailBaja').val();
    if(!usuario && !correo) {
        Swal.fire({
            icon: 'warning',
            title: 'Alerta',
            text: 'Debe llenar al menos un usuario o correo'
        });
        return;
    }
    let datos = {
        usuario,
        correo
    };

    Swal.fire({
        title: '¿Está seguro de dar de baja al usuario?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, dar de baja'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'scripts/baja-usuario.php',
                type: 'POST',
                data: JSON.stringify(datos),
                dataType: 'json',
                success: function(response){
                    console.log(response);
                    if(response.status == 'success'){
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: 'El usuario ha sido dado de baja'
                        });
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'El usuario no se ha podido dar de baja, motivo: ' + response.message
                        });
                    }
                }
            });
        }
    });
}