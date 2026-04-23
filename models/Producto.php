<?php
// Modelo Producto - acceso a datos con PDO y control de stock

class Producto {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /** Obtiene todos los productos */
    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM productos ORDER BY nombre");
        return $stmt->fetchAll();
    }

    /** Obtiene un producto por ID */
    public function getById(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /** Crea un nuevo producto */
    public function crear(string $nombre, string $descripcion, float $precio, int $stock): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO productos (nombre, descripcion, precio, stock)
             VALUES (:nombre, :descripcion, :precio, :stock)"
        );
        return $stmt->execute([
            ':nombre'      => $nombre,
            ':descripcion' => $descripcion,
            ':precio'      => $precio,
            ':stock'       => $stock,
        ]);
    }

    /** Elimina un producto por ID */
    public function eliminar(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM productos WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    /** Reduce el stock de un producto tras una venta */
    public function reducirStock(int $id, int $cantidad): bool {
        $stmt = $this->db->prepare(
            "UPDATE productos SET stock = stock - :cantidad
             WHERE id = :id AND stock >= :cantidad"
        );
        $stmt->execute([':cantidad' => $cantidad, ':id' => $id]);
        return $stmt->rowCount() > 0;   // false si no había suficiente stock
    }
}
