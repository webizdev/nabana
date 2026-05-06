<?php
/**
 * Banner Model Stub
 */
class Banner {
    private Database $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getActive(): array {
        try {
            $stmt = $this->db->getConnection()->prepare("SELECT * FROM banners WHERE is_active = 1 ORDER BY sort_order LIMIT 5");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];  // Return empty during setup
        }
    }
}

