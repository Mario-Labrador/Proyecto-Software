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
                $result['fechaNacimiento'],
                $result['foto_perfil']
            );
        } else {
            return null;  // Si no existe la persona con ese DNI
        }
    }

    // 🔹 Obtener una persona por su email (para login)
    public function getPersonaByEmail($email) {
        $pdo = Database::connect();
        $sql = "SELECT * FROM persona WHERE emailPersona = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
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
                $result['fechaNacimiento'],
                $result['foto_perfil']
            );
        } else {
            return null;
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
        $telefono = $persona->getTelefono();
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
    public function existeDni($dni) {
        $pdo = Database::connect();
        $sql = "SELECT COUNT(*) FROM persona WHERE dni = :dni";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':dni', $dni);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
    
    // Verifica si un email ya existe
    public function existeEmail($email) {
        $pdo = Database::connect();
        $sql = "SELECT COUNT(*) FROM persona WHERE emailPersona = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
    
    // Verifica si un teléfono ya existe
    public function existeTelefono($telefono) {
        $pdo = Database::connect();
        $sql = "SELECT COUNT(*) FROM persona WHERE telefonoPersona = :telefono";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function updatePersona(PersonaVO $persona) {
        $pdo = Database::connect();
    
        $sql = "UPDATE persona SET 
                    nombrePersona = :nombrePersona,
                    apellidosPersona = :apellidosPersona,
                    emailPersona = :emailPersona,
                    contrasenyaPersona = :contrasenyaPersona,
                    telefonoPersona = :telefonoPersona,
                    fechaNacimiento = :fechaNacimiento,
                    foto_perfil = :foto_perfil
                WHERE dni = :dni";
        
        // Guardar resultados en variables temporales
        $nombre = $persona->getNombrePersona();
        $apellidos = $persona->getApellidosPersona();
        $email = $persona->getEmailPersona();
        $contrasenya = $persona->getContrasenyaPersona();
        $telefono = $persona->getTelefono();
        $fechaNacimiento = $persona->getFechaNacimiento();
        $fotoPerfil = $persona->getFotoPerfil();
        $dni = $persona->getDni();
        
        $stmt = $pdo->prepare($sql);
        
        // Ahora usa las variables temporales
        $stmt->bindParam(':nombrePersona', $nombre);
        $stmt->bindParam(':apellidosPersona', $apellidos);
        $stmt->bindParam(':emailPersona', $email);
        $stmt->bindParam(':contrasenyaPersona', $contrasenya);
        $stmt->bindParam(':telefonoPersona', $telefono);
        $stmt->bindParam(':fechaNacimiento', $fechaNacimiento);
        $stmt->bindParam(':foto_perfil', $fotoPerfil);
        $stmt->bindParam(':dni', $dni);
        
        $stmt->execute();
    }
    public function getFotoPerfilPorDni($dni) {
        $pdo = Database::connect();
        $sql = "SELECT foto_perfil FROM persona WHERE dni = :dni";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':dni', $dni);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['foto_perfil'] : '../assets/images/default.png'; // Si no tiene foto, usar la predeterminada
    }

    // Obtener el nombre completo de la persona según el DNI
    public function getNombrePorDni($dni) {
        $pdo = Database::connect();
        $sql = "SELECT nombrePersona FROM persona WHERE dni = :dni";  
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':dni', $dni);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['nombrePersona'] : null;  
    }
    public function getApellidoPorDni($dni) {
        $pdo = Database::connect();
        $sql = "SELECT apellidosPersona FROM persona WHERE dni = :dni"; 
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':dni', $dni);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['apellidosPersona'] : null;  
    }
    
}
?>
