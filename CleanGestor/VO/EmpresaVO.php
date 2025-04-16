<?php

class EmpresaVO {
    private $idEmpresa;
    private $nombreEmpresa;
    private $telefonoEmpresa;
    private $direccion;

    public function __construct($idEmpresa, $nombreEmpresa, $telefonoEmpresa, $direccion) {
        $this->idEmpresa = $idEmpresa;
        $this->nombreEmpresa = $nombreEmpresa;
        $this->telefonoEmpresa = $telefonoEmpresa;
        $this->direccion = $direccion;
    }

    public function getIdEmpresa() {
        return $this->idEmpresa;
    }

    public function getNombreEmpresa() {
        return $this->nombreEmpresa;
    }

    public function getTelefonoEmpresa() {
        return $this->telefonoEmpresa;
    }

    public function getDireccion() {
        return $this->direccion;
    }
}
?>
