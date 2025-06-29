<!-- filepath: c:\xampp\htdocs\CleanGestor\views\procesar_editar_servicio.php -->
<?php
// procesar_editar_servicio.php
// Mario Recio
if (session_status() === PHP_SESSION_NONE) session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['dni']) || $_SESSION['tipo_usuario'] !== 'trabajador' || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "gestor");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener los datos del formulario
$idServicio = $_POST['idServicio'];
$nombreServicio = $_POST['nombreServicio'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$horas = $_POST['horas'];
$sueldo = $_POST['sueldo'];

// Manejar la subida de la foto
$fotoServicio = null;
if (isset($_FILES['fotoServicio']) && $_FILES['fotoServicio']['error'] === UPLOAD_ERR_OK) {
    $directorioDestino = "../assets/images/";
    $nombreArchivo = basename($_FILES['fotoServicio']['name']);
    $rutaArchivo = $directorioDestino . $nombreArchivo;

    // Mover el archivo subido al directorio de destino
    if (move_uploaded_file($_FILES['fotoServicio']['tmp_name'], $rutaArchivo)) {
        $fotoServicio = $rutaArchivo; // Guardar la ruta del archivo
    } else {
        die("Error al subir la foto.");
    }
}

// Actualizar los datos del servicio en la base de datos
if ($fotoServicio) {
    // Si se subió una nueva foto, actualiza también la columna de la foto
    $sql = "UPDATE servicio SET nombreServicio = ?, descripcion = ?, precio = ?, horas = ?, sueldo = ?, fotoServicio = ? WHERE idServicio = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssdddsi", $nombreServicio, $descripcion, $precio, $horas, $sueldo, $fotoServicio, $idServicio);
} else {
    // Si no se subió una nueva foto, no actualices la columna de la foto
    $sql = "UPDATE servicio SET nombreServicio = ?, descripcion = ?, precio = ?, horas = ?, sueldo = ? WHERE idServicio = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssdddi", $nombreServicio, $descripcion, $precio, $horas, $sueldo, $idServicio);
}

if ($stmt->execute()) {
    header("Location: misServicios.php?mensaje=Servicio actualizado correctamente");
} else {
    header("Location: editar_servicio.php?id=$idServicio&error=No se pudo actualizar el servicio");
}

$stmt->close();
$conexion->close();
?>