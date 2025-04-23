<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$foto_perfil = isset($_SESSION['foto_perfil']) ? $_SESSION['foto_perfil'] : '../assets/uploads/default.png';
?>
<nav class="navbar navbar-expand-lg custom_nav-container">
    <a class="navbar-brand animate__animated animate__fadeInDown" href="index.php">
        <span>CLEAN GESTOR</span>
    </a>
    <button class="navbar-toggler animate__animated animate__fadeInDown" type="button" data-toggle="collapse"
        data-target="#navbarSupportedContent">
        <span class=""> </span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="index.php">INICIO</a></li>
            <li class="nav-item"><a class="nav-link" href="informate.php">SOBRE NOSOTROS</a></li>
            <li class="nav-item"><a class="nav-link" href="servicios.php">SERVICIOS</a></li>
            <?php if (isset($_SESSION['dni'])): ?>
                <li class="nav-item" style="display: flex; align-items: center;">
                    <details style="position: relative;">
                        <summary style="list-style: none; cursor: pointer; outline: none; border: none; background: none; margin-top: 6px;">
                            <img 
                                id="profile-photo"
                                src="<?php echo htmlspecialchars($foto_perfil); ?>"
                                alt="Foto de perfil"
                                class="profile-image mb-2"
                                style="max-height: 45px; width: 45px; border-radius: 50%; object-fit: cover;"
                            >
                        </summary>
                        <div class="navbar-profile-settings">
                            <div class="d-flex flex-column align-items-center gap-2">
                                <div class="text-black mb-2">
                                    <i class="fa fa-user me-2"></i>Hola, <?php echo $_SESSION['nombre'] ?? 'Usuario'; ?>
                                </div>
                                <?php
                                  $tipoUsuario = $_SESSION['tipo_usuario'] ?? '';
                                  $perfilUrl = 'perfil.php'; // Default
                                  if ($tipoUsuario === 'trabajador') {
                                      $perfilUrl = 'perfilTrabajador.php';
                                  }
                                ?>
                                <a href="<?php echo $perfilUrl; ?>" class="btn btn-primary w-100 mb-2">
                                    <i class="fa fa-pencil"></i> Mi Perfil
                                </a>
                                <a href="logout.php" class="btn btn-danger w-100">
                                    <i class="fa fa-sign-out"></i> Cerrar Sesión
                                </a>
                            </div>
                        </div>
                    </details>
                </li>
            <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="login.php">INICIAR SESIÓN</a></li>
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
