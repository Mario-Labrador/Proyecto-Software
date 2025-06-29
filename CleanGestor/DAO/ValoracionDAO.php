<?php
//ValoracionDAO.php
//Alberto Lacarta
class ValoracionDAO {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function existeValoracion($idContrato, $idServicio) {
        $sql = "SELECT COUNT(*) as total FROM valoracion WHERE idContrato = ? AND idServicio = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ii", $idContrato, $idServicio);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'] > 0; // Devuelve true si ya existe una valoración
    }

    public function agregarValoracion($valoracion) {
        if ($this->existeValoracion($valoracion->getIdContrato(), $valoracion->getIdServicio())) {
            throw new Exception("Ya existe una valoración para este contrato y servicio.");
        }

        $sql = "INSERT INTO valoracion (nota, descripcion, idContrato, idServicio) VALUES (?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);

        // Usar variables para bind_param
        $nota = $valoracion->getNota();
        $descripcion = $valoracion->getDescripcion();
        $idContrato = $valoracion->getIdContrato();
        $idServicio = $valoracion->getIdServicio();

        $stmt->bind_param("isii", $nota, $descripcion, $idContrato, $idServicio);

        return $stmt->execute();
    }
    
    public function obtenerNotaValoracion($idContrato, $idServicio) {
        $sql = "SELECT nota FROM valoracion WHERE idContrato = ? AND idServicio = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ii", $idContrato, $idServicio);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? $row['nota'] : null; // Devuelve la nota si existe, o null si no hay valoración
    }
}
?>