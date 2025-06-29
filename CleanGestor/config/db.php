
<?php
// Conecta con la base de datos MySQL usando PDO
//Alberto Lacarta
class Database {
    private static $host = 'localhost';    
    private static $dbname = 'gestor';  
    private static $username = 'root';       
    private static $password = '';          

    private static $pdo = null;

    // Método estático para crear la conexión a la base de datos
    public static function connect() {
        // Si no existe la conexión, la creamos
        if (self::$pdo === null) {
            try {
                // Usamos PDO para conectar a la base de datos
                self::$pdo = new PDO(
                    'mysql:host=' . self::$host . ';dbname=' . self::$dbname . ';charset=utf8',
                    self::$username,
                    self::$password
                );
                // Configuramos para que las excepciones se lancen cuando ocurran errores
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // Retornamos la conexión
            } catch (PDOException $e) {
                // Si ocurre un error en la conexión, lo mostramos
                die("Error de conexión: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
?>
