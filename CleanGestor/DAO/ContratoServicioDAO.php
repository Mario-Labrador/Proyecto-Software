<?php
//COntratoServicioDAO.php
//Alberto Lacarta
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
        $idContrato = $contratoServicio->getIdContrato();
		$idServicio = $contratoServicio->getIdServicio();
		
		$stmt->bind_param("ii", $idContrato, $idServicio);
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
        $stmt = $this->conexion->prepare("DELETE FROM contratoservicio WHERE idContrato = ? AND idServicio = ?");
        $stmt->bind_param("ii", $idContrato, $idServicio);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
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
            $sqlServicios = "SELECT s.idServicio, s.nombreServicio, s.precio
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
