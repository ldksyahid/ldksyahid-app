<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Tab switching ── */
    var tabs  = document.querySelectorAll('.cd-tab');
    var panes = document.querySelectorAll('.cd-tab-pane');

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            var target = this.dataset.target;

            tabs.forEach(function (t) { t.classList.remove('active'); });
            panes.forEach(function (p) { p.classList.remove('active'); });

            this.classList.add('active');
            var pane = document.getElementById(target);
            if (pane) pane.classList.add('active');
        });
    });

    /* ── Share: Copy URL ── */
    window.cdCopyUrl = function (ev) {
        if (ev) ev.preventDefault();
        var url = window.location.href;
        function showToast(ok) {
            if (typeof Swal === 'undefined') return;
            Swal.fire({
                toast: true, position: 'top-end',
                icon: ok ? 'success' : 'error',
                title: ok ? 'URL berhasil disalin!' : 'Gagal menyalin URL',
                showConfirmButton: false, timer: 2500, timerProgressBar: true
            });
        }
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(url)
                .then(function () { showToast(true); })
                .catch(function () { showToast(false); });
        } else {
            try {
                var ta = document.createElement('textarea');
                ta.value = url;
                ta.style.cssText = 'position:fixed;top:0;left:0;opacity:0;pointer-events:none;';
                document.body.appendChild(ta); ta.select(); document.execCommand('copy');
                document.body.removeChild(ta); showToast(true);
            } catch (e) { showToast(false); }
        }
    };

    /* ── Progress bar animated fill on scroll ── */
    var fills = document.querySelectorAll('.cd-progress-fill');
    if ('IntersectionObserver' in window && fills.length) {
        var widths = [];
        fills.forEach(function (fill, i) {
            widths[i] = fill.style.width;
            fill.style.width = '0%';
        });
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                var idx = Array.from(fills).indexOf(entry.target);
                entry.target.style.width = widths[idx];
                io.unobserve(entry.target);
            });
        }, { threshold: .1 });
        fills.forEach(function (fill) { io.observe(fill); });
    }

});
</script>
