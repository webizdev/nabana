<?php
/**
 * Nabana Sejahtera Teknik - Front Controller
 * Entry point untuk semua frontend request (PRD 15.3)
 */

define('BASEPATH', true);
define('START_TIME', microtime(true));

// Load core config
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/models/Database.php';

// Load helpers
require_once __DIR__ . '/helpers/functions.php';

// Start session BEFORE any output or ini_set
if (session_status() == PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}
session_regenerate_id(true);

// Load router AFTER models/helpers are safe
require_once __DIR__ . '/routes.php';

// Track visitor (optional, skip if DB not ready)
if (isset($_SESSION['visited']) === false && class_exists('Database')) {
    trackVisitor($_SERVER['REQUEST_URI'] ?? '/');
    $_SESSION['visited'] = true;
}

