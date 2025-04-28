<!-- filepath: c:\xampp\htdocs\CleanGestor\views\procesar_editar_servicio.php -->
<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['dni']) || $_SESSION['tipo_usuario'] !== 'trabajador' || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "gestor");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener los datos del formulario
$idServicio = $_POST['idServicio'];
$nombreServicio = $_POST['nombreServicio'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$horas = $_POST['horas'];
$sueldo = $_POST['sueldo'];

// Actualizar los datos del servicio
$sql = "UPDATE servicio SET nombreServicio = ?, descripcion = ?, precio = ?, horas = ?, sueldo = ? WHERE idServicio = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssdddi", $nombreServicio, $descripcion, $precio, $horas, $sueldo, $idServicio);

if ($stmt->execute()) {
    header("Location: misServicios.php?mensaje=Servicio actualizado correctamente");
} else {
    header("Location: editar_servicio.php?id=$idServicio&error=No se pudo actualizar el servicio");
}

$stmt->close();
$conexion->close();
?>