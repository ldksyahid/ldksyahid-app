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

    /* ─── 2. MOBILE OWL CAROUSEL + PREV/NEXT + COUNTER ─── */
    $(document).ready(function () {
        var $c    = $('#schCarousel');
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

        var total   = $c.find('.owl-item:not(.cloned)').length;
        var current = 0;
        var $nav    = $('#schMobNav');
        var $prev   = $('#schMobPrev');
        var $next   = $('#schMobNext');
        var $ctr    = $('#schMobCounter');

        function updateNav(idx) {
            current = idx;
            $ctr.text((idx + 1) + ' / ' + total);
            $prev.prop('disabled', idx === 0);
            $next.prop('disabled', idx === total - 1);
        }

        /* Init */
        updateNav(0);
        if (total <= 1) $nav.hide();

        /* Button clicks */
        $prev.on('click', function () {
            if (current > 0) $c.trigger('to.owl.carousel', [current - 1, 380]);
        });
        $next.on('click', function () {
            if (current < total - 1) $c.trigger('to.owl.carousel', [current + 1, 380]);
        });

        /* Sync on swipe/change */
        $c.on('changed.owl.carousel', function (e) {
            updateNav(e.item.index);
        });
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
        if (bsPanel) bsPanel.scrollTop = 0;
        sheet.classList.add('is-open');
        document.body.classList.add('sch-modal-open');
        hideBtt();
        setTimeout(function () { if (bsClose) bsClose.focus(); }, 80);
    }

    function closeSheet() {
        if (!sheet) return;
        sheet.classList.add('is-closing');
        sheet.classList.remove('is-open');
        document.body.classList.remove('sch-modal-open');
        showBtt();
        setTimeout(function () {
            sheet.classList.remove('is-closing');
            bsImg.src = '';
        }, 420);
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
