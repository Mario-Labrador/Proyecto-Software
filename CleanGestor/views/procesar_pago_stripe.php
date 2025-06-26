<?php
session_start();
require_once '../vendor/autoload.php';  // Usa Composer para cargar la librería Stripe

\Stripe\Stripe::setApiKey('sk_test_51RJGemRiSDxu7JZh0lntrnDAZ8Gs4GZitFspHbofMBQXvriDZkQ1rRTSjoKbYsYyB4rFA22kJLwVk2aEbCSLDGuB00FNM8xJ0b'); // Cambia por tu clave secreta real

// Obtener el token desde el formulario
$token = $_POST['stripeToken'] ?? null;

if (!$token) {
    die('Token no recibido. El pago no pudo ser procesado.');
}

// Verifica si el total está disponible en la sesión
if (!isset($_SESSION['total_pago'])) {
    die('No se ha establecido el monto del pago en la sesión.');
}

$monto = $_SESSION['total_pago']; // Monto en euros
$montoCentavos = intval($monto * 100); // Stripe trabaja en centavos

try {
    $charge = \Stripe\Charge::create([
        'amount' => $montoCentavos,
        'currency' => 'eur',
        'description' => 'Pago de servicios contratados',
        'source' => $token,
    ]);

    // Limpia el total de la sesión si el pago fue exitoso
    unset($_SESSION['total_pago']);

    // Después de un pago exitoso
    require_once("../DAO/ContratoDAO.php");
    $conexion = new mysqli("localhost", "root", "", "gestor");
    $contratoDAO = new ContratoDAO($conexion);

    $idContrato = $_POST['idContrato'] ?? null;
    if ($idContrato) {
        $contratoDAO->finalizarContrato($idContrato); // Cambia el estado a 'finalizado'
    }

    header("Location: pago_confirmado.php");
    exit;

} catch (\Stripe\Exception\ApiErrorException $e) {
    echo "Error al procesar el pago: " . $e->getMessage();
}
?>
