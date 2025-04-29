<?php
session_start();
include_once '../config/db.php'; 
include_once '../DAO/EmpresaDAO.php';
include_once '../DAO/SolicitudDAO.php';
include_once '../DAO/PersonaDAO.php';
include_once '../VO/TrabajadorVO.php';

// Verificar sesión y permisos
if (!isset($_SESSION['dni']) || $_SESSION['tipo_usuario'] !== 'trabajador' || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php");
    exit();
}

// Obtener datos de la sesión
$idEmpresa = $_SESSION['idEmpresa'] ?? null;
if (!$idEmpresa) {
    die("Error: No se pudo determinar la empresa asociada.");
}

// Instanciar DAOs
$empresaDAO = new EmpresaDAO();
$solicitudDAO = new SolicitudDAO();
$personaDAO = new PersonaDAO();

// Obtener datos de la empresa
$nombreEmpresa = $empresaDAO->getEmpresaById($idEmpresa)->getNombreEmpresa();

// Obtener solicitudes de empleo
$solicitudes = $solicitudDAO->obtenerSolicitudesPorEmpresa($idEmpresa);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif" />
  <title>Solicitudes de Empleo | CLEAN GESTOR</title>

  <!-- Estilos CSS -->
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="../assets/css/style.css" rel="stylesheet" />
  <link href="../assets/css/responsive.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>

<body class="sub_page">
    <div class="hero_area">
        <header class="header_section">
        <div class="container-fluid">
            <?php include_once("navbar.php"); ?>
        </div>
        </header>
    </div>
        <div class="profile-card animate__animated animate__fadeInUp" style="margin-top: 100px;">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="text-center">
                        <h3 class="mb-4">Administrador de <?= htmlspecialchars($nombreEmpresa) ?></h3>
                        <hr>
                        
                        <?php if (!empty($solicitudes)): ?>
                            <h4 class="mb-4">Solicitudes de empleo pendientes:</h4>
                            <div class="list-group">
                            <?php foreach ($solicitudes as $solicitud): 
                            $trabajador = $personaDAO->getPersonaByDni($solicitud->getDni());
                        ?>
                        <div class="list-group-item justify-content-between d-flex align-items-center">
                            <!-- Foto de perfil -->
                            <div class="avatar-container mr-3">
                                <?php if ($trabajador && $trabajador->getFotoPerfil()): ?>
                                    <img src="<?= htmlspecialchars($trabajador->getFotoPerfil()) ?>" 
                                    alt="Foto de perfil" 
                                    class="rounded-circle" 
                                    style="max-width: 50px; max-height: 50px; margin-right: 15px;">
                                <?php else: ?>
                                    <div class="avatar-default rounded-circle">
                                        <i class="fas fa-user"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Datos del solicitante -->
                            <div class="flex-grow-1">
                                <div class="d-flex flex-column">
                                <strong class="nombre-solicitante">
                                    <a href="perfilTrabajadorLectura.php?dni=<?= urlencode($solicitud->getDni()) ?>" 
                                    class="btn btn-link p-0 m-0 align-baseline" 
                                    style="font-weight: bold; font-size: 1.1em;">
                                        <?= $trabajador ? 
                                            htmlspecialchars($trabajador->getNombrePersona()." ".$trabajador->getApellidosPersona()) :
                                            "Usuario no encontrado" ?>
                                    </a> 
                                </strong>
                                    <small class="text-muted">
                                        DNI: <?= htmlspecialchars($solicitud->getDni()) ?>
                                    </small>
                                </div>
                            </div>
                            
                            <!-- Botones de acción -->
                            <div class="acciones">
                                <a href="aceptar_solicitud.php?id=<?= $solicitud->getId() ?>&accion=aceptar" 
                                class="btn btn-success btn-sm">
                                <i class="fas fa-check"></i> Aceptar
                                </a>
                                <a href="rechazar_solicitud.php?id=<?= $solicitud->getId() ?>" 
                                class="btn btn-danger btn-sm">
                                <i class="fas fa-times"></i> Rechazar
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>

                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                No hay solicitudes de empleo pendientes.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
</html>
