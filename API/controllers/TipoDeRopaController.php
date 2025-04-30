<?php

require_once __DIR__ . '/../models/TipoDeRopaModel.php';

class TipoDeRopaController {
    private $model;

    public function __construct($db) {
        $this->model = new TipoDeRopaModel($db);
    }

    // Obtener todas las prendas con info de marca
    public function getAll() {
        try {
            $prendas = $this->model->getAll();
            header('Content-Type: application/json');
            echo json_encode($prendas);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // Crear nueva prenda con manejo de errores
    public function create() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            // Validar que se recibieron datos
            if ($data === null) {
                throw new Exception("Datos JSON inválidos o vacíos");
            }
            
            $id = $this->model->create($data);
            echo json_encode([
                'success' => true,
                'id' => $id,
                'message' => 'Prenda creada correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    
    public function getById($id) {
        $data = $this->model->getById($id);
        echo json_encode($data);
    }

    // Actualizar un cliente
    public function update($id) {
        try {
            // Obtener y validar datos
            $json = file_get_contents('php://input');
            if (empty($json)) {
                throw new Exception("No se recibieron datos para actualizar");
            }
            
            $data = json_decode($json, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Error al decodificar JSON: " . json_last_error_msg());
            }
    
            // Validar campos requeridos
            $required = ['nombre', 'marca_id', 'precio', 'stock'];
            foreach ($required as $field) {
                if (!isset($data[$field])) {
                    throw new Exception("El campo '$field' es requerido");
                }
            }
    
            // Convertir tipos de datos
            $data['marca_id'] = (int)$data['marca_id'];
            $data['precio'] = (float)$data['precio'];
            $data['stock'] = (int)$data['stock'];
    
            // Ejecutar actualización
            $this->model->update($id, $data);
            
            // Respuesta exitosa
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Prenda actualizada correctamente',
                'data' => $this->model->getById($id) // Devuelve los datos actualizados
            ]);
            
        } catch (Exception $e) {
            // Manejo de errores
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage(),
                'received_data' => $data ?? null,
                'request_body' => $json ?? null
            ]);
        }
    }

    // Eliminar un cliente
    public function delete($id) {
        $this->model->delete($id);
        echo json_encode(['message' => 'Este tipo de ropa se a eliminado']);
    }
}