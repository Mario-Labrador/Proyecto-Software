<?php
session_start();
if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit();
}

include_once '../config/db.php';
include_once '../DAO/PersonaDAO.php';

$personaDAO = new PersonaDAO();
$persona = $personaDAO->getPersonaByDni($_SESSION['dni']);

$errores = [];
$exito = '';
$foto_perfil = $persona->getFotoPerfil();

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $apellidos = trim($_POST['apellidos'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $fechaNacimiento = trim($_POST['fecha_nacimiento'] ?? '');

    // Validaciones básicas
    if ($nombre === '') $errores[] = "El nombre es obligatorio.";
    if ($apellidos === '') $errores[] = "Los apellidos son obligatorios.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "El email no es válido.";
    if ($telefono === '') $errores[] = "El teléfono es obligatorio.";
    if ($fechaNacimiento === '') $errores[] = "La fecha de nacimiento es obligatoria.";

    $errores = [];
    if ($nombre === '') $errores['nombre'] = "El nombre es obligatorio.";
    if ($apellidos === '') $errores['apellidos'] = "Los apellidos son obligatorios.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores['email'] = "El email no es válido.";
    if ($telefono === '') $errores['telefono'] = "El teléfono es obligatorio.";
    if ($fechaNacimiento === '') $errores['fecha_nacimiento'] = "La fecha de nacimiento es obligatoria.";

    // Comprobar duplicados
    if (trim((string)$email) !== trim((string)$persona->getEmailPersona())) {
        if ($personaDAO->existeEmail($email)) {
            $errores['email'] = "El correo electrónico ya está registrado por otro usuario.";
        }
    }
    if (trim((string)$telefono) !== trim((string)$persona->getTelefono())) {
        if ($personaDAO->existeTelefono($telefono)) {
            $errores['telefono'] = "El número de teléfono ya está registrado por otro usuario.";
        }
    }

    // Procesar subida de foto si se envió
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['foto_perfil']['tmp_name'];
        $nombre_archivo = uniqid() . '_' . basename($_FILES['foto_perfil']['name']);
        $ruta_destino = "../assets/uploads/" . $nombre_archivo;

        $info = getimagesize($tmp_name);
        if ($info === false) {
            $errores[] = "El archivo subido no es una imagen válida.";
        } elseif ($_FILES['foto_perfil']['size'] > 2 * 1024 * 1024) {
            $errores[] = "La imagen no puede superar los 2MB.";
        } else {
            if (move_uploaded_file($tmp_name, $ruta_destino)) {
                $foto_perfil = $ruta_destino;
            } else {
                $errores[] = "Error al subir la foto de perfil.";
            }
        }
    }

    // Si no hay errores, actualizar
    if (empty($errores)) {
        $fechaNacimientoSQL = date('Y-m-d', strtotime(str_replace('/', '-', $fechaNacimiento)));
        $persona->setNombrePersona($nombre);
        $persona->setApellidosPersona($apellidos);
        $persona->setEmailPersona($email);
        $persona->setTelefono($telefono);
        $persona->setFechaNacimiento($fechaNacimientoSQL);
        $persona->setFotoPerfil($foto_perfil);

        $personaDAO->updatePersona($persona);

        // Actualiza la sesión
        $_SESSION['nombre'] = $nombre;
        $_SESSION['apellidos'] = $apellidos;
        $_SESSION['email'] = $email;
        $_SESSION['telefono'] = $telefono;
        $_SESSION['fechaNacimiento'] = $fechaNacimientoSQL;
        $_SESSION['foto_perfil'] = $foto_perfil;

        $exito = "Perfil actualizado correctamente.";
        // Recarga datos actualizados
        $persona = $personaDAO->getPersonaByDni($_SESSION['dni']);
    }
} else {
    // Valores iniciales
    $nombre = $persona->getNombrePersona();
    $apellidos = $persona->getApellidosPersona();
    $email = $persona->getEmailPersona();
    $telefono = $persona->getTelefono();
    $fechaNacimiento = $persona->getFechaNacimiento();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif" />
<title>Editar Perfil | CLEAN GESTOR</title>

<!-- Estilos CSS -->
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
        <div class="profile-card animate__animated animate__fadeInUp">
        <div class="text-center">
            <!-- Mostrar la imagen de perfil o la predeterminada -->
            <h2 class="mt-3">Editar Perfil</h2>
            <hr>
            <img src="<?php echo !empty($foto_perfil) ? $foto_perfil : '../assets/uploads/default.png'; ?>" 
                alt="Foto de perfil" 
                class="profile-image mb-2" 
                style="max-height: 200px; border-radius: 50%;">
        </div>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group text-center">
            <label for="foto_perfil" class="btn btn-primary mb-3">
                <i class="fa fa-camera"></i> Cambiar foto de perfil
            </label>
            <input type="file" name="foto_perfil" id="foto_perfil" class="d-none" accept="image/*">
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control" 
                                value="<?= htmlspecialchars($nombre) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Apellidos</label>
                        <input type="text" name="apellidos" class="form-control" 
                                value="<?= htmlspecialchars($apellidos) ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Correo electrónico</label>
                        <input type="email" name="email"
                            class="form-control <?= isset($errores['email']) ? 'is-invalid' : '' ?>"
                            value="<?= htmlspecialchars($email) ?>" required>
                        <?php if (isset($errores['email'])): ?>
                        <div class="invalid-feedback"><?= htmlspecialchars($errores['email']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" name="telefono"
                            class="form-control <?= isset($errores['telefono']) ? 'is-invalid' : '' ?>"
                            value="<?= htmlspecialchars($telefono) ?>" required>
                        <?php if (isset($errores['telefono'])): ?>
                        <div class="invalid-feedback"><?= htmlspecialchars($errores['telefono']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Fecha de nacimiento</label>
                <input type="date" name="fecha_nacimiento" class="form-control"
                        value="<?= htmlspecialchars($fechaNacimiento) ?>" required>
            </div>

            <?php if ($exito): ?>
                <div class="alert alert-success animate__animated animate__headShake mb-4">
                <?= $exito ?>
                </div>
            <?php endif; ?>

            <?php if ($errores): ?>
                <div class="alert alert-danger animate__animated animate__headShake mb-4">
                    <ul class="mb-0">
                        <?php foreach ($errores as $e): ?>
                            <li><?= htmlspecialchars($e) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Guardar cambios
                </button>
                <a href="perfil.php" class="btn btn-secondary">
                    <i class="fa fa-times"></i> Volver al perfil
                </a>
            </div>
        </form>
        </div>
    </div>
    </section>
</div>

<script src="../assets/js/jquery-3.4.1.min.js"></script>
<script src="../assets/js/bootstrap.js"></script>
</body>
</html>
