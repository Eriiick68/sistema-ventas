<?php
/**
 * SISTEMA DE VENTAS - MVC
 * index.php: Front Controller (punto de entrada único)
 */

require_once 'config/database.php';
require_once 'models/Producto.php';
require_once 'models/Venta.php';
require_once 'models/DetalleVenta.php';
require_once 'controllers/ProductoController.php';
require_once 'controllers/VentaController.php';

// Routing básico
$controller = isset($_GET['controller']) ? trim($_GET['controller']) : 'productos';
$action     = isset($_GET['action'])     ? trim($_GET['action'])     : 'index';

// Whitelist de seguridad
$allowed = [
    'productos' => ['index', 'crear', 'guardar', 'eliminar'],
    'ventas'    => ['index', 'nueva', 'registrar', 'detalle'],
];

if (!array_key_exists($controller, $allowed)) {
    $controller = 'productos';
    $action     = 'index';
}
if (!in_array($action, $allowed[$controller])) {
    $action = 'index';
}

// Instanciar controlador correcto
switch ($controller) {
    case 'ventas':
        $ctrl = new VentaController();
        break;
    default:
        $ctrl = new ProductoController();
}

// Ejecutar acción
$ctrl->$action();
