
/* Creo la base de datos */
CREATE DATABASE tienda_ropa;
USE tienda_ropa;

/* Creo las tablas */
CREATE TABLE marcas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);


CREATE TABLE tipo_de_ropa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    marca_id INT,
    precio DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL,
    FOREIGN KEY (marca_id) REFERENCES marcas(id)
);


CREATE TABLE ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha_venta DATE NOT NULL
);


CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    telefono VARCHAR(15),
    direccion TEXT
);


CREATE TABLE detalle_ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venta_id INT NOT NULL,
    tipo_de_ropa_id INT NOT NULL, 
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (venta_id) REFERENCES ventas(id),
    FOREIGN KEY (tipo_de_ropa_id) REFERENCES tipo_de_ropa(id) 
);


/* Inserto los datos */
INSERT INTO marcas (nombre) VALUES 
('Nike'),
('Adidas'),
('Puma'),
('Gucci'),
('Lacoste'),
('Prada'),
('Channel'),
('Dior');


INSERT INTO tipo_de_ropa (nombre, marca_id, precio, stock) VALUES 
('Camiseta Deportiva', 1, 1700, 100), 
('Pantalón Deportivo', 2, 1800, 50), 
('Tennis', 3, 54000, 30), 
('Sudadera', 4, 23000, 20), 
('Leggins', 5, 18500, 70);


INSERT INTO ventas (fecha_venta) VALUES 
('2023-02-01'),
('2023-02-02'),
('2023-02-03');


INSERT INTO clientes (nombre, email, telefono, direccion) VALUES
('Juan Pérez', 'juan.perez@example.com', '88257628', 'Puntarenas'),
('María López', 'maria.lopez@example.com', '88549203', 'Cartago'),
('Carlos Gómez', 'carlos.gomez@example.com', '88975430', 'Pejibaye');


INSERT INTO detalle_ventas (venta_id, tipo_de_ropa_id, cantidad, precio_unitario) VALUES
(1, 1, 2, 1700),
(1, 3, 1, 54000),
(2, 2, 1, 1800),
(3, 5, 3, 18500);


/* Eliminar o Actualizar Datos*/

-- Elimino un datos
DELETE FROM tipo_de_ropa WHERE id = 4;

-- Actualizo un dato
UPDATE tipo_de_ropa SET stock = stock - 3 WHERE id = 1;


/* Consultas */
SELECT 
    tipo_de_ropa_id, 
    SUM(cantidad) AS cantidad_vendida 
FROM detalle_ventas 
JOIN ventas v ON detalle_ventas.venta_id = v.id
WHERE fecha_venta = '2023-02-02'
GROUP BY tipo_de_ropa_id;

/* Creo las vistas */

-- Aqui obtengo la lista de todas las marcas que tienen al menos una venta
CREATE VIEW marcas_con_ventas AS
SELECT DISTINCT m.nombre AS marca
FROM marcas m
JOIN tipo_de_ropa tr ON m.id = tr.marca_id
JOIN detalle_ventas dv ON tr.id = dv.tipo_de_ropa_id;

-- Aqui obtengo la ropa vendida y su cantidad restante en stock
CREATE VIEW ropa_vendida_stock AS
SELECT 
    tr.nombre AS tipo_de_ropa, 
    SUM(dv.cantidad) AS cantidad_vendida, 
    tr.stock AS cantidad_restante 
FROM tipo_de_ropa tr
JOIN detalle_ventas dv ON tr.id = dv.tipo_de_ropa_id
GROUP BY tr.id;

-- Aqui obtengo el listado de las 5 marcas más vendidas y su cantidad de ventas
CREATE VIEW top_5_marcas_vendidas AS
SELECT 
    m.nombre AS marca, 
    SUM(dv.cantidad) AS cantidad_vendida 
FROM marcas m
JOIN tipo_de_ropa tr ON m.id = tr.marca_id
JOIN detalle_ventas dv ON tr.id = dv.tipo_de_ropa_id
GROUP BY m.id
ORDER BY cantidad_vendida DESC
LIMIT 5;