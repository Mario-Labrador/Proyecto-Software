<?php
session_start();

include_once '../DAO/EmpresaDAO.php';  // Incluir el DAO de Empresa
include_once '../DAO/TrabajadorDAO.php'; // Asegúrate de que este es el correcto
include_once '../DAO/PersonaDAO.php'; // Asegúrate de incluir la clase PersonaVO

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

// Obtener el origen de la navegación (valor por defecto: 'empleados')
$from = isset($_GET['from']) ? $_GET['from'] : 'empleados';

// Sanear y validar el valor
$allowed_from = ['ofertas', 'empleados'];
if (!in_array($from, $allowed_from)) {
    $from = 'empleados'; // Valor por defecto si no es válido
}

// Determinar la URL de retorno
switch ($from) {
    case 'ofertas':
        $url_retorno = 'solicitudes_empleo.php'; // Ajusta al nombre correcto de tu página de ofertas
        break;
    case 'empleados':
    default:
        $url_retorno = 'misTrabajadores.php';
}

// Obtener datos del trabajador
$trabajadorDAO = new TrabajadorDAO();
$trabajador = $trabajadorDAO->getTrabajadorByDni($dniTrabajador);

// Verificar que el trabajador existe
if (!$trabajador) {
    echo "El trabajador no existe.";
    exit();
}

// Obtener los datos de la persona asociada al trabajador
$personaDAO = new PersonaDAO(); // Asegúrate de tener un DAO para Persona
$persona = $personaDAO->getPersonaByDni($dniTrabajador); // Supongo que tienes un método en PersonaDAO para obtener la persona

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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


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
        <div class="profile-card animate__animated animate__fadeInUp">
          <div class="text-center">
            <!-- Imagen de perfil -->
            <img src="<?php echo !empty($persona->getFotoPerfil()) ? $persona->getFotoPerfil() : '../assets/uploads/default.png'; ?>" 
                  alt="Foto de perfil" 
                  class="profile-image mb-2" 
                  style="max-height: 200px; border-radius: 50%;">
            <h2 class="mt-3"><?php echo htmlspecialchars($persona->getNombrePersona() . ' ' . $persona->getApellidosPersona()); ?></h2>
            <div class="profile-actions">
                <a href="<?= htmlspecialchars($url_retorno) ?>" class="btn btn-primary">
                    <i class="fa fa-arrow-left"></i> Volver al perfil administrador
                </a>
            </div>

          </div>
          <hr>
          <div class="profile-info mt-4">
            <div class="row">
              <div class="col-md-6"><label>Correo electrónico</label><p><?php echo htmlspecialchars($persona->getEmailPersona()); ?></p></div>
              <div class="col-md-6"><label>Teléfono</label><p><?php echo htmlspecialchars($persona->getTelefono()); ?></p></div>
              <div class="col-md-6"><label>DNI/NIF</label><p><?php echo htmlspecialchars($persona->getDni()); ?></p></div>
              <div class="col-md-6"><label>Fecha de nacimiento</label><p><?php echo htmlspecialchars(date('d/m/Y', strtotime($persona->getFechaNacimiento()))); ?></p></div>
            </div>
          </div>
          <hr>
        </div>
      </div>
    </section>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
