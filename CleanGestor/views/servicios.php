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

  <title>Servicios - CLEAN GESTOR</title>

    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css" />
  <link href="../assets/css/font-awesome.min.css" rel="stylesheet" />
  <link href="../assets/css/style.css" rel="stylesheet" />
  <link href="../assets/css/responsive.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <!-- Google Fonts: Montserrat -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
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

  <!-- Servicios Section -->
  <section class="service_section layout_padding">
    <div class="container">
      <div class="mb-5 text-center">
        <h2 class="fw-bold">Nuestros Servicios</h2>
        <p>
          Encuentra, contrata y gestiona servicios de limpieza de manera fácil, rápida y confiable.
        </p>
      </div>

      <!-- Buscador y botón de filtro -->
      <div class="mb-4 d-flex">
        <input type="text" id="serviceSearch" class="form-control me-2" placeholder="Buscar servicios..." onkeyup="filterServices()">
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="filterDropdown" data-toggle="dropdown" aria-expanded="false">
            Filtrar
          </button>
          <ul class="dropdown-menu" aria-labelledby="filterDropdown">
            <li><a class="dropdown-item" href="#" onclick="filterBy('precio')">Por precio</a></li>
            <li><a class="dropdown-item" href="#" onclick="filterBy('valoracion')">Por valoración</a></li>
            <li><a class="dropdown-item" href="#" onclick="filterBy('veces_contratado')">Por veces contratado</a></li>
          </ul>
        </div>
      </div>

      <!-- Mensaje de no resultados -->
      <div id="noResultsMessage" class="text-center" style="display: none; color: red;">
        <p>De momento no ofrecemos ningún servicio con ese nombre</p>
      </div>

      <div class="row" id="serviceList">
        <!-- Servicio 1 -->
        <div class="col-md-6 service-item">
          <div class="card service-card h-100" style="background:#0275d8; color:#fff; border:none;">
            <div class="card-body">
              <h5 class="card-title fw-bold">Limpieza de Oficinas</h5>
              <p class="card-text">Empresa: CleanPro S.A.</p>
            </div>
          </div>
        </div>
        <!-- Servicio 2 -->
        <div class="col-md-6 service-item">
          <div class="card service-card h-100" style="background:#5cb85c; color:#fff; border:none;">
            <div class="card-body">
              <h5 class="card-title fw-bold">Desinfección Industrial</h5>
              <p class="card-text">Empresa: Higiene Total</p>
            </div>
          </div>
        </div>
        <!-- Servicio 3 -->
        <div class="col-md-6 service-item">
          <div class="card service-card h-100" style="background:#f0ad4e; color:#fff; border:none;">
            <div class="card-body">
              <h5 class="card-title fw-bold">Limpieza de Alfombras</h5>
              <p class="card-text">Empresa: Brillo Express</p>
            </div>
          </div>
        </div>
        <!-- Servicio 4 -->
        <div class="col-md-6 service-item">
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

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

  <script>
    // Animación para el contenido principal
    gsap.from(".detail-box h1", { duration: 2, x: -100, opacity: 0 });
    gsap.from(".detail-box p", { duration: 2, y: -50, opacity: 0, delay: 0.5 });
    gsap.from(".img-box img", { duration: 1.5, scale: 0.8, opacity: 0, delay: 1 });

    // Función para filtrar servicios
    function filterServices() {
      const searchInput = document.getElementById('serviceSearch').value.toLowerCase();
      const serviceItems = document.querySelectorAll('.service-item');
      let hasResults = false;

      serviceItems.forEach(item => {
        const text = item.textContent.toLowerCase();
        if (text.includes(searchInput)) {
          item.style.display = 'block';
          hasResults = true;
        } else {
          item.style.display = 'none';
        }
      });

      // Mostrar o ocultar el mensaje de no resultados
      const noResultsMessage = document.getElementById('noResultsMessage');
      if (hasResults) {
        noResultsMessage.style.display = 'none';
      } else {
        noResultsMessage.style.display = 'block';
      }
    }

    // Función para manejar el filtro (placeholder para futuras funcionalidades)
    function filterBy(criteria) {
      console.log(`Filtrar por: ${criteria}`);
      // Aquí puedes añadir la lógica para filtrar por precio, valoración o veces contratado
    }
  </script>
</body>

</html>
