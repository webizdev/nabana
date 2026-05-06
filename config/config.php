<?php
/**
 * Main Configuration File
 * Nabana Sejahtera Teknik
 * PRD v1.0
 */

defined('BASEPATH') or exit('No direct script access allowed');

// Environment: 'development' or 'production'
define('ENVIRONMENT', 'production'); // Live cPanel hosting

// Error reporting
if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Base URL - Dynamic Detection (handles root or subdirectories)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost:8080';
$script_name = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$base_path = ($script_name == '/') ? '' : $script_name;
define('BASE_URL', $protocol . "://" . $host . $base_path);

// Paths (absolute for local dev)
define('ROOT_PATH', dirname(__DIR__) . '/');
define('VIEWS_PATH', ROOT_PATH . 'views/');
define('ADMIN_VIEWS_PATH', ROOT_PATH . 'admin/views/');
define('UPLOADS_PATH', ROOT_PATH . 'uploads/');
define('CACHE_PATH', ROOT_PATH . 'cache/');
define('LOGS_PATH', ROOT_PATH . 'logs/');
define('UPLOADS_URL', BASE_URL . '/uploads/');
define('ASSETS_URL', BASE_URL . '/assets/');

// Database - cPanel Live Hosting
define('DB_HOST', 'localhost');         // cPanel always uses localhost
define('DB_NAME', 'alilogis_nabana');
define('DB_USER', 'alilogis_nabana');
define('DB_PASS', 'BawV8Btnj3DyCDQxZwsD');
define('DB_CHARSET', 'utf8mb4');

// Upload settings (from PRD)
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/webp', 'image/gif']);
define('THUMB_WIDTH', 150);
define('THUMB_HEIGHT', 150);
define('MEDIUM_WIDTH', 600);
define('MEDIUM_HEIGHT', 400);
define('LARGE_WIDTH', 1200);
define('LARGE_HEIGHT', 800);

// Pagination (from PRD)
define('PRODUCTS_PER_PAGE', 12);
define('ADMIN_ITEMS_PER_PAGE', 20);

// Session (from PRD)
define('SESSION_LIFETIME', 7200); // 2 hours
define('SESSION_NAME', 'NABANA_SESSION');

// Security (from PRD)
define('CSRF_TOKEN_NAME', '_csrf_token');
define('LOGIN_MAX_ATTEMPTS', 5);
define('LOGIN_LOCKOUT_TIME', 900); // 15 min

// WhatsApp (from PRD)
define('WA_NUMBER', '6285767772694');

