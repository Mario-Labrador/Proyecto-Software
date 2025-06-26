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
    private $foto_perfil; 

    // Constructor
    public function __construct($dni, $nombrePersona, $apellidosPersona, $emailPersona, $contrasenyaPersona, $telefonoPersona, $fechaNacimiento, $foto_perfil = null) {
        $this->dni = $dni;
        $this->nombrePersona = $nombrePersona;
        $this->apellidosPersona = $apellidosPersona;
        $this->emailPersona = $emailPersona;
        $this->contrasenyaPersona = $contrasenyaPersona;
        $this->telefonoPersona = $telefonoPersona;
        $this->fechaNacimiento = $fechaNacimiento;
        
        if (empty($foto_perfil)) {
            $this->foto_perfil = '../assets/uploads/default.png';  // Ruta a la imagen por defecto
        } else {
            $this->foto_perfil = $foto_perfil;
        }
    }

    public function getFotoPerfil() {
        return $this->foto_perfil;
    }

    public function setFotoPerfil($foto_perfil) {
        $this->foto_perfil = $foto_perfil;
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

    public function setTelefono($telefonoPersona) {
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
