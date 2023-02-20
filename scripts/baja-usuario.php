<?php
//Se valida que exista cookie de sesion
session_start();
if(!isset($_COOKIE['key_sesion'])){
    header('Location: login.php');
    die();
}
require_once('class/connection.php');
//Creo objeto de la clase conexion
$connection = new Connection();
//Obtengo la conexion
$sql_conn = $connection->getConnection();

//Obtener json de la peticion
$json = file_get_contents('php://input');
//Decodificar json
$json = json_decode($json, true);

$query_aux = "";
if(isset($json['usuario']) && $json['usuario'] != ""){
    $query_aux .= " AND usuario LIKE '%".$json['usuario']."%'";
}
if(isset($json['correo'])&& $json['correo'] != ""){
    $query_aux .= " AND correo LIKE '%".$json['correo']."%'";
}

//Busca el usuario en la base de datos
$statement = $sql_conn->prepare("SELECT COUNT(*) AS total FROM usuarios WHERE 1=1 $query_aux ORDER BY id ASC;");
$statement->execute();
//Obtengo el numero de filas
$count = $statement->fetch(PDO::FETCH_ASSOC);
//Verifica la cantidad no sea 0
if($count['total']<=0){
    //Si no existe el usuario mando mensaje de error
    //agrego header de respuesta
    header('Content-Type: application/json');
    //Creo array con el mensaje de error
    $response = array(
        'status' => 'error',
        'message' => 'No se encontraron registros'
    );
    //Codifico el array a json
    $response = json_encode($response);
    //Se cambia el status de la respuesta
    http_response_code(404);
    //Mando el json al cliente
    echo $response;
    //detengo la ejecucion del script
    die();
}
//Validar que el usuario este inactivo
$statement = $sql_conn->prepare("SELECT COUNT(*) AS total FROM usuarios WHERE 1=1 AND activo = 0 $query_aux;");
$statement->execute();
//Obtengo el numero de filas
$count = $statement->fetch(PDO::FETCH_ASSOC);
//Verifica la cantidad no sea 0
if($count['total']>=1){
    //Si no existe el usuario mando mensaje de error
    //agrego header de respuesta
    header('Content-Type: application/json');
    //Creo array con el mensaje de error
    $response = array(
        'status' => 'error',
        'message' => 'El usuario ya se encuentra inactivo'
    );
    //Codifico el array a json
    $response = json_encode($response);
    //Mando el json al cliente
    echo $response;
    //detengo la ejecucion del script
    die();
}
//Cambio el status del usuario a inactivo
$statement = $sql_conn->prepare("UPDATE usuarios SET activo = 0 WHERE 1=1 $query_aux;");
$statement->execute();
//Creo header de respuesta
header('Content-Type: application/json');
//Creo array con el mensaje de exito
$response = array(
    'status' => 'success',
    'message' => 'Se desactivo el usuario'
);
//Codifico el array a json
$response = json_encode($response);
//Mando el json al cliente
echo $response;