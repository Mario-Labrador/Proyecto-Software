<?php
// subir_foto.php
// Alberto Lacarta
session_start();

if (!isset($_SESSION['dni'])) {
  header("Location: login.php");
  exit();
}

include_once '../config/db.php';

$dni = $_SESSION['dni'];

if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
    $nombreArchivo = $_FILES['foto_perfil']['name'];
    $tmp = $_FILES['foto_perfil']['tmp_name'];
    $ext = pathinfo($nombreArchivo, PATHINFO_EXTENSION);

    // Validar extensión
    $permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array(strtolower($ext), $permitidas)) {
        $_SESSION['error_foto'] = "Formato de imagen no permitido.";
        header("Location: perfil.php");
        exit();
    }

    $nuevoNombre = "foto_" . $dni . "." . $ext;
    $rutaDestino = "../assets/uploads/" . $nuevoNombre;

    if (!is_dir("../assets/uploads")) {
        mkdir("../assets/uploads", 0777, true);
    }

    if (move_uploaded_file($tmp, $rutaDestino)) {
        // Guardar en base de datos la ruta
        $pdo = Database::connect();
        $stmt = $pdo->prepare("UPDATE persona SET foto_perfil = ? WHERE dni = ?");
        $stmt->execute([$rutaDestino, $dni]);
    

        $_SESSION['success_foto'] = "Imagen actualizada con éxito.";
    } else {
        $_SESSION['error_foto'] = "Error al mover la imagen.";
    }
}

header("Location: perfil.php");
exit();
?>
