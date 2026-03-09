<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ============================================================
       SMOOTH ACCORDION
       ============================================================ */
    var accHeaders = document.querySelectorAll('.kk-acc-header');

    accHeaders.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var item = btn.closest('.kk-acc-item');
            var isOpen = item.classList.contains('kk-open');

            /* Close all others */
            document.querySelectorAll('.kk-acc-item.kk-open').forEach(function (openItem) {
                if (openItem !== item) openItem.classList.remove('kk-open');
            });

            /* Toggle this one */
            item.classList.toggle('kk-open', !isOpen);
        });
    });

    /* ============================================================
       SCROLL LOCK HELPERS
       ============================================================ */
    var _touchBlock = null;
    var btt = document.querySelector('.back-to-top');

    function lockScroll() {
        document.documentElement.style.overflow = 'hidden';
        document.body.classList.add('kk-sheet-open');
        _touchBlock = function (e) {
            var sheet = document.getElementById('kk-bottom-sheet');
            if (sheet && sheet.contains(e.target)) return;
            e.preventDefault();
        };
        window.addEventListener('touchmove', _touchBlock, { passive: false });
        if (btt) { btt.style.opacity = '0'; btt.style.visibility = 'hidden'; }
    }

    function unlockScroll() {
        document.documentElement.style.overflow = '';
        document.body.classList.remove('kk-sheet-open');
        if (_touchBlock) {
            window.removeEventListener('touchmove', _touchBlock);
            _touchBlock = null;
        }
        if (btt) { btt.style.opacity = ''; btt.style.visibility = ''; }
    }

    /* ============================================================
       COPY URL HELPER (share feature)
       ============================================================ */
    function showCopyToast(ok) {
        if (typeof Swal === 'undefined') return;
        Swal.fire({
            toast: true, position: 'top-end',
            icon: ok ? 'success' : 'error',
            title: ok ? 'URL berhasil disalin!' : 'Gagal menyalin URL',
            showConfirmButton: false, timer: 2500, timerProgressBar: true,
            customClass: { container: 'kk-swal-above' }
        });
    }

    /* ============================================================
       BOTTOM SHEET — SCORE RESULTS (mobile)
       ============================================================ */
    function buildScoreSheet() {
        /* Read current values from spans/tds updated by the external refreshValue() */
        function getSpan(id) {
            var el = document.querySelector('span[id="' + id + '"]');
            return el ? el.innerHTML : '-';
        }
        function getTd(id) {
            var el = document.querySelector('td[id="' + id + '"]');
            return el ? (el.innerHTML || '-') : '-';
        }

        var prokerName  = document.querySelector('span[id="namaproker"]');
        var nameText    = prokerName ? (prokerName.innerHTML || 'Program Kerja') : 'Program Kerja';
        var totalSpan   = document.querySelector('span[id="persen_proker"]');
        var totalVal    = totalSpan ? (totalSpan.innerHTML || '0') : '0';

        var rows = [
            { label: 'Kesesuaian Rencana',         bobot: '20%', id: 'sesuai_rencana' },
            { label: 'Kesesuaian Tujuan & Sasaran', bobot: '25%', id: 'sesuai_tujuansasaran' },
            { label: 'Waktu & Tempat',              bobot: '15%', id: 'sesuai_waktutempat' },
            { label: 'Parameter Keberhasilan',      bobot: '30%', id: 'sesuai_parameter' },
            { label: 'Akurasi Dana',                bobot: '10%', id: 'efisiensi_dana' },
        ];

        var rowsHtml = rows.map(function (r) {
            var tdVal = getTd(r.id);
            return '<tr>' +
                '<td style="padding:0.65rem 0.85rem;font-size:.83rem;color:#374151;border-bottom:1px solid rgba(0,167,157,.08)">' + r.label + '</td>' +
                '<td style="padding:0.65rem 0.5rem;font-size:.75rem;color:#9ca3af;text-align:center;border-bottom:1px solid rgba(0,167,157,.08)">' + r.bobot + '</td>' +
                '<td style="padding:0.65rem 0.85rem;font-size:.85rem;font-weight:700;color:#00a79d;text-align:right;border-bottom:1px solid rgba(0,167,157,.08)">' + tdVal + '%</td>' +
            '</tr>';
        }).join('');

        return '<div style="text-align:center;margin-bottom:1.25rem">' +
            '<p style="font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#9ca3af;margin:0 0 .2rem">Rekap Nilai</p>' +
            '<p style="font-size:1rem;font-weight:700;color:#1f2937;margin:0 0 .75rem">' + nameText + '</p>' +
            '<div style="display:inline-flex;align-items:center;justify-content:center;gap:.4rem;background:linear-gradient(135deg,#00a79d,#006D6D);border-radius:50rem;padding:.6rem 1.5rem">' +
                '<span style="color:#fff;font-size:.75rem;font-weight:600">Total Nilai</span>' +
                '<span style="color:#fff;font-size:1.35rem;font-weight:800">' + totalVal + '%</span>' +
            '</div>' +
        '</div>' +
        '<div style="border:2px solid rgba(0,167,157,.12);border-radius:16px;overflow:hidden;margin-bottom:1rem">' +
            '<table style="width:100%;border-collapse:collapse">' +
                '<thead><tr>' +
                    '<th style="padding:.6rem .85rem;background:rgba(0,167,157,.08);font-size:.68rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#00a79d;text-align:left">Kriteria</th>' +
                    '<th style="padding:.6rem .5rem;background:rgba(0,167,157,.08);font-size:.68rem;font-weight:700;text-transform:uppercase;color:#00a79d;text-align:center">Bobot</th>' +
                    '<th style="padding:.6rem .85rem;background:rgba(0,167,157,.08);font-size:.68rem;font-weight:700;text-transform:uppercase;color:#00a79d;text-align:right">Nilai</th>' +
                '</tr></thead>' +
                '<tbody>' + rowsHtml + '</tbody>' +
            '</table>' +
        '</div>' +
        '<div style="display:flex;gap:.65rem">' +
            '<button onclick="kkCopyUrl()" style="flex:1;display:flex;align-items:center;justify-content:center;gap:.4rem;border:1.5px solid rgba(0,167,157,.3);border-radius:50px;padding:.75rem;font-size:.8rem;font-weight:600;color:#00a79d;background:rgba(0,167,157,.08);cursor:pointer;transition:all .2s">' +
                '<i class="fas fa-link"></i><span>Salin URL</span>' +
            '</button>' +
            '<button onclick="kkShareWa()" style="flex:1;display:flex;align-items:center;justify-content:center;gap:.4rem;border:1.5px solid rgba(37,211,102,.28);border-radius:50px;padding:.75rem;font-size:.8rem;font-weight:600;color:#1da851;background:rgba(37,211,102,.08);cursor:pointer;transition:all .2s">' +
                '<i class="fab fa-whatsapp"></i><span>WhatsApp</span>' +
            '</button>' +
        '</div>';
    }

    function openSheet() {
        var content = document.getElementById('kk-bs-content');
        if (content) content.innerHTML = buildScoreSheet();
        document.getElementById('kk-bottom-sheet').scrollTop = 0;
        document.getElementById('kk-bs-backdrop').classList.add('active');
        document.getElementById('kk-bottom-sheet').classList.add('active');
        lockScroll();
    }

    function closeSheet() {
        document.getElementById('kk-bs-backdrop').classList.remove('active');
        document.getElementById('kk-bottom-sheet').classList.remove('active');
        unlockScroll();
    }

    /* View score button (mobile) */
    var viewBtn = document.getElementById('kk-view-score-btn');
    if (viewBtn) viewBtn.addEventListener('click', openSheet);

    var bsClose    = document.getElementById('kk-bs-close');
    var bsBackdrop = document.getElementById('kk-bs-backdrop');
    if (bsClose)    bsClose.addEventListener('click', closeSheet);
    if (bsBackdrop) bsBackdrop.addEventListener('click', closeSheet);

    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        var bs = document.getElementById('kk-bottom-sheet');
        if (bs && bs.classList.contains('active')) closeSheet();
    });

    /* ============================================================
       SHARE HELPERS
       ============================================================ */
    window.kkCopyUrl = function () {
        var url = window.location.href;
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(url).then(
                function () { showCopyToast(true); },
                function () { showCopyToast(false); }
            );
        } else {
            try {
                var ta = document.createElement('textarea');
                ta.value = url;
                ta.style.cssText = 'position:fixed;top:0;left:0;opacity:0;pointer-events:none';
                document.body.appendChild(ta); ta.select();
                document.execCommand('copy');
                document.body.removeChild(ta);
                showCopyToast(true);
            } catch (e) { showCopyToast(false); }
        }
    };

    window.kkShareWa = function () {
        var prokerName = document.querySelector('span[id="namaproker"]');
        var name = prokerName ? prokerName.innerHTML : '';
        var text = (name ? 'Nilai Proker "' + name + '": ' : 'Kalkulator Kestari LDK Syahid\n') + window.location.href;
        window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank');
    };

}); /* end DOMContentLoaded */
</script>
