<?php
/**
 * Category Model
 */

class Category {
    private Database $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll(bool $withSub = true, bool $activeOnly = true): array {
        $where = $activeOnly ? 'WHERE is_active = 1' : '';
        $sql = $withSub 
            ? "WITH RECURSIVE category_tree AS (
                SELECT id, name, slug, parent_id, icon, sort_order, 0 as level
                FROM categories WHERE parent_id IS NULL AND is_active = 1
                UNION ALL
                SELECT c.id, c.name, c.slug, c.parent_id, c.icon, c.sort_order, ct.level + 1
                FROM categories c
                INNER JOIN category_tree ct ON c.parent_id = ct.id
                WHERE c.is_active = 1
              ) SELECT * FROM category_tree ORDER BY sort_order, level, name"
            : "SELECT * FROM categories $where ORDER BY sort_order, name";

        try {
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            logError("Category getAll error: " . $e->getMessage());
            return [];
        }
    }

    public function getBySlug(string $slug, ?string $parentSlug = null): ?array {
        $sql = "SELECT * FROM categories WHERE slug = ? AND is_active = 1";
        $params = [$slug];
        
        if ($parentSlug) {
            $sql = "SELECT c.* FROM categories c 
                    JOIN categories p ON c.parent_id = p.id 
                    WHERE c.slug = ? AND p.slug = ? AND c.is_active = 1";
            $params[] = $parentSlug;
        }
        
        try {
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch() ?: null;
        } catch (Exception $e) {
            return null;
        }
    }

    public function getProductCount(int $categoryId): int {
        try {
            $stmt = $this->db->getConnection()->prepare("
                SELECT COUNT(*) FROM products 
                WHERE category_id = ? OR id IN (
                    SELECT id FROM categories WHERE parent_id = ?
                ) AND is_active = 1
            ");
            $stmt->execute([$categoryId, $categoryId]);
            return (int) $stmt->fetchColumn();
        } catch (Exception $e) {
            return 0;
        }
    }
}

