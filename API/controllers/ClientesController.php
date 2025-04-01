<?php

require_once __DIR__ . '/../models/ClientesModel.php';

class ClientesController {
    private $model;

    public function __construct($db) {
        $this->model = new ClientesModel($db);
    }

    // Obtener todos los clientes
    public function getAll() {
        $data = $this->model->getAll();
        echo json_encode($data);
    }

    // Obtener un cliente por ID
    public function getById($id) {
        $data = $this->model->getById($id);
        echo json_encode($data);
    }

    // Crear un nuevo cliente
    public function create() {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $this->model->create($data);
        echo json_encode(['message' => 'Se ingreso un nuevo cliente de forma correcta']);
    }

    // Actualizar un cliente
    public function update($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->model->update($id, $data);
        echo json_encode(['message' => 'Cliente actualizado']);
    }

    // Eliminar un cliente
    public function delete($id) {
        $this->model->delete($id);
        echo json_encode(['message' => 'Cliente eliminado']);
    }
}