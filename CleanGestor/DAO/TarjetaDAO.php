<?php
require_once 'TarjetaVO.php';

class TarjetaDAO {
    private $conn;

    public function __construct($conexion) {
        $this->conn = $conexion;
    }

    public function insertar(Tarjeta $tarjeta) {
        $sql = "INSERT INTO tarjeta (idContrato, numeroTarjeta, cvv, fechaExpiracion) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $tarjeta->getIdContrato(),
            $tarjeta->getNumeroTarjeta(),
            $tarjeta->getCvv(),
            $tarjeta->getFechaExpiracion()
        ]);
    }

    public function buscarPorId($idContrato) {
        $sql = "SELECT * FROM tarjeta WHERE idContrato = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idContrato]);
        $row = $stmt->fetch();
        if ($row) {
            return new Tarjeta($row['idContrato'], $row['numeroTarjeta'], $row['cvv'], $row['fechaExpiracion']);
        }
        return null;
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM tarjeta";
        $stmt = $this->conn->query($sql);
        $resultados = [];
        while ($row = $stmt->fetch()) {
            $resultados[] = new Tarjeta($row['idContrato'], $row['numeroTarjeta'], $row['cvv'], $row['fechaExpiracion']);
        }
        return $resultados;
    }
}
?>
