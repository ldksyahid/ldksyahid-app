<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ============================================================
       1. READING PROGRESS BAR
       ============================================================ */
    var progress = document.getElementById('nd-progress');
    if (progress) {
        function updateProgress() {
            var body    = document.documentElement;
            var scroll  = body.scrollTop  || document.body.scrollTop;
            var height  = body.scrollHeight - body.clientHeight;
            var pct     = height > 0 ? (scroll / height) * 100 : 0;
            progress.style.width = pct + '%';
        }
        window.addEventListener('scroll', updateProgress, { passive: true });
        updateProgress();
    }


    /* ============================================================
       2. SECTION ENTRANCE ANIMATION — appear together on load
       ============================================================ */
    document.querySelectorAll('.nd-enter').forEach(function (el) {
        el.classList.add('nd-visible');
    });


    /* ============================================================
       3. COPY URL FUNCTION
       ============================================================ */
    window.ndCopyUrl = function (url) {
        var full = window.location.href;
        if (url) full = window.location.origin + url;

        function showToast(ok) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    toast: true, position: 'top-end',
                    icon: ok ? 'success' : 'error',
                    title: ok ? 'URL berhasil disalin!' : 'Gagal menyalin URL',
                    showConfirmButton: false, timer: 2500, timerProgressBar: true,
                    customClass: { container: 'nd-swal-below-nav' }
                });
            }
        }

        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(full).then(
                function () { showToast(true); },
                function () { showToast(false); }
            );
        } else {
            try {
                var ta = document.createElement('textarea');
                ta.value = full;
                ta.style.cssText = 'position:fixed;top:0;left:0;opacity:0;pointer-events:none;';
                document.body.appendChild(ta); ta.select(); document.execCommand('copy');
                document.body.removeChild(ta); showToast(true);
            } catch (e) { showToast(false); }
        }
    };


    /* ============================================================
       4. WHATSAPP SHARE
       ============================================================ */
    window.ndShareWa = function (title) {
        var full = window.location.href;
        var text = (title ? title + '\n' : '') + full;
        window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank');
    };


    /* ============================================================
       5. WIRE SHARE BUTTONS
       ============================================================ */
    document.querySelectorAll('.nd-share-copy').forEach(function (btn) {
        btn.addEventListener('click', function () { ndCopyUrl(); });
    });
    document.querySelectorAll('.nd-share-wa').forEach(function (btn) {
        btn.addEventListener('click', function () {
            ndShareWa(this.dataset.title || '');
        });
    });


    /* ============================================================
       6. DISQUS EMBED
       ============================================================ */
    (function () {
        var d = document, s = d.createElement('script');
        s.src = 'https://https-ldksyah-id-1.disqus.com/embed.js';
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
    })();

}); /* end DOMContentLoaded */
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
