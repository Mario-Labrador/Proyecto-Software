<!-- filepath: c:\xampp\htdocs\CleanGestor\models\ServicioVO.php -->
<?php
class ServicioVO {
    private $idServicio;
    private $nombreServicio;
    private $descripcion;
    private $precio;
    private $horas;
    private $sueldo;
    private $empresa;

    // Constructor
    public function __construct($nombreServicio, $descripcion, $precio, $horas, $sueldo, $empresa, $idServicio = null) {
        $this->idServicio = $idServicio;
        $this->nombreServicio = $nombreServicio;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->horas = $horas;
        $this->sueldo = $sueldo;
        $this->empresa = $empresa;
    }

    // Getters y Setters
    public function getIdServicio() {
        return $this->idServicio;
    }

    public function setIdServicio($idServicio) {
        $this->idServicio = $idServicio;
    }

    public function getNombreServicio() {
        return $this->nombreServicio;
    }

    public function setNombreServicio($nombreServicio) {
        $this->nombreServicio = $nombreServicio;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function getHoras() {
        return $this->horas;
    }

    public function setHoras($horas) {
        $this->horas = $horas;
    }

    public function getSueldo() {
        return $this->sueldo;
    }

    public function setSueldo($sueldo) {
        $this->sueldo = $sueldo;
    }

    public function getEmpresa() {
        return $this->empresa;
    }

    public function setEmpresa($empresa) {
        $this->empresa = $empresa;
    }
}
?>