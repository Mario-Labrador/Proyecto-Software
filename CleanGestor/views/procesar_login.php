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
        throw new Exception("❌ No se encontró un usuario con ese correo.");
    }

    // Verificar contraseña (asumiendo que está hasheada con password_hash)
    if (!password_verify($password, $persona->getContrasenyaPersona())) {
        throw new Exception("❌ Contraseña incorrecta.");
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
        throw new Exception("❌ Este usuario no tiene un rol asignado.");
    }

    // Guardar info en sesión
    $_SESSION['dni'] = $persona->getDni();
    $_SESSION['nombre'] = $persona->getNombre();
    $_SESSION['email'] = $persona->getEmail();
    $_SESSION['tipo_usuario'] = $tipoUsuario;
    $_SESSION['rol'] = $rol;

    // Redirigir según tipo
    if ($tipoUsuario === 'cliente') {
        header("Location: ../cliente/dashboard_cliente.php");
    } else {
        header("Location: ../trabajador/dashboard_trabajador.php");
    }
    exit();

} catch (Exception $e) {
    // En caso de error, redirigir de nuevo al login con mensaje
    $_SESSION['error_login'] = $e->getMessage();
    header("Location: login.php");
    exit();
}
?>
