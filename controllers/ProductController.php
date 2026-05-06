<?php
/**
 * Product Controller (PRD 8.3-8.4)
 */

require_once ROOT_PATH . 'models/Product.php';
require_once ROOT_PATH . 'models/Category.php';

class ProductController {
    private Product $productModel;
    private Category $categoryModel;

    public function __construct() {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }

    public function index($page = 1) {
        $perPage = PRODUCTS_PER_PAGE;
        $offset = ($page - 1) * $perPage;
        $filters = $_GET;  // search, category_id, etc.

        $products = $this->productModel->getAll($perPage, $offset, $filters);
        $total = $this->productModel->getCount($filters);
        $categories = $this->categoryModel->getAll();

        $data = [
            'title' => 'Produk - ' . SITE_NAME,
            'products' => $products,
            'categories' => $categories,
            'filters' => $filters,
            'pagination' => paginate($page, $total, $perPage, BASE_URL . '/produk'),
            'total' => $total
        ];

        require VIEWS_PATH . 'layouts/header.php';
        require VIEWS_PATH . 'products/index.php';
        require VIEWS_PATH . 'layouts/footer.php';
    }

    public function detail($slug) {
        $product = $this->productModel->getBySlug($slug);
        
        // Full Demo Fallback Data (12 Products)
        if (!$product) {
            $demo_products = [
                'safety-gloves-uci' => [
                    'id' => 1, 'name' => 'Sarung Tangan Safety Anti Sayat UCI 69', 'category_name' => 'Safety PPE', 'price' => 125000, 
                    'image' => 'assets/images/products/sarung-tangan-cut-gloves-anti-sayat-pisau-uci-safety-69.webp', 
                    'description' => 'Sarung tangan pelindung tingkat tinggi dengan teknologi anti-sayat. Cocok untuk industri manufaktur, konstruksi, dan penanganan material tajam.',
                    'specs' => ['Material' => 'HPPE Fiber', 'Level' => 'Cut Level 5', 'Sertifikasi' => 'EN388', 'Ukuran' => 'L/XL']
                ],
                'led-floodlight-48w' => [
                    'id' => 2, 'name' => 'Lampu Sorot LED Floodlight 48W IP68', 'category_name' => 'Lampu', 'price' => 285000, 
                    'image' => 'assets/images/products/taffled-lampu-sorot-tembak-mobil-led-floodlight-cool-white-ip68-48w-d841.jpeg',
                    'description' => 'Lampu sorot LED tahan air (IP68) dengan daya 48W. Memberikan pencahayaan maksimal untuk area industri atau kendaraan off-road.',
                    'specs' => ['Daya' => '48 Watt', 'Voltase' => '12V - 24V', 'Waterproof' => 'IP68', 'Chip' => 'Cree LED']
                ],
                'industrial-chain-ansi' => [
                    'id' => 3, 'name' => 'Industrial Chain ANSI RS FSCM High Quality', 'category_name' => 'Barang Industri', 'price' => 850000, 
                    'image' => 'assets/images/products/chain-ANSI-RS-FSCM.jpg',
                    'description' => 'Rantai transmisi industri standar ANSI. Tahan aus dan beban berat, dirancang untuk mesin industri skala besar.',
                    'specs' => ['Standar' => 'ANSI RS', 'Material' => 'Hardened Steel', 'Tipe' => 'Single Strand', 'Kekuatan' => 'High Tensile']
                ],
                'sugar-mill-chain' => [
                    'id' => 4, 'name' => 'Sugar Mill Chain Heavy Duty 300x222', 'category_name' => 'Barang Industri', 'price' => 1250000, 
                    'image' => 'assets/images/products/sugar-mill-chain-300x222.jpg',
                    'description' => 'Rantai khusus untuk industri pabrik gula. Dirancang untuk tahan korosi dan beban kontinu tinggi.',
                    'specs' => ['Tipe' => 'Sugar Mill', 'Dimensi' => '300x222 mm', 'Kapasitas' => 'Grade A+', 'Pelapisan' => 'Anti-Corrosion']
                ],
                'ss-chain-50ssrb' => [
                    'id' => 5, 'name' => 'Rantai Stainless Steel 50SSRB-1 Premium', 'category_name' => 'Alat Angkat', 'price' => 950000, 
                    'image' => 'assets/images/products/50SSRB-1.jpg',
                    'description' => 'Rantai stainless steel berkualitas tinggi (SUS304). Tahan karat sempurna untuk industri makanan atau kimia.',
                    'specs' => ['Material' => 'SS 304', 'Tipe' => '50SSRB-1', 'Panjang' => '10 Feet', 'Grade' => 'Food Grade']
                ],
                'touchscreen-gloves-kiprun' => [
                    'id' => 6, 'name' => 'Sarung Tangan Touchscreen Kiprun V2', 'category_name' => 'Safety PPE', 'price' => 85000, 
                    'image' => 'assets/images/products/sarung-tangan-lari-touchscreen-500-v2-hitam-kiprun-8759607.avif',
                    'description' => 'Sarung tangan kerja ringan yang mendukung layar sentuh. Nyaman digunakan sepanjang hari dengan sirkulasi udara baik.',
                    'specs' => ['Material' => 'Nylon/Spandex', 'Fitur' => 'Touchscreen Ready', 'Warna' => 'Hitam', 'Ukuran' => 'All Size']
                ],
                'electrical-component-1056' => [
                    'id' => 7, 'name' => 'Electrical Tool Component 10569648', 'category_name' => 'Electrical', 'price' => 450000, 
                    'image' => 'assets/images/products/10569648_1.webp',
                    'description' => 'Komponen elektrikal industri untuk perbaikan mesin. Standar original dengan durabilitas tinggi.',
                    'specs' => ['Part Number' => '10569648', 'Material' => 'Cooper/PVC', 'Rating' => '220V/16A', 'Asal' => 'Import']
                ],
                'industrial-component-1040' => [
                    'id' => 8, 'name' => 'Industrial Component 10408109 Heavy Duty', 'category_name' => 'Barang Industri', 'price' => 670000, 
                    'image' => 'assets/images/products/10408109_1.webp',
                    'description' => 'Suku cadang mesin industri untuk aplikasi heavy duty. Presisi tinggi dan tahan panas.',
                    'specs' => ['Model' => 'HD-10408109', 'Aplikasi' => 'Conveyor/Mill', 'Daya Tahan' => 'Extra High', 'Sertifikasi' => 'ISO 9001']
                ],
                'arei-safety-shoes' => [
                    'id' => 9, 'name' => 'Sepatu Safety Arei Outdoor Gear', 'category_name' => 'Safety PPE', 'price' => 450000, 
                    'image' => 'assets/images/products/areioutdoorgear_20241213_675be96a35aa5.webp',
                    'description' => 'Sepatu pelindung dengan ujung baja (steel toe) dan sol anti-slip. Dirancang untuk keamanan di lapangan ekstrem.',
                    'specs' => ['Proteksi' => 'Steel Toe Cap', 'Material' => 'Genuine Leather', 'Sol' => 'Rubber Anti-Slip', 'Warna' => 'Coklat']
                ],
                'portable-floodlight-s13' => [
                    'id' => 10, 'name' => 'Lampu Sorot Portable S13PNT New Stamp', 'category_name' => 'Lampu', 'price' => 320000, 
                    'image' => 'assets/images/products/s13pnt_img_new_stamp_june_2021-1.jpg',
                    'description' => 'Lampu sorot portable yang mudah dibawa. Cocok untuk perbaikan darurat atau proyek konstruksi malam hari.',
                    'specs' => ['Baterai' => 'Rechargeable Li-ion', 'Daya' => '30 Watt', 'Mode' => 'High/Low/SOS', 'Handle' => 'Adjustable']
                ],
                'tech-parts-9913' => [
                    'id' => 11, 'name' => 'Technical Parts 991388be Premium', 'category_name' => 'Electrical', 'price' => 560000, 
                    'image' => 'assets/images/products/991388be-29e4-4086-a23a-2bc25d820624w.webp',
                    'description' => 'Suku cadang teknis untuk sistem kelistrikan kompleks. Menjamin stabilitas arus pada mesin industri.',
                    'specs' => ['ID' => '991388be', 'Tipe' => 'Controller Module', 'Kompatibilitas' => 'Multi-brand', 'Garansi' => '1 Tahun']
                ],
                'floodlight-part-51d' => [
                    'id' => 12, 'name' => 'Floodlight Component 51dOkuVqvIL', 'category_name' => 'Lampu', 'price' => 150000, 
                    'image' => 'assets/images/products/51dOkuVqvIL._AC_UF1000,1000_QL80_.jpg',
                    'description' => 'Lensa dan komponen pengganti untuk lampu sorot LED. Terbuat dari material tahan panas tinggi.',
                    'specs' => ['Material' => 'Tempered Glass', 'Transmisi' => '98% Light', 'Thermal' => 'High Resistance', 'Tipe' => 'Replacement Part']
                ]
            ];

            if (isset($demo_products[$slug])) {
                $product = $demo_products[$slug];
                $product['slug'] = $slug;
            }
        }

        if (!$product) {
            http_response_code(404);
            require VIEWS_PATH . 'errors/404.php';
            return;
        }

        $images = []; // Empty for demo
        $related = []; // Empty for demo

        $data = [
            'title' => $product['name'] . ' - ' . SITE_NAME,
            'product' => $product,
            'images' => $images,
            'related' => $related
        ];

        require VIEWS_PATH . 'layouts/header.php';
        require VIEWS_PATH . 'products/detail.php';
        require VIEWS_PATH . 'layouts/footer.php';
    }

    public function category($slug, $subSlug = '') {
        $category = $this->categoryModel->getBySlug($slug, $subSlug);
        if (!$category) {
            http_response_code(404);
            require VIEWS_PATH . 'errors/404.php';
            return;
        }

        $_GET['category_id'] = $category['id'];
        $this->index(1);  // Reuse listing
    }
}

