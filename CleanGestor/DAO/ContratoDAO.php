<?php
require_once("../VO/ContratoVO.php");

class ContratoDAO {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function crearContrato(ContratoVO $contrato) {
        $sql = "INSERT INTO contrato (fecha, lugar, dni) VALUES (?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param(
            "sss",
            $contrato->getFecha(),
            $contrato->getLugar(),
            $contrato->getDni()
        );
        return $stmt->execute();
    }

    public function verificarContrato($dni) {
        $sql = "SELECT * FROM contrato WHERE dni = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->num_rows > 0; // Devuelve true si existe un contrato
    }

    public function obtenerContratoAbierto($dni) {
        $sql = "SELECT * FROM contrato WHERE dni = ? AND estado = 'abierto'";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc(); // Devuelve el contrato abierto o null si no existe
    }
    public function cerrarContrato(ContratoVO $contrato) {
        try {
            // En este caso, siempre actualizas el estado a 'finalizado'
            $sql = "UPDATE contrato SET estado = 'finalizado' WHERE idContrato = ?";  
            
            $stmt = $this->conexion->prepare($sql);
            
            // Aquí solo necesitas el idContrato del objeto para actualizar el registro
            $stmt->bind_param('i', $contrato->getIdContrato()); // 'i' es para integer
            
            $stmt->execute();
            
            return true;
        } catch (Exception $e) {
            echo "Error al actualizar el estado del contrato: " . $e->getMessage();
            return false;
        }
    }
    public function obtenerContratosConServicios($dni) {
        $sqlContratos = "SELECT c.idContrato, c.fecha, c.lugar 
                         FROM contrato c 
                         WHERE c.dni = ?";
        $stmt = $this->conexion->prepare($sqlContratos);
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        $resultContratos = $stmt->get_result();
        $contratos = $resultContratos->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        // Obtener los servicios asociados a cada contrato
        $contratoServicios = [];
        foreach ($contratos as $contrato) {
            $idContrato = $contrato['idContrato'];
            $sqlServicios = "SELECT s.nombreServicio, s.precio 
                             FROM servicio s
                             INNER JOIN contratoservicio cs ON s.idServicio = cs.idServicio
                             WHERE cs.idContrato = ?";
            $stmt = $this->conexion->prepare($sqlServicios);
            $stmt->bind_param("i", $idContrato);
            $stmt->execute();
            $resultServicios = $stmt->get_result();
            $contratoServicios[$idContrato] = $resultServicios->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
        }

        return ['contratos' => $contratos, 'servicios' => $contratoServicios];
    }

    
}
?>