<?php
session_start();
require_once("../DAO/ContratoDAO.php");

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "gestor");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Crear instancia del DAO
$contratoDAO = new ContratoDAO($conexion);

// Obtener los contratos y servicios del cliente
$dni = $_SESSION['dni'];
$data = $contratoDAO->obtenerContratosConServicios($dni);
$contratos = $data['contratos'];
$contratoServicios = $data['servicios'];

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Contratos</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

</head>
<body class="sub_page">
    <div class="hero_area">
        <header class="header_section">
            <div class="container-fluid">
                <?php include_once("navbar.php"); ?>
            </div>
        </header>
    </div>
        <h1 class="text-center mb-4">Historial de Contratos</h1>

        <?php if (count($contratos) > 0): ?>
            <?php foreach ($contratos as $contrato): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>Contrato #<?= $contrato['idContrato'] ?></strong>
                        <span class="float-end"><?= htmlspecialchars($contrato['fecha']) ?></span>
                    </div>
                    <div class="card-body">
                        <p><strong>Direccion:</strong> <?= htmlspecialchars($contrato['lugar']) ?></p>
                        <h5>Servicios:</h5>
                        <ul>
                            <?php foreach ($contratoServicios[$contrato['idContrato']] as $servicio): ?>
                                <li>
                                    <?= htmlspecialchars($servicio['nombreServicio']) ?> - 
                                    <?= number_format($servicio['precio'], 2, ',', '.') ?> €
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </header>
        </div>

        <div class="container py-5">
            <a href="javascript:history.back()" class="back-link mt-4 d-inline-block">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <h1 class="text-center mb-5">Historial de Servicios</h1>
            <?php if (count($contratos) > 0): ?>
                <div class="row justify-content-center">
                    <?php foreach ($contratos as $contrato): ?>
                        <div class="col-md-8">
                            <div class="service-history-card card shadow mb-4">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-file-contract me-2"></i>
                                        <strong>Contrato #<?= $contrato['idContrato'] ?></strong>
                                    </div>
                                    <span>
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        <?= date("d/m/Y", strtotime($contrato['fecha'])) ?>
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <i class="fas fa-map-marker-alt me-2 text-secondary"></i>
                                        <strong>Dirección:</strong> <?= htmlspecialchars($contrato['lugar']) ?>
                                    </div>
                                    <h5 class="mt-3 mb-3">
                                        <i class="fas fa-concierge-bell me-2"></i> Servicios contratados
                                    </h5>
                                    <ul class="list-group list-group-flush mb-3">
                                        <?php foreach ($contratoServicios[$contrato['idContrato']] as $servicio): ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <span>
                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                    <?= htmlspecialchars($servicio['nombreServicio']) ?>
                                                </span>
                                                <span class="badge bg-success rounded-pill">
                                                    <?= number_format($servicio['precio'], 2, ',', '.') ?> €
                                                </span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center text-muted mt-5">
                    <i class="fas fa-history fa-3x mb-3"></i>
                    <p>No tienes contratos en tu historial.</p>
                </div>
            <?php endif; ?>
        </div>
    </body>
</html>