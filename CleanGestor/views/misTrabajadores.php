<?php

include_once '../config/db.php'; 
include_once '../DAO/EmpresaDAO.php';
include_once '../DAO/PersonaDAO.php';  // Incluye el PersonaDAO
include_once '../VO/TrabajadorVO.php';

if (session_status() === PHP_SESSION_NONE) session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['dni']) || $_SESSION['tipo_usuario'] !== 'trabajador' || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php"); // Redirigir al login si no es administrador
    exit();
}

// Obtener el idEmpresa desde la sesión
$idEmpresa = $_SESSION['idEmpresa'] ?? null;
if (!$idEmpresa) {
    die("Error: No se pudo determinar la empresa asociada al administrador.");
}

// Crear una instancia de EmpresaDAO
$empresaDAO = new EmpresaDAO();

// Obtener los trabajadores asociados a la empresa
$trabajadores = $empresaDAO->getTrabajadoresPorEmpresa($idEmpresa);

// Crear una instancia de PersonaDAO para obtener la foto de perfil y nombre
$personaDAO = new PersonaDAO();

// Inicializar un array para almacenar trabajadores con foto y nombre
$trabajadoresConFoto = [];

// Obtener la foto de perfil y nombre de cada trabajador
foreach ($trabajadores as $trabajador) {
    $dniTrabajador = $trabajador->getDni();
    if ($trabajador->getRol() === 'administrador') {
        continue; // Si es administrador, saltar al siguiente trabajador
    }

    // Obtener foto de perfil y nombre
    $fotoPerfil = $personaDAO->getFotoPerfilPorDni($dniTrabajador);
    $nombre = $personaDAO->getNombrePorDni($dniTrabajador);
    $apellido = $personaDAO->getApelldioPorDni($dniTrabajador);

    // Agregar los datos al array
    $trabajadoresConFoto[] = [
        'foto_perfil' => $fotoPerfil,
        'nombre' => $nombre,
        'dni' => $trabajador->getDni(),
        'apellido' => $apellido
        
    ];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Site Metas -->
  <link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Trabajadores - CLEAN GESTOR</title>

  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css" />
  <link href="../assets/css/font-awesome.min.css" rel="stylesheet" />
  <link href="../assets/css/style.css" rel="stylesheet" />
  <link href="../assets/css/responsive.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <!-- Google Fonts: Montserrat -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>

<body class="sub_page">
  <div class="hero_area">
    <!-- header section starts -->
    <header class="header_section">
      <div class="container-fluid">
        <?php include_once("navbar.php"); ?>
      </div>
    </header>
    <!-- header section ends -->
  </div>

  <!-- Trabajadores Section -->
  <section class="service_section layout_padding">
    <div class="container">
      <div class="mb-5 text-center">
        <h2 class="fw-bold">Trabajadores Asociados</h2>
        <p>
          Aquí puedes ver los trabajadores asociados a tu empresa.
        </p>
      </div>

      <!-- Contenido de los trabajadores -->
      <div class="row">
        <?php if (!empty($trabajadoresConFoto)): ?>
          <ul class="list-group">
            <?php foreach ($trabajadoresConFoto as $trabajador): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                  <!-- Mostrar foto de perfil -->
                  <img src="<?php echo htmlspecialchars($trabajador['foto_perfil']); ?>" 
                       alt="Foto de perfil" 
                       class="rounded-circle" 
                       style="max-width: 50px; max-height: 50px; margin-right: 15px;">
                  <div class="mr-4">
                    <strong>DNI:</strong> <?php echo htmlspecialchars($trabajador['dni']); ?>
                  </div>
                  <div class="mr-4">
                    <strong>Nombre:</strong> <?php echo htmlspecialchars($trabajador['nombre']); ?>
                  </div>
                  <div class="mr-4">
                    <strong>Apellido:</strong> <?php echo htmlspecialchars($trabajador['apellido']); ?>
                  </div>
                  
                </div>
                <!-- Enlace para editar trabajador -->
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?>
          <div class="col-md-12">
            <p class="text-center">No hay trabajadores asociados a esta empresa.</p>
          </div>
        <?php endif; ?>
      </div>

    </div>
  </section>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
