<script>
(function () {
    var LS_KEYS_OLD = [
        'ldksyahid_welcome_popup',
        'ldksyahid_welcome_popup_eid_fitri',
        'ldksyahid_welcome_popup_arafah_fasting',
    ];
    var LS_KEY   = 'ldksyahid_welcome_popup_syawal_fasting';
    var backdrop = document.getElementById('wrp-backdrop');

    /* Remove old keys if they still exist */
    LS_KEYS_OLD.forEach(function (key) { localStorage.removeItem(key); });

    /* Already shown before — skip */
    if (localStorage.getItem(LS_KEY)) return;

    function lockScroll() { document.body.style.overflow = 'hidden'; }
    function unlockScroll() { document.body.style.overflow = ''; }

    /* Close only (without marking — popup will show again on next visit) */
    function closePopup() {
        if (!backdrop) return;
        backdrop.classList.remove('active');
        unlockScroll();
    }

    /* Close & mark in localStorage — will not show again */
    function dismissPopup() {
        if (!backdrop) return;
        backdrop.classList.remove('active');
        unlockScroll();
        localStorage.setItem(LS_KEY, '1');
    }

    var btnExplore = document.getElementById('wrp-btn-explore');
    var btnDismiss = document.getElementById('wrp-btn-dismiss');
    var btnX       = document.getElementById('wrp-x');

    if (btnExplore) btnExplore.addEventListener('click', closePopup);
    if (btnDismiss) btnDismiss.addEventListener('click', dismissPopup);
    if (btnX)       btnX.addEventListener('click', closePopup);

    /* Click on dark backdrop outside the card */
    if (backdrop) {
        backdrop.addEventListener('click', function (e) {
            if (e.target === backdrop) closePopup();
        });
    }

    /* Escape key */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closePopup();
    });

    /* Show popup after page has fully loaded */
    function showPopup() {
        setTimeout(function () {
            if (backdrop) {
                backdrop.classList.add('active');
                lockScroll();
            }
        }, 800);
    }

    if (document.readyState === 'complete') {
        showPopup();
    } else {
        window.addEventListener('load', showPopup);
    }
}());
</script>
