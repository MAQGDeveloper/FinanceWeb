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
$nombre = $json['nombre'];
$rfc = $json['rfc'];
$servicio = $json['servicio'];
$empresa = $json['empresa'];
$diasCredito = $json['diasCredito'];
$cargaSocial = $json['cargaSocial'];
$fee = $json['fee'];
$activo = $json['activo'];

//Se verifica que no exista el RFC
$statement = $sql_conn->prepare("SELECT * FROM catalogo_clientes WHERE rfc = :rfc");
$statement->bindParam(':rfc', $rfc);
$statement->execute();
//Obtengo el numero de filas
$count = $statement->rowCount();
//Si el numero de filas es menor a 0
if($count>0){
  //agrego header de respuesta
  header('Content-Type: application/json');
  //Agregar header http de error
  http_response_code(400);
  //Creo array con el mensaje de error
  $response = array(
    'status' => 'error',
    'message' => 'El RFC ya existe'
  );
  //Codifico el array a json
  $response = json_encode($response);
  //Mando el json al cliente
  echo $response;
  //detengo la ejecucion del script
  die();
}
//Se guardar el cliente
$statement = $sql_conn->prepare("INSERT INTO catalogo_clientes (nombre, rfc, servicio, empresa, dias_credito, carga_social, fee, activo) VALUES (:nombre, :rfc, :servicio, :empresa, :diasCredito, :cargaSocial, :fee, :activo)");
$statement->bindParam(':nombre', $nombre);
$statement->bindParam(':rfc', $rfc);
$statement->bindParam(':servicio', $servicio);
$statement->bindParam(':empresa', $empresa);
$statement->bindParam(':diasCredito', $diasCredito);
$statement->bindParam(':cargaSocial', $cargaSocial);
$statement->bindParam(':fee', $fee);
$statement->bindParam(':activo', $activo);
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
    'message' => 'El cliente se guardo correctamente'
  );
  //Codifico el array a json
  $response = json_encode($response);
  //Mando el json al cliente
  echo $response;
  //detengo la ejecucion del script
  die();
}
