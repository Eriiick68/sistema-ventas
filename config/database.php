<?php
/**
 * config/database.php
 * Configuración y conexión a la base de datos (Patrón Singleton)
 */

define('DB_HOST', 'localhost');
define('DB_NAME', 'sistema_ventas');
define('DB_USER', 'root');
define('DB_PASS', '');       // Cambia si tu MySQL tiene contraseña
define('DB_CHARSET', 'utf8mb4');

define('IVA', 0.16);          // 16% IVA México

class Database {
    private static $instance = null;

    /** Devuelve la conexión PDO (Singleton) */
    public static function getConnection(): PDO {
        if (self::$instance === null) {
            $dsn = "mysql:host=" . DB_HOST
                 . ";dbname=" . DB_NAME
                 . ";charset=" . DB_CHARSET;
            try {
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                die('<div style="font-family:sans-serif;padding:2rem;color:red;">
                    <h2>Error de conexión a la base de datos</h2>
                    <p>' . htmlspecialchars($e->getMessage()) . '</p>
                    <p>Verifica que MySQL esté activo y que hayas importado <code>database.sql</code>.</p>
                </div>');
            }
        }
        return self::$instance;
    }
}
