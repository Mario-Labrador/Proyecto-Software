<?php
session_start();
require_once("../DAO/ContratoServicioDAO.php");
require_once("../DAO/ContratoDAO.php"); // Incluir el DAO de Contrato
require_once("../config/db.php");

// Verificar si el usuario está logueado y es cliente
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
    <title>Carrito</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Carrito</h1>
        <div class="row">
            <!-- Lista de servicios -->
            <div class="col-md-8">
                <?php if ($servicios->num_rows > 0): ?>
                    <?php while ($row = $servicios->fetch_assoc()): ?>
                        <?php
                        $totalPrecio += $row['precio'];
                        $totalServicios++;
                        ?>
                        <div class="cart-item d-flex align-items-center p-3 mb-3 rounded">
                            <div class="me-4">
                                <?php
                                $fotoServicio = !empty($row['fotoServicio']) 
                                    ? htmlspecialchars($row['fotoServicio']) 
                                    : '../assets/images/default_service.png';
                                ?>
                                <img src="<?= $fotoServicio ?>" 
                                     alt="<?= htmlspecialchars($row['nombreServicio']) ?>" 
                                     class="img-thumbnail cart-image">
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-2"><?= htmlspecialchars($row['nombreServicio']) ?></h5>
                                <p class="mb-0 text-muted"><?= number_format($row['precio'], 2, ',', '.') ?> €</p>
                            </div>
                            <div>
                                <a href="eliminar_servicio_carrito.php?idContrato=<?= $idContrato ?>&idServicio=<?= $row['idServicio'] ?>" 
                                   class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center text-muted">Todavía no has añadido ningún servicio.</p>
                <?php endif; ?>
            </div>

            <!-- Resumen del carrito -->
            <div class="col-md-4">
                <div class="cart-summary">
                    <h4>Resumen del Carrito</h4>
                    <p><strong>Total de Servicios:</strong> <?= $totalServicios ?></p>
                    <p><strong>Precio Total:</strong> <?= number_format($totalPrecio, 2, ',', '.') ?> €</p>
                    <div class="d-grid gap-2">
                        <?php
                        // Guardar el total en la sesión (solo esta línea añadida)
                        $_SESSION['total_pago'] = $totalPrecio;
                        ?>
                        <?php if ($totalServicios > 0): ?>
                            <!-- Formulario para finalizar el contrato -->
                            <form method="POST" action="">
                                <button type="submit" name="finalizar_contrato" class="btn btn-success">
                                    <i class="fas fa-check"></i> Finalizar Contrato
                                </button>
                            </form>
                        <?php else: ?>
                            <button class="btn btn-success" disabled>
                                <i class="fas fa-check"></i> Añade algún servicio al carrito
                            </button>
                        <?php endif; ?>
                        <a href="servicios.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Seguir Contratando
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>