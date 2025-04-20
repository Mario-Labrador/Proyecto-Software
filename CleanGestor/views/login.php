<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  
  <!-- Site Metas -->
  <link rel="icon" href="../assets/iamges/IconoEscoba.png" type="image/gif" />
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
            <input type="email" class="form-control" id="email" name="email" placeholder="Introduce tu correo" required>
          </div>
          <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Introduce tu contraseña" required>
          </div>
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

  <!-- GSAP Script for Menu Buttons Animation -->
  <script>
    // Animación para el contenido principal
    gsap.from(".detail-box h1", { duration: 2, x: -100, opacity: 0 });
    gsap.from(".detail-box p", { duration: 2, y: -50, opacity: 0, delay: 0.5 });
    gsap.from(".img-box img", { duration: 1.5, scale: 0.8, opacity: 0, delay: 1 });
  </script>
</body>

</html>