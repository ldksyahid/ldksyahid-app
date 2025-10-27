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
        }).catch(() => {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = bookLink;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            showSuccessMessage('Link buku berhasil disalin!');
        });
    };

    window.shareOnWhatsApp = function() {
        const bookLink = window.location.href;
        const bookTitle = '{{ $book->titleBook }}';
        const message = `📚 *{{ $book->titleBook }}* \n\nBaca buku "${bookTitle}" di: ${bookLink}`;
        const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(message)}`;

        window.open(whatsappUrl, '_blank');
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

    window.downloadBook = function() {
        showSuccessMessage('Memulai download buku...');
        // In real implementation, this would trigger the download
    };

    // Show success message
    function showSuccessMessage(message) {
        // Remove existing message
        const existingMessage = document.querySelector('.success-message');
        if (existingMessage) {
            existingMessage.remove();
        }

        // Create new message
        const successMessage = document.getElementById('success-message').cloneNode(true);
        successMessage.id = '';
        successMessage.style.display = 'flex';
        successMessage.querySelector('.message-text').textContent = message;
        document.body.appendChild(successMessage);

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
        // Add loading states to buttons
        initElegantButtonLoading();

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

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-tab');

                // Remove active class from all tabs and panes
                tabs.forEach(t => t.classList.remove('active'));
                panes.forEach(p => p.classList.remove('active'));

                // Add active class to clicked tab and corresponding pane
                this.classList.add('active');
                document.getElementById(`${targetTab}-tab`).classList.add('active');
            });
        });
    }

    function initElegantButtonLoading() {
        document.querySelectorAll('.btn-read, .btn-outline').forEach(button => {
            button.addEventListener('click', function(e) {
                if (!this.href || this.hasAttribute('target')) {
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                    this.disabled = true;

                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.disabled = false;
                    }, 2000);
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

        // Add hover effects to stat cards
        const statCards = document.querySelectorAll('.stat-card, .detail-item, .related-book-card');
        statCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });

            card.addEventListener('mouseleave', function() {
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
        document.querySelectorAll('.stat-card, .detail-item, .related-book-card, .author-profile').forEach(el => {
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

    // Update meta tags for social sharing
    function updateMetaTags() {
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
