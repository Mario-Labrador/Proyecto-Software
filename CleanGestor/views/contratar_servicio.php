<!-- filepath: c:\xampp\htdocs\CleanGestor\views\contratar_servicio.php -->
<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Verificar si el usuario está logueado y es cliente
if (!isset($_SESSION['dni']) || $_SESSION['tipo_usuario'] !== 'cliente') {
    header("Location: login.php");
    exit();
}

// Aquí podrías obtener los servicios disponibles desde la base de datos
// Ejemplo de array simulado:
$servicios = [
    ['id' => 1, 'nombre' => 'Limpieza Básica', 'descripcion' => 'Limpieza general de vivienda.', 'precio' => 30.00, 'horas' => 2],
    ['id' => 2, 'nombre' => 'Limpieza Profunda', 'descripcion' => 'Limpieza profunda de cocina y baños.', 'precio' => 50.00, 'horas' => 3],
    // ...otros servicios
];
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif" />
  <title>Contratar Servicio - CLEAN GESTOR</title>
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
        <h2 class="fw-bold">Contratar Servicio</h2>
        <p>Selecciona el servicio y completa los datos para solicitarlo.</p>
      </div>
      <form action="procesar_contratar_servicio.php" method="POST">
        <div class="mb-3">
          <label for="servicio" class="form-label">Servicio</label>
          <select class="form-select" id="servicio" name="servicio" required>
            <option value="" selected disabled>Selecciona un servicio</option>
            <?php foreach ($servicios as $servicio): ?>
              <option value="<?= $servicio['id'] ?>">
                <?= htmlspecialchars($servicio['nombre']) ?> (<?= number_format($servicio['precio'], 2) ?> €)
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label for="fecha" class="form-label">Fecha</label>
          <input type="date" class="form-control" id="fecha" name="fecha" required min="<?= date('Y-m-d') ?>">
        </div>
        <div class="mb-3">
          <label for="hora" class="form-label">Hora</label>
          <input type="time" class="form-control" id="hora" name="hora" required>
        </div>
        <div class="mb-3">
          <label for="direccion" class="form-label">Dirección</label>
          <input type="text" class="form-control" id="direccion" name="direccion" required>
        </div>
        <div class="mb-3">
          <label for="notas" class="form-label">Notas adicionales (opcional)</label>
          <textarea class="form-control" id="notas" name="notas" rows="3"></textarea>
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-primary">Solicitar Servicio</button>
          <a href="misServiciosCliente.php" class="btn btn-secondary">Cancelar</a>
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
