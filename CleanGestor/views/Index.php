<!DOCTYPE html>
<html lang="en">

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
  
  <title>CLEAN GESTOR</title>

  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet" />
  <link href="../assets/css/responsive.css" rel="stylesheet" />
  <link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>

<body>
    <div class="hero_area">
      <!-- header section starts -->
      <header class="header_section">
        <div class="container-fluid">
          <header class="header_section">
            <div class="container-fluid">
              <?php include_once("navbar.php"); ?>
            </div>
          </header>
        </div>
      </header>

      <!-- slider section -->
      <section class="slider_section ">
        <div id="customCarousel1" class="carousel slide animate__animated animate__zoomIn delay-1s" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="container ">
                <div class="row">
                  <!-- Text Section -->
                  <div class="col-md-6 detail-box animate__animated animate__fadeInLeft delay-1s">
                    <h1>Ofrece, contrata y gestiona<br>la limpieza</h1>
                    <p>Encuentra, contrata y gestiona servicios de limpieza de manera fácil, rápida y confiable, todo en un solo lugar.</p>
                    <!-- Botones con animación -->
                    <div class="btn-box">
                      <a href="login.php" class="btn-1 animate__animated animate__fadeInDown delay-2s">Identifícate</a>
                      <a href="informate.php" class="btn-2 animate__animated animate__fadeInDown delay-3s">Infórmate</a>
                    </div>
                  </div>

                  <!-- Image Section -->
                  <div class="col-md-6 img-box animate__animated animate__fadeInRight delay-2s">
                    <img src="../assets/images/InicioEscoba1.png" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

    </div>

    <!-- GSAP Animation -->
    <!-- Add GSAP via CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <!-- GSAP Script for Menu Buttons Animation -->
    <script>

      // Animación para el contenido principal
      gsap.from(".detail-box h1", { duration: 2, x: -100, opacity: 0 });
      gsap.from(".detail-box p", { duration: 2, y: -50, opacity: 0, delay: 0.5 });
      gsap.from(".img-box img", { duration: 1.5, scale: 0.8, opacity: 0, delay: 1 });
    </script>

</body>

</html>
