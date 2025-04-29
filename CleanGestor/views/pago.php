<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif" />
  <title>Método de Pago - CLEAN GESTOR</title>

  <link rel="stylesheet" href="../assets/css/bootstrap.css" />
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

    <section class="login_section">
      <div class="login_box">
        <h2>Selecciona tu Método de Pago</h2>
        <form action="procesar_pago.php" method="POST">
          <div class="form-group">
            <label for="forma_pago">Método de Pago</label>
            <select class="form-control" id="forma_pago" name="forma_pago" required>
              <option value="">Selecciona un método</option>
              <option value="tarjeta">Tarjeta</option>
              <option value="paypal">PayPal</option>
            </select>
          </div>

          <!-- Campos Tarjeta -->
          <div id="tarjeta_fields" style="display: none;">
            <div class="form-group">
              <label for="numero_tarjeta">Número de Tarjeta</label>
              <input type="text" class="form-control" id="numero_tarjeta" name="numero_tarjeta" placeholder="Ej: 1234 5678 9012 3456">
            </div>
            <div class="form-group">
              <label for="cvv">CVV</label>
              <input type="text" class="form-control" id="cvv" name="cvv" placeholder="Ej: 123">
            </div>
            <div class="form-group">
              <label for="fecha_exp">Fecha de Expiración</label>
              <input type="month" class="form-control" id="fecha_exp" name="fecha_exp">
            </div>
          </div>

          <!-- Campos PayPal -->
          <div id="paypal_fields" style="display: none;">
            <div class="form-group">
              <label for="paypal_email">Correo de PayPal</label>
              <input type="email" class="form-control" id="paypal_email" name="paypal_email" placeholder="correo@ejemplo.com">
            </div>
            <div class="form-group">
              <label for="paypal_pass">Contraseña de PayPal</label>
              <input type="password" class="form-control" id="paypal_pass" name="paypal_pass" placeholder="Contraseña">
            </div>
          </div>

          <button type="submit" class="btn btn-success btn-block">Pagar</button>
        </form>
      </div>
    </section>
  </div>

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>

  <script>
    document.getElementById('forma_pago').addEventListener('change', function () {
      const tarjetaFields = document.getElementById('tarjeta_fields');
      const paypalFields = document.getElementById('paypal_fields');

      if (this.value === 'tarjeta') {
        tarjetaFields.style.display = 'block';
        paypalFields.style.display = 'none';
      } else if (this.value === 'paypal') {
        paypalFields.style.display = 'block';
        tarjetaFields.style.display = 'none';
      } else {
        tarjetaFields.style.display = 'none';
        paypalFields.style.display = 'none';
      }
    });
  </script>

  <!-- Info Section -->
  <section class="info_section layout_padding2">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <div class="info_contact">
            <h4>Dirección</h4>
            <div class="contact_link_box">
              <a href="login.php">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <span>Calle Cineasta Carlos Saura, 123, Ciudad</span>
              </a>
              <a href="#">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span>Llama al: 685 145 788</span>
              </a>
              <a href="#">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <span>contacto@cleangestor.com</span>
              </a>
            </div>
          </div>
          <div class="info_social">
            <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
            <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
          </div>
        </div>
        <div class="col-md-3">
          <div class="info_link_box">
            <h4>Enlaces</h4>
            <div class="info_links">
              <a href="Index.php">Inicio</a>
              <a href="informate.php">Sobre Nosotros</a>
              <a href="servicios.php">Servicios</a>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="info_detail">
            <h4>Información</h4>
            <p>CLEAN GESTOR es tu aliado para mantener tus espacios limpios y organizados. Contáctanos para más información.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end Info Section -->

  <!-- Footer Section -->
  <footer class="footer_section">
    <div class="container">
      <p>
        &copy; <span id="displayYear"></span> Todos los derechos reservados por
        <a href="#">CLEAN GESTOR</a>
      </p>
    </div>
  </footer>
  <!-- end Footer Section -->

  <script>
    document.getElementById("displayYear").textContent = new Date().getFullYear();
  </script>
  <script src="https://js.stripe.com/v3/"></script>
</body>

</html>
