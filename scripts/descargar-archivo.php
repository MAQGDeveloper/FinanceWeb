<?php
//Obtener la variable del navegador
$data = $_GET['nombreArchivo'];

//Se descarga el archivo
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.basename($data));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($data));
//Se descarga el archivo
readfile($data);
//Se cierra la pestana del navegador con js
echo "<script>window.close();</script>";

