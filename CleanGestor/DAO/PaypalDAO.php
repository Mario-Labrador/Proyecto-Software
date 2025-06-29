<?php
//PayPalDAO.php
//Alberto Lacarta
require_once 'Paypal.php';

class PaypalDAO {
    private $conn;

    public function __construct($conexion) {
        $this->conn = $conexion;
    }

    public function insertar(Paypal $paypal) {
        $sql = "INSERT INTO paypal (idContrato, correo, contraseña) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $paypal->getIdContrato(),
            $paypal->getCorreo(),
            $paypal->getContrasena()
        ]);
    }

    public function buscarPorId($idContrato) {
        $sql = "SELECT * FROM paypal WHERE idContrato = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idContrato]);
        $row = $stmt->fetch();
        if ($row) {
            return new Paypal($row['idContrato'], $row['correo'], $row['contraseña']);
        }
        return null;
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM paypal";
        $stmt = $this->conn->query($sql);
        $resultados = [];
        while ($row = $stmt->fetch()) {
            $resultados[] = new Paypal($row['idContrato'], $row['correo'], $row['contraseña']);
        }
        return $resultados;
    }
}

?>