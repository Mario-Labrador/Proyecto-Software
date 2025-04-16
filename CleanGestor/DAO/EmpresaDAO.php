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
                $result['direccion']
            );
        } else {
            return null;  // Si no existe la empresa con ese ID
        }
    }

    // Insertar una nueva empresa
    public function insertEmpresa(EmpresaVO $empresa) {
        $pdo = Database::connect();
        
        // Asignar a variables para evitar los "Notice"
        $id = $empresa->getIdEmpresa();
        $nombre = $empresa->getNombreEmpresa();
        $telefono = $empresa->getTelefonoEmpresa();
        $direccion = $empresa->getDireccion();
        
        // SQL de inserción
        $sql = "INSERT INTO empresa (idEmpresa, nombreEmpresa, telefonoEmpresa, direccion) 
                VALUES (:idEmpresa, :nombreEmpresa, :telefonoEmpresa, :direccion)";
        
        $stmt = $pdo->prepare($sql);
        
        // Bind de los parámetros
        $stmt->bindParam(':idEmpresa', $id);
        $stmt->bindParam(':nombreEmpresa', $nombre);
        $stmt->bindParam(':telefonoEmpresa', $telefono);
        $stmt->bindParam(':direccion', $direccion);

        // Ejecutar
        $stmt->execute();
    }
}
?>
