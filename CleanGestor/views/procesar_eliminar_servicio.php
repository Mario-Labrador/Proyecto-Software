<!-- filepath: c:\xampp\htdocs\CleanGestor\views\procesar_eliminar_servicio.php -->
<?php
// procesar_eliminar_servicio.php
// Mario Recio  
if (session_status() === PHP_SESSION_NONE) session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['dni']) || $_SESSION['tipo_usuario'] !== 'trabajador' || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php"); // Redirigir al login si no es administrador
    exit();
}

// Verificar si se ha recibido el idServicio
if (!isset($_GET['idServicio'])) {
    header("Location: eliminar_servicio.php?error=No se ha especificado el servicio a eliminar");
    exit();
}

$idServicio = intval($_GET['idServicio']);

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "gestor");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Eliminar el servicio de la base de datos
$sql = "DELETE FROM servicio WHERE idServicio = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idServicio);

if ($stmt->execute()) {
    // Redirigir con un mensaje de éxito
    header("Location: eliminar_servicio.php?mensaje=Servicio eliminado correctamente&finalizado=true");
} else {
    // Redirigir con un mensaje de error
    header("Location: eliminar_servicio.php?error=No se pudo eliminar el servicio");
}

// Cerrar la conexión
$stmt->close();
$conexion->close();
?>