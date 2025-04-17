<?php

include_once '../config/db.php';

class PersonaVO {
    private $dni;
    private $nombrePersona;
    private $apellidosPersona;
    private $emailPersona;
    private $contrasenyaPersona;
    private $telefonoPersona;
    private $fechaNacimiento;

    // Constructor
    public function __construct($dni, $nombrePersona, $apellidosPersona, $emailPersona, $contrasenyaPersona, $telefonoPersona, $fechaNacimiento) {
        $this->dni = $dni;
        $this->nombrePersona = $nombrePersona;
        $this->apellidosPersona = $apellidosPersona;
        $this->emailPersona = $emailPersona;
        $this->contrasenyaPersona = $contrasenyaPersona;
        $this->telefonoPersona = $telefonoPersona;
        $this->fechaNacimiento = $fechaNacimiento;
    }

    // Métodos getter y setter
    public function getDni() {
        return $this->dni;
    }

    public function setDni($dni) {
        $this->dni = $dni;
    }

    public function getNombrePersona() {
        return $this->nombrePersona;
    }

    public function setNombrePersona($nombrePersona) {
        $this->nombrePersona = $nombrePersona;
    }

    public function getApellidosPersona() {
        return $this->apellidosPersona;
    }

    public function setApellidosPersona($apellidosPersona) {
        $this->apellidosPersona = $apellidosPersona;
    }

    public function getEmailPersona() {
        return $this->emailPersona;
    }

    public function setEmailPersona($emailPersona) {
        $this->emailPersona = $emailPersona;
    }

    public function getContrasenyaPersona() {
        return $this->contrasenyaPersona;
    }

    public function setContrasenyaPersona($contrasenyaPersona) {
        $this->contrasenyaPersona = $contrasenyaPersona;
    }

    public function getTelefono() {
        return $this->telefonoPersona;
    }

    public function setTelefonoPersona($telefonoPersona) {
        $this->telefonoPersona = $telefonoPersona;
    }

    public function getFechaNacimiento() {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento($fechaNacimiento) {
        $this->fechaNacimiento = $fechaNacimiento;
    }
}
?>
