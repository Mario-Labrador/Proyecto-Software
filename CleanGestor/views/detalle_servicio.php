<?php
session_start();
require_once("../VO/ServicioVO.php");
require_once("../DAO/ServicioDAO.php");
require_once("../DAO/ContratoDAO.php"); // Cambiar a ContratoDAO

// Validar el parámetro id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de servicio no válido.");
}
$id = intval($_GET['id']);

// Conexión a la base de datos
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'gestor';

$conexion = new mysqli($host, $user, $pass, $db);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener los datos del servicio
$sql = "SELECT * FROM servicio WHERE idServicio = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$servicio = $result->fetch_assoc();
$stmt->close();

if (!$servicio) {
    die("Servicio no encontrado.");
}

// Verificar si el cliente tiene un contrato abierto
$contratoDAO = new ContratoDAO($conexion);
$contratoAbierto = $contratoDAO->obtenerContratoAbierto($_SESSION['dni'] ?? null);

$servicioYaEnCarrito = false;
if ($contratoAbierto) {
    require_once("../DAO/ContratoServicioDAO.php");
    $contratoServicioDAO = new ContratoServicioDAO($conexion);
    $servicioYaEnCarrito = $contratoServicioDAO->servicioYaEnContrato($contratoAbierto['idContrato'], $servicio['idServicio']);
}

$conexion->close();

$foto_perfil = isset($_SESSION['foto_perfil']) ? $_SESSION['foto_perfil'] : '../assets/uploads/default.png';
$imagen = !empty($servicio['fotoServicio']) && file_exists(__DIR__ . "/" . $servicio['fotoServicio']) 
    ? htmlspecialchars($servicio['fotoServicio']) 
    : "../assets/images/default_service.png";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif" />
    <title>Detalle del Servicio | CLEAN GESTOR</title>
    <link href="../assets/css/style.css?v=2" rel="stylesheet" />
    <link href="../assets/css/responsive.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="sub_page">
    <!-- NAVBAR -->
    <div class="hero_area">
        <header class="header_section">
            <div class="container-fluid">
                <?php include_once("navbar.php"); ?>
            </div>
        </header>
    </div>
    <?php include_once("carrito_flotante.php"); ?>

    <div class="container py-4">
        <a href="javascript:history.back()" class="back-link mt-4 d-inline-block">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <div class="service-card mx-auto mt-4" style="max-width: 800px;">
            <div class="row g-4 align-items-center">
                <div class="col-md-5 text-center">
                    <div class="service-img-container">
                        <img src="<?= $imagen ?>" 
                            alt="Imagen del servicio" 
                            class="service-img">
                    </div>
                </div>
                <div class="col-md-7">
                    <h1 class="service-title mb-3"><?= htmlspecialchars($servicio['nombreServicio']) ?></h1>
                    <p class="mb-3"><?= nl2br(htmlspecialchars($servicio['descripcion'])) ?></p>
                    
                    <?php if (!empty($servicio['precio'])): ?>
                        <div class="service-price mb-4">
                            <i class="fas fa-euro-sign"></i> 
                            <?= number_format($servicio['precio'], 2, ',', '.') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($servicio['horas'])): ?>
                        <div class="mb-3">
                            <i class="fas fa-clock me-2"></i>
                            <strong>Duración:</strong> <?= $servicio['horas'] ?> horas
                        </div>
                    <?php endif; ?>

                    <?php if ($_SESSION['tipo_usuario'] === 'cliente'): ?>
                        <!-- Botón habilitado para clientes -->
                        <a href="<?= $servicioYaEnCarrito ? "ver_carrito.php?idContrato={$contratoAbierto['idContrato']}" : "agregar_servicio_carrito.php?idContrato={$contratoAbierto['idContrato']}&idServicio={$servicio['idServicio']}" ?>" 
                           class="btn btn-primary btn-lg mb-3">
                            <i class="fas fa-shopping-cart"></i> <?= $servicioYaEnCarrito ? 'Ya en el carrito' : 'Contratar Servicio' ?>
                        </a>
                    <?php else: ?>
                        <!-- Mensaje para usuarios no clientes -->
                        <div class="alert alert-warning mt-3" style="margin-right: 40px;">
                            <i class="fas fa-exclamation-circle"></i> Debes iniciar sesión como cliente para contratar un servicio.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS y animaciones -->
    <?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    $foto_perfil = isset($_SESSION['foto_perfil']) ? $_SESSION['foto_perfil'] : '../assets/uploads/default.png';
    ?>

    <!-- jQuery, Popper.js y Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>


    <script>
      document.querySelectorAll('.dropdown').forEach(dropdown => {
        dropdown.addEventListener('hidden.bs.dropdown', () => {
          const focused = dropdown.querySelector(':focus');
          if (focused) focused.blur();
        });
      });
    </script>
</body>
</html>
