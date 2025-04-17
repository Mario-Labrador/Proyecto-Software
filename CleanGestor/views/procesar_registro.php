<?php
session_start();

include_once '../config/db.php';
include_once '../VO/PersonaVO.php';
include_once '../DAO/PersonaDAO.php';
include_once '../VO/EmpresaVO.php';
include_once '../DAO/EmpresaDAO.php';
include_once '../VO/TrabajadorVO.php';
include_once '../DAO/TrabajadorDAO.php';
include_once '../VO/ClienteVO.php';
include_once '../DAO/ClienteDAO.php';

// Recoger datos del formulario
$dni = $_POST['DNI'] ?? '';
$nombre = $_POST['nombre'] ?? '';
$apellidos = $_POST['apellidos'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$fechaNacimiento = $_POST['fecha_nacimiento'] ?? '';
$tipoUsuario = strtolower($_POST['tipo_usuario'] ?? '');
$rolTrabajador = $_POST['rol_trabajador'] ?? null;

try {
    $pdo = Database::connect();
    $pdo->beginTransaction();

    $personaDAO = new PersonaDAO();

    // Validaciones de existencia
    if ($personaDAO->existeDni($dni)) {
        $_SESSION['error_msg'] = "El DNI ya está registrado.";
        header("Location: error.php");
        exit();
    }

    if ($personaDAO->existeEmail($email)) {
        $_SESSION['error_msg'] = "El correo electrónico ya está registrado.";
        header("Location: error.php");
        exit();
    }

    if ($personaDAO->existeTelefono($telefono)) {
        $_SESSION['error_msg'] = "El número de teléfono ya está registrado.";
        header("Location: error.php");
        exit();
    }

    // Validar correo si es administrador de empresa
    if ($tipoUsuario === 'trabajador' && $rolTrabajador === 'administrador de empresa') {
        $empresaDAO = new EmpresaDAO();
        $esCorreoAdmin = $empresaDAO->existeCorreoAdmin($email);

        if (!$esCorreoAdmin) {
            $_SESSION['error_msg'] = "El correo electrónico no está registrado como correoAdmin de ninguna empresa.";
            header("Location: error.php");
            exit();
        }
    }

    // Hashear la contraseña
    $passwordHasheada = password_hash($password, PASSWORD_DEFAULT);

    // Insertar en Persona
    $personaVO = new PersonaVO($dni, $nombre, $apellidos, $email, $passwordHasheada, $telefono, $fechaNacimiento);
    $personaDAO->insertPersona($personaVO);

    // Insertar en Cliente o Trabajador
    if ($tipoUsuario === 'cliente') {
        $clienteVO = new ClienteVO($dni);
        $clienteDAO = new ClienteDAO();
        $clienteDAO->insertCliente($clienteVO);
    }

    if ($tipoUsuario === 'trabajador') {
        $trabajadorVO = new TrabajadorVO($rolTrabajador, null, $dni, null);
        $trabajadorDAO = new TrabajadorDAO();
        $trabajadorDAO->insertTrabajador($trabajadorVO);
    }

    $pdo->commit();
    header("Location: registroExsitoso.php"); // Redirige si todo fue bien
    exit();

} catch (Exception $e) {
    if (isset($pdo)) {
        $pdo->rollBack();
    }
    $_SESSION['error_msg'] = "Error en la transacción: " . $e->getMessage();
    header("Location: error.php");
    exit();
}
?>
