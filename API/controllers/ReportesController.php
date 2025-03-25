<?php

class ReportesController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Reporte 1: Listar todas las marcas que tienen al menos una venta
    public function marcasConVentas() {
        $query = $this->db->query("
            SELECT DISTINCT m.nombre AS marca
            FROM marcas m
            JOIN tipo_de_ropa tr ON m.id = tr.marca_id
            JOIN detalle_ventas dv ON tr.id = dv.tipo_de_ropa_id
        ");
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($data);
    }

    // Reporte 2: Mostrar las prendas vendidas junto con la cantidad restante en stock
    public function prendasVendidasStock() {
        $query = $this->db->query("
            SELECT 
                tr.nombre AS tipo_de_ropa, 
                SUM(dv.cantidad) AS cantidad_vendida, 
                tr.stock AS cantidad_restante 
            FROM tipo_de_ropa tr
            JOIN detalle_ventas dv ON tr.id = dv.tipo_de_ropa_id
            GROUP BY tr.id
        ");
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($data);
    }

    // Reporte 3: Listar las 5 marcas más vendidas, mostrando la cantidad de ventas de cada una
    public function top5MarcasVendidas() {
        $query = $this->db->query("
            SELECT 
                m.nombre AS marca, 
                SUM(dv.cantidad) AS cantidad_vendida 
            FROM marcas m
            JOIN tipo_de_ropa tr ON m.id = tr.marca_id
            JOIN detalle_ventas dv ON tr.id = dv.tipo_de_ropa_id
            GROUP BY m.id
            ORDER BY cantidad_vendida DESC
            LIMIT 5
        ");
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($data);
    }
}