<script>
(function () {
    var LS_KEY_OLD = 'ldksyahid_welcome_popup';
    var LS_KEY     = 'ldksyahid_welcome_popup_eid_fitri';
    var backdrop   = document.getElementById('wrp-backdrop');

    /* Hapus key lama jika masih ada */
    if (localStorage.getItem(LS_KEY_OLD)) {
        localStorage.removeItem(LS_KEY_OLD);
    }

    /* Sudah pernah ditampilkan — skip */
    if (localStorage.getItem(LS_KEY)) return;

    /* Tutup saja (tanpa tandai — popup muncul lagi di kunjungan berikutnya) */
    function closePopup() {
        if (!backdrop) return;
        backdrop.classList.remove('active');
    }

    /* Tutup & tandai di localStorage — tidak muncul lagi */
    function dismissPopup() {
        if (!backdrop) return;
        backdrop.classList.remove('active');
        localStorage.setItem(LS_KEY, '1');
    }

    var btnExplore = document.getElementById('wrp-btn-explore');
    var btnDismiss = document.getElementById('wrp-btn-dismiss');
    var btnX       = document.getElementById('wrp-x');

    if (btnExplore) btnExplore.addEventListener('click', closePopup);
    if (btnDismiss) btnDismiss.addEventListener('click', dismissPopup);
    if (btnX)       btnX.addEventListener('click', closePopup);

    /* Klik area gelap di luar card */
    if (backdrop) {
        backdrop.addEventListener('click', function (e) {
            if (e.target === backdrop) closePopup();
        });
    }

    /* Tombol Escape */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closePopup();
    });

    /* Tampilkan setelah halaman selesai dimuat */
    function showPopup() {
        setTimeout(function () {
            if (backdrop) backdrop.classList.add('active');
        }, 800);
    }

    if (document.readyState === 'complete') {
        showPopup();
    } else {
        window.addEventListener('load', showPopup);
    }
}());
</script>
