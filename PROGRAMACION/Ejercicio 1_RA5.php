<?php
session_start(); // Inicia la sesión para el contador por sesión
// Zona horaria recomendada
// Puedes cambiar 'Europe/Madrid' a tu preferida
date_default_timezone_set('Europe/Madrid');

// --------- BLOQUE EXTRA PARA EL ENUNCIADO --------- //
// Autenticación simulada (solo en este ejemplo)
if (!isset($_SESSION['autenticado'])) {
    // Autenticado por defecto, simulado
    $_SESSION['autenticado'] = true;
}
if (!$_SESSION['autenticado']) {
    die("Acceso no autorizado. Inicia sesión para continuar.");
}

// Si solicitan borrar visitas:
if (isset($_POST['borrar_visitas'])) {
    unset($_SESSION['instantes_visita']);
    $visitas_borradas = true;
}
// --------- FIN BLOQUE EXTRA --------- //


/* --- Mensaje de anterior visita (cookie) --- */
$ahora = date('d/m/Y H:i');
if (isset($_COOKIE['ultima_visita'])) {
    $mensaje_cookie = "Bienvenido de nuevo! Tu última visita fue el " . $_COOKIE['ultima_visita'] . ".";
} else {
    $mensaje_cookie = "Bienvenido! Esta es tu primera visita.";
}


// Actualiza la cookie a la fecha de la visita actual
setcookie('ultima_visita', $ahora, time() + 60*60*24*365); // 1 año


/* --- Contador de visitas con sesión --- */
if (!isset($_SESSION['visitas'])) {
    $_SESSION['visitas'] = 1;
} else {
    $_SESSION['visitas']++;
}


/* --- Registro de instantes de visita por sesión --- */
if (!isset($_SESSION['instantes_visita'])) {
    $_SESSION['instantes_visita'] = [];
}
// Evita registrar cuando acaban de borrar, solo en POST que no sea borrar
if (!isset($visitas_borradas)) {
    array_push($_SESSION['instantes_visita'], $ahora);
}
$numero_visitas = count($_SESSION['instantes_visita']);

// --- Mensaje según si es la primera visita ---
if ($numero_visitas <= 1) {
    $mensaje_sesion = "Bienvenido! Esta es tu primera visita en la sesión.";
} else {
    $mensaje_sesion = "Has visitado la página " . 
        $numero_visitas . 
        " veces durante esta sesión, en los instantes: " . 
        implode(", ", $_SESSION['instantes_visita']) . ".";
}


/* --- Conversor de monedas --- */
$monedas = [
    "libras" => 1.31,
    "euros"  => 1.09,
    "dolares" => 1
];
$cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : '';
$origen   = isset($_POST['origen']) ? $_POST['origen'] : 'libras';
$destino  = isset($_POST['destino']) ? $_POST['destino'] : 'dolares';


$resultado = '';
$error = '';
$mostrar_resultado = false;


if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['borrar_visitas'])) {
    if (!is_numeric($cantidad) || $cantidad <= 0) {
        $error = "Por favor, introduce una cantidad válida mayor que cero.";
    } elseif (!isset($monedas[$origen]) || !isset($monedas[$destino])) {
        $error = "Selecciona monedas válidas.";
    } else {
        $resultado = number_format($cantidad * $monedas[$origen] / $monedas[$destino], 2);
        $mostrar_resultado = true;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Conversor de monedas</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8f8f8; }
        .container { background: #fff; margin: 50px auto; width: 430px; border-radius:8px; box-shadow:0 3px 12px #0002; padding: 24px; }
        .barra-azul { background:#2196F3; color:#fff; font-weight: bold; padding:10px 14px; margin: -24px -24px 18px -24px; border-radius:8px 8px 0 0;}
        .form-group { margin-bottom:14px; }
        label { font-weight:bold; display:inline-block; width:78px; }
        input[type="text"], select { width:200px; padding:6px 10px; border:1px solid #ccd; border-radius:4px; margin-left:4px;}
        .boton { display:block; width:110px; background: #4CAF50; color:#fff; font-size: 1.1em; font-weight: bold; border: none; border-radius: 4px; padding:8px; margin: 0 auto;}
        .error { color: #b00; background:#fee; padding: 5px; border-radius:4px; margin-bottom: 10px;}
        .visitas-msg {
            background: #e3f2fd;
            color: #1976d2;
            border-left: 5px solid #1976d2;
            padding: 10px 18px;
            margin-bottom: 15px;
            font-size: 1.05em;
            font-weight: 500;
            border-radius: 6px;
            box-shadow: 0 1px 4px #0001;
            display: flex;
            align-items: center;
        }
        .visitas-msg::before {
            content: '\1F4C5'; /* emoji calendario */
            margin-right: 7px;
            font-size: 1.2em;
            opacity: .75;
        }
        .sesion-msg {
            background: #ffe082;
            color: #6d4c41;
            border-left: 5px solid #ffb300;
            padding: 10px 18px;
            margin-bottom: 16px;
            border-radius: 6px;
            font-size: 1.04em;
            font-weight: 500;
            box-shadow: 0 1px 4px #0001;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Mensaje de anterior visita (cookie) -->
        <div class="visitas-msg">
            <?php echo $mensaje_cookie; ?>
        </div>
        <!-- Mensaje de visitas por sesión con instantes -->
        <div class="sesion-msg">
            <?php echo $mensaje_sesion; ?>
        </div>
        <!-- Botón para borrar registro de visitas -->
        <form method="post" style="margin-bottom:15px;">
            <button type="submit" name="borrar_visitas" class="boton" style="background:#d32f2f;">Borrar visitas</button>
        </form>

        <?php if ($mostrar_resultado): ?>
            <div class="barra-azul">
                <?php echo "{$cantidad} {$origen} son {$resultado} {$destino}"; ?>
            </div>
        <?php endif; ?>

        <h2>Conversor de monedas</h2>
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="form-group">
                <label for="cantidad">Cantidad:</label>
                <input type="text" name="cantidad" id="cantidad" value="<?php echo htmlspecialchars($cantidad); ?>">
            </div>
            <div class="form-group">
                <label for="origen">Origen:</label>
                <select name="origen" id="origen">
                    <?php foreach ($monedas as $codigo => $valor): ?>
                        <option value="<?php echo $codigo; ?>" <?php if($codigo == $origen) echo 'selected'; ?>>
                            <?php echo $codigo; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="destino">Destino:</label>
                <select name="destino" id="destino">
                    <?php foreach ($monedas as $codigo => $valor): ?>
                        <option value="<?php echo $codigo; ?>" <?php if($codigo == $destino) echo 'selected'; ?>>
                            <?php echo $codigo; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="boton">Convertir</button>
        </form>
    </div>
</body>
</html>
