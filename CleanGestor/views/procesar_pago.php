<?php
require_once '../config/db.php'; // Contiene la conexión
require_once 'FormaPagoDAO.php';
require_once 'PaypalDAO.php';
require_once 'TarjetaDAO.php';
require_once 'PaypalVO.php';
require_once 'TarjetaVO.php';
require_once 'FormaPagoVO.php';

// Obtener datos del formulario
$idContrato = $_POST['idContrato'];
$fecha = $_POST['fecha'];
$metodo = $_POST['metodoPago'];

// Crear instancia del DAO para insertar el pago
$formapagoDAO = new FormaPagoDAO(Database::connect()); // Usamos la clase Database para conectar
$formapago = new FormaPago($idContrato, $fecha);
$formapagoDAO->insertar($formapago); // Insertar el pago en la base de datos

// Verificar el método de pago y guardar la información correspondiente
if ($metodo === 'paypal') {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Insertar los datos de PayPal en la base de datos
    $paypalDAO = new PaypalDAO(Database::connect());
    $paypal = new Paypal($idContrato, $correo, $contrasena);
    $paypalDAO->insertar($paypal);
    
} elseif ($metodo === 'tarjeta') {
    $numeroTarjeta = $_POST['numeroTarjeta'];
    $cvv = $_POST['cvv'];
    $fechaExpiracion = $_POST['fechaExpiracion'];

    // Insertar los datos de la tarjeta en la base de datos
    $tarjetaDAO = new TarjetaDAO(Database::connect());
    $tarjeta = new Tarjeta($idContrato, $numeroTarjeta, $cvv, $fechaExpiracion);
    $tarjetaDAO->insertar($tarjeta);
}

// Redirigir a la página de confirmación de pago
header("Location: confirmacion_pago.php");
exit;
?>
