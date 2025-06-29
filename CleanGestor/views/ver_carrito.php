<?php
// ver_carrito.php
// Mario Recio
session_start();
require_once("../DAO/ContratoServicioDAO.php");
require_once("../DAO/ContratoDAO.php");
require_once("../config/db.php");

if (!isset($_SESSION['dni']) || $_SESSION['tipo_usuario'] !== 'cliente') {
    header("Location: login.php?mensaje=Debes iniciar sesión como cliente para ver el carrito.");
    exit();
}

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "gestor");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener los servicios del contrato
$idContrato = $_GET['idContrato'];
$contratoServicioDAO = new ContratoServicioDAO($conexion);
$servicios = $contratoServicioDAO->obtenerServiciosPorContrato($idContrato);

// Variables para calcular el total
$totalPrecio = 0;
$totalServicios = 0;

// Verificar si se ha enviado el formulario para finalizar el contrato
if (isset($_POST['finalizar_contrato'])) {
    // Crear una instancia del DAO de contrato
    $contratoDAO = new ContratoDAO($conexion);

    // Crear un objeto ContratoVO
    // En este caso, pasamos el idContrato (ya lo tenemos en la variable) y el estado "finalizado"
    $contratoVO = new ContratoVO(null, null, null, 'finalizado');  // Pasamos null para los otros campos que no necesitamos
    $contratoVO->setIdContrato($idContrato);  // Establecer el id del contrato
    

    // Intentar cerrar el contrato pasando el objeto ContratoVO
    if ($contratoDAO->cerrarContrato($contratoVO)) {
        // Guardar el total en la sesión

        // Redirigir a la página de pago
        header("Location: pago2.php?idContrato=" . $idContrato);
        exit();
    } else {
        echo "Hubo un error al cerrar el contrato.";
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif" />
    <title>Carrito | CLEAN GESTOR</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0" style="max-width:1200px; margin:0 auto;">
                    <div class="card-body p-4">
                        <div class="row">
                            <!-- Encabezado -->
                            <div class="col-12 mb-4 text-center">
                                <h2 class="fw-bold mb-0">
                                    <i class="fas fa-shopping-cart text-success me-2"></i>
                                    Tu Carrito de Servicios
                                </h2>
                                <p class="text-muted mb-0">Revisa y gestiona los servicios seleccionados</p>
                            </div>
                            <!-- Lista de servicios -->
                            <div class="col-md-8 border-end">
                                <?php if ($servicios->num_rows > 0): ?>
                                    <?php while ($row = $servicios->fetch_assoc()): ?>
                                        <?php
                                        $totalPrecio += $row['precio'];
                                        $_SESSION['total_pago'] = $totalPrecio;
                                        $totalServicios++;
                                        $fotoServicio = !empty($row['fotoServicio']) 
                                            ? htmlspecialchars($row['fotoServicio']) 
                                            : '../assets/images/default_service.png';
                                        ?>
                                        <div class="d-flex align-items-center mb-4 p-3 bg-light rounded shadow-sm">
                                            <img src="<?= $fotoServicio ?>" alt="<?= htmlspecialchars($row['nombreServicio']) ?>" 
                                                class="img-thumbnail me-4" style="width: 80px; height: 80px; object-fit:cover;">
                                            <div class="flex-grow-1">
                                                <h5 class="ml-3"><?= htmlspecialchars($row['nombreServicio']) ?></h5>
                                                <span class="badge bg-primary text-white ml-3"><?= number_format($row['precio'], 2, ',', '.') ?> €</span>
                                            </div>
                                            <a href="eliminar_servicio_carrito.php?idContrato=<?= $idContrato ?>&idServicio=<?= $row['idServicio'] ?>" 
                                            class="btn btn-outline-danger btn-sm ms-4" title="Eliminar servicio">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <div class="alert alert-info text-center">
                                        <i class="fas fa-info-circle"></i> Todavía no has añadido ningún servicio.
                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- Resumen del carrito -->
                            <div class="col-md-4 d-flex flex-column">
                                <div class="p-4 bg-white rounded shadow-sm h-100 d-flex flex-column">
                                    <h4 class="fw-bold mb-3">Resumen</h4>
                                    <ul class="list-group mb-3">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Total de Servicios
                                        <span class="badge bg-primary text-white rounded-pill"><?= $totalServicios ?></span>
                                    </li>
                                        <strong class="list-group-item d-flex justify-content-between align-items-center">
                                            Precio Total
                                            <span class="fw-bold text-success"><?= number_format($totalPrecio, 2, ',', '.') ?> €</span>
                                        </strong>
                                    </ul>
                                    <div class="mt-auto">
                                        <?php if ($totalServicios > 0): ?>
                                            <a href="crear_contrato.php?idContrato=<?= $idContrato ?>" class="btn btn-success btn-lg w-100 mb-3">
                                                <i class="fas fa-check"></i> Finalizar Contrato
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-success btn-lg w-100 mb-3" disabled>
                                                <i class="fas fa-check"></i> Añade algún servicio al carrito
                                            </button>
                                        <?php endif; ?>
                                        <a href="servicios.php" class="btn btn-outline-secondary btn-lg w-100">
                                            <i class="fas fa-arrow-left"></i> Seguir Contratando
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
