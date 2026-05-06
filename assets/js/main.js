// main.js - Nabana Sejahtera Teknik (PRD 4.2)

// AOS Initialization
AOS.init({
  duration: 1000,
  once: true,
  offset: 100
});

// Swiper Configurations
document.addEventListener('DOMContentLoaded', function() {
  // Hero Swiper
  const heroSwiper = new Swiper('.hero-swiper', {
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    effect: 'fade',
    fadeEffect: { crossFade: true }
  });

  // Featured Products Swiper
  const featuredSwiper = new Swiper('.featured-swiper', {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    autoplay: {
      delay: 3000,
      disableOnInteraction: false,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    breakpoints: {
      576: { slidesPerView: 2 },
      768: { slidesPerView: 3 },
      992: { slidesPerView: 4 }
    }
  });

  // Testimonials Swiper
  const testimonialSwiper = new Swiper('.testimonials-swiper', {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    autoplay: {
      delay: 4000,
    },
    pagination: {
      el: '.swiper-pagination-testimonial',
      clickable: true,
    },
    breakpoints: {
      768: { slidesPerView: 2 },
      992: { slidesPerView: 3 }
    }
  });
});

// Header Scroll Effect
let lastScroll = 0;
window.addEventListener('scroll', () => {
  const header = document.querySelector('.header');
  if (window.scrollY > 100) {
    header.classList.add('scrolled');
  } else {
    header.classList.remove('scrolled');
  }
});

// Smooth Scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });
});

// Form CSRF
function updateCsrfToken() {
  const token = document.getElementById('csrf_token').value;
  document.querySelectorAll('input[name="<?php echo CSRF_TOKEN_NAME; ?>"]').forEach(el => {
    el.value = token;
  });
}

// Lazy Load Images
if ('loading' in HTMLImageElement.prototype) {
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('img[data-src]').forEach(img => {
      img.src = img.dataset.src;
      img.removeAttribute('data-src');
    });
  });
} else {
  // Fallback for older browsers
  const script = document.createElement('script');
  script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js';
  document.head.appendChild(script);
}

// Search Functionality (Live search)
function initLiveSearch() {
  const searchInput = document.getElementById('product-search');
  if (searchInput) {
    searchInput.addEventListener('input', function() {
      const query = this.value;
      // AJAX search to /api/search-products
      if (query.length > 2) {
        // Implement AJAX later
        console.log('Searching:', query);
      }
    });
  }
}

// Filter Sidebar Toggle Mobile
function initMobileFilters() {
  const toggle = document.getElementById('filter-toggle');
  const sidebar = document.getElementById('product-sidebar');
  if (toggle && sidebar) {
    toggle.addEventListener('click', () => {
      sidebar.classList.toggle('show');
    });
  }
}

// Initialize on load
document.addEventListener('DOMContentLoaded', () => {
  initLiveSearch();
  initMobileFilters();
  updateCsrfToken();
});

// Lightbox for Product Images
function initLightbox() {
  const images = document.querySelectorAll('.product-gallery img');
  images.forEach(img => {
    img.addEventListener('click', function() {
      // Simple modal lightbox
      const modal = document.createElement('div');
      modal.className = 'lightbox-modal';
      modal.innerHTML = `
        <span class="lightbox-close">&times;</span>
        <img src="${this.src}" alt="${this.alt}">
      `;
      document.body.appendChild(modal);
      modal.querySelector('.lightbox-close').onclick = () => modal.remove();
      modal.onclick = (e) => { if (e.target === modal) modal.remove(); };
    });
  });
}

// Navbar Dropdown Hover (Desktop)
if (window.innerWidth >= 992) {
  document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
    toggle.addEventListener('mouseenter', () => toggle.parentElement.classList.add('show'));
    toggle.addEventListener('mouseleave', () => toggle.parentElement.classList.remove('show'));
  });
}

// Counter Animation
function animateCounters() {
  const counters = document.querySelectorAll('.counter');
  counters.forEach(counter => {
    const target = parseInt(counter.getAttribute('data-target'));
    const increment = target / 100;
    let current = 0;
    const timer = setInterval(() => {
      current += increment;
      if (current >= target) {
        counter.textContent = target.toLocaleString();
        clearInterval(timer);
      } else {
        counter.textContent = Math.floor(current).toLocaleString();
      }
    }, 20);
  });
}

// Intersection Observer for animations
const observerOptions = {
  threshold: 0.1,
  rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      if (entry.target.classList.contains('animate-counter')) {
        animateCounters();
      }
      observer.unobserve(entry.target);
    }
  });
}, observerOptions);

// Service Worker for PWA (optional)
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/sw.js');
}
