<?php

class Venta {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll(): array {
        $sql = "SELECT v.*, 
                       COUNT(d.id) AS num_productos
                FROM ventas v
                LEFT JOIN detalle_ventas d ON d.venta_id = v.id
                GROUP BY v.id
                ORDER BY v.id DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function getConDetalle(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM ventas WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $venta = $stmt->fetch();
        if (!$venta) return false;

        $stmt2 = $this->db->prepare(
            "SELECT d.*, p.nombre 
             FROM detalle_ventas d
             JOIN productos p ON p.id = d.producto_id
             WHERE d.venta_id = :id"
        );
        $stmt2->execute([':id' => $id]);
        $venta['detalle'] = $stmt2->fetchAll();

        return $venta;
    }

    public function registrar(string $cliente, array $items, Producto $modeloProducto): array {

        $errores = [];
        $lineas  = [];
        $subtotalTotal = 0.0;

        foreach ($items as $item) {
            $prod = $modeloProducto->getById((int)$item['producto_id']);

            if (!$prod) {
                $errores[] = "Producto no existe";
                continue;
            }

            $cant = (int)$item['cantidad'];

            if ($cant <= 0) {
                $errores[] = "Cantidad inválida para {$prod['nombre']}";
                continue;
            }

            if ($cant > $prod['stock']) {
                $errores[] = "Stock insuficiente para {$prod['nombre']}";
                continue;
            }

            $sub = $prod['precio'] * $cant;

            $lineas[] = [
                'producto_id' => $prod['id'],
                'cantidad'    => $cant,
                'precio'      => $prod['precio'],
                'subtotal'    => $sub
            ];

            $subtotalTotal += $sub;
        }

        if (!empty($errores)) {
            return ['ok' => false, 'errores' => $errores];
        }

        
        $iva   = round($subtotalTotal * 0.16, 2);
        $total = round($subtotalTotal + $iva, 2);

        try {
            $this->db->beginTransaction();

            // insertar venta
            $stmt = $this->db->prepare("
                INSERT INTO ventas (cliente, subtotal, iva, total)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([$cliente, $subtotalTotal, $iva, $total]);

            $ventaId = $this->db->lastInsertId();

            // detalle + stock
            foreach ($lineas as $l) {

                $stmt = $this->db->prepare("
                    INSERT INTO detalle_ventas 
                    (venta_id, producto_id, cantidad, precio_unit, subtotal)
                    VALUES (?, ?, ?, ?, ?)
                ");

                $stmt->execute([
                    $ventaId,
                    $l['producto_id'],
                    $l['cantidad'],
                    $l['precio'],
                    $l['subtotal']
                ]);

                
                $stmt = $this->db->prepare("
                    UPDATE productos 
                    SET stock = stock - ? 
                    WHERE id = ?
                ");
                $stmt->execute([$l['cantidad'], $l['producto_id']]);
            }

            $this->db->commit();

            return [
                'ok' => true,
                'venta_id' => $ventaId
            ];

        } catch (Exception $e) {

            $this->db->rollBack();

            return [
                'ok' => false,
                'errores' => [$e->getMessage()]
            ];
        }
    }
}
