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

  <style>
    /* Ocultar el botón de tarjeta de crédito/débito */
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

          <!-- Stripe Card Fields -->
          <div id="tarjeta_fields" style="display: none;">
            <div class="form-group">
              <label for="card-element">Número de Tarjeta</label>
              <div id="card-element"></div>
            </div>
            <div id="card-errors" role="alert" style="color: red;"></div>
          </div>

          <!-- PayPal Button (Always visible when selected) -->
          <div id="paypal_fields" style="display: none;">
            <div id="paypal-button-container"></div>
          </div>

          <!-- Submit Button (Visible only for Stripe) -->
          <button type="submit" class="btn btn-success btn-block" id="submit-button" style="display: none;">Pagar</button>
        </form>
      </div>
    </section>
  </div>

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>

  <!-- Stripe -->
  <script src="https://js.stripe.com/v3/"></script>

  <!-- PayPal SDK (Client ID ya incluido) -->
  <script src="https://www.paypal.com/sdk/js?client-id=ARbnydAWoP3tnbQ2Z_BkSMUPDb0ghoyh8z-hlycoMNNQODBONDWPttgXae8GNzJz2nygZnIAhXHloY3u&currency=USD&components=buttons"></script>

  <script>
    const stripe = Stripe('pk_test_51RJGemRiSDxu7JZhO5rKCvELDh5t8KA8pAUvGx4TEZpTM2jNvF6j5Du2iz65Edig1V5dNS8YF2HWYcPlnHgk7ut000Nxcx22JC');
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    const tarjetaFields = document.getElementById('tarjeta_fields');
    const paypalFields = document.getElementById('paypal_fields');
    const submitButton = document.getElementById('submit-button');

    // Mostrar campos según el método de pago seleccionado
    document.getElementById('forma_pago').addEventListener('change', function () {
      const metodo = this.value;
      if (metodo === 'tarjeta') {
        tarjetaFields.style.display = 'block';
        paypalFields.style.display = 'none';
        submitButton.style.display = 'block'; // Mostrar botón de pagar para tarjeta
      } else if (metodo === 'paypal') {
        tarjetaFields.style.display = 'none';
        paypalFields.style.display = 'block'; // Mostrar el botón de PayPal
        submitButton.style.display = 'none'; // Ocultar el botón de pagar
      } else {
        tarjetaFields.style.display = 'none';
        paypalFields.style.display = 'none';
        submitButton.style.display = 'none';
      }
    });

    // Stripe tokenization
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

    // PayPal Button render
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
                value: '50.00'
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

    renderPaypalButton(); // Siempre renderizar el botón de PayPal cuando se carga la página
  </script>

  <!-- Footer -->
  <footer class="footer_section">
    <div class="container">
      <p>&copy; <span id="displayYear"></span> Todos los derechos reservados por
        <a href="#">CLEAN GESTOR</a></p>
    </div>
  </footer>

  <script>
    document.getElementById("displayYear").textContent = new Date().getFullYear();
  </script>
</body>

</html>
