<?php
session_start();
require_once("../VO/ServicioVO.php");
require_once("../DAO/ServicioDAO.php");

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

$sql = "SELECT * FROM servicio WHERE idServicio = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$servicio = $result->fetch_assoc();
$stmt->close();
$conexion->close();

if (!$servicio) {
    die("Servicio no encontrado.");
}

$foto_perfil = isset($_SESSION['foto_perfil']) ? $_SESSION['foto_perfil'] : '../assets/uploads/default.png';
$imagen = !empty($servicio['imagen']) ? $servicio['imagen'] : '../assets/images/default_service.png';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Servicio | CLEAN GESTOR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tus estilos personalizados -->
    <link href="../assets/css/style.css?v=2" rel="stylesheet" />
    <link href="../assets/css/responsive.css" rel="stylesheet" />
    <!-- Iconos y fuentes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
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

    <div class="container py-4">
        <a href="javascript:history.back()" class="back-link mt-4 d-inline-block">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <div class="service-card mx-auto mt-4" style="max-width: 800px;">
            <div class="row g-4 align-items-center">
                <div class="col-md-5 text-center">
                    <img src="<?= htmlspecialchars($imagen) ?>" 
                         alt="Imagen del servicio" 
                         class="service-img img-fluid">
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

                    <a href="contratar_servicio.php?id=<?= $servicio['idServicio'] ?>" 
                       class="btn btn-primary btn-lg">
                        <i class="fas fa-shopping-cart"></i> Contratar Servicio
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS y animaciones -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script>
        gsap.from(".navbar-nav .nav-link", { y: -50, opacity: 0, duration: 0.8, stagger: 0.3 });
        gsap.from(".profile-card", { duration: 1.2, y: 50, opacity: 0, delay: 0.5 });
        gsap.from(".profile-actions .btn", { duration: 0.7, x: -30, opacity: 0, stagger: 0.2, delay: 1.2 });
        gsap.from("#profile-photo", { y: -100, opacity: 0, duration: 1, delay: 1 });
    </script>
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
