<?php
include_once '../config/db.php';
include_once '../VO/PersonaVO.php';

class PersonaDAO {

    // Obtener una persona por su DNI
    public function getPersonaByDni($dni) {
        $pdo = Database::connect();
        $sql = "SELECT * FROM persona WHERE dni = :dni";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':dni', $dni);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new PersonaVO(
                $result['dni'],
                $result['nombrePersona'],
                $result['apellidosPersona'],
                $result['emailPersona'],
                $result['contrasenyaPersona'],
                $result['telefonoPersona'],
                $result['fechaNacimiento']
            );
        } else {
            return null;  // Si no existe la persona con ese DNI
        }
    }

    // Insertar una nueva persona
    public function insertPersona(PersonaVO $persona) {
        $pdo = Database::connect();
        
        // Asignar a variables para evitar los "Notice"
        $dni = $persona->getDni();
        $nombre = $persona->getNombrePersona();
        $apellidos = $persona->getApellidosPersona();
        $email = $persona->getEmailPersona();
        $contrasenya = $persona->getContrasenyaPersona();
        $telefono = $persona->getTelefonoPersona();
        $fechaNacimiento = $persona->getFechaNacimiento();
        
        // SQL de inserción
        $sql = "INSERT INTO persona (dni, nombrePersona, apellidosPersona, emailPersona, contrasenyaPersona, telefonoPersona, fechaNacimiento) 
                VALUES (:dni, :nombrePersona, :apellidosPersona, :emailPersona, :contrasenyaPersona, :telefonoPersona, :fechaNacimiento)";
        
        $stmt = $pdo->prepare($sql);
        
        // Bind de los parámetros
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':nombrePersona', $nombre);
        $stmt->bindParam(':apellidosPersona', $apellidos);
        $stmt->bindParam(':emailPersona', $email);
        $stmt->bindParam(':contrasenyaPersona', $contrasenya);
        $stmt->bindParam(':telefonoPersona', $telefono);
        $stmt->bindParam(':fechaNacimiento', $fechaNacimiento);

        // Ejecutar
        $stmt->execute();
    }
}
?>
