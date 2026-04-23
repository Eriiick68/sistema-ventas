<?php
// Controlador de Productos - maneja registro, listado y eliminación 

class ProductoController {
    private Producto $model;

    public function __construct() {
        $this->model = new Producto();
    }

    /** GET /index.php?controller=productos&action=index */
    public function index(): void {
        $productos = $this->model->getAll();
        require 'views/productos/index.php';
    }

    /** GET /index.php?controller=productos&action=crear */
    public function crear(): void {
        $errores = [];
        require 'views/productos/crear.php';
    }

    /** POST /index.php?controller=productos&action=guardar */
    public function guardar(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=productos');
            exit;
        }

        // Sanitizar entradas
        $nombre      = trim(htmlspecialchars($_POST['nombre']      ?? ''));
        $descripcion = trim(htmlspecialchars($_POST['descripcion'] ?? ''));
        $precioRaw   = trim($_POST['precio'] ?? '');
        $stockRaw    = trim($_POST['stock']  ?? '0');

        // ── VALIDACIONES ──────────────────────────────────────────
        $errores = [];

        if ($nombre === '') {
            $errores[] = 'El nombre del producto no puede estar vacío.';
        }
        if ($descripcion === '') {
            $errores[] = 'La descripción no puede estar vacía.';
        }
        if ($precioRaw === '') {
            $errores[] = 'El precio no puede estar vacío.';
        } elseif (!is_numeric($precioRaw)) {
            $errores[] = 'El precio debe ser un número válido.';
        } elseif ((float)$precioRaw <= 0) {
            $errores[] = 'El precio debe ser mayor que 0.';
        }
        if (!ctype_digit($stockRaw) || (int)$stockRaw < 0) {
            $errores[] = 'El stock debe ser un número entero igual o mayor a 0.';
        }
        // ─────────────────────────────────────────────────────────

        if (!empty($errores)) {
            // Volver a mostrar el formulario con errores
            require 'views/productos/crear.php';
            return;
        }

        $ok = $this->model->crear($nombre, $descripcion, (float)$precioRaw, (int)$stockRaw);

        if ($ok) {
            header('Location: index.php?controller=productos&exito=1');
        } else {
            $errores[] = 'Error al guardar en la base de datos. Intente de nuevo.';
            require 'views/productos/crear.php';
        }
        exit;
    }

    /** GET /index.php?controller=productos&action=eliminar&id=X */
    public function eliminar(): void {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $this->model->eliminar($id);
        }
        header('Location: index.php?controller=productos&eliminado=1');
        exit;
    }
}
