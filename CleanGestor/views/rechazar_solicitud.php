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

    // Eliminar la solicitud de la base de datos
    $solicitudDAO->eliminarSolicitud($idSolicitud);

    // Redirigir a la lista de solicitudes
    header("Location: perfil.php");
    exit();  // Aseguramos que el código no siga ejecutándose después de la redirección
}
?>
