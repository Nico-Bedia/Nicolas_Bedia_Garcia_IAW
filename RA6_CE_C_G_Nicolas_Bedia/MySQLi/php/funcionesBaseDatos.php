<?php
// Incluye el archivo donde están definidas las constantes HOST, USERNAME, PASSWORD, DATABASE
include_once 'constantes.php';

/* Conexion MySQLi */
function getConexionMySQLi()
{
    // constantes de conexión y la base de datos
    $mysqli = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);

    // Comprueba si hubo error de conexión
    if ($mysqli->connect_error) {
        // Si hay error, termina el script mostrando el mensaje
        die("Error de conexión MySQLi: " . $mysqli->connect_error);
    }

    // 
    $mysqli->set_charset("utf8");

    // Devuelve el objeto de conexión
    return $mysqli;
}


function getConexionMySQLi_sin_bbdd()
{
    // Crea la conexión, pero sin seleccionar base de datos (no pasamos DATABASE)
    $mysqli = new mysqli(HOST, USERNAME, PASSWORD);

    // Comprueba si hubo error de conexión
    if ($mysqli->connect_error) {
        // Si hay error, termina el script mostrando el mensaje
        die("Error de conexión MySQLi sin BD: " . $mysqli->connect_error);
    }

    $mysqli->set_charset("utf8");

    // Devuelve el objeto de conexión
    return $mysqli;
}


/* Crear base de datos y tablas */
function crearBBDD_MySQLi($basedatos) {
    // Crea conexión sin base de datos 
    $mysqli = getConexionMySQLi_sin_bbdd();

    // Consulta SQL para ver si existe una base de datos 
    $sql = "SHOW DATABASES LIKE '$basedatos'";

    // Ejecuta la consulta
    $result = $mysqli->query($sql);

    // Si hay al menos una fila, la base de datos ya existe
    if ($result -> num_rows > 0) // base de datos creada
    { 
        // Devuelve 1 indicando que ya existe
        return 1;
    }
    else { 
        // Sentencia para crear la base de datos 
        $crearBD= "CREATE DATABASE $basedatos CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"; 
        
        // Ejecuta la sentencia de creación
        $result = $mysqli->query($crearBD);

        // Devuelve 0 indicando que no existía (la acabamos de crear)
        return 0; // base de datos no
    }

    // Cierra la conexión (esta línea no se ejecuta porque ya se hace return antes)
    $mysqli->close();
}
    


function crearTablas_MySQLi($basedatos) {
    // Crea conexión con base de datos 
    $mysqli = getConexionMySQLi();

    // Sentencia SQL para crear la tabla libros si no existe
    $sqlLibros = "CREATE TABLE IF NOT EXISTS libros (
        numero_ejemplar INT AUTO_INCREMENT PRIMARY KEY,
        titulo VARCHAR(255) NOT NULL,
        anyo_edicion INT NOT NULL,
        precio DECIMAL(8,2) NOT NULL,
        fecha_adquisicion DATE NOT NULL
    ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";

    // Sentencia SQL para crear la tabla logins si no existe
    $sqlLogins = "CREATE TABLE IF NOT EXISTS logins (
        usuario VARCHAR(50) PRIMARY KEY,
        password VARCHAR(255) NOT NULL
    ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";

    // Ejecuta la creación de la tabla libros
    $ok1 = $mysqli->query($sqlLibros);

    // Ejecuta la creación de la tabla logins
    $ok2 = $mysqli->query($sqlLogins);

    // Cierra la conexión
    $mysqli->close();

    // Devuelve true solo si las dos consultas fueron correctas
    return $ok1 && $ok2;
}


/* Usuario funciones */
function usuarioCorrecto_MySQLi($usuario, $password)
{
    // Crea conexión a la base de datos
    $mysqli = getConexionMySQLi();

    // Cifra la contraseña con MD5 (no es lo más seguro, pero funciona como ejemplo)
    $passwordCifrada = md5($password);

    // Consulta SQL con placeholders para evitar inyección SQL
    $sql = "SELECT usuario FROM logins WHERE usuario = ? AND password = ?";

    // Prepara la consulta
    $stmt = $mysqli->prepare($sql);

    // Si falla la preparación, se muestra error y se termina
    if (!$stmt) die("Error preparando consulta: " . $mysqli->error);

    // Enlaza los parámetros $usuario y $passwordCifrada como strings ("ss")
    $stmt->bind_param("ss", $usuario, $passwordCifrada);

    // Ejecuta la consulta preparada
    $stmt->execute();

    // Obtiene el conjunto de resultados
    $result = $stmt->get_result();

    // Cierra el statement
    $stmt->close();

    // Cierra la conexión
    $mysqli->close();

    // Devuelve true si hay resultado y al menos una fila (usuario+password correctos)
    return $result && $result->num_rows > 0;
}


