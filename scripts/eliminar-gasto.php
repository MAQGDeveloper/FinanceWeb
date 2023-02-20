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
$id = $json['id'];

//Se elimina el registro de la tabla catalogo_gastos
$sql = "DELETE FROM catalogo_gastos WHERE id_gasto = :id";
$stmt = $sql_conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
//Se valida que existan registros
if($stmt->rowCount() > 0) {
  //Se genera mensaje de exito
  //Se cambia el header a 200
  http_response_code(200);
  //Se manda mensaje de exito
  echo json_encode(array('message' => 'Registro eliminado'));
} else {
  //Se manda mensaje de error
  //Se cambia el header a 404
  http_response_code(404);
  echo json_encode(array('message' => 'Error al eliminar el registro'));
  die();
}
