<?php

class DetalleVentasModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Obtener todos los detalles de ventas
    public function getAll() {
        $query = $this->db->query("SELECT * FROM detalle_ventas");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un detalle de venta por ID
    public function getById($id) {
        $query = $this->db->prepare("SELECT * FROM detalle_ventas WHERE id = :id");
        $query->execute(['id' => $id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo detalle de venta
    public function create($data) {
        $query = $this->db->prepare("INSERT INTO detalle_ventas (venta_id, tipo_de_ropa_id, cantidad, precio_unitario) VALUES (:venta_id, :tipo_de_ropa_id, :cantidad, :precio_unitario)");
        $query->execute($data);
        return $this->db->lastInsertId();
    }

    // Actualizar un detalle de venta
    public function update($id, $data) {
        $data['id'] = $id;
        $query = $this->db->prepare("UPDATE detalle_ventas SET venta_id = :venta_id, tipo_de_ropa_id = :tipo_de_ropa_id, cantidad = :cantidad, precio_unitario = :precio_unitario WHERE id = :id");
        $query->execute($data);
    }

    // Eliminar un detalle de venta
    public function delete($id) {
        $query = $this->db->prepare("DELETE FROM detalle_ventas WHERE id = :id");
        $query->execute(['id' => $id]);
    }
}