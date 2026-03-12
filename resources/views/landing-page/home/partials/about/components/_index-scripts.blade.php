<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabBtns = document.querySelectorAll('.tab-btn-cr');
    const tabContents = document.querySelectorAll('.tab-content-cr');
    const slider = document.querySelector('.tabs-cr-slider');
    const tabContentsWrapper = document.querySelector('.tab-contents-cr');

    function updateSlider(btn) {
        if (!slider || window.innerWidth < 992) return;
        slider.style.width = btn.offsetWidth + 'px';
        slider.style.left = btn.offsetLeft + 'px';
    }

    // Initialize slider
    const activeBtn = document.querySelector('.tab-btn-cr.active');
    if (activeBtn) {
        setTimeout(() => updateSlider(activeBtn), 100);
    }

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');

            tabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));

            this.classList.add('active');
            const targetTab = document.getElementById('tab-' + tabId);
            targetTab.classList.add('active');

            updateSlider(this);
        });
    });

    window.addEventListener('resize', function() {
        const active = document.querySelector('.tab-btn-cr.active');
        if (active) updateSlider(active);
    });

    // Tap to flip mission cards (all devices - CSS @media hover:hover handles desktop hover)
    document.querySelectorAll('.mission-card-cr').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.mission-card-cr.flipped').forEach(c => {
                if (c !== this) c.classList.remove('flipped');
            });
            this.classList.toggle('flipped');
        });
    });

    // Mobile: bottom sheet for pillars
    if ('ontouchstart' in window) {
        const backdrop = document.getElementById('pillarBackdrop');
        const sheet    = document.getElementById('pillarSheet');
        const pbsIcon  = document.getElementById('pbsIcon');
        const pbsTitle = document.getElementById('pbsTitle');
        const pbsDesc  = document.getElementById('pbsDesc');
        const pbsClose = document.getElementById('pbsClose');

        let _pbsWheelLock = null, _pbsKeyLock = null, _pbsTouchLock = null;

        function openSheet(icon, title, desc) {
            pbsIcon.textContent  = icon;
            pbsTitle.textContent = title;
            pbsDesc.textContent  = desc;
            backdrop.style.display = 'block';
            requestAnimationFrame(() => {
                backdrop.classList.add('active');
                sheet.classList.add('active');
            });
            document.body.classList.add('kmb2-popup-open');
            // Lock scroll via events — tidak pakai overflow:hidden agar navbar & sticky aman
            _pbsWheelLock = function(e) { e.preventDefault(); };
            _pbsKeyLock   = function(e) {
                if ([' ','ArrowUp','ArrowDown','PageUp','PageDown','Home','End'].includes(e.key)) {
                    e.preventDefault();
                }
            };
            _pbsTouchLock = function(e) {
                if (!sheet.contains(e.target)) e.preventDefault();
            };
            window.addEventListener('wheel',   _pbsWheelLock,  { passive: false });
            window.addEventListener('keydown', _pbsKeyLock);
            document.addEventListener('touchmove', _pbsTouchLock, { passive: false });
        }

        function closeSheet() {
            backdrop.classList.remove('active');
            sheet.classList.remove('active');
            // Lepas scroll lock
            if (_pbsWheelLock)  { window.removeEventListener('wheel',   _pbsWheelLock);  _pbsWheelLock  = null; }
            if (_pbsKeyLock)    { window.removeEventListener('keydown', _pbsKeyLock);    _pbsKeyLock    = null; }
            if (_pbsTouchLock)  { document.removeEventListener('touchmove', _pbsTouchLock); _pbsTouchLock = null; }
            setTimeout(() => {
                backdrop.style.display = 'none';
                document.body.classList.remove('kmb2-popup-open');
                if (window.jQuery && (window.scrollY || document.documentElement.scrollTop) > 300) {
                    jQuery('.back-to-top').stop(true).fadeIn(300);
                }
            }, 350);
        }

        document.querySelectorAll('.pillar-cr').forEach(pillar => {
            pillar.addEventListener('click', function() {
                openSheet(
                    this.dataset.icon,
                    this.dataset.title,
                    this.dataset.desc
                );
            });
        });

        backdrop.addEventListener('click', closeSheet);
        pbsClose.addEventListener('click', closeSheet);
    }
});
</script>
