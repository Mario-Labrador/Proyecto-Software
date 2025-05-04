<?php
  // Conexión a la base de datos
  $conexion = new mysqli("localhost", "root", "", "gestor");
  if ($conexion->connect_error) {
      die("Error de conexión: " . $conexion->connect_error);
  }

  // Consulta para obtener servicios y empresa
  $sql = "SELECT s.idServicio, s.nombreServicio, s.descripcion, s.precio, s.horas, e.nombreEmpresa, s.fotoServicio
          FROM servicio s
          JOIN empresa e ON s.idEmpresa = e.idEmpresa";
  $resultado = $conexion->query($sql);
  if (!$resultado) {
      die("Error en la consulta: " . $conexion->error);
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="icon" href="../assets/images/IconoEscoba.png" type="image/gif" />
  <title>Servicios - CLEAN GESTOR</title>
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css" />
  <link href="../assets/css/style.css" rel="stylesheet" />
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
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
  </div>
  <?php include_once("carrito_flotante.php"); ?>

  <!-- Servicios Section -->
  <section class="service_section layout_padding">
    <div class="container">
      <div class="mb-5 text-center">
        <h2 class="fw-bold">Nuestros Servicios</h2>
        <p>Encuentra, contrata y gestiona servicios de limpieza de forma fácil, rápida y confiable.</p>
      </div>

      <!-- Buscador y botón de filtro -->
      <div class="mb-4 d-flex justify-content-center">
        <input type="text" id="serviceSearch" class="form-control me-2 w-50" placeholder="Buscar servicios..." onkeyup="filterServices()">
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="filterDropdown" data-toggle="dropdown" aria-expanded="false">
            Filtrar
          </button>
          <ul class="dropdown-menu" aria-labelledby="filterDropdown">
            <li><a class="dropdown-item" href="#" onclick="filterBy('precioAsc')">De más barato a más caro</a></li>
            <li><a class="dropdown-item" href="#" onclick="filterBy('precioDesc')">De más caro a más barato</a></li>
            <li><a class="dropdown-item" href="#" onclick="filterBy('valoracionDesc')">Mejor valorado</a></li>
            <li><a class="dropdown-item" href="#" onclick="filterBy('valoracionAsc')">Peor valorado</a></li>
            <li><a class="dropdown-item" href="#" onclick="filterBy('veces_contratadoDesc')">Más veces contratado</a></li>
            <li><a class="dropdown-item" href="#" onclick="filterBy('veces_contratadoAsc')">Menos veces contratado</a></li>
          </ul>
        </div>
      </div>

      <!-- Mensaje de no resultados -->
      <div id="noResultsMessage" class="text-center" style="display: none; color: red;">
        <p>De momento no ofrecemos ningún servicio con ese nombre</p>
      </div>

      <!-- Lista de servicios -->
      <div class="row" id="serviceList">
        <?php while ($row = $resultado->fetch_assoc()): ?>
          <div class="col-md-4 col-sm-6 mb-4 service-item" data-precio="<?php echo $row['precio']; ?>">
            <a href="detalle_servicio.php?id=<?php echo $row['idServicio']; ?>" style="text-decoration:none;">
              <div class="card service-card h-100 shadow-sm" style="background:#fff; color:#000; border:1px solid #ddd; cursor:pointer; border-radius: 10px;">
                <!-- Imagen del servicio -->
                <div class="text-center p-3">
                  <img 
                    src="<?php echo !empty($row['fotoServicio']) ? htmlspecialchars($row['fotoServicio']) : '../assets/images/default_service.png'; ?>" 
                    class="card-img-top" 
                    alt="Imagen del servicio" 
                    style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                </div>
                <!-- Información del servicio -->
                <div class="card-body text-center">
                  <h6 class="card-title fw-bold mb-2"><?php echo htmlspecialchars($row['nombreServicio']); ?></h6>
                  <p class="card-text text-muted mb-1"><strong>Ofrecido por:</strong> <?php echo htmlspecialchars($row['nombreEmpresa']); ?></p>
                  <p class="card-text text-primary fw-bold mb-2" style="font-size: 2rem;" ><?php echo htmlspecialchars($row['precio']); ?> €</p>
                  <p class="card-text text-muted"><strong>Horas:</strong> <?php echo htmlspecialchars($row['horas']); ?></p>
                </div>
              </div>
            </a>
          </div>
        <?php endwhile; ?>
      </div>
      <?php $conexion->close(); ?>
    </div>
  </section>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <script>
    // Función para filtrar servicios por texto
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

    // Función para filtrar servicios por criterio
    function filterBy(criteria) {
      const serviceList = document.getElementById('serviceList');
      const serviceItems = Array.from(document.querySelectorAll('.service-item'));

      if (criteria === 'precioAsc') {
        // Ordenar por precio (ascendente)
        serviceItems.sort((a, b) => {
          const precioA = parseFloat(a.getAttribute('data-precio'));
          const precioB = parseFloat(b.getAttribute('data-precio'));
          return precioA - precioB;
        });
      } else if (criteria === 'precioDesc') {
        // Ordenar por precio (descendente)
        serviceItems.sort((a, b) => {
          const precioA = parseFloat(a.getAttribute('data-precio'));
          const precioB = parseFloat(b.getAttribute('data-precio'));
          return precioB - precioA;
        });
      }

      // Limpiar y reordenar los elementos en el DOM
      serviceList.innerHTML = '';
      serviceItems.forEach(item => serviceList.appendChild(item));
    }
  </script>
</body>
</html>
