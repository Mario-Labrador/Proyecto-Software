<?php
session_start();
require_once("../DAO/ContratoDAO.php");

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

// Obtener el DNI del cliente logueado
$dni = $_SESSION['dni'];
$idServicio = $_GET['id'] ?? null;

if (!$idServicio) {
    die("ID de servicio no especificado.");
}

// Crear una instancia de ContratoDAO
$contratoDAO = new ContratoDAO($conexion);

// Verificar si el cliente tiene un contrato abierto
$contratoAbierto = $contratoDAO->obtenerContratoAbierto($dni);

if ($contratoAbierto) {
    // Si tiene un contrato abierto, añadir el servicio al contrato
    header("Location: agregar_servicio_carrito.php?idContrato=" . $contratoAbierto['idContrato'] . "&idServicio=$idServicio");
} else {
    // Si no tiene contrato, redirigir a la página para crear un contrato
    header("Location: crear_contrato.php");
}

$conexion->close();
?>