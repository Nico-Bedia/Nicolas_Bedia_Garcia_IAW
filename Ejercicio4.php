<!DOCTYPE html> 
<html lange="es"> 
<head> 
    <title>tipos de datos PHP</title> 
</head> 
<body> 
    <?php 
        $temporal = "Nico"; 
        echo   "Tipo: "  . gettype($temporal) . "<br>"; 
        $temporal = 3.14; 

        echo    "Tipo: " . gettype($temporal) . "<br>"; 
        $temporal = false; 

        echo   "Tipo: " . gettype($temporal) . "<br>"; 
        $temporal = 3; 

        echo  "Tipo: "  . gettype($temporal) . "<br>"; 
        $temporal = null; 

        echo  "Tipo: "  . gettype($temporal) . "<br>"; 
    ?>
</body> 
</html> 