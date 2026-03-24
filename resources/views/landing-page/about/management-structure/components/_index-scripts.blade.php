<script>
(function () {
    'use strict';

    var btt = document.querySelector('.back-to-top');

    /* ─── Helper: hide / show back-to-top ─── */
    function hideBtt() {
        if (btt) btt.style.cssText =
            'opacity:0!important;pointer-events:none!important;transform:scale(0.7) translateY(10px)!important;transition:opacity .3s ease,transform .3s ease!important;';
    }
    function showBtt() {
        if (btt) btt.style.cssText = '';
    }

    /* ─── 1. SCROLL REVEAL ─── */
    var revealEls = document.querySelectorAll('.ms-reveal');
    if ('IntersectionObserver' in window && revealEls.length) {
        var ro = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { e.target.classList.add('visible'); ro.unobserve(e.target); }
            });
        }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
        revealEls.forEach(function (el) { ro.observe(el); });
    } else {
        revealEls.forEach(function (el) { el.classList.add('visible'); });
    }

    /* ─── 2. ANIMATED FEATURE LIST ─── */
    var featLists = document.querySelectorAll('[data-ms-list]');
    if ('IntersectionObserver' in window && featLists.length) {
        var lo = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) {
                    e.target.querySelectorAll('li').forEach(function (li, i) {
                        li.style.animationDelay = (0.1 + i * 0.15) + 's';
                        li.classList.add('ms-li-visible');
                    });
                    lo.unobserve(e.target);
                }
            });
        }, { threshold: 0.2 });
        featLists.forEach(function (l) { lo.observe(l); });
    } else {
        featLists.forEach(function (l) {
            l.querySelectorAll('li').forEach(function (li) { li.classList.add('ms-li-visible'); });
        });
    }

    /* ─── 3. LIGHTBOX (desktop chart click) ─── */
    var lb        = document.getElementById('msLightbox');
    var lbImg     = document.getElementById('msLbImg');
    var lbTitle   = document.getElementById('msLbTitleText');
    var lbClose   = document.getElementById('msLbClose');
    var lbBg      = document.getElementById('msLbBackdrop');
    var prevFocus = null;

    if (lb) {
        function openLb(src, title) {
            prevFocus = document.activeElement;
            lbImg.src = src || '';
            lbTitle.textContent = title || '';
            lb.classList.add('ms-lb-active');
            lb.classList.remove('ms-lb-closing');
            document.body.classList.add('ms-modal-open');
            hideBtt();
            setTimeout(function () { if (lbClose) lbClose.focus(); }, 60);
        }

        function closeLb() {
            lb.classList.add('ms-lb-closing');
            setTimeout(function () {
                lb.classList.remove('ms-lb-active', 'ms-lb-closing');
                document.body.classList.remove('ms-modal-open');
                lbImg.src = '';
                showBtt();
                if (prevFocus) prevFocus.focus();
            }, 340);
        }

        document.querySelectorAll('[data-ms-lb]').forEach(function (el) {
            el.addEventListener('click', function (e) {
                e.preventDefault();
                openLb(this.dataset.src, this.dataset.title);
            });
            el.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); openLb(this.dataset.src, this.dataset.title); }
            });
        });

        lbClose.addEventListener('click', closeLb);
        lbBg.addEventListener('click', closeLb);
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && lb.classList.contains('ms-lb-active')) closeLb();
        });

        lb.addEventListener('keydown', function (e) {
            if (e.key !== 'Tab') return;
            var f = lb.querySelectorAll('button,[href],[tabindex]:not([tabindex="-1"])');
            var first = f[0], last = f[f.length - 1];
            if (e.shiftKey) { if (document.activeElement === first) { e.preventDefault(); last.focus(); } }
            else            { if (document.activeElement === last)  { e.preventDefault(); first.focus(); } }
        });
    }

    /* ─── 4. DETAIL POPUP (mobile "Lihat Selengkapnya") ─── */
    var dm       = document.getElementById('msDetailModal');
    var dmBg     = document.getElementById('msDmBackdrop');
    var dmClose  = document.getElementById('msDmClose');
    var dmSheet  = document.getElementById('msDmSheet');
    var dmBatch  = document.getElementById('msDmBatch');
    var dmName   = document.getElementById('msDmName');
    var dmPeriod = document.getElementById('msDmPeriod');
    var dmDesc   = document.getElementById('msDmDesc');
    var dmPhoto  = document.getElementById('msDmPhoto');
    var dmChart  = document.getElementById('msDmChart');

    if (dm) {
        function openDm(data) {
            dmBatch.textContent = data.batch  || '';
            dmName.textContent  = data.name   || '';
            dmPeriod.innerHTML  = '<i class="fas fa-calendar-alt" style="font-size:0.62rem;"></i> Masa Bakti ' + (data.period || '');
            dmDesc.textContent  = data.desc   || '';
            dmPhoto.src = data.photo || '';
            dmPhoto.alt = 'Foto Pengurus ' + (data.batch || '');
            dmChart.src = data.chart || '';
            dmChart.alt = 'Bagan Struktur ' + (data.batch || '');
            dm.classList.add('ms-dm-active');
            dm.classList.remove('ms-dm-closing');
            document.body.classList.add('ms-modal-open');
            hideBtt();
            /* Scroll body to top */
            if (dmSheet) {
                var body = dmSheet.querySelector('.ms-dm-body');
                if (body) body.scrollTop = 0;
            }
            setTimeout(function () { if (dmClose) dmClose.focus(); }, 80);
        }

        function closeDm() {
            dm.classList.add('ms-dm-closing');
            setTimeout(function () {
                dm.classList.remove('ms-dm-active', 'ms-dm-closing');
                document.body.classList.remove('ms-modal-open');
                dmPhoto.src = '';
                dmChart.src = '';
                showBtt();
            }, 340);
        }

        document.querySelectorAll('.ms-detail-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                openDm({
                    batch : this.dataset.batch,
                    name  : this.dataset.name,
                    period: this.dataset.period,
                    desc  : this.dataset.desc,
                    photo : this.dataset.photo,
                    chart : this.dataset.chart
                });
            });
        });

        dmClose.addEventListener('click', closeDm);
        dmBg.addEventListener('click', closeDm);
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && dm.classList.contains('ms-dm-active')) closeDm();
        });
    }

    /* ─── 5. DESKTOP CHART COLLAPSE ─── */
    document.querySelectorAll('.ms-di-chart-section').forEach(function (section) {
        var btn = section.querySelector('.ms-di-chart-toggle');
        if (!btn) return;
        btn.addEventListener('click', function () {
            var isOpen = section.classList.toggle('ms-cs-open');
            btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    });

    /* ─── 6. MOBILE OWL CAROUSEL + DOTS-ONLY NAV ─── */
    $(document).ready(function () {
        var $c = $('#msCarousel');
        if (!$c.length || window.innerWidth > 991) return;

        /* Init carousel — identical to the article carousel */
        $c.owlCarousel({
            items       : 1,
            loop        : false,
            margin      : 14,
            stagePadding: 24,
            dots        : false,
            nav         : false,
            smartSpeed  : 350,
            autoplay    : false,
            touchDrag   : true,
            mouseDrag   : true
        });

        /* ── Build custom dots ── */
        var total   = $c.find('.owl-item').length;
        var $dots   = $('#msMobDots');

        for (var i = 0; i < total; i++) {
            $dots.append(
                '<button class="ms-mob-dot' + (i === 0 ? ' active' : '') +
                '" data-idx="' + i + '" aria-label="Slide ' + (i + 1) + '"></button>'
            );
        }

        /* Update active dot */
        function syncDots(idx) {
            $dots.find('.ms-mob-dot').removeClass('active');
            $dots.find('[data-idx="' + idx + '"]').addClass('active');
        }

        syncDots(0);

        /* Dot click — jump to slide */
        $dots.on('click', '.ms-mob-dot', function () {
            $c.trigger('to.owl.carousel', [parseInt($(this).data('idx')), 480]);
        });

        /* Sync on carousel change */
        $c.on('changed.owl.carousel', function (e) {
            syncDots(e.item.index);
        });

        /* Hide nav if only one item */
        if (total <= 1) {
            $('#msMobNav').hide();
        }
    });

})();
</script>
