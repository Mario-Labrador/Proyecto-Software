<?php
// Simula si el usuario está registrado como cliente
$isClientRegistered = true;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">CleanGestor</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                    </li>
                    <?php if ($isClientRegistered): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#area-cliente">Área Cliente</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if ($isClientRegistered): ?>
            <section id="area-cliente">
                <h2>Área Cliente</h2>
                <p>Bienvenido a tu área de cliente. Aquí puedes gestionar tus servicios.</p>
                <h3>Servicios Disponibles</h3>
                <ul>
                    <li><a href="#">Servicio 1</a></li>
                    <li><a href="#">Servicio 2</a></li>
                    <li><a href="#">Servicio 3</a></li>
                </ul>
            </section>
        <?php else: ?>
            <p>Por favor, regístrate como cliente para acceder al Área Cliente.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>