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
$id = $json['id'];
$nombre = $json['nombre'];
$rfc = $json['rfc'];
$servicio = $json['servicio'];
$empresa = $json['empresa'];
$diasCredito = $json['diasCredito'];
$cargaSocial = $json['cargaSocial'];
$fee = $json['fee'];
$activo = $json['activo'];


//Se actualiza el cliente
$sql = "UPDATE catalogo_clientes SET nombre = :nombre, rfc = :rfc, servicio = :servicio, empresa = :empresa, dias_credito = :diasCredito, carga_social = :cargaSocial, fee = :fee, activo = :activo WHERE id_cliente = :id";
$stmt = $sql_conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':rfc', $rfc);
$stmt->bindParam(':servicio', $servicio);
$stmt->bindParam(':empresa', $empresa);
$stmt->bindParam(':diasCredito', $diasCredito);
$stmt->bindParam(':cargaSocial', $cargaSocial);
$stmt->bindParam(':fee', $fee);
$stmt->bindParam(':activo', $activo);
$stmt->execute();
//Se valida que existan registros
if($stmt->rowCount() > 0) {
  //Se envia mensaje de exito
  echo json_encode(array('message' => 'Se actualizo el cliente correctamente'));
} else {
  //Se manda mensaje de error de actualizacion
  //Se cambia el header a 404
  http_response_code(404);
  //Se obtiene el error
  $error = $stmt->errorInfo();
  echo json_encode(array('message' => 'No hubo ningun cambio.'));
  die();
}
