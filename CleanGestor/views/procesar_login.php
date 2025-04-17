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
        $_SESSION['error_msg'] = "No se encontró un usuario con ese correo.";
        header("Location: error.php");
        exit();
    }

    // Verificar contraseña (asumiendo que está hasheada con password_hash)
    if (!password_verify($password, $persona->getContrasenyaPersona())) {
        $_SESSION['error_msg'] = "Contraseña incorrecta.";
        header("Location: error.php");
        exit();
    }   

    // Determinar el tipo de usuario (cliente o trabajador)
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
    } else {
        $_SESSION['error_msg'] = "Este usuario no tiene un rol asignado.";
        header("Location: error.php");
        exit();
    }

    // Guardar info en sesión
    $_SESSION['dni'] = $persona->getDni();
    $_SESSION['nombre'] = $persona->getNombrePersona();
    $_SESSION['email'] = $persona->getEmailPersona();
    $_SESSION['tipo_usuario'] = $tipoUsuario;
    $_SESSION['rol'] = $rol;
    $_SESSION['foto_perfil'] = $persona->getFotoPerfil();

    // Redirigir al perfil
    header("Location: perfil.php");
    exit();

} catch (Exception $e) {
    $_SESSION['error_msg'] = "Error al iniciar sesión: " . $e->getMessage();
    header("Location: error.php");
    exit();
}
