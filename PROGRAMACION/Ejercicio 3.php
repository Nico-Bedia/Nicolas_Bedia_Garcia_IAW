<!DOCTYPE html> 
<html lang="es"> 
<head> 
    <title>variables_informacion</title> 
</head> 
<body> 
    <?php 
        $nombre = "Nico"; 
        echo "variable_informacion\"nombre\": "; 
        var_dump($nombre); 
        echo "<br>"; 
        echo " variable_de_contenido: $nombre<br>"; 
        $nombre = null; 
        echo "valor nulo"; 
        var_dump($nombre); 
    ?> 
</body> 
</html> 