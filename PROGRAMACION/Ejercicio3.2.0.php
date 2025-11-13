<?php
// Creacion de Array con 10 nombres de peliculas
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

// Comprobacion de busqueda de pelicula
echo '<form method="GET">';
echo 'Buscar película: <input type="text" name="busqueda">';
echo '<input type="submit" value="Buscar">';
echo '</form>';

if (isset($_GET['busqueda'])) {
    $busqueda = $_GET['busqueda'];
    echo '<h3>Resultados:</h3>';
    $encontradas = false;
    foreach ($peliculas as $peli) {
        // Muestra el resultado //
        if (stripos($peli, $busqueda) !== false) {
            echo "<p>Película: $peli</p>";
            $encontradas = true;
        }
    }
    if (!$encontradas) {
        echo '<p>No se encontró la pelicula.</p>';
    }
}
?>
