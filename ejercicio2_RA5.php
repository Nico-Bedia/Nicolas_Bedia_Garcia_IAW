<?php
// Zona horaria
date_default_timezone_set('Europe/Madrid');

// Obtener fecha y hora actual
$ahora = date('d/m/Y H:i:s');

// Verificar si existe cookie de visita anterior
if (isset($_COOKIE['ultima_visita'])) {
    $mensaje = "Bienvenido de nuevo! Tu última visita fue el " . $_COOKIE['ultima_visita'] . ".";
} else {
    $mensaje = "Bienvenido! Esta es tu primera visita.";
}

// Actualizar cookie con el instante actual (expira en 1 año)
setcookie('ultima_visita', $ahora, time() + (365 * 24 * 60 * 60));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Visitas con Cookies</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
        }
        .mensaje {
            background: #e3f2fd;
            color: #1976d2;
            padding: 20px;
            border-radius: 5px;
            border-left: 5px solid #1976d2;
            font-size: 1.1em;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Control de Visitas</h1>
        <div class="mensaje">
            <?php echo $mensaje; ?>
        </div>
        <p style="margin-top: 20px; color: #666;">
            <small>Fecha y hora actual: <?php echo $ahora; ?></small>
        </p>
    </div>
        <div class="container">
        <!-- Mensaje de anterior visita (cookie de primer acceso) -->
        <div class="visitas-msg">
            <?php echo $mensaje_cookie; ?>
        </div>
        <!-- Mensaje de visitas por sesión repetido -->
        <div class="sesion-msg">
            <?php echo  ?>
        </div>
        <!-- Boton para borrar registro de  las visitas -->
        <form method="post" style="margin-bottom:15px;">
            <button type="submit" name="borrar_visitas" class="boton" style="background:#d32f2f;">Borrar visitas</button>
        </form>
    
</body>
</html>
