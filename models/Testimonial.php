<?php
/**
 * Testimonial Model Stub
 */
class Testimonial {
    private Database $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getActive(int $limit = 6): array {
        try {
            $stmt = $this->db->getConnection()->prepare("SELECT * FROM testimonials WHERE is_active = 1 ORDER BY sort_order LIMIT ?");
            $stmt->execute([$limit]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
}

