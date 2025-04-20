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
$confirm_password = $_POST['confirm_password'] ?? '';
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
        $_SESSION['registro_error_type'] = "dni_duplicado";
        $_SESSION['registro_data'] = $_POST;
        header("Location: registro.php");
        exit();
    }

    if ($personaDAO->existeEmail($email)) {
        $_SESSION['registro_error_type'] = "email_duplicado";
        $_SESSION['registro_data'] = $_POST;
        header("Location: registro.php");
        exit();
    }

    if ($personaDAO->existeTelefono($telefono)) {
        $_SESSION['registro_error_type'] = "telefono_duplicado";
        $_SESSION['registro_data'] = $_POST;
        header("Location: registro.php");
        exit();
    }

    if ($password !== $confirm_password) {
        $_SESSION['registro_error_type'] = 'password_mismatch';
        $_SESSION['registro_data'] = $_POST;
        header("Location: registro.php");
        exit();
    }

    // Validar correo si es administrador de empresa
    if ($tipoUsuario === 'trabajador' && $rolTrabajador === 'administrador de empresa') {
        $empresaDAO = new EmpresaDAO();
        $esCorreoAdmin = $empresaDAO->existeCorreoAdmin($email);

        if (!$esCorreoAdmin) {
            $_SESSION['registro_error_type'] = "no_correo_admin";
            $_SESSION['registro_data'] = $_POST;
            header("Location: registro.php");
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
}
?>
