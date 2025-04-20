<?php
session_start();
$errorMsg = $_SESSION['error_msg'] ?? 'Ha ocurrido un error inesperado.';
unset($_SESSION['error_msg']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Error</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <div class="container text-center mt-5">
    <div class="alert alert-danger" role="alert">
      <h4 class="alert-heading">¡Error!</h4>
      <p><?php echo htmlspecialchars($errorMsg); ?></p>
      <hr>
      <a href="login.html" class="btn btn-primary">Volver atrás</a>
    </div>
  </div>
</body>
</html>
