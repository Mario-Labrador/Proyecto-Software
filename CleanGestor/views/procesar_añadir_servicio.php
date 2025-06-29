<!-- filepath: c:\xampp\htdocs\CleanGestor\views\procesar_añadir_servicio.php -->
<?php
//Mario Recio
// procesar_añadir_servicio.php
require_once("../VO/ServicioVO.php");
require_once("../DAO/ServicioDAO.php");

// Verificar si el usuario es administrador
session_start();
if (!isset($_SESSION['dni']) || $_SESSION['tipo_usuario'] !== 'trabajador' || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php");
    exit();
}

$idEmpresa = $_SESSION['idEmpresa'] ?? null;
if (!$idEmpresa) {
    die("Error: No se pudo determinar la empresa asociada al administrador.");
}

$conexion = new mysqli("localhost", "root", "", "gestor");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener datos del formulario
$nombreServicio = $_POST['nombreServicio'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$horas = $_POST['horas'];
$sueldo = $_POST['sueldo'];

// Manejar la subida de la imagen
$fotoServicio = null;
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $directorioSubida = "../assets/uploads/";
    $nombreArchivo = uniqid() . "_" . basename($_FILES['imagen']['name']);
    $rutaCompleta = $directorioSubida . $nombreArchivo;

    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaCompleta)) {
        $fotoServicio = $rutaCompleta;
    }
}
else {
    $fotoServicio = "../assets/images/default_service.png";
}

// Crear un objeto ServicioVO
$servicio = new ServicioVO($nombreServicio, $descripcion, $precio, $horas, $sueldo, $idEmpresa, $fotoServicio);

// Crear un objeto ServicioDAO y guardar el servicio
$servicioDAO = new ServicioDAO($conexion);
if ($servicioDAO->insertarServicio($servicio)) {
    header("Location: misServicios.php?mensaje=Servicio añadido correctamente");
} else {
    header("Location: añadir_servicio.php?error=No se pudo añadir el servicio");
}

$conexion->close();
?>