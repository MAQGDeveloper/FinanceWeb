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

//Obtener datos del json
$query_aux = "";
if(isset($json['nombre']) && $json['nombre'] != ""){
  $nombre = $json['nombre'];
  $query_aux .= " AND nombre LIKE '%$nombre%'";
}
if(isset($json['rfc']) && $json['rfc'] != ""){
  $rfc = $json['rfc'];
  $query_aux .= " AND rfc LIKE '%$rfc%'";
}
if(isset($json['servicio']) && $json['servicio'] != ""){
  $servicio = $json['servicio'];
  $query_aux .= " AND servicio = LIKE '%".$json['servicio']."%'";
}
if(isset($json['empresa']) && $json['empresa'] != ""){
  $empresa = $json['empresa'];
  $query_aux .= " AND empresa = LIKE '%".$json['empresa']."%'";
}
if(isset($json['diasCredito']) && $json['diasCredito'] != ""){
  $diasCredito = $json['diasCredito'];
  $query_aux .= " AND dias_credito = ".$json['diasCredito'];
}
if(isset($json['cargaSocial']) && $json['cargaSocial'] != ""){
  $cargaSocial = $json['cargaSocial'];
  $query_aux .= " AND carga_social = ".$json['cargaSocial'];
}
if(isset($json['fee']) && $json['fee'] != ""){
  $fee = $json['fee'];
  $query_aux .= " AND fee = ".$json['fee'];
}
if(isset($json['activo']) && $json['activo'] != ""){
  $activo = $json['activo'];
  $query_aux .= " AND activo = ".$json['activo'];
}


//Se busca el cliente con el query_aux
$statement = $sql_conn->prepare("SELECT * FROM catalogo_clientes WHERE 1=1 ".$query_aux);
$statement->execute();
//Obtengo el numero de filas
$count = $statement->rowCount();
//Si el numero de filas es menor a 0
if($count>0){
  //agrego header de respuesta
  header('Content-Type: application/json');
  //Agregar header http de error
  http_response_code(200);
  //Creo array con el mensaje de error
  $response = array(
    'status' => 'success',
    'message' => $statement->fetchAll(PDO::FETCH_ASSOC)
  );
  //Codifico el array a json
  $response = json_encode($response);
  //Mando el json al cliente
  echo $response;
  //detengo la ejecucion del script
  die();
}
//agrego header de respuesta
header('Content-Type: application/json');
//Agregar header http de error
http_response_code(400);
//Creo array con el mensaje de error
$response = array(
  'status' => 'error',
  'message' => 'No se encontraron clientes'
);
//Codifico el array a json
$response = json_encode($response);
//Mando el json al cliente
echo $response;
//detengo la ejecucion del script
die();
