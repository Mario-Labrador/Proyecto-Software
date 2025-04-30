<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$foto_perfil = isset($_SESSION['foto_perfil']) ? $_SESSION['foto_perfil'] : '../assets/uploads/default.png';
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
            
            <?php if ($_SESSION['tipo_usuario'] === 'trabajador' && $_SESSION['rol'] === 'empleado'): ?>
                <li class="nav-item"><a class="nav-link" href="buscar_empleo.php">BUSCAR EMPLEO</a></li>
            <?php endif; ?>
            
            <?php if ($_SESSION['tipo_usuario'] === 'cliente'): ?>
                <!-- Menú ÁREA CLIENTE -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="areaClienteDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i> ÁREA CLIENTE
                    </a>
                    <ul class="dropdown-menu shadow rounded" aria-labelledby="areaClienteDropdown">
                        <li><a class="dropdown-item" href="servicios.php"><i class="fas fa-concierge-bell me-2"></i>Servicios</a></li>
                        <li><a class="dropdown-item" href="servicios_contratados_cliente.php"><i class="fas fa-handshake me-2"></i>Servicios Contratados</a></li>
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
                            <a class="dropdown-item" href="misServicios.php"><i class="fas fa-briefcase me-2"></i>Mis Servicios</a>
                            <a class="dropdown-item" href="estadisticas.php"><i class="fas fa-chart-bar me-2"></i>Estadisticas</a>
                            <a class="dropdown-item" href="misTrabajadores.php"><i class="fas fa-user-tie"></i>  Mis trabajadores</a>
                            <a class="dropdown-item" href="solicitudes_empleo.php"><i class="fas fa-file-signature"></i> Solicitudes de empleo </a>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script>
    gsap.from(".navbar-nav .nav-link", { y: -50, opacity: 0, duration: 0.8, stagger: 0.3 });
    gsap.from(".profile-card", { duration: 1.2, y: 50, opacity: 0, delay: 0.5 });
    gsap.from(".profile-actions .btn", { duration: 0.7, x: -30, opacity: 0, stagger: 0.2, delay: 1.2 });
    gsap.from("#profile-photo", { y: -100, opacity: 0, duration: 1, delay: 1 });
</script>
<script>
  // Elimina el foco del item seleccionado al cerrar el dropdown
  document.querySelectorAll('.dropdown').forEach(dropdown => {
    dropdown.addEventListener('hidden.bs.dropdown', () => {
      const focused = dropdown.querySelector(':focus');
      if (focused) focused.blur();
    });
  });
</script>
