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

    // Insertar en Persona
    try {
        $personaVO = new PersonaVO($dni, $nombre, $apellidos, $email, $password, $telefono, $fechaNacimiento);
        $personaDAO = new PersonaDAO();
        $personaDAO->insertPersona($personaVO);
        echo "<p>✅ Persona insertada correctamente.</p>";
    } catch (Exception $e) {
        throw new Exception("❌ Error al insertar persona: " . $e->getMessage());
    }

    // Insertar en Cliente si corresponde
    if ($tipoUsuario === "cliente") {
        try {
            $clienteVO = new ClienteVO($dni);
            $clienteDAO = new ClienteDAO();
            $clienteDAO->insertCliente($clienteVO);
            echo "<p>✅ Cliente insertado correctamente.</p>";
        } catch (Exception $e) {
            throw new Exception("❌ Error al insertar cliente: " . $e->getMessage());
        }
    }

    // Insertar en Trabajador si corresponde
    if ($tipoUsuario === 'trabajador') {
        try {
            $trabajadorVO = new TrabajadorVO($rolTrabajador, null, $dni, null);
            $trabajadorDAO = new TrabajadorDAO();
            $trabajadorDAO->insertTrabajador($trabajadorVO);
            echo "<p>✅ Trabajador insertado correctamente con rol: <strong>$rolTrabajador</strong>.</p>";
        } catch (Exception $e) {
            throw new Exception("❌ Error al insertar trabajador: " . $e->getMessage());
        }
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
