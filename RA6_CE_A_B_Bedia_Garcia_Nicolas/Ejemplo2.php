<?php
// Datos de conexion
$host = 'localhost';
$dbname = 'basededatos';
$user = 'usuario';
$pass = 'contrasena';

try {
    // Crear instancia PDO con atributos para manejar excepciones
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch assoc por defecto
    ]);

    // Preparar consulta (en este caso sin parametros, pero permite seguridad para consultas futuras)
    $stmt = $pdo->prepare("SELECT * FROM tabla");

    // Ejecutar la consulta
    $stmt->execute();

    // Comprobar si hay resultados
    if ($stmt->rowCount() > 0) {
        // Recorrer resultados
        while ($fila = $stmt->fetch()) {
            // Mostrar con htmlspecialchars para evitar XSS
            echo "Campo: " . htmlspecialchars($fila['campo']) . "<br>";
        }
    } else {
        echo "No se encontraron registros.";
    }
} catch (PDOException $e) {
    echo "Error en la conexion o consulta: " . $e->getMessage();
}
?>
