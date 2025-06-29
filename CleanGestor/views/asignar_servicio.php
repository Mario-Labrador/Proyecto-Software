<?php
//Mario Labrador
// asignar_servicio.php
if (session_status() === PHP_SESSION_NONE) session_start();

include_once '../config/db.php'; 

if (!isset($_SESSION['dni']) || $_SESSION['tipo_usuario'] !== 'trabajador' || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php"); // Redirigir al login si no es administrador
    exit();
}

$dni_empresario = $_SESSION['dni'];

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
$sql = "SELECT cs.idContrato, cs.idServicio, s.nombreServicio as nombre_servicio, cs.dni
        FROM contratoservicio cs
        INNER JOIN servicio s ON cs.idServicio = s.idServicio
        WHERE s.idEmpresa = ? AND cs.dni IS NULL";
        
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idEmpresa);
$stmt->execute();
$resultado = $stmt->get_result();


// Almacenar los servicios en un array
$servicios = [];
while ($fila = $resultado->fetch_assoc()) {
    $servicios[] = $fila;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif" />
    <title>Asignación contratos | CLEAN GESTOR</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css" />
    <link href="../assets/css/style.css" rel="stylesheet" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link href="../assets/css/responsive.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .list-group-item {
            margin-bottom: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .no-asignado {
            color: #e74c3c;
            font-style: italic;
        }
        .btn-asignar {
            background-color: #27ae60;
            color: #fff;
            border-radius: 5px;
            padding: 6px 14px;
            font-size: 0.95rem;
        }
        .btn-asignar:hover {
            background-color: #219150;
            color: #fff;
        }
        .card-title {
            font-weight: 700;
            font-size: 1.2rem;
        }
        .card-subtitle {
            font-size: 1rem;
            color: #888;
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
  <?php include_once("carrito_flotante.php"); ?>

  <div class="container" style="max-width: 900px; margin-top: 50px;">
    <div class="mb-5 text-center">
      <h2 class="fw-bold">Asignación de contratos</h2>
      <p>
        Aquí puedes ver los contratos de servicios de tu empresa y asignar empleados.
      </p>
    </div>

    <?php if (count($servicios) > 0): ?>
        <ul class="list-group animate__animated animate__fadeInUp">
        <?php foreach ($servicios as $row): ?>
          <li class="list-group-item">
            <div class="row align-items-center">
              <div class="col-12 col-md-8">
                <div class="card-title mb-1">
                  <i class="fa-solid fa-file-contract me-2"></i>
                  Contrato <?php echo htmlspecialchars($row['idContrato']); ?>
                </div>
                <div class="card-subtitle mb-2 text-muted">
                  <i class="fa-solid fa-briefcase me-1"></i>
                  Servicio: <b><?php echo htmlspecialchars($row['nombre_servicio']); ?></b>
                </div>
                <div>
                  <i class="fa-solid fa-user me-1"></i>
                  Empleado asignado:
                  <?php if ($row['dni']): ?>
                    <span><?php echo htmlspecialchars($row['dni']); ?></span>
                  <?php else: ?>
                    <span class="no-asignado">No asignado</span>
                  <?php endif; ?>
                </div>
              </div>
              <div class="col-12 col-md-4 text-md-right mt-3 mt-md-0">
                <a href="asignar_empleado.php?idContrato=<?= $row['idContrato'] ?>&idServicio=<?= $row['idServicio'] ?>" class="btn btn-asignar">
                  <i class="fa-solid fa-user-plus me-1"></i> Asignar Empleado
                </a>
              </div>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p class="text-center mt-5">No hay contratos de servicios disponibles para su empresa.</p>
    <?php endif; ?>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
