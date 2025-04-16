<?php

class TrabajadorVO {
    private $rol;
    private $especialidad;
    private $dni;
    private $idEmpresa;

    public function __construct($rol, $especialidad, $dni, $idEmpresa) {
        $this->rol = $rol;
        $this->especialidad = $especialidad;
        $this->dni = $dni;
        $this->idEmpresa = $idEmpresa;
    }

    public function getRol() {
        return $this->rol;
    }

    public function getEspecialidad() {
        return $this->especialidad;
    }

    public function getDni() {
        return $this->dni;
    }

    public function getIdEmpresa() {
        return $this->idEmpresa;
    }
}
?>
