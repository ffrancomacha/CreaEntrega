<?php
include '../Conexion/Conexion.php';
session_start();

// Obtenemos la acción desde la URL (ejemplo: api.php/Login -> action será /Login)
$action = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';

switch ($action) {
    case '/Login':
        procesarLogin($conexion);
        break;

    case '/CrearPublicacion':
        procesarPublicacion($conexion);
        break;

    case '/Register':
        procesarRegistro($conexion);
        break;

    case '/CrearComentario':
        procesarComentario($conexion);
        break;


    case '/Logout':
        processarLogout($conexion);

    default:
        echo "Acción no válida";
        break;
}

// --- FUNCIÓN DE LOGIN ---
function procesarLogin($conexion) {
    $EmailLogin = $_POST["MailLog"];
    $ContraseniaLogin = $_POST["PasswordLog"];

    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $EmailLogin, $ContraseniaLogin);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        $_SESSION['usuario_id'] = $usuario['id']; // <--- NUEVO: Guardamos el ID
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['usuario_foto'] = $usuario['foto_perfil'];
       
        header("Location:http://localhost/Utu/LoginUtu/Vista/perfil.php");
        exit();
    } else {
        echo "<script>alert('Correo o contraseña incorrectos'); window.location='../Vista/indexLogin.php';</script>";
    }
}

// --- FUNCIÓN DE REGISTRO ---
function procesarRegistro($conexion) {
    $Nombre = $_POST["FName"];
    $SegundoNombre = $_POST["SName"];
    $Apellido = $_POST["LName"];
    $Email = $_POST["Mail"];
    $Contrasenia = $_POST["Password"];

    $NombreCompleto = $Nombre . " " . $SegundoNombre . " " . $Apellido;
    $nombreFoto = "default.png"; 

    // Manejo de la imagen
    if (isset($_FILES['ProfilePic']) && $_FILES['ProfilePic']['error'] === 0) {
        $carpetaDestino = "../Fotos de perfiles/";
        if (!file_exists($carpetaDestino)) {
            mkdir($carpetaDestino, 0777, true);
        }

        $extension = pathinfo($_FILES['ProfilePic']['name'], PATHINFO_EXTENSION);
        $nombreFoto = time() . "_" . $Email . "." . $extension; 
        move_uploaded_file($_FILES['ProfilePic']['tmp_name'], $carpetaDestino . $nombreFoto);
    }

    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, email, password, foto_perfil) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $NombreCompleto, $Email, $Contrasenia, $nombreFoto);

    if ($stmt->execute()) {
        echo "<script>alert('Usuario registrado con éxito'); window.location='http://localhost/Utu/LoginUtu/Vista/indexLogin.php';</script>";
        } else {
        echo "Error al registrar: " . $stmt->error;
    }
    $stmt->close();
}

function procesarPublicacion($conexion) {
    // No olvides el session_start si no está al inicio del archivo
    $usuario_id = $_SESSION['usuario_id']; // Asegúrate de haber guardado esto en el Login
    $contenido = $_POST['contenido'];
    $nombreFoto = null;

    if (isset($_FILES['PostPic']) && $_FILES['PostPic']['error'] === 0) {
        $carpetaDestino = "../PublicacionesFotos/";
        if (!file_exists($carpetaDestino)) {
            mkdir($carpetaDestino, 0777, true);
        }

        $extension = pathinfo($_FILES['PostPic']['name'], PATHINFO_EXTENSION);
        $nombreFoto = "post_" . time() . "_" . uniqid() . "." . $extension;
        move_uploaded_file($_FILES['PostPic']['tmp_name'], $carpetaDestino . $nombreFoto);
    }

    $stmt = $conexion->prepare("INSERT INTO publicaciones (usuario_id, contenido, imagen) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $usuario_id, $contenido, $nombreFoto);

    if ($stmt->execute()) {
        // En lugar de header redirect, enviamos una respuesta exitosa a JS
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conexion->error]);
    }
    $stmt->close();
    exit; // Importante para que no imprima nada más
}


function procesarComentario($conexion) {
    session_start();
    $usuario_id = $_SESSION['usuario_id'];
    $publicacion_id = $_POST['post_id'];
    $comentario = $_POST['comentario'];

    $stmt = $conexion->prepare("INSERT INTO comentarios (publicacion_id, usuario_id, comentario) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $publicacion_id, $usuario_id, $comentario);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
    exit;
}

function processarLogout($conexion){
//session_start();
session_destroy();
header("Location:http://localhost/Utu/LoginUtu/Vista/indexLogin.php");
}
$conexion->close();
?>