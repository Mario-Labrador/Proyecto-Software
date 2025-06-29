<?php
// procesar_registro.php
// Alberto Lacarta
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
$fechaInput = $_POST['fecha-nacimiento'];
$fechaNacimiento = date('Y-m-d', DateTime::createFromFormat('d/m/Y', $fechaInput) ? strtotime(str_replace('/', '-', $fechaInput)) : strtotime($fechaInput));
$tipoUsuario = strtolower($_POST['tipo_usuario'] ?? '');
$rolTrabajador = $_POST['rol_trabajador'] ?? null;

try {
    $pdo = Database::connect();
    $pdo->beginTransaction();

    $personaDAO = new PersonaDAO();
    $empresaDAO = new EmpresaDAO(); // Instanciar aquí para usar luego si es necesario

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
    if ($tipoUsuario === 'trabajador' && $rolTrabajador === 'administrador') {
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

        // Si el trabajador es administrador, asociarlo a la empresa correspondiente
        if ($rolTrabajador === 'administrador') {
            $empresa = $empresaDAO->getEmpresaByAdministradorEmail($email);
            if ($empresa) {
                $trabajadorDAO->actualizarEmpresaTrabajador($dni, $empresa->getIdEmpresa());
            } else {
                throw new Exception("No se encontró la empresa asociada al correo del administrador.");
            }
        }
    }

    $pdo->commit();
    header("Location: registro_exitoso.php");
    exit();

} catch (Exception $e) {
    if (isset($pdo)) {
        $pdo->rollBack();
    }
    die("Error en el registro: " . $e->getMessage());
}
?>