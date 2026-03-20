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
        document.body.classList.add('sv-sheet-open');
        _touchBlock = function (e) {
            var sheet = document.getElementById('sv-bottom-sheet');
            if (sheet && sheet.contains(e.target)) return;
            e.preventDefault();
        };
        window.addEventListener('touchmove', _touchBlock, { passive: false });
        if (btt) { btt.style.opacity = '0'; btt.style.visibility = 'hidden'; }
    }
    function unlockScroll() {
        document.body.classList.remove('sv-sheet-open');
        if (_touchBlock) {
            window.removeEventListener('touchmove', _touchBlock);
            _touchBlock = null;
        }
        if (btt) { btt.style.opacity = ''; btt.style.visibility = ''; }
    }


    /* ============================================================
       TOAST HELPER
       ============================================================ */
    function showCopyToast(ok) {
        if (typeof Swal === 'undefined') return;
        Swal.fire({
            toast: true, position: 'top-end',
            icon: ok ? 'success' : 'error',
            title: ok ? 'URL berhasil disalin!' : 'Gagal menyalin URL',
            showConfirmButton: false, timer: 2500, timerProgressBar: true,
            customClass: { container: 'sv-swal-above-sheet' }
        });
    }


    /* ============================================================
       SHARE HELPERS  (exposed globally for desktop card buttons)
       ============================================================ */
    window.svCopyUrl = function (url, ev) {
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
    window.svShareWa = function (url, title, ev) {
        if (ev) ev.stopPropagation();
        var full = (url && url.indexOf('http') === 0) ? url : window.location.origin + url;
        var text = (title ? title + ' — LDK Syahid\n' : '') + full;
        window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank');
    };


    /* ============================================================
       MOBILE BOTTOM SHEET
       ============================================================ */
    window.svOpenSheet = function (el) {
        var content = document.getElementById('sv-bs-content');
        if (!content) return;

        var title    = el.dataset.title    || '';
        var desc     = el.dataset.desc     || '';
        var image    = el.dataset.image    || '';
        var url      = el.dataset.url      || '';
        var accent   = el.dataset.accent   || '#00a79d';
        var label    = el.dataset.label    || 'Mulai';
        var disabled = el.dataset.disabled === '1';

        var imgHtml = image
            ? '<img src="https://lh3.googleusercontent.com/d/' + escHtml(image) + '" alt="' + escHtml(title) + '" class="sv-bs-img-photo" loading="lazy">'
            : '';

        var ctaHtml = disabled
            ? '<button class="sv-bs-cta sv-bs-cta-disabled" disabled>' +
                  '<i class="fas fa-clock"></i><span>' + escHtml(label) + '</span>' +
              '</button>'
            : '<a href="' + escHtml(url) + '" class="sv-bs-cta" target="_blank" rel="noopener"' +
                  ' style="background:' + escHtml(accent) + ';color:white;box-shadow:0 6px 24px ' + escHtml(accent) + '55;">' +
                  '<i class="fas fa-arrow-right"></i><span>' + escHtml(label) + '</span>' +
              '</a>';

        var shareHtml = (!disabled && url)
            ? '<div class="sv-bs-share-wrap">' +
                  '<div class="sv-bs-share-label">Bagikan</div>' +
                  '<div class="sv-bs-share-row">' +
                      '<button class="sv-bs-share-btn sv-bs-share-copy _sv-copy-btn"><i class="fas fa-link"></i><span>Salin URL</span></button>' +
                      '<button class="sv-bs-share-btn sv-bs-share-wa _sv-wa-btn"><i class="fab fa-whatsapp"></i><span>WhatsApp</span></button>' +
                  '</div>' +
              '</div>'
            : '';

        content.innerHTML =
            '<div class="sv-bs-img-wrap" style="background:' + escHtml(accent) + '14;">' +
                '<div class="sv-bs-drag-handle"></div>' +
                imgHtml +
            '</div>' +
            '<div class="sv-bs-info">' +
                '<h5 class="sv-bs-title">' + escHtml(title) + '</h5>' +
                (desc ? '<p class="sv-bs-desc">' + escHtml(desc) + '</p>' : '') +
                ctaHtml +
                shareHtml +
            '</div>';

        /* Wire share buttons */
        var copyBtn = content.querySelector('._sv-copy-btn');
        var waBtn   = content.querySelector('._sv-wa-btn');
        if (copyBtn) copyBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            svCopyUrl(url);
        });
        if (waBtn) waBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            svShareWa(url, title);
        });

        document.getElementById('sv-bottom-sheet').scrollTop = 0;
        document.getElementById('sv-bs-backdrop').classList.add('active');
        document.getElementById('sv-bottom-sheet').classList.add('active');
        lockScroll();
    };

    function svCloseSheet() {
        document.getElementById('sv-bs-backdrop').classList.remove('active');
        document.getElementById('sv-bottom-sheet').classList.remove('active');
        unlockScroll();
    }

    var bsClose    = document.getElementById('sv-bs-close');
    var bsBackdrop = document.getElementById('sv-bs-backdrop');
    if (bsClose)    bsClose.addEventListener('click', svCloseSheet);
    if (bsBackdrop) bsBackdrop.addEventListener('click', svCloseSheet);

    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        var bs = document.getElementById('sv-bottom-sheet');
        if (bs && bs.classList.contains('active')) svCloseSheet();
    });

}); /* end DOMContentLoaded */
</script>
