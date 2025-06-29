<?php
//Alberto Lacarta
// login.php

session_start();
if (isset($_SESSION['dni'])) {
  header("Location: perfil.php");
  exit();
}
$preservedEmail = $_SESSION['preserved_email'] ?? '';
$errorType = $_SESSION['error_type'] ?? '';
unset($_SESSION['error_type'], $_SESSION['preserved_email']);
?>

<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  
  <!-- Site Metas -->
  <link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  
  <title>Login - CLEAN GESTOR</title>

  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet" />
  <link href="../assets/css/responsive.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>

<body>

  <div class="hero_area">
    <!-- header section starts -->
    <header class="header_section">
      <div class="container-fluid">
        <?php include_once("navbar.php"); ?>
      </div>
    </header>
    <!-- header section ends -->

    <!-- Login Form Section -->
    <section class="login_section">
      <div class="login_box">
        <h2>Iniciar Sesión</h2>
        <form action="procesar_login.php" method="POST">
          <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" class="form-control <?= $errorType === 'email_no_existe' ? 'is-invalid' : '' ?>"  id="email" name="email" value="<?= htmlspecialchars($preservedEmail) ?>" placeholder="Introduce tu correo" required>
          </div>
          <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control <?= $errorType === 'password_incorrecta' ? 'is-invalid' : '' ?>"  id="password" name="password" placeholder="Introduce tu contraseña" required>
          </div>
          <?php if ($errorType): ?>
            <div class="alert alert-danger animate__animated animate__headShake mb-4">
                <?php 
                echo match($errorType) {
                    'email_no_existe' => 'Correo no registrado',
                    'password_incorrecta' => 'Contraseña incorrecta',
                    'sin_rol' => 'Usuario sin rol asignado',
                    default => 'Error desconocido'
                };
                ?>
            </div>
          <?php endif; ?>
          <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        </form>
        <p>
          ¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a>
        </p>
      </div>
    </section>
  </div>

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

  <script>
    // Animación para el contenido principal
    gsap.from(".detail-box h1", { duration: 2, x: -100, opacity: 0 });
    gsap.from(".detail-box p", { duration: 2, y: -50, opacity: 0, delay: 0.5 });
    gsap.from(".img-box img", { duration: 1.5, scale: 0.8, opacity: 0, delay: 1 });
  </script>
</body>

</html>