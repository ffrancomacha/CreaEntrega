<?php
$host = "localhost";
$user = "root";
$pass = 'A2438klsop$93.'; 
$db   = "sistema_login";

$conexion = mysqli_connect($host, $user, $pass, $db);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>