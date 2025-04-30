<?php

class Paypal {
    private $idContrato;
    private $correo;
    private $contrasena;

    public function __construct($idContrato, $correo, $contrasena) {
        $this->idContrato = $idContrato;
        $this->correo = $correo;
        $this->contrasena = $contrasena;
    }

    public function getIdContrato() {
        return $this->idContrato;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function getContrasena() {
        return $this->contrasena;
    }

    public function setIdContrato($idContrato) {
        $this->idContrato = $idContrato;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    public function setContrasena($contrasena) {
        $this->contrasena = $contrasena;
    }
}
?>