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
//Se obtienen los datos del json
$nombre = $json['nombre'];

//Se crea la consulta para insertar la empresa
$statement = $sql_conn->prepare("INSERT INTO catalogo_empresa(nombre) VALUES(:nombre);");
//Se ejecuta la consulta
$statement->execute(array(
  ':nombre' => $nombre
));
//Se verifica si se inserto el registro
if($statement->rowCount() > 0){
  //Se crea el header de respuesta
  header('Content-Type: application/json');
  //Se crea el array con el mensaje de exito
  $response = array(
    'status' => 'success',
    'message' => 'Se guardo el registro correctamente'
  );
  //Se codifica el array a json
  $response = json_encode($response);
  //Se cambia el status de la respuesta
  http_response_code(200);
  //Se manda el json al cliente
  echo $response;
  //Se detiene la ejecucion del script
  die();
}else{
  //Se crea el header de respuesta
  header('Content-Type: application/json');
  //Se crea el array con el mensaje de error
  $response = array(
    'status' => 'error',
    'message' => 'No se pudo guardar el registro'
  );
  //Se codifica el array a json
  $response = json_encode($response);
  //Se cambia el status de la respuesta
  http_response_code(400);
  //Se manda el json al cliente
  echo $response;
  //Se detiene la ejecucion del script
  die();
}
