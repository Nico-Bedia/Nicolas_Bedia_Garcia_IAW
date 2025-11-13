<?php
function pasar_a_minuscula($cadena) {
    return strtolower($cadena); // Nos convierte la cadena en minuscula
}

$peliculas = [
    "Salvar al soldado Ryan",
    "Apocalypse Now",
    "La delgada línea roja",
    "Fury",
    "Dunkerque",
    "Platoon",
    "Rescatando al soldado Pérez",
    "En tierra hostil",
    "Black Hawk derribado",
    "1917"
];

echo '<form method="GET">';
echo 'Buscar película: <input type="text" name="busqueda">';
echo '<input type="submit" value="Buscar">';
echo '</form>';

if (isset($_GET['busqueda'])) {
    $busqueda = $_GET['busqueda'];
    echo '<h3>Resultados:</h3>';
    $encontradas = false;
    foreach ($peliculas as $peli) {
        if (stripos($peli, $busqueda) !== false) { // Búsqueda insensible a mayúsculas
            // Muestra el resultado en minúscula
            echo "<p>Película: " . pasar_a_minuscula($peli) . "</p>";
            $encontradas = true;
        }
    }
    if (!$encontradas) {
        echo '<p>No se encontró la película</p>';
    }
}
?>
