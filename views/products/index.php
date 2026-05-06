<section class="section-padding bg-light page-header-spacing">
    <div class="container">
        <!-- Header & Search -->
        <div class="row align-items-center mb-5 g-4">
            <div class="col-lg-5 animate-fade-up">
                <h6 class="text-primary-custom fw-bold text-uppercase mb-2">Katalog Produk</h6>
                <h1 class="page-title mb-0">Jelajahi Produk <span class="text-gradient">Unggulan</span> Kami</h1>
            </div>
            <div class="col-lg-7 animate-fade-up">
                <div class="d-flex flex-column flex-md-row gap-3 justify-content-lg-end align-items-md-center">
                    <!-- Search Bar -->
                    <div class="search-bar-premium glass rounded-pill px-4 py-2 d-flex align-items-center shadow-sm w-100 max-w-400">
                        <i class="fas fa-search text-muted me-3"></i>
                        <input type="text" id="productSearch" class="form-control border-0 bg-transparent p-0 shadow-none" placeholder="Cari produk Anda...">
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Filters -->
        <div class="mb-5 animate-fade-up" style="animation-delay: 0.1s;">
            <div class="category-filter-container d-flex flex-wrap gap-2" id="categoryFilters">
                <button class="nav-link-category-pill glass active px-4 py-2 fw-semibold border-0" data-category="all">Semua</button>
                <button class="nav-link-category-pill glass px-4 py-2 fw-semibold border-0" data-category="Safety PPE">Safety PPE</button>
                <button class="nav-link-category-pill glass px-4 py-2 fw-semibold border-0" data-category="Lampu">Lampu & Pencahayaan</button>
                <button class="nav-link-category-pill glass px-4 py-2 fw-semibold border-0" data-category="Barang Industri">Barang Industri</button>
                <button class="nav-link-category-pill glass px-4 py-2 fw-semibold border-0" data-category="Alat Angkat">Alat Angkat</button>
                <button class="nav-link-category-pill glass px-4 py-2 fw-semibold border-0" data-category="Electrical">Electrical Equipment</button>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="row g-4 mb-5" id="productGrid">
            <!-- Products will be injected by JavaScript -->
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center animate-fade-up" id="paginationContainer">
            <!-- Pagination buttons will be injected by JavaScript -->
        </div>
    </div>
</section>

