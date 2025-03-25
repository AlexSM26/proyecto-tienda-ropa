<?php

require_once __DIR__ . '/../models/TipoDeRopaModel.php';

class TipoDeRopaController {
    private $model;

    public function __construct($db) {
        $this->model = new TipoDeRopaModel($db);
    }

    public function getAll() {
        $data = $this->model->getAll();
        echo json_encode($data);
    }

    
    public function getById($id) {
        $data = $this->model->getById($id);
        echo json_encode($data);
    }

    // Crear un nuevo cliente
    public function create() {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $this->model->create($data);
        echo json_encode(['id' => $id]);
    }

    // Actualizar un cliente
    public function update($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->model->update($id, $data);
        echo json_encode(['message' => 'El tipo de ropa se a actualizado']);
    }

    // Eliminar un cliente
    public function delete($id) {
        $this->model->delete($id);
        echo json_encode(['message' => 'Este tipo de ropa se a eliminado']);
    }
}