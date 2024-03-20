<?php

$host = "localhost";
$bd = "valkyriafundas";
$usuario = "root";
$contrasenia = "mysql";

try {

    $conexion = new PDO("mysql:host=$host;dbname=$bd", $usuario, $contrasenia);

} catch (Exception $ex) {
    echo $ex->getMessage();
}

?>
