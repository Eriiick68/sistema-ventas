<?php
/**
 * controllers/VentaController.php
 * CONTROLADOR – Lógica de negocio para ventas
 */

class VentaController {
    private Venta    $model;
    private Producto $modelProducto;

    public function __construct() {
        $this->model         = new Venta();
        $this->modelProducto = new Producto();
    }

    /** GET /index.php?controller=ventas&action=index */
    public function index(): void {
        $ventas = $this->model->getAll();
        require 'views/ventas/index.php';
    }

    /** GET /index.php?controller=ventas&action=nueva */
    public function nueva(): void {
        $productos = $this->modelProducto->getAll();
        $errores   = [];
        $old = [
            'cliente' => '',
            'producto_id' => [],
            'cantidad' => []
        ];

        require 'views/ventas/nueva.php';
    }

    /** POST /index.php?controller=ventas&action=registrar */
    public function registrar(): void {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=ventas');
            exit;
        }

        $errores  = [];
        $productos = $this->modelProducto->getAll();

        $cliente = trim(htmlspecialchars($_POST['cliente'] ?? ''));

        if ($cliente === '') {
            $errores[] = 'El nombre del cliente no puede estar vacío.';
        }
        

        // ── CONSTRUIR ITEMS ───────────────────────────────
        $items = [];

        $ids = $_POST['producto_id'] ?? [];
        $cantidades = $_POST['cantidad'] ?? [];

        foreach ($ids as $i => $pid) {

            if (empty($pid)) continue;

            $cant = $cantidades[$i] ?? 0;

            // validar cantidad
            if (!is_numeric($cant) || (int)$cant <= 0) {
                $errores[] = "La cantidad del producto #" . ($i + 1) . " debe ser mayor a 0.";
                continue;
            }

            $items[] = [
                'producto_id' => (int)$pid,
                'cantidad' => (int)$cant
            ];
        }

        if (count($items) === 0) {
            $errores[] = 'Debes agregar al menos un producto válido a la venta.';
        }

        // ── SI HAY ERRORES ───────────────────────────────
        if (!empty($errores)) {

            $old = [
                'cliente' => $cliente,
                'producto_id' => $_POST['producto_id'] ?? [],
                'cantidad' => $_POST['cantidad'] ?? []
            ];

            require 'views/ventas/nueva.php';
            return;
        }

        // ── GUARDAR VENTA ───────────────────────────────
        $resultado = $this->model->registrar($cliente, $items, $this->modelProducto);

        if ($resultado['ok']) {
            header('Location: index.php?controller=ventas&action=detalle&id=' . $resultado['venta_id']);
        } else {
            $errores = $resultado['errores'];

            $old = [
                'cliente' => $cliente,
                'producto_id' => $_POST['producto_id'] ?? [],
                'cantidad' => $_POST['cantidad'] ?? []
            ];

            require 'views/ventas/nueva.php';
        }

        exit;
    }

    /** GET /index.php?controller=ventas&action=detalle&id=X */
    public function detalle(): void {
        $id    = (int)($_GET['id'] ?? 0);
        $venta = $this->model->getConDetalle($id);

        if (!$venta) {
            header('Location: index.php?controller=ventas');
            exit;
        }

        require 'views/ventas/detalle.php';
    }
}