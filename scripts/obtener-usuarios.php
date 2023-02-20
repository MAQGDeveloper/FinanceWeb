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

//Se obtienen los datos del usuario
$statement = $sql_conn->prepare("SELECT id,usuario,correo,activo,P.perfil FROM usuarios AS U JOIN catalogo_perfil as P where U.puesto = P.id_perfil ORDER BY id ASC;");
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
