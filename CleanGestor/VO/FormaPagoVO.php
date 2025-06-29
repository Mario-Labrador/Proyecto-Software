
<?php
// FormaPagoVO.php
// Alberto Lacarta
class FormaPago {
    private $idContrato;
    private $fecha;

    public function __construct($idContrato, $fecha) {
        $this->idContrato = $idContrato;
        $this->fecha = $fecha;
    }

    public function getIdContrato() {
        return $this->idContrato;
    }

    public function setIdContrato($idContrato) {
        $this->idContrato = $idContrato;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }
}
?>