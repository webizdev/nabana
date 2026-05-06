<?php
/**
 * Database Singleton Class (PDO)
 * PRD 15.2
 */

class Database {
    private static ?Database $instance = null;
    private ?PDO $pdo = null; // nullable - no crash if DB unavailable

    private function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
            ];
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // DB not available (demo/Vercel mode) - fail silently
            $this->pdo = null;
        }
    }

    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): ?PDO {
        return $this->pdo; // returns null if DB not connected
    }

    // Prevent cloning/unserialize
    private function __clone() {}
    public function __wakeup() { throw new Exception("Cannot unserialize"); }
}

// Simple error logger
function logError($message) {
    $log = date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL;
    file_put_contents(LOGS_PATH . 'error.log', $log, FILE_APPEND | LOCK_EX);
}

