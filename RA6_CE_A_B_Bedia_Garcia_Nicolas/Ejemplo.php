<?php
// Datos de conexion
$host = "localhost";
$user = "usuario";
$password = "contrasena";
$database = "basededatos";

// Crear una conexion usando OOP MySQLi
$conexion = new mysqli($host, $user, $password, $database);

// Verificar la conexion
if ($conexion->connect_error) {
    die("Error de conexion: " . $conexion->connect_error);
}

// Consulta segura que puede ser preparada si se desean filtros
$sql = "SELECT * FROM tabla";

// Ejecutar la consulta
if ($resultado = $conexion->query($sql)) {
    // Revisar si hay resultados
    if ($resultado->num_rows > 0) {
        // Recorrer resultados
        while ($fila = $resultado->fetch_assoc()) {
            echo "Campo: " . htmlspecialchars($fila['campo']) . "<br>";
        }
    } else {
        echo "No se encontraron registros.";
    }
    // Liberar resultado
    $resultado->free();
} else {
    echo "Error en la consulta: " . $conexion->error;
}

// Cerrar la conexion
$conexion->close();
?>
