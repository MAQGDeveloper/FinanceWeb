<?php
require_once('class/connection.php');
//Creo objeto de la clase conexion
$connection = new Connection();
//Obtengo la conexion
$sql_conn = $connection->getConnection();

//Obtener json de la peticion
$json = file_get_contents('php://input');
//Decodificar json
$json = json_decode($json, true);
//Obtener datos del json
$correo = $json['correo'];
//Genero sha256 de la contraseña
$password = hash('sha256', $json['password']);
//Genero hash de sesion a partir de la fecha actual
$sessionHash = password_hash(date('Y-m-d H:i:s'), PASSWORD_DEFAULT);
//Valido que el correo exista en la base de datos
$statement = $sql_conn->prepare("SELECT * FROM usuarios WHERE correo = :correo OR usuario = :correo");
$statement->bindParam(':correo', $correo);
//$statement->bindParam(':password', $password);
$statement->execute();
//Obtengo el numero de filas
$count = $statement->rowCount();
//Obtengo la informacion del usuario
$user = $statement->fetch(PDO::FETCH_ASSOC);

// $query = $statement->queryString;
// //Si el numero de filas es menor a 0
if($count<=0){
    //Si no existe el usuario mando mensaje de error
    //agrego header de respuesta
    header('Content-Type: application/json');
    //Creo array con el mensaje de error
    $response = array(
        'status' => 'error',
        'message' => 'Correo o contraseña incorrectos'
    );
    //Codifico el array a json
    $response = json_encode($response);
    //Mando el json al cliente
    echo $response;
    //detengo la ejecucion del script
    die();
}
//Valido que el password sha256 sea igual al password de la base de datos
if($count == 1 && $password == $user['password']){
    $usuario = $user['usuario'];
    $correo = $user['correo'];
    $puesto = $user['puesto'];
    //Obtener la direccion ip del cliente
    $ip = $_SERVER['REMOTE_ADDR'];
    //Obtener el user agent del cliente
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    //Obtener el nombre del host del cliente
    $host = gethostbyaddr($_SERVER['REMOTE_ADDR']);

    //Creo consulta para actualizar el hash de sesion
    $statement = $sql_conn->prepare("UPDATE usuarios SET key_sesion = :key_sesion WHERE correo = :correo AND password = :password");
    $statement->bindParam(':key_sesion', $sessionHash);
    $statement->bindParam(':correo', $correo);
    $statement->bindParam(':password', $password);
    $statement->execute();
    //Creo cookie para almacenar el hash de sesion
    setcookie('key_sesion', $sessionHash, time() + (86400 * 30), "/");
    //Creo cookie para almacenar el correo del usuario
    setcookie('usuario', $correo, time() + (86400 * 30), "/");
    setcookie('username',$usuario, time() + (86400 * 30), "/");
    //Creo header de respuesta
    header('Content-Type: application/json');
    $accion = 'Inicio de sesion';
    //Header de fecha de mexico
    date_default_timezone_set('America/Mexico_City');
    $fecha = date('Y-m-d H:i:s');
    //Se inserta la informacion de log en la base de datos
    $statement = $sql_conn->prepare("INSERT INTO logs (usuario, ip, host, user_agent, accion,fecha) VALUES (:usuario, :ip, :host, :user_agent,:accion,:fecha)");
    $statement->bindParam(':usuario', $correo);
    $statement->bindParam(':ip', $ip);
    $statement->bindParam(':host', $host);
    $statement->bindParam(':user_agent', $user_agent);
    $statement->bindParam(':accion', $accion);
    $statement->bindParam(':fecha', $fecha);
    $statement->execute();
    //Creo array con el mensaje de exito
    $response = array(
        'status' => 200,
        'token' => $sessionHash,
        'user' => $usuario,
        'correo' => $correo,
        'puesto' => $puesto
    );
    //Codifico el array a json
    $response = json_encode($response);
    //Mando el json al cliente
    echo $response;
}else{
    //Si no existe el usuario mando mensaje de error
    //agrego header de respuesta
    header('Content-Type: application/json');
    //Creo array con el mensaje de error
    $response = array(
        'status' => 'error',
        'message' => 'Correo o contraseña incorrectos'
    );
    //Codifico el array a json
    $response = json_encode($response);
    //Mando el json al cliente
    echo $response;
    //detengo la ejecucion del script
    die();
}
?>
