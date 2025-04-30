<?php
// asignar_empleado.php

session_start();
include_once '../config/db.php';
include_once '../DAO/EmpresaDAO.php';
include_once '../DAO/PersonaDAO.php';
include_once '../VO/TrabajadorVO.php';

// Verificar permisos y sesión
if (
    !isset($_SESSION['dni']) ||
    $_SESSION['tipo_usuario'] !== 'trabajador' ||
    $_SESSION['rol'] !== 'administrador'
) {
    header("Location: login.php");
    exit();
}

// Obtener y validar parámetros
$idContrato = isset($_GET['idContrato']) ? intval($_GET['idContrato']) : null;
$idServicio = isset($_GET['idServicio']) ? intval($_GET['idServicio']) : null;

if (!$idContrato || !$idServicio) {
    header("Location: asignacion_servicios.php?error=Parámetros inválidos");
    exit();
}

// Obtener empresa del usuario
$idEmpresa = $_SESSION['idEmpresa'] ?? null;
if (!$idEmpresa) {
    die("Error: Empresa no encontrada");
}

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "gestor");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Verificar que el contrato y servicio existen y pertenecen a la empresa
$query = "SELECT cs.*, s.nombreServicio 
          FROM contratoservicio cs
          JOIN servicio s ON cs.idServicio = s.idServicio
          WHERE cs.idContrato = ? AND cs.idServicio = ? AND s.idEmpresa = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("iii", $idContrato, $idServicio, $idEmpresa);
$stmt->execute();
$result = $stmt->get_result();
$contrato = $result->fetch_assoc();

if (!$contrato) {
    header("Location: asignacion_servicios.php?error=Contrato o servicio no encontrado");
    exit();
}

// Obtener trabajadores disponibles
$empresaDAO = new EmpresaDAO();
$trabajadores = $empresaDAO->getTrabajadoresPorEmpresa($idEmpresa);
$personaDAO = new PersonaDAO();

$error = null;

// Procesar asignación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dniEmpleado = $_POST['dni_empleado'] ?? null;

    if ($dniEmpleado) {
        $update = $conexion->prepare("UPDATE contratoservicio 
                                      SET dni = ? 
                                      WHERE idContrato = ? AND idServicio = ?");
        $update->bind_param("sii", $dniEmpleado, $idContrato, $idServicio);

        if ($update->execute()) {
            header("Location: asignacion_confirmada.php");
            exit();
        } else {
            $error = "Error al asignar el empleado: " . $conexion->error;
        }
    } else {
        $error = "Debe seleccionar un empleado";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif" />
    <title>Asignar Empleado | CLEAN GESTOR</title>
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

  <div class="container" style="max-width: 900px; margin-top: 50px;">
    <div class="mb-5 text-center">
      <h2 class="fw-bold">Asignar Empleado al Servicio</h2>
      
      <div class="contract-info animate__animated animate__fadeIn">
        <h4>Contrato #<?= htmlspecialchars($contrato['idContrato']) ?></h4>
        <p class="mb-1"><strong>Servicio:</strong> <?= htmlspecialchars($contrato['nombreServicio']) ?></p>
        <p><strong>ID Servicio:</strong> <?= htmlspecialchars($contrato['idServicio']) ?></p>
      </div>

      <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>

      <h4 class="mb-4">Seleccionar Trabajador</h4>
      
      <?php if (!empty($trabajadores)): ?>
        <form method="POST">
          <ul class="list-group animate__animated animate__fadeInUp">
            <?php foreach ($trabajadores as $trabajador): 
              if ($trabajador->getRol() !== 'empleado') continue;
              $foto = $personaDAO->getFotoPerfilPorDni($trabajador->getDni());
              $nombre = $personaDAO->getNombrePorDni($trabajador->getDni());
              $apellidos = $personaDAO->getApellidoPorDni($trabajador->getDni());
            ?>
              <li class="list-group-item">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <input type="radio" name="dni_empleado" 
                           value="<?= htmlspecialchars($trabajador->getDni()) ?>" 
                           id="empleado_<?= htmlspecialchars($trabajador->getDni()) ?>" required>
                  </div>
                  <div class="col-auto" style="width:80px;">
                    <img src="<?= htmlspecialchars($foto) ?>" 
                         alt="Foto perfil" 
                         style="width:70px; height:70px; object-fit:cover; border-radius:50%;">
                  </div>
                  <div class="col">
                    <label for="empleado_<?= htmlspecialchars($trabajador->getDni()) ?>" class="mb-0">
                      <strong><?= htmlspecialchars($nombre . ' ' . $apellidos) ?></strong><br>
                      <small class="text-muted">DNI: <?= htmlspecialchars($trabajador->getDni()) ?></small>
                    </label>
                  </div>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
          <div class="text-center mt-4">
            <button type="submit" class="btn btn-success btn-lg">
              <i class="fa fa-check-circle me-2"></i>Asignar Empleado
            </button>
            <a href="asignacion_servicios.php" class="btn btn-secondary btn-lg">Cancelar</a>
          </div>
        </form>
      <?php else: ?>
        <div class="alert alert-warning">No hay trabajadores disponibles para asignar</div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
