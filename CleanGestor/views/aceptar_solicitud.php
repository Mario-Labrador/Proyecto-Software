<?php
session_start();
include_once '../DAO/SolicitudDAO.php';
include_once '../DAO/EmpresaDAO.php';

if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit();
}

$idSolicitud = $_GET['id'] ?? null;
$accion = $_GET['accion'] ?? '';

if ($idSolicitud && $accion === 'aceptar') {
    $solicitudDAO = new SolicitudDAO();
    $empresaDAO = new EmpresaDAO();

    // Obtener la solicitud por ID
    $solicitud = $solicitudDAO->getSolicitudById($idSolicitud);

    if ($solicitud) {
        // Cambiar el estado de la solicitud a "aceptada"
        $solicitudDAO->actualizarEstado($idSolicitud, 'aceptada');

        // Asignar la empresa al trabajador (si se necesita hacer alguna acción adicional en este sentido)
        // Este paso dependerá de la lógica de negocio que tengas (por ejemplo, si se requiere agregar el trabajador a la empresa)

        // Redirigir a la lista de solicitudes
        header("Location: perfil.php");
        exit();  // Importante para evitar que el código siga ejecutándose
    }
}
?>
