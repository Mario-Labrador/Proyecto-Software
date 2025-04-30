<?php
class ContratoVO {
    private $idContrato;
    private $fecha;
    private $lugar;
    private $dni;
    private $estado;

    public function __construct($idContrato = null, $fecha = null, $lugar = null, $dni = null, $estado = null) {
        $this->idContrato = $idContrato;
        $this->fecha = $fecha;
        $this->lugar = $lugar;
        $this->dni = $dni;
        $this->estado = $estado;
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

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setIdContrato($idContrato) {
        $this->idContrato = $idContrato;
    }
}
?>