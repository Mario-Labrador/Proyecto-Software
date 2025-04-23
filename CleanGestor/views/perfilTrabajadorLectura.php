<?php
session_start();

include_once '../DAO/EmpresaDAO.php';  // Incluir el DAO de Empresa
include_once '../DAO/TrabajadorDAO.php'; // Asegúrate de que este es el correcto

// Verificar si la sesión está activa
if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit();
}

// Verificar que se pasó un DNI válido desde el perfil del administrador
if (!isset($_GET['dni'])) {
    echo "DNI no válido.";
    exit();
}

$dniTrabajador = $_GET['dni'];

// Obtener datos del trabajador
$trabajadorDAO = new TrabajadorDAO();
$trabajador = $trabajadorDAO->getTrabajadorByDni($dniTrabajador);

// Verificar que el trabajador existe
if (!$trabajador) {
    echo "El trabajador no existe.";
    exit();
}

// Obtener historial de empresas del trabajador
$empresaDAO = new EmpresaDAO();
$historialEmpresas = $empresaDAO->obtenerHistorialEmpresas($dniTrabajador);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif" />
  <title>Perfil Trabajador | CLEAN GESTOR</title>

  <!-- Estilos -->
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css?v=<?php echo time(); ?>" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link href="../assets/css/style.css?v=<?php echo time(); ?>" rel="stylesheet" />
  <link href="../assets/css/responsive.css?v=<?php echo time(); ?>" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

  <!-- Mostrar errores (desarrollo) -->
  <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
  ?>
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
          <!-- Columna izquierda: Información del perfil del trabajador -->
          <div class="col-md-6">
            <div class="profile-card animate__animated animate__fadeInUp">
              <div class="text-center">
                <!-- Imagen de perfil -->
                <img src="<?php echo !empty($trabajador->getFotoPerfil()) ? $trabajador->getFotoPerfil() : '../assets/uploads/default.png'; ?>" 
                     alt="Foto de perfil" 
                     class="profile-image mb-2" 
                     style="max-height: 200px; border-radius: 50%;">
                <h2 class="mt-3"><?php echo htmlspecialchars($trabajador->getNombre() . ' ' . $trabajador->getApellidos()); ?></h2>
                <p class="text-muted mb-2">
                  <?php echo ucfirst($trabajador->getTipoUsuario()); ?>
                  <?php echo $trabajador->getRol() ? '(' . htmlspecialchars($trabajador->getRol()) . ')' : ''; ?>
                </p>
                <div class="profile-actions">
                  <a href="perfilAdministrador.php" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Volver al perfil administrador</a>
                </div>
              </div>
              <hr>
              <div class="profile-info mt-4">
                <div class="row">
                  <div class="col-md-6"><label>Correo electrónico</label><p><?php echo htmlspecialchars($trabajador->getEmail()); ?></p></div>
                  <div class="col-md-6"><label>Teléfono</label><p><?php echo htmlspecialchars($trabajador->getTelefono()); ?></p></div>
                  <div class="col-md-6"><label>DNI/NIF</label><p><?php echo htmlspecialchars($trabajador->getDni()); ?></p></div>
                  <div class="col-md-6"><label>Fecha de nacimiento</label><p><?php echo htmlspecialchars(date('d/m/Y', strtotime($trabajador->getFechaNacimiento()))); ?></p></div>
                </div>
              </div>
              <hr>
            </div>
          </div>

          <!-- Columna derecha: Historial de empresas -->
          <div class="col-md-6">
            <div class="profile-card animate__animated animate__fadeInUp">
              <div class="text-center">
                <h3 class="mt-3">Historial de empresas</h3>
                <hr>
                <?php if (count($historialEmpresas) > 0): ?>
                  <ul>
                    <?php foreach ($historialEmpresas as $historial): ?>
                      <li>
                        <strong><?php echo htmlspecialchars($historial->getNombreEmpresa()); ?></strong>
                        - <?php echo htmlspecialchars($historial->getFechaContrato()); ?>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                <?php else: ?>
                  <p>No tienes historial de empresas.</p>
                <?php endif; ?>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
  </div>
</body>
</html>
