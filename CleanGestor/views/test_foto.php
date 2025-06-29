<?php
// test_foto.php
// Alberto Lacarta
session_start();

// Verificar si la sesión está activa
if (!isset($_SESSION['dni'])) {
    echo "La sesión no está activa. Salir.";
    exit();
}

// Obtener los datos de la sesión
$dni = $_SESSION['dni'];
$foto_perfil = $_SESSION['foto_perfil'] ?? ''; // Obtener la ruta de la foto de perfil desde la sesión

echo "<h2>Valores obtenidos de la sesión</h2>";
echo "<pre>";
print_r($_SESSION); // Muestra todos los datos de la sesión para verificar
echo "</pre>";

// Verificar si la variable foto_perfil tiene valor
echo "<h3>Verificando el valor de foto_perfil:</h3>";
if (!empty($foto_perfil)) {
    echo "La variable 'foto_perfil' tiene el valor: " . htmlspecialchars($foto_perfil) . "<br>";
} else {
    echo "La variable 'foto_perfil' está vacía o no se ha establecido.<br>";
}

// Verificar si la ruta de la foto existe
$rutaFoto = "../" . $foto_perfil;
echo "<h3>Verificando si la ruta de la foto existe:</h3>";

if (file_exists($rutaFoto)) {
    echo "La foto de perfil existe en la ruta: " . $rutaFoto . "<br>";
} else {
    echo "La foto de perfil no existe en la ruta: " . $rutaFoto . "<br>";
}

// Verificando si se está usando la foto por defecto
echo "<h3>Verificando si se está usando la foto por defecto:</h3>";
if (empty($foto_perfil) || !file_exists($rutaFoto)) {
    echo "Se está usando la foto por defecto: '../assets/uploads/default.png'<br>";
} else {
    echo "Se está usando la foto personalizada.<br>";
}

?>
