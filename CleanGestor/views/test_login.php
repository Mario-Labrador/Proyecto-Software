<?php
session_start();

// Verificar si la sesión está activa
if (!isset($_SESSION['dni'])) {
    echo "No estás logueado.";
    exit();
}

// Mostrar los datos de la sesión
echo "<h3>Datos del usuario logueado</h3>";
echo "<strong>DNI:</strong> " . htmlspecialchars($_SESSION['dni']) . "<br>";
echo "<strong>Nombre:</strong> " . htmlspecialchars($_SESSION['nombre']) . "<br>";
echo "<strong>Email:</strong> " . htmlspecialchars($_SESSION['email']) . "<br>";
echo "<strong>Tipo de usuario:</strong> " . htmlspecialchars($_SESSION['tipo_usuario']) . "<br>";
echo "<strong>Rol:</strong> " . htmlspecialchars($_SESSION['rol']) . "<br>";
echo "<strong>Foto de perfil:</strong> " . (empty($_SESSION['foto_perfil']) ? 'No tiene foto de perfil' : $_SESSION['foto_perfil']) . "<br>";
echo "<strong>Id de la empresa:</strong> " . (isset($_SESSION['idEmpresa']) ? htmlspecialchars($_SESSION['idEmpresa']) : 'No asignado') . "<br>";
?>
