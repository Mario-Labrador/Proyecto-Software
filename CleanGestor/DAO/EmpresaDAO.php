<?php
include_once '../config/db.php';
include_once '../VO/EmpresaVO.php';
include_once '../VO/ContratoVO.php';  // Asegúrate de incluir el VO de Contrato

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

    // Obtener todas las empresas
    public function getAllEmpresas() {
        $pdo = Database::connect();
        $sql = "SELECT idEmpresa, nombreEmpresa, telefonoEmpresa, direccion FROM empresa";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Devuelve un array con todas las empresas
    }

    // Obtener una empresa por el correo del administrador
    public function getEmpresaByAdministradorEmail($email) {
        $pdo = Database::connect();  // Asegúrate de establecer la conexión aquí
        $sql = "SELECT * FROM empresa WHERE correoDirector = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($row) {
            return new EmpresaVO(
                $row['idEmpresa'], 
                $row['nombreEmpresa'], 
                $row['telefonoEmpresa'], 
                $row['direccion'], 
                $row['correoDirector']
            );
        }
    
        return null;
    }

    // Actualizar la empresa asignada a un trabajador
    public function actualizarEmpresaTrabajador($dni, $idEmpresa) {
        $pdo = Database::connect();
        $sql = "UPDATE trabajador SET idEmpresa = :idEmpresa WHERE dni = :dni";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idEmpresa', $idEmpresa);
        $stmt->bindParam(':dni', $dni);
        $stmt->execute();
    }

    // Obtener el historial de empresas donde ha trabajado un trabajador
    public function obtenerHistorialEmpresas($dni) {
        $pdo = Database::connect();
        $sql = "SELECT e.nombreEmpresa, c.fecha 
                FROM contrato c 
                JOIN empresa e ON c.id_empresa = e.idEmpresa 
                WHERE c.dni = :dni";
    
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
        $stmt->execute();
    
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $historialEmpresas = [];
        foreach ($result as $row) {
            $historialEmpresas[] = new ContratoVO($row['nombreEmpresa'], $row['fecha']);
        }
        return $historialEmpresas;    
    }
    public function getTrabajadoresPorEmpresa($idEmpresa) {
        $pdo = Database::connect();
        $sql = "SELECT * FROM trabajador WHERE idEmpresa = :idEmpresa";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stmt->execute();
    
        $trabajadoresData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $trabajadores = [];
    
        foreach ($trabajadoresData as $row) {
            $trabajadores[] = new TrabajadorVO(
                $row['rol'],
                $row['especialidad'],
                $row['dni'],
                $row['idEmpresa']
            );
        }
    
        return $trabajadores; // Devuelve un array de objetos TrabajadorVO
    }
    
}
?>
