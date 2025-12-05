<?php

// Funciones de la base de datos

session_start(); // Inicia o continúa la sesión para poder usar $_SESSION

// Datos de conexión (constantes para no repetirlos)
define("HOST", "localhost");
define("USERNAME", "root");
define("PASSWORD", "");
define("DATABASE", "nicolas_bedia");

// -------- FUNCIÓN CONECTAR --------
// Crea y devuelve una conexión MySQLi usando las constantes de arriba
function conectar() {
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    return $conn;
}

// -------- COMPROBAR USUARIO (LOGIN) --------
// Devuelve true si el usuario y contraseña son correctos, false si no
function usuarioCorrecto($usuario, $password) {
    $conn = conectar();

    // Se encripta la contraseña con md5 (no es lo más seguro, pero vale para prácticas)
    $password_md5 = md5($password);

    // Consulta preparada para evitar inyección SQL
    $stmt = $conn->prepare("SELECT * FROM logins WHERE usuario=? AND passwd=?");
    $stmt->bind_param("ss", $usuario, $password_md5);

    // Ejecuta la consulta y obtiene el resultado
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Si hay al menos una fila, el usuario existe con esa contraseña
    $existe = $resultado->num_rows > 0;

    // Cerramos recursos
    $stmt->close();
    $conn->close();

    return $existe;
}

// -------- REGISTRAR NUEVO USUARIO --------
// Inserta un usuario nuevo en la tabla logins
function registrarUsuario($usuario, $password) {
    $conn = conectar();

    // Encriptamos la contraseña igual que en el login
    $password_md5 = md5($password);

    // Insert preparado
    $stmt = $conn->prepare("INSERT INTO logins(usuario, passwd) VALUES(?, ?)");
    $stmt->bind_param("ss", $usuario, $password_md5);

    // Ejecutamos y guardamos si ha ido bien (true/false)
    $resultado = $stmt->execute();

    $stmt->close();
    $conn->close();

    return $resultado;
}

// -------- OBTENER TODAS LAS APLICACIONES --------
// Devuelve un array con todas las filas de la tabla aplicaciones
function getAplicaciones() {
    $conn = conectar();

    // Ejecuta la consulta directa
    $resultado = $conn->query("SELECT * FROM aplicaciones");

    $apps = [];
    // Recorre todas las filas y las mete en el array $apps
    while ($fila = $resultado->fetch_assoc()) {
        $apps[] = $fila;
    }

    $conn->close();
    return $apps;
}

// -------- INSERTAR NUEVA APLICACIÓN --------
// Inserta una aplicación con nombre y descripción
function insertarAplicacion($nombre, $descripcion) {
    $conn = conectar();

    // Insert preparado para aplicaciones
    $stmt = $conn->prepare(
        "INSERT INTO aplicaciones(nombre_aplicacion, descripcion) VALUES(?, ?)"
    );
    $stmt->bind_param("ss", $nombre, $descripcion);

    $resultado = $stmt->execute();

    $stmt->close();
    $conn->close();

    return $resultado;
}

// -------- BORRAR APLICACIÓN --------
// Borra una aplicación por su nombre (nombre_aplicacion)
function borrarAplicacion($nombre) {
    $conn = conectar();

    $stmt = $conn->prepare(
        "DELETE FROM aplicaciones WHERE nombre_aplicacion=?"
    );
    $stmt->bind_param("s", $nombre);

    $resultado = $stmt->execute();

    $stmt->close();
    $conn->close();

    return $resultado;
}
?>
