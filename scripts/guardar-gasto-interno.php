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
$gastoid = $json['gastoID'];
$monto = $json['monto'];
$fecha = $json['fecha'];
$semana_pago = $json['semana_pago'];

//Se consulta si el id del gasto no existe
$sql = "SELECT * FROM registro_gastos_internos WHERE id_gasto_interno = :gastoid";
$stmt = $sql_conn->prepare($sql);
$stmt->bindParam(':gastoid', $gastoid);
$stmt->execute();
//Se valida que existan registros
if($stmt->rowCount() > 0) {
  //Se cambia el id del gasto +1
  $gastoid = $gastoid + 1;
}
$estatus = 1;
//Obtiene el year actual
$year = date('Y');
//Se guarda el gasto en la tabla gastos_internos
$sql = "INSERT INTO registro_gastos_internos (id_gasto_interno, monto, fecha_pago,year_pago, semana_pago,estatus) VALUES (:gastoid, :monto, :fecha,:year_pago, :semana_pago,:estatus)";
$stmt = $sql_conn->prepare($sql);
$stmt->bindParam(':gastoid', $gastoid);
$stmt->bindParam(':monto', $monto);
$stmt->bindParam(':fecha', $fecha);
$stmt->bindParam(':year_pago', $year);
$stmt->bindParam(':semana_pago', $semana_pago);
$stmt->bindParam(':estatus', $estatus);
$stmt->execute();
//Se valida que existan registros
if($stmt->rowCount() > 0) {
  //Se genera mensaje de exito
  //Se cambia el header a 200
  http_response_code(200);
  echo json_encode(array('message' => 'Se guardo el gasto con el id '.$gastoid));
} else {
  //Se manda mensaje de error
  //Se cambia el header a 404
  http_response_code(404);
  echo json_encode(array('message' => 'Hubo un error al guardar el gasto'));
  die();
}
