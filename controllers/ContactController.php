<?php
/**
 * Contact Controller - Nabana Sejahtera Teknik
 * Handles contact page and form submissions.
 */

defined('BASEPATH') or exit('No direct script access allowed');

require_once ROOT_PATH . 'models/Setting.php';

class ContactController {
    private Setting $settingModel;

    public function __construct() {
        $this->settingModel = new Setting();
    }

    public function index() {
        $data = [
            'title' => 'Hubungi Kami - Nabana Sejahtera Teknik',
            'meta_description' => 'Hubungi Nabana Sejahtera Teknik untuk pertanyaan, pemesanan, atau konsultasi teknik.',
            'settings' => $this->settingModel->getAll()
        ];

        require VIEWS_PATH . 'layouts/header.php';
        require VIEWS_PATH . 'contact/index.php';
        require VIEWS_PATH . 'layouts/footer.php';
    }

    public function submit() {
        // Handle contact form submission (PRD 8.4)
        // In a real app, save to database and send email
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $message = $_POST['message'] ?? '';

        // Simple success message for demonstration
        $_SESSION['contact_success'] = "Terima kasih, pesan Anda telah terkirim!";
        header("Location: " . BASE_URL . "/kontak");
        exit;
    }
}
