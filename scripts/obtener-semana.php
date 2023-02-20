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
$fecha = $json['fecha'];
//Obtener semana
$semana = date("W", strtotime($fecha));
//Si es el primer dia del año y la semana es 52 o 53, entonces la semana es 1
if($semana == 53 && date("m", strtotime($fecha)) == 1 && date("d", strtotime($fecha)) == 1){
  $semana = '01';
}
//Valida que la fecha sea el primer dia del año
if(date("m", strtotime($fecha)) == 1 && date("d", strtotime($fecha)) == 1) {
  $semana = '01';
}
//Crear header de la respuesta
header('Content-Type: application/json');
//Crear array de respuesta
$response = array();
//Agregar semana al array de respuesta
$response['semana'] = $semana;
//Codificar array de respuesta a json
$json = json_encode($response);
//Imprimir json
echo $json;
