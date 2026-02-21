<script>
document.addEventListener('DOMContentLoaded', function() {

    // ── IntersectionObserver for scroll animations ──
    var animElements = document.querySelectorAll('.news-header-animate, .news-card-animate');
    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });

        animElements.forEach(function(el) {
            observer.observe(el);
        });
    } else {
        // Fallback: show all immediately
        animElements.forEach(function(el) {
            el.classList.add('is-visible');
        });
    }

    // ── Owl Carousel for mobile ──
    var $newsCarousel = jQuery('.news-carousel');

    if ($newsCarousel.length) {
        $newsCarousel.owlCarousel({
            items: 1,
            margin: 14,
            stagePadding: 24,
            loop: false,
            dots: false,
            nav: false,
            autoplay: false,
            smartSpeed: 350,
            touchDrag: true,
            mouseDrag: true,
            autoWidth: false,
        });

        // Custom dots
        var $dotsContainer = jQuery('.news-carousel-dots');
        var itemCount = $newsCarousel.find('.owl-item:not(.cloned)').length;

        if (itemCount > 1 && $dotsContainer.length) {
            for (var i = 0; i < itemCount; i++) {
                var $dot = jQuery('<button class="news-dot" aria-label="Slide ' + (i + 1) + '"></button>');
                if (i === 0) $dot.addClass('active');
                $dot.data('index', i);
                $dotsContainer.append($dot);
            }

            $dotsContainer.on('click', '.news-dot', function() {
                $newsCarousel.trigger('to.owl.carousel', [jQuery(this).data('index'), 300]);
            });

            $newsCarousel.on('changed.owl.carousel', function(e) {
                var idx = e.item.index;
                $dotsContainer.find('.news-dot').removeClass('active');
                $dotsContainer.find('.news-dot').eq(idx).addClass('active');
            });
        }
    }

    // ── Bottom Sheet Logic ──
    var $overlay = jQuery('#newsSheetOverlay');
    var $sheet   = jQuery('#newsSheet');
    var $body    = jQuery('body');

    function openNewsSheet(data) {
        jQuery('#newsSheetImg').attr('src', data.img).attr('alt', data.title);
        jQuery('#newsSheetTitle').text(data.title);
        jQuery('#newsSheetReporter').text(data.reporter);
        jQuery('#newsSheetEditor').text(data.editor);
        jQuery('#newsSheetDate').text(data.date);
        jQuery('#newsSheetExcerpt').text(data.excerpt);
        jQuery('#newsSheetBtn').attr('href', data.url);

        $body.addClass('news-sheet-open');
        $overlay.addClass('active');

        setTimeout(function() {
            $sheet.addClass('active');
        }, 10);

        $sheet[0].scrollTop = 0;
    }

    function closeNewsSheet() {
        $sheet.removeClass('active');

        setTimeout(function() {
            $overlay.removeClass('active');
            $body.removeClass('news-sheet-open');

            if (jQuery(window).scrollTop() > 300) {
                jQuery('.back-to-top').stop(true).fadeIn(300);
            }
        }, 380);
    }

    // Click on mobile carousel card -> open sheet
    jQuery(document).on('click', '.news-card--mobile', function(e) {
        e.preventDefault();
        var $el = jQuery(this);
        openNewsSheet({
            title:    $el.data('news-title'),
            reporter: $el.data('news-reporter'),
            editor:   $el.data('news-editor'),
            date:     $el.data('news-date'),
            img:      $el.data('news-img'),
            excerpt:  $el.data('news-excerpt'),
            url:      $el.data('news-url')
        });
    });

    // Close sheet
    jQuery('#newsSheetClose').on('click', closeNewsSheet);
    $overlay.on('click', closeNewsSheet);

    // Close with Escape key
    jQuery(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $sheet.hasClass('active')) {
            closeNewsSheet();
        }
    });

    // Swipe down to close (touch)
    var touchStartY = 0;
    var touchCurrentY = 0;
    var sheetEl = $sheet[0];

    if (sheetEl) {
        sheetEl.addEventListener('touchstart', function(e) {
            if (this.scrollTop <= 0) {
                touchStartY = e.touches[0].clientY;
            } else {
                touchStartY = 0;
            }
        }, { passive: true });

        sheetEl.addEventListener('touchmove', function(e) {
            if (touchStartY === 0) return;
            touchCurrentY = e.touches[0].clientY;
            var diff = touchCurrentY - touchStartY;
            if (diff > 0 && this.scrollTop <= 0) {
                var translateVal = Math.min(diff * 0.6, 200);
                if (window.innerWidth >= 768) {
                    this.style.transform = 'translate(-50%, ' + translateVal + 'px)';
                } else {
                    this.style.transform = 'translateY(' + translateVal + 'px)';
                }
            }
        }, { passive: true });

        sheetEl.addEventListener('touchend', function() {
            var diff = touchCurrentY - touchStartY;
            if (diff > 80) {
                closeNewsSheet();
            }
            var self = this;
            setTimeout(function() {
                self.style.transform = '';
            }, 380);
            touchStartY = 0;
            touchCurrentY = 0;
        }, { passive: true });
    }
});
</script>
