<div class="product-card-premium animate-fade-up h-100">
    <a href="<?php echo BASE_URL; ?>/produk/detail/<?php echo $product['slug']; ?>" class="text-decoration-none">
        <div class="product-image-wrapper">
            <?php 
                $img_src = 'https://placehold.co/500x500/EEE/31343C?text=Product';
                if (!empty($product['image'])) {
                    // Check if it's already a full URL or starts with assets/
                    if (strpos($product['image'], 'http') === 0) {
                        $img_src = $product['image'];
                    } elseif (strpos($product['image'], 'assets/') === 0) {
                        $img_src = BASE_URL . '/' . $product['image'];
                    } else {
                        $img_src = UPLOADS_URL . 'products/' . $product['image'];
                    }
                }
            ?>
            <img src="<?php echo $img_src; ?>" 
                 alt="<?php echo $product['name']; ?>" 
                 class="img-fluid w-100 h-100 object-fit-cover transition-transform">
            <div class="product-badge"><?php echo $product['category_name'] ?? 'Produk'; ?></div>
        </div>
        <div class="product-info">
            <h5 class="fw-bold text-dark mb-2 text-truncate-2"><?php echo $product['name']; ?></h5>
            <div class="d-flex justify-content-between align-items-center">
                <div class="product-price">Rp <?php echo number_format($product['price'] ?? 0, 0, ',', '.'); ?></div>
                <div class="product-btn-arrow"><i class="fas fa-arrow-right"></i></div>
            </div>
        </div>
    </a>
</div>
