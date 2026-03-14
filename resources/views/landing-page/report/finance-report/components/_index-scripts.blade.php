{{-- ── Hero Jumbotron shared scripts ── --}}
@include('components.hero-jumbotron.scripts')

<script>
(function () {
    'use strict';

    /* ── Share helpers ───────────────────────────────────────── */
    function showToast(ok) {
        if (typeof Swal === 'undefined') return;
        Swal.fire({
            toast: true, position: 'top-end',
            icon: ok ? 'success' : 'error',
            title: ok ? 'URL berhasil disalin!' : 'Gagal menyalin URL',
            showConfirmButton: false, timer: 2500, timerProgressBar: true,
            customClass: { container: 'fr-swal-below-nav' }
        });
    }

    window.frCopyUrl = function (url, ev) {
        if (ev) ev.stopPropagation();
        var full = (url && url.indexOf('http') === 0) ? url : window.location.origin + url;
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

    window.frShareWa = function (url, title, ev) {
        if (ev) ev.stopPropagation();
        var full = (url && url.indexOf('http') === 0) ? url : window.location.origin + url;
        var text = (title ? title + '\n' : '') + full;
        window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank');
    };

    window.frShareX = function (url, title, ev) {
        if (ev) ev.stopPropagation();
        var full = (url && url.indexOf('http') === 0) ? url : window.location.origin + url;
        var text = (title ? title + ' — LDK Syahid\n' : '') + full;
        window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(text), '_blank');
    };

})();
</script>
