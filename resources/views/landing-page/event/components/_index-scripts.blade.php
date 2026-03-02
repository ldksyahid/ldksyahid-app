@include('components.hero-jumbotron.scripts')

{{-- ── Select2 JS ── --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
/* ================================================================
   EVENT INDEX PAGE — prefix: ev-
   ================================================================ */
document.addEventListener('DOMContentLoaded', function () {

    /* ─── Select2 init ────────────────────────────────────────── */
    if (typeof $.fn.select2 !== 'undefined') {
        $('#ev-division-select, #ev-year-select').select2({
            placeholder: 'Pilih...',
            allowClear: true,
            width: '100%',
        });
    }

    /* ─── HTML escape helper ─────────────────────────────────── */
    function escHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g,'&amp;').replace(/</g,'&lt;')
            .replace(/>/g,'&gt;').replace(/"/g,'&quot;')
            .replace(/'/g,'&#039;');
    }

    /* ─── Scroll lock/unlock ─────────────────────────────────── */
    var _scrollY = 0;
    function lockScroll() {
        _scrollY = window.scrollY;
        document.documentElement.style.overflow = 'hidden';
        /* hide back-to-top */
        var btt = document.querySelector('.back-to-top');
        if (btt) btt.style.cssText = 'opacity:0 !important; pointer-events:none !important; transition:opacity .3s ease;';
    }
    function unlockScroll() {
        document.documentElement.style.overflow = '';
        window.scrollTo({ top: _scrollY, left: 0, behavior: 'instant' });
        /* restore back-to-top */
        var btt = document.querySelector('.back-to-top');
        if (btt) btt.style.cssText = '';
    }

    /* ─── Filter badge counter ───────────────────────────────── */
    function updateFilterBadge() {
        var count = 0;
        $('#ev-division-select').val() && count++;
        $('#ev-year-select').val() && count++;
        var badge = document.getElementById('ev-filter-badge');
        if (badge) {
            badge.textContent = count || '';
            badge.style.display = count ? 'flex' : 'none';
        }
        var filterBtn = document.getElementById('ev-filter-btn');
        if (filterBtn) {
            filterBtn.classList.toggle('sfb-btn--active', count > 0);
        }
    }

    /* ─── Active filter pills ────────────────────────────────── */
    function buildPills() {
        var pillsWrap = document.getElementById('ev-pills-wrap');
        if (!pillsWrap) return;
        pillsWrap.innerHTML = '';

        function addPills(selectId, label) {
            var vals = $('#' + selectId).val() || [];
            vals.forEach(function (v) {
                var pill = document.createElement('span');
                pill.className = 'sfb-pill';
                pill.dataset.selectId = selectId;
                pill.dataset.value = v;
                pill.innerHTML = '<span>' + label + ': ' + escHtml(v) + '</span><i class="fas fa-times"></i>';
                pill.querySelector('i').addEventListener('click', function () {
                    removePillValue(selectId, v);
                });
                pillsWrap.appendChild(pill);
            });
        }
        addPills('ev-division-select', 'Divisi');
        addPills('ev-year-select', 'Tahun');
    }

    function removePillValue(selectId, value) {
        var $sel = $('#' + selectId);
        var vals = $sel.val() || [];
        vals = vals.filter(function (v) { return v !== value; });
        $sel.val(vals).trigger('change');
        updateFilterBadge();
        buildPills();
    }

    /* ─── Build URL from current state ──────────────────────── */
    function buildUrl(page) {
        var base   = document.getElementById('ev-base-url').value;
        var search = document.getElementById('ev-search-input') ? document.getElementById('ev-search-input').value.trim() : '';
        var sort   = document.getElementById('ev-sort-val').value;
        var params = [];

        if (search) params.push('search=' + encodeURIComponent(search));

        var divVals = $('#ev-division-select').val() || [];
        divVals.forEach(function (v) { params.push('division[]=' + encodeURIComponent(v)); });

        var yearVals = $('#ev-year-select').val() || [];
        yearVals.forEach(function (v) { params.push('year[]=' + encodeURIComponent(v)); });

        if (sort && sort !== 'newest') params.push('sort=' + encodeURIComponent(sort));
        if (page && page > 1) params.push('page=' + page);

        return base + (params.length ? '?' + params.join('&') : '');
    }

    /* ─── Load cards via AJAX ────────────────────────────────── */
    var _ajaxReq = null;
    function loadEvents(url, pushState) {
        var wrap = document.getElementById('ev-cards-wrap');
        if (!wrap) return;
        wrap.classList.add('ev-page-transitioning');

        if (_ajaxReq) _ajaxReq.abort();
        _ajaxReq = $.ajax({
            url: url,
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function (html) {
                wrap.innerHTML = html;
                wrap.classList.remove('ev-page-transitioning');
                if (pushState) history.pushState(null, '', url);
                bindPagination();
                initCarouselDots();
                updateResultsInfo();
            },
            error: function (xhr) {
                if (xhr.statusText !== 'abort') wrap.classList.remove('ev-page-transitioning');
            }
        });
    }

    /* ─── Results info (from pagination links) ───────────────── */
    function updateResultsInfo() {
        /* info is server-rendered on initial load; on AJAX it stays static */
    }

    /* ─── Pagination (event delegation) ─────────────────────── */
    function bindPagination() {
        document.querySelectorAll('.ev-pagination-wrap .pagination-custom a[data-page]').forEach(function (a) {
            a.addEventListener('click', function (e) {
                e.preventDefault();
                var page = this.dataset.page;
                var url  = buildUrl(page);
                loadEvents(url, true);
                window.scrollTo({ top: document.getElementById('ev-event-section').offsetTop - 80, behavior: 'smooth' });
            });
        });
    }
    bindPagination();

    /* ─── Search (debounced) ─────────────────────────────────── */
    var _searchTimer;
    var searchInput = document.getElementById('ev-search-input');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            clearTimeout(_searchTimer);
            _searchTimer = setTimeout(function () {
                loadEvents(buildUrl(1), true);
            }, 420);
        });
        var clearBtn = document.getElementById('ev-search-clear');
        if (clearBtn) {
            clearBtn.addEventListener('click', function () {
                searchInput.value = '';
                loadEvents(buildUrl(1), true);
            });
        }
    }

    /* ─── Filter apply ───────────────────────────────────────── */
    var applyBtn = document.getElementById('ev-filter-apply');
    if (applyBtn) {
        applyBtn.addEventListener('click', function () {
            updateFilterBadge();
            buildPills();
            loadEvents(buildUrl(1), true);
            /* close modal */
            var modal = document.getElementById('ev-filter-modal');
            if (modal) {
                unlockScroll();
                modal.classList.remove('sfb-fm--open');
                var backdrop = document.getElementById('ev-filter-modal-backdrop');
                if (backdrop) backdrop.classList.remove('sfb-fm-backdrop--open');
            }
        });
    }

    /* ─── Filter reset ───────────────────────────────────────── */
    var resetBtn = document.getElementById('ev-filter-reset');
    if (resetBtn) {
        resetBtn.addEventListener('click', function () {
            $('#ev-division-select, #ev-year-select').val(null).trigger('change');
            updateFilterBadge();
            buildPills();
        });
    }

    /* ─── Sort dropdown ──────────────────────────────────────── */
    document.querySelectorAll('[data-ev-sort]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('ev-sort-val').value = this.dataset.evSort;
            /* update label */
            var label = document.getElementById('ev-sort-label');
            if (label) label.textContent = this.textContent.trim();
            loadEvents(buildUrl(1), true);
        });
    });

    /* ─── Mobile carousel dots ───────────────────────────────── */
    function initCarouselDots() {
        var carousel = document.getElementById('ev-mobile-carousel');
        var dotsWrap = document.getElementById('ev-carousel-dots');
        if (!carousel || !dotsWrap) return;

        var cards = carousel.querySelectorAll('.ev-mobile-card');
        if (!cards.length) return;

        dotsWrap.innerHTML = '';
        cards.forEach(function (_, i) {
            var btn = document.createElement('button');
            btn.className = 'ev-dot' + (i === 0 ? ' active' : '');
            btn.setAttribute('aria-label', 'Slide ' + (i + 1));
            btn.addEventListener('click', function () {
                cards[i].scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            });
            dotsWrap.appendChild(btn);
        });

        carousel.addEventListener('scroll', function () {
            var scrollLeft = carousel.scrollLeft;
            var cardWidth  = cards[0].offsetWidth + parseFloat(getComputedStyle(carousel).gap || 0);
            var idx = Math.round(scrollLeft / cardWidth);
            dotsWrap.querySelectorAll('.ev-dot').forEach(function (d, i) {
                d.classList.toggle('active', i === idx);
            });
        }, { passive: true });
    }
    initCarouselDots();

    /* ─── Share functions ────────────────────────────────────── */
    function showToast(ok, msg) {
        if (typeof Swal === 'undefined') return;
        Swal.fire({
            toast: true, position: 'top-end',
            icon: ok ? 'success' : 'error',
            title: msg || (ok ? 'Berhasil!' : 'Gagal!'),
            showConfirmButton: false, timer: 2500, timerProgressBar: true,
            customClass: { container: 'ev-swal-below-nav' }
        });
    }

    window.evCopyUrl = function (url, ev) {
        if (ev) ev.stopPropagation();
        var full = window.location.origin + url;
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(full)
                .then(function () { showToast(true, 'URL berhasil disalin!'); })
                .catch(function () { showToast(false, 'Gagal menyalin URL'); });
        } else {
            var ta = document.createElement('textarea');
            ta.value = full; ta.style.cssText = 'position:fixed;top:0;left:0;opacity:0';
            document.body.appendChild(ta); ta.select(); document.execCommand('copy');
            document.body.removeChild(ta); showToast(true, 'URL berhasil disalin!');
        }
    };

    window.evShareWa = function (url, title, ev) {
        if (ev) ev.stopPropagation();
        var full = window.location.origin + url;
        var text = (title ? title + '\n' : '') + full;
        window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank');
    };

    window.evShareTw = function (url, title, ev) {
        if (ev) ev.stopPropagation();
        var full = window.location.origin + url;
        var text = (title ? title + ' — LDK Syahid\n' : '') + full;
        window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(text), '_blank');
    };

    /* ─── Mobile Bottom Sheet ────────────────────────────────── */
    var sheet    = document.getElementById('ev-bottom-sheet');
    var backdrop = document.getElementById('ev-bs-backdrop');
    var closeBtn = document.getElementById('ev-bs-close');
    var content  = document.getElementById('ev-bs-content');

    function evOpenBs() {
        if (!sheet) return;
        backdrop.classList.add('active');
        sheet.classList.add('open');
        lockScroll();
    }
    function evCloseBs() {
        if (!sheet) return;
        sheet.classList.remove('open');
        backdrop.classList.remove('active');
        unlockScroll();
    }

    if (closeBtn) closeBtn.addEventListener('click', evCloseBs);
    if (backdrop) backdrop.addEventListener('click', evCloseBs);
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && sheet && sheet.classList.contains('open')) evCloseBs();
    });

    window.evOpenBottomSheet = function (card) {
        if (!content) return;
        var id       = card.dataset.id;
        var title    = card.dataset.title;
        var division = card.dataset.division;
        var date     = card.dataset.date;
        var location = card.dataset.location;
        var status   = card.dataset.status;
        var statusCls= card.dataset.statusCls || '';
        var poster   = card.dataset.poster;
        var url      = card.dataset.url;
        var excerpt  = card.dataset.excerpt;

        var posterHtml = poster
            ? '<img src="' + escHtml(poster) + '" class="ev-bs-poster" alt="' + escHtml(title) + '">'
            : '';

        var metaRows = '';
        if (date && date !== '-')
            metaRows += '<div class="ev-bs-meta-row"><i class="far fa-calendar-alt"></i><span>' + escHtml(date) + '</span></div>';
        if (location && location !== '-')
            metaRows += '<div class="ev-bs-meta-row"><i class="fas fa-map-marker-alt"></i><span>' + escHtml(location) + '</span></div>';

        content.innerHTML =
            posterHtml +
            '<div class="ev-bs-status-row">' +
                '<span class="ev-card-status ' + escHtml(statusCls) + '" style="position:static">' + escHtml(status) + '</span>' +
                '<span class="ev-bs-division">' + escHtml(division) + '</span>' +
            '</div>' +
            '<div class="ev-bs-title">' + escHtml(title) + '</div>' +
            (metaRows ? '<div class="ev-bs-meta">' + metaRows + '</div>' : '') +
            (excerpt ? '<p class="ev-bs-excerpt">' + escHtml(excerpt) + '</p>' : '') +
            '<a href="' + escHtml(url) + '" class="ev-bs-detail-btn">' +
                '<i class="fas fa-calendar-check"></i> Lihat Detail Kegiatan' +
            '</a>' +
            '<div class="ev-bs-share">' +
                '<p class="ev-bs-share-title">Bagikan Kegiatan</p>' +
                '<div class="ev-bs-share-grid">' +
                    '<button class="ev-bs-share-btn ev-bs-share-btn--copy ev-bs-copy-btn">' +
                        '<span class="ev-bs-share-icon"><i class="fas fa-link"></i></span>' +
                        '<span class="ev-bs-share-lbl">Salin URL</span>' +
                    '</button>' +
                    '<button class="ev-bs-share-btn ev-bs-share-btn--wa ev-bs-wa-btn">' +
                        '<span class="ev-bs-share-icon"><i class="fab fa-whatsapp"></i></span>' +
                        '<span class="ev-bs-share-lbl">WhatsApp</span>' +
                    '</button>' +
                    '<button class="ev-bs-share-btn ev-bs-share-btn--tw ev-bs-tw-btn">' +
                        '<span class="ev-bs-share-icon"><span class="xi" style="font-size:1.3rem">X</span></span>' +
                        '<span class="ev-bs-share-lbl">X</span>' +
                    '</button>' +
                '</div>' +
            '</div>';

        /* Wire share buttons */
        var copyBtn = content.querySelector('.ev-bs-copy-btn');
        var waBtn   = content.querySelector('.ev-bs-wa-btn');
        var twBtn   = content.querySelector('.ev-bs-tw-btn');

        if (copyBtn) {
            copyBtn.addEventListener('click', function () {
                var btn = this;
                evCopyUrl(url);
                btn.classList.add('ev-bs-copied');
                btn.querySelector('.ev-bs-share-icon').innerHTML = '<i class="fas fa-check"></i>';
                btn.querySelector('.ev-bs-share-lbl').textContent = 'Tersalin!';
                setTimeout(function () {
                    btn.classList.remove('ev-bs-copied');
                    btn.querySelector('.ev-bs-share-icon').innerHTML = '<i class="fas fa-link"></i>';
                    btn.querySelector('.ev-bs-share-lbl').textContent = 'Salin URL';
                }, 2500);
            });
        }
        if (waBtn)   waBtn.addEventListener('click', function () { evShareWa(url, title); });
        if (twBtn)   twBtn.addEventListener('click', function () { evShareTw(url, title); });

        evOpenBs();
    };

});
</script>
