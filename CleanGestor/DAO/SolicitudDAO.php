<?php
include_once '../VO/SolicitudVO.php';
include_once '../config/db.php';

class SolicitudDAO {
    private $conn;

    // Constructor para establecer la conexión con la base de datos
    public function __construct() {
        $this->conn = Database::connect();
    }

    // Método para enviar una nueva solicitud de empleo
    public function enviarSolicitud(SolicitudVO $solicitud) {
        $sql = "INSERT INTO solicitudempleo (dniTrabajador, idEmpresa, fechaSolicitud, estado) 
                VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $solicitud->getDni(),
            $solicitud->getIdEmpresa(),
            $solicitud->getFechaSolicitud(),
            $solicitud->getEstado()
        ]);
    }

    // Método para verificar si el trabajador ya ha solicitado en la empresa
    public function yaHaSolicitado($dni, $idEmpresa) {
        $sql = "SELECT COUNT(*) FROM solicitudempleo WHERE dniTrabajador = ? AND idEmpresa = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$dni, $idEmpresa]);
        return $stmt->fetchColumn() > 0;
    }

    // Método para obtener todas las solicitudes de una empresa
    public function obtenerSolicitudesPorEmpresa($idEmpresa) {
        $sql = "SELECT * FROM solicitudempleo WHERE idEmpresa = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idEmpresa]);

        $resultados = [];
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultados[] = new SolicitudVO(
                $fila['idSolicitud'],
                $fila['dniTrabajador'],
                $fila['idEmpresa'],
                $fila['fechaSolicitud'],
                $fila['estado']
            );
        }
        return $resultados;
    }

    // Método para actualizar el estado de una solicitud
    public function actualizarEstado($id, $nuevoEstado) {
        $sql = "UPDATE solicitudempleo SET estado = ? WHERE idSolicitud = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$nuevoEstado, $id]);
    }
    public function getSolicitudById($id) {
        $sql = "SELECT * FROM solicitudempleo WHERE idSolicitud = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($fila) {
            return new SolicitudVO(
                $fila['idSolicitud'],
                $fila['dniTrabajador'],
                $fila['idEmpresa'],
                $fila['fechaSolicitud'],
                $fila['estado']
            );
        }
        return null;  // Si no se encuentra la solicitud
    }
}
?>
