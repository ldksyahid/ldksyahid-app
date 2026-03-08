{{-- ── Hero Jumbotron shared scripts ── --}}
@include('components.hero-jumbotron.scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ============================================================
       UTILITIES
       ============================================================ */
    function escHtml(str) {
        if (str == null) return '';
        return String(str)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;')
            .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    var btt = document.querySelector('.back-to-top');
    var _touchBlock = null;
    function lockScroll() {
        document.documentElement.style.overflow = 'hidden';
        document.body.classList.add('rp-sheet-open');
        _touchBlock = function (e) {
            var sheet = document.getElementById('rp-bottom-sheet');
            if (sheet && sheet.contains(e.target)) return;
            e.preventDefault();
        };
        window.addEventListener('touchmove', _touchBlock, { passive: false });
        if (btt) { btt.style.opacity = '0'; btt.style.visibility = 'hidden'; }
    }
    function unlockScroll() {
        document.documentElement.style.overflow = '';
        document.body.classList.remove('rp-sheet-open');
        if (_touchBlock) {
            window.removeEventListener('touchmove', _touchBlock);
            _touchBlock = null;
        }
        if (btt) { btt.style.opacity = ''; btt.style.visibility = ''; }
    }

    /* Share helpers (exposed for desktop card onclick) */
    function showCopyToast(ok) {
        if (typeof Swal === 'undefined') return;
        Swal.fire({
            toast: true, position: 'top-end',
            icon: ok ? 'success' : 'error',
            title: ok ? 'URL berhasil disalin!' : 'Gagal menyalin URL',
            showConfirmButton: false, timer: 2500, timerProgressBar: true,
            customClass: { container: 'rp-swal-above-sheet' }
        });
    }
    window.rpCopyUrl = function (url, ev) {
        if (ev) ev.stopPropagation();
        var full = (url && url.indexOf('http') === 0) ? url : window.location.origin + url;
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(full).then(
                function () { showCopyToast(true); }, function () { showCopyToast(false); }
            );
        } else {
            try {
                var ta = document.createElement('textarea');
                ta.value = full; ta.style.cssText = 'position:fixed;top:0;left:0;opacity:0;pointer-events:none;';
                document.body.appendChild(ta); ta.select(); document.execCommand('copy');
                document.body.removeChild(ta); showCopyToast(true);
            } catch (e) { showCopyToast(false); }
        }
    };
    window.rpShareWa = function (url, title, ev) {
        if (ev) ev.stopPropagation();
        var full = (url && url.indexOf('http') === 0) ? url : window.location.origin + url;
        var text = (title ? title + '\n' : '') + full;
        window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank');
    };


    /* ============================================================
       MOBILE BOTTOM SHEET
       ============================================================ */
    window.rpOpenBottomSheet = function (el) {
        var content = document.getElementById('rp-bs-content');
        if (!content) return;

        var title = el.dataset.title || '';
        var desc  = el.dataset.desc  || '';
        var image = el.dataset.image || '';
        var node  = el.dataset.node  || '';

        var imgHtml = image
            ? '<img src="https://lh3.googleusercontent.com/d/' + escHtml(image) + '" alt="' + escHtml(title) + '" class="rp-bs-img-photo" loading="lazy">'
            : '<div class="rp-bs-img-fallback"><i class="fas fa-file-alt"></i></div>';

        content.innerHTML =
            '<div class="rp-bs-img-wrap">' +
                '<div class="rp-bs-drag-handle"></div>' +
                imgHtml +
                '<div class="rp-bs-img-gradient"></div>' +
            '</div>' +
            '<div class="rp-bs-info">' +
                '<h5 class="rp-bs-title">' + escHtml(title) + '</h5>' +
                (desc ? '<p class="rp-bs-desc">' + escHtml(desc) + '</p>' : '') +
                '<div class="rp-bs-btns">' +
                    (node ? '<a href="' + escHtml(node) + '" class="rp-bs-btn-primary" target="_blank" rel="noopener">' +
                        '<i class="fas fa-external-link-alt"></i><span>Buka Dokumen</span>' +
                    '</a>' : '') +
                '</div>' +
                (node ?
                    '<div class="rp-bs-share-wrap">' +
                        '<span class="rp-bs-share-label">Bagikan</span>' +
                        '<div class="rp-bs-share-row">' +
                            '<button class="rp-bs-share-btn rp-bs-share-copy rp-bs-copy-btn"><i class="fas fa-link"></i><span>Salin URL</span></button>' +
                            '<button class="rp-bs-share-btn rp-bs-share-wa rp-bs-wa-btn"><i class="fab fa-whatsapp"></i><span>WhatsApp</span></button>' +
                        '</div>' +
                    '</div>'
                : '') +
            '</div>';

        /* Wire share buttons */
        var bsCopyBtn = content.querySelector('.rp-bs-copy-btn');
        var bsWaBtn   = content.querySelector('.rp-bs-wa-btn');
        if (bsCopyBtn) bsCopyBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(node).then(
                    function () { showCopyToast(true); }, function () { showCopyToast(false); }
                );
            } else {
                try {
                    var ta = document.createElement('textarea');
                    ta.value = node; ta.style.cssText = 'position:fixed;top:0;left:0;opacity:0;pointer-events:none;';
                    document.body.appendChild(ta); ta.select(); document.execCommand('copy');
                    document.body.removeChild(ta); showCopyToast(true);
                } catch (err) { showCopyToast(false); }
            }
        });
        if (bsWaBtn) bsWaBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            var text = (title ? title + '\n' : '') + node;
            window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank');
        });

        document.getElementById('rp-bottom-sheet').scrollTop = 0;
        document.getElementById('rp-bs-backdrop').classList.add('active');
        document.getElementById('rp-bottom-sheet').classList.add('active');
        lockScroll();
    };

    function rpCloseBs() {
        document.getElementById('rp-bs-backdrop').classList.remove('active');
        document.getElementById('rp-bottom-sheet').classList.remove('active');
        unlockScroll();
    }

    var bsClose    = document.getElementById('rp-bs-close');
    var bsBackdrop = document.getElementById('rp-bs-backdrop');
    if (bsClose)    bsClose.addEventListener('click', rpCloseBs);
    if (bsBackdrop) bsBackdrop.addEventListener('click', rpCloseBs);

    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        var bs = document.getElementById('rp-bottom-sheet');
        if (bs && bs.classList.contains('active')) rpCloseBs();
    });

}); /* end DOMContentLoaded */
</script>
