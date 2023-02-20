<script>
    //window.onload = () => {
        //Se valida que exista el token en el localstorage
        if (localStorage.getItem('token') == null || localStorage.getItem('token') == undefined || localStorage.getItem('token') == '' || localStorage.getItem('token') == 'null'
        || localStorage.getItem('token') == 'undefined' || localStorage.getItem('token') == 'NaN' || localStorage.getItem('correo') == null || 
        localStorage.getItem('correo') == undefined || localStorage.getItem('correo') == '' || localStorage.getItem('correo') == 'null' ||
        localStorage.getItem('correo') == 'undefined' || localStorage.getItem('correo') == 'NaN' || localStorage.getItem('usuario') == null ||
        localStorage.getItem('usuario') == undefined || localStorage.getItem('usuario') == '' || localStorage.getItem('usuario') == 'null' ||
        localStorage.getItem('usuario') == 'undefined' || localStorage.getItem('usuario') == 'NaN' || localStorage.getItem('puesto') == null ||
        localStorage.getItem('puesto') == undefined || localStorage.getItem('puesto') == '' || localStorage.getItem('puesto') == 'null' ||
        localStorage.getItem('puesto') == 'undefined' || localStorage.getItem('puesto') == 'NaN') {
            window.location.href = "login.php";
        }
    //}
</script>