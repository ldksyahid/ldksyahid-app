<script>
document.addEventListener('DOMContentLoaded', function() {
    // Viewport animations
    var animEls = document.querySelectorAll('.testimony-sidebar, .stat-card-animate, .testimony-card-animate');
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

    // Mobile Carousel with Dots / Counter
    if (typeof jQuery !== 'undefined' && jQuery('.testimony-carousel').length) {
        var $carousel = jQuery('.testimony-carousel');
        var $dots = jQuery('.testimony-carousel-dot');
        var $slideNum = jQuery('#testiSlideNum');
        var hasCounter = $slideNum.length > 0;

        if ($carousel.data('owl.carousel')) {
            $carousel.owlCarousel('destroy');
        }

        $carousel.owlCarousel({
            items: 1,
            margin: 16,
            stagePadding: 40,
            loop: false,
            dots: false,
            nav: false,
            autoplay: false,
            smartSpeed: 400,
            touchDrag: true,
            mouseDrag: true,
            onChanged: function(event) {
                var currentIndex = event.item.index - event.relatedTarget._clones.length / 2;
                var totalItems = event.item.count;
                if (currentIndex < 0) currentIndex = totalItems + currentIndex;
                else if (currentIndex >= totalItems) currentIndex = currentIndex - totalItems;

                if (hasCounter) {
                    $slideNum.text(currentIndex + 1);
                } else {
                    $dots.removeClass('active');
                    $dots.eq(currentIndex).addClass('active');
                }
            },
            responsive: {
                0: { items: 1, stagePadding: 30, margin: 12 },
                576: { items: 1, stagePadding: 50, margin: 16 }
            }
        });

        // Custom dots click handler (only when dots exist)
        if (!hasCounter) {
            $dots.on('click', function() {
                var index = jQuery(this).data('slide');
                $carousel.trigger('to.owl.carousel', [index, 400]);
            });
        }
    }

    // Desktop Load More
    (function() {
        var PAGE_SIZE = 6;
        var grid = document.getElementById('testimonyGrid');
        var btn  = document.getElementById('testiLoadMoreBtn');
        var wrap = document.getElementById('testiLoadMoreWrap');
        var countEl = wrap ? wrap.querySelector('.testi-lm-count') : null;
        if (!grid || !btn) return;

        var hiddenCards = Array.prototype.slice.call(
            grid.querySelectorAll('.testimony-card[data-testi-idx]')
        ).filter(function(card) {
            return parseInt(card.dataset.testiIdx, 10) >= 6;
        });

        // Hide cards beyond index 5 on load
        hiddenCards.forEach(function(card) { card.style.display = 'none'; });

        var shownCount = 0;

        btn.addEventListener('click', function() {
            var batch = hiddenCards.slice(shownCount, shownCount + PAGE_SIZE);

            // Reveal batch with staggered animation
            batch.forEach(function(card, i) {
                card.style.display = '';
                card.style.setProperty('--anim-delay', (i * 0.07) + 's');
                void card.offsetWidth; // reflow
                card.classList.add('testi-card-reveal');
                card.addEventListener('animationend', function handler() {
                    card.classList.remove('testi-card-reveal');
                    card.removeEventListener('animationend', handler);
                });
            });

            shownCount += batch.length;
            var remaining = hiddenCards.length - shownCount;

            if (remaining <= 0) {
                // No more cards — hide button
                if (wrap) {
                    wrap.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
                    wrap.style.opacity = '0';
                    wrap.style.transform = 'translateY(6px)';
                    setTimeout(function() { wrap.style.display = 'none'; }, 260);
                }
            } else {
                // Update count label
                if (countEl) {
                    countEl.textContent = '+' + remaining + ' testimoni';
                }
            }
        });
    }());

    // Bottom Sheet
    var $overlay = jQuery('#testimonySheetOverlay');
    var $sheet = jQuery('#testimonySheet');
    var $body = jQuery('body');
    var $backToTop = jQuery('.back-to-top');

    function openSheet(data) {
        jQuery('#testimonySheetAvatar').attr('src', data.img).attr('alt', data.name);
        jQuery('#testimonySheetName').text(data.name);
        jQuery('#testimonySheetRole').text(data.role);
        jQuery('#testimonySheetText').text('"' + data.text + '"');

        $body.addClass('testimony-sheet-open');
        $overlay.addClass('active');

        // Hide back-to-top button smoothly
        if ($backToTop.length) {
            $backToTop.addClass('hide-for-overlay');
        }

        setTimeout(function() {
            $sheet.addClass('active');
        }, 50);

        if ($sheet[0]) {
            $sheet[0].scrollTop = 0;
        }
    }

    function closeSheet() {
        $sheet.removeClass('active');
        setTimeout(function() {
            $overlay.removeClass('active');
            $body.removeClass('testimony-sheet-open');

            // Show back-to-top button smoothly
            if ($backToTop.length) {
                $backToTop.removeClass('hide-for-overlay');
            }
        }, 400);
    }

    // Handle button clicks
    jQuery(document).on('click', '.testimony-card-mobile__btn', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var $btn = jQuery(this);
        openSheet({
            name: $btn.data('name'),
            role: $btn.data('role'),
            img: $btn.data('img'),
            text: $btn.data('text')
        });
    });

    // Close handlers
    jQuery('#testimonySheetClose').on('click', closeSheet);
    $overlay.on('click', closeSheet);

    jQuery(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $sheet.hasClass('active')) {
            closeSheet();
        }
    });

    // Swipe down to close
    var startY = 0, currentY = 0;
    var el = $sheet[0];
    if (el) {
        el.addEventListener('touchstart', function(e) {
            if (this.scrollTop <= 0) {
                startY = e.touches[0].clientY;
            }
        }, { passive: true });

        el.addEventListener('touchmove', function(e) {
            if (!startY) return;
            currentY = e.touches[0].clientY;
            var diff = currentY - startY;

            if (diff > 0 && this.scrollTop <= 0) {
                e.preventDefault();
                var val = Math.min(diff * 0.6, 200);
                this.style.transform = 'translateY(' + val + 'px)';
            }
        }, { passive: false });

        el.addEventListener('touchend', function() {
            if (currentY - startY > 80) {
                closeSheet();
            }
            this.style.transform = '';
            startY = 0;
            currentY = 0;
        }, { passive: true });
    }
});
</script>
