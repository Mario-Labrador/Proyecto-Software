<?php
// servicios_asignados.php
// Mario Recio
include_once '../config/db.php';
include_once '../DAO/PersonaDAO.php';

if (session_status() === PHP_SESSION_NONE) session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['dni']) || $_SESSION['tipo_usuario'] !== 'trabajador' || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php"); // Redirigir al login si no es administrador
    exit();
}

// Obtener el DNI del trabajador desde la URL
$dniTrabajador = $_GET['dni'] ?? null;
if (!$dniTrabajador) {
    die("Error: No se ha especificado un trabajador.");
}

// Crear instancia de PersonaDAO
$personaDAO = new PersonaDAO();
$nombreTrabajador = $personaDAO->getNombrePorDni($dniTrabajador);
$apellidoTrabajador = $personaDAO->getApellidoPorDni($dniTrabajador);
$fotoTrabajador = $personaDAO->getFotoPerfilPorDni($dniTrabajador);

// Conexión directa a la base de datos para evitar problemas con $conn global
$conexion = new mysqli("localhost", "root", "", "gestor");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta para obtener los servicios asignados al trabajador
$sql = "SELECT c.idContrato, s.idServicio, s.nombreServicio, s.descripcion, s.precio, s.horas, 
               e.nombreEmpresa, s.fotoServicio, 
               p.nombrePersona AS nombre_cliente, p.apellidosPersona AS apellidos_cliente
        FROM contratoservicio cs
        JOIN servicio s ON cs.idServicio = s.idServicio
        JOIN empresa e ON s.idEmpresa = e.idEmpresa
        JOIN contrato c ON cs.idContrato = c.idContrato
        JOIN persona p ON c.dni = p.dni
        WHERE cs.dni = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $dniTrabajador);
$stmt->execute();
$resultado = $stmt->get_result();
$servicios = [];
while ($row = $resultado->fetch_assoc()) {
    $servicios[] = $row;
}
$stmt->close();
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif" />
  <title>Servicios Asignados | CLEAN GESTOR</title>
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css?v=<?php echo time(); ?>" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link href="../assets/css/style.css?v=<?php echo time(); ?>" rel="stylesheet" />
  <link href="../assets/css/responsive.css?v=<?php echo time(); ?>" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body class="sub_page">
  <div class="hero_area">
    <header class="header_section">
      <div class="container-fluid">
        <?php include_once("navbar.php"); ?>
      </div>
    </header>

    <section class="profile-section">
        <div class="container">
            <div class="row">
                <div class="profile-card animate__animated animate__fadeInUp">
                    <div class="text-center mb-4">
                        <div class="d-flex justify-content-center align-items-center mb-3">
                            <img src="<?php echo htmlspecialchars($fotoTrabajador); ?>" 
                                alt="Foto de perfil" 
                                class="rounded-circle"
                                style="width: 80px; height: 80px; object-fit: cover; margin-right: 15px;">
                            <div class="text-left">
                                <h3 class="mt-0 mb-1">Servicios asignados a:</h3>
                                <h4 class="text-primary"><?php echo htmlspecialchars($nombreTrabajador . ' ' . $apellidoTrabajador); ?></h4>
                                <p class="text-muted mb-0">DNI: <?php echo htmlspecialchars($dniTrabajador); ?></p>
                            </div>
                        </div>
                        <hr>
                        
                        <?php if (!empty($servicios)): ?>
                            <div class="list-group">
                                <?php foreach ($servicios as $servicio): ?>
                                    <div class="d-flex align-items-center list-group-item list-group-item-action py-3"
                                        style="transition: all 0.3s ease; border-left: 4px solid #0275d8; margin-bottom: 10px;">
                                        <!-- Columna idContrato -->
                                        <div class="text-center" style="width: 150px; font-weight: bold;">
                                            ID Servicio: <?php echo htmlspecialchars($servicio['idServicio']); ?><br>
                                            ID Contrato: <?php echo htmlspecialchars($servicio['idContrato']); ?>
                                        </div>
                                        <!-- Imagen -->
                                        <div class="flex-shrink-0" style="margin-right: 15px;">
                                            <img 
                                                src="<?php echo !empty($servicio['fotoServicio']) ? htmlspecialchars($servicio['fotoServicio']) : '../assets/images/default_service.png'; ?>" 
                                                alt="Imagen del servicio" 
                                                class="rounded-circle"
                                                style="width: 60px; height: 60px; object-fit: cover;">
                                        </div>
                                        <!-- Info principal -->
                                        <div class="flex-grow-1 d-flex justify-content-between align-items-center">
                                            <div>
                                                <h5 class="fw-bold mb-2"><?php echo htmlspecialchars($servicio['nombreServicio']); ?></h5>
                                                <div><strong>Duración:</strong> <?php echo htmlspecialchars($servicio['horas']); ?> horas</div>
                                                <div><strong>Precio:</strong> <?php echo htmlspecialchars($servicio['precio']); ?>€</div>
                                            </div>
                                            <div>
                                                <strong>Cliente:</strong> <?php echo htmlspecialchars($servicio['nombre_cliente'] . ' ' . $servicio['apellidos_cliente']); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>  
                        <?php else: ?>
                            <div class="alert alert-info">
                                <p class="mb-0">Este trabajador no tiene servicios asignados actualmente.</p>
                            </div>
                        <?php endif; ?>
                        
                        <div class="mt-4">
                            <a href="javascript:history.back()" class="btn btn-secondary">Volver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
