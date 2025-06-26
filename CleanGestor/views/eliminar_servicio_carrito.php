<?php
session_start();
require_once("../DAO/ContratoServicioDAO.php");

// Verificar si el usuario está logueado y es cliente
if (!isset($_SESSION['dni']) || $_SESSION['tipo_usuario'] !== 'cliente') {
    header("Location: login.php?mensaje=Debes iniciar sesión como cliente para realizar esta acción.");
    exit();
}

// Validar parámetros
if (!isset($_GET['idContrato']) || !isset($_GET['idServicio'])) {
    header("Location: ver_carrito.php?error=Parámetros inválidos");
    exit();
}

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "gestor");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener los datos del contrato y servicio
$idContrato = intval($_GET['idContrato']);
$idServicio = intval($_GET['idServicio']);

// Crear una instancia del DAO
$contratoServicioDAO = new ContratoServicioDAO($conexion);

// Eliminar el servicio del contrato
if ($contratoServicioDAO->eliminarServicioDeContrato($idContrato, $idServicio)) {
    header("Location: ver_carrito.php?idContrato=$idContrato&mensaje=Servicio eliminado del carrito.");
    exit();
} else {
    echo "Error al eliminar el servicio del carrito.";
}

$conexion->close();
?>