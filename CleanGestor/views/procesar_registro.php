<?php
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

    echo "<p>Tipo de usuario: <strong>$tipoUsuario</strong></p>";

    // Validar correo si es administrador de empresa
    if ($tipoUsuario === 'trabajador' && $rolTrabajador === 'administrador de empresa') {
        $empresaDAO = new EmpresaDAO();
        $esCorreoAdmin = $empresaDAO->existeCorreoAdmin($email);

        if (!$esCorreoAdmin) {
            throw new Exception(" El correo electrónico no está registrado como correoAdmin de ninguna empresa.");
        }
    }

    // Hashear la contraseña si quieres seguridad adicional
    // $passwordHasheada = password_hash($password, PASSWORD_DEFAULT);
    // Por ahora se usará la contraseña tal cual:
    $passwordFinal = $password;

    // Insertar en Persona
    echo "<p> Insertando persona...</p>";
    $personaVO = new PersonaVO($dni, $nombre, $apellidos, $email, $passwordFinal, $telefono, $fechaNacimiento);
    $personaDAO = new PersonaDAO();
    $personaDAO->insertPersona($personaVO);
    echo "<p> Persona insertada correctamente.</p>";

    // Insertar en Cliente si corresponde
    if ($tipoUsuario === 'cliente') {
        echo "<p> Insertando cliente...</p>";
        $clienteVO = new ClienteVO($dni);
        $clienteDAO = new ClienteDAO();
        $clienteDAO->insertCliente($clienteVO);
        echo "<p> Cliente insertado correctamente.</p>";
    }

    // Insertar en Trabajador si corresponde
    if ($tipoUsuario === 'trabajador') {
        echo "<p> Insertando trabajador con rol: <strong>$rolTrabajador</strong></p>";
        $trabajadorVO = new TrabajadorVO($rolTrabajador, null, $dni, null);
        $trabajadorDAO = new TrabajadorDAO();
        $trabajadorDAO->insertTrabajador($trabajadorVO);
        echo "<p>s Trabajador insertado correctamente.</p>";
    }

    $pdo->commit();
    echo "<p>🎉 Todos los datos fueron insertados con éxito.</p>";

} catch (Exception $e) {
    if (isset($pdo)) {
        $pdo->rollBack();
    }
    echo "<p><strong>Error en la transacción:</strong> " . $e->getMessage() . "</p>";
}
?>
