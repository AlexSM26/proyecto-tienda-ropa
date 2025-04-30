<?php

class ReportesController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function marcasConVentas() {
        try {
            $query = $this->db->query("
                SELECT DISTINCT m.id, m.nombre AS marca
                FROM marcas m
                JOIN tipo_de_ropa tr ON m.id = tr.marca_id
                JOIN detalle_ventas dv ON tr.id = dv.tipo_de_ropa_id
                WHERE dv.cantidad > 0
                ORDER BY m.nombre
            ");
            
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode([
                'success' => true,
                'data' => $data,
                'count' => count($data)
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage(),
                'data' => []
            ]);
        }
    }

    public function prendasVendidasStock() {
        try {
            $query = $this->db->query("
                SELECT 
                    tr.id,
                    tr.nombre AS prenda, 
                    IFNULL(SUM(dv.cantidad), 0) AS vendidas, 
                    tr.stock
                FROM tipo_de_ropa tr
                LEFT JOIN detalle_ventas dv ON tr.id = dv.tipo_de_ropa_id
                GROUP BY tr.id
                HAVING vendidas > 0 OR tr.stock > 0
                ORDER BY vendidas DESC
            ");
            
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode([
                'success' => true,
                'data' => $data,
                'count' => count($data)
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage(),
                'data' => []
            ]);
        }
    }

    public function top5MarcasVendidas() {
        try {
            $query = $this->db->query("
                SELECT 
                    m.id,
                    m.nombre AS marca, 
                    IFNULL(SUM(dv.cantidad), 0) AS total_vendido
                FROM marcas m
                LEFT JOIN tipo_de_ropa tr ON m.id = tr.marca_id
                LEFT JOIN detalle_ventas dv ON tr.id = dv.tipo_de_ropa_id
                GROUP BY m.id
                HAVING total_vendido > 0
                ORDER BY total_vendido DESC
                LIMIT 5
            ");
            
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode([
                'success' => true,
                'data' => $data,
                'count' => count($data)
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage(),
                'data' => []
            ]);
        }
    }
}