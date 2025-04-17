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
        throw new Exception("No se encontró un usuario con ese correo.");
    }

    // Verificar contraseña (asumiendo que está hasheada con password_hash)
    if (!password_verify($password, $persona->getContrasenyaPersona())) {
        throw new Exception("Contraseña incorrecta.");
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
        throw new Exception("Este usuario no tiene un rol asignado.");
    }

    // Guardar info en sesión
    $_SESSION['dni'] = $persona->getDni();
    $_SESSION['nombre'] = $persona->getNombrePersona();  // Cambié a getNombrePersona()
    $_SESSION['email'] = $persona->getEmailPersona();   // Cambié a getEmailPersona()
    $_SESSION['tipo_usuario'] = $tipoUsuario;
    $_SESSION['rol'] = $rol;

    // Redirigir según tipo
    header("Location: perfil.php");
    exit();

} catch (Exception $e) {
    // Mostrar error directamente en pantalla
    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <title>Error de inicio de sesión</title>
        <style>
            body { font-family: Arial, sans-serif; background-color: #f8f8f8; text-align: center; padding: 50px; }
            .error { color: red; font-size: 1.2em; }
            a { text-decoration: none; color: #007bff; }
        </style>
    </head>
    <body>
        <h1>Error al iniciar sesión</h1>
        <p class='error'>{$e->getMessage()}</p>
        <p><a href='index.html'>Volver al inicio de sesión</a></p>
    </body>
    </html>";
    exit();
}
?>
