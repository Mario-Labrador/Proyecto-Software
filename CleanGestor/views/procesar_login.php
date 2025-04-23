<?php
session_start();

include_once '../config/db.php';
include_once '../DAO/PersonaDAO.php';
include_once '../DAO/TrabajadorDAO.php';
include_once '../DAO/ClienteDAO.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

try {
    $pdo = Database::connect();
    $personaDAO = new PersonaDAO();
    $persona = $personaDAO->getPersonaByEmail($email);

    if (!$persona) {
        $_SESSION['error_type'] = 'email_no_existe';
        unset($_SESSION['preserved_email']);
        header("Location: login.php");
        exit();
    }

    if (!password_verify($password, $persona->getContrasenyaPersona())) {
        $_SESSION['error_type'] = 'password_incorrecta';
        $_SESSION['preserved_email'] = $email;
        header("Location: login.php");
        exit();
    }   

    $clienteDAO = new ClienteDAO();
    $trabajadorDAO = new TrabajadorDAO();

    $tipoUsuario = '';
    $rol = '';

    if ($clienteDAO->esCliente($persona->getDni())) {
        $tipoUsuario = 'cliente';
    } elseif ($trabajadorDAO->esTrabajador($persona->getDni())) {
        $tipoUsuario = 'trabajador';
        $trabajador = $trabajadorDAO->getTrabajadorByDni($persona->getDni());
        $rol = $trabajador->getRol();
        $idEmpresa = $trabajador->getIdEmpresa();
    } else {
        $_SESSION['error_type'] = 'sin_rol';
        header("Location: login.php");
        exit();
    }

    // Guardar datos de sesión
    $_SESSION['dni'] = $persona->getDni();
    $_SESSION['nombre'] = $persona->getNombrePersona();
    $_SESSION['apellidos'] = $persona->getApellidosPersona();
    $_SESSION['email'] = $persona->getEmailPersona();
    $_SESSION['telefono'] = $persona->getTelefono();
    $_SESSION['fechaNacimiento'] = $persona->getFechaNacimiento();
    $_SESSION['tipo_usuario'] = $tipoUsuario;
    $_SESSION['rol'] = $rol;
    $_SESSION['foto_perfil'] = $persona->getFotoPerfil() ?? '../assets/uploads/default.png';

    // Redirigir según el tipo de usuario
    if ($tipoUsuario === 'trabajador') {
        $_SESSION['idEmpresa'] = $idEmpresa;

        // Verificar si el trabajador es administrador
        if ($rol === 'administrador') {
            header("Location: perfilAdministrador.php");  // Redirigir a perfil administrador
        } else {
            header("Location: perfilTrabajador.php");  // Redirigir a perfil trabajador
        }
    } else {
        header("Location: perfil.php");  // Redirigir a perfil de cliente
    }
    exit();

} catch (Exception $e) {    
    $_SESSION['error_type'] = 'error_general';
    $_SESSION['error_message'] = $e->getMessage();
    header("Location: login.php");
    exit();
}
