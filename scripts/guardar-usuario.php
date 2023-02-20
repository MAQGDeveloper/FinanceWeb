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
$correo = $json['correo'];
//Genero sha256 de la contraseña
$password = hash('sha256', $json['password']);
$puesto = $json['puesto'];
$activo = $json['activo'];
$perfil = 0;

//Valido que el correo no exista en la base de datos
$statement = $sql_conn->prepare("SELECT * FROM usuarios WHERE correo = :correo");
$statement->bindParam(':correo', $correo);
$statement->execute();
//Obtengo el numero de filas
$count = $statement->rowCount();
//Si el numero de filas es menor a 0
if($count>0){
    //agrego header de respuesta
    header('Content-Type: application/json');
    //Creo array con el mensaje de error
    $response = array(
        'status' => 'error',
        'message' => 'El correo ya existe'
    );
    //Codifico el array a json
    $response = json_encode($response);
    //Mando el json al cliente
    echo $response;
    //detengo la ejecucion del script
    die();
}
//Valido que el usuario no exista en la base de datos
$statement = $sql_conn->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
$statement->bindParam(':usuario', $nombre);
$statement->execute();
//Obtengo el numero de filas
$count = $statement->rowCount();
//Si el numero de filas es menor a 0
if($count>0){
    //agrego header de respuesta
    header('Content-Type: application/json');
    //Creo array con el mensaje de error
    $response = array(
        'status' => 'error',
        'message' => 'El usuario ya existe'
    );
    //Codifico el array a json
    $response = json_encode($response);
    //Mando el json al cliente
    echo $response;
    //detengo la ejecucion del script
    die();
}
//Se obbtiene el ultimo id de la tabla
$statement = $sql_conn->prepare("SELECT MAX(id) AS id FROM usuarios");
$statement->execute();
//Obtengo el numero de filas
$count = $statement->rowCount();
//Si el numero de filas es menor a 0
if($count>0){
    //Obtengo el resultado
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    //Obtengo el id
    $id = $result['id'];
    //Sumo 1 al id
    $id = $id + 1;
}else{
    //Si no hay registros en la tabla
    $id = 1;
}
//Si no existe el usuario
//Preparo la consulta
$statement = $sql_conn->prepare("INSERT INTO usuarios (id,usuario, correo, password, puesto, activo, perfil) VALUES (:id,:usuario, :correo, :password, :puesto, :activo, :perfil)");
//Agrego los parametros
$statement->bindParam(':id', $id);
$statement->bindParam(':usuario', $nombre);
$statement->bindParam(':correo', $correo);
$statement->bindParam(':password', $password);
$statement->bindParam(':puesto', $puesto);
$statement->bindParam(':activo', $activo);
$statement->bindParam(':perfil', $perfil);
//Ejecuto la consulta
$statement->execute();
//Obtengo el numero de filas afectadas
$count = $statement->rowCount();
//Si el numero de filas afectadas es mayor a 0
if($count>0){
    //agrego header de respuesta
    header('Content-Type: application/json');
    //Creo array con el mensaje de error
    $response = array(
        'status' => 200,
        'message' => 'Usuario guardado correctamente'
    );
    //Codifico el array a json
    $response = json_encode($response);
    //Mando el json al cliente
    echo $response;
    //detengo la ejecucion del script
    die();
}
//Si no se guardo el usuario
//agrego header de respuesta
header('Content-Type: application/json');
//Creo array con el mensaje de error
$response = array(
    'status' => 'error',
    'message' => 'No se pudo guardar el usuario'
);
//Codifico el array a json
$response = json_encode($response);
//Mando el json al cliente
echo $response;
//detengo la ejecucion del script
die();