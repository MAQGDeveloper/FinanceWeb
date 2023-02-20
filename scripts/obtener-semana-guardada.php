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
//Obtener json de la peticion
$json = file_get_contents('php://input');
//Decodificar json
$json = json_decode($json, true);
//Se obtienen los datos del json
$flag = null;
if(isset($json['flag'])){
  $flag = $json['flag'];
}
//Se valida si no es nulo la bandera
if($flag != null){
  //Obtengo la conexion
  $sql_conn = $connection->getConnection();
//Se valida que exista registro del año
  $statement = $sql_conn->prepare("SELECT * FROM catalogo_semanas");
  $statement->execute();
//Obtengo el numero de filas
  $count = $statement->rowCount();
//Verifica la cantidad no sea 0
  $semana = 0;
  if ($count > 0) {
    //Se almacena todos los registros en un arreglo de objetos
    $rows = $statement->fetchAll(PDO::FETCH_OBJ);
    //Creo header de respuesta
    header('Content-Type: application/json');
    //Header http de respuesta
    http_response_code(200);
    //Creo array con el mensaje de exito
    $response = array(
      'status' => 200,
      'message' => 'Se encontraron registros',
      'semana' => $rows
    );
    //Codifico el array a json
    $response = json_encode($rows);
    //Mando el json al cliente
    echo $response;
    //detengo la ejecucion del script
    die();
  }
  //Creo header de respuesta
  header('Content-Type: application/json');
  //Header http de respuesta
  http_response_code(404);
  //Creo array con el mensaje de exito
  $response = array(
    'status' => 404,
    'message' => 'No se encontro registros.'
  );
  //Codifico el array a json
  $response = json_encode($response);
  //Mando el json al cliente
  echo $response;
  //detengo la ejecucion del script
  die();
}else{
  //Obtengo la conexion
  $sql_conn = $connection->getConnection();
//Year actual
  $year = date('Y');
//Se valida que exista registro del año
  $statement = $sql_conn->prepare("SELECT * FROM catalogo_semanas WHERE year = :year");
  $statement->bindParam(':year', $year);
  $statement->execute();
//Obtengo el numero de filas
  $count = $statement->rowCount();
//Verifica la cantidad no sea 0
  $semana = 0;
  if ($count > 0) {
    //Se almacena todos los registros en un arreglo de objetos
    $rows = $statement->fetchAll(PDO::FETCH_OBJ);
    //Creo header de respuesta
    header('Content-Type: application/json');
    //Header http de respuesta
    http_response_code(200);
    //Creo array con el mensaje de exito
    $response = array(
      'status' => 200,
      'message' => 'Se encontraron registros',
      'semana' => $rows
    );
    //Codifico el array a json
    $response = json_encode($rows);
    //Mando el json al cliente
    echo $response;
    //detengo la ejecucion del script
    die();
  }
  //Creo header de respuesta
    header('Content-Type: application/json');
  //Header http de respuesta
    http_response_code(404);
  //Creo array con el mensaje de exito
    $response = array(
      'status' => 404,
      'message' => 'No se encontro registros.'
    );
  //Codifico el array a json
    $response = json_encode($response);
  //Mando el json al cliente
    echo $response;
  //detengo la ejecucion del script
    die();
}
