/**
 * LDK Syahid - Modern Base JavaScript
 * Reusable scripts for all landing pages
 * Version: 2.0
 */

(function ($) {
    "use strict";

    // ========================================
    // 1. CONFIGURATION
    // ========================================
    const CONFIG = {
        scrollOffset: 300,
        animationDuration: 800,
        transitionSpeed: 300,
        carouselSpeed: 1000,
        toastDuration: 3000
    };

    // ========================================
    // 2. SPINNER / LOADER
    // ========================================
    const Spinner = {
        init: function() {
            setTimeout(function () {
                const spinner = document.getElementById('spinner');
                if (spinner) {
                    spinner.classList.remove('show');
                }
            }, 1);
        },

        show: function() {
            const spinner = document.getElementById('spinner');
            if (spinner) {
                spinner.classList.add('show');
            }
        },

        hide: function() {
            const spinner = document.getElementById('spinner');
            if (spinner) {
                spinner.classList.remove('show');
            }
        }
    };

    // ========================================
    // 3. WOW.JS ANIMATIONS
    // ========================================
    const Animations = {
        init: function() {
            if (typeof WOW !== 'undefined') {
                new WOW({
                    boxClass: 'wow',
                    animateClass: 'animated',
                    offset: 50,
                    mobile: true,
                    live: true
                }).init();
            }
        }
    };

    // ========================================
    // 4. STICKY NAVBAR
    // ========================================
    const StickyNavbar = {
        init: function() {
            const navbar = document.querySelector('.sticky-top');
            if (!navbar) return;

            // Ensure navbar is always visible
            navbar.style.top = '0px';

            $(window).scroll(function () {
                const currentScroll = $(this).scrollTop();

                if (currentScroll > 50) {
                    $('.sticky-top').addClass('navbar-scrolled');
                } else {
                    $('.sticky-top').removeClass('navbar-scrolled');
                }
            });
        }
    };

    // ========================================
    // 5. BACK TO TOP BUTTON
    // ========================================
    const BackToTop = {
        init: function() {
            const backToTopBtn = document.querySelector('.back-to-top');
            if (!backToTopBtn) return;

            // Show/hide button on scroll
            $(window).scroll(function () {
                if ($(this).scrollTop() > CONFIG.scrollOffset) {
                    $('.back-to-top').fadeIn('slow');
                } else {
                    $('.back-to-top').fadeOut('slow');
                }
            });

            // Smooth scroll to top
            $(backToTopBtn).click(function (e) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: 0
                }, 1500, 'easeInOutExpo');
                return false;
            });
        }
    };

    // ========================================
    // 6. OWL CAROUSEL - ALL CAROUSELS
    // ========================================
    const Carousels = {
        init: function() {
            this.testimonialCarousel();
        },

        testimonialCarousel: function() {
            if ($(".testimonial-carousel").length) {
                $(".testimonial-carousel").owlCarousel({
                    autoplay: true,
                    autoplayTimeout: 5000,
                    autoplayHoverPause: true,
                    smartSpeed: CONFIG.carouselSpeed,
                    items: 1,
                    dots: true,
                    loop: true,
                    nav: true,
                    navText: [
                        '<i class="fas fa-chevron-left"></i>',
                        '<i class="fas fa-chevron-right"></i>'
                    ],
                    responsive: {
                        0: {
                            nav: false,
                            dots: true
                        },
                        992: {
                            nav: true,
                            dots: false
                        }
                    }
                });
            }
        }
    };

    // ========================================
    // 7. SCROLL ANIMATIONS (Intersection Observer)
    // ========================================
    const ScrollAnimations = {
        init: function() {
            if (!('IntersectionObserver' in window)) return;

            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-visible');
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe elements with animation classes
            document.querySelectorAll('.animate-on-scroll').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(el);
            });
        }
    };

    // ========================================
    // 8. HOVER EFFECTS
    // ========================================
    const HoverEffects = {
        init: function() {
            this.cardHover();
            this.imageParallax();
        },

        cardHover: function() {
            const cards = document.querySelectorAll('.card-modern, .card-elegant, .feature-box');

            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-6px)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        },

        imageParallax: function() {
            const parallaxContainers = document.querySelectorAll('.parallax-container');

            parallaxContainers.forEach(container => {
                container.addEventListener('mousemove', (e) => {
                    const xAxis = (window.innerWidth / 2 - e.pageX) / 25;
                    const yAxis = (window.innerHeight / 2 - e.pageY) / 25;
                    container.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
                });

                container.addEventListener('mouseenter', () => {
                    container.style.transition = 'none';
                });

                container.addEventListener('mouseleave', () => {
                    container.style.transition = 'all 0.5s ease';
                    container.style.transform = 'rotateY(0deg) rotateX(0deg)';
                });
            });
        }
    };

    // ========================================
    // 9. TOAST NOTIFICATIONS
    // ========================================
    const Toast = {
        show: function(message, type = 'success') {
            // Remove existing toast
            const existingToast = document.querySelector('.toast-notification');
            if (existingToast) {
                existingToast.remove();
            }

            // Create toast element
            const toast = document.createElement('div');
            toast.className = 'toast-notification';

            // Icon based on type
            let icon = 'fa-check-circle';
            if (type === 'error') icon = 'fa-times-circle';
            if (type === 'warning') icon = 'fa-exclamation-circle';
            if (type === 'info') icon = 'fa-info-circle';

            toast.innerHTML = `
                <i class="fas ${icon}"></i>
                <span>${message}</span>
            `;

            document.body.appendChild(toast);

            // Auto remove after duration
            setTimeout(() => {
                toast.classList.add('fade-out');
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.remove();
                    }
                }, 300);
            }, CONFIG.toastDuration);
        },

        success: function(message) {
            this.show(message, 'success');
        },

        error: function(message) {
            this.show(message, 'error');
        },

        warning: function(message) {
            this.show(message, 'warning');
        },

        info: function(message) {
            this.show(message, 'info');
        }
    };

    // ========================================
    // 10. SMOOTH SCROLL
    // ========================================
    const SmoothScroll = {
        init: function() {
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    const href = this.getAttribute('href');

                    // Skip if it's just "#" or empty
                    if (href === '#' || href === '') return;

                    const target = document.querySelector(href);
                    if (target) {
                        e.preventDefault();

                        const navbarHeight = document.querySelector('.navbar')?.offsetHeight || 0;
                        const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - navbarHeight - 20;

                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        }
    };

    // ========================================
    // 11. IMAGE ERROR HANDLING
    // ========================================
    window.onImgErr = function(el) {
        if (!el.dataset.err) {
            el.src = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300' preserveAspectRatio='xMidYMid meet'%3E%3Crect width='400' height='300' fill='%23e9ecef'/%3E%3Cpolygon points='80,240 200,120 320,240' fill='%23ced4da'/%3E%3Cpolygon points='200,240 300,160 400,240' fill='%23adb5bd'/%3E%3Ccircle cx='310' cy='100' r='35' fill='%23dee2e6'/%3E%3Crect y='240' width='400' height='60' fill='%23dee2e6'/%3E%3Ctext x='200' y='275' text-anchor='middle' fill='%236c757d' font-family='sans-serif' font-size='15'%3ENo Image%3C/text%3E%3C/svg%3E";
            el.dataset.err = 1;
        }
    };

    const ImageErrorHandler = {
        init: function() {
            const defaultImage = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300' preserveAspectRatio='xMidYMid meet'%3E%3Crect width='400' height='300' fill='%23e9ecef'/%3E%3Cpolygon points='80,240 200,120 320,240' fill='%23ced4da'/%3E%3Cpolygon points='200,240 300,160 400,240' fill='%23adb5bd'/%3E%3Ccircle cx='310' cy='100' r='35' fill='%23dee2e6'/%3E%3Crect y='240' width='400' height='60' fill='%23dee2e6'/%3E%3Ctext x='200' y='275' text-anchor='middle' fill='%236c757d' font-family='sans-serif' font-size='15'%3ENo Image%3C/text%3E%3C/svg%3E";

            document.querySelectorAll('img').forEach(img => {
                img.addEventListener('error', function() {
                    if (!this.dataset.errorHandled) {
                        this.src = defaultImage;
                        this.alt = 'Gambar tidak tersedia';
                        this.classList.add('img-error');
                        this.dataset.errorHandled = 'true';
                    }
                });
            });
        }
    };

    // ========================================
    // 12. FORM VALIDATION ENHANCEMENT
    // ========================================
    const FormValidation = {
        init: function() {
            const forms = document.querySelectorAll('.needs-validation');

            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!form.checkValidity()) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                    form.classList.add('was-validated');
                });

                // Real-time validation feedback
                const inputs = form.querySelectorAll('input, textarea, select');
                inputs.forEach(input => {
                    input.addEventListener('blur', function() {
                        if (this.checkValidity()) {
                            this.classList.remove('is-invalid');
                            this.classList.add('is-valid');
                        } else {
                            this.classList.remove('is-valid');
                            this.classList.add('is-invalid');
                        }
                    });
                });
            });
        }
    };

    // ========================================
    // 13. TABS FUNCTIONALITY
    // ========================================
    const Tabs = {
        init: function() {
            const tabTriggers = document.querySelectorAll('[data-tab-target]');

            tabTriggers.forEach(trigger => {
                trigger.addEventListener('click', function() {
                    const targetId = this.dataset.tabTarget;
                    const tabContent = document.querySelector(targetId);

                    if (!tabContent) return;

                    // Remove active from all triggers and content
                    document.querySelectorAll('[data-tab-target]').forEach(t => {
                        t.classList.remove('active');
                    });
                    document.querySelectorAll('.tab-pane').forEach(p => {
                        p.classList.remove('active', 'show');
                    });

                    // Add active to clicked trigger and target content
                    this.classList.add('active');
                    tabContent.classList.add('active', 'show');
                });
            });
        }
    };

    // ========================================
    // 14. COPY TO CLIPBOARD
    // ========================================
    const Clipboard = {
        copy: function(text, successMessage = 'Berhasil disalin!') {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(() => {
                    Toast.success(successMessage);
                }).catch(() => {
                    this.fallbackCopy(text, successMessage);
                });
            } else {
                this.fallbackCopy(text, successMessage);
            }
        },

        fallbackCopy: function(text, successMessage) {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            document.body.appendChild(textArea);
            textArea.select();

            try {
                document.execCommand('copy');
                Toast.success(successMessage);
            } catch (err) {
                Toast.error('Gagal menyalin teks');
            }

            document.body.removeChild(textArea);
        }
    };

    // ========================================
    // 15. SHARE FUNCTIONALITY
    // ========================================
    const Share = {
        whatsapp: function(url, text) {
            const message = encodeURIComponent(`${text}\n\n${url}`);
            window.open(`https://wa.me/?text=${message}`, '_blank');
        },

        twitter: function(url, text) {
            const message = encodeURIComponent(text);
            window.open(`https://twitter.com/intent/tweet?text=${message}&url=${encodeURIComponent(url)}`, '_blank');
        },

        facebook: function(url) {
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`, '_blank');
        },

        telegram: function(url, text) {
            const message = encodeURIComponent(text);
            window.open(`https://t.me/share/url?url=${encodeURIComponent(url)}&text=${message}`, '_blank');
        },

        copyLink: function(url) {
            Clipboard.copy(url, 'Link berhasil disalin!');
        }
    };

    // ========================================
    // 16. LAZY LOADING IMAGES
    // ========================================
    const LazyLoad = {
        init: function() {
            if ('IntersectionObserver' in window) {
                const lazyImages = document.querySelectorAll('img[data-src]');

                const imageObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src;
                            img.removeAttribute('data-src');
                            img.classList.add('loaded');
                            imageObserver.unobserve(img);
                        }
                    });
                });

                lazyImages.forEach(img => {
                    imageObserver.observe(img);
                });
            } else {
                // Fallback for older browsers
                document.querySelectorAll('img[data-src]').forEach(img => {
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                });
            }
        }
    };

    // ========================================
    // 17. COUNTER ANIMATION
    // ========================================
    const CounterAnimation = {
        init: function() {
            const counters = document.querySelectorAll('.counter');

            if (!('IntersectionObserver' in window)) {
                counters.forEach(counter => {
                    counter.textContent = counter.dataset.target;
                });
                return;
            }

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const counter = entry.target;
                        const target = parseInt(counter.dataset.target);
                        const duration = parseInt(counter.dataset.duration) || 2000;

                        this.animateCounter(counter, target, duration);
                        observer.unobserve(counter);
                    }
                });
            }, { threshold: 0.5 });

            counters.forEach(counter => {
                observer.observe(counter);
            });
        },

        animateCounter: function(element, target, duration) {
            let start = 0;
            const increment = target / (duration / 16);

            const updateCounter = () => {
                start += increment;
                if (start < target) {
                    element.textContent = Math.floor(start);
                    requestAnimationFrame(updateCounter);
                } else {
                    element.textContent = target;
                }
            };

            updateCounter();
        }
    };

    // ========================================
    // 18. PERFORMANCE MONITORING
    // ========================================
    const Performance = {
        init: function() {
            window.addEventListener('load', function() {
                if (window.performance && window.performance.timing) {
                    const timing = window.performance.timing;
                    const loadTime = timing.loadEventEnd - timing.navigationStart;
                    console.log(`Page loaded in ${loadTime}ms`);
                }
            });
        }
    };

    // ========================================
    // 19. GLOBAL ERROR HANDLER
    // ========================================
    const ErrorHandler = {
        init: function() {
            window.addEventListener('error', function(e) {
                console.error('Global error:', e.error || e.message);
            });

            window.addEventListener('unhandledrejection', function(e) {
                console.error('Unhandled promise rejection:', e.reason);
            });
        }
    };

    // ========================================
    // 20. INITIALIZE ALL MODULES
    // ========================================
    function init() {
        // Core functionality
        Spinner.init();
        Animations.init();
        StickyNavbar.init();
        BackToTop.init();
        Carousels.init();

        // Enhancements
        ScrollAnimations.init();
        HoverEffects.init();
        SmoothScroll.init();
        ImageErrorHandler.init();
        FormValidation.init();
        Tabs.init();
        LazyLoad.init();
        CounterAnimation.init();

        // Monitoring
        Performance.init();
        ErrorHandler.init();

        console.log('LDK Syahid - All modules initialized');
    }

    // Run on DOM ready
    $(document).ready(function() {
        init();
    });

    // ========================================
    // 21. EXPOSE PUBLIC API
    // ========================================
    window.LDKSyahid = {
        Toast: Toast,
        Clipboard: Clipboard,
        Share: Share,
        Spinner: Spinner,

        // Utility functions
        showToast: function(message, type) {
            Toast.show(message, type);
        },

        copyToClipboard: function(text, message) {
            Clipboard.copy(text, message);
        },

        shareWhatsApp: function(url, text) {
            Share.whatsapp(url, text);
        },

        shareFacebook: function(url) {
            Share.facebook(url);
        },

        shareTwitter: function(url, text) {
            Share.twitter(url, text);
        },

        shareTelegram: function(url, text) {
            Share.telegram(url, text);
        },

        copyLink: function(url) {
            Share.copyLink(url);
        }
    };

})(jQuery);
