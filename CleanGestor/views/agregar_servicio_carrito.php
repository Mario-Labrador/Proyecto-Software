<?php
// agregar_servicio_carrito.php
// Mario Recio 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Verificar sesión primero
if (!isset($_SESSION['dni']) || $_SESSION['tipo_usuario'] !== 'cliente') {
    header("Location: login.php?mensaje=Debes iniciar sesión como cliente para contratar servicios.");
    exit();
}

// Verificar parámetro GET
$idServicio = $_GET['idServicio'] ?? null;
if (!$idServicio || !is_numeric($idServicio)) {
    $_SESSION['error'] = "Servicio no válido.";
    header("Location: servicios.php");
    exit();
}

// Incluir archivos después de validaciones
require_once("../DAO/ContratoDAO.php");
require_once("../DAO/ContratoServicioDAO.php");
require_once("../VO/ContratoServicioVO.php");

try {
    // Conexión a base de datos con manejo de errores
    $conexion = new mysqli("localhost", "root", "", "gestor");
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
        
    }
    
    // Crear instancias DAO
    $ContratoDAO = new ContratoDAO($conexion);
    $contratoServicioDAO = new ContratoServicioDAO($conexion);
    // Obtener o crear contrato
    $contratoAbierto = $ContratoDAO->obtenerContratoAbierto($_SESSION['dni']);
    if (!$contratoAbierto) {
echo "hola";
     $idContrato = $ContratoDAO->crearContratoVacio($_SESSION['dni']);
echo "hola";
      if (!$idContrato) {
            //throw new Exception("Error al crear nuevo contrato");
       }
    } else {
        $idContrato = $contratoAbierto['idContrato'];
    }

    // Añadir servicio si no existe
    if (!$contratoServicioDAO->servicioYaEnContrato($idContrato, $idServicio)) {
        $contratoServicioVO = new ContratoServicioVO($idContrato, $idServicio);
        if (!$contratoServicioDAO->agregarServicioAContrato($contratoServicioVO)) {
            throw new Exception("Error al agregar servicio al contrato");
        }
    }
    echo "hola4";
    // Redirigir al carrito
    header("Location: ver_carrito.php?idContrato=$idContrato");
    exit();
    
} catch (Exception $e) {
    // Manejo de errores
    error_log("Error en agregar_servicio_carrito: " . $e->getMessage());
    $_SESSION['error'] = "Ocurrió un error al procesar tu solicitud: " . $e->getMessage();
    exit();
}
