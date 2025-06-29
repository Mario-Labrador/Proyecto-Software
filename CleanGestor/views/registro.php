<?php
// registro.php
// Mario Labrador
session_start();
$errorType = $_SESSION['registro_error_type'] ?? '';
$registroData = $_SESSION['registro_data'] ?? [];
unset($_SESSION['registro_error_type'], $_SESSION['registro_data']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  
  <!-- Site Metas -->
  <link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif"/>
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  
  <title>Registro - CLEAN GESTOR</title>

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

    <!-- Registration Form Section -->
    <section class="login_section">
      <div class="login_box">
        <h2>Regístrate</h2>
        <form action="procesar_registro.php" method="POST">
          <div class="form-group">
            <label for="DNI/NIF">DNI/NIF</label>
            <input type="text" class="form-control <?= $errorType === 'dni_duplicado' ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($registroData['DNI'] ?? '') ?>" id="DNI" name="DNI" placeholder="Introduce tu DNI/NIF" required>
          </div>
          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($registroData['nombre'] ?? '') ?>" placeholder="Introduce tu nombre" required>
          </div>
          <div class="form-group">
            <label for="apellidos">Apellidos</label>
            <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?= htmlspecialchars($registroData['apellidos'] ?? '') ?>" placeholder="Introduce tus apellidos" required>
          </div>
          <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" class="form-control <?= $errorType === 'email_duplicado' || $errorType === 'no_correo_admin' ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($registroData['email'] ?? '') ?>" id="email" name="email" placeholder="Introduce tu correo" required>
          </div>
          <div class="form-group">
            <label for="telefono">Número de teléfono</label>
            <input type="telefono" class="form-control <?= $errorType === 'telefono_duplicado' ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($registroData['telefono'] ?? '') ?>" id="telefono" name="telefono" placeholder="Introduce tu número de teléfono" required>
          </div>
          <div class="form-group">
            <label for="fecha-nacimiento">Fecha de nacimiento</label>
            <input type="date" class="form-control" id="fecha-nacimiento" value="<?= htmlspecialchars($registroData['fecha-nacimiento'] ?? '') ?>" name="fecha-nacimiento" required>
          </div>
          <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control <?= $errorType === 'password_mismatch' ? 'is-invalid' : '' ?>"  id="password" name="password" placeholder="Introduce tu contraseña" required>
          </div>
          <div class="form-group">
            <label for="confirm_password">Confirmar Contraseña</label>
            <input type="password" class="form-control <?= $errorType === 'password_mismatch' ? 'is-invalid' : '' ?>"  id="confirm_password" name="confirm_password" placeholder="Confirma tu contraseña" required>
          </div>
          <div class="form-group">
            <label for="tipo_usuario">Tipo de usuario</label>
            <select class="form-control" id="tipo_usuario" name="tipo_usuario" required>
              <option value="">Selecciona una opción</option>
              <option value="trabajador">Trabajador</option>
              <option value="cliente">Cliente</option>
            </select>
          </div>
          <div class="form-group" id="rol_trabajador_group" style="display: none;">
            <label for="rol_trabajador">Rol de trabajador</label>
            <select class="form-control" id="rol_trabajador" name="rol_trabajador">
              <option value="">Selecciona un rol</option>
              <option value="administrador">Administrador de empresa</option>
              <option value="empleado">Empleado</option>
            </select>
          </div>
          <?php if ($errorType): ?>
            <div class="alert alert-danger animate__animated animate__headShake mb-4">
                <?php 
                echo match($errorType) {
                    'dni_duplicado' => 'El DNI ya está registrado',
                    'email_duplicado' => 'El correo electrónico ya está registrado',
                    'telefono_duplicado' => 'El número de teléfono ya está registrado',
                    'password_mismatch' => 'Las contraseñas no coinciden',
                    'no_correo_admin' => 'Este correo no está registrado como administrador de empresa',
                    default => 'Error en el registro'
                };
                ?>
            </div>
          <?php endif; ?>
          <button type="submit" class="btn btn-primary">Registrarse</button>
        </form>
        <p>
          ¿Ya tienes una cuenta? <a href="login.html">Inicia sesión aquí</a>
        </p>
      </div>
    </section>
  </div>

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  
  <script>
    // Animación para el contenido principal
    gsap.from(".detail-box h1", { duration: 2, x: -100, opacity: 0 });
    gsap.from(".detail-box p", { duration: 2, y: -50, opacity: 0, delay: 0.5 });
    gsap.from(".img-box img", { duration: 1.5, scale: 0.8, opacity: 0, delay: 1 });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('tipo_usuario').addEventListener('change', function() {
        var rolGroup = document.getElementById('rol_trabajador_group');
        if (this.value === 'trabajador') {
          rolGroup.style.display = 'block';
          document.getElementById('rol_trabajador').setAttribute('required', 'required');
        } else {
          rolGroup.style.display = 'none';
          document.getElementById('rol_trabajador').removeAttribute('required');
          document.getElementById('rol_trabajador').value = '';
        }
      });
    });
  </script>
</body>

</html>