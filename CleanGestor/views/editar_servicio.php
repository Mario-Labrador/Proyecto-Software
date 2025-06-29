<!-- filepath: c:\xampp\htdocs\CleanGestor\views\editar_servicio.php -->
<?php
// editar_servicio.php
// Mario Labrador
if (session_status() === PHP_SESSION_NONE) session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['dni']) || $_SESSION['tipo_usuario'] !== 'trabajador' || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "gestor");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener el idServicio
$idServicio = $_GET['id'] ?? null;
if (!$idServicio) {
    die("Error: No se especificó el servicio a editar.");
}

// Consultar los datos del servicio
$sql = "SELECT * FROM servicio WHERE idServicio = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idServicio);
$stmt->execute();
$resultado = $stmt->get_result();
$servicio = $resultado->fetch_assoc();

if (!$servicio) {
    die("Error: No se encontró el servicio.");
}

$stmt->close();
$conexion->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Servicio</title>
  <link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif" />
  <link rel="stylesheet" href="../assets/css/bootstrap.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

</head>
<body>
  <div class="container mt-5">
    <h2 class="mb-4">Editar Servicio</h2>
    <form action="procesar_editar_servicio.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="idServicio" value="<?php echo htmlspecialchars($servicio['idServicio']); ?>">
      <div class="mb-3">
        <label for="nombreServicio" class="form-label">Nombre del Servicio</label>
        <input type="text" class="form-control" id="nombreServicio" name="nombreServicio" value="<?php echo htmlspecialchars($servicio['nombreServicio']); ?>" required>
      </div>
      <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php echo htmlspecialchars($servicio['descripcion']); ?></textarea>
      </div>
      <div class="mb-3">
        <label for="precio" class="form-label">Precio</label>
        <input type="number" class="form-control" id="precio" name="precio" value="<?php echo htmlspecialchars($servicio['precio']); ?>" step="0.01" required>
      </div>
      <div class="mb-3">
        <label for="horas" class="form-label">Horas</label>
        <input type="number" class="form-control" id="horas" name="horas" value="<?php echo htmlspecialchars($servicio['horas']); ?>" required>
      </div>
      <div class="mb-3">
        <label for="sueldo" class="form-label">Sueldo</label>
        <input type="number" class="form-control" id="sueldo" name="sueldo" value="<?php echo htmlspecialchars($servicio['sueldo']); ?>" step="0.01" required>
      </div>
      <div class="mb-3">
        <label for="fotoServicio" class="form-label">Foto del Servicio</label>
        <input type="file" class="form-control" id="fotoServicio" name="fotoServicio">
      </div>
      <button type="submit" class="btn btn-primary">Guardar Cambios</button>
      <a href="misServicios.php" class="btn btn-secondary">Cancelar</a>
    </form>
  </div>
</body>
</html>