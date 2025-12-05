<?php
session_start(); 
// Página para listar, insertar y borrar aplicaciones.

include_once 'conexion.php';
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

// Insertar aplicación
if (isset($_POST['insertar'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    insertarAplicacion($nombre, $descripcion);
}

// Borrar aplicación
if (isset($_POST['borrar'])) {
    $nombre = $_POST['nombre_borrar'];
    borrarAplicacion($nombre);
}

$apps = getAplicaciones();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Aplicaciones</title>

</head>
<body>
    <h1>Listado de aplicaciones</h1>

        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
        </tr>
        <?php foreach($apps as $app): ?>
        <tr>
            <td><?php echo $app['nombre_aplicacion']; ?></td>
            <td><?php echo $app['descripcion']; ?></td>
            <td>
                <form method="post" style="display:inline">
                    <input type="hidden" name="nombre_borrar" value="<?php echo $app['nombre_aplicacion']; ?>">
                    <button type="submit" name="borrar">Borrar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Insertar nueva aplicación</h2>
    <form method="post">
        <label>Nombre:</label>
        <input type="text" name="nombre" required>
        <br>
        <label>Descripción:</label>
        <input type="text" name="descripcion" required>
        <br>
        <button type="submit" name="insertar">Insertar</button>
    </form>

    <p><a href="principal.php">Volver al principal</a></p>
</body>
</html>
