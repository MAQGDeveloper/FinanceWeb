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

$id = "";
if(isset($json['id'])&& $json['id'] != ""){
$id = $json['id'];
}
//Se obtiene el estatus actual del usuario
$statement = $sql_conn->prepare("SELECT activo,key_sesion FROM usuarios WHERE id = $id;");
$statement->execute();
//Obtengo el numero de filas
$count = $statement->fetch(PDO::FETCH_ASSOC);
//Si es 0 se cambia a 1 y viceversa
$activo = "";
$mensaje = "";
//Valida si existe key_sesion para no cambiar el estatus del usuario logueado
if($count['key_sesion'] == $_COOKIE['key_sesion']){
  //Si es el usuario logueado mando mensaje de error
  //agrego header de respuesta
  header('Content-Type: application/json');
  //Creo array con el mensaje de error
  $response = array(
  'success' => false,
  'status'  => 'error',
  'message' => 'No se puede cambiar el estatus del usuario logueado'
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
if($count['activo'] == 0){
  $activo = 1;
  $mensaje = "Usuario activado";
}else{
  $activo = 0;
  $mensaje = "Usuario desactivado";
}
//Se actualiza el estatus del usuario
$statement = $sql_conn->prepare("UPDATE usuarios SET activo = $activo WHERE id = $id;");
$statement->execute();
//Se obtiene el numero de filas afectadas`
$count = $statement->rowCount();
//Verifica la cantidad no sea 0
if($count<=0){
//Si no existe el usuario mando mensaje de error
//agrego header de respuesta
header('Content-Type: application/json');
//Creo array con el mensaje de error
$response = array(
'success' => false,
'status' => 'error',
'message' => 'No se pudo actualizar el estatus del usuario'
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
//Si todo sale bien mando mensaje de exito
//Se actualiza la tabla de logs
$statement = $sql_conn->prepare("INSERT INTO logs (usuario,accion,fecha) VALUES ('".$_COOKIE['usuario']."','Se actualizo el estatus del usuario $id',NOW());");
$statement->execute();
//agrego header de respuesta
header('Content-Type: application/json');
//Creo array con el mensaje de exito
$response = array(
'success' => true,
'status' => 'success',
'message' => $mensaje
);
//Codifico el array a json
$response = json_encode($response);
//Se cambia el status de la respuesta
http_response_code(200);
//Mando el json al cliente
echo $response;
//detengo la ejecucion del script
die();
