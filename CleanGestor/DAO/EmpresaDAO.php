<?php
include_once '../config/db.php';
include_once '../VO/EmpresaVO.php';

class EmpresaDAO {

    // Obtener una empresa por su ID
    public function getEmpresaById($idEmpresa) {
        $pdo = Database::connect();
        $sql = "SELECT * FROM empresa WHERE idEmpresa = :idEmpresa";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idEmpresa', $idEmpresa);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new EmpresaVO(
                $result['idEmpresa'],
                $result['nombreEmpresa'],
                $result['telefonoEmpresa'],
                $result['direccion'],
                $result['correoDirector']  // <- importante
            );
        } else {
            return null;
        }
    }

    // Insertar una nueva empresa
    public function insertEmpresa(EmpresaVO $empresa) {
        $pdo = Database::connect();

        $id = $empresa->getIdEmpresa();
        $nombre = $empresa->getNombreEmpresa();
        $telefono = $empresa->getTelefonoEmpresa();
        $direccion = $empresa->getDireccion();
        $correo = $empresa->getCorreoDirector();

        $sql = "INSERT INTO empresa (idEmpresa, nombreEmpresa, telefonoEmpresa, direccion, correoDirector) 
                VALUES (:idEmpresa, :nombreEmpresa, :telefonoEmpresa, :direccion, :correoDirector)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idEmpresa', $id);
        $stmt->bindParam(':nombreEmpresa', $nombre);
        $stmt->bindParam(':telefonoEmpresa', $telefono);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':correoDirector', $correo);
        $stmt->execute();
    }

    // Verifica si ya existe una empresa con ese correo de director
    public function existeCorreoAdmin($email) {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM empresa WHERE correoDirector = ?");
        $stmt->execute([$email]);
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    
    public function getAllEmpresas() {
    $pdo = Database::connect();
    $sql = "SELECT idEmpresa, nombreEmpresa, telefonoEmpresa, direccion FROM empresa"; // Cambiado 'id', 'nombre', etc., por los nombres correctos
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Devuelve un array con todas las empresas
    }
}
?>
