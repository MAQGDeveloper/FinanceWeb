<?php
require_once('scripts/class/connection.php');
//Creo objeto de la clase conexion
$connection = new Connection();
//Obtengo la conexion
$sql_conn = $connection->getConnection();
//Obtener json de la peticion
$json = file_get_contents('php://input');
//Decodificar json
$json = json_decode($json, true);
//Obtener datos del json
$token = $json['token'];

//Validar que el token exista
if ($token == null || $token == '' || $token == 'null' || $token == 'undefined' || $token == 'NaN') {
    $response = array(
        'status' => 'error',
        'message' => 'No se puede cerrar sesión, token no existe'
    );
    echo json_encode($response);
    return;
}
//Validar que el token exista en la base de datos con pdo
try {
    $sql = "SELECT * FROM usuarios WHERE key_sesion = :token";
    $stmt = $sql_conn->prepare($sql);
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($result) == 0) {
        $response = array(
            'status' => 'error',
            'message' => 'No se puede cerrar sesión, token no existe'
        );
        echo json_encode($response);
        return;
    }
} catch (PDOException $e) {
    $response = array(
        'status' => 'error',
        'message' => 'No se puede cerrar sesión, error en la base de datos ' . $e->getMessage()
    );
    echo json_encode($response);
    return;
}
//Eliminar token de la base de datos
try {
    $sql = "UPDATE usuarios SET key_sesion = null WHERE key_sesion = :token";
    $stmt = $sql_conn->prepare($sql);
    $stmt->bindParam(':token', $token);
    $stmt->execute();
} catch (PDOException $e) {
    $response = array(
        'status' => 'error',
        'message' => 'No se puede cerrar sesión, error en la base de datos'
    );
    echo json_encode($response);
    return;
}

//Se eliminan todas las cookies del navegador
if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
}

//Se crea la respuesta de la peticion
$response = array(
    'status' => 'success',
    'message' => 'Sesión cerrada correctamente'
);
echo json_encode($response);