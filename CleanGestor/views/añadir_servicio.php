<!-- filepath: c:\xampp\htdocs\CleanGestor\views\añadir_servicio.php -->
<?php
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
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css" />
  <link href="../assets/css/style.css" rel="stylesheet" />
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
</html>