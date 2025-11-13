<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Calculadora PHP con estilo</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      background-color: #f7f9fc;
      color: #333;
    }
    h2 {
      color: #005a9c;
      border-bottom: 2px solid #005a9c;
      padding-bottom: 5px;
    }
    form {
      margin-bottom: 20px;
    }
    label {
      font-weight: bold;
      margin-right: 10px;
    }
    input[type="number"] {
      padding: 5px;
      width: 150px;
      border: 1px solid #ccc;
      border-radius: 4px;
      margin-right: 10px;
    }
    button {
      background-color: #005a9c;
      color: white;
      padding: 6px 15px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    button:hover {
      background-color: #003f6a;
    }
    table {
      border-collapse: collapse;
      width: 50%;
      margin-top: 10px;
    }
    table, th, td {
      border: 1px solid #ccc;
    }
    th, td {
      padding: 8px 12px;
      text-align: left;
    }
    th {
      background-color: #e9f1f7;
    }
    p {
      max-width: 800px;
      line-height: 1.4;
    }
  </style>
</head>
<body>

<h2>Fecha actual</h2>
<p>
<?php
$diasSemana = ["lunes", "martes", "miércoles", "jueves", "viernes", "sábado", "domingo"];
$meses = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
$fecha = getdate();
echo $diasSemana[$fecha['wday']] . ", " . $fecha['mday'] . " de " . $meses[$fecha['mon'] - 1] . " de " . $fecha['year'];
?>
</p>

<h2>Introduce un número para verificar</h2>
<form method="post">
  <label for="numSumaProd">Número:</label>
  <input type="number" id="numSumaProd" name="numSumaProd" required>
  <button type="submit" name="checkSumaProd">Comprobar</button>
</form>

<?php
function sumaProductoIgual($num) {
    $digitos = ($num);
    $suma = array_sum($digitos);
    $producto = 1;
    foreach ($digitos as $d) {
        $producto *= $d;
    }
    return $suma == $producto;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkSumaProd']) && isset($_POST['numSumaProd'])) {
    $numSP = ($_POST['numSumaProd']);
    $resultadoSP = ($numSP) ? "Cumple" : "No cumple";
    echo "<p>El número <strong>$numSP</strong> $resultadoSP la condición suma = producto de sus dígitos.</p>";
}

// Mostrar todos los números entre 100 y 999 que cumplen para referencia
$numerosEspeciales = [];
for ($i = 100; $i <= 999; $i++) {
    if (sumaProductoIgual($i)) {
        $numerosEspeciales[] = $i;
    }
}
echo "<p><strong>Números entre 100 y 999 que cumplen suma = producto:</strong> " . implode(", ", $numerosEspeciales) . "</p>";
?>

<h2>Introduce un número para calcular factorial y comprobar si es primo</h2>
<form method="post">
  <label for="numero">Número:</label>
  <input type="number" id="numero" name="numero" required>
  <button type="submit" name="calcFactPrimo">Calcular</button>
</form>

<?php
function factorial($n) {
    $resultado = 1;
    for ($i = 1; $i <= $n; $i++) {
        $resultado *= $i;
    }
    return $resultado;
}

function esPrimo($n) {
    if ($n < 2) return false;
    for ($i = 2; $i <= sqrt($n); $i++) {
        if ($n % $i == 0) return false;
    }
    return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['calcFactPrimo']) && isset($_POST['numero'])) {
    $num = intval($_POST['numero']);
    $fact = factorial($num);
    $primo = esPrimo($num) ? "Sí" : "No";

    echo "<h3>Resultados para el número $num</h3>";
    echo "<table>";
    echo "<tr><th>Cálculo</th><th>Resultado</th></tr>";
    echo "<tr><td>Factorial</td><td>$fact</td></tr>";
    echo "<tr><td>¿Es primo?</td><td>$primo</td></tr>";
    echo "</table>";
}
?>

</body>
</html>
