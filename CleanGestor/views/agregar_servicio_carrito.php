<?php
session_start();
require_once("../DAO/ContratoServicioDAO.php");
require_once("../VO/ContratoServicioVO.php");

// Verificar si el usuario está logueado y es cliente
if (!isset($_SESSION['dni']) || $_SESSION['tipo_usuario'] !== 'cliente') {
    header("Location: login.php?mensaje=Debes iniciar sesión como cliente para contratar un servicio.");
    exit();
}

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "gestor");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener los datos del contrato y servicio
$idContrato = $_GET['idContrato'];
$idServicio = $_GET['idServicio'];

// Crear una instancia del DAO
$contratoServicioDAO = new ContratoServicioDAO($conexion);

// Verificar si el servicio ya está en el contrato
if ($contratoServicioDAO->servicioYaEnContrato($idContrato, $idServicio)) {
    echo "<script>
        alert('El servicio ya está en el carrito.');
        window.location.href = 'ver_carrito.php?idContrato=$idContrato';
    </script>";
    exit();
}

// Crear el VO y agregar el servicio al contrato
$contratoServicio = new ContratoServicioVO($idContrato, $idServicio);
if ($contratoServicioDAO->agregarServicioAContrato($contratoServicio)) {
    header("Location: ver_carrito.php?idContrato=$idContrato");
} else {
    echo "Error al añadir el servicio al contrato.";
}

$conexion->close();
?>