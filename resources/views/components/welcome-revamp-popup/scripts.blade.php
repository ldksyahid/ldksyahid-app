<script>
/* ── Welcome Gemilang — Popup Logic ─────────────────────────────── */
(function () {
    /* ── localStorage keys ── */
    var LS_KEYS_OLD = [
        'ldksyahid_welcome_popup',
        'ldksyahid_welcome_popup_eid_fitri',
        'ldksyahid_welcome_popup_arafah_fasting',
        'ldksyahid_welcome_popup_syawal_fasting',
        'ldksyahid_welcome_popup_self_reward',
        'ldksyahid_welcome_popup_qurban',
        'ldksyahid_welcome_popup_milad_30',
        'ldksyahid_welcome_popup_muharram_1448',
    ];
    var LS_KEY   = 'ldksyahid_welcome_popup_gemilang_2026';
    var backdrop = document.getElementById('wrp-backdrop');

    LS_KEYS_OLD.forEach(function (k) { localStorage.removeItem(k); });
    if (localStorage.getItem(LS_KEY)) return;

    /* ── Scroll lock ── */
    function lockScroll()   { document.body.style.overflow = 'hidden'; }
    function unlockScroll() { document.body.style.overflow = ''; }

    /* ── Open / close / dismiss ── */
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
    var fallback   = document.getElementById('wrp-share-fallback');

    if (btnX)       btnX.addEventListener('click', closePopup);
    if (btnDismiss) btnDismiss.addEventListener('click', dismissPopup);

    /* ── Share — Web Share API + fallback ── */
    if (btnExplore) {
        var shareData = {
            title : 'Warisan Akal Budi Gemilang — LDK Syahid',
            text  : 'Tentang masa depan, tentang masa terang. Pelan pasti, jalanmu bakal gemilang gaes! 🌟 — LDK Syahid UIN Jakarta',
            url   : 'https://ldksyah.id/',
        };
        btnExplore.addEventListener('click', function () {
            if (navigator.share) {
                navigator.share(shareData).catch(function () {});
            } else {
                if (fallback) fallback.style.display = 'block';
                btnExplore.style.display = 'none';
            }
        });
    }

    /* ── Close on backdrop click & Escape ── */
    if (backdrop) {
        backdrop.addEventListener('click', function (e) {
            if (e.target === backdrop) closePopup();
        });
    }
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closePopup();
    });

    /* ── Show popup ── */
    function showPopup() {
        setTimeout(function () {
            if (backdrop) { backdrop.classList.add('active'); lockScroll(); }
        }, 800);
    }
    if (document.readyState === 'complete') { showPopup(); }
    else { window.addEventListener('load', showPopup); }
}());
</script>
