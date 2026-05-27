<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Proyecto de prueba</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="Container">
        <h2>Registro de Usuario</h2>
        <form action="../Controlador/api.php/Register" method="Post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td><label for="FName">Nombre:</label></td>
                    <td><input type="text" id="FName" name="FName" required></td>
                </tr>
                <tr>
                    <td><label for="SName">Segundo Nombre:</label></td>
                    <td><input type="text" id="SName" name="SName"></td>
                </tr>
                <tr>
                    <td><label for="LName">Apellido:</label></td>
                    <td><input type="text" id="LName" name="LName" required></td>
                </tr>
                <tr>
                    <td><label for="Mail">Email:</label></td>
                    <td><input type="email" id="Mail" name="Mail" required></td>
                </tr>
                <tr>
                    <td><label for="Password">Password:</label></td>
                   <td><input type="password" id="Password" name="Password" minlength="8" required></td>
                </tr>
                <tr>
            <td><label for="ProfilePic">Foto de Perfil:</label></td>
            <td><input type="file" id="ProfilePic" name="ProfilePic" accept="image/*"></td>
        </tr>
            </table>
            <button type="Submit" class="SubmitBtn">Registrarse</button>
        </form>
        <p>¿Ya tienes cuenta? <a href="indexLogin.php">Inicia sesión aquí</a></p>
    </div>
<script>
    // Esperamos a que el DOM cargue
    document.addEventListener("DOMContentLoaded", function() {
        // Seleccionamos el formulario
        const form = document.querySelector("form");
        const passwordInput = document.getElementById("Password");

        form.addEventListener("submit", function(event) {
            // Obtenemos el valor de la contraseña
            const password = passwordInput.value;

            // Verificamos si tiene menos de 8 caracteres
            if (password.length < 8) {
                // Evitamos que el formulario se envíe
                event.preventDefault();
                
                // Mostramos un mensaje de error
                alert("La contraseña debe tener al menos 8 caracteres.");
                
                // Opcional: poner el foco de nuevo en el campo
                passwordInput.focus();
            }
        });
    });
</script>
</body>
</html>