<?php
//Mario Recio 
// cerrar_contrato.php
session_start();
require_once("../DAO/ContratoDAO.php");
$conexion = new mysqli("localhost", "root", "", "gestor");
$contratoDAO = new ContratoDAO($conexion);

$idContrato = $_POST['idContrato'] ?? null;
if ($idContrato) {
    $contratoDAO->finalizarContrato($idContrato);
}

// Limpia la variable de sesión si la usas
unset($_SESSION['idContrato']);

header("Location: servicios.php");
exit;
?>