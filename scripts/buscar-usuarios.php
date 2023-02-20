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
if(isset($json['perfil'])&& $json['perfil'] != ""){
    $query_aux .= " AND puesto = ".$json['perfil'];
}
if(isset($json['estatus'])&& $json['estatus'] != ""){
    $query_aux .= " AND activo = ".$json['estatus'];
}
//Se obtienen los datos del usuario
$statement = $sql_conn->prepare("SELECT id,usuario,correo,activo,P.perfil FROM usuarios AS U JOIN catalogo_perfil as P where U.puesto = P.id_perfil $query_aux ORDER BY id ASC;");
$statement->execute();
//Obtengo el numero de filas
$count = $statement->rowCount();
//Verifica la cantidad no sea 0
if($count<=0){
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
//Obtengo la informacion del usuario
$usuarios = $statement->fetchAll(PDO::FETCH_ASSOC);
//Creo header de respuesta
header('Content-Type: application/json');
//Creo array con el mensaje de exito
$response = array(
    'status' => 200,
    'message' => $usuarios
);
//Codifico el array a json
$response = json_encode($response);
//Mando el json al cliente
echo $response;
