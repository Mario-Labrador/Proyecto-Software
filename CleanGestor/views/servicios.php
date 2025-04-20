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

  <title>Registro - CLEAN GESTOR</title>

  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css" />
  <link href="../assets/css/font-awesome.min.css" rel="stylesheet" />
  <link href="../assets/css/style.css" rel="stylesheet" />
  <link href="../assets/css/responsive.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <!-- Google Fonts: Montserrat -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  
</head>

<body>
  <div class="hero_area">
    <!-- header section starts -->
    <header class="header_section">
      <div class="container-fluid">
        <?php include_once("navbar.php"); ?>
      </div>
    </header>

    <section class="service_section">
      <div class="container">
        <div class="mb-5 text-center">
          <h2 class="fw-bold">Nuestros Servicios</h2>
          <p>
            Encuentra, contrata y gestiona servicios de limpieza de manera fácil, rápida y confiable.
          </p>
        </div>
        <div class="row">
          <!-- Servicio 1 -->
          <div class="col-md-6">
            <div class="card service-card h-100" style="background:#0275d8; color:#fff; border:none;">
              <div class="card-body">
                <h5 class="card-title fw-bold">Limpieza de Oficinas</h5>
                <p class="card-text">Empresa: CleanPro S.A.</p>
              </div>
            </div>
          </div>
          <!-- Servicio 2 -->
          <div class="col-md-6">
            <div class="card service-card h-100" style="background:#5cb85c; color:#fff; border:none;">
              <div class="card-body">
                <h5 class="card-title fw-bold">Desinfección Industrial</h5>
                <p class="card-text">Empresa: Higiene Total</p>
              </div>
            </div>
          </div>
          <!-- Servicio 3 -->
          <div class="col-md-6">
            <div class="card service-card h-100" style="background:#f0ad4e; color:#fff; border:none;">
              <div class="card-body">
                <h5 class="card-title fw-bold">Limpieza de Alfombras</h5>
                <p class="card-text">Empresa: Brillo Express</p>
              </div>
            </div>
          </div>
          <!-- Servicio 4 -->
          <div class="col-md-6">
            <div class="card service-card h-100" style="background:#5bc0de; color:#fff; border:none;">
              <div class="card-body">
                <h5 class="card-title fw-bold">Mantenimiento de Jardines</h5>
                <p class="card-text">Empresa: Verde Vivo</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  
  <script>
    // Animación para el contenido principal
    gsap.from(".detail-box h1", { duration: 2, x: -100, opacity: 0 });
    gsap.from(".detail-box p", { duration: 2, y: -50, opacity: 0, delay: 0.5 });
    gsap.from(".img-box img", { duration: 1.5, scale: 0.8, opacity: 0, delay: 1 });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var tipoUsuario = document.getElementById('tipo_usuario');
      if(tipoUsuario){
        tipoUsuario.addEventListener('change', function() {
          var rolGroup = document.getElementById('rol_trabajador_group');
          if (this.value === 'trabajador') {
            rolGroup.style.display = 'block';
            document.getElementById('rol_trabajador').setAttribute('required', 'required');
          } else {
            rolGroup.style.display = 'none';
            document.getElementById('rol_trabajador').removeAttribute('required');
            document.getElementById('rol_trabajador').value = '';
          }
        });
      }
    });
  </script>
</body>

</html>
