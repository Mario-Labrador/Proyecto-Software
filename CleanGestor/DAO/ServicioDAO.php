<!-- filepath: c:\xampp\htdocs\CleanGestor\DAO\ServicioDAO.php -->
<?php
require_once("../VO/ServicioVO.php");

class ServicioDAO {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Método para insertar un servicio
    public function insertarServicio(ServicioVO $servicio) {
        $sql = "INSERT INTO servicio (nombreServicio, descripcion, precio, horas, sueldo, idEmpresa)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);

        // Asignar valores a variables antes de pasarlas a bind_param
        $nombreServicio = $servicio->getNombreServicio();
        $descripcion = $servicio->getDescripcion();
        $precio = $servicio->getPrecio();
        $horas = $servicio->getHoras();
        $sueldo = $servicio->getSueldo();
        $idEmpresa = $servicio->getEmpresa();

        // Pasar las variables por referencia
        $stmt->bind_param(
            "ssddis", // Tipos de datos: string, string, double, double, integer, string
            $nombreServicio,
            $descripcion,
            $precio,
            $horas,
            $sueldo,
            $idEmpresa
        );

        if ($stmt->execute()) {
            return true;
        } else {
            throw new mysqli_sql_exception("Error al insertar el servicio: " . $stmt->error);
        }
    }
}
?>