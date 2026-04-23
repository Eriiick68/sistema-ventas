-- ============================================================
--  SISTEMA DE VENTAS  –  Esquema de base de datos
--  Ejecutar en phpMyAdmin o con: mysql -u root -p < database.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS sistema_ventas
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE sistema_ventas;

-- ----------------------------
-- Tabla: productos
-- ----------------------------
CREATE TABLE IF NOT EXISTS productos (
    id          INT          UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre      VARCHAR(120) NOT NULL,
    descripcion TEXT         NOT NULL,
    precio      DECIMAL(10,2) NOT NULL CHECK (precio >= 0),
    stock       INT          UNSIGNED NOT NULL DEFAULT 0,
    creado_en   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Tabla: ventas (cabecera)
-- ----------------------------
CREATE TABLE IF NOT EXISTS ventas (
    id           INT           UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    subtotal     DECIMAL(10,2) NOT NULL,
    iva          DECIMAL(10,2) NOT NULL,
    total        DECIMAL(10,2) NOT NULL,
    cliente      VARCHAR(120)  NOT NULL DEFAULT 'Cliente general',
    fecha        TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Tabla: detalle_ventas (líneas)
-- ----------------------------
CREATE TABLE IF NOT EXISTS detalle_ventas (
    id          INT           UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    venta_id    INT           UNSIGNED NOT NULL,
    producto_id INT           UNSIGNED NOT NULL,
    cantidad    INT           UNSIGNED NOT NULL,
    precio_unit DECIMAL(10,2) NOT NULL,
    subtotal    DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (venta_id)    REFERENCES ventas(id)    ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Datos de ejemplo
-- ----------------------------
INSERT INTO productos (nombre, descripcion, precio, stock) VALUES
    ('Laptop Lenovo IdeaPad',  'Procesador Intel i5, 8GB RAM, 512GB SSD', 12999.00, 10),
    ('Mouse Inalámbrico',      'Mouse óptico 2.4GHz, 3 botones, negro',      299.00, 50),
    ('Teclado Mecánico',       'Switches azules, retroiluminado RGB',         899.00, 25),
    ('Monitor 24"',            'Full HD 1080p, 75Hz, panel IPS',            3499.00,  8),
    ('Audífonos Bluetooth',    'Over-ear, cancelación de ruido, 30h batería',1199.00, 15);
