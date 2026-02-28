<script>
(function () {
    /* ── Share helpers ───────────────────────────────────────────── */
    function showToast(ok) {
        if (typeof Swal === 'undefined') return;
        Swal.fire({
            toast: true, position: 'top-end',
            icon: ok ? 'success' : 'error',
            title: ok ? 'URL berhasil disalin!' : 'Gagal menyalin URL',
            showConfirmButton: false,
            timer: 2500, timerProgressBar: true,
            customClass: { container: 'ad-swal-below-nav' }
        });
    }

    window.adCopyUrl = function (ev) {
        if (ev) ev.stopPropagation();
        var url = window.location.href;
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(url).then(
                function () { showToast(true); },
                function () { showToast(false); }
            );
        } else {
            try {
                var ta = document.createElement('textarea');
                ta.value = url;
                ta.style.cssText = 'position:fixed;top:0;left:0;opacity:0;pointer-events:none;';
                document.body.appendChild(ta);
                ta.select();
                document.execCommand('copy');
                document.body.removeChild(ta);
                showToast(true);
            } catch (e) { showToast(false); }
        }
    };

    window.adShareWa = function (btn, ev) {
        if (ev) ev.stopPropagation();
        var title = btn ? btn.dataset.title : '';
        var text  = (title ? title + '\n' : '') + window.location.href;
        window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank');
    };

    /* ── Mobile Baca Juga Sheet ──────────────────────────────────── */
    window.adOpenRjSheet = function () {
        document.getElementById('ad-rj-backdrop').classList.add('active');
        document.getElementById('ad-rj-sheet').classList.add('active');
        document.body.classList.add('ad-rj-open');
    };

    window.adCloseRjSheet = function () {
        document.getElementById('ad-rj-backdrop').classList.remove('active');
        document.getElementById('ad-rj-sheet').classList.remove('active');
        document.body.classList.remove('ad-rj-open');
    };

    document.addEventListener('DOMContentLoaded', function () {
        var backdrop = document.getElementById('ad-rj-backdrop');
        if (backdrop) backdrop.addEventListener('click', adCloseRjSheet);

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') adCloseRjSheet();
        });
    });
})();

/* ── Disqus ──────────────────────────────────────────────────────── */
(function () {
    var d = document, s = d.createElement('script');
    s.src = 'https://https-ldksyah-id-1.disqus.com/embed.js';
    s.setAttribute('data-timestamp', +new Date());
    (d.head || d.body).appendChild(s);
})();
</script>
<noscript>
    Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a>
</noscript>
