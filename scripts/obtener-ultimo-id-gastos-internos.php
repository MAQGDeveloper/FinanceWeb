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

//Se consulta el ultimo id de la tabla gastos_internos
$sql = "SELECT MAX(id_gasto_interno) AS id FROM registro_gastos_internos";
$stmt = $sql_conn->prepare($sql);
$stmt->execute();
//Se valida que existan registros si no se crea el id en 1
if($stmt->rowCount() > 0) {
  //Se obtiene el id
  $id = $stmt->fetch(PDO::FETCH_ASSOC);
  //Se incrementa el id
  $id = $id['id'] + 1;
  //Se genera mensaje de exito
  //Se cambia el header a 200
  http_response_code(200);
  echo json_encode(array('message' => 'Se obtuvo el ultimo id de gastos internos', 'id' => $id));
} else {
  //Se crea el id en 1
  $id = 1;
  //Se genera mensaje de exito
  //Se cambia el header a 200
  http_response_code(200);
  echo json_encode(array('message' => 'Se obtuvo el ultimo id de gastos internos', 'id' => $id));
  die();
}
