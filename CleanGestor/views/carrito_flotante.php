<?php
// filepath: c:\xampp\htdocs\CleanGestor\views\carrito_flotante.php
//Mario Recio 
// carrito_flotante.php
if (isset($_SESSION['dni']) && $_SESSION['tipo_usuario'] === 'cliente') {
    require_once("../DAO/ContratoDAO.php");
    $conexion = new mysqli("localhost", "root", "", "gestor");
    $contratoDAO = new ContratoDAO($conexion);

    // Verificar si el cliente tiene un contrato abierto
    $contratoAbierto = $contratoDAO->obtenerContratoAbierto($_SESSION['dni']);
    if ($contratoAbierto) {
        // Contar los servicios en el carrito
        $idContrato = $contratoAbierto['idContrato'];
        $sql = "SELECT COUNT(*) AS totalServicios FROM contratoservicio WHERE idContrato = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $idContrato);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $row = $resultado->fetch_assoc();
        $totalServicios = $row['totalServicios'];
        $stmt->close();
        ?>
        <div id="carrito-flotante" style="position: fixed; bottom: 20px; right: 20px; z-index: 1000;">
            <a href="ver_carrito.php?idContrato=<?= $idContrato ?>" 
               class="btn btn-success btn-lg rounded-circle shadow position-relative">
                <i class="fas fa-shopping-cart"></i>
                <?php if ($totalServicios > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?= $totalServicios ?>
                    </span>
                <?php endif; ?>
            </a>
        </div>
        <?php
    }
    $conexion->close();
}
?>