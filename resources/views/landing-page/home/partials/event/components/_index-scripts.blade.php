<script>
document.addEventListener('DOMContentLoaded', function() {
    // Viewport animations
    var animEls = document.querySelectorAll('.event-header-wrap, .event-card-animate');
    if ('IntersectionObserver' in window) {
        var obs = new IntersectionObserver(function(entries) {
            entries.forEach(function(e) {
                if (e.isIntersecting) {
                    e.target.classList.add('is-visible');
                    obs.unobserve(e.target);
                }
            });
        }, { threshold: 0.15 });
        animEls.forEach(function(el) { obs.observe(el); });
    } else {
        animEls.forEach(function(el) { el.classList.add('is-visible'); });
    }

    // Carousel
    var $carousel = jQuery('.event-carousel');
    if ($carousel.length) {
        $carousel.owlCarousel({
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
        });

        var $dots = jQuery('.event-carousel-dots');
        var count = $carousel.find('.owl-item:not(.cloned)').length;
        if (count > 1 && $dots.length) {
            for (var i = 0; i < count; i++) {
                var $d = jQuery('<button class="event-dot" aria-label="Slide ' + (i + 1) + '"></button>');
                if (i === 0) $d.addClass('active');
                $d.data('index', i);
                $dots.append($d);
            }
            $dots.on('click', '.event-dot', function() {
                $carousel.trigger('to.owl.carousel', [jQuery(this).data('index'), 300]);
            });
            $carousel.on('changed.owl.carousel', function(e) {
                $dots.find('.event-dot').removeClass('active').eq(e.item.index).addClass('active');
            });
        }
    }

    // Bottom Sheet
    var $overlay = jQuery('#eventSheetOverlay');
    var $sheet = jQuery('#eventSheet');
    var $body = jQuery('body');

    function openSheet(d) {
        jQuery('#eventSheetImg').attr('src', d.img).attr('alt', d.title);
        jQuery('#eventSheetDay').text(d.day);
        jQuery('#eventSheetMonth').text(d.month);
        jQuery('#eventSheetBadgeText').text(d.division);
        jQuery('#eventSheetTitle').text(d.title);
        jQuery('#eventSheetDateFull').text(d.date);
        jQuery('#eventSheetDesc').text(d.desc);
        jQuery('#eventSheetBtn').attr('href', d.url);

        // Apply dynamic color
        jQuery('.event-sheet__date').css('background', d.color);
        jQuery('.event-sheet__badge').css({
            'background': d.color + '20',
            'color': d.color
        });
        jQuery('.event-sheet__meta i').css('color', d.color);

        $body.addClass('event-sheet-open');
        $overlay.addClass('active');
        setTimeout(function() { $sheet.addClass('active'); }, 10);
        $sheet[0].scrollTop = 0;
    }

    function closeSheet() {
        $sheet.removeClass('active');
        setTimeout(function() {
            $overlay.removeClass('active');
            $body.removeClass('event-sheet-open');
            if (jQuery(window).scrollTop() > 300) {
                jQuery('.back-to-top').stop(true).fadeIn(300);
            }
        }, 380);
    }

    jQuery(document).on('click', '.event-card-mobile', function(e) {
        e.preventDefault();
        var $el = jQuery(this);
        openSheet({
            title: $el.data('event-title'),
            division: $el.data('event-division'),
            date: $el.data('event-date'),
            day: $el.data('event-day'),
            month: $el.data('event-month'),
            img: $el.data('event-img'),
            desc: $el.data('event-desc'),
            url: $el.data('event-url'),
            color: $el.data('event-color')
        });
    });

    jQuery('#eventSheetClose').on('click', closeSheet);
    $overlay.on('click', closeSheet);
    jQuery(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $sheet.hasClass('active')) closeSheet();
    });

    // Swipe down
    var startY = 0, currentY = 0, el = $sheet[0];
    if (el) {
        el.addEventListener('touchstart', function(e) {
            startY = this.scrollTop <= 0 ? e.touches[0].clientY : 0;
        }, { passive: true });
        el.addEventListener('touchmove', function(e) {
            if (!startY) return;
            currentY = e.touches[0].clientY;
            var diff = currentY - startY;
            if (diff > 0 && this.scrollTop <= 0) {
                var val = Math.min(diff * 0.6, 200);
                this.style.transform = window.innerWidth >= 768 ?
                    'translate(-50%, ' + val + 'px)' : 'translateY(' + val + 'px)';
            }
        }, { passive: true });
        el.addEventListener('touchend', function() {
            if (currentY - startY > 80) closeSheet();
            var self = this;
            setTimeout(function() { self.style.transform = ''; }, 380);
            startY = 0;
            currentY = 0;
        }, { passive: true });
    }
});
</script>