function registrarUsuario_MySQLi($usuario, $password)
{
    // Crea conexión a la base de datos
    $mysqli = getConexionMySQLi();

    // Cifra la contraseña con MD5
    $passwordCifrada = md5($password);

    // Consulta para comprobar si el usuario ya existe
    $sql_exists = "SELECT usuario FROM logins WHERE usuario = ?";

    // Prepara la consulta
    $stmt = $mysqli->prepare($sql_exists);

    // Enlaza el parámetro $usuario
    $stmt->bind_param("s", $usuario);

    // Ejecuta la consulta
    $stmt->execute();

    // Obtiene el resultado (si hay usuario con ese nombre)
    $result = $stmt->get_result();

    // Si fetch_assoc devuelve algo, el usuario ya existe
    if ($result->fetch_assoc()) {
        // Cierra el statement
        $stmt->close();

        // Cierra la conexión
        $mysqli->close();

        // Devuelve false indicando que no se registra porque ya existe
        return false; // Usuario ya existente 
    }

    // Cierra el statement anterior
    $stmt->close();

    // Consulta para insertar un nuevo usuario
    $sql = "INSERT INTO logins (usuario, password) VALUES (?, ?)";

    // Prepara la sentencia de inserción
    $stmt = $mysqli->prepare($sql);

    // Enlaza usuario y contraseña cifrada
    $stmt->bind_param("ss", $usuario, $passwordCifrada);

    // Ejecuta la sentencia y guarda si fue correcta o no
    $ok = $stmt->execute();

    // Cierra el statement
    $stmt->close();

    // Cierra la conexión
    $mysqli->close();

    // Devuelve true si se insertó correctamente
    return $ok;
}


/* Libros CRUD básico */
function insertarLibro_MySQLi($titulo, $anyo, $precio, $fechaAdquisicion)
{
    // Crea conexión
    $mysqli = getConexionMySQLi();

    // Sentencia de inserción con placeholders
    $sql = "INSERT INTO libros (titulo, anyo_edicion, precio, fecha_adquisicion) VALUES (?, ?, ?, ?)";

    // Prepara la sentencia
    $stmt = $mysqli->prepare($sql);

    // Si falla la preparación, muestra error y termina
    if ($stmt === false) die("Error preparando libro: " . $mysqli->error);

    // Enlaza los parámetros:
    // s = string (titulo), i = int (año), d = double (precio), s = string (fecha)
    $stmt->bind_param("sids", $titulo, $anyo, $precio, $fechaAdquisicion);

    // Ejecuta la sentencia
    $ok = $stmt->execute();

    // Cierra el statement
    $stmt->close();

    // Cierra la conexión
    $mysqli->close();

    // Devuelve true si se insertó correctamente
    return $ok;
}


function getLibros_MySQLi()
{
    // Crea conexión
    $mysqli = getConexionMySQLi();

    // Consulta para obtener todos los libros
    $sql = "SELECT * FROM libros";

    // Ejecuta la consulta
    $result = $mysqli->query($sql);

    // Inicializa un array para guardar los libros
    $libros = [];

    // Si la consulta devolvió algo
    if ($result) {
        // Recorre cada fila convirtiéndola en objeto
        while ($fila = $result->fetch_object()) {
            // Añade el objeto al array
            $libros[] = $fila;
        }
    }

    // Cierra la conexión
    $mysqli->close();

    // Devuelve el array de libros (puede estar vacío)
    return $libros;
}


function getLibrosTitulo_MySQLi()
{
    // Crea conexión
    $mysqli = getConexionMySQLi();

    // Consulta para obtener solo el título
    $sql = "SELECT titulo FROM libros";

    // Ejecuta la consulta
    $result = $mysqli->query($sql);

    // Array para guardar los títulos
    $titulos = [];

    // Si hay resultado
    if ($result) {
        // Recorre cada fila como array asociativo
        while ($fila = $result->fetch_assoc()) {
            // Añade solo el valor de 'titulo' al array
            $titulos[] = $fila['titulo'];
        }
    }

    // Cierra la conexión
    $mysqli->close();

    // Devuelve el array de títulos
    return $titulos;
}


function borrarLibro_MySQLi($numeroEjemplar)
{
    // Crea conexión
    $mysqli = getConexionMySQLi();

    // Consulta de borrado con placeholder
    $sql = "DELETE FROM libros WHERE numero_ejemplar = ?";

    // Prepara la sentencia
    $stmt = $mysqli->prepare($sql);

    // Si falla la preparación, error y termina
    if (!$stmt) die("Error preparando borrado: " . $mysqli->error);

    // Enlaza el parámetro (entero)
    $stmt->bind_param("i", $numeroEjemplar);

    // Ejecuta la sentencia
    $ok = $stmt->execute();

    // Cierra el statement
    $stmt->close();

    // Cierra la conexión
    $mysqli->close();

    // Devuelve true si se borró correctamente
    return $ok;
}


