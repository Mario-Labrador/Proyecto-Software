<?php
session_start();

// Verificar si la sesión está activa
if (!isset($_SESSION['dni'])) {
    exit();
}

// Obtener datos de la sesión
$dni = $_SESSION['dni'];
$nombre = $_SESSION['nombre'];
$email = $_SESSION['email'];
$tipo = $_SESSION['tipo_usuario'];
$rol = $_SESSION['rol'] ?? '';
$fotoPerfil = $_SESSION['foto_perfil'] ?? ''; // Obtener la ruta de la foto de perfil desde la sesión

// Datos adicionales
$telefono = $_SESSION['telefono'] ?? 'No disponible';
$direccion = $_SESSION['direccion'] ?? 'No disponible';
$fechaRegistro = $_SESSION['fecha_registro'] ?? 'No disponible';
$sobreMi = $_SESSION['sobre_mi'] ?? 'No disponible';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif" />
  <title>Perfil | CLEAN GESTOR</title>
  
  <!-- Estilos CSS -->
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css?v=<?php echo time(); ?>" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" crossorigin="anonymous">
  <link href="../assets/css/style.css?v=<?php echo time(); ?>" rel="stylesheet" />
  <link href="../assets/css/responsive.css?v=<?php echo time(); ?>" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

  <!-- Mostrar errores PHP (solo en desarrollo) -->
  <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
  ?>
</head>

<body>
  <div class="hero_area">
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container">
          <a class="navbar-brand animate__animated animate__fadeInDown" href="index.html">
            <span>CLEAN GESTOR</span>
          </a>
          <button class="navbar-toggler animate__animated animate__fadeInDown" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent">
            <span class=""> </span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item"><a class="nav-link" href="index.html">INICIO</a></li>
              <li class="nav-item"><a class="nav-link" href="about.html">SOBRE NOSOTROS</a></li>
              <li class="nav-item"><a class="nav-link" href="service.html">SERVICIOS</a></li>
              <li class="nav-item"><a class="nav-link" href="contact.html">CONTACTO</a></li>
              <li class="nav-item"><a class="nav-link" href="perfil.php">PERFIL</a></li>
            </ul>
          </div>
        </nav>
      </div>
    </header>

    <section class="profile-section">
      <div class="container">
        <div class="profile-card animate__animated animate__fadeInUp">
          <div class="text-center">
            <!-- Mostrar la imagen de perfil o la predeterminada -->
            <img src="<?php echo !empty($fotoPerfil) ? $fotoPerfil : '../assets/uploads/default.png'; ?>" 
                 alt="Foto de perfil" 
                 class="profile-image mb-2" 
                 style="max-height: 200px; border-radius: 50%;">
            <h2 class="mt-3"><?php echo htmlspecialchars($nombre); ?></h2>
            <p class="text-muted mb-2"><?php echo ucfirst($tipo); ?> <?php echo $rol ? "($rol)" : ''; ?></p>
            <div class="profile-actions">
              <a href="editar-perfil.php" class="btn btn-primary"><i class="fa fa-pencil"></i> Editar Perfil</a>
              <a href="logout.php" class="btn btn-danger"><i class="fa fa-sign-out"></i> Cerrar Sesión</a>
            </div>
          </div>
          <hr>
          <div class="profile-info mt-4">
            <div class="row">
              <div class="col-md-6"><label>Correo electrónico</label><p><?php echo htmlspecialchars($email); ?></p></div>
              <div class="col-md-6"><label>Teléfono</label><p><?php echo htmlspecialchars($telefono); ?></p></div>
              <div class="col-md-6"><label>Dirección</label><p><?php echo htmlspecialchars($direccion); ?></p></div>
              <div class="col-md-6"><label>Miembro desde</label><p><?php echo htmlspecialchars($fechaRegistro); ?></p></div>
            </div>
          </div>
          <hr>
          <div class="mt-3">
            <h5>Sobre mí</h5>
            <p><?php echo htmlspecialchars($sobreMi); ?></p>
          </div>

          <!-- Formulario para subir la foto de perfil -->
          <div class="text-center mt-4">
              <h3>Cambiar foto de perfil</h3>
              <form action="subir_foto.php" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                      <input type="file" name="foto_perfil" class="form-control" accept="image/*" required>
                  </div>
                  <button type="submit" class="btn btn-success">Subir Foto</button>
              </form>
          </div>

          <!-- Mostrar mensaje de éxito o error -->
          <?php if (isset($_SESSION['success_foto'])): ?>
              <div class="alert alert-success mt-3">
                  <?php echo $_SESSION['success_foto']; unset($_SESSION['success_foto']); ?>
              </div>
          <?php endif; ?>

          <?php if (isset($_SESSION['error_foto'])): ?>
              <div class="alert alert-danger mt-3">
                  <?php echo $_SESSION['error_foto']; unset($_SESSION['error_foto']); ?>
              </div>
          <?php endif; ?>
          
        </div>
      </div>
    </section>
  </div>

  <!-- Scripts JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <script>
    gsap.from(".navbar-nav .nav-link", { y: -50, opacity: 0, duration: 0.8, stagger: 0.3 });
    gsap.from(".profile-card", { duration: 1.2, y: 50, opacity: 0, delay: 0.5 });
    gsap.from(".profile-actions .btn", { duration: 0.7, x: -30, opacity: 0, stagger: 0.2, delay: 1.2 });
  </script>
</body>
</html>