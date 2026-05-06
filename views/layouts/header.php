<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo esc($data['title'] ?? 'Nabana Sejahtera Teknik - Alat Teknik & Elektronik'); ?></title>
    <meta name="description" content="<?php echo esc($data['meta_description'] ?? getSetting('meta_description') ?? 'Penyedia Sparepart, Alat Teknik, dan Elektronik Terbaik'); ?>">
    
    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/style.css">
    
    <!-- SEO -->
    <?php echo getOrganizationSchema(); ?>
</head>
<body>

<header class="main-header">
    <nav class="navbar navbar-expand-lg">
        <div class="container glass py-2 px-4 rounded-pill">
            <a class="navbar-brand d-flex align-items-center" href="<?php echo BASE_URL; ?>">
                <div class="brand-icon bg-white text-primary-custom shadow-sm rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px; border: 1px solid rgba(0,0,0,0.05);">
                    <i class="fas fa-tools"></i>
                </div>
                <span class="fw-bold text-dark h5 mb-0">NABANA</span>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>/tentang-kami">Tentang Kami</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>/produk">Produk</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>/layanan">Layanan</a></li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn-premium btn-primary-premium py-2 px-4" href="<?php echo BASE_URL; ?>/kontak">
                            Kontak <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main class="main-content">
<?php if (isset($data['breadcrumb'])): ?>
<nav aria-label="breadcrumb" class="bg-light py-2">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <?php echo $data['breadcrumb']; ?>
        </ol>
    </div>
</nav>
<?php endif; ?>
<input type="hidden" id="csrf_token" value="<?php echo generateCsrfToken(); ?>">

