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
    <?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    $foto_perfil = isset($_SESSION['foto_perfil']) ? $_SESSION['foto_perfil'] : '../assets/uploads/default.png';
    ?>




    <nav class="navbar navbar-expand-lg custom_nav-container">
        <a class="navbar-brand animate__animated animate__fadeInDown" href="index.php">
            <span>CLEAN GESTOR</span>
        </a>
        <button class="navbar-toggler animate__animated animate__fadeInDown" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="index.php">INICIO</a></li>
                <li class="nav-item"><a class="nav-link" href="informate.php">SOBRE NOSOTROS</a></li>
                <li class="nav-item"><a class="nav-link" href="servicios.php">SERVICIOS</a></li>
                <?php if (isset($_SESSION['dni'])): ?>
                
                <?php if ($_SESSION['tipo_usuario'] === 'cliente'): ?>
                    <!-- Menú ÁREA CLIENTE -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="areaClienteDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> ÁREA CLIENTE
                        </a>
                        <ul class="dropdown-menu shadow rounded" aria-labelledby="areaClienteDropdown">
                            <li><a class="dropdown-item" href="servicios.php"><i class="fas fa-concierge-bell me-2"></i>Servicios</a></li>
                            <li><a class="dropdown-item" href="servicios_contratados.php"><i class="fas fa-handshake me-2"></i>Servicios Contratados</a></li>
                            <li><a class="dropdown-item" href="valoraciones.php"><i class="fas fa-star me-2"></i>Valoraciones</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                
                <?php if ($_SESSION['tipo_usuario'] === 'trabajador' && $_SESSION['rol'] === 'administrador'): ?>
                        <!-- Menú desplegable MI EMPRESA -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="miEmpresaDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                MI EMPRESA
                            </a>
                            <div class="dropdown-menu" aria-labelledby="miEmpresaDropdown">
                                <a class="dropdown-item" href="misServicios.php">Mis Servicios</a>
                            </div>
                        </li>
                <?php endif; ?>

                <!-- Perfil del usuario -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 10px 15px;">
                        <img 
                            src="<?php echo htmlspecialchars($foto_perfil); ?>"
                            alt="Foto de perfil"
                            class="rounded-circle shadow-sm border border-2"
                            style="height: 42px; width: 42px; object-fit: cover; margin-right: 8px;"
                        >
                        <span class="fw-semibold"><?php echo $_SESSION['nombre'] ?? 'Usuario'; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow rounded" aria-labelledby="profileDropdown">
                        <li class="px-3 py-2 text-center">
                            <img 
                                src="<?php echo htmlspecialchars($foto_perfil); ?>"
                                alt="Foto de perfil"
                                class="rounded-circle mb-2"
                                style="height: 60px; width: 60px; object-fit: cover; border: 2px solid #eee;"
                            >
                            <div class="fw-bold" style="font-family: 'Montserrat', Arial, sans-serif;"><?php echo $_SESSION['nombre'] ?? 'Usuario'; ?></div>
                            <small class="text-muted"><?php echo $_SESSION['email'] ?? ''; ?></small>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="perfil.php" style="font-family: 'Montserrat', Arial, sans-serif;">
                                <i class="fa fa-pencil me-2"></i> Mi Perfil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="logout.php" style="font-family: 'Montserrat', Arial, sans-serif;">
                                <i class="fa fa-sign-out me-2"></i> Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-primary px-4 ms-2 rounded-pill" href="login.php">
                            <i class="fas fa-sign-in-alt me-2"></i>INICIAR SESIÓN
                        </a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </nav>

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
