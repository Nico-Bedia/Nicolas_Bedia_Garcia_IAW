<?php
// Función que convierte a minúscula manualmente
function pasar_a_minuscula($cadena) {
    $resultado = ""; // Cadena resultado vacía
    $longitud = strlen($cadena); // Largo de la cadena

    // Recorremos los caracteres
    for ($i = 0; $i < $longitud; $i++) {
        $letra = $cadena[$i]; // Caracter actual
        $codigo = ord($letra); // Código ASCII del carácter

        // Si está entre 'A' y 'Z' (65 a 90 ASCII)
        if ($codigo >= 65 && $codigo <= 90) {
            $codigo = $codigo + 32; // Convertimos a minúscula sumando 32
            $letra = chr($codigo); // Convertir código ASCII a carácter
        }
        $resultado = $resultado . $letra; // Concatenar al resultado
    }
    return $resultado;
}

// Array con nombres en mayúsculas (1 a 10)
$peliculas = array("UNO", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE", "DIEZ");

$resultados = array(); // Arreglo para coincidencias

if (isset($_GET['buscar'])) {
    $buscar = trim($_GET['buscar']); // Quitar espacios

    if ($buscar != "") {
        $buscar = pasar_a_minuscula($buscar); // Convertir texto búsqueda a minúsculas

        // Recorrer array con foreach
        foreach ($peliculas as $pelicula) {
            // Convertir título a minúsculas
            $pelicula_minus = pasar_a_minuscula($pelicula);

            // Buscar si la búsqueda está dentro del título (strpos devuelve posición o false)
            if (strpos($pelicula_minus, $buscar) !== false) {
                $resultados[] = $pelicula; // Guardar resultado
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Buscador de Películas</title>
</head>

<body>

<h1>Buscar película</h1>

<form method="get" action="">
    <input type="text" name="buscar" placeholder="Escribe para buscar"
        value="<?php echo isset($buscar) ? htmlspecialchars($buscar): ''; ?>">
    <input type="submit" value="Buscar">
</form>

<h2>Resultados</h2>
<ul>
    <?php
    if (isset($_GET['buscar'])) {
        if (count($resultados) > 0) {
            // Mostrar resultados encontrados
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
