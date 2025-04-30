<?php

class TipoDeRopaModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }


    // Obtener todas las prendas con información de marca
    public function getAll() {
        $query = $this->db->query("
            SELECT tr.*, m.nombre as marca_nombre 
            FROM tipo_de_ropa tr
            LEFT JOIN marcas m ON tr.marca_id = m.id
        ");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener una prenda por ID con información de marca
    public function getById($id) {
        $query = $this->db->prepare("
            SELECT tr.*, m.nombre as marca_nombre 
            FROM tipo_de_ropa tr
            LEFT JOIN marcas m ON tr.marca_id = m.id
            WHERE tr.id = :id
        ");
        $query->execute(['id' => $id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Crear nueva prenda con validación
    public function create($data) {
        // Validar datos requeridos
        if (empty($data['nombre']) || !isset($data['marca_id']) || !isset($data['precio']) || !isset($data['stock'])) {
            throw new Exception("Datos incompletos para crear la prenda");
        }

        $query = $this->db->prepare("
            INSERT INTO tipo_de_ropa 
            (nombre, marca_id, precio, stock) 
            VALUES (:nombre, :marca_id, :precio, :stock)
        ");
        
        // Asegurar tipos de datos correctos
        $params = [
            ':nombre' => $data['nombre'],
            ':marca_id' => (int)$data['marca_id'],
            ':precio' => (float)$data['precio'],
            ':stock' => (int)$data['stock']
        ];
        
        if ($query->execute($params)) {
            return $this->db->lastInsertId();
        } else {
            throw new Exception("Error al ejecutar la consulta: " . implode(", ", $query->errorInfo()));
        }
    }

    // Actualizar un cliente
    public function update($id, $data) {
        // Validar datos antes de actualizar
        if (!is_numeric($id)) {
            throw new Exception("ID inválido");
        }
    
        $query = $this->db->prepare("
            UPDATE tipo_de_ropa 
            SET nombre = :nombre, 
                marca_id = :marca_id, 
                precio = :precio, 
                stock = :stock 
            WHERE id = :id
        ");
        
        $params = [
            ':id' => (int)$id,
            ':nombre' => $data['nombre'],
            ':marca_id' => (int)$data['marca_id'],
            ':precio' => (float)$data['precio'],
            ':stock' => (int)$data['stock']
        ];
        
        if (!$query->execute($params)) {
            $errorInfo = $query->errorInfo();
            throw new Exception("Error al actualizar: " . $errorInfo[2]);
        }
        
        // Verificar si se actualizó alguna fila
        if ($query->rowCount() === 0) {
            throw new Exception("No se encontró la prenda con ID $id o los datos son idénticos");
        }
        
        return true;
    }

    // Eliminar un cliente
    public function delete($id) {
        $query = $this->db->prepare("DELETE FROM tipo_de_ropa WHERE id = :id");
        $query->execute(['id' => $id]);
    }
}