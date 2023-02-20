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

//Se realiza consulta de toda la informacion de la tabla registro_gastos_internos por PDO
$sql = "SELECT id_gasto_interno,monto,fecha_pago,year_pago,semana_pago,estatus,numero_semana,semana_periodo FROM registro_gastos_internos AS ri JOIN catalogo_semanas WHERE ri.semana_pago = catalogo_semanas.id_catalogo_semana AND year_pago = catalogo_semanas.year ORDER BY id_gasto_interno desc;";
$stmt = $sql_conn->prepare($sql);
$stmt->execute();
//Se valida que existan registros
if($stmt->rowCount() > 0) {
  //Se genera mensaje de exito
  //Se cambia el header a 200
  http_response_code(200);
  //Se obtienen los registros
  $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
  //Se convierte a json
  $registros = json_encode($registros);
  //Se imprime el json
  echo $registros;
} else {
  //Se manda mensaje de error
  //Se cambia el header a 404
  http_response_code(404);
  echo json_encode(array('message' => 'No existen registros'));
  die();
}
