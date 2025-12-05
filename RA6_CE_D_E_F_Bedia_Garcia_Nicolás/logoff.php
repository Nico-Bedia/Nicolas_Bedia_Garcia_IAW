<?php

// Cierra la sesión y redirige a index.php

session_start();
session_unset();
session_destroy();
header("Location: index.php");
exit;
?>