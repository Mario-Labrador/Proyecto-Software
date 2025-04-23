<?php
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
          <!-- Columna izquierda: Información del perfil -->
          <div class="col-md-6">
            <div class="profile-card animate__animated animate__fadeInUp">
              <div class="text-center">
                <!-- Mostrar la imagen de perfil o la predeterminada -->
                <img src="<?php echo !empty($foto_perfil) ? $foto_perfil : '../assets/uploads/default.png'; ?>" 
                     alt="Foto de perfil" 
                     class="profile-image mb-2" 
                     style="max-height: 200px; border-radius: 50%;">
                <h2 class="mt-3"><?php echo htmlspecialchars($nombre . ' ' . $apellidos); ?></h2>
                <p class="text-muted mb-2"><?php echo ucfirst($tipo); ?> <?php echo $rol ? "($rol)" : ''; ?></p>
                <div class="profile-actions">
                  <a href="editar_perfil.php" class="btn btn-primary"><i class="fa fa-pencil"></i> Editar Perfil</a>
                  <a href="logout.php" class="btn btn-danger"><i class="fa fa-sign-out"></i> Cerrar Sesión</a>
                </div>
              </div>
              <hr>
              <div class="profile-info mt-4">
                <div class="row">
                  <div class="col-md-6"><label>Correo electrónico</label><p><?php echo htmlspecialchars($email); ?></p></div>
                  <div class="col-md-6"><label>Teléfono</label><p><?php echo htmlspecialchars($telefono); ?></p></div>
                  <div class="col-md-6"><label>DNI/NIF</label><p><?php echo htmlspecialchars($dni); ?></p></div>
                  <div class="col-md-6"><label>Fecha de nacimiento</label><p><?php echo htmlspecialchars(date('d/m/Y', strtotime($fechaNacimiento))); ?></p></div>
                </div>
              </div>
              <hr>    
            </div>
          </div>

          <!-- Columna derecha: Información de la empresa -->
          <div class="col-md-6">
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
                      <div class="col-md-6">
                        <div class="card service-card h-100" style="background:#0275d8; color:#fff; border:none;">
                          <div class="card-body">
                            <h5 class="card-title fw-bold"><?php echo htmlspecialchars($empresa['nombreEmpresa']); ?></h5>
                            <p class="card-text">Teléfono: <?php echo htmlspecialchars($empresa['telefonoEmpresa']); ?></p>
                            <p class="card-text">Dirección: <?php echo htmlspecialchars($empresa['direccion']); ?></p>
                          </div>
                        </div>
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