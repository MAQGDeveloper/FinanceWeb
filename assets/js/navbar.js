const cerrarSesion = () => {
    Pace.restart();
    waitingDialog.show('Cerrando sesi&oacute;n...');
    //Se obtiene el token del localStorage
    let token = localStorage.getItem('token');
    let data = {
        'token': token
    }
    //Se envia el token al servidor para que lo valide
    $.ajax({
        url: 'cerrar-sesion.php',
        type: 'POST',
        data: JSON.stringify(data),
        dataType: "json",
        contentType: 'application/json',
        success: function (response) {
            waitingDialog.hide();
            //Si el servidor responde ok, se limpia el localStorage y se redirecciona al login
            if (response.status === 'success') {
                localStorage.clear();
                location.href = 'login.php';
            } else {
                swal.fire("Oops...", response.message, "error");
            }
        }
    });
}