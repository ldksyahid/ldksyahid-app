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

        function openSheet(icon, title, desc) {
            pbsIcon.textContent  = icon;
            pbsTitle.textContent = title;
            pbsDesc.textContent  = desc;
            backdrop.style.display = 'block';
            requestAnimationFrame(() => {
                backdrop.classList.add('active');
                sheet.classList.add('active');
            });
            // Sembunyikan back-to-top secara smooth
            document.body.classList.add('kmb2-popup-open');
        }

        function closeSheet() {
            backdrop.classList.remove('active');
            sheet.classList.remove('active');
            setTimeout(() => {
                backdrop.style.display = 'none';
                // Tampilkan kembali back-to-top jika sudah scroll cukup
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
