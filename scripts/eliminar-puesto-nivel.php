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
$id = $json['id'];

//Se elimina el puesto del catalogo
$sql = "DELETE FROM catalogo_puesto WHERE puesto = :puesto AND id_puesto = :id";
$stmt = $sql_conn->prepare($sql);
$stmt->bindParam(':puesto', $puesto);
$stmt->bindParam(':id', $id);
$stmt->execute();
//Se valida que existan registros
if($stmt->rowCount() > 0) {
  //Se obtienen los registros
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  //Se codifica el resultado en json
  $json = json_encode((array("message"=>$result)));
  //Se imprime el json
  echo $json;
} else {
  //Se manda mensaje de error
  //Se cambia el header a 404
  http_response_code(404);
  echo json_encode(array('message' => 'No se encontraron registros, puede agregar uno nuevo'));
  die();
}
