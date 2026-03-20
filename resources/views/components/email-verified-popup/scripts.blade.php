<script>
(function () {
    var overlay  = document.getElementById('evpOverlay');
    var closeBtn = document.getElementById('evpClose');
    var ctaBtn   = document.getElementById('evpBtn');
    if (!overlay) return;

    function lockScroll()   { document.body.style.overflow = 'hidden'; }
    function unlockScroll() { document.body.style.overflow = ''; }

    lockScroll();

    function closePopup() {
        overlay.style.animation = 'evpFadeOut 0.3s ease forwards';
        unlockScroll();
        setTimeout(function () { overlay.style.display = 'none'; }, 320);
    }

    if (closeBtn) closeBtn.addEventListener('click', closePopup);
    if (ctaBtn)   ctaBtn.addEventListener('click', closePopup);

    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) closePopup();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closePopup();
    });
}());
</script>
