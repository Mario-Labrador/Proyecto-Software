<?php
// buscar_empleo.php
// Mario Labrador 
session_start();

include_once '../DAO/EmpresaDAO.php'; // Incluir el DAO de Empresa

// Verificar si la sesión está activa
if (!isset($_SESSION['dni'])) {
  header("Location: login.php");
  exit();
}

// Obtener datos de la sesión
$dni = $_SESSION['dni'] ?? '';
$nombre = $_SESSION['nombre'] ?? '';
$apellidos = $_SESSION['apellidos'] ?? '';
$email = $_SESSION['email'] ?? '';
$telefono = $_SESSION['telefono'] ?? '';
$fechaNacimiento = $_SESSION['fechaNacimiento'] ?? '';
$tipo = $_SESSION['tipo_usuario'] ?? '';
$rol = $_SESSION['rol'] ?? '';
$foto_perfil = $_SESSION['foto_perfil'] ?? '';
$idEmpresa = $_SESSION['idEmpresa'] ?? null;

// Obtener el nombre de la empresa si el empleado pertenece a una
$empresaDAO = new EmpresaDAO();
$nombreEmpresa = $idEmpresa ? $empresaDAO->getEmpresaById($idEmpresa)->getNombreEmpresa() : null;

// Obtener todas las empresas si no pertenece a ninguna
$empresasDisponibles = !$idEmpresa ? $empresaDAO->getAllEmpresas() : [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif" />
  <title>Perfil Trabajador | CLEAN GESTOR</title>
  
  <!-- Estilos CSS -->
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css?v=<?php echo time(); ?>" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link href="../assets/css/style.css?v=<?php echo time(); ?>" rel="stylesheet" />
  <link href="../assets/css/responsive.css?v=<?php echo time(); ?>" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

  <!-- Mostrar errores PHP (solo en desarrollo) -->
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
            <div class="profile-card animate__animated animate__fadeInUp">
              <div class="text-center">
              <?php if ($nombreEmpresa): ?>
                <h3 class="mt-3">Ahora mismo perteneces a la empresa <?php echo htmlspecialchars($nombreEmpresa); ?></h3>
              <?php else: ?>
                <h3 class="mt-3">Ahora mismo no perteneces a ninguna empresa</h3>
                <hr>
                <h4>Empresas disponibles:</h4>
                <div class="row">
                  <?php foreach ($empresasDisponibles as $empresa): ?>
                    <div class="col-md-4 col-sm-6 mb-4">
                      <a href="perfilEmpresa.php?id=<?php echo htmlspecialchars($empresa['idEmpresa']); ?>" style="text-decoration: none;">
                        <div class="card service-card h-100 shadow-sm" style="background:#fff; color:#000; border:1px solid #ddd; cursor:pointer; border-radius: 10px;">
                          <div class="text-center p-3">
                            <?php if (!empty($empresa['logoEmpresa'])): ?>
                              <img 
                                src="<?php echo htmlspecialchars($empresa['logoEmpresa']); ?>" 
                                alt="Logo de la empresa" 
                                style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%; border:2px solid #0275d8;">
                            <?php else: ?>
                              <i class="fa-solid fa-building fa-3x" style="color:#0275d8;"></i>
                            <?php endif; ?>
                          </div>
                          <div class="card-body text-center">
                            <h5 class="card-title fw-bold mb-2"><?php echo htmlspecialchars($empresa['nombreEmpresa']); ?></h5>
                            <p class="card-text text-muted mb-1"><strong>Teléfono:</strong> <?php echo htmlspecialchars($empresa['telefonoEmpresa']); ?></p>
                            <p class="card-text text-muted"><strong>Dirección:</strong> <?php echo htmlspecialchars($empresa['direccion']); ?></p>
                          </div>
                        </div>
                      </a>
                    </div>
                  <?php endforeach; ?>
                </div>
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