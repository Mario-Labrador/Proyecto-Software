<?php
session_start();
include_once '../DAO/SolicitudDAO.php';
include_once '../DAO/EmpresaDAO.php';  // Asegúrate de incluir el DAO de Empresa
include_once '../DAO/TrabajadorDAO.php'; // Incluir el DAO de Trabajador

if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit();
}

$idSolicitud = $_GET['id'] ?? null;
$accion = $_GET['accion'] ?? '';

if ($idSolicitud && $accion === 'aceptar') {
    $solicitudDAO = new SolicitudDAO();
    $empresaDAO = new EmpresaDAO();
    $trabajadorDAO = new TrabajadorDAO(); // Instanciamos el DAO de Trabajador

    // Obtener la solicitud por ID
    $solicitud = $solicitudDAO->getSolicitudById($idSolicitud);

    if ($solicitud) {
        // Eliminar la solicitud de la base de datos
        $solicitudDAO->eliminarSolicitud($idSolicitud);

        // Asignar el trabajador a la empresa
        $dniTrabajador = $solicitud->getDni();// DNI del trabajador
        $idEmpresa = $solicitud->getIdEmpresa(); // ID de la empresa que acepta la solicitud

        // Llamamos al método de TrabajadorDAO para actualizar el idEmpresa del trabajador
        $trabajadorDAO->actualizarEmpresaTrabajador($dniTrabajador, $idEmpresa);

        // Redirigir a la lista de solicitudes o a donde desees
        header("Location: perfil.php");
        exit();  // Aseguramos que el código no siga ejecutándose después de la redirección
    }
}
?>
