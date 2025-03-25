<?php

class MarcasModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Obtener todas las marcas
    public function getAll() {
        $query = $this->db->query("SELECT * FROM marcas");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener una marca por ID
    public function getById($id) {
        $query = $this->db->prepare("SELECT * FROM marcas WHERE id = :id");
        $query->execute(['id' => $id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Crear una nueva marca
    public function create($data) {
        $query = $this->db->prepare("INSERT INTO marcas (nombre) VALUES (:nombre)");
        $query->execute($data);
        return $this->db->lastInsertId();
    }

    // Actualizar una marca
    public function update($id, $data) {
        $data['id'] = $id;
        $query = $this->db->prepare("UPDATE marcas SET nombre = :nombre WHERE id = :id");
        $query->execute($data);
    }

    // Eliminar una marca
    public function delete($id) {
        $query = $this->db->prepare("DELETE FROM marcas WHERE id = :id");
        $query->execute(['id' => $id]);
    }
}
