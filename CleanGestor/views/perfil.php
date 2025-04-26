<?php
session_start();

// Verificar si la sesión está activa
if (!isset($_SESSION['dni'])) {
  header("Location: login.php");
  exit();
}

// Obtener datos de la sesión
$dni = $_SESSION['dni'] ?? '';
$nombre = $_SESSION['nombre'] ?? '';
$apellidos = $_SESSION['apellidos'] ?? '';
$email = $_SESSION['email'] ?? '';
$telefono = $_SESSION['telefono'] ?? '';
$fechaNacimiento = $_SESSION['fechaNacimiento'] ?? '';
$tipo = $_SESSION['tipo_usuario'] ?? '';
$rol = $_SESSION['rol'] ?? '';
$foto_perfil = $_SESSION['foto_perfil'] ?? ''; // Obtener la ruta de la foto de perfil desde la sesión
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif" />
  <title>Perfil | CLEAN GESTOR</title>
  
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css?v=<?php echo time(); ?>" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link href="../assets/css/style.css?v=<?php echo time(); ?>" rel="stylesheet" />
  <link href="../assets/css/responsive.css?v=<?php echo time(); ?>" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

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
        <?php include_once("navbar.php"); ?>
      </div>
    </header>

    <section class="profile-section">
      <div class="container">
        <div class="profile-card animate__animated animate__fadeInUp">
          <div class="text-center">
            <!-- Mostrar la imagen de perfil o la predeterminada -->
            <img src="<?php echo !empty($foto_perfil) ? $foto_perfil : '../assets/uploads/default.png'; ?>" 
                 alt="Foto de perfil" 
                 class="profile-image mb-2" 
                 style="max-height: 200px; border-radius: 50%;">
            <h2 class="mt-3"><?php echo htmlspecialchars($nombre . ' ' . $apellidos); ?></h2>
            <p class="text-muted mb-2"><?php echo ucfirst($tipo); ?> <?php echo $rol ? "($rol)" : ''; ?></p>
            <div class="profile-actions">
              <a href="editar_perfil.php" class="btn btn-primary"><i class="fa fa-pencil"></i> Editar Perfil</a>
              <a href="logout.php" class="btn btn-danger"><i class="fa fa-sign-out"></i> Cerrar Sesión</a>
            </div>
          </div>
          <hr>
          <div class="profile-info mt-4">
            <div class="row">
              <div class="col-md-6"><label>Correo electrónico</label><p><?php echo htmlspecialchars($email); ?></p></div>
              <div class="col-md-6"><label>Teléfono</label><p><?php echo htmlspecialchars($telefono); ?></p></div>
              <div class="col-md-6"><label>DNI/NIF</label><p><?php echo htmlspecialchars($dni); ?></p></div>
              <div class="col-md-6"><label>Fecha de nacimiento</label><p><?php echo htmlspecialchars(date('d/m/Y', strtotime($fechaNacimiento))); ?></p></div>
              
            </div>
          </div>
          <hr>    
        </div>
      </div>
    </section>
  </div>

  <!-- jQuery, Popper.js y Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>