<?php
session_start();               // Iniciamos la sesión

include_once 'conexion.php';   // Carga funciones y conexión

// Si ya hay sesión iniciada, redirige a la página principal
if (isset($_SESSION['usuario'])) {
    header("Location: principal.php");  // mejor que apunte a principal.php
    exit;
}

// Procesar login cuando se envía el formulario
if (isset($_POST['login'])) {
    $usuario  = $_POST['usuario'];
    $password = $_POST['password'];

    // Comprobamos usuario y contraseña con la función de conexion.php
    if (usuarioCorrecto($usuario, $password)) {
        // Guardamos el usuario en la sesión
        $_SESSION['usuario'] = $usuario;
        // Redirigimos a la página principal
        header("Location: principal.php");
        exit;
    } else {
        // Mensaje de error si no coincide
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Acceso a aplicaciones</h1>

    <!-- Mostrar error si existe -->
    <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>

    <!-- Formulario de login -->
    <form method="post">
        <label>Usuario:</label>
        <input type="text" name="usuario" required>
        <br>
        <label>Contraseña:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit" name="login">Entrar</button>
    </form>

    <p>¿No tienes cuenta? <a href="registro.php">Registrarse</a></p>
</body>
</html>
