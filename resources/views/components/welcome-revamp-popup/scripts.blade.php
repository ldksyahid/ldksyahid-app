<script>
(function () {
    var LS_KEY   = 'ldksyahid_welcome_popup';
    var backdrop = document.getElementById('wrp-backdrop');

    /* Sudah pernah ditampilkan — skip */
    if (localStorage.getItem(LS_KEY)) return;

    /* Tutup & tandai di localStorage */
    function closePopup() {
        if (!backdrop) return;
        backdrop.classList.remove('active');
        localStorage.setItem(LS_KEY, '1');
    }

    var btnExplore = document.getElementById('wrp-btn-explore');
    var btnX       = document.getElementById('wrp-x');

    if (btnExplore) btnExplore.addEventListener('click', closePopup);
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
