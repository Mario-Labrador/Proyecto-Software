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

        // Solución al Notice: usar una variable intermedia
        $dni = $cliente->getDni();
        $stmt->bindParam(':dni', $dni);

        $stmt->execute();
    }

    // Método para verificar si un cliente existe por su DNI
    public function esCliente($dni) {
        $pdo = Database::connect();
        $sql = "SELECT COUNT(*) FROM cliente WHERE dni = :dni";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':dni', $dni);
        $stmt->execute();
        
        // Si existe el cliente, devolver true
        $count = $stmt->fetchColumn();
        return $count > 0;  // Si el número de registros es mayor que 0, existe el cliente
    }
}
?>
