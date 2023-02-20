<?php
//Creo clase para la conexion a la base de datos pdo
class Connection{
    //Atributos de la clase
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $database = 'finance';
    private $connection;
    //Constructor de la clase
    public function __construct(){
        //Creo conexion a la base de datos
        $this->connection = new PDO("mysql:host=$this->host;dbname=$this->database", $this->user, $this->password);
        //Configuro la conexion para que arroje excepciones
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    //Metodo para obtener la conexion
    public function getConnection(){
        return $this->connection;
    }
}
?>