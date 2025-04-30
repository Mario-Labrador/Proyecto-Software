<?php
session_start();
require_once("../DAO/ValoracionDAO.php");
require_once("../VO/ValoracionVO.php");

// Verificar si el usuario está logueado y es cliente
if (!isset($_SESSION['dni']) || $_SESSION['tipo_usuario'] !== 'cliente') {
    die("Debes iniciar sesión como cliente para valorar un servicio.");
}

// Validar parámetros
if (!isset($_GET['idContrato']) || !isset($_GET['idServicio'])) {
    die("Parámetros inválidos.");
}

$idContrato = intval($_GET['idContrato']);
$idServicio = intval($_GET['idServicio']);

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nota = intval($_POST['nota']);
    $descripcion = $_POST['descripcion'];

    $conexion = new mysqli("localhost", "root", "", "gestor");
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $valoracionDAO = new ValoracionDAO($conexion);
    $valoracion = new ValoracionVO();
    $valoracion->setNota($nota);
    $valoracion->setDescripcion($descripcion);
    $valoracion->setIdContrato($idContrato);
    $valoracion->setIdServicio($idServicio);

    try {
        if ($valoracionDAO->agregarValoracion($valoracion)) {
            // Redirigir a la página de valoraciones
            header("Location: valoraciones.php");
            exit;
        }
    } catch (Exception $e) {
        echo "<div class='alert alert-danger text-center'>Error: " . $e->getMessage() . "</div>";
    }

    $conexion->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valorar Servicio</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif" />
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link href="../assets/css/responsive.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Valorar Servicio</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="nota" class="form-label">Nota:</label>
                <div class="star-rating">
                    <input type="radio" name="nota" id="star5" value="5"><label for="star5">★</label>
                    <input type="radio" name="nota" id="star4" value="4"><label for="star4">★</label>
                    <input type="radio" name="nota" id="star3" value="3"><label for="star3">★</label>
                    <input type="radio" name="nota" id="star2" value="2"><label for="star2">★</label>
                    <input type="radio" name="nota" id="star1" value="1"><label for="star1">★</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea name="descripcion" id="descripcion" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar Valoración</button>
        </form>
    </div>
</body>
</html>