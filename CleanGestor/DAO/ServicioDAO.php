<!-- filepath: c:\xampp\htdocs\CleanGestor\DAO\ServicioDAO.php -->
<?php
//ServicioDAO.php
//Alberto Lacarta
require_once("../VO/ServicioVO.php");

class ServicioDAO {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Método para insertar un servicio
    public function insertarServicio(ServicioVO $servicio) {
        $sql = "INSERT INTO servicio (nombreServicio, descripcion, precio, horas, sueldo, idEmpresa, fotoServicio)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);

        // Asignar valores a variables antes de pasarlas a bind_param
        $nombreServicio = $servicio->getNombreServicio();
        $descripcion = $servicio->getDescripcion();
        $precio = $servicio->getPrecio();
        $horas = $servicio->getHoras();
        $sueldo = $servicio->getSueldo();
        $idEmpresa = $servicio->getEmpresa();
        $fotoServicio = $servicio->getFotoServicio(); 

        // Pasar las variables por referencia
        $stmt->bind_param(
            "ssddiss", // Tipos de datos: string, string, double, double, integer, string, string
            $nombreServicio,
            $descripcion,
            $precio,
            $horas,
            $sueldo,
            $idEmpresa,
            $fotoServicio
        );

        if ($stmt->execute()) {
            return true;
        } else {
            throw new mysqli_sql_exception("Error al insertar el servicio: " . $stmt->error);
        }
    }
}
?>