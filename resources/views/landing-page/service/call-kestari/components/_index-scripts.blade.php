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
        document.body.classList.add('ck-sheet-open');
        _touchBlock = function (e) {
            var sheet = document.getElementById('ck-bottom-sheet');
            if (sheet && sheet.contains(e.target)) return;
            e.preventDefault();
        };
        window.addEventListener('touchmove', _touchBlock, { passive: false });
        if (btt) { btt.style.opacity = '0'; btt.style.visibility = 'hidden'; }
    }
    function unlockScroll() {
        document.documentElement.style.overflow = '';
        document.body.classList.remove('ck-sheet-open');
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
            customClass: { container: 'ck-swal-above-sheet' }
        });
    }


    /* ============================================================
       SHARE HELPERS  (exposed globally for desktop card buttons)
       ============================================================ */
    window.ckCopyUrl = function (url, ev) {
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
    window.ckShareWa = function (url, name, ev) {
        if (ev) ev.stopPropagation();
        var full = (url && url.indexOf('http') === 0) ? url : window.location.origin + url;
        var text = (name ? name + ' — LDK Syahid\n' : '') + full;
        window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank');
    };


    /* ============================================================
       MOBILE BOTTOM SHEET
       ============================================================ */
    window.ckOpenSheet = function (el) {
        var content = document.getElementById('ck-bs-content');
        if (!content) return;

        var name        = el.dataset.name        || '';
        var link        = el.dataset.link        || '';
        var icon        = el.dataset.icon        || 'fas fa-external-link-alt';
        var displayLink = el.dataset.displayLink || link;

        content.innerHTML =
            '<div class="ck-bs-icon-wrap">' +
                '<div class="ck-bs-drag-handle"></div>' +
                '<div class="ck-bs-icon"><i class="' + escHtml(icon) + '"></i></div>' +
            '</div>' +
            '<div class="ck-bs-info">' +
                '<h5 class="ck-bs-name">' + escHtml(name) + '</h5>' +
                (displayLink ? '<p class="ck-bs-link">' + escHtml(displayLink) + '</p>' : '') +
                '<a href="' + escHtml(link) + '" target="_blank" rel="noopener" class="ck-bs-cta">' +
                    '<i class="fas fa-arrow-right"></i><span>Buka Tautan</span>' +
                '</a>' +
                '<div class="ck-bs-share-wrap">' +
                    '<div class="ck-bs-share-label">Bagikan</div>' +
                    '<div class="ck-bs-share-row">' +
                        '<button class="ck-bs-share-btn ck-bs-share-copy _ck-copy-btn">' +
                            '<i class="fas fa-link"></i><span>Salin URL</span>' +
                        '</button>' +
                        '<button class="ck-bs-share-btn ck-bs-share-wa _ck-wa-btn">' +
                            '<i class="fab fa-whatsapp"></i><span>WhatsApp</span>' +
                        '</button>' +
                    '</div>' +
                '</div>' +
            '</div>';

        /* Wire share buttons */
        var copyBtn = content.querySelector('._ck-copy-btn');
        var waBtn   = content.querySelector('._ck-wa-btn');
        if (copyBtn) copyBtn.addEventListener('click', function (e) {
            e.stopPropagation(); ckCopyUrl(link);
        });
        if (waBtn) waBtn.addEventListener('click', function (e) {
            e.stopPropagation(); ckShareWa(link, name);
        });

        document.getElementById('ck-bottom-sheet').scrollTop = 0;
        document.getElementById('ck-bs-backdrop').classList.add('active');
        document.getElementById('ck-bottom-sheet').classList.add('active');
        lockScroll();
    };

    function ckCloseSheet() {
        document.getElementById('ck-bs-backdrop').classList.remove('active');
        document.getElementById('ck-bottom-sheet').classList.remove('active');
        unlockScroll();
    }

    var bsClose    = document.getElementById('ck-bs-close');
    var bsBackdrop = document.getElementById('ck-bs-backdrop');
    if (bsClose)    bsClose.addEventListener('click', ckCloseSheet);
    if (bsBackdrop) bsBackdrop.addEventListener('click', ckCloseSheet);

    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        var bs = document.getElementById('ck-bottom-sheet');
        if (bs && bs.classList.contains('active')) ckCloseSheet();
    });


    /* ============================================================
       AJAX SEARCH / SORT / PAGINATION
       ============================================================ */
    var BASE_URL    = document.getElementById('ck-base-url') ? document.getElementById('ck-base-url').value : '/callkestari';
    var currentSort = document.getElementById('ck-sort-val') ? document.getElementById('ck-sort-val').value : 'newest';

    function ckBuildUrl() {
        var params   = new URLSearchParams();
        var searchEl = document.getElementById('ck-search-input');
        var search   = searchEl ? searchEl.value.trim() : '';
        if (search) params.set('search', search);
        if (currentSort && currentSort !== 'newest') params.set('sort', currentSort);
        var q = params.toString();
        return BASE_URL + (q ? '?' + q : '');
    }

    function ckLoad(url) {
        var wrap      = document.getElementById('ck-cards-wrap');
        var pgnWrap   = document.getElementById('ck-pagination-wrap');
        var resultsEl = document.getElementById('ck-results-info');
        var searchEl  = document.getElementById('ck-search-input');
        var section   = document.getElementById('ck-main-section');

        if (wrap) wrap.classList.add('ck-cards-out');

        if (section) {
            window.scrollTo({ top: section.getBoundingClientRect().top + window.scrollY - 90, behavior: 'smooth' });
        }

        var minDelay  = new Promise(function (res) { setTimeout(res, 350); });
        var fetchData = fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                            .then(function (r) { return r.json(); });

        Promise.all([fetchData, minDelay])
            .then(function (results) {
                var json = results[0];

                if (wrap) {
                    wrap.innerHTML = json.cards;
                    requestAnimationFrame(function () {
                        requestAnimationFrame(function () {
                            wrap.classList.remove('ck-cards-out');
                        });
                    });
                }
                if (pgnWrap) { pgnWrap.innerHTML = json.pagination || ''; }

                if (resultsEl) {
                    if (json.total > 0) {
                        var info    = 'Menampilkan <strong>' + json.from + '–' + json.to + '</strong>' +
                                      ' dari <strong>' + json.total + '</strong> tautan';
                        var keyword = searchEl ? searchEl.value.trim() : '';
                        if (keyword) info += ' untuk "<em>' + escHtml(keyword) + '</em>"';
                        resultsEl.innerHTML = info;
                    } else {
                        resultsEl.innerHTML = 'Tidak ada tautan yang ditemukan';
                    }
                }
            })
            .catch(function () {
                if (wrap) wrap.classList.remove('ck-cards-out');
            });
    }

    /* Pagination — event delegation (no rebind needed) */
    document.addEventListener('click', function (e) {
        var link = e.target.closest('#ck-pagination-wrap a.pgn-nav, #ck-pagination-wrap a.pgn-num');
        if (!link) return;
        e.preventDefault();
        ckLoad(link.href);
    });

    /* Search with debounce */
    var _searchTimer;
    var searchInput = document.getElementById('ck-search-input');
    var searchClear = document.getElementById('ck-search-clear');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            if (searchClear) searchClear.style.display = this.value ? 'flex' : 'none';
            clearTimeout(_searchTimer);
            _searchTimer = setTimeout(function () { ckLoad(ckBuildUrl()); }, 420);
        });
    }
    if (searchClear) {
        searchClear.addEventListener('click', function () {
            if (searchInput) { searchInput.value = ''; searchInput.focus(); }
            this.style.display = 'none';
            ckLoad(ckBuildUrl());
        });
    }

    /* Sort change */
    document.querySelectorAll('.sfb-sort-item[data-sort-prefix="ck"]').forEach(function (item) {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            currentSort = this.dataset.sort;
            document.querySelectorAll('.sfb-sort-item[data-sort-prefix="ck"]').forEach(function (i) {
                i.classList.remove('active');
            });
            this.classList.add('active');
            var sortVal = document.getElementById('ck-sort-val');
            if (sortVal) sortVal.value = currentSort;
            ckLoad(ckBuildUrl());
        });
    });

}); /* end DOMContentLoaded */
</script>
