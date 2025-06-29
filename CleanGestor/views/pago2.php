<?php
// pago.php
// Alberto Lacarta
session_start();
$totalPago = isset($_SESSION['total_pago']) ? number_format($_SESSION['total_pago'], 2, '.', '') : '0.00';
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

  <style>
    .paypal-button-wrapper {
        display: none !important;
    }
  </style>
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
      <h2>Total a pagar:</h2>
      <h2><strong class="text-primary"><?= $totalPago ?> €</strong></h2>


        <form action="procesar_pago_stripe.php" method="POST" id="payment-form">
          <div class="form-group">
            <label for="forma_pago">Método de Pago</label>
            <select class="form-control" id="forma_pago" name="forma_pago" required>
              <option value="">Selecciona un método</option>
              <option value="tarjeta">Tarjeta</option>
              <option value="paypal">PayPal</option>
            </select>
          </div>

          <!-- Stripe Card Fields -->
          <div id="tarjeta_fields" style="display: none;">
            <div class="form-group">
              <label for="card-element">Número de Tarjeta</label>
              <div id="card-element"></div>
            </div>
            <div id="card-errors" role="alert" style="color: red;"></div>
          </div>

          <!-- PayPal Button -->
          <div id="paypal_fields" style="display: none;">
            <div id="paypal-button-container"></div>
          </div>

          <!-- Submit Button -->
          <button type="submit" class="btn btn-success btn-block" id="submit-button" style="display: none;">Pagar</button>
        </form>
      </div>
    </section>
  </div>

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>

  <!-- Stripe -->
  <script src="https://js.stripe.com/v3/"></script>

  <!-- PayPal -->
  <script src="https://www.paypal.com/sdk/js?client-id=ARbnydAWoP3tnbQ2Z_BkSMUPDb0ghoyh8z-hlycoMNNQODBONDWPttgXae8GNzJz2nygZnIAhXHloY3u&currency=EUR&components=buttons"></script>

  <script>
    const stripe = Stripe('pk_test_51RJGemRiSDxu7JZhO5rKCvELDh5t8KA8pAUvGx4TEZpTM2jNvF6j5Du2iz65Edig1V5dNS8YF2HWYcPlnHgk7ut000Nxcx22JC');
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    const tarjetaFields = document.getElementById('tarjeta_fields');
    const paypalFields = document.getElementById('paypal_fields');
    const submitButton = document.getElementById('submit-button');

    // Total desde PHP (en euros como string)
    const totalPago = "<?= $totalPago ?>";

    // Cambiar visibilidad según método seleccionado
    document.getElementById('forma_pago').addEventListener('change', function () {
      const metodo = this.value;
      if (metodo === 'tarjeta') {
        tarjetaFields.style.display = 'block';
        paypalFields.style.display = 'none';
        submitButton.style.display = 'block';
      } else if (metodo === 'paypal') {
        tarjetaFields.style.display = 'none';
        paypalFields.style.display = 'block';
        submitButton.style.display = 'none';
      } else {
        tarjetaFields.style.display = 'none';
        paypalFields.style.display = 'none';
        submitButton.style.display = 'none';
      }
    });

    // Stripe token
    const form = document.getElementById('payment-form');
    form.addEventListener('submit', function (event) {
      if (document.getElementById('forma_pago').value === 'tarjeta') {
        event.preventDefault();
        stripe.createToken(card).then(function (result) {
          if (result.error) {
            document.getElementById('card-errors').textContent = result.error.message;
          } else {
            const hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', result.token.id);
            form.appendChild(hiddenInput);
            form.submit();
          }
        });
      }
    });

    // Renderizar botón de PayPal
    let paypalButtons;
    function renderPaypalButton() {
      if (paypalButtons) {
        paypalButtons.close();
      }
      paypalButtons = paypal.Buttons({
        createOrder: function (data, actions) {
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: totalPago // Usar total de sesión
              }
            }]
          });
        },
        onApprove: function (data, actions) {
          return actions.order.capture().then(function (details) {
            alert('Pago completado por ' + details.payer.name.given_name);
            window.location.href = "confirmacion_pago.php";
          });
        },
        onError: function (err) {
          console.error(err);
          alert('Error con el pago de PayPal.');
        }
      });
      paypalButtons.render('#paypal-button-container');
    }

    renderPaypalButton();
  </script>

  <!-- Info Section -->
  <section class="info_section layout_padding2">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <div class="info_contact">
            <h4>
              Dirección
            </h4>
            <div class="contact_link_box">
              <a href="href=login.php">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <span>
                  Calle Cineasta Carlos Saura, 123, Ciudad
                </span>
              </a>
              <a href="">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span>
                  Llama al: 685 145 788
                </span>
              </a>
              <a href="">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <span>
                  contacto@cleangestor.com
                </span>
              </a>
            </div>
          </div>
          <div class="info_social">
            <a href="">
              <i class="fa fa-facebook" aria-hidden="true"></i>
            </a>
            <a href="">
              <i class="fa fa-twitter" aria-hidden="true"></i>
            </a>
            <a href="">
              <i class="fa fa-linkedin" aria-hidden="true"></i>
            </a>
            <a href="">
              <i class="fa fa-instagram" aria-hidden="true"></i>
            </a>
          </div>
        </div>
        <div class="col-md-3">
          <div class="info_link_box">
            <h4>
              Enlaces
            </h4>
            <div class="info_links">
              <a href="Index.php">
                Inicio
              </a>
              <a href="informate.php">
                Sobre Nosotros
              </a>
              <a href="servicios.php">
                Servicios
              </a>
              
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="info_detail">
            <h4>
              Información
            </h4>
            <p>
              CLEAN GESTOR es tu aliado para mantener tus espacios limpios y organizados. Contáctanos para más información.
            </p>
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

  <script>
    document.getElementById("displayYear").textContent = new Date().getFullYear();
  </script>
</body>
</html>
