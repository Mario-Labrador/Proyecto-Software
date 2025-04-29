<?php
session_start();

// Verificar si el usuario está logueado y es cliente
if (!isset($_SESSION['dni']) || $_SESSION['tipo_usuario'] !== 'cliente') {
    header("Location: login.php?mensaje=Debes iniciar sesión como cliente para crear un contrato.");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Contrato</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Crear Contrato</h1>
        <h4 class="text-center mb-4">Antes de contratar un servicio, configura donde y cuando quieres que se lleve a cabo</h4>
        <form action="procesar_crear_contrato.php" method="POST">
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required min="<?= date('Y-m-d') ?>">
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Crear Contrato</button>
                <a href="detalle_servicio.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>