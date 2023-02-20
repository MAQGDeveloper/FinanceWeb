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
$puesto = $json['puesto'];
$puestoNombre = $json['puestoNombre'];

//Se valida que no exista el nombre del puesto con el id del puesto
$sql = "SELECT * FROM catalogo_puesto WHERE id_puesto = :puesto AND puesto = :puestoNombre";
$stmt = $sql_conn->prepare($sql);
$stmt->bindParam(':puesto', $puesto);
$stmt->bindParam(':puestoNombre', $puestoNombre);
$stmt->execute();
//Se valida que existan registros
if($stmt->rowCount() > 0) {
  //Se manda mensaje de error
  //Se cambia el header a 404
  http_response_code(404);
  echo json_encode(array('message' => 'Ya existe un puesto con ese nombre'));
  die();
}
//Se inserta el registro en la tabla catalogo_puesto
$sql = "INSERT INTO catalogo_puesto (id_puesto, puesto) VALUES (:puesto, :puestoNombre)";
$stmt = $sql_conn->prepare($sql);
$stmt->bindParam(':puesto', $puesto);
$stmt->bindParam(':puestoNombre', $puestoNombre);
$stmt->execute();
//Se valida que se haya insertado el registro
if($stmt->rowCount() > 0) {
  //Se manda mensaje de exito
  //Se cambia el header a 201
  http_response_code(201);
  echo json_encode(array('message' => 'Se ha agregado el puesto correctamente'));
} else {
  //Se manda mensaje de error
  //Se cambia el header a 404
  http_response_code(404);
  echo json_encode(array('message' => 'No se pudo agregar el puesto'));
}
