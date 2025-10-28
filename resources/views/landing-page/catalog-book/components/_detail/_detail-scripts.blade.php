<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize elegant book detail page
    initElegantBookDetail();

    // Tab functionality
    initElegantTabs();

    // Initialize Disqus
    initDisqusComments();

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
    let shareOptionsVisible = false;

    window.toggleShareOptions = function() {
        const shareOptions = document.getElementById('shareOptions');

        if (shareOptionsVisible) {
            closeShareOptions();
        } else {
            openShareOptions();
        }
    }

    function openShareOptions() {
        const shareOptions = document.getElementById('shareOptions');
        shareOptions.classList.add('show');
        shareOptionsVisible = true;

        // Create overlay if it doesn't exist
        let overlay = document.querySelector('.share-overlay');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.className = 'share-overlay';
            document.body.appendChild(overlay);

            // Add styles for overlay
            overlay.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1040;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            `;
        }

        overlay.classList.add('show');

        // Close on overlay click
        overlay.onclick = closeShareOptions;
    }

    function closeShareOptions() {
        const shareOptions = document.getElementById('shareOptions');
        shareOptions.classList.remove('show');
        shareOptionsVisible = false;

        const overlay = document.querySelector('.share-overlay');
        if (overlay) {
            overlay.classList.remove('show');
        }
    }

    // Close share options when clicking outside or pressing ESC
    document.addEventListener('click', function(event) {
        const shareOptions = document.getElementById('shareOptions');
        const shareButton = document.querySelector('.btn-share');

        if (shareOptionsVisible &&
            !shareButton.contains(event.target) &&
            !shareOptions.contains(event.target)) {
            closeShareOptions();
        }
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && shareOptionsVisible) {
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

        // Create new message element
        const successMessage = document.createElement('div');
        successMessage.className = 'success-message';
        successMessage.innerHTML = `
            <i class="fas fa-check-circle me-2"></i>
            <span class="message-text">${message}</span>
        `;

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

                // If comments tab is activated, initialize Disqus
                if (targetTab === 'comments') {
                    setTimeout(() => {
                        initDisqusComments();
                    }, 300);
                }
            });
        });
    }

    function initDisqusComments() {
        // Check if Disqus is already loaded
        if (window.DISQUS) {
            return;
        }

        // Disqus configuration
        var disqus_config = function () {
            this.page.url = '{{ url()->current() }}';
            this.page.identifier = 'book-{{ $book->id }}';
            this.page.title = '{{ $book->titleBook }} - Diskusi Buku';
        };

        // Load Disqus script
        (function() {
            var d = document, s = d.createElement('script');
            s.src = 'https://https-ldksyah-id-1.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();

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
        toggleShareOptions: window.toggleShareOptions
    };

    // Replace with safe versions
    Object.keys(originalFunctions).forEach(funcName => {
        window[funcName] = function(...args) {
            return safeFunctionCall(() => originalFunctions[funcName].apply(this, args));
        };
    });

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

</script>

<!-- Disqus Fallback for No JavaScript -->
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
