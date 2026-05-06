<?php
/**
 * Frontend URL Routes (PRD 5.1, 15.4)
 * Clean URLs via .htaccess
 */

$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
$url = filter_var($url, FILTER_SANITIZE_URL);
$segments = explode('/', $url);

// CSRF check for POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrfToken();
}

switch ($segments[0]) {
    case '':
    case 'beranda':
        require_once ROOT_PATH . 'controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;

    case 'tentang-kami':
        require_once ROOT_PATH . 'controllers/PageController.php';
        $controller = new PageController();
        $controller->about();
        break;

    case 'layanan':
        require_once ROOT_PATH . 'controllers/PageController.php';
        $controller = new PageController();
        $controller->services();
        break;

    case 'kontak':
        require_once ROOT_PATH . 'controllers/ContactController.php';
        $controller = new ContactController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->submit();
        } else {
            $controller->index();
        }
        break;

    case 'produk':
        require_once ROOT_PATH . 'controllers/ProductController.php';
        $controller = new ProductController();
        if (!empty($segments[1])) {
            if ($segments[1] === 'kategori') {
                $controller->category($segments[2] ?? '', $segments[3] ?? '');
            } elseif ($segments[1] === 'detail') {
                $controller->detail($segments[2] ?? '');
            } else {
                // Fallback for /produk/slug format
                $controller->detail($segments[1]);
            }
        } else {
            $controller->index();
        }
        break;

    case 'halaman':
        require_once 'controllers/PageController.php';
        $controller = new PageController();
        $controller->show($segments[1] ?? '');
        break;

    case 'sitemap.xml':
        require_once 'controllers/SitemapController.php';
        $controller = new SitemapController();
        $controller->index();
        break;

    default:
        // 404
        http_response_code(404);
        require VIEWS_PATH . 'errors/404.php';
        break;
}

function verifyCsrfToken() {
    if (!isset($_POST[CSRF_TOKEN_NAME]) || !hash_equals($_SESSION[CSRF_TOKEN_NAME] ?? '', $_POST[CSRF_TOKEN_NAME])) {
        die('CSRF token mismatch');
    }
    // Regenerate token
    $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
}

