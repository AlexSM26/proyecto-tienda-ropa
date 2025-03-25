<?php

// Incluir la clase Database
require_once __DIR__ . '/../db/Database.php';


// Crear una instancia de Database y conectar a la base de datos
$database = new Database();
$db = $database->connect();

// Incluir los controladores
require_once __DIR__ . '/../controllers/ClientesController.php';
require_once __DIR__ . '/../controllers/MarcasController.php';
require_once __DIR__ . '/../controllers/TipoDeRopaController.php';
require_once __DIR__ . '/../controllers/VentasController.php';
require_once __DIR__ . '/../controllers/DetalleVentasController.php';
require_once __DIR__ . '/../controllers/ReportesController.php';

// Crear instancias de los controladores y pasar la conexión a la base de datos
$clientesController = new ClientesController($db);
$marcasController = new MarcasController($db);
$tipoDeRopaController = new TipoDeRopaController($db);
$ventasController = new VentasController($db);
$detalleVentasController = new DetalleVentasController($db);
$reportesController = new ReportesController($db);

// Obtener la solicitud HTTP y la URL
$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];

// Eliminar la parte base de la URL (/proyecto/API/public/index.php)
$base_path = '/proyecto/API/public/index.php';
$api_path = str_replace($base_path, '', $request_uri);

// Dividir la URL en partes
$uri_parts = explode('/', $api_path);

// Manejar las rutas para clientes
if ($uri_parts[1] === 'api' && $uri_parts[2] === 'clientes') {
    // Si hay un cuarto segmento en la URL, es el ID
    if (isset($uri_parts[3]) && is_numeric($uri_parts[3])) {
        $id = $uri_parts[3]; // Obtener el ID

        // Manejar las solicitudes según el método HTTP
        switch ($request_method) {
            case 'GET':
                $clientesController->getById($id);
                break;
            case 'PUT':
                $clientesController->update($id);
                break;
            case 'DELETE':
                $clientesController->delete($id);
                break;
            default:
                header("HTTP/1.1 405 Method Not Allowed");
                
                break;
        }
    } else {
        // Si no hay un ID, manejar la ruta /api/clientes
        switch ($request_method) {
            case 'GET':
                $clientesController->getAll();
                break;
            case 'POST':
                $clientesController->create();
                break;
            default:
                header("HTTP/1.1 405 Method Not Allowed");
                include __DIR__ . '/../public/error/response.html';
                break;
        }
    }
}

// Manejar las rutas para marcas
elseif ($uri_parts[1] === 'api' && $uri_parts[2] === 'marcas') {
    // Si hay un cuarto segmento en la URL, es el ID
    if (isset($uri_parts[3]) && is_numeric($uri_parts[3])) {
        $id = $uri_parts[3]; // Obtener el ID

        // Manejar las solicitudes según el método HTTP
        switch ($request_method) {
            case 'GET':
                $marcasController->getById($id);
                break;
            case 'PUT':
                $marcasController->update($id);
                break;
            case 'DELETE':
                $marcasController->delete($id);
                break;
            default:
                header("HTTP/1.1 405 Method Not Allowed");
                
                break;
        }
    } else {
        // Si no hay un ID, manejar la ruta /api/marcas
        switch ($request_method) {
            case 'GET':
                $marcasController->getAll();
                break;
            case 'POST':
                $marcasController->create();
                break;
            default:
                header("HTTP/1.1 405 Method Not Allowed");
                include __DIR__ . '/../public/error/response.html';
                break;
        }
    }
}


//Manejar las rutas por el tipo de ropa
elseif ($uri_parts[1] === 'api' && $uri_parts[2] === 'tipo_de_ropa') {
    // Si hay un cuarto segmento en la URL, es el ID
    if (isset($uri_parts[3]) && is_numeric($uri_parts[3])) {
        $id = $uri_parts[3]; // Obtener el ID

        // Manejar las solicitudes según el método HTTP
        switch ($request_method) {
            case 'GET':
                $tipoDeRopaController->getById($id);
                break;
            case 'PUT':
                $tipoDeRopaController->update($id);
                break;
            case 'DELETE':
                $tipoDeRopaController->delete($id);
                break;
            default:
                header("HTTP/1.1 405 Method Not Allowed");
                include __DIR__ . '/../public/error/response.html';
                break;
        }
    } else {
        // Si no hay un ID, manejar la ruta /api/tipo_de_ropa
        switch ($request_method) {
            case 'GET':
                $tipoDeRopaController->getAll();
                break;
            case 'POST':
                $tipoDeRopaController->create();
                break;
            default:
                header("HTTP/1.1 405 Method Not Allowed");
                include __DIR__ . '/../public/error/response.html';
                break;
        }
    }
}


// Manejar las rutas para ventas
elseif ($uri_parts[1] === 'api' && $uri_parts[2] === 'ventas') {
    // Si hay un cuarto segmento en la URL, es el ID
    if (isset($uri_parts[3]) && is_numeric($uri_parts[3])) {
        $id = $uri_parts[3]; // Obtener el ID

        // Manejar las solicitudes según el método HTTP
        switch ($request_method) {
            case 'GET':
                $ventasController->getById($id);
                break;
            case 'PUT':
                $ventasController->update($id);
                break;
            case 'DELETE':
                $ventasController->delete($id);
                break;
            default:
                header("HTTP/1.1 405 Method Not Allowed");
                include __DIR__ . '/../public/error/response.html';
                break;
        }
    } else {
        // Si no hay un ID, manejar la ruta /api/ventas
        switch ($request_method) {
            case 'GET':
                $ventasController->getAll();
                break;
            case 'POST':
                $ventasController->create();
                break;
            default:
                header("HTTP/1.1 405 Method Not Allowed");
                include __DIR__ . '/../public/error/response.html';
                break;
        }
    }
}

// Manejar las rutas para detalle de ventas
elseif ($uri_parts[1] === 'api' && $uri_parts[2] === 'detalle_ventas') {
    // Si hay un cuarto segmento en la URL, es el ID
    if (isset($uri_parts[3]) && is_numeric($uri_parts[3])) {
        $id = $uri_parts[3]; // Obtener el ID

        // Manejar las solicitudes según el método HTTP
        switch ($request_method) {
            case 'GET':
                $detalleVentasController->getById($id);
                break;
            case 'PUT':
                $detalleVentasController->update($id);
                break;
            case 'DELETE':
                $detalleVentasController->delete($id);
                break;
            default:
                header("HTTP/1.1 405 Method Not Allowed");
                include __DIR__ . '/../public/error/response.html';
                break;
        }
    } else {
        // Si no hay un ID, manejar la ruta /api/detalle_ventas
        switch ($request_method) {
            case 'GET':
                $detalleVentasController->getAll();
                break;
            case 'POST':
                $detalleVentasController->create();
                break;
            default:
                header("HTTP/1.1 405 Method Not Allowed");
                include __DIR__ . '/../public/error/response.html';
                break;
        }
    }
}

// Manejar las rutas para reportes
elseif ($uri_parts[1] === 'api' && $uri_parts[2] === 'reportes') {
    // Si hay un cuarto segmento en la URL, es el tipo de reporte
    if (isset($uri_parts[3])) {
        switch ($uri_parts[3]) {
            case 'marcas-con-ventas':
                $reportesController->marcasConVentas();
                break;
            case 'prendas-vendidas-stock':
                $reportesController->prendasVendidasStock();
                break;
            case 'top-5-marcas-vendidas':
                $reportesController->top5MarcasVendidas();
                break;
            default:
                header("HTTP/1.1 404 Not Found");
                include __DIR__ . '/../public/error/response.html';
                break;
        }
    } else {
        // Si no hay un tipo de reporte, devolver un error
        header("HTTP/1.1 400 Bad Request");
        include __DIR__ . '/../public/error/response.html';
    }
}


// Ruta no encontrada
else {
    header("HTTP/1.1 404 Not Found");
    include __DIR__ . '/../public/error/response.html';
}