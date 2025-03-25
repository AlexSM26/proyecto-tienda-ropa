<?php

class TipoDeRopaModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Obtener todos los clientes
    public function getAll() {
        $query = $this->db->query("SELECT * FROM tipo_de_ropa");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un cliente por ID
    public function getById($id) {
        $query = $this->db->prepare("SELECT * FROM tipo_de_ropa WHERE id = :id");
        $query->execute(['id' => $id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo cliente
    public function create($data) {
        $query = $this->db->prepare("INSERT INTO tipo_de_ropa (nombre, marca_id, precio, stock) VALUES (:nombre, :marca_id, :precio, :stock)");
        $query->execute($data);
        return $this->db->lastInsertId();
    }

    // Actualizar un cliente
    public function update($id, $data) {
        $data['id'] = $id;
        $query = $this->db->prepare("UPDATE tipo_de_ropa SET nombre = :nombre, marca_id = :marca_id, precio = :precio, stock = :stock WHERE id = :id");
        $query->execute($data);
    }

    // Eliminar un cliente
    public function delete($id) {
        $query = $this->db->prepare("DELETE FROM tipo_de_ropa WHERE id = :id");
        $query->execute(['id' => $id]);
    }
}