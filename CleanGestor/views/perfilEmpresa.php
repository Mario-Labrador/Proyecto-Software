<?php
// perfilEmpresa.php
// Mario Labrador
session_start();
include_once '../DAO/EmpresaDAO.php';
include_once '../DAO/SolicitudDAO.php';

// Redirigir si no hay sesión activa
if (!isset($_SESSION['dni'])) {
  header("Location: login.php");
  exit();
}

// Datos del usuario
$dni = $_SESSION['dni'];
$tipoUsuario = $_SESSION['tipo_usuario'] ?? '';
$rol = $_SESSION['rol'] ?? null;
$idEmpresaUsuario = $_SESSION['idEmpresa'] ?? null;

// Empresa que se está consultando
$idEmpresa = $_GET['id'] ?? null;
if (!$idEmpresa) {
  echo "ID de empresa no proporcionado.";
  exit();
}

$empresaDAO = new EmpresaDAO();
$solicitudDAO = new SolicitudDAO();
$empresa = $empresaDAO->getEmpresaById($idEmpresa);

if (!$empresa) {
  echo "Empresa no encontrada.";
  exit();
}

// Comprobar si el trabajador ya ha solicitado empleo en esta empresa
$yaSolicito = $solicitudDAO->yaHaSolicitado($dni, $idEmpresa);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Perfil Empresa | CLEAN GESTOR</title>
  <link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Estilos -->
  <link rel="stylesheet" href="../assets/css/bootstrap.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="../assets/css/responsive.css?v=<?php echo time(); ?>">
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
        <div class="profile-card animate__animated animate__fadeInUp">
          <div class="text-center">
          <div class="profile-icon-container mb-2">
            <i class="fa-solid fa-building fa-3x"></i>
          </div>
            <h2 class="mt-3"><?php echo htmlspecialchars($empresa->getNombreEmpresa()); ?></h2>
            <p class="text-muted mb-2">Empresa registrada</p>
          </div>
          <hr>
          <div class="profile-info mt-4">
            <div class="row mb-2">
              <div class="col-md-6">
                <label><strong>ID de Empresa</strong></label>
                <p><?php echo htmlspecialchars($empresa->getIdEmpresa()); ?></p>
              </div>
              <div class="col-md-6">
                <label><strong>Nombre</strong></label>
                <p><?php echo htmlspecialchars($empresa->getNombreEmpresa()); ?></p>
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-md-6">
                <label><strong>Teléfono</strong></label>
                <p><?php echo htmlspecialchars($empresa->getTelefonoEmpresa()); ?></p>
              </div>
              <div class="col-md-6">
                <label><strong>Dirección</strong></label>
                <p><?php echo htmlspecialchars($empresa->getDireccion()); ?></p>
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-md-6">
                <label><strong>Correo del Director</strong></label>
                <p><?php echo htmlspecialchars($empresa->getCorreoDirector()); ?></p>
              </div>
            </div>
          </div>
          <hr>
          <?php if ($tipoUsuario === 'trabajador' && !$yaSolicito): ?>
                <form action="enviar_solicitud.php" method="post" class="text-center">
                <input type="hidden" name="idEmpresa" value="<?php echo htmlspecialchars($idEmpresa); ?>">
                <button type="submit" class="btn btn-success mt-2">Enviar solicitud de empleo</button>
                </form>
          <?php elseif ($yaSolicito): ?>
            <p class="text-warning text-center mt-3">Ya has enviado una solicitud a esta empresa.</p>
          <?php endif; ?>
        </div>
      </div>
    </section>
  </div>
</body>
</html>
