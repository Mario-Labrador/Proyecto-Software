<?php

class ContratoServicioVO {
    private $idContrato;
    private $idServicio;

    public function __construct($idContrato, $idServicio) {
        $this->idContrato = $idContrato;
        $this->idServicio = $idServicio;
    }

    public function getIdContrato() {
        return $this->idContrato;
    }

    public function getIdServicio() {
        return $this->idServicio;
    }
}
?>