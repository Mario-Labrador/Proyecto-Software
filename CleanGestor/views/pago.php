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
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet" />
  <link href="../assets/css/responsive.css" rel="stylesheet" />
</head>

<body>
  <div class="hero_area">
    <header class="header_section">
      <div class="container-fluid">
        <!-- Aquí va tu barra de navegación si la tienes -->
      </div>
    </header>

    <section class="login_section">
      <div class="login_box">
        <h2>Selecciona tu Método de Pago</h2>

        <!-- Contenedor del botón de PayPal -->
        <div id="paypal-button-container"></div>
      </div>
    </section>
  </div>

  <!-- PayPal SDK (Usa tu propio client-id de PayPal) -->
  <script src="https://www.paypal.com/sdk/js?client-id=EJjavbJZyhzqvhtXvzEoVD03oGtH5z88ntLcspnslrg7-fmwCJv923Q5dIk1CUede-aeponS5ZkKo3_j&currency=USD"></script>

  <script>
    // Renderiza el botón de PayPal
    paypal.Buttons({
      createOrder: function (data, actions) {
        return actions.order.create({
          purchase_units: [{
            amount: {
              value: '50.00' // Cambia este valor al monto que deseas cobrar
            }
          }]
        });
      },
      onApprove: function (data, actions) {
        return actions.order.capture().then(function (details) {
          alert('Pago completado por ' + details.payer.name.given_name);
          window.location.href = "confirmacion_pago.php";  // Redirige a la página de confirmación
        });
      },
      onError: function (err) {
        console.error(err);
        alert('Hubo un error con el pago de PayPal.');
      }
    }).render('#paypal-button-container');  // Renderiza el botón en el contenedor
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
  <!-- end Footer Section -->s
</html>
