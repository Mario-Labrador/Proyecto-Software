<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  
  <!-- Site Metas -->
  <link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  
  <title>Infórmate - CLEAN GESTOR</title>

  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet" />
  <link href="../assets/css/responsive.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

</head>

<body class="sub_page">

  <div class="hero_area">
    <!-- header section starts -->
    <header class="header_section">
      <div class="container-fluid">
        <?php include_once("navbar.php"); ?>
      </div>
    </header>
    <!-- header section ends -->
  </div>

  <!-- Informate Section -->
  <section class="about_section layout_padding">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="detail-box">
            <div class="heading_container">
              <h2>
                Sobre CLEAN GESTOR
              </h2>
            </div>
            <p>
              En CLEAN GESTOR, nos especializamos en conectar a clientes con servicios de limpieza de alta calidad. Nuestro objetivo es simplificar el proceso de encontrar, contratar y gestionar servicios de limpieza, ofreciendo una plataforma confiable y fácil de usar.
            </p>
            <p>
              Ademas de lo nombrado anteriormente, nuestra página le ofrece a las empresas el servicio de poder gestionar su empleados y todo lo relacionado con su empresa.
            </p>
            <a href="service.html">
              Descubre nuestros servicios
            </a>
          </div>
        </div>
        <div class="col-md-6">
          <div class="img-box">
            <img src="imagenes/empresa.jpg" alt="Sobre CLEAN GESTOR">
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end Informate Section -->

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
              <a href="">
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
              <a href="index.html">
                Inicio
              </a>
              <a href="about.html">
                Sobre Nosotros
              </a>
              <a href="service.html">
                Servicios
              </a>
              <a href="contact.html">
                Contacto
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
  <!-- end Footer Section -->

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

  <script>
    // Animación para el contenido principal
    gsap.from(".detail-box h1", { duration: 1, x: -100, opacity: 0 });
    gsap.from(".detail-box p", { duration: 1, y: -50, opacity: 0, delay: 0.5 });
    gsap.from(".img-box img", { duration: 1.5, scale: 0.8, opacity: 0, delay: 1 });
  </script>
</body>

</html>