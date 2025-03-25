<?php

require_once __DIR__ . '/../models/VentasModel.php';

class VentasController {
    private $model;

    public function __construct($db) {
        $this->model = new VentasModel($db);
    }

    // Obtener todas las ventas
    public function getAll() {
        $data = $this->model->getAll();
        echo json_encode($data);
    }

    // Obtener una venta por ID
    public function getById($id) {
        $data = $this->model->getById($id);
        echo json_encode($data);
    }

    // Crear una nueva venta
    public function create() {
        $data = json_decode(file_get_contents('php://input'), true);

        // Validar que los datos estén completos
        if (isset($data['fecha_venta'])) {
            // Insertar la nueva venta
            $id = $this->model->create($data);
            
            // Devolver el ID de la nueva venta
            echo json_encode(['id' => $id]);
        } else {
            // Datos incompletos
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(['message' => 'Datos incompletos']);
        }
    }

    // Actualizar una venta
    public function update($id) {
        $data = json_decode(file_get_contents('php://input'), true);

        // Validar que los datos estén completos
        if (isset($data['fecha_venta'])) {
            // Actualizar la venta
            $this->model->update($id, $data);
            
            // Devolver un mensaje de éxito
            echo json_encode(['message' => 'Venta actualizada']);
        } else {
            // Datos incompletos
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(['message' => 'Datos incompletos']);
        }
    }

    // Eliminar una venta
    public function delete($id) {
        $this->model->delete($id);
        echo json_encode(['message' => 'Venta eliminada']);
    }
}