<?php
/**
 * Page Controller - Nabana Sejahtera Teknik
 * Handles static pages like About Us, Services, etc.
 */

defined('BASEPATH') or exit('No direct script access allowed');

require_once ROOT_PATH . 'models/Setting.php';

class PageController {
    private Setting $settingModel;

    public function __construct() {
        $this->settingModel = new Setting();
    }

    public function about() {
        $data = [
            'title' => 'Tentang Kami - Nabana Sejahtera Teknik',
            'meta_description' => 'Pelajari lebih lanjut tentang Nabana Sejahtera Teknik, visi, misi, dan komitmen kami dalam menyediakan alat teknik berkualitas.',
            'settings' => $this->settingModel->getAll()
        ];

        require VIEWS_PATH . 'layouts/header.php';
        require VIEWS_PATH . 'about/index.php';
        require VIEWS_PATH . 'layouts/footer.php';
    }

    public function services() {
        $data = [
            'title' => 'Layanan Kami - Nabana Sejahtera Teknik',
            'meta_description' => 'Berbagai layanan teknik dan penyediaan sparepart otomotif berkualitas dari Nabana Sejahtera Teknik.',
            'settings' => $this->settingModel->getAll()
        ];

        require VIEWS_PATH . 'layouts/header.php';
        require VIEWS_PATH . 'services/index.php';
        require VIEWS_PATH . 'layouts/footer.php';
    }

    public function show($slug) {
        // For dynamic pages from database if needed
        http_response_code(404);
        require VIEWS_PATH . 'errors/404.php';
    }
}