function modificarLibro_MySQLi($numero_ejemplar, $precio)
{
    // Crea conexión
    $mysqli = getConexionMySQLi();

    // Consulta para actualizar el precio
    $sql = "UPDATE libros SET precio = ? WHERE numero_ejemplar = ?";

    // Prepara la sentencia
    $stmt = $mysqli->prepare($sql);

    // Si falla la preparación, error y termina
    if (!$stmt) die("Error preparando actualización precio: " . $mysqli->error);

    // Enlaza parámetros: d = double (precio), i = int (número ejemplar)
    $stmt->bind_param("di", $precio, $numero_ejemplar);

    // Ejecuta la sentencia
    $ok = $stmt->execute();

    // Cierra el statement
    $stmt->close();

    // Cierra la conexión
    $mysqli->close();

    // Devuelve true si se actualizó correctamente
    return $ok;
}


function modificarLibroAnyo_MySQLi($numero_ejemplar, $anyo_edicion)
{
    // Crea conexión
    $mysqli = getConexionMySQLi();

    // Consulta para actualizar el año de edición
    $sql = "UPDATE libros SET anyo_edicion = ? WHERE numero_ejemplar = ?";

    // Prepara la sentencia
    $stmt = $mysqli->prepare($sql);

    // Si falla la preparación, error y termina
    if (!$stmt) die("Error preparando actualización año: " . $mysqli->error);

    // Enlaza parámetros: i = int (año), i = int (nº ejemplar)
    $stmt->bind_param("ii", $anyo_edicion, $numero_ejemplar);

    // Ejecuta la sentencia
    $ok = $stmt->execute();

    // Guarda cuántas filas se modificaron
    $filas = $stmt->affected_rows; // filas modificadas

    // Cierra el statement
    $stmt->close();

    // Cierra la conexión
    $mysqli->close();

    // Devuelve array con si fue ok y cuántas filas se cambiaron
    return [$ok, $filas];
}




function getLibrosPrecio_MySQLi($libro)
{
    // Crea conexión
    $mysqli = getConexionMySQLi();

    // Consulta para obtener el precio de los libros con ese título
    $sql = "SELECT precio FROM libros WHERE titulo = ?";

    // Prepara la sentencia
    $stmt = $mysqli->prepare($sql);

    // Si falla la preparación, error y termina
    if (!$stmt) die("Error preparando consulta precios: " . $mysqli->error);

    // Enlaza el título como string
    $stmt->bind_param("s", $libro);

    // Ejecuta la sentencia
    $stmt->execute();

    // Obtiene el resultado
    $resultado = $stmt->get_result();

    // Array para guardar los precios
    $precios = [];

    // Recorre las filas como array asociativo
    while ($fila = $resultado->fetch_assoc()) {
        // Convierte el precio a float y lo añade al array
        $precios[] = floatval($fila['precio']);
    }

    // Cierra el statement
    $stmt->close();

    // Cierra la conexión
    $mysqli->close();

    // Devuelve el array de precios
    return $precios;
}


function getLibrosAnyo_MySQLi($libro) {
    // Crea conexión
    $mysqli = getConexionMySQLi();

    // Consulta para obtener título, año y nº ejemplar de los libros con ese título
    $sql = "SELECT titulo, anyo_edicion, numero_ejemplar FROM libros WHERE titulo = ?";

    // Prepara la sentencia
    $stmt = $mysqli->prepare($sql);

    // Si falla la preparación, error y termina
    if (!$stmt) die("Error preparando consulta años: " . $mysqli->error);

    // Enlaza el título como string
    $stmt->bind_param("s", $libro);

    // Ejecuta la sentencia
    $stmt->execute();

    // Obtiene el resultado
    $resultado = $stmt->get_result();
    
    // Array para guardar la info de los libros
    $libros = [];

    // Recorre los resultados como array asociativo
    while ($fila = $resultado->fetch_assoc()) { 
        // Añade cada libro como array con tipos convertidos a int
        $libros[] = [
            'titulo'          => $fila['titulo'],
            'anyo_edicion'    => intval($fila['anyo_edicion']),
            'numero_ejemplar' => intval($fila['numero_ejemplar'])
        ];
    }

    // Cierra el statement
    $stmt->close();

    // Cierra la conexión
    $mysqli->close();

    // Devuelve el array de libros
    return $libros;
}





function arrayFlotante($array) {
   
    return array_map('floatval', $array);
}


?>
