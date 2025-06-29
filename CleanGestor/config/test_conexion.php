<?php
// Conecta con la base de datos MySQL usando PDO
//Alberto Lacarta
include('db.php');  

try {
    $db = Database::connect();
    echo "Conexión exitosa a la base de datos!";
} catch (Exception $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}
?>
