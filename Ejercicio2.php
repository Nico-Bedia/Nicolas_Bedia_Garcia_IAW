<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
</head>

<body>
    <?php
        // Definición de los operadores con su valor asignado
        $operador1 = 13;
        $operador2 = 4;

        // Resta, resultado y se podra ver en pantalla
        $resultado = $operador1 - $operador2;
        echo "<p> La resta de $operador1 - $operador2 es igual a $resultado </p>";

        // Suma, resultado y se podra ver en pantalla
        $resultado = $operador1 + $operador2;
        echo "<p> La suma de $operador1 + $operador2 es igual a $resultado </p>";

        // Multiplicación, resultado y se podra ver en pantalla
        $resultado = $operador1 * $operador2;
        echo "<p> La multiplicación de $operador1 * $operador2 es igual a $resultado </p>";

        // División, resultado y se podra ver en pantalla
        $resultado = $operador1 / $operador2;
        echo "<p> La división de $operador1 / $operador2 es igual a $resultado </p>";

        //Resto o módulo, resultado y se podra ver en pantalla
        $resultado = $operador1 % $operador2;
        echo "<p> El resto o módulo de $operador1 % $operador2 es igual a $resultado </p>";
    ?>
</body>
</html>
