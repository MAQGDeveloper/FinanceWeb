window.onload = async () => {
    //Remuevo todos los nav items que tengan la clase menu-open para que se cierren
    $('.nav-item.menu-open').removeClass('menu-open');
    // if(localStorage.getItem('token') === null){
    //     window.location.href = 'login.php';
    // }
    //$('#sdMenuPrincipal').hide();
    //Obtener el usuario del localstorage
    let usuario = localStorage.getItem('usuario');
    //Seteo el nombre del usuario en el sidebar
    $('#txtUsuario').text(usuario);
    //Obtiene el puesto del usuario
    let puesto = localStorage.getItem('puesto');
    //Seteo el puesto del usuario en el sidebar
    if(puesto == '1'){
        $('#txtPuesto').text('Manager');
    }
    //Obtengo el correo del usuario
    let correo = localStorage.getItem('correo');
    //Seteo el correo del usuario en el sidebar
    $('#txtCorreo').text(correo);
    //Habilito opciones del sidebar dependiendo del puesto del usuario
    if(puesto == '1'){
        //Quito propiedad visibility hidden del elemento Menu Principal
        $('#sdMenuPrincipal').css('visibility', 'visible');
        //Quito propiedad visibility hidden del elemento mantenimiento de reporte
        $('#sdMantenUsuario').css('visibility', 'visible');
        $('#sdMantenUsuario').addClass('nav-item');
        //Quito propiedad visibility hidden del elemento mantenimiento de usuarios
        $('#sdMantenReporte').css('visibility', 'visible');
        $('#sdMantenReporte').addClass('nav-item');
        //Agrega propiedad a la clase para que se muestre el icono de menu principal
        $('#sdMenuPrincipal').addClass('nav-item');
        //Quito la propiedad visibility hidden del elemento de Reportes
        $('#sdFormatos').css('visibility', 'visible');
        $('#sdFormatos').addClass('nav-item');
    }
    if(puesto == '2'){
        //Quito propiedad visibility hidden del elemento Menu Principal
        $('#sdMenuPrincipal').css('visibility', 'visible');
    }
}
