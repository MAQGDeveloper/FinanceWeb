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
$estatus = $json['estatus'];

//Se actualiza el estatus a borrador la tabla registro_gastos_internos
$sql = "UPDATE registro_gastos_internos SET estatus = :estatus WHERE id_gasto_interno = :id";
$stmt = $sql_conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->bindParam(':estatus', $estatus);
$stmt->execute();
//Se valida que existan registros
if($stmt->rowCount() > 0) {
  //Se envia mensaje de exito
  echo json_encode(array('message' => 'Se actualizo el estatus a borrador correctamente'));
} else {
  //Se manda mensaje de error de actualizacion
  //Se cambia el header a 404
  http_response_code(404);
  //Se obtiene el error
  $error = $stmt->errorInfo();
  echo json_encode(array('message' => 'No hubo ningun cambio.'));
  die();
}
