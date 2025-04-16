<?php
include_once '../config/db.php';
include_once '../VO/ClienteVO.php';

class ClienteDAO {

    // Obtener un cliente por su DNI
    public function getClienteByDni($dni) {
        $pdo = Database::connect();
        $sql = "SELECT * FROM cliente WHERE dni = :dni";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':dni', $dni);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new ClienteVO($result['dni']);
        } else {
            return null;  // Si no existe el cliente con ese DNI
        }
    }

    // Insertar un nuevo cliente
    public function insertCliente(ClienteVO $cliente) {
        $pdo = Database::connect();
        $sql = "INSERT INTO cliente (dni) VALUES (:dni)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':dni', $cliente->getDni());
        
        $stmt->execute();
    }
}
?>
