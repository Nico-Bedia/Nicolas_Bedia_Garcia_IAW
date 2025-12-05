<?php
session_start();               // Iniciamos / continuamos la sesión

// Página de registro de usuarios.

include_once 'conexion.php';

// Si se ha enviado el formulario de registro
if (isset($_POST['registrar'])) {
    $usuario   = $_POST['usuario'];
    $password  = $_POST['password'];
    $password2 = $_POST['password2'];

    // Comprobamos que las contraseñas coinciden
    if ($password !== $password2) {
        $error = "Las contraseñas no coinciden.";
    } else {
        // Intentamos registrar el usuario (función en conexion.php)
        if (registrarUsuario($usuario, $password)) {
            // Guardamos el usuario en sesión y redirigimos
            $_SESSION['usuario'] = $usuario;
            header("Location: principal.php");
            exit;
        } else {
            $error = "Error: El usuario ya existe o no se pudo registrar.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body>
    <h1>Registrar nuevo usuario</h1>

    <!-- Mostrar mensaje de error si lo hay -->
    <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>

    <!-- Formulario de registro -->
    <form method="post">
        <label>Usuario:</label>
        <input type="text" name="usuario" required>
        <br>
        <label>Contraseña:</label>
        <input type="password" name="password" required>
        <br>
        <label>Repetir contraseña:</label>
        <input type="password" name="password2" required>
        <br>
        <button type="submit" name="registrar">Registrar</button>
    </form>

    <p><a href="index.php">Volver al login</a></p>
</body>
</html>
