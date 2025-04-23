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

        // Evitar el error "Only variables should be passed by reference"
        $rol = $trabajador->getRol();
        $especialidad = $trabajador->getEspecialidad();
        $dni = $trabajador->getDni();
        $idEmpresa = $trabajador->getIdEmpresa();

        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':especialidad', $especialidad);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':idEmpresa', $idEmpresa);

        $stmt->execute();
    }

    // Verificar si un correo pertenece a un administrador
    public function verificarCorreoAdmin($correo) {
        $pdo = Database::connect();
        $sql = "SELECT * FROM empresa WHERE correoAdmin = :correo";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? true : false; // Retorna true si existe un admin con ese correo, de lo contrario false
    }

    // Verificar si un trabajador existe por su DNI
    public function esTrabajador($dni) {
        $pdo = Database::connect();
        $sql = "SELECT COUNT(*) FROM trabajador WHERE dni = :dni";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':dni', $dni);
        $stmt->execute();
        
        $count = $stmt->fetchColumn();
        return $count > 0; // Retorna true si existe al menos un trabajador con ese DNI
    }
    public function actualizarEmpresaTrabajador($dni, $idEmpresa) {
        $pdo = Database::connect();
        $sql = "UPDATE trabajador SET idEmpresa = :idEmpresa WHERE dni = :dni";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':idEmpresa', $idEmpresa);
        $stmt->execute();
    }
}

?>