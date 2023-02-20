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

//Se obtiene el nombre del archivo en la tabla catalogo_empresa
$statement = $sql_conn->prepare("SELECT constancia FROM catalogo_empresa;");
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
//Obtengo la informacion del archivo
$empresa = $statement->fetchAll(PDO::FETCH_OBJ);
//Eliminar recursivamente los archivos de la carpeta files/constancia excepto el archivo que se encuentra en la tabla catalogo_empresa
$files = glob('files/constancia/*'); // get all file names
foreach($files as $file){
  if(is_file($file)){
    if($file != $empresa[0]->constancia){
      unlink($file);
    }else{
      continue;
    }
  }
}
