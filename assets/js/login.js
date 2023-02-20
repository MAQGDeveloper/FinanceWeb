$(document).ajaxStart(function () {
    Pace.restart();
  });
  /*
  * Se llama la funcion cuando la pagina carga
  */
  $(function() {
    // Al presionar enter en el input de correo se llama la funcion para iniciar sesion
    $('#txtCorreo').keypress(function(e) {
        if (e.which == 13) {
            userLogIn();
        }
    });
    // Al presionar enter en el input de password se llama la funcion para iniciar sesion
    $('#password').keypress(function(e) {
        if (e.which == 13) {
            userLogIn();
        }
    });
    localStorage.clear();
    });
const userLogIn = () => {
    Pace.restart();
    waitingDialog.show('Inicio de sesión...');
    //Obtengo los valores de los inputs
    let correo = $('#txtCorreo').val();
    let password = $('#password').val();

    //Valido que los campos no esten vacios
    if(correo == '' || password == ''){
        waitingDialog.hide();
        Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Los campos no pueden estar vacios',
        })
    }else{
        //Creo un objeto con los datos
        let data = {
            "correo":correo,
            "password":password
        }
        //Llamo a la funcion para hacer la peticion
        ajaxRequest(data);
    }
}
const ajaxRequest = (data) => {
    $.ajax({
        type: "POST",
        url: "scripts/login.php",
        data: JSON.stringify(data),
        contentType: 'application/json; charset=utf-8',
        dataType: "json",
        success: function (response) {
            if(response.status == 200){
                waitingDialog.hide();
                localStorage.setItem('token', response.token);
                localStorage.setItem('usuario', response.user);
                localStorage.setItem('correo', response.correo);
                localStorage.setItem('puesto', response.puesto);
                window.location.href = 'index.php';
            }else{
                waitingDialog.hide();
                swal.fire("Oops...", response.message, "error");
            }
        }
    });
}
