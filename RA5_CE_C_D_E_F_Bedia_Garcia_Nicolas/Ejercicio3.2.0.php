<?php
// Definir array con nombres del uno al diez
$peliculas = array("Uno", "Dos", "Tres", "Cuatro", "Cinco", "Seis", "Siete", "Ocho", "Nueve", "Diez");

// Variable arreglo donde se guardarán resultados de búsqueda
$resultados = array();

// Comprobar si se ha enviado información desde el formulario mediante GET
if (isset($_GET['buscar'])) {
    $buscar = trim($_GET['buscar']); // Quitar espacios al principio y final
    
    if ($buscar != "") {
        // Recorrer el array de películas con foreach para buscar coincidencias
        foreach ($peliculas as $pelicula) {
            // Buscar la cadena dentro del nombre película usando strpos para no ser sensible a mayúsculas
            if (stripos($pelicula, $buscar) !== false) {
                $resultados[] = $pelicula; // Si coincide, agregar al resultado
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Búsqueda de Películas</title>
</head>
<body>

<h1>Buscador de películas</h1>

<!-- Formulario HTML con método GET -->
<form action="" method="get">
    <input type="text" name="buscar" placeholder="Escribe para buscar" 
           value="<?php echo isset($buscar) ? ($buscar) : ''; ?>">
    <input type="submit" value="Buscar">
</form>

<h2>Resultados</h2>
<ul>
    <?php 
    if (isset($_GET['buscar'])) {
        if (count($resultados) > 0) {
            foreach ($resultados as $res) {
                echo "<li>" . htmlspecialchars($res) . "</li>";
            }
        } else {
            echo "<li>No se encontraron películas.</li>";
        }
    }
    ?>
</ul>

</body>
</html>
