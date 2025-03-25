<?php

require_once __DIR__ . '/../models/DetalleVentasModel.php';

class DetalleVentasController {
    private $model;

    public function __construct($db) {
        $this->model = new DetalleVentasModel($db);
    }

    // Obtener todos los detalles de ventas
    public function getAll() {
        $data = $this->model->getAll();
        echo json_encode($data);
    }

    // Obtener un detalle de venta por ID
    public function getById($id) {
        $data = $this->model->getById($id);
        echo json_encode($data);
    }

    // Crear un nuevo detalle de venta
    public function create() {
        $data = json_decode(file_get_contents('php://input'), true);

        // Validar que los datos estén completos
        if (isset($data['venta_id']) && isset($data['tipo_de_ropa_id']) && isset($data['cantidad']) && isset($data['precio_unitario'])) {
            // Insertar el nuevo detalle de venta
            $id = $this->model->create($data);
            
            // Devolver el ID del nuevo detalle de venta
            echo json_encode(['id' => $id]);
        } else {
            // Datos incompletos
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(['message' => 'Datos incompletos']);
        }
    }

    // Actualizar un detalle de venta
    public function update($id) {
        $data = json_decode(file_get_contents('php://input'), true);

        // Validar que los datos estén completos
        if (isset($data['venta_id']) && isset($data['tipo_de_ropa_id']) && isset($data['cantidad']) && isset($data['precio_unitario'])) {
            // Actualizar el detalle de venta
            $this->model->update($id, $data);
            
            // Devolver un mensaje de éxito
            echo json_encode(['message' => 'Detalle de venta actualizado']);
        } else {
            // Datos incompletos
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(['message' => 'Datos incompletos']);
        }
    }

    // Eliminar un detalle de venta
    public function delete($id) {
        $this->model->delete($id);
        echo json_encode(['message' => 'Detalle de venta eliminado']);
    }
}