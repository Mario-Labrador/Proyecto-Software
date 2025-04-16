<?php
include_once '../config/db.php';
include_once '../VO/TrabajadorVO.php';

class TrabajadorDAO {

    // Obtener un trabajador por su DNI
    public function getTrabajadorByDni($dni) {
        $pdo = Database::connect();
        $sql = "SELECT * FROM trabajador WHERE dni = :dni";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':dni', $dni);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new TrabajadorVO(
                $result['rol'],
                $result['especialidad'],
                $result['dni'],
                $result['idEmpresa']
            );
        } else {
            return null;  // Si no existe el trabajador con ese DNI
        }
    }

    // Insertar un nuevo trabajador
    public function insertTrabajador(TrabajadorVO $trabajador) {
        $pdo = Database::connect();
        $sql = "INSERT INTO trabajador (rol, especialidad, dni, idEmpresa) 
                VALUES (:rol, :especialidad, :dni, :idEmpresa)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':rol', $trabajador->getRol());
        $stmt->bindParam(':especialidad', $trabajador->getEspecialidad());
        $stmt->bindParam(':dni', $trabajador->getDni());
        $stmt->bindParam(':idEmpresa', $trabajador->getIdEmpresa());

        $stmt->execute();
    }
}
?>
