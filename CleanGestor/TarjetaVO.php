<?php

class Tarjeta {
    private $idContrato;
    private $numeroTarjeta;
    private $cvv;
    private $fechaExpiracion;

    public function __construct($idContrato, $numeroTarjeta, $cvv, $fechaExpiracion) {
        $this->idContrato = $idContrato;
        $this->numeroTarjeta = $numeroTarjeta;
        $this->cvv = $cvv;
        $this->fechaExpiracion = $fechaExpiracion;
    }

    public function getIdContrato() {
        return $this->idContrato;
    }

    public function getNumeroTarjeta() {
        return $this->numeroTarjeta;
    }

    public function getCvv() {
        return $this->cvv;
    }

    public function getFechaExpiracion() {
        return $this->fechaExpiracion;
    }

    public function setIdContrato($idContrato) {
        $this->idContrato = $idContrato;
    }

    public function setNumeroTarjeta($numeroTarjeta) {
        $this->numeroTarjeta = $numeroTarjeta;
    }

    public function setCvv($cvv) {
        $this->cvv = $cvv;
    }

    public function setFechaExpiracion($fechaExpiracion) {
        $this->fechaExpiracion = $fechaExpiracion;
    }
}
?>