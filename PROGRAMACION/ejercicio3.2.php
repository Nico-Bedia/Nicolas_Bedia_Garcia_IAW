<!DOCTYPE html>
<html>
<head>
	<title>Ejercicio 3</title>
	<link rel="stylesheet" media="screen" href="css/estilo.css" >
</head>
<body>


<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="formulario">
	<ul>
	    <li>
	         <h2>Buscador de películas</h2>
	    </li>
	    <li>
			<label for="buscador">Buscador</label>
			<input type="text" name="buscador">
	    </li>
	      
		<li>
			<button class="submit" type="submit" name="buscar">Buscar</button>
		</li>
	</ul>
</form>

<?php
$peliculas = array("El pianista", "El caballero oscuro", "Origen", "Memento", "El lobo de Wall Street", "12 años de esclavitud", "Spotlight", "Amelie", "Malditos bastardos", "No es país para viejos");
function paso_a_minusculas($array)
	{
		$min=strtolower($array);
		return $min;
	}
if(isset($_POST["buscar"]))
{
	echo "<ul>";
	$buscador = paso_a_minusculas($_POST["buscador"]);
	foreach ($peliculas as $peli)
	{
		if(strpos(strtolower($peli), $buscador)!==false)
		{
			echo "<li>$peli</li>";
		}
	}
	echo "</ul>";
}

?>

</body>
</html>