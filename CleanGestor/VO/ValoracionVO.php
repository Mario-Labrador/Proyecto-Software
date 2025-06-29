<?php
// ValoracionVO.php
// Alberto Lacarta
class ValoracionVO {
    private $nota;
    private $descripcion;
    private $idContrato;
    private $idServicio;

    public function getNota() {
        return $this->nota;
    }

    public function setNota($nota) {
        $this->nota = $nota;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getIdContrato() {
        return $this->idContrato;
    }

    public function setIdContrato($idContrato) {
        $this->idContrato = $idContrato;
    }

    public function getIdServicio() {
        return $this->idServicio;
    }

    public function setIdServicio($idServicio) {
        $this->idServicio = $idServicio;
    }
}
?>