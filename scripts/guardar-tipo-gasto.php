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
$tipoGasto = $json['tipoGasto'];
$selectTipoGasto = $json['selectTipoGasto'];
$selectDescripcion = $json['selectDescripcion'];

//Se guarda el tipo de gasto en la tabla catalogo_gastos
$sql = "INSERT INTO catalogo_gastos (tipo, descripcion,nombre) VALUES (:selectTipoGasto, :selectDescripcion,:tipoGasto)";
$stmt = $sql_conn->prepare($sql);
$stmt->bindParam(':tipoGasto', $tipoGasto);
$stmt->bindParam(':selectTipoGasto', $selectTipoGasto);
$stmt->bindParam(':selectDescripcion', $selectDescripcion);
$stmt->execute();
//Se valida que existan registros
if($stmt->rowCount() > 0) {
  //Se genera mensaje de exito
  //Se cambia el header a 200
  http_response_code(200);
  echo json_encode(array('message' => 'Se guardo el tipo de gasto'));
} else {
  //Se manda mensaje de error
  //Se cambia el header a 404
  http_response_code(404);
  echo json_encode(array('message' => 'Hubo un error al guardar el tipo de gasto'));
  die();
}
