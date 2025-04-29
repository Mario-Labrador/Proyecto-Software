<?php
session_start();

// Verificar si el usuario está logueado y es cliente
if (!isset($_SESSION['dni']) || $_SESSION['tipo_usuario'] !== 'cliente') {
    header("Location: login.php?mensaje=Debes iniciar sesión como cliente para crear un contrato.");
    exit();
}

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "gestor");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener los datos del formulario
$fecha = $_POST['fecha'];
$direccion = $_POST['direccion'];
$dni = $_SESSION['dni'];

// Insertar el contrato en la base de datos
$sql = "INSERT INTO contrato (fecha, lugar, dni) VALUES (?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sss", $fecha, $direccion, $dni);

if ($stmt->execute()) {
    header("Location: contrato_exitoso.php");
} else {
    echo "Error al crear el contrato.";
}

$stmt->close();
$conexion->close();
?>