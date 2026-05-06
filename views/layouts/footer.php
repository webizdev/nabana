</main>

<footer class="main-footer">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4">
                <div class="footer-brand d-flex align-items-center mb-4">
                    <div class="brand-icon bg-white text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                        <i class="fas fa-tools"></i>
                    </div>
                    <span class="fw-bold text-white h4 mb-0">NABANA</span>
                </div>
                <p class="mb-4">Penyedia suku cadang, alat teknik, dan perangkat elektronik berkualitas tinggi untuk kebutuhan industri dan otomotif Anda.</p>
            </div>
            
            <div class="col-lg-2 col-md-4">
                <h4>Tautan</h4>
                <a href="<?php echo BASE_URL; ?>" class="footer-link">Beranda</a>
                <a href="<?php echo BASE_URL; ?>/tentang-kami" class="footer-link">Tentang Kami</a>
                <a href="<?php echo BASE_URL; ?>/produk" class="footer-link">Produk</a>
                <a href="<?php echo BASE_URL; ?>/kontak" class="footer-link">Kontak</a>
            </div>
            
            <div class="col-lg-3 col-md-4">
                <h4>Layanan</h4>
                <a href="#" class="footer-link">Sparepart Otomotif</a>
                <a href="#" class="footer-link">Alat Teknik Industri</a>
                <a href="#" class="footer-link">Konsultasi Teknik</a>
                <a href="#" class="footer-link">Pengiriman Cepat</a>
            </div>
            
            <div class="col-lg-3 col-md-4">
                <h4>Kontak Kami</h4>
                <ul class="list-unstyled footer-contact-list">
                    <li class="d-flex mb-3">
                        <i class="fas fa-phone-alt mt-1 me-3 text-accent flex-shrink-0" style="width: 20px;"></i>
                        <a href="tel:<?php echo getSetting('company_phone'); ?>" class="text-reset text-decoration-none">
                            <?php echo esc(getSetting('company_phone') ?? '+62 857 6777 2694'); ?>
                        </a>
                    </li>
                    <li class="d-flex mb-4">
                        <i class="fas fa-envelope mt-1 me-3 text-accent flex-shrink-0" style="width: 20px;"></i>
                        <a href="mailto:<?php echo getSetting('company_email'); ?>" class="text-reset text-decoration-none text-break">
                            <?php echo esc(getSetting('company_email') ?? 'info@nabana.com'); ?>
                        </a>
                    </li>
                </ul>
                <div class="social-links d-flex gap-3">
                    <a href="#" class="btn btn-outline-light rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-size: 0.9rem;"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="btn btn-outline-light rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-size: 0.9rem;"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="btn btn-outline-light rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-size: 0.9rem;"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
        
        <hr class="my-5" style="border-color: rgba(255,255,255,0.1);">
        
        <div class="text-center">
            <p class="mb-0 small">&copy; <?php echo date('Y'); ?> Nabana Sejahtera Teknik. All rights reserved.</p>
        </div>
    </div>
</footer>

<?php echo getWhatsAppFloatingButton(); ?>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>js/main.js"></script>

</body>
</html>
