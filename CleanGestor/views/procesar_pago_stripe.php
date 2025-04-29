<?php
require_once '../vendor/autoload.php';  // Usa Composer para cargar la librería Stripe

// Configura tu clave secreta de prueba de Stripe
\Stripe\Stripe::setApiKey('sk_test_51RJGemRiSDxu7JZh0lntrnDAZ8Gs4GZitFspHbofMBQXvriDZkQ1rRTSjoKbYsYyB4rFA22kJLwVk2aEbCSLDGuB00FNM8xJ0b');

// Obtén el token enviado desde el frontend
$token = $_POST['stripeToken'];

if (!$token) {
    die('Token no recibido. El pago no pudo ser procesado.');
}

try {
    // Crea el cargo (pago) en Stripe
    $charge = \Stripe\Charge::create([
        'amount' => 5000,  // El monto en centavos (Ej: 5000 = $50)
        'currency' => 'usd',
        'description' => 'Pago de prueba',
        'source' => $token,  // El token enviado desde el formulario
    ]);

    // Si el pago es exitoso, redirige a la página de confirmación
    header("Location: confirmacion_pago.php");
    exit;

} catch (\Stripe\Exception\ApiErrorException $e) {
    // Maneja el error
    echo "Error al procesar el pago: " . $e->getMessage();
}
?>
