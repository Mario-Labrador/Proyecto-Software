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
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-muted">No tienes contratos en tu historial.</p>
        <?php endif; ?>
</body>
</html>