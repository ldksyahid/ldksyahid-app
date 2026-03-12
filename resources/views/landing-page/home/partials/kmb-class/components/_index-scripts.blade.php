{{-- ══════════════════════════════════════════ --}}
{{-- SCRIPT                                    --}}
{{-- ══════════════════════════════════════════ --}}
<script>
(function() {
    const KMB_DATA = @json($kelas);
    let currentIdx = 0;
    let _kmbWheelLock = null, _kmbKeyLock = null, _kmbTouchLock = null;

    /* ── Helpers ── */
    function isDesktop() { return window.innerWidth >= 992; }

    function lockScroll(container) {
        _kmbWheelLock = function(e) { e.preventDefault(); };
        _kmbKeyLock   = function(e) {
            if ([' ','ArrowUp','ArrowDown','PageUp','PageDown','Home','End'].includes(e.key)) {
                e.preventDefault();
            }
        };
        _kmbTouchLock = function(e) {
            if (!container.contains(e.target)) e.preventDefault();
        };
        window.addEventListener('wheel',      _kmbWheelLock,  { passive: false });
        window.addEventListener('keydown',    _kmbKeyLock);
        document.addEventListener('touchmove', _kmbTouchLock, { passive: false });
    }

    function unlockScroll() {
        if (_kmbWheelLock)  { window.removeEventListener('wheel',      _kmbWheelLock);   _kmbWheelLock  = null; }
        if (_kmbKeyLock)    { window.removeEventListener('keydown',    _kmbKeyLock);      _kmbKeyLock    = null; }
        if (_kmbTouchLock)  { document.removeEventListener('touchmove', _kmbTouchLock);  _kmbTouchLock  = null; }
    }

    /* ── Back-to-top toggle (smooth) ── */
    function hideBackToTop() {
        document.body.classList.add('kmb2-popup-open');
    }
    function showBackToTop() {
        document.body.classList.remove('kmb2-popup-open');
        // Re-trigger jQuery fade-in if scrolled far enough
        setTimeout(function() {
            if (window.jQuery && (window.scrollY || document.documentElement.scrollTop) > 300) {
                jQuery('.back-to-top').stop(true).fadeIn(300);
            }
        }, 380);
    }

    /* ── Populate Modal ── */
    function populateModal(idx) {
        const d = KMB_DATA[idx];
        document.getElementById('kmb2MBanner').style.background = d.color;
        document.getElementById('kmb2MPhotoRing').style.background =
            'linear-gradient(135deg,' + d.color + ',' + d.light + ')';
        document.getElementById('kmb2MEmoji').innerHTML  = d.icon_svg;
        document.getElementById('kmb2MTag').textContent  = d.tag;
        document.getElementById('kmb2MIcon').innerHTML   = d.icon_svg;
        var chip = document.getElementById('kmb2MChip');
        chip.innerHTML    = d.icon_svg;
        chip.style.color  = d.color;
        document.getElementById('kmb2MTitle').textContent = d.title;
        document.getElementById('kmb2MDesc').textContent  = d.desc;
        // Update dots
        document.querySelectorAll('#kmb2MDots .mdot').forEach(function(dot, i) {
            dot.classList.toggle('active', i === idx);
        });
    }

    /* ── Populate Sheet ── */
    function populateSheet(idx) {
        const d = KMB_DATA[idx];
        document.getElementById('kmb2SBanner').style.background = d.color;
        document.getElementById('kmb2SPhotoRing').style.background =
            'linear-gradient(135deg,' + d.color + ',' + d.light + ')';
        document.getElementById('kmb2SEmoji').innerHTML  = d.icon_svg;
        document.getElementById('kmb2STag').textContent  = d.tag;
        document.getElementById('kmb2SIcon').innerHTML   = d.icon_svg;
        var chip = document.getElementById('kmb2SChip');
        chip.innerHTML    = d.icon_svg;
        chip.style.color  = d.color;
        document.getElementById('kmb2STitle').textContent = d.title;
        document.getElementById('kmb2SDesc').textContent  = d.desc;
        // Update dots
        document.querySelectorAll('#kmb2SDots .sdot').forEach(function(dot, i) {
            dot.classList.toggle('active', i === idx);
        });
        // Scroll sheet to top
        document.getElementById('kmb2Sheet').scrollTop = 0;
    }

    /* ── Open ── */
    window.kmbOpen = function(idx) {
        currentIdx = idx;
        if (isDesktop()) openModal(idx);
        else             openSheet(idx);
    };

    function openModal(idx) {
        populateModal(idx);
        var bd = document.getElementById('kmb2MBackdrop');
        var md = document.getElementById('kmb2Modal');
        bd.style.display = 'block';
        md.style.display = 'block';
        requestAnimationFrame(function() {
            bd.classList.add('active');
            md.classList.add('active');
        });
        lockScroll(document.getElementById('kmb2Modal'));
        hideBackToTop();
        document.getElementById('kmb2MClose').focus();
    }

    function closeModal() {
        var bd = document.getElementById('kmb2MBackdrop');
        var md = document.getElementById('kmb2Modal');
        bd.classList.remove('active');
        md.classList.remove('active');
        setTimeout(function() {
            bd.style.display = 'none';
            md.style.display = 'none';
            unlockScroll();
            showBackToTop();
        }, 350);
    }

    function openSheet(idx) {
        populateSheet(idx);
        var bd = document.getElementById('kmb2SBackdrop');
        var sh = document.getElementById('kmb2Sheet');
        bd.style.display = 'block';
        sh.style.display = 'block';
        requestAnimationFrame(function() {
            bd.classList.add('active');
            sh.classList.add('active');
        });
        lockScroll(document.getElementById('kmb2Sheet'));
        hideBackToTop();
    }

    function closeSheet() {
        var bd = document.getElementById('kmb2SBackdrop');
        var sh = document.getElementById('kmb2Sheet');
        bd.classList.remove('active');
        sh.classList.remove('active');
        setTimeout(function() {
            bd.style.display = 'none';
            sh.style.display = 'none';
            unlockScroll();
            showBackToTop();
        }, 380);
    }

    /* ── Navigate ── */
    function navigateTo(idx) {
        currentIdx = (idx + KMB_DATA.length) % KMB_DATA.length;
        if (isDesktop()) populateModal(currentIdx);
        else             populateSheet(currentIdx);
    }

    /* ── Build Dots ── */
    function buildDots(containerId, cssClass) {
        var container = document.getElementById(containerId);
        if (!container) return;
        container.innerHTML = '';
        KMB_DATA.forEach(function(_, i) {
            var dot = document.createElement('span');
            dot.className = cssClass + (i === 0 ? ' active' : '');
            dot.addEventListener('click', function() { navigateTo(i); });
            container.appendChild(dot);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        buildDots('kmb2MDots', 'mdot');
        buildDots('kmb2SDots', 'sdot');

        /* Modal events */
        document.getElementById('kmb2MClose').addEventListener('click', closeModal);
        document.getElementById('kmb2MBackdrop').addEventListener('click', closeModal);
        document.getElementById('kmb2MPrev').addEventListener('click', function() { navigateTo(currentIdx - 1); });
        document.getElementById('kmb2MNext').addEventListener('click', function() { navigateTo(currentIdx + 1); });

        /* Sheet events */
        document.getElementById('kmb2SClose').addEventListener('click', closeSheet);
        document.getElementById('kmb2SBackdrop').addEventListener('click', closeSheet);
        document.getElementById('kmb2SPrev').addEventListener('click', function() { navigateTo(currentIdx - 1); });
        document.getElementById('kmb2SNext').addEventListener('click', function() { navigateTo(currentIdx + 1); });

        /* Keyboard: Escape to close, arrows to navigate */
        document.addEventListener('keydown', function (e) {
            var mOpen = document.getElementById('kmb2Modal').classList.contains('active');
            var sOpen = document.getElementById('kmb2Sheet').classList.contains('active');
            if (!mOpen && !sOpen) return;
            if (e.key === 'Escape')     { mOpen ? closeModal() : closeSheet(); }
            if (e.key === 'ArrowLeft')  { navigateTo(currentIdx - 1); }
            if (e.key === 'ArrowRight') { navigateTo(currentIdx + 1); }
        });
    });
})();
</script>
