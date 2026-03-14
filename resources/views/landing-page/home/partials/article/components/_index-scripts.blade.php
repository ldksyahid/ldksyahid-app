<script>
document.addEventListener('DOMContentLoaded', function() {
    // ── Owl Carousel for mobile ──
    var $artCarousel = jQuery('.art-carousel');

    if ($artCarousel.length) {
        $artCarousel.owlCarousel({
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
        var $dotsContainer = jQuery('.art-carousel-dots');
        var itemCount = $artCarousel.find('.owl-item:not(.cloned)').length;

        if (itemCount > 1 && $dotsContainer.length) {
            for (var i = 0; i < itemCount; i++) {
                var $dot = jQuery('<button class="art-dot" aria-label="Slide ' + (i + 1) + '"></button>');
                if (i === 0) $dot.addClass('active');
                $dot.data('index', i);
                $dotsContainer.append($dot);
            }

            $dotsContainer.on('click', '.art-dot', function() {
                $artCarousel.trigger('to.owl.carousel', [jQuery(this).data('index'), 300]);
            });

            $artCarousel.on('changed.owl.carousel', function(e) {
                var idx = e.item.index;
                $dotsContainer.find('.art-dot').removeClass('active');
                $dotsContainer.find('.art-dot').eq(idx).addClass('active');
            });
        }
    }

    // ── Bottom Sheet Logic ──
    var $overlay = jQuery('#artSheetOverlay');
    var $sheet   = jQuery('#artSheet');
    var $body    = jQuery('body');

    function openSheet(data) {
        jQuery('#artSheetImg').attr('src', data.img).attr('alt', data.title);
        jQuery('#artSheetTheme').text(data.theme).css({
            '--theme-color': data.accent || 'var(--primary)',
            'background': 'color-mix(in srgb, ' + (data.accent || '#00a79d') + ' 12%, transparent)',
            'color': data.accent || 'var(--primary)'
        });
        jQuery('#artSheetTitle').text(data.title);
        jQuery('#artSheetWriter').text(data.writer);
        if (data.editor) {
            jQuery('#artSheetEditor').text(data.editor);
            jQuery('#artSheetEditorRow').show();
        } else {
            jQuery('#artSheetEditorRow').hide();
        }
        jQuery('#artSheetDate').text(data.date);
        jQuery('#artSheetBtn').attr('href', data.url);

        $body.addClass('art-sheet-open');
        $overlay.addClass('active');

        setTimeout(function() {
            $sheet.addClass('active');
        }, 10);

        $sheet[0].scrollTop = 0;
    }

    function closeSheet() {
        $sheet.removeClass('active');

        setTimeout(function() {
            $overlay.removeClass('active');
            $body.removeClass('art-sheet-open');

            if (jQuery(window).scrollTop() > 300) {
                jQuery('.back-to-top').stop(true).fadeIn(300);
            }
        }, 380);
    }

    // Click on mobile carousel card → open sheet
    jQuery(document).on('click', '.art-card--mobile', function(e) {
        e.preventDefault();
        var $el = jQuery(this);
        openSheet({
            title:  $el.data('article-title'),
            theme:  $el.data('article-theme'),
            writer: $el.data('article-writer'),
            editor: $el.data('article-editor'),
            date:   $el.data('article-date'),
            img:    $el.data('article-img'),
            url:    $el.data('article-url'),
            accent: $el.data('article-accent')
        });
    });

    // Close sheet
    jQuery('#artSheetClose').on('click', closeSheet);
    $overlay.on('click', closeSheet);

    // Close with Escape key
    jQuery(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $sheet.hasClass('active')) {
            closeSheet();
        }
    });

    // Swipe down to close (touch)
    var touchStartY = 0;
    var touchCurrentY = 0;
    var sheetEl = $sheet[0];

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
            closeSheet();
        }
        var self = this;
        setTimeout(function() {
            self.style.transform = '';
        }, 380);
        touchStartY = 0;
        touchCurrentY = 0;
    }, { passive: true });
});
</script>
