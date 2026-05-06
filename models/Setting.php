<?php
/**
 * Settings Model
 */

class Setting {
    private Database $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll(string $group = null): array {
        $sql = "SELECT * FROM settings";
        $params = [];
        if ($group) {
            $sql .= " WHERE setting_group = ?";
            $params[] = $group;
        }
        $sql .= " ORDER BY setting_group, setting_key";

        try {
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute($params);
            $settings = [];
            while ($row = $stmt->fetch()) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
            return $settings;
        } catch (Exception $e) {
            logError("Settings getAll error: " . $e->getMessage());
            return [];
        }
    }

    public function get(string $key): ?string {
        try {
            $stmt = $this->db->getConnection()->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
            $stmt->execute([$key]);
            return $stmt->fetchColumn() ?: null;
        } catch (Exception $e) {
            return null;
        }
    }

    public function update(string $key, string $value): bool {
        try {
            $stmt = $this->db->getConnection()->prepare("
                INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) 
                ON DUPLICATE KEY UPDATE setting_value = ?
            ");
            return $stmt->execute([$key, $value, $value]);
        } catch (Exception $e) {
            logError("Settings update error: " . $e->getMessage());
            return false;
        }
    }
}