<!-- Product Data & Logic Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const products = [
        { name: 'Sarung Tangan Safety Anti Sayat UCI 69', category: 'Safety PPE', price: 125000, image: 'assets/images/products/sarung-tangan-cut-gloves-anti-sayat-pisau-uci-safety-69.webp', slug: 'safety-gloves-uci' },
        { name: 'Lampu Sorot LED Floodlight 48W IP68', category: 'Lampu', price: 285000, image: 'assets/images/products/taffled-lampu-sorot-tembak-mobil-led-floodlight-cool-white-ip68-48w-d841.jpeg', slug: 'led-floodlight-48w' },
        { name: 'Industrial Chain ANSI RS FSCM High Quality', category: 'Barang Industri', price: 850000, image: 'assets/images/products/chain-ANSI-RS-FSCM.jpg', slug: 'industrial-chain-ansi' },
        { name: 'Sugar Mill Chain Heavy Duty 300x222', category: 'Barang Industri', price: 1250000, image: 'assets/images/products/sugar-mill-chain-300x222.jpg', slug: 'sugar-mill-chain' },
        { name: 'Rantai Stainless Steel 50SSRB-1 Premium', category: 'Alat Angkat', price: 950000, image: 'assets/images/products/50SSRB-1.jpg', slug: 'ss-chain-50ssrb' },
        { name: 'Sarung Tangan Touchscreen Kiprun V2', category: 'Safety PPE', price: 85000, image: 'assets/images/products/sarung-tangan-lari-touchscreen-500-v2-hitam-kiprun-8759607.avif', slug: 'touchscreen-gloves-kiprun' },
        { name: 'Electrical Tool Component 10569648', category: 'Electrical', price: 450000, image: 'assets/images/products/10569648_1.webp', slug: 'electrical-component-1056' },
        { name: 'Industrial Component 10408109 Heavy Duty', category: 'Barang Industri', price: 670000, image: 'assets/images/products/10408109_1.webp', slug: 'industrial-component-1040' },
        { name: 'Sepatu Safety Arei Outdoor Gear', category: 'Safety PPE', price: 450000, image: 'assets/images/products/areioutdoorgear_20241213_675be96a35aa5.webp', slug: 'arei-safety-shoes' },
        { name: 'Lampu Sorot Portable S13PNT New Stamp', category: 'Lampu', price: 320000, image: 'assets/images/products/s13pnt_img_new_stamp_june_2021-1.jpg', slug: 'portable-floodlight-s13' },
        { name: 'Technical Parts 991388be Premium', category: 'Electrical', price: 560000, image: 'assets/images/products/991388be-29e4-4086-a23a-2bc25d820624w.webp', slug: 'tech-parts-9913' },
        { name: 'Floodlight Component 51dOkuVqvIL', category: 'Lampu', price: 150000, image: 'assets/images/products/51dOkuVqvIL._AC_UF1000,1000_QL80_.jpg', slug: 'floodlight-part-51d' }
    ];

    let filteredProducts = [...products];
    let currentPage = 1;
    const itemsPerPage = 6;
    let activeCategory = 'all';
    let searchQuery = '';

    const productGrid = document.getElementById('productGrid');
    const paginationContainer = document.getElementById('paginationContainer');
    const searchInput = document.getElementById('productSearch');
    const categoryButtons = document.querySelectorAll('#categoryFilters .nav-link-category-pill');

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number).replace('IDR', 'Rp');
    }

    function renderProducts() {
        productGrid.innerHTML = '';
        
        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const paginatedItems = filteredProducts.slice(start, end);

        if (paginatedItems.length === 0) {
            productGrid.innerHTML = `
                <div class="col-12 text-center py-5">
                    <div class="glass p-5 rounded-5 d-inline-block">
                        <i class="fas fa-search-minus fa-4x text-muted mb-4"></i>
                        <h3>Produk Tidak Ditemukan</h3>
                        <p class="text-muted">Coba kata kunci atau kategori lainnya.</p>
                    </div>
                </div>`;
            paginationContainer.innerHTML = '';
            return;
        }

        paginatedItems.forEach(product => {
            const card = `
                <div class="col-6 col-lg-4 col-md-6 mb-3 mb-md-4 animate-fade-up">
                    <div class="product-card-premium h-100">
                        <a href="<?php echo BASE_URL; ?>/produk/detail/${product.slug}" class="text-decoration-none">
                            <div class="product-image-wrapper">
                                <img src="<?php echo BASE_URL; ?>/${product.image}" alt="${product.name}" class="img-fluid w-100 h-100 object-fit-cover transition-transform">
                                <div class="product-badge">${product.category}</div>
                            </div>
                            <div class="product-info">
                                <h5 class="product-title-text fw-bold text-dark mb-1 mb-md-2 text-truncate-2">${product.name}</h5>
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                                    <div class="product-price text-primary fw-bold">${formatRupiah(product.price)}</div>
                                    <div class="product-btn-arrow d-none d-md-flex"><i class="fas fa-arrow-right"></i></div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>`;
            productGrid.innerHTML += card;
        });

        renderPagination();
    }

    function renderPagination() {
        const totalPages = Math.ceil(filteredProducts.length / itemsPerPage);
        paginationContainer.innerHTML = '';

        if (totalPages <= 1) return;

        let paginationHtml = `<nav><ul class="pagination pagination-premium gap-2 border-0">`;
        
        for (let i = 1; i <= totalPages; i++) {
            paginationHtml += `
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <button class="page-link rounded-circle d-flex align-items-center justify-content-center shadow-sm border-0" 
                            style="width: 45px; height: 45px;" onclick="changePage(${i})">${i}</button>
                </li>`;
        }
        
        paginationHtml += `</ul></nav>`;
        paginationContainer.innerHTML = paginationHtml;
    }

    window.changePage = function(page) {
        currentPage = page;
        renderProducts();
        window.scrollTo({ top: productGrid.offsetTop - 150, behavior: 'smooth' });
    };

    function filterProducts() {
        filteredProducts = products.filter(p => {
            const matchesCategory = activeCategory === 'all' || p.category === activeCategory;
            const matchesSearch = p.name.toLowerCase().includes(searchQuery.toLowerCase());
            return matchesCategory && matchesSearch;
        });
        currentPage = 1;
        renderProducts();
    }

    searchInput.addEventListener('input', (e) => {
        searchQuery = e.target.value;
        filterProducts();
    });

    categoryButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            categoryButtons.forEach(b => b.classList.remove('active', 'btn-primary-premium'));
            categoryButtons.forEach(b => b.classList.add('glass'));
            
            btn.classList.add('active', 'btn-primary-premium');
            btn.classList.remove('glass');
            
            activeCategory = btn.dataset.category;
            filterProducts();
        });
    });

    // Initial render
    renderProducts();
});
</script>

<style>
.max-w-400 { max-width: 400px; }
.search-bar-premium input::placeholder { color: #94a3b8; font-size: 0.9rem; }
.nav-link-category-pill.active {
    background: var(--grad-primary) !important;
    color: white !important;
    border: none !important;
    box-shadow: 0 8px 20px rgba(var(--primary-rgb), 0.3) !important;
}
.pagination-premium .page-link {
    background: white;
    color: var(--dark);
    font-weight: 600;
    transition: all 0.3s ease;
}
.pagination-premium .page-item.active .page-link {
    background: var(--primary) !important;
    color: white !important;
    transform: scale(1.1);
}
.pagination-premium .page-link:hover {
    background: var(--primary-light);
    color: white;
}
</style>
