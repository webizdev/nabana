<section class="section-padding page-header-spacing">
    <div class="container">
        <div class="text-center mb-5 animate-fade-up">
            <h6 class="text-primary-custom fw-bold text-uppercase mb-2">Hubungi Kami</h6>
            <h1 class="page-title">Ada Pertanyaan? <span class="text-gradient">Mari Berdiskusi</span></h1>
            <p class="lead-mobile opacity-75 max-w-600 mx-auto">Tim kami siap membantu memberikan solusi teknik terbaik untuk kebutuhan industri Anda.</p>
        </div>

        <div class="row g-5">
            <div class="col-lg-5">
                <div class="premium-card bg-blue-light h-100 p-4 p-md-5">
                    <h3 class="fw-bold text-dark mb-5">Informasi Kontak</h3>
                    
                    <div class="contact-info-item d-flex mb-4">
                        <div class="bg-white text-primary-custom shadow-sm rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 54px; height: 54px;">
                            <i class="fas fa-map-marker-alt fa-lg"></i>
                        </div>
                        <div class="ms-4">
                            <h6 class="fw-bold text-dark mb-1">Alamat Kantor</h6>
                            <p class="text-muted small mb-0"><?php echo esc(getSetting('company_address')); ?></p>
                        </div>
                    </div>

                    <div class="contact-info-item d-flex mb-4">
                        <div class="bg-white text-primary-custom shadow-sm rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 54px; height: 54px;">
                            <i class="fas fa-phone-alt fa-lg"></i>
                        </div>
                        <div class="ms-4">
                            <h6 class="fw-bold text-dark mb-1">Telepon / WA</h6>
                            <p class="text-muted small mb-0"><?php echo esc(getSetting('company_phone')); ?></p>
                        </div>
                    </div>

                    <div class="contact-info-item d-flex mb-5">
                        <div class="bg-white text-primary-custom shadow-sm rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 54px; height: 54px;">
                            <i class="fas fa-envelope fa-lg"></i>
                        </div>
                        <div class="ms-4">
                            <h6 class="fw-bold text-dark mb-1">Email Resmi</h6>
                            <p class="text-muted small mb-0"><?php echo esc(getSetting('company_email')); ?></p>
                        </div>
                    </div>

                    <div class="mt-auto">
                        <h6 class="fw-bold text-dark mb-3">Ikuti Kami</h6>
                        <div class="social-links d-flex gap-3">
                            <a href="#" class="btn btn-white shadow-sm rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="fab fa-facebook-f text-primary"></i></a>
                            <a href="#" class="btn btn-white shadow-sm rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="fab fa-instagram text-danger"></i></a>
                            <a href="#" class="btn btn-white shadow-sm rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="fab fa-linkedin-in text-primary"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="premium-card glass p-4 p-md-5">
                    <?php if (isset($_SESSION['contact_success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
                            <?php echo $_SESSION['contact_success']; unset($_SESSION['contact_success']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo BASE_URL; ?>/kontak" method="POST">
                        <input type="hidden" name="_csrf_token" value="<?php echo generateCsrfToken(); ?>">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control rounded-4 p-3 border-0 bg-light" placeholder="Masukkan nama Anda" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Alamat Email</label>
                                <input type="email" name="email" class="form-control rounded-4 p-3 border-0 bg-light" placeholder="email@contoh.com" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Pesan Anda</label>
                                <textarea name="message" rows="8" class="form-control rounded-4 p-3 border-0 bg-light" placeholder="Bagaimana kami bisa membantu Anda?" required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn-premium btn-primary-premium w-100 justify-content-center py-3">
                                    Kirim Pesan <i class="fas fa-paper-plane ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <div class="mt-5 pt-4 animate-fade-up">
            <div class="premium-card p-0 overflow-hidden rounded-5 shadow-lg border-0">
                <div style="width: 100%; height: 450px;">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127441.22238478446!2d99.30948924335938!3d3.461331700000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3031835700000001%3A0x6b6c0e0000000000!2sKabupaten%20Batu%20Bara%2C%20Sumatera%20Utara!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" 
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
