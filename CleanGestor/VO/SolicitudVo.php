<?php

class SolicitudVO {
    private $id;
    private $dni;
    private $idEmpresa;
    private $fechaSolicitud;
    private $estado;

    public function __construct($id = null, $dni = null, $idEmpresa = null, $fechaSolicitud = null, $estado = 'pendiente') {
        $this->id = $id;
        $this->dni = $dni;
        $this->idEmpresa = $idEmpresa;
        $this->fechaSolicitud = $fechaSolicitud ?? date('Y-m-d H:i:s');
        $this->estado = $estado;
    }

    public function getId() { return $this->id; }
    public function getDni() { return $this->dni; }
    public function getIdEmpresa() { return $this->idEmpresa; }
    public function getFechaSolicitud() { return $this->fechaSolicitud; }
    public function getEstado() { return $this->estado; }

    public function setId($id) { $this->id = $id; }
    public function setDni($dni) { $this->dni = $dni; }
    public function setIdEmpresa($idEmpresa) { $this->idEmpresa = $idEmpresa; }
    public function setFechaSolicitud($fechaSolicitud) { $this->fechaSolicitud = $fechaSolicitud; }
    public function setEstado($estado) { $this->estado = $estado; }
}
