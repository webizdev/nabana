<?php
/**
 * Home Controller (PRD 8.1 Homepage)
 */

require_once ROOT_PATH . 'models/Product.php';
require_once ROOT_PATH . 'models/Category.php';
require_once ROOT_PATH . 'models/Banner.php';
require_once ROOT_PATH . 'models/Testimonial.php';
require_once ROOT_PATH . 'models/Setting.php';

class HomeController {
    private Product $productModel;
    private Category $categoryModel;
    private Banner $bannerModel;
    private Testimonial $testimonialModel;
    private Setting $settingModel;

    public function __construct() {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
        $this->bannerModel = new Banner();
        $this->testimonialModel = new Testimonial();
        $this->settingModel = new Setting();
    }

    public function index() {
        // Data for homepage sections (PRD 8.1)
$data = [
            'title' => getSetting('site_name') ?: SITE_NAME,
            'banners' => $this->bannerModel->getActive(),
            'categories' => $this->categoryModel->getAll(true, true),
            'featured_products' => $this->productModel->getFeatured(8),
            'testimonials' => $this->testimonialModel->getActive(6),
            'settings' => $this->settingModel->getAll()
        ];

        // Load view
        require VIEWS_PATH . 'layouts/header.php';
        require VIEWS_PATH . 'home/index.php';
        require VIEWS_PATH . 'layouts/footer.php';
    }
}



