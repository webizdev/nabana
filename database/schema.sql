-- ============================================
-- DATABASE: nabana_sejahtera (PRD 6.2)
-- Engine: InnoDB, Charset: utf8mb4
-- Import this inside your cPanel database
-- ============================================


-- Tabel Pengaturan Website
CREATE TABLE `settings` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `setting_key` VARCHAR(100) NOT NULL,
    `setting_value` TEXT DEFAULT NULL,
    `setting_group` VARCHAR(50) DEFAULT 'general',
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data default settings (PRD)
INSERT INTO `settings` (`setting_key`, `setting_value`, `setting_group`) VALUES
('site_name', 'Nabana Sejahtera Teknik', 'general'),
('site_tagline', 'Distributor & Supplier Lampu, Kabel dan Barang Industri Terpercaya', 'general'),
('site_description', 'Nabana Sejahtera Teknik adalah distributor dan supplier terpercaya untuk lampu, kabel, dan barang-barang industri di Sumatera Utara.', 'general'),
('site_logo', 'assets/images/logo.png', 'general'),
('site_favicon', 'assets/images/favicon.ico', 'general'),
('company_address', 'Jl Permata Jaya, Perumahan Villa Permata, Desa Pematang Cengkering, Kecamatan Medang Deras, Kabupaten Batu Bara, Provinsi Sumatera Utara, Indonesia', 'contact'),
('company_phone', '0857-6777-2694', 'contact'),
('company_whatsapp', '6285767772694', 'contact'),
('company_email', 'info@nabanasejahterateknik.com', 'contact'),
('google_maps_embed', '', 'contact'),
('social_facebook', '', 'social'),
('social_instagram', '', 'social'),
('social_tiktok', '', 'social'),
('meta_title', 'Nabana Sejahtera Teknik - Distributor Lampu & Barang Industri', 'seo'),
('meta_description', 'Distributor dan supplier lampu, kabel, barang industri dan electrical terpercaya di Sumatera Utara. Hubungi kami untuk harga terbaik.', 'seo'),
('meta_keywords', 'distributor lampu medan, supplier kabel sumatera utara, barang industri, electrical medan, distributor lampu sumatera utara', 'seo'),
('whatsapp_default_message', 'Halo Nabana Sejahtera Teknik, saya tertarik dengan produk Anda.', 'whatsapp'),
('whatsapp_product_message', 'Halo, saya tertarik dengan produk: {product_name}. Mohon info harga dan ketersediaan.', 'whatsapp');

-- Tabel Admin (password default: Admin@2025 - CHANGE IMMEDIATELY)
CREATE TABLE `admins` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `full_name` VARCHAR(100) NOT NULL,
    `role` ENUM('super_admin', 'admin') DEFAULT 'admin',
    `avatar` VARCHAR(255) DEFAULT NULL,
    `is_active` TINYINT(1) DEFAULT 1,
    `last_login` DATETIME DEFAULT NULL,
    `remember_token` VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_username` (`username`),
    UNIQUE KEY `uk_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Default super admin: username 'admin', password 'Admin@2025' (bcrypt)
-- Run: UPDATE admins SET password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' WHERE id=1;
INSERT INTO `admins` (`username`, `email`, `password`, `full_name`, `role`) VALUES
('admin', 'admin@nabanasejahterateknik.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Super Administrator', 'super_admin');  -- password: Admin@2025

-- Continue with other tables from PRD 6.2 (abbreviated for brevity; full schema in PDR.md)
-- Tabel Categories (with sample data)
CREATE TABLE `categories` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `parent_id` INT(11) UNSIGNED DEFAULT NULL,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(120) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `image` VARCHAR(255) DEFAULT NULL,
    `icon` VARCHAR(50) DEFAULT NULL,
    `sort_order` INT(11) DEFAULT 0,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_slug` (`slug`),
    KEY `idx_parent_id` (`parent_id`),
    CONSTRAINT `fk_category_parent` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categories` (`name`, `slug`, `description`, `icon`, `sort_order`) VALUES
('Lampu', 'lampu', 'Berbagai jenis lampu untuk kebutuhan industri dan komersial', 'bi-lightbulb', 1),
('Kabel', 'kabel', 'Kabel listrik dan kabel data berkualitas tinggi', 'bi-ethernet', 2),
('Electrical Equipment', 'electrical-equipment', 'Peralatan kelistrikan untuk industri', 'bi-lightning', 3),
('Barang Industri', 'barang-industri', 'Berbagai kebutuhan barang industri', 'bi-gear', 4);

-- Tabel Products
CREATE TABLE `products` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `category_id` INT(11) UNSIGNED DEFAULT NULL,
    `name` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `sku` VARCHAR(50) DEFAULT NULL,
    `brand` VARCHAR(100) DEFAULT NULL,
    `short_description` TEXT DEFAULT NULL,
    `description` TEXT DEFAULT NULL,
    `price` DECIMAL(15,2) DEFAULT 0.00,
    `sort_order` INT(11) DEFAULT 0,
    `is_featured` TINYINT(1) DEFAULT 0,
    `is_active` TINYINT(1) DEFAULT 1,
    `meta_title` VARCHAR(255) DEFAULT NULL,
    `meta_description` TEXT DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_slug` (`slug`),
    KEY `idx_category_id` (`category_id`),
    CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Product Images
CREATE TABLE `product_images` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `product_id` INT(11) UNSIGNED NOT NULL,
    `image_path` VARCHAR(255) NOT NULL,
    `is_primary` TINYINT(1) DEFAULT 0,
    `sort_order` INT(11) DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_product_id` (`product_id`),
    CONSTRAINT `fk_image_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Banners
CREATE TABLE `banners` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `subtitle` VARCHAR(255) DEFAULT NULL,
    `image_path` VARCHAR(255) NOT NULL,
    `link_url` VARCHAR(255) DEFAULT NULL,
    `button_text` VARCHAR(50) DEFAULT 'Lihat Produk',
    `sort_order` INT(11) DEFAULT 0,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Testimonials
CREATE TABLE `testimonials` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `client_name` VARCHAR(100) NOT NULL,
    `company_name` VARCHAR(100) DEFAULT NULL,
    `comment` TEXT NOT NULL,
    `rating` TINYINT(1) DEFAULT 5,
    `is_active` TINYINT(1) DEFAULT 1,
    `sort_order` INT(11) DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Visitor Stats
CREATE TABLE `visitor_stats` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `page_url` VARCHAR(255) NOT NULL,
    `visitor_ip` VARCHAR(50) DEFAULT NULL,
    `user_agent` VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Fulltext index for search
ALTER TABLE `products` ADD FULLTEXT INDEX `ft_products_search` (`name`, `description`);
