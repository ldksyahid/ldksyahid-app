<script>
/* ================================================================
   IT SUPPORT PAGE — prefix: its-
   ================================================================ */
document.addEventListener('DOMContentLoaded', function () {

    /* ─── HTML escape helper ─────────────────────────────────── */
    function escHtml(str) {
        if (str == null) return '';
        return String(str)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;')
            .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    /* ─── Scroll lock / unlock ────────────────────────────────── */
    var _scrollY = 0;
    function lockScroll() {
        _scrollY = window.scrollY;
        document.body.classList.add('its-sheet-open');
    }
    function unlockScroll() {
        document.body.classList.remove('its-sheet-open');
        window.scrollTo({ top: _scrollY, left: 0, behavior: 'instant' });
    }

    /* ─── Bottom Sheet elements ──────────────────────────────── */
    var sheet    = document.getElementById('its-bottom-sheet');
    var backdrop = document.getElementById('its-bs-backdrop');
    var closeBtn = document.getElementById('its-bs-close');
    var content  = document.getElementById('its-bs-content');

    if (!sheet) return;

    /* ─── Touch block (prevent body scroll through sheet) ────── */
    var _touchBlock = null;
    function openSheet() {
        if (backdrop) backdrop.classList.add('active');
        sheet.classList.add('open');
        lockScroll();
        _touchBlock = function (e) {
            if (!e.target.closest('#its-bottom-sheet')) e.preventDefault();
        };
        window.addEventListener('touchmove', _touchBlock, { passive: false, capture: true });
    }
    function closeSheet() {
        sheet.classList.remove('open');
        if (backdrop) backdrop.classList.remove('active');
        unlockScroll();
        if (_touchBlock) {
            window.removeEventListener('touchmove', _touchBlock, { capture: true });
            _touchBlock = null;
        }
    }

    if (closeBtn)  closeBtn.addEventListener('click', closeSheet);
    if (backdrop)  backdrop.addEventListener('click', closeSheet);
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && sheet.classList.contains('open')) closeSheet();
    });

    /* ─── Open sheet from mobile card ────────────────────────── */
    window.itsOpenSheet = function (card) {
        if (!content) return;

        var name      = card.dataset.name      || '';
        var position  = card.dataset.position  || '';
        var forkat    = card.dataset.forkat    || '';
        var photo     = card.dataset.photo     || '';
        var instagram = card.dataset.instagram || '';
        var linkedin  = card.dataset.linkedin  || '';
        var accent    = card.dataset.accent    || '#00a79d';

        /* Gradient header */
        var hdrHtml =
            '<div class="its-bs-hdr" style="--its-bs-accent:' + escHtml(accent) + '">' +
                '<div class="its-bs-drag-handle"></div>' +
            '</div>';

        /* Circular photo */
        var photoHtml = photo
            ? '<div class="its-bs-photo-band">' +
                  '<div class="its-bs-photo-ring">' +
                      '<img src="' + escHtml(photo) + '" class="its-bs-photo" alt="' + escHtml(name) + '" loading="lazy">' +
                  '</div>' +
              '</div>'
            : '<div style="height:1rem"></div>';

        /* Social links */
        var igBtn = instagram
            ? '<a href="' + escHtml(instagram) + '" target="_blank" rel="noopener noreferrer"' +
                  ' class="its-bs-social-btn its-bs-social-btn--ig">' +
                  '<i class="fab fa-instagram"></i> Instagram' +
              '</a>'
            : '';
        var liBtn = linkedin
            ? '<a href="' + escHtml(linkedin) + '" target="_blank" rel="noopener noreferrer"' +
                  ' class="its-bs-social-btn its-bs-social-btn--li">' +
                  '<i class="fab fa-linkedin-in"></i> LinkedIn' +
              '</a>'
            : '';

        content.innerHTML =
            hdrHtml +
            photoHtml +
            '<div class="its-bs-info">' +
                '<span class="its-position-badge" style="--its-accent:' + escHtml(accent) + ';position:static">' +
                    escHtml(position) +
                '</span>' +
                '<h3 class="its-bs-name">' + escHtml(name) + '</h3>' +
                (forkat
                    ? '<div class="its-bs-forkat">' +
                          '<span class="its-bullet" style="--its-accent:' + escHtml(accent) + '"></span>' +
                          '<span>' + escHtml(forkat) + '</span>' +
                      '</div>'
                    : '') +
                (igBtn || liBtn
                    ? '<div class="its-bs-social">' + igBtn + liBtn + '</div>'
                    : '') +
            '</div>';

        sheet.scrollTop = 0;
        openSheet();
    };

    /* ─── Carousel dots (IntersectionObserver) ───────────────── */
    function initCarouselDots() {
        var carousel = document.getElementById('its-mobile-carousel');
        var dotsWrap = document.getElementById('its-carousel-dots');
        if (!carousel || !dotsWrap) return;

        var cards = carousel.querySelectorAll('.its-mobile-card');
        dotsWrap.innerHTML = '';
        if (cards.length <= 1) { dotsWrap.style.display = 'none'; return; }
        dotsWrap.style.display = 'flex';

        var dots = [];
        cards.forEach(function (card, i) {
            var dot = document.createElement('span');
            dot.className = 'its-dot' + (i === 0 ? ' active' : '');
            dot.setAttribute('aria-label', 'Slide ' + (i + 1));
            dot.addEventListener('click', function () {
                card.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            });
            dotsWrap.appendChild(dot);
            dots.push(dot);
        });

        var obs = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                var idx = Array.from(cards).indexOf(entry.target);
                dots.forEach(function (d, i) { d.classList.toggle('active', i === idx); });
            });
        }, { root: carousel, threshold: 0.55 });

        cards.forEach(function (c) { obs.observe(c); });
    }

    initCarouselDots();
});
</script>
