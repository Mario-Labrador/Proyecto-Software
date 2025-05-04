<?php
session_start();

include_once '../DAO/EmpresaDAO.php';

if (!isset($_SESSION['dni'])) {
  header("Location: login.php");
  exit();
}

$dni = $_SESSION['dni'] ?? '';
$nombre = $_SESSION['nombre'] ?? '';
$apellidos = $_SESSION['apellidos'] ?? '';
$email = $_SESSION['email'] ?? '';
$telefono = $_SESSION['telefono'] ?? '';
$fechaNacimiento = $_SESSION['fechaNacimiento'] ?? '';
$tipo = $_SESSION['tipo_usuario'] ?? '';
$rol = $_SESSION['rol'] ?? '';
$foto_perfil = $_SESSION['foto_perfil'] ?? '';

$conexion = new mysqli("localhost", "root", "", "gestor");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

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
$stmt->bind_param("s", $dni);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif" />
  <title>Servicios Pendientes | CLEAN GESTOR</title>
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css?v=<?php echo time(); ?>" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link href="../assets/css/style.css?v=<?php echo time(); ?>" rel="stylesheet" />
  <link href="../assets/css/responsive.css?v=<?php echo time(); ?>" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
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
            <div class="row">
                <div class="profile-card animate__animated animate__fadeInUp">
                    <div class="text-center">
                        <h3 class="mt-3">Servicios pendientes asignados</h3>
                        <hr>
                        <?php if ($resultado->num_rows > 0): ?>
                            <div class="list-group">
                                <?php while ($servicio = $resultado->fetch_assoc()): ?>
                                    <div class="d-flex align-items-center list-group-item list-group-item-action py-3"
                                        style="transition: all 0.3s ease; border-left: 4px solid #0275d8; margin-bottom: 10px;">
                                        <!-- Columna idContrato -->
                                        <div class="text-center" style="width: 150px; font-weight: bold;">
                                            ID Servicio: <?php echo htmlspecialchars($servicio['idContrato']); ?>
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
                                            </div>
                                            <div>
                                                <strong>Cliente:</strong> <?php echo htmlspecialchars($servicio['nombre_cliente'] . ' ' . $servicio['apellidos_cliente']); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>  
                        <?php else: ?>
                            <p class="text-muted">No tienes servicios pendientes asignados.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
  </div>
</body>
</html>
