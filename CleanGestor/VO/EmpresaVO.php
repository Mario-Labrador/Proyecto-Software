<?php
class EmpresaVO {
    private $idEmpresa;
    private $nombreEmpresa;
    private $telefonoEmpresa;
    private $direccion;
    private $correoDirector;

    public function __construct($idEmpresa, $nombreEmpresa, $telefonoEmpresa, $direccion, $correoDirector) {
        $this->idEmpresa = $idEmpresa;
        $this->nombreEmpresa = $nombreEmpresa;
        $this->telefonoEmpresa = $telefonoEmpresa;
        $this->direccion = $direccion;
        $this->correoDirector = $correoDirector;
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

    public function getCorreoDirector() {
        return $this->correoDirector;
    }

    public function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    public function setNombreEmpresa($nombreEmpresa) {
        $this->nombreEmpresa = $nombreEmpresa;
    }

    public function setTelefonoEmpresa($telefonoEmpresa) {
        $this->telefonoEmpresa = $telefonoEmpresa;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function setCorreoDirector($correoDirector) {
        $this->correoDirector = $correoDirector;
    }
}
?>
