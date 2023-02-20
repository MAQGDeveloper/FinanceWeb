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

//Se guarda el tipo de servicio en la tabla catalogo_servicios
$sql = "INSERT INTO catalogo_servicios (nombre) VALUES (:nombre)";
$stmt = $sql_conn->prepare($sql);
$stmt->bindParam(':nombre', $nombre);
$stmt->execute();
//Se valida que se haya guardado el tipo de servicio
if($stmt->rowCount() > 0) {
  //Se genera mensaje de exito
  //Se cambia el header a 200
  http_response_code(200);
  echo json_encode(array('message' => 'Se guardo el tipo de servicio'));
} else {
  //Se manda mensaje de error
  //Se cambia el header a 404
  http_response_code(404);
  echo json_encode(array('message' => 'Hubo un error al guardar el tipo de servicio'));
  die();
}
