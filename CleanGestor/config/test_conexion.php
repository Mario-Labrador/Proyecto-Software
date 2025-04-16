<?php
// Incluir la clase de conexión a la base de datos
include('db.php');  // Asegúrate de que la ruta sea correcta si los archivos están en carpetas diferentes

// Intentar conectarse a la base de datos
try {
    // Intentar obtener la conexión usando el método estático de la clase Database
    $db = Database::connect();
    echo "Conexión exitosa a la base de datos!";
} catch (Exception $e) {
    // Si hay un error, mostrar el mensaje de error
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}
?>
