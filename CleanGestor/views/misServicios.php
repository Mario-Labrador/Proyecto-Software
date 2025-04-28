<!-- filepath: c:\xampp\htdocs\CleanGestor\views\mis_servicios.php -->
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

// Obtener el idEmpresa desde la sesión
$idEmpresa = $_SESSION['idEmpresa'] ?? null;
if (!$idEmpresa) {
    die("Error: No se pudo determinar la empresa asociada al administrador.");
}

// Consultar los servicios asociados a la empresa
$sql = "SELECT idServicio, nombreServicio, descripcion, precio, horas, sueldo, fotoServicio FROM servicio WHERE idEmpresa = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idEmpresa);
$stmt->execute();
$resultado = $stmt->get_result();

// Almacenar los servicios en un array
$servicios = [];
while ($fila = $resultado->fetch_assoc()) {
    $servicios[] = $fila;
}

// Cerrar la conexión
$stmt->close();
$conexion->close();
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
  <link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Mis Servicios - CLEAN GESTOR</title>

  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css" />
  <link href="../assets/css/font-awesome.min.css" rel="stylesheet" />
  <link href="../assets/css/style.css" rel="stylesheet" />
  <link href="../assets/css/responsive.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <!-- Google Fonts: Montserrat -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>

<body class="sub_page">
  <div class="hero_area">
    <!-- header section starts -->
    <header class="header_section">
      <div class="container-fluid">
        <?php include_once("navbar.php"); ?>
      </div>
    </header>
    <!-- header section ends -->
  </div>

  <!-- Mis Servicios Section -->
  <section class="service_section layout_padding">
    <div class="container">
      <div class="mb-5 text-center">
        <h2 class="fw-bold">Mis Servicios</h2>
        <p>
          Aquí puedes gestionar los servicios de tu empresa.
        </p>
      </div>

      <!-- Botones de acción -->
      <div class="mb-4 text-center">
        <a href="añadir_servicio.php" class="btn btn-primary me-2">Añadir Servicio</a>
        <a href="eliminar_servicio.php" class="btn btn-danger">Eliminar Servicio</a>
      </div>

      <!-- Contenido de los servicios -->
      <div class="row">
        <?php if (count($servicios) > 0): ?>
          <?php foreach ($servicios as $servicio): ?>
            <div class="col-md-4 mb-4">
              <div class="card">
                <!-- Mostrar la imagen del servicio -->
                <img 
                  src="<?php echo !empty($servicio['fotoServicio']) ? htmlspecialchars($servicio['fotoServicio']) : '../assets/images/default_service.png'; ?>" 
                  class="card-img-top" 
                  alt="Imagen del servicio" 
                  style="max-height: 200px; object-fit: cover;">
                <div class="card-body">
                  <h5 class="card-title"><?php echo htmlspecialchars($servicio['nombreServicio']); ?></h5>
                  <p class="card-text"><?php echo htmlspecialchars($servicio['descripcion']); ?></p>
                  <p class="card-text"><strong>Precio:</strong> <?php echo htmlspecialchars($servicio['precio']); ?> €</p>
                  <p class="card-text"><strong>Horas:</strong> <?php echo htmlspecialchars($servicio['horas']); ?></p>
                  <p class="card-text"><strong>Sueldo:</strong> <?php echo htmlspecialchars($servicio['sueldo']); ?> €</p>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="col-md-12">
            <p class="text-center">No hay servicios disponibles por el momento.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>