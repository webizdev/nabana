<section class="section-padding page-header-spacing">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6">
                <div class="glass p-3 rounded-5 sticky-top" style="top: 120px;">
                    <?php 
                        $img_src = 'https://placehold.co/800x800/EEE/31343C?text=Product';
                        if (!empty($data['product']['image'])) {
                            if (strpos($data['product']['image'], 'http') === 0) {
                                $img_src = $data['product']['image'];
                            } elseif (strpos($data['product']['image'], 'assets/') === 0) {
                                $img_src = BASE_URL . '/' . $data['product']['image'];
                            } else {
                                $img_src = UPLOADS_URL . 'products/' . $data['product']['image'];
                            }
                        }
                    ?>
                    <div class="main-image mb-3 overflow-hidden rounded-4" style="height: 450px;">
                        <img src="<?php echo $img_src; ?>" 
                             alt="<?php echo $data['product']['name']; ?>" 
                             class="img-fluid w-100 h-100 object-fit-cover transition-transform hover-zoom">
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="premium-card glass p-4 p-md-5">
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/produk" class="text-primary">Katalog</a></li>
                            <li class="breadcrumb-item active"><?php echo $data['product']['category_name'] ?? 'Detail Produk'; ?></li>
                        </ol>
                    </nav>

                    <h1 class="display-6 fw-bold mb-3"><?php echo $data['product']['name']; ?></h1>
                    <div class="h3 fw-bold text-primary-custom mb-4">
                        Rp <?php echo number_format($data['product']['price'] ?? 0, 0, ',', '.'); ?>
                    </div>

                    <div class="mb-5">
                        <h5 class="fw-bold mb-3 d-flex align-items-center">
                            <span class="bg-primary-custom p-1 rounded me-2" style="width: 5px; height: 20px;"></span>
                            Deskripsi Produk
                        </h5>
                        <div class="text-muted leading-relaxed">
                            <?php echo nl2br($data['product']['description']); ?>
                        </div>
                    </div>

                    <?php if (!empty($data['product']['specs'])): ?>
                    <div class="mb-5">
                        <h5 class="fw-bold mb-3 d-flex align-items-center">
                            <span class="bg-primary-custom p-1 rounded me-2" style="width: 5px; height: 20px;"></span>
                            Spesifikasi Teknis
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <?php foreach ($data['product']['specs'] as $key => $value): ?>
                                        <tr>
                                            <td class="text-muted py-2" width="40%"><?php echo $key; ?></td>
                                            <td class="fw-bold py-2"><?php echo $value; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="d-grid mt-4">
                        <a href="https://wa.me/<?php echo WA_NUMBER; ?>?text=<?php echo urlencode("Halo Nabana Sejahtera Teknik, saya tertarik dengan produk: " . $data['product']['name'] . ". Mohon info stok dan pengirimannya."); ?>" 
                           target="_blank"
                           class="btn-premium btn-primary-premium py-3 justify-content-center shadow-lg">
                            <i class="fab fa-whatsapp fa-lg me-2"></i> Tanya via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($data['related'])): ?>
            <div class="mt-5 pt-5">
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <h3 class="fw-bold mb-0">Produk <span class="text-gradient">Terkait</span></h3>
                    <a href="<?php echo BASE_URL; ?>/produk" class="text-primary text-decoration-none fw-bold small">Lihat Semua</a>
                </div>
                <div class="row g-4">
                    <?php foreach ($data['related'] as $product): ?>
                        <div class="col-lg-3 col-md-6">
                            <?php require VIEWS_PATH . 'partials/product-card.php'; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
