<?php
class ContratoVO {
    private $nombreEmpresa;
    private $fechaContrato;

    // Constructor para inicializar los valores
    public function __construct($nombreEmpresa, $fechaContrato) {
        $this->nombreEmpresa = $nombreEmpresa;
        $this->fechaContrato = $fechaContrato;
    }

    // Getter para obtener el nombre de la empresa
    public function getNombreEmpresa() {
        return $this->nombreEmpresa;
    }

    // Getter para obtener la fecha del contrato
    public function getFechaContrato() {
        return $this->fechaContrato;
    }
}
?>
