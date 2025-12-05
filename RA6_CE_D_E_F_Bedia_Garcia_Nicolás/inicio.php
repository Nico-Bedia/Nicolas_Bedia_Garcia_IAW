<?php
session_start();               // 1) Inicia / continúa la sesión

// Página principal tras login.

include_once 'conexion.php';   // 2) Incluye funciones y conexión

// 3) Si no hay usuario en sesión, vuelve al login
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Principal</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <!-- 4) Muestra mensaje de bienvenida usando el usuario en sesión -->
    <h1>Bienvenido a mi pagina principal: Nico Bedia <?php echo $_SESSION['usuario']; ?></h1>
    <ul>
        <!-- 5) Enlace a la gestión de aplicaciones (carpeta admin) -->
        <li><a href="admin/aplicaciones.php">Gestiona las Aplicaciones</a></li>
        <!-- 6) Enlace para cerrar sesión -->
        <li><a href="logoff.php">Cerrar la sesión</a></li>
    </ul>
</body>
</html>
