<?php

require_once __DIR__ . '/../models/MarcasModel.php';

class MarcasController {
    private $model;

    public function __construct($db) {
        $this->model = new MarcasModel($db);
    }

    // Obtener todas las marcas
    public function getAll() {
        $data = $this->model->getAll();
        echo json_encode($data);
    }

    // Obtener una marca por ID
    public function getById($id) {
        $data = $this->model->getById($id);
        echo json_encode($data);
    }

    // Crear una nueva marca
    public function create() {
        $data = json_decode(file_get_contents('php://input'), true);

        // Validar que los datos estén completos
        if (isset($data['nombre'])) {
            // Insertar la nueva marca
            $id = $this->model->create($data);
            
            // Devolver el ID de la nueva marca
            echo json_encode(['id' => $id]);
        } else {
            // Datos incompletos
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(['message' => 'Datos incompletos']);
        }
    }

    // Actualizar una marca
    public function update($id) {
        $data = json_decode(file_get_contents('php://input'), true);

        // Validar que los datos estén completos
        if (isset($data['nombre'])) {
            // Actualizar la marca
            $this->model->update($id, $data);
            
            // Devolver un mensaje de éxito
            echo json_encode(['message' => 'Marca actualizada']);
        } else {
            // Datos incompletos
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(['message' => 'Datos incompletos']);
        }
    }

    // Eliminar una marca
    public function delete($id) {
        $this->model->delete($id);
        echo json_encode(['message' => 'Marca eliminada']);
    }
}