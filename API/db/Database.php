<?php

class Database {
    private $host = 'localhost:3310';
    private $db_name = 'tienda_ropa'; 
    private $username = 'root';      
    private $password = '';
    private $conn;

    // Método para conectar a la base de datos
    public function connect() {
        $this->conn = null;

        try {
            // Cadena de conexión PDO
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name}",
                $this->username,
                $this->password
            );

            // Configurar PDO para lanzar excepciones en caso de errores
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Configurar el charset a UTF-8
            $this->conn->exec("SET NAMES 'utf8'");

        } catch (PDOException $e) {
            // En caso de error, mostrar un mensaje
            echo "Error de conexión: " . $e->getMessage();
        }

        return $this->conn;
    }
}