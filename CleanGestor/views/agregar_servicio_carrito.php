<?php
session_start();
require_once("../DAO/ContratoDAO.php");
require_once("../DAO/ContratoServicioDAO.php");
require_once("../VO/ContratoServicioVO.php");

if (!isset($_SESSION['dni']) || $_SESSION['tipo_usuario'] !== 'cliente') {
    header("Location: login.php?mensaje=Debes iniciar sesión como cliente para contratar servicios.");
    exit();
}

$idServicio = $_GET['idServicio'] ?? null;
if (!$idServicio) {
    die("Servicio no válido.");
}

$conexion = new mysqli("localhost", "root", "", "gestor");
$contratoDAO = new ContratoDAO($conexion);
$contratoServicioDAO = new ContratoServicioDAO($conexion);

$contratoAbierto = $contratoDAO->obtenerContratoAbierto($_SESSION['dni']);

if (!$contratoAbierto) {
    // Si no hay contrato abierto, créalo vacío
    $idContrato = $contratoDAO->crearContratoVacio($_SESSION['dni']);
} else {
    $idContrato = $contratoAbierto['idContrato'];
}

// Añadir el servicio al contrato solo si no está ya
if (!$contratoServicioDAO->servicioYaEnContrato($idContrato, $idServicio)) {
    $contratoServicioVO = new ContratoServicioVO($idContrato, $idServicio);
    $contratoServicioDAO->agregarServicioAContrato($contratoServicioVO);
}

// Redirigir al carrito
header("Location: ver_carrito.php?idContrato=$idContrato");
exit();
?>