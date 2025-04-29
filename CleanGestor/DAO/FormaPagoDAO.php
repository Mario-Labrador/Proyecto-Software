
<?php
require_once 'FormaPagoVO.php';

class FormaPagoDAO {
    private $conn;

    public function __construct($conexion) {
        $this->conn = $conexion;
    }

    public function insertar(FormaPago $formaPago) {
        $sql = "INSERT INTO formapago (idContrato, fecha) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $formaPago->getIdContrato(),
            $formaPago->getFecha()
        ]);
    }

    public function buscarPorId($idContrato) {
        $sql = "SELECT * FROM formapago WHERE idContrato = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idContrato]);
        $row = $stmt->fetch();
        if ($row) {
            return new FormaPago($row['idContrato'], $row['fecha']);
        }
        return null;
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM formapago";
        $stmt = $this->conn->query($sql);
        $resultados = [];
        while ($row = $stmt->fetch()) {
            $resultados[] = new FormaPago($row['idContrato'], $row['fecha']);
        }
        return $resultados;
    }
}
?>