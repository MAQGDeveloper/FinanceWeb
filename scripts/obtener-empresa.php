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

//Se obtienen los datos de la empresa
$statement = $sql_conn->prepare("SELECT * FROM catalogo_empresa;");
$statement->execute();
//Obtengo el numero de filas
$count = $statement->rowCount();
//Verifica la cantidad no sea 0
if($count<=0){
  //Si no existe el usuario mando mensaje de error
  //agrego header de respuesta
  header('Content-Type: application/json');
  //Creo array con el mensaje de error
  $response = array(
    'status' => 'error',
    'message' => 'No se encontraron registros'
  );
  //Codifico el array a json
  $response = json_encode($response);
  //Se cambia el status de la respuesta
  http_response_code(404);
  //Mando el json al cliente
  echo $response;
  //detengo la ejecucion del script
  die();
}
//Obtengo la informacion del usuario
$empresa = $statement->fetchAll(PDO::FETCH_ASSOC);
//Creo header de respuesta
header('Content-Type: application/json');
//Header http de respuesta
http_response_code(200);
//Creo array con el mensaje de exito

//Codifico el array a json
$response = json_encode($empresa);
//Mando el json al cliente
echo $response;
//detengo la ejecucion del script
die();
