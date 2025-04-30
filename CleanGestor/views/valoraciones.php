<?php
session_start();
require_once("../DAO/ContratoServicioDAO.php");
require_once("../DAO/ValoracionDAO.php");

// Verificar si el usuario está logueado y es cliente
if (!isset($_SESSION['dni']) || $_SESSION['tipo_usuario'] !== 'cliente') {
    die("Debes iniciar sesión como cliente para acceder a esta página.");
}

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "gestor");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener los contratos y servicios del cliente
$dniCliente = $_SESSION['dni'];
$contratoServicioDAO = new ContratoServicioDAO($conexion);
$valoracionDAO = new ValoracionDAO($conexion);

$data = $contratoServicioDAO->obtenerContratosConServicios($dniCliente);
$contratos = $data['contratos'];
$serviciosPorContrato = $data['servicios'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Basic -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valoraciones - CLEAN GESTOR</title>
    <link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif" />
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link href="../assets/css/responsive.css" rel="stylesheet">

</head>
<body class="sub_page">
    <div class="hero_area">
        <!-- Header section -->
        <header class="header_section">
            <div class="container-fluid">
                <?php include_once("navbar.php"); ?>
            </div>
        </header>
    </div>

    <div class="container mt-3">
        <h1 class="page-title">Valoraciones</h1>
        <p class="page-subtitle">Valora las experiencias que has tenido con cada servicio</p>

        <?php if (count($contratos) > 0): ?>
            <?php foreach ($contratos as $contrato): ?>
                <div class="card">
                    <div class="card-header">
                        Contrato #<?= $contrato['idContrato'] ?>
                        <span class="float-end"><?= htmlspecialchars($contrato['fecha']) ?></span>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-1 text-center">Servicios:</h6>
                        <div class="ul-valoraciones">
                        <?php foreach ($serviciosPorContrato[$contrato['idContrato']] as $servicio): ?>
                            <div class="li-valoraciones">
                                <div>
                                    <?= htmlspecialchars($servicio['nombreServicio']) ?> - 
                                    <?= number_format($servicio['precio'], 2, ',', '.') ?> €
                                </div>
                                <?php
                                // Obtener la nota de la valoración
                                $nota = $valoracionDAO->obtenerNotaValoracion($contrato['idContrato'], $servicio['idServicio']);
                                ?>
                                <?php if ($nota !== null): ?>
                                    <div class="star-rating">
                                        <?php for ($i = 5; $i >= 1; $i--): ?>
                                            <span class="<?= $i <= $nota ? 'text-warning' : 'text-muted' ?>">★</span>
                                        <?php endfor; ?>
                                    </div>
                                <?php else: ?>
                                    <a href="valorar_servicio.php?idContrato=<?= urlencode($contrato['idContrato']) ?>&idServicio=<?= urlencode($servicio['idServicio']) ?>" 
                                       class="btn btn-primary btn-sm btn-valorar">
                                        Valorar
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-muted">No tienes servicios contratados para valorar.</p>
        <?php endif; ?>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conexion->close();
?>