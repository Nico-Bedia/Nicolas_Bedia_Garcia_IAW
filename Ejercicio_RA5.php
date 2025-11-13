<?php
$peliculas = [
    "El lobo de Wall Street",
    "12 años de esclavitud",
    "Origen",
    "El caballero Oscuro",
    "El pianista",
    "Esclavitud",
    "malditos_bastardos",
    "Ni es pais para viejos",
    "Sportlihgt",

];
$imagenes = [
    "El lobo de Wall Street" => "FOTOS/el_lobo.jpg",
    "12 años de esclavitud"  => "FOTOS/esclavitud.jpg",
    "Origen"                 => "FOTOS/origen.jpg",
    "El caballero Oscuro"    => "FOTOS/el_caballero_oscuro.jpg",
    "El pianista"            => "FOTOS/el_pianista.jpg",
    "Memento"                => "FOTOS/memento.jpg",
    "Malditos Bastardos"     => "FOTOS/malditos_bastardos.jpg",
    "No es pais para Viejos" => "FOTOS/no_es_para_viejos.jpg",
    "spotlight"              => "FOTOS/spotlight.jpg",


];
$busqueda = isset($_POST['busqueda']) ? $_POST['busqueda'] : '';
$resultados = [];
if ($busqueda) {
    foreach ($peliculas as $peli) {
        if (stripos($peli, $busqueda) !== false) {
            $resultados[] = $peli;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Buscador de películas</title>
    <style>
        body {font: 14px/21px "Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif;}
        .formulario ul { width:750px; list-style-type:none; margin:0px; padding:0px;}
        .formulario li{ padding:12px; border-bottom:1px solid #eee; position:relative;}
        .formulario li:first-child, .formulario li:last-child { border-bottom:1px solid #777;}
        .formulario h2 { margin:0; display: inline; }
        .formulario label { width:150px; margin-top: 3px; display:inline-block; float:left; padding:3px;}
        .formulario input { height:20px; width:220px; padding:5px 8px;}
        .formulario button {margin-left:156px;}
        .aviso{ width:710px; padding: 20px; background-color: #2196F3; color: white; margin-bottom: 10px; }
        .tabla { border: 1px solid #000; border-collapse: collapse; width: 650px; margin: 20px 0 0 30px;}
        .tabla td { font-size: 15px; color: #424242; line-height: 1.4; padding: 12px 16px; text-align: left; border-bottom: 1px solid #DDD; }
        .tabla tr:nth-child(even) { background-color: #eaf8e6; }
        .tabla tr:nth-child(odd)  { background-color: #fff; }
        .tabla img {width:140px; border-radius:4px; box-shadow:0 1px 4px #0002;}
    </style>
</head>
<body>
<div class="formulario">
    <form method="post" action="">
        <ul>
            <li>
                <h2>Buscador de películas</h2>
            </li>
            <li>
                <label for="busqueda">Buscador</label>
                <input type="text" name="busqueda" id="busqueda" value="<?php echo ($busqueda); ?>">
                <button type="submit" class="submit">Buscar</button>
            </li>
        </ul>
    </form>

<?php if ($busqueda !== ''): ?>
    <div class="aviso">
        <?php echo ($resultados).' película(s) encontrada para la búsqueda "' . ($busqueda) . '"'; ?>
    </div>
<?php endif; ?>

<?php if(($resultados) > 0): ?>
    <table class="tabla">
        <?php foreach($resultados as $peli): ?>
        <tr>
            <td>
                <img src="<?php echo ($imagenes[$peli]); ?>" alt="<?php echo ($peli); ?>">
            </td>
            <td>
                <?php echo ($peli); ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
</div>
</body>
</html>
