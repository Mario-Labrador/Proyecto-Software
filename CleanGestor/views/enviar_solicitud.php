<?php
session_start();
include_once '../config/db.php';
include_once '../VO/SolicitudVO.php';
include_once '../DAO/SolicitudDAO.php';

// Asegurarse de que hay sesión y datos POST
if (!isset($_SESSION['dni']) || !isset($_POST['idEmpresa'])) {
  header("Location: login.php");
  exit();
}

$dni = $_SESSION['dni'];
$idEmpresa = $_POST['idEmpresa'];
$fecha = date('Y-m-d');
$estado = 'pendiente';

// Crear el objeto SolicitudVO
$nuevaSolicitud = new SolicitudVO(
  null,           // ID autoincremental
  $dni,
  $idEmpresa,
  $fecha,
  $estado
);

// Insertar la solicitud
$solicitudDAO = new SolicitudDAO();
$solicitudDAO->enviarSolicitud($nuevaSolicitud);

// Redirigir de vuelta al perfil de la empresa
header("Location: perfilEmpresa.php?id=" . urlencode($idEmpresa));
exit();
?>
