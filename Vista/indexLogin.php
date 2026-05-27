<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto de prueba</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="Container">
    <h2>Formulario HTML</h2>
        <div class="FormBoxLog">
            <form action="../Controlador/api.php/Login" method="Post"> <!-- con action le decimos hacia donde enviamos los datos con method es el metodo de enviado -->
                <table>
                    <tr>
                        <td>
                            <label for="MailLog">mail:</label>
                        </td>
                        <td>
                            <input type="text" id="MailLog" name="MailLog" placeholder="mail@gmail.com"><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="PasswordLog">Password:</label>
                        </td>
                        <td>
                            <input type="password" id="PasswordLog" name="PasswordLog" placeholder="******"><br>
                        </td>
                    </tr>
                </table>

                <button type="Submit" class="SubmitBtn">Entrar</button>
                </form>
        </div>
        <p>Si no tienes cuenta registrate <a href="indexRegister.php">aqui</a> </p>
    </div>
</body>
</html>