<?php
// procesar_despido.php
// Mario Labrador
include_once '../config/db.php';
include_once '../DAO/TrabajadorDAO.php';

session_start();

// Verifica permisos de administrador
if (!isset($_SESSION['dni']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php");
    exit();
}

// Verifica que el DNI está presente y no está vacío
if (!isset($_GET['dni']) || empty($_GET['dni'])) {
    die("Error: DNI no especificado.");
}

$dni = $_GET['dni'];

// Instancia el DAO
$trabajadorDAO = new TrabajadorDAO();

// Verifica que el trabajador existe
if (!$trabajadorDAO->esTrabajador($dni)) {
    die("Error: El trabajador no existe.");
}

// Quita la empresa al trabajador (despido)
$trabajadorDAO->actualizarEmpresaTrabajador($dni, null);

// Redirige con mensaje de éxito
header("Location: misTrabajadores.php?mensaje=Trabajador despedido con éxito.");
exit();
?>
