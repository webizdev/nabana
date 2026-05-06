<?php
/**
 * Product Model
 */

class Product {
    private $db;

    public function __construct() {
        if (class_exists('Database')) {
            $this->db = Database::getInstance();
        }
    }

    public function getAll(int $limit = PRODUCTS_PER_PAGE, int $offset = 0, array $filters = []): array {
        try {
            $where = $params = [];
            if (!empty($filters['category_id'])) {
                $where[] = 'p.category_id = ?';
                $params[] = $filters['category_id'];
            }
            if (!empty($filters['search'])) {
                $where[] = '(p.name LIKE ? OR p.description LIKE ?)';
                $search = '%' . $filters['search'] . '%';
                $params[] = $search;
                $params[] = $search;
            }
            if (isset($filters['is_featured'])) {
                $where[] = 'p.is_featured = ?';
                $params[] = $filters['is_featured'];
            }

            $whereSql = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';
            $sql = "SELECT p.*, c.name as category_name, pi.image_path as primary_image 
                    FROM products p 
                    LEFT JOIN categories c ON p.category_id = c.id 
                    LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1 
                    $whereSql 
                    ORDER BY p.sort_order DESC, p.created_at DESC 
                    LIMIT ? OFFSET ?";
            $params[] = $limit;
            $params[] = $offset;

            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            logError("Product getAll error: " . $e->getMessage());
            return [];
        }
    }

    public function getBySlug(string $slug): ?array {
        try {
            $stmt = $this->db->getConnection()->prepare("
                SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.slug = ? AND p.is_active = 1
            ");
            $stmt->execute([$slug]);
            return $stmt->fetch() ?: null;
        } catch (Exception $e) {
            logError("Product getBySlug error: " . $e->getMessage());
            return null;
        }
    }

    public function getImages(int $productId): array {
        try {
            $stmt = $this->db->getConnection()->prepare("
                SELECT * FROM product_images 
                WHERE product_id = ? ORDER BY sort_order, id
            ");
            $stmt->execute([$productId]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getCount(array $filters = []): int {
        try {
            $where = $params = [];
            if (!empty($filters['category_id'])) {
                $where[] = 'category_id = ?';
                $params[] = $filters['category_id'];
            }
            if (!empty($filters['search'])) {
                $where[] = '(name LIKE ? OR description LIKE ?)';
                $search = '%' . $filters['search'] . '%';
                $params[] = $search;
                $params[] = $search;
            }
            $whereSql = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';
            $sql = "SELECT COUNT(*) FROM products $whereSql";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute($params);
            return (int) $stmt->fetchColumn();
        } catch (Exception $e) {
            return 0;
        }
    }

    // Featured products
    public function getFeatured(int $limit = 8): array {
        return $this->getAll($limit, 0, ['is_featured' => 1]);
    }
}

