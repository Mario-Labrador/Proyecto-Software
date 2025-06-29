<!-- filepath: c:\xampp\htdocs\CleanGestor\views\añadir_servicio.php -->
<?php
// añadir_servicio.php
// Mario Recio
if (session_status() === PHP_SESSION_NONE) session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['dni']) || $_SESSION['tipo_usuario'] !== 'trabajador' || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php");
    exit();
}

// Obtener el identificador de la empresa desde la sesión
$idEmpresa = $_SESSION['idEmpresa'] ?? null;
if (!$idEmpresa) {
    die("Error: No se pudo determinar la empresa asociada al administrador.");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif" />
  <title>Añadir Servicio - CLEAN GESTOR</title>
  <link href="../assets/css/style.css?v=2" rel="stylesheet" />
  <link href="../assets/css/responsive.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="sub_page">
  <div class="hero_area">
    <header class="header_section">
      <div class="container-fluid">
        <?php include_once("navbar.php"); ?>
      </div>
    </header>
  </div>

  <section class="service_section layout_padding">
    <div class="container">
      <div class="mb-5 text-center">
        <h2 class="fw-bold">Añadir Servicio</h2>
        <p>Rellena los campos para añadir un nuevo servicio.</p>
      </div>
      <form action="procesar_añadir_servicio.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="nombreServicio" class="form-label">Nombre del Servicio</label>
          <input type="text" class="form-control" id="nombreServicio" name="nombreServicio" required>
        </div>
        <div class="mb-3">
          <label for="descripcion" class="form-label">Descripción</label>
          <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
        </div>
        <div class="mb-3">
          <label for="precio" class="form-label">Precio</label>
          <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
        </div>
        <div class="mb-3">
          <label for="horas" class="form-label">Horas</label>
          <input type="number" class="form-control" id="horas" name="horas" required>
        </div>
        <div class="mb-3">
          <label for="sueldo" class="form-label">Sueldo</label>
          <input type="number" class="form-control" id="sueldo" name="sueldo" step="0.01" required>
        </div>
        <div class="mb-3">
          <label for="imagen" class="form-label">Imagen del Servicio</label>
          <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-primary">Guardar Servicio</button>
          <a href="misServicios.php" class="btn btn-secondary">Cancelar</a>
        </div>
      </form>
    </div>
  </section>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
</html>