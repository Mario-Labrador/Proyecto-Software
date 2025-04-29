<?php
class ContratoVO {
    private $idContrato;
    private $fecha;
    private $lugar;
    private $dni;

    public function __construct($fecha, $lugar, $dni) {
        $this->fecha = $fecha;
        $this->lugar = $lugar;
        $this->dni = $dni;
    }

    public function getIdContrato() {
        return $this->idContrato;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getLugar() {
        return $this->lugar;
    }

    public function getDni() {
        return $this->dni;
    }
}
?>