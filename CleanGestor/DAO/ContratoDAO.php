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
        $sql = "SELECT * FROM contrato WHERE dni = ? AND estado = 'abierto' LIMIT 1";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        $result = $stmt->get_result();
        $contrato = $result->fetch_assoc();
        $stmt->close();
        return $contrato;
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
        $sqlContratos = "SELECT c.idContrato, c.fecha, c.lugar, c.estado 
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

public function crearContratoVacio($dni) {
    // Usar nombres exactos de columnas y proveer valores default
    $sql = "INSERT INTO contrato (dni, estado, fecha, lugar) 
            VALUES (?, 'abierto', CURDATE(), '')";
    
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("s", $dni);
    
    if (!$stmt->execute()) {
        throw new Exception("Error creando contrato: " . $stmt->error);
    }
    
    return $stmt->insert_id;
}



    public function actualizarLugarYFecha($idContrato, $lugar, $fecha) {
        $stmt = $this->conexion->prepare("UPDATE contrato SET lugar = ?, fecha = ? WHERE idContrato = ?");
        $stmt->bind_param("ssi", $lugar, $fecha, $idContrato);
        $stmt->execute();
        $stmt->close();
    }

    public function finalizarContrato($idContrato) {
        $stmt = $this->conexion->prepare("UPDATE contrato SET estado = 'finalizado' WHERE idContrato = ?");
        $stmt->bind_param("i", $idContrato);
        $stmt->execute();
        $stmt->close();
    }
}
?>
