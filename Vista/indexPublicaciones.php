<?php
session_start();
include '../Conexion/Conexion.php';

if(!isset($_SESSION['usuario_nombre'])){
    header('location:../Vista/indexLogin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Proyecto de prueba</title>
    <link rel="stylesheet" href="../Vista/styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="perfilPic">Utu</div>
        <ul class="nav-links">
            <li><a href="indexInicio.php">Inicio</a></li>
            <li><a href="perfil.php">Perfil</a></li>
            <li><a href="indexPublicaciones.php">Publicaciones</a></li>
            <li><a href="../Controlador/api.php/Logout">Logout</a></li>
        </ul>
    </nav>

    <div class="ContainerGen">
    <!-- Formulario Publicar -->
    <div class="Container1">
        <h3>¿Qué estás pensando?</h3>
        <form id="formPublicar" enctype="multipart/form-data">
            <textarea name="contenido" placeholder="Escribe algo aquí..." required></textarea>
            <input type="file" name="PostPic" accept="image/*">
            <button type="submit" class="SubmitBtn">Publicar</button>
        </form>
    </div>

    <!-- Feed -->
    <div class="Feed" style="width: 100%; max-width: 700px;">
        <?php
        // ORDER BY fecha_creacion DESC para que lo más nuevo esté arriba
        $query = "SELECT p.*, u.nombre, u.foto_perfil 
                  FROM publicaciones p 
                  JOIN usuarios u ON p.usuario_id = u.id 
                  ORDER BY p.fecha_creacion DESC";
        $resultado = mysqli_query($conexion, $query);

        while($post = mysqli_fetch_assoc($resultado)) {
            $post_id = $post['id'];
        ?>
            <div class="PostCard">
                <div class="PostHeader">
                    <div class="UserInfo">
                        <!-- Foto de perfil en la esquina izquierda -->
                        <img src="../Fotos de perfiles/<?php echo $post['foto_perfil']; ?>" class="UserPic">
                        <strong><?php echo $post['nombre']; ?></strong>
                    </div>
                    <!-- Hora en la esquina derecha -->
                    <div class="PostTime">
                        <?php echo date('H:i d/m/y', strtotime($post['fecha_creacion'])); ?>
                    </div>
                </div>

                <div class="PostContent"><?php echo $post['contenido']; ?></div>

                <?php if($post['imagen']): ?>
                    <img src="../PublicacionesFotos/<?php echo $post['imagen']; ?>" class="PostImage">
                <?php endif; ?>

                <div class="CommentsSection">
                    <?php
                    // Comentarios en orden de subida
                    $cQuery = "SELECT c.*, u.nombre FROM comentarios c 
                               JOIN usuarios u ON c.usuario_id = u.id 
                               WHERE c.publicacion_id = $post_id 
                               ORDER BY c.fecha_creacion ASC";
                    $resCom = mysqli_query($conexion, $cQuery);
                    while($com = mysqli_fetch_assoc($resCom)){
                        echo "<div class='Comment'><strong>{$com['nombre']}:</strong> {$com['comentario']}</div>";
                    }
                    ?>
                    <form class="formComentar CommentForm">
                        <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                        <input type="text" name="comentario" class="CommentInput" placeholder="Escribir comentario..." required>
                        <button type="submit" class="SubmitBtn" style="width:80px; padding:5px;">Enviar</button>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

    <script>
    // Publicar
    document.getElementById('formPublicar').addEventListener('submit', function(e) {
        e.preventDefault();
        fetch('../Controlador/api.php/CrearPublicacion', {
            method: 'POST',
            body: new FormData(this)
        }).then(() => location.reload());
    });

    // Comentar
    document.querySelectorAll('.formComentar').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            fetch('../Controlador/api.php/CrearComentario', {
                method: 'POST',
                body: new FormData(this)
            }).then(() => location.reload());
        });
    });
</script>
</body>
</html>