<?php
session_start();
include_once '../DAO/SolicitudDAO.php';

if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit();
}

$idSolicitud = $_GET['id'] ?? null;

if ($idSolicitud) {
    $solicitudDAO = new SolicitudDAO();

    // Cambiar el estado de la solicitud a "rechazada"
    $solicitudDAO->actualizarEstado($idSolicitud, 'rechazada');

    // Redirigir a la lista de solicitudes
    header("Location: perfil.php");
    exit();  // Aseguramos que el código no siga ejecutándose después de la redirección
}
?>
