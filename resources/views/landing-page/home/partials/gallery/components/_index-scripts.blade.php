{{-- GLightbox JS --}}
<script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ═══════════════════════════════════════════════
    // VIEWPORT ANIMATIONS
    // ═══════════════════════════════════════════════
    const animEls = document.querySelectorAll('.gallery-header-wrap, .gallery-item-elegant');

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.15
        });

        animEls.forEach(function(el) {
            observer.observe(el);
        });
    } else {
        animEls.forEach(function(el) {
            el.classList.add('is-visible');
        });
    }

    // ═══════════════════════════════════════════════
    // GLIGHTBOX - Soft & Fun Image Viewer
    // ═══════════════════════════════════════════════
    // ═══════════════════════════════════════════════
    // Enhanced GLightbox for Video Only
    // ═══════════════════════════════════════════════
    const lightbox = GLightbox({
        selector: '.glightbox-gal',
        touchNavigation: true,
        loop: false,
        autoplayVideos: true,
        skin: 'clean',
        closeButton: true,
        openEffect: 'zoom',
        closeEffect: 'zoom',
        slideEffect: 'fade',
        moreLength: 0,
        plyr: {
            css: 'https://cdn.plyr.io/3.7.8/plyr.css',
            js: 'https://cdn.plyr.io/3.7.8/plyr.js',
            config: {
                ratio: '16:9',
                autoplay: true,
                muted: false,
                volume: 0.8,
                controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'settings', 'pip', 'fullscreen'],
                fullscreen: { enabled: true, fallback: true, iosNative: false },
                quality: { default: 1080, options: [4320, 2880, 2160, 1440, 1080, 720, 576, 480, 360, 240] }
            }
        }
    });

});
</script>
