<?php

class ClientesModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Obtener todos los clientes
    public function getAll() {
        $query = $this->db->query("SELECT * FROM clientes");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un cliente por ID
    public function getById($id) {
        $query = $this->db->prepare("SELECT * FROM clientes WHERE id = :id");
        $query->execute(['id' => $id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo cliente
    public function create($data) {
        $query = $this->db->prepare("INSERT INTO clientes (nombre, email, telefono, direccion) VALUES (:nombre, :email, :telefono, :direccion)");
        $query->execute($data);
        return $this->db->lastInsertId();
    }

    // Actualizar un cliente
    public function update($id, $data) {
        $data['id'] = $id;
        $query = $this->db->prepare("UPDATE clientes SET nombre = :nombre, email = :email, telefono = :telefono, direccion = :direccion WHERE id = :id");
        $query->execute($data);
    }

    // Eliminar un cliente
    public function delete($id) {
        $query = $this->db->prepare("DELETE FROM clientes WHERE id = :id");
        $query->execute(['id' => $id]);
    }
}