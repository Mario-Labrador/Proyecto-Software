<?php
//ClienteVO.php
//Alberto Lacarta
class ClienteVO {
    private $dni;

    public function __construct($dni) {
        $this->dni = $dni;
    }

    public function getDni() {
        return $this->dni;
    }
}
?>
