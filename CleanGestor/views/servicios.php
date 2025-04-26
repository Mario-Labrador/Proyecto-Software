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

  <title>Servicios | CLEAN GESTOR</title>

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

    <section class="service_section" style="background-color: #fff">
      <div class="container" >
        <div class="mb-5 text-center">
          <h2 class="mt-3">Nuestros Servicios</h2>
          <p> 
            Encuentra, contrata y gestiona servicios de limpieza de manera fácil, rápida y confiable.
          </p>
        </div>

        <?php
        // Conexión a la base de datos
        $conexion = new mysqli("localhost", "root", "", "gestor");
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        // Consulta para obtener servicios y empresa
        $sql = "SELECT s.idServicio, s.nombreServicio, s.descripcion, s.precio, s.sueldo, s.horas, e.nombreEmpresa
                FROM servicio s
                JOIN empresa e ON s.idEmpresa = e.idEmpresa";
        $resultado = $conexion->query($sql);
        ?>

        <div class="row">
        <section class="service_section" style="background-color: #fff">
        <div class="container">
          <div class="row">
            <?php while($row = $resultado->fetch_assoc()): ?>
              <div class="col-md-6">
                <a href="detalle_servicio.php?id=<?php echo $row['idServicio']; ?>" style="text-decoration:none;">
                  <div class="card service-card h-100" style="background:#0275d8; color:#fff; border:none; cursor:pointer;">
                    <div class="card-body">
                      <h5 class="card-title fw-bold"><?php echo htmlspecialchars($row['nombreServicio']); ?></h5>
                      <p class="card-text">Empresa: <?php echo htmlspecialchars($row['nombreEmpresa']); ?></p>
                      <p class="card-text"><?php echo htmlspecialchars($row['descripcion']); ?></p>
                    </div>
                  </div>
                </a>
              </div>
            <?php endwhile; ?>
          </div>
        </div>
      </section>
      <?php $conexion->close(); ?>

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
