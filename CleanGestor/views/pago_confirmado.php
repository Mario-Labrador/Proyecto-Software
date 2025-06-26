<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Pago Exitoso | CLEAN GESTOR</title>

  <link rel="icon" href="../assets/iamges/IconoEscoba.png" type="image/gif" />
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet" />
  <link href="../assets/css/responsive.css" rel="stylesheet" />
</head>

<body>

    <div class="hero_area">
        <header class="header_section">
            <div class="container-fluid">
                <?php include_once("navbar.php"); ?>
            </div>
        </header>

        <section class="text-center">
        <div class="container">
            <div class="success-box animate__animated animate__fadeIn">
            <h2>¡Pago realizado correctamente!</h2>
            <form action="cerrar_contrato.php" method="post" style="display:inline;">
                <input type="hidden" name="idContrato" value="<?= htmlspecialchars($idContrato) ?>">
                <button type="submit" class="btn btn-primary">Volver a servicios</button>
            </form>
            </div>
        </div>
        </section>
  </div>

  <script src="../js/jquery-3.4.1.min.js"></script>
  <script src="../js/bootstrap.js"></script>
</body>
</html>
