<?php
/**
 * Helper Functions (PRD 15.4-15.6)
 */

defined('BASEPATH') or exit('No direct script access allowed');

// Generate CSRF Token
function generateCsrfToken() {
    if (empty($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

// WhatsApp URL (PRD 15.5)
function getWhatsAppUrl(string $message = '', string $phone = ''): string {
    $phone = $phone ?: WA_NUMBER;
    $defaultMsg = getSetting('whatsapp_default_message') ?: 'Halo Nabana Sejahtera Teknik, saya tertarik dengan produk Anda.';
    $message = $message ?: $defaultMsg;
    return 'https://wa.me/' . $phone . '?text=' . urlencode($message);
}

function getProductWhatsAppUrl(string $productName): string {
    $template = getSetting('whatsapp_product_message') ?: 'Halo, saya tertarik dengan produk: {product_name}. Mohon info harga dan ketersediaan.';
    $message = str_replace('{product_name}', $productName, $template);
    return getWhatsAppUrl($message);
}

// Settings getter (PRD database)
function getSetting(string $key, string $default = '') {
    try {
        if (!class_exists('Database')) return $default;
        $db = Database::getInstance()->getConnection();
        if (!$db) return $default; // No DB available (Vercel demo mode)
        $stmt = $db->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        return $stmt->fetchColumn() ?: $default;
    } catch (Exception $e) {
        return $default;
    }
}

// Security: Escape output
function esc($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Pagination helper
function paginate($current, $total, $perPage, $baseUrl) {
    $pages = ceil($total / $perPage);
    $html = '';
    if ($pages > 1) {
        $html .= '<nav><ul class="pagination">';
        if ($current > 1) {
            $html .= '<li class="page-item"><a class="page-link" href="' . $baseUrl . '?page=' . ($current-1) . '">&laquo;</a></li>';
        }
        for ($i = max(1, $current-2); $i <= min($pages, $current+2); $i++) {
            $active = $i == $current ? 'active' : '';
            $html .= '<li class="page-item ' . $active . '"><a class="page-link" href="' . $baseUrl . '?page=' . $i . '">' . $i . '</a></li>';
        }
        if ($current < $pages) {
            $html .= '<li class="page-item"><a class="page-link" href="' . $baseUrl . '?page=' . ($current+1) . '">&raquo;</a></li>';
        }
        $html .= '</ul></nav>';
    }
    return $html;
}

// Track Visitor (PRD visitor_stats - simplified)
function trackVisitor($url) {
    if (!class_exists('Database')) return;
    try {
        $db = Database::getInstance()->getConnection();
        if (!$db) return; // No DB available
        $stmt = $db->prepare("INSERT INTO visitor_stats (page_url, visitor_ip, created_at) VALUES (?, ?, NOW()) ON DUPLICATE KEY UPDATE page_url=page_url");
        $stmt->execute([$url, $_SERVER['REMOTE_ADDR'] ?? 'unknown']);
    } catch (Exception $e) {
        // Ignore DB errors during setup
    }
}

// SEO Schema Markup (PRD 15.6)
function getOrganizationSchema(): string
{
    $schema = [
        "@context" => "https://schema.org",
        "@type" => "Organization",
        "name" => "Nabana Sejahtera Teknik",
        "description" => getSetting('site_description'),
        "url" => BASE_URL,
        "logo" => BASE_URL . '/assets/images/logo.png',
        "address" => [
            "@type" => "PostalAddress",
            "streetAddress" => "Jl Permata Jaya, Perumahan Villa Permata",
            "addressLocality" => "Medang Deras",
            "addressRegion" => "Sumatera Utara",
            "addressCountry" => "ID"
        ],
        "contactPoint" => [
            "@type" => "ContactPoint",
            "telephone" => "+62-857-6777-2694",
            "contactType" => "sales"
        ]
    ];
    
    return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES) . '</script>';
}

function getProductSchema(array $product): string
{
    $schema = [
        "@context" => "https://schema.org",
        "@type" => "Product",
        "name" => $product['name'],
        "description" => $product['short_description'] ?? $product['description'],
        "sku" => $product['sku'] ?? '',
        "brand" => [
            "@type" => "Brand",
            "name" => $product['brand'] ?? 'Nabana Sejahtera Teknik'
        ],
        "image" => BASE_URL . '/uploads/products/large/' . ($product['primary_image'] ?? 'placeholder.jpg'),
        "url" => BASE_URL . '/produk/' . $product['slug'],
        "offers" => [
            "@type" => "Offer",
            "availability" => "https://schema.org/InStock",
            "priceCurrency" => "IDR",
            "seller" => [
                "@type" => "Organization",
                "name" => "Nabana Sejahtera Teknik"
            ]
        ]
    ];
    
    return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES) . '</script>';
}

// WhatsApp Floating Button (PRD 15.5)
function getWhatsAppFloatingButton(): string
{
    $url = getWhatsAppUrl();
    return <<<HTML
    <a href="{$url}" target="_blank" rel="noopener" 
       class="whatsapp-float" title="Chat via WhatsApp"
       aria-label="Hubungi kami via WhatsApp">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
            <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.325-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
        </svg>
        <span class="whatsapp-float-tooltip">Chat dengan kami</span>
    </a>
    HTML;
}

