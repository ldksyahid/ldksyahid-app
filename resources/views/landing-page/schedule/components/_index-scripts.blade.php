{{-- ── Hero Jumbotron shared scripts ── --}}
@include('components.hero-jumbotron.scripts')

<script>
(function () {
    'use strict';

    /* ─── Back-to-top reference (global element) ─── */
    var btt = document.querySelector('.back-to-top');

    function hideBtt() {
        if (btt) btt.style.cssText =
            'opacity:0!important;pointer-events:none!important;' +
            'transform:scale(0.7) translateY(10px)!important;' +
            'transition:opacity .3s ease,transform .3s ease!important;';
    }
    function showBtt() {
        if (btt) btt.style.cssText = '';
    }

    /* ─── 1. DESKTOP EXPAND / COLLAPSE ─── */
    document.querySelectorAll('.sch-card-header').forEach(function (header) {
        header.addEventListener('click', schToggle);
        header.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                schToggle.call(this);
            }
        });
    });

    function schToggle() {
        var bodyId = this.getAttribute('data-target');
        var body   = document.getElementById(bodyId);
        if (!body) return;

        var isOpen = this.getAttribute('aria-expanded') === 'true';
        var label  = this.querySelector('.sch-toggle-label');

        if (isOpen) {
            this.setAttribute('aria-expanded', 'false');
            body.classList.remove('is-open');
            if (label) label.textContent = 'Lihat Jadwal';
        } else {
            this.setAttribute('aria-expanded', 'true');
            body.classList.add('is-open');
            if (label) label.textContent = 'Sembunyikan';
        }
    }

    /* ─── 2. MOBILE OWL CAROUSEL + CUSTOM DOTS ─── */
    $(document).ready(function () {
        var $c = $('#schCarousel');
        if (!$c.length || window.innerWidth >= 768) return;

        $c.owlCarousel({
            items       : 1,
            loop        : false,
            margin      : 14,
            stagePadding: 24,
            dots        : false,
            nav         : false,
            smartSpeed  : 380,
            autoplay    : false,
            touchDrag   : true,
            mouseDrag   : true
        });

        /* Build custom dots */
        var total = $c.find('.owl-item:not(.cloned)').length;
        var $dots = $('#schMobDots');

        for (var i = 0; i < total; i++) {
            $dots.append(
                '<button class="sch-mob-dot' + (i === 0 ? ' active' : '') +
                '" data-idx="' + i + '" aria-label="Jadwal ' + (i + 1) + '"></button>'
            );
        }

        function syncDots(idx) {
            $dots.find('.sch-mob-dot').removeClass('active');
            $dots.find('[data-idx="' + idx + '"]').addClass('active');
        }

        /* Dot click */
        $dots.on('click', '.sch-mob-dot', function () {
            $c.trigger('to.owl.carousel', [parseInt($(this).data('idx')), 400]);
        });

        /* Sync on carousel change */
        $c.on('changed.owl.carousel', function (e) {
            syncDots(e.item.index);
        });

        /* Hide dots if only one item */
        if (total <= 1) $dots.hide();
    });

    /* ─── 3. MOBILE BOTTOM SHEET ─── */
    var sheet   = document.getElementById('schBottomSheet');
    var bsImg   = document.getElementById('schBsImg');
    var bsMonth = document.getElementById('schBsMonth');
    var bsTitle = document.getElementById('schBsTitle');
    var bsClose = document.getElementById('schBsClose');
    var bsBack  = document.getElementById('schBsBackdrop');
    var bsPanel = document.getElementById('schBsPanel');

    function openSheet(title, month, imgSrc) {
        if (!sheet) return;
        bsTitle.textContent = title  || '';
        bsMonth.textContent = month  || '';
        bsImg.src           = imgSrc || '';
        bsImg.alt           = title  || '';
        /* Scroll panel to top */
        if (bsPanel) bsPanel.scrollTop = 0;
        sheet.classList.add('is-open');
        document.body.style.overflow = 'hidden';
        hideBtt();
        setTimeout(function () { if (bsClose) bsClose.focus(); }, 80);
    }

    function closeSheet() {
        if (!sheet) return;
        sheet.classList.remove('is-open');
        document.body.style.overflow = '';
        showBtt();
        setTimeout(function () { bsImg.src = ''; }, 400);
    }

    /* Open via card buttons */
    document.querySelectorAll('.sch-mob-expand-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            openSheet(
                this.getAttribute('data-title'),
                this.getAttribute('data-month'),
                this.getAttribute('data-img')
            );
        });
    });

    if (bsClose) bsClose.addEventListener('click', closeSheet);
    if (bsBack)  bsBack.addEventListener('click', closeSheet);

    /* ESC key */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && sheet && sheet.classList.contains('is-open')) {
            closeSheet();
        }
    });

})();
</script>
