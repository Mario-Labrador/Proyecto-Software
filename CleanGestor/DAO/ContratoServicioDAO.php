<?php
require_once("../VO/ContratoServicioVO.php");
require_once("../VO/ServicioVO.php");

class ContratoServicioDAO {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Método para agregar un servicio a un contrato
    public function agregarServicioAContrato(ContratoServicioVO $contratoServicio) {
        $sql = "INSERT INTO contratoservicio (idContrato, idServicio) VALUES (?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param(
            "ii",
            $contratoServicio->getIdContrato(),
            $contratoServicio->getIdServicio()
        );
        return $stmt->execute();
    }

    // Método para obtener los servicios de un contrato
    public function obtenerServiciosPorContrato($idContrato) {
    $sql = "SELECT s.idServicio, s.nombreServicio, s.precio, s.fotoServicio
            FROM servicio s
            INNER JOIN contratoservicio cs ON s.idServicio = cs.idServicio
            WHERE cs.idContrato = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("i", $idContrato);
    $stmt->execute();
    return $stmt->get_result();
    }

    // Método para eliminar un servicio de un contrato
    public function eliminarServicioDeContrato($idContrato, $idServicio) {
        $sql = "DELETE FROM contratoservicio WHERE idContrato = ? AND idServicio = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ii", $idContrato, $idServicio);
        return $stmt->execute();
    }

    // Método para verificar si un servicio ya está en un contrato
    public function servicioYaEnContrato($idContrato, $idServicio) {
        $sql = "SELECT * FROM contratoservicio WHERE idContrato = ? AND idServicio = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ii", $idContrato, $idServicio);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->num_rows > 0; // Devuelve true si el servicio ya está en el contrato
    }

    public function obtenerContratosConServicios($dni) {
        $sqlContratos = "SELECT c.idContrato, c.fecha, c.lugar 
                         FROM contrato c 
                         WHERE c.dni = ?";
        $stmt = $this->conexion->prepare($sqlContratos);
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        $resultContratos = $stmt->get_result();
    
        $contratos = [];
        $servicios = [];
    
        while ($contrato = $resultContratos->fetch_assoc()) {
            $contratos[] = $contrato;
    
            // Obtener servicios para cada contrato
            $sqlServicios = "SELECT s.idServicio, s.nombreServicio, s.precio 
                             FROM servicio s 
                             INNER JOIN contratoservicio cs ON s.idServicio = cs.idServicio 
                             WHERE cs.idContrato = ?";
            $stmtServicios = $this->conexion->prepare($sqlServicios);
            $stmtServicios->bind_param("i", $contrato['idContrato']);
            $stmtServicios->execute();
            $resultServicios = $stmtServicios->get_result();
    
            while ($servicio = $resultServicios->fetch_assoc()) {
                $servicios[$contrato['idContrato']][] = $servicio;
            }
        }
    
        return ['contratos' => $contratos, 'servicios' => $servicios];
    }

}
?>