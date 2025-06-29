<?php
//Mario Recio
// crear_contrato.php
session_start();
require_once("../DAO/ContratoDAO.php");
$conexion = new mysqli("localhost", "root", "", "gestor");
$contratoDAO = new ContratoDAO($conexion);

$contratoAbierto = $contratoDAO->obtenerContratoAbierto($_SESSION['dni']);
$idContrato = $contratoAbierto['idContrato'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lugar = $_POST['lugar'];
    $fecha = $_POST['fecha'];
    $contratoDAO->actualizarLugarYFecha($idContrato, $lugar, $fecha);

    // Calcula el total del contrato y guárdalo en sesión para el pago
    require_once("../DAO/ContratoServicioDAO.php");
    $contratoServicioDAO = new ContratoServicioDAO($conexion);
    $servicios = $contratoServicioDAO->obtenerServiciosPorContrato($idContrato);
    $total = 0;
    foreach ($servicios as $servicio) {
        $total += $servicio['precio'];
    }
    $_SESSION['total_pago'] = $total;

    header("Location: pago.php?idContrato=$idContrato");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar y Pagar</title>
    <link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif" />
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Finalizar y Pagar</h1>
        <h4 class="text-center mb-4">Antes de pagar, indica dónde y cuándo quieres el servicio</h4>
        <form action="crear_contrato.php" method="POST">
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required min="<?= date('Y-m-d') ?>">
            </div>
            <div class="mb-3">
                <label for="lugar" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="lugar" name="lugar" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Finalizar y Pagar</button>
                <a href="ver_carrito.php?idContrato=<?= $idContrato ?>" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>