<!-- filepath: c:\xampp\htdocs\CleanGestor\views\eliminar_servicio.php -->
<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['dni']) || $_SESSION['tipo_usuario'] !== 'trabajador' || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php"); // Redirigir al login si no es administrador
    exit();
}

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "gestor");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consultar los servicios asociados a la empresa
$idEmpresa = $_SESSION['idEmpresa'] ?? null;
if (!$idEmpresa) {
    die("Error: No se pudo determinar la empresa asociada al administrador.");
}

$sql = "SELECT idServicio, nombreServicio, descripcion, precio, horas, fotoServicio FROM servicio WHERE idEmpresa = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idEmpresa);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif" />
  <title>Eliminar Servicio - CLEAN GESTOR</title>
  <link href="../assets/css/style.css?v=2" rel="stylesheet" />
  <link href="../assets/css/responsive.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .modal {
      z-index: 1050 !important;
    }
    .modal-backdrop {
      z-index: 1040 !important;
    }
  </style>
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
    <div class="container" >
      <!-- Botón de Volver 
      <a href="javascript:history.back()" class="btn btn-link text-decoration-none mb-3" >
        ← Volver
      </a> -->

      <div class="mb-5 text-center">
        <h2 class="fw-bold">Eliminar Servicio</h2>
        <p>Selecciona el servicio que deseas eliminar.</p>
      </div>

      <!-- Mostrar mensajes -->
      <?php if (isset($_GET['mensaje'])): ?>
        <div class="alert alert-success text-center">
          <?php echo htmlspecialchars($_GET['mensaje']); ?>
        </div>
        <div class="text-center mt-4">
          <a href="misServicios.php" class="btn btn-primary">Finalizar</a>
        </div>
      <?php elseif (isset($_GET['error'])): ?>
        <div class="alert alert-danger text-center">
          <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
      <?php endif; ?>

      <div class="row">
        <?php if ($resultado->num_rows > 0): ?>
          <?php while ($row = $resultado->fetch_assoc()): ?>
            <div class="col-md-3 col-sm-6 mb-4">
              <div class="card">
                <!-- Mostrar la imagen del servicio -->
                <img 
                  src="<?php echo !empty($row['fotoServicio']) ? htmlspecialchars($row['fotoServicio']) : '../assets/images/default_service.png'; ?>" 
                  class="card-img-top" 
                  alt="Imagen del servicio" 
                  style="width: 100%; height: 150px; object-fit: cover; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                <div class="card-body">
                  <h5 class="card-title"><?php echo htmlspecialchars($row['nombreServicio']); ?></h5>
                  <p class="card-text"><?php echo htmlspecialchars($row['descripcion']); ?></p>
                  <p class="card-text"><strong>Precio:</strong> <?php echo htmlspecialchars($row['precio']); ?> €</p>
                  <p class="card-text"><strong>Horas:</strong> <?php echo htmlspecialchars($row['horas']); ?></p>
                  <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?php echo $row['idServicio']; ?>, '<?php echo htmlspecialchars($row['nombreServicio']); ?>')">Eliminar</button>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <div class="col-md-12">
            <p class="text-center">No hay servicios disponibles para eliminar.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Modal de confirmación -->
  <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar eliminación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          ¿Estás seguro de que deseas eliminar el servicio <strong id="serviceName"></strong>?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <a href="#" id="confirmDeleteButton" class="btn btn-danger">Eliminar</a>
        </div>
      </div>
    </div>
  </div>

  <?php
  $stmt->close();
  $conexion->close();
  ?>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
  <script>
        gsap.from(".navbar-nav .nav-link", { y: -50, opacity: 0, duration: 0.8, stagger: 0.3 });
        gsap.from(".profile-card", { duration: 1.2, y: 50, opacity: 0, delay: 0.5 });
        gsap.from(".profile-actions .btn", { duration: 0.7, x: -30, opacity: 0, stagger: 0.2, delay: 1.2 });
        gsap.from("#profile-photo", { y: -100, opacity: 0, duration: 1, delay: 1 });
  </script>
  
  <script>
    // Función para mostrar el modal de confirmación
    function confirmDelete(idServicio, nombreServicio) {
      // Establecer el nombre del servicio en el modal
      document.getElementById('serviceName').textContent = nombreServicio;

      // Establecer el enlace de eliminación con el idServicio
      document.getElementById('confirmDeleteButton').href = `procesar_eliminar_servicio.php?idServicio=${idServicio}`;

      // Mostrar el modal
      const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
      modal.show();
    }

    // Asegurarse de que el botón "Cancelar" cierre el modal
    document.querySelectorAll('[data-bs-dismiss="modal"]').forEach(button => {
      button.addEventListener('click', () => {
        const modal = bootstrap.Modal.getInstance(document.getElementById('confirmDeleteModal'));
        modal.hide();
      });
    });
  </script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>