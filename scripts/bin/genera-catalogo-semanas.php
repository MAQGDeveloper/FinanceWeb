<?php
require_once('../class/connection.php');
//Creo objeto de la clase conexion
$connection = new Connection();
//Obtengo la conexion
$sql_conn = $connection->getConnection();

$year = date('Y');
$weeks = getIsoWeeksInYear($year);
$registros_procesados = 0;
for($x=1; $x<=$weeks; $x++){
  $dates = getStartAndEndDate($x, $year);
  //Se inserta el registro
  $statement = $sql_conn->prepare("INSERT INTO catalogo_semanas (year,numero_semana, semana_periodo) VALUES (:year, :numero_semana, :semana_periodo)");
  $statement->bindParam(':year', $year);
  $statement->bindParam(':numero_semana', $x);
  $periodo = $dates['week_start'] . ' - ' . $dates['week_end'];
  $statement->bindParam(':semana_periodo', $periodo);
  $statement->execute();
  print_r("Registros procesados: " . $registros_procesados);
  $registros_procesados++;
}

function getIsoWeeksInYear($year) {
  $date = new DateTime;
  $date->setISODate($year, 53);
  return ($date->format("W") === "53" ? 53 : 52);
}

function getStartAndEndDate($week, $year) {
  $dto = new DateTime();
  $ret['week_start'] = $dto->setISODate($year, $week)->format('Y-m-d');
  $ret['week_end'] = $dto->modify('+6 days')->format('Y-m-d');
  return $ret;
}
