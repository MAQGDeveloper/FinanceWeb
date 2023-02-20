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

//Se obtienen los clientes
$statement = $sql_conn->prepare("SELECT * FROM catalogo_clientes");
$statement->execute();
//Obtengo el numero de filas
$count = $statement->rowCount();
//Si el numero de filas es menor a 0
if($count>0){
  //agrego header de respuesta
  header('Content-Type: application/json');
  //Agregar header http de error
  http_response_code(200);
  //Creo array con el mensaje de error
  $response = array(
    'status' => 'success',
    'message' => $statement->fetchAll(PDO::FETCH_ASSOC)
  );
  //Codifico el array a json
  $response = json_encode($response);
  //Mando el json al cliente
  echo $response;
  //detengo la ejecucion del script
  die();
}
//Si no se obtienen clientes
//agrego header de respuesta
header('Content-Type: application/json');
//Agregar header http de error
http_response_code(400);
//Creo array con el mensaje de error
$response = array(
  'status' => 'error',
  'message' => 'No se encontraron clientes'
);
//Codifico el array a json
$response = json_encode($response);
//Mando el json al cliente
echo $response;
//detengo la ejecucion del script
die();
