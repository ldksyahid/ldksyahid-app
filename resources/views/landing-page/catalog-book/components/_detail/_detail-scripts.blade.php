<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize elegant book detail page
    initElegantBookDetail();

    // Tab functionality
    initElegantTabs();

    // Share functionality
    window.copyBookLink = function() {
        const bookLink = window.location.href;

        navigator.clipboard.writeText(bookLink).then(() => {
            showSuccessMessage('Link buku berhasil disalin!');
            closeShareOptions();
        }).catch(() => {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = bookLink;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            showSuccessMessage('Link buku berhasil disalin!');
            closeShareOptions();
        });
    };

    window.shareOnWhatsApp = function() {
        const bookLink = window.location.href;
        const bookTitle = '{{ $book->titleBook }}';
        const message = `📚 *{{ $book->titleBook }}* \n\nBaca buku "${bookTitle}" di: ${bookLink}`;
        const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(message)}`;

        window.open(whatsappUrl, '_blank');
        closeShareOptions();
    };

    window.openPdfReader = function() {
        const pdfUrl = '{{ $book->pdfFileUrl() }}';
        if (pdfUrl) {
            window.open(pdfUrl, '_blank');
        } else {
            showSuccessMessage('Buku tidak tersedia untuk dibaca online.');
        }
    };

    window.addToFavorites = function() {
        showSuccessMessage('Buku telah ditambahkan ke favorit!');
        // In real implementation, this would be an API call
    };

    // Share Options functionality
    window.toggleShareOptions = function() {
        const shareOptions = document.getElementById('shareOptions');
        shareOptions.classList.toggle('show');
    }

    function closeShareOptions() {
        const shareOptions = document.getElementById('shareOptions');
        shareOptions.classList.remove('show');
    }

    // Close share options when clicking outside
    document.addEventListener('click', function(event) {
        const shareOptions = document.getElementById('shareOptions');
        const shareButton = document.querySelector('.btn-share');

        if (!shareButton.contains(event.target) && !shareOptions.contains(event.target)) {
            closeShareOptions();
        }
    });

    // Show success message
    function showSuccessMessage(message) {
        // Remove existing message
        const existingMessage = document.querySelector('.success-message');
        if (existingMessage) {
            existingMessage.remove();
        }

        // Create new message element directly
        const successMessage = document.createElement('div');
        successMessage.className = 'success-message';
        successMessage.innerHTML = `
            <i class="fas fa-check-circle me-2"></i>
            <span class="message-text">${message}</span>
        `;

        // Add styles if not already in CSS
        successMessage.style.cssText = `
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 1rem 2rem;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(40, 167, 69, 0.4);
            z-index: 9999;
            animation: slideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        `;

        document.body.appendChild(successMessage);

        // Add keyframes for animation if not in CSS
        if (!document.querySelector('#success-message-animations')) {
            const style = document.createElement('style');
            style.id = 'success-message-animations';
            style.textContent = `
                @keyframes slideUp {
                    from {
                        transform: translateX(-50%) translateY(100%);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(-50%) translateY(0);
                        opacity: 1;
                    }
                }
                @keyframes slideDown {
                    from {
                        transform: translateX(-50%) translateY(0);
                        opacity: 1;
                    }
                    to {
                        transform: translateX(-50%) translateY(100%);
                        opacity: 0;
                    }
                }
                .success-message.fade-out {
                    animation: slideDown 0.3s ease forwards;
                }
            `;
            document.head.appendChild(style);
        }

        // Remove message after 3 seconds with fade out effect
        setTimeout(() => {
            successMessage.classList.add('fade-out');
            setTimeout(() => {
                if (successMessage.parentNode) {
                    successMessage.remove();
                }
            }, 300);
        }, 2700);
    }

    function initElegantBookDetail() {
        // Add hover effects
        initElegantHoverEffects();

        // Initialize animations
        initElegantAnimations();

        // Add image error handling
        initImageErrorHandling();
    }

    function initElegantTabs() {
        const tabs = document.querySelectorAll('.nav-tab');
        const panes = document.querySelectorAll('.tab-pane');

        // Set initial active state - DETAILS tab first
        if (tabs.length > 0 && panes.length > 0) {
            tabs[0].classList.add('active');
            panes[0].classList.add('active');
        }

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-tab');

                // Remove active class from all tabs and panes
                tabs.forEach(t => t.classList.remove('active'));
                panes.forEach(p => p.classList.remove('active'));

                // Add active class to clicked tab and corresponding pane
                this.classList.add('active');
                const targetPane = document.getElementById(`${targetTab}-tab`);
                if (targetPane) {
                    targetPane.classList.add('active');
                }
            });
        });
    }

    function initElegantHoverEffects() {
        // Add parallax effect to book cover
        const coverContainer = document.querySelector('.cover-container');
        if (coverContainer) {
            coverContainer.addEventListener('mousemove', (e) => {
                const xAxis = (window.innerWidth / 2 - e.pageX) / 25;
                const yAxis = (window.innerHeight / 2 - e.pageY) / 25;
                coverContainer.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
            });

            coverContainer.addEventListener('mouseenter', () => {
                coverContainer.style.transition = 'none';
            });

            coverContainer.addEventListener('mouseleave', () => {
                coverContainer.style.transition = 'all 0.5s ease';
                coverContainer.style.transform = 'rotateY(0deg) rotateX(0deg)';
            });
        }

        // Add hover effects to detail items
        const detailItems = document.querySelectorAll('.detail-item, .related-book-card');
        detailItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });

            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    }

    function initElegantAnimations() {
        // Add scroll-triggered animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe elements for scroll animations
        document.querySelectorAll('.detail-item, .related-book-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    }

    function initImageErrorHandling() {
        document.querySelectorAll('.cover-image, .book-cover-small img').forEach(img => {
            img.addEventListener('error', function() {
                this.src = 'https://lh3.googleusercontent.com/d/11uThObxFLEhUURq0ggI5ncJDdlPYkKyd';
                this.alt = 'Gambar tidak tersedia';
                this.classList.add('img-error');
            });
        });
    }

    // Social media sharing
    window.shareOnFacebook = function() {
        const bookLink = encodeURIComponent(window.location.href);
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${bookLink}`, '_blank');
    };

    window.shareOnTwitter = function() {
        const bookLink = encodeURIComponent(window.location.href);
        const bookTitle = encodeURIComponent('{{ $book->titleBook }}');
        window.open(`https://twitter.com/intent/tweet?text=${bookTitle}&url=${bookLink}`, '_blank');
    };

    // Error handling for all functions
    function safeFunctionCall(fn, fallbackMessage = 'Terjadi kesalahan. Silakan coba lagi.') {
        try {
            return fn();
        } catch (error) {
            console.error('Error:', error);
            showSuccessMessage(fallbackMessage);
            return null;
        }
    }

    // Wrap all window functions with error handling
    const originalFunctions = {
        copyBookLink: window.copyBookLink,
        shareOnWhatsApp: window.shareOnWhatsApp,
        openPdfReader: window.openPdfReader,
        addToFavorites: window.addToFavorites,
        shareOnFacebook: window.shareOnFacebook,
        shareOnTwitter: window.shareOnTwitter,
        toggleShareOptions: window.toggleShareOptions
    };

    // Replace with safe versions
    Object.keys(originalFunctions).forEach(funcName => {
        window[funcName] = function(...args) {
            return safeFunctionCall(() => originalFunctions[funcName].apply(this, args));
        };
    });

    // Update meta tags for social sharing
    function updateMetaTags() {
        try {
            const metaTitle = document.querySelector('title');
            if (metaTitle) {
                metaTitle.textContent = '{{ $book->titleBook }} - Perpustakaan Digital';
            }

            // Update Open Graph tags
            const ogTitle = document.querySelector('meta[property="og:title"]');
            if (ogTitle) {
                ogTitle.setAttribute('content', '{{ $book->titleBook }}');
            }

            const ogDescription = document.querySelector('meta[property="og:description"]');
            if (ogDescription) {
                ogDescription.setAttribute('content', '{{ Str::limit($book->description, 150) }}');
            }

            const ogImage = document.querySelector('meta[property="og:image"]');
            if (ogImage && '{{ $book->coverImageUrl() }}') {
                ogImage.setAttribute('content', '{{ $book->coverImageUrl() }}');
            }
        } catch (error) {
            console.error('Error updating meta tags:', error);
        }
    }

    // Initialize meta tags
    updateMetaTags();

    // Track book view
    function trackBookView() {
        console.log('Book viewed:', '{{ $book->titleBook }}');
    }

    // Track initial view
    trackBookView();
});

// Performance monitoring
window.addEventListener('load', function() {
    if (window.performance) {
        const perfData = window.performance.timing;
        const loadTime = perfData.loadEventEnd - perfData.navigationStart;
        console.log(`Elegant book detail page loaded in ${loadTime}ms`);
    }
});

// Global error handler
window.addEventListener('error', function(e) {
    console.error('Global error:', e.error);
});

// Service Worker registration for PWA features (optional)
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js').then(function(registration) {
            console.log('ServiceWorker registration successful');
        }, function(err) {
            console.log('ServiceWorker registration failed: ', err);
        });
    });
}
</script>
