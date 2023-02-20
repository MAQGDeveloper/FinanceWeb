<?php
//Se valida que exista cookie de sesion
session_start();
if (!isset($_COOKIE['key_sesion'])) {
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
//Obtener datos del json
$semana = $json['semana'];
//Se obtiene el año actual
$anio = date("Y");
//Se valida que no exista registro del año
$statement = $sql_conn->prepare("SELECT * FROM catalogo_semanas WHERE year = :year");
$statement->bindParam(':year', $anio);
$statement->execute();
//Obtengo el numero de filas
$count = $statement->rowCount();
//Verifica la cantidad no sea 0
if ($count > 0) {
 //Se actualiza el registro
  $statement = $sql_conn->prepare("UPDATE catalogo_semanas SET numero_semana = :semana WHERE year = :year");
  $statement->bindParam(':semana', $semana);
  $statement->bindParam(':year', $anio);
  $statement->execute();
  //Creo header de respuesta
  header('Content-Type: application/json');
  //Header http de respuesta
  http_response_code(200);
  //Creo array con el mensaje de exito
  $response = array(
    'status' => 200,
    'message' => 'Se actualizo la semana correctamente'
  );
  //Codifico el array a json
  $response = json_encode($response);
  //Mando el json al cliente
  echo $response;
  //detengo la ejecucion del script
  die();
}
//Se inserta el registro
$statement = $sql_conn->prepare("INSERT INTO catalogo_semanas (year, numero_semana) VALUES (:year, :semana)");
$statement->bindParam(':year', $anio);
$statement->bindParam(':semana', $semana);
$statement->execute();
//Creo header de respuesta
header('Content-Type: application/json');
//Header http de respuesta
http_response_code(200);
//Creo array con el mensaje de exito
$response = array(
  'status' => 200,
  'message' => 'Se guardo la semana correctamente'
);
//Codifico el array a json
$response = json_encode($response);
//Mando el json al cliente
echo $response;
//detengo la ejecucion del script
die();
