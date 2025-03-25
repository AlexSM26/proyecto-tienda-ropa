<?php

class VentasModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Obtener todas las ventas
    public function getAll() {
        $query = $this->db->query("SELECT * FROM ventas");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener una venta por ID
    public function getById($id) {
        $query = $this->db->prepare("SELECT * FROM ventas WHERE id = :id");
        $query->execute(['id' => $id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Crear una nueva venta
    public function create($data) {
        $query = $this->db->prepare("INSERT INTO ventas (fecha_venta) VALUES (:fecha_venta)");
        $query->execute($data);
        return $this->db->lastInsertId();
    }

    // Actualizar una venta
    public function update($id, $data) {
        $data['id'] = $id;
        $query = $this->db->prepare("UPDATE ventas SET fecha_venta = :fecha_venta WHERE id = :id");
        $query->execute($data);
    }

    // Eliminar una venta
    public function delete($id) {
        $query = $this->db->prepare("DELETE FROM ventas WHERE id = :id");
        $query->execute(['id' => $id]);
    }
}