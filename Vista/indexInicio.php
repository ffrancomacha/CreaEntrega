<?php
session_start();
if(!isset($_SESSION['usuario_nombre'])){
    header('location:../Vista/indexLogin.php');
}

?>

<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto de prueba</title>
    <link rel="stylesheet" href="../Vista/styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="perfilPic">Utu</div>
        <ul class="nav-links">
            <li><a href="../Vista/indexInicio.php">Inicio</a></li>
            <li><a href="../Vista/perfil.php">Perfil</a></li>
            <li><a href="../Vista/indexPublicaciones.php">Publicaciones</a></li>
            <li><a href="../Controlador/api.php/Logout">Logout</a></li>

        </ul>
    </nav>

    <div class="ContainerGen">
        <div class="Container1">
            <h2>Inicio</h2>
        </div>
    </div>
</body>
</html>