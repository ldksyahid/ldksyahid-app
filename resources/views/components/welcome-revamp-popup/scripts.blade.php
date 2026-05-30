<script>
/* ── Popup open / close / dismiss ────────────────────────────────── */
(function () {
    var LS_KEYS_OLD = [
        'ldksyahid_welcome_popup',
        'ldksyahid_welcome_popup_eid_fitri',
        'ldksyahid_welcome_popup_arafah_fasting',
        'ldksyahid_welcome_popup_syawal_fasting',
        'ldksyahid_welcome_popup_self_reward',
        'ldksyahid_welcome_popup_qurban',
    ];
    var LS_KEY   = 'ldksyahid_welcome_popup_milad_30';
    var backdrop = document.getElementById('wrp-backdrop');

    LS_KEYS_OLD.forEach(function (k) { localStorage.removeItem(k); });
    if (localStorage.getItem(LS_KEY)) return;

    function lockScroll()   { document.body.style.overflow = 'hidden'; }
    function unlockScroll() { document.body.style.overflow = ''; }

    function closePopup() {
        if (!backdrop) return;
        backdrop.classList.remove('active');
        unlockScroll();
    }
    function dismissPopup() {
        if (!backdrop) return;
        backdrop.classList.remove('active');
        unlockScroll();
        localStorage.setItem(LS_KEY, '1');
    }

    var btnExplore = document.getElementById('wrp-btn-explore');
    var btnDismiss = document.getElementById('wrp-btn-dismiss');
    var btnX       = document.getElementById('wrp-x');

    if (btnExplore) btnExplore.addEventListener('click', function () {
        window.open('https://ldksyah.id/TwibbonMilad30', '_blank', 'noopener,noreferrer');
        closePopup();
    });
    if (btnDismiss) btnDismiss.addEventListener('click', dismissPopup);
    if (btnX)       btnX.addEventListener('click', closePopup);

    if (backdrop) {
        backdrop.addEventListener('click', function (e) {
            if (e.target === backdrop) closePopup();
        });
    }
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closePopup();
    });

    function showPopup() {
        setTimeout(function () {
            if (backdrop) { backdrop.classList.add('active'); lockScroll(); }
        }, 800);
    }
    if (document.readyState === 'complete') { showPopup(); }
    else { window.addEventListener('load', showPopup); }
}());
</script>
