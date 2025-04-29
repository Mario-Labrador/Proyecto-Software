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
        <form action="procesar_pago_stripe.php" method="POST" id="payment-form">
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
              <label for="card-element">Número de Tarjeta</label>
              <div id="card-element">
                <!-- Un elemento Stripe será insertado aquí -->
              </div>
            </div>
            <div id="card-errors" role="alert"></div>
          </div>

          <button type="submit" class="btn btn-success btn-block">Pagar</button>
        </form>
      </div>
    </section>
  </div>

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>

  <script src="https://js.stripe.com/v3/"></script>
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

    // Configura Stripe con tu clave pública
    var stripe = Stripe('pk_test_51RJGemRiSDxu7JZhO5rKCvELDh5t8KA8pAUvGx4TEZpTM2jNvF6j5Du2iz65Edig1V5dNS8YF2HWYcPlnHgk7ut000Nxcx22JC'); // Usa tu clave pública de Stripe
    var elements = stripe.elements();

    // Crea el elemento de tarjeta
    var card = elements.create('card');
    card.mount('#card-element');  // Monta el campo de tarjeta en el DOM

    // Manejador de errores
    card.on('change', function(event) {
      var displayError = document.getElementById('card-errors');
      if (event.error) {
        displayError.textContent = event.error.message;
      } else {
        displayError.textContent = '';
      }
    });

    // Enviar el formulario cuando se envíe
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
      event.preventDefault();

      // Crea un token de Stripe con los datos de la tarjeta
      stripe.createToken(card).then(function(result) {
        if (result.error) {
          // Si hay un error, lo mostramos
          var errorElement = document.getElementById('card-errors');
          errorElement.textContent = result.error.message;
        } else {
          // Si el token se crea correctamente, lo enviamos al servidor
          var token = result.token.id;

          // Crea un input oculto para el token
          var hiddenInput = document.createElement('input');
          hiddenInput.setAttribute('type', 'hidden');
          hiddenInput.setAttribute('name', 'stripeToken');
          hiddenInput.setAttribute('value', token);

          // Agrega el input oculto al formulario
          form.appendChild(hiddenInput);

          // Envía el formulario
          form.submit();
        }
      });
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

</body>

</html>
