{{-- ── Hero Jumbotron scripts ── --}}
@include('components.hero-jumbotron.scripts')

{{-- ── Skeleton cards shared scripts ── --}}
@include('components.skeleton-cards.scripts')

{{-- ── Select2 JS ── --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ============================================================
       0. UTILITIES
       ============================================================ */
    function escHtml(str) {
        if (str == null) return '';
        return String(str)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;')
            .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    /* ── Bottom sheet scroll lock ── */
    var _cbTouchBlock = null;
    function cbLockScroll() {
        document.documentElement.style.overflow = 'hidden';
        document.body.classList.add('cb-sheet-open');
        _cbTouchBlock = function (e) {
            var sheet = document.getElementById('cb-bottom-sheet');
            if (sheet && sheet.contains(e.target)) return;
            e.preventDefault();
        };
        window.addEventListener('touchmove', _cbTouchBlock, { passive: false });
    }
    function cbUnlockScroll() {
        document.documentElement.style.overflow = '';
        document.body.classList.remove('cb-sheet-open');
        if (_cbTouchBlock) {
            window.removeEventListener('touchmove', _cbTouchBlock);
            _cbTouchBlock = null;
        }
    }

    /* ── Filter modal scroll lock ── */
    var _cbFmWheelLock = null, _cbFmKeyLock = null, _cbFmTouchBlock = null;
    function cbFmLockScroll() {
        _cbFmWheelLock = function(e) {
            if (e.target.closest('.sfb-fm-body')) return; /* allow scroll inside modal body */
            e.preventDefault();
        };
        _cbFmKeyLock = function(e) {
            var active = document.activeElement;
            if (active && active.closest('.sfb-fm-body')) return;
            if ([' ','ArrowUp','ArrowDown','PageUp','PageDown','Home','End'].includes(e.key))
                e.preventDefault();
        };
        window.addEventListener('wheel',   _cbFmWheelLock, { passive: false });
        window.addEventListener('keydown', _cbFmKeyLock);
    }
    function cbFmUnlockScroll() {
        if (_cbFmWheelLock) { window.removeEventListener('wheel',   _cbFmWheelLock); _cbFmWheelLock = null; }
        if (_cbFmKeyLock)   { window.removeEventListener('keydown', _cbFmKeyLock);   _cbFmKeyLock   = null; }
    }


    /* ============================================================
       1. CARD TAB SWITCHING  (event delegation — works after AJAX)
       ============================================================ */
    var cbCardsWrap = document.getElementById('cb-cards-wrap');
    if (cbCardsWrap) {
        cbCardsWrap.addEventListener('click', function (e) {
            var btn = e.target.closest('.cb-tab');
            if (!btn) return;
            e.stopPropagation();

            var nav           = btn.closest('.cb-tabs-nav');
            var tabsContainer = btn.closest('.cb-card-tabs');
            if (!nav || !tabsContainer) return;

            nav.querySelectorAll('.cb-tab').forEach(function (t) {
                t.classList.remove('active');
            });
            tabsContainer.querySelectorAll('.cb-tab-pane').forEach(function (p) {
                p.classList.remove('active');
            });

            btn.classList.add('active');
            var targetId   = btn.getAttribute('data-target');
            var targetPane = tabsContainer.querySelector('#' + targetId);
            if (targetPane) targetPane.classList.add('active');
        });
    }


    /* ============================================================
       2. SELECT2 INIT
       ============================================================ */
    if (typeof $.fn !== 'undefined' && typeof $.fn.select2 !== 'undefined') {
        var $filterSelects = $(
            '#cb-category-select, #cb-author-select, #cb-publisher-select, ' +
            '#cb-year-select, #cb-language-select, #cb-author-type-select, #cb-availability-select'
        );
        $filterSelects.each(function () {
            $(this).select2({
                placeholder: 'Semua',
                allowClear: true,
                width: '100%',
                dropdownParent: $('#cb-filter-modal'),
            });
        });
        $(window).on('scroll', function () { $filterSelects.select2('close'); });
    }


    /* ============================================================
       2. FILTER COUNT BADGE
       ============================================================ */
    var filterSelectIds = [
        'cb-category-select', 'cb-author-select', 'cb-publisher-select',
        'cb-year-select', 'cb-language-select', 'cb-author-type-select', 'cb-availability-select'
    ];

    /* ── Filter snapshot (restore on close without apply) ── */
    var _cbFilterSnapshot = {};
    var _cbApplied = false;

    function cbSnapshotFilters() {
        _cbFilterSnapshot = {};
        filterSelectIds.forEach(function (id) {
            var el = document.getElementById(id);
            if (!el) return;
            _cbFilterSnapshot[id] = Array.from(el.selectedOptions).map(function (o) { return o.value; });
        });
    }

    function cbRestoreFilters() {
        filterSelectIds.forEach(function (id) {
            var el = document.getElementById(id);
            if (!el) return;
            var vals = _cbFilterSnapshot[id] || [];
            for (var i = 0; i < el.options.length; i++) {
                el.options[i].selected = vals.indexOf(el.options[i].value) !== -1;
            }
            if (typeof $ !== 'undefined') $(el).trigger('change');
        });
    }

    function updateFilterBadge() {
        var count = 0;
        filterSelectIds.forEach(function (id) {
            var el = document.getElementById(id);
            if (el && el.selectedOptions) count += el.selectedOptions.length;
        });
        var badge    = document.getElementById('cb-filter-count');
        var clearBtn = document.getElementById('cb-filter-clear');
        if (badge)    { badge.textContent = count; badge.style.display = count > 0 ? 'flex' : 'none'; }
        if (clearBtn) { clearBtn.style.display = count > 0 ? 'flex' : 'none'; }
    }

    /* Filter modal backdrop */
    var filterModal = document.getElementById('cb-filter-modal');
    var fmBackdrop  = document.getElementById('cb-fm-backdrop');

    if (filterModal) {
        filterModal.addEventListener('show.bs.modal', function () {
            cbSnapshotFilters();
            _cbApplied = false;
            updateFilterBadge();
            if (fmBackdrop) fmBackdrop.classList.add('active');
            cbFmLockScroll();
            _cbFmTouchBlock = function (e) {
                if (!e.target.closest('.sfb-fm-body')) e.preventDefault();
            };
            window.addEventListener('touchmove', _cbFmTouchBlock, { passive: false, capture: true });
        });
        filterModal.addEventListener('hidden.bs.modal', function () {
            if (!_cbApplied) {
                cbRestoreFilters();
                updateFilterBadge();
            }
            _cbApplied = false;
            if (fmBackdrop) fmBackdrop.classList.remove('active');
            cbFmUnlockScroll();
            if (_cbFmTouchBlock) {
                window.removeEventListener('touchmove', _cbFmTouchBlock, { capture: true });
                _cbFmTouchBlock = null;
            }
        });
    }
    if (fmBackdrop) {
        fmBackdrop.addEventListener('click', function () {
            var modal = bootstrap.Modal.getInstance(filterModal);
            if (modal) modal.hide();
        });
    }


    /* ============================================================
       3. BUILD URL FROM FORM STATE
       ============================================================ */
    function cbBuildUrl(page) {
        var params = new URLSearchParams();

        var searchEl = document.getElementById('cb-search-input');
        var search   = searchEl ? searchEl.value.trim() : '';
        if (search) params.set('search', search);

        var fieldMap = {
            'cb-category-select':     'category',
            'cb-author-select':       'author',
            'cb-publisher-select':    'publisher',
            'cb-year-select':         'year',
            'cb-language-select':     'language',
            'cb-author-type-select':  'author_type',
            'cb-availability-select': 'availability',
        };
        Object.keys(fieldMap).forEach(function (id) {
            var el = document.getElementById(id);
            if (!el || !el.selectedOptions) return;
            Array.from(el.selectedOptions).forEach(function (opt) {
                params.append(fieldMap[id] + '[]', opt.value);
            });
        });

        var sortEl = document.getElementById('cb-sort-val');
        var sort   = sortEl ? sortEl.value : 'newest';
        if (sort && sort !== 'newest') params.set('sort', sort);

        if (page && page > 1) params.set('page', page);

        var base = document.getElementById('cb-base-url').value;
        var qs   = params.toString();
        return base + (qs ? '?' + qs : '');
    }


    /* ============================================================
       4. ACTIVE FILTER PILLS (JS-driven)
       ============================================================ */
    var pillFieldMap = {
        'cb-category-select':     'Kategori',
        'cb-author-select':       'Penulis',
        'cb-publisher-select':    'Penerbit',
        'cb-year-select':         'Tahun',
        'cb-language-select':     'Bahasa',
        'cb-author-type-select':  'Kat. Penulis',
        'cb-availability-select': 'Ketersediaan',
    };

    function buildActivePills() {
        var container = document.getElementById('cb-active-pills');
        if (!container) return;
        container.innerHTML = '';

        Object.keys(pillFieldMap).forEach(function (id) {
            var el = document.getElementById(id);
            if (!el) return;
            Array.from(el.selectedOptions).forEach(function (opt) {
                var pill = document.createElement('span');
                pill.className = 'sfb-pill';
                pill.innerHTML =
                    '<span>' + escHtml(pillFieldMap[id]) + ': ' + escHtml(opt.text) + '</span>' +
                    ' <i class="fas fa-times"></i>';
                pill.dataset.selectId = id;
                pill.dataset.value    = opt.value;

                var icon = pill.querySelector('i');
                if (icon) {
                    icon.addEventListener('click', function () {
                        var p   = this.closest('.sfb-pill');
                        var sel = document.getElementById(p.dataset.selectId);
                        if (!sel) return;
                        for (var i = 0; i < sel.options.length; i++) {
                            if (sel.options[i].value === p.dataset.value) sel.options[i].selected = false;
                        }
                        if (typeof $ !== 'undefined') $(sel).trigger('change');
                        updateFilterBadge();
                        buildActivePills();
                        cbLoadPage(cbBuildUrl());
                    });
                }
                container.appendChild(pill);
            });
        });
    }


    /* ============================================================
       5. AJAX LOAD PAGE
       ============================================================ */
    var FADE = 320; /* ms — harus <= CSS transition duration (350ms) */

    function cbFadeOut(el) {
        return new Promise(function (resolve) {
            el.classList.add('cb-cards-out');
            setTimeout(resolve, FADE);
        });
    }

    function cbFadeIn(el) {
        requestAnimationFrame(function () {
            requestAnimationFrame(function () {
                el.classList.remove('cb-cards-out');
            });
        });
    }

    function cbLoadPage(url) {
        var wrap    = document.getElementById('cb-cards-wrap');
        var section = document.getElementById('cb-book-section');

        if (section) {
            var top = section.getBoundingClientRect().top + window.scrollY - 90;
            window.scrollTo({ top: top, behavior: 'smooth' });
        }

        var fetchData = fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                            .then(function (r) { return r.json(); });

        /* Phase 1 — fade out current content → show skeleton */
        var skeletonShown = wrap
            ? cbFadeOut(wrap).then(function () {
                wrap.innerHTML = buildSkeleton('book', 4, 3);
                cbFadeIn(wrap);
              })
            : Promise.resolve();

        /* Phase 2 — wait: data ready + skeleton visible at least 400ms */
        var minSkeleton = new Promise(function (res) { setTimeout(res, FADE + 400); });

        Promise.all([fetchData, skeletonShown, minSkeleton])
            .then(function (results) {
                var data = results[0];
                if (!wrap) return;

                /* Phase 3 — fade out skeleton → show real content */
                cbFadeOut(wrap).then(function () {
                    wrap.innerHTML = data.html;
                    cbFadeIn(wrap);

                    var info = document.getElementById('cb-results-info');
                    if (info) {
                        if (data.total > 0) {
                            info.innerHTML =
                                'Menampilkan <strong>' + data.from + '–' + data.to + '</strong>' +
                                ' dari <strong>' + data.total + '</strong> buku';
                        } else {
                            info.innerHTML = 'Tidak ada buku yang ditemukan';
                        }
                    }

                    initCarouselDots();
                });
            })
            .catch(function () {
                if (wrap) {
                    wrap.classList.remove('cb-cards-out');
                }
                window.location.href = url;
            });
    }


    /* ============================================================
       6. AJAX PAGINATION
       ============================================================ */
    document.addEventListener('click', function (e) {
        var link = e.target.closest('#cb-cards-wrap .pgn-nav[href], #cb-cards-wrap .pgn-num[href]');
        if (!link) return;
        e.preventDefault();
        cbLoadPage(link.href);
    });


    /* ============================================================
       7. SEARCH — debounced AJAX
       ============================================================ */
    var searchInput = document.getElementById('cb-search-input');
    var searchClear = document.getElementById('cb-search-clear');
    var searchTimer = null;

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            if (searchClear) searchClear.style.display = this.value ? 'flex' : 'none';
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function () { cbLoadPage(cbBuildUrl()); }, 420);
        });
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(searchTimer);
                cbLoadPage(cbBuildUrl());
            }
        });
        if (searchClear) searchClear.style.display = searchInput.value ? 'flex' : 'none';
    }

    if (searchClear) {
        searchClear.addEventListener('click', function () {
            if (searchInput) { searchInput.value = ''; this.style.display = 'none'; }
            clearTimeout(searchTimer);
            cbLoadPage(cbBuildUrl());
        });
    }


    /* ============================================================
       8. FILTER APPLY / RESET
       ============================================================ */
    var applyBtn = document.getElementById('cb-apply-filter');
    if (applyBtn) {
        applyBtn.addEventListener('click', function () {
            _cbApplied = true;
            var modal = bootstrap.Modal.getInstance(document.getElementById('cb-filter-modal'));
            if (modal) modal.hide();
            updateFilterBadge();
            buildActivePills();
            cbLoadPage(cbBuildUrl());
        });
    }

    function cbClearAllFilters() {
        filterSelectIds.forEach(function (id) {
            var el = document.getElementById(id);
            if (!el) return;
            for (var i = 0; i < el.options.length; i++) el.options[i].selected = false;
            if (typeof $ !== 'undefined') $(el).trigger('change');
        });
        updateFilterBadge();
    }

    var resetBtn = document.getElementById('cb-reset-filter');
    if (resetBtn) resetBtn.addEventListener('click', cbClearAllFilters);

    var filterClearBtn = document.getElementById('cb-filter-clear');
    if (filterClearBtn) {
        filterClearBtn.addEventListener('click', function () {
            cbClearAllFilters();
            buildActivePills();
            cbLoadPage(cbBuildUrl());
        });
    }


    /* ============================================================
       9. SORT DROPDOWN
       ============================================================ */
    document.querySelectorAll('[data-sort][data-sort-prefix="cb"]').forEach(function (el) {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            var val    = this.dataset.sort;
            var sortEl = document.getElementById('cb-sort-val');
            if (sortEl) sortEl.value = val;
            document.querySelectorAll('[data-sort][data-sort-prefix="cb"]').forEach(function (s) {
                s.classList.toggle('active', s.dataset.sort === val);
            });
            cbLoadPage(cbBuildUrl());
        });
    });


    /* ============================================================
       10. MOBILE CAROUSEL DOTS
       ============================================================ */
    function initCarouselDots() {
        var carousel = document.getElementById('cb-mobile-carousel');
        var dotsWrap = document.getElementById('cb-carousel-dots');
        if (!carousel || !dotsWrap) return;

        var cards = carousel.querySelectorAll('.cb-mobile-card');
        dotsWrap.innerHTML = '';

        if (cards.length <= 1) { dotsWrap.style.display = 'none'; return; }
        dotsWrap.style.display = 'flex';

        var dots = [];
        cards.forEach(function (card, i) {
            var dot = document.createElement('button');
            dot.className = 'cb-dot' + (i === 0 ? ' active' : '');
            dot.title = 'Buku ' + (i + 1);
            dot.addEventListener('click', function () {
                card.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
            });
            dotsWrap.appendChild(dot);
            dots.push(dot);
        });

        var obs = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                var idx = Array.from(cards).indexOf(entry.target);
                dots.forEach(function (d, i) { d.classList.toggle('active', i === idx); });
            });
        }, { root: carousel, threshold: 0.55 });

        cards.forEach(function (c) { obs.observe(c); });
    }
    initCarouselDots();


    /* ============================================================
       11. SHARE FUNCTIONS (exposed globally)
       ============================================================ */
    function showCopyToast(ok) {
        if (typeof Swal === 'undefined') return;
        Swal.fire({
            toast: true, position: 'top-end',
            icon: ok ? 'success' : 'error',
            title: ok ? 'URL berhasil disalin!' : 'Gagal menyalin URL',
            showConfirmButton: false, timer: 2500, timerProgressBar: true,
            customClass: { container: 'cb-swal-above-sheet' }
        });
    }

    window.cbCopyUrl = function (url, ev) {
        if (ev) ev.stopPropagation();
        var full = (url && url.indexOf('http') === 0) ? url : window.location.origin + url;
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(full).then(
                function () { showCopyToast(true); },
                function () { showCopyToast(false); }
            );
        } else {
            try {
                var ta = document.createElement('textarea');
                ta.value = full;
                ta.style.cssText = 'position:fixed;top:0;left:0;opacity:0;pointer-events:none;';
                document.body.appendChild(ta); ta.select(); document.execCommand('copy');
                document.body.removeChild(ta); showCopyToast(true);
            } catch (e) { showCopyToast(false); }
        }
    };

    window.cbShareWa = function (url, title, ev) {
        if (ev) ev.stopPropagation();
        var full = (url && url.indexOf('http') === 0) ? url : window.location.origin + url;
        var text = (title ? title + '\n' : '') + full;
        window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank');
    };


    /* ============================================================
       12. MOBILE BOTTOM SHEET
       ============================================================ */
    window.cbOpenBottomSheet = function (el) {
        var content = document.getElementById('cb-bs-content');
        if (!content) return;

        var title        = el.dataset.title        || '';
        var author       = el.dataset.author       || '';
        var authorType   = el.dataset.authorType   || '';
        var publisher    = el.dataset.publisher    || '';
        var year         = el.dataset.year         || '';
        var edition      = el.dataset.edition      || '';
        var isbn         = el.dataset.isbn         || '';
        var pages        = el.dataset.pages        || '';
        var likes        = el.dataset.likes        || '0';
        var date         = el.dataset.date         || '';
        var category     = el.dataset.category     || '';
        var language     = el.dataset.language     || '';
        var availability = el.dataset.availability || '';
        var synopsis     = el.dataset.synopsis     || '';
        var cover        = el.dataset.cover        || '';
        var url          = el.dataset.url          || '#';
        var spine        = el.dataset.spine        || 'var(--cb-primary)';
        var isPrem       = el.dataset.prem         === '1';
        var isNew        = el.dataset.new          === '1';

        /* ── Cover ── */
        var imgHtml = cover
            ? '<img src="' + escHtml(cover) + '" alt="' + escHtml(title) + '" class="cb-bs-cover-img" loading="lazy">'
            : '<div class="cb-bs-cover-fallback"><i class="fas fa-book-open"></i></div>';

        /* ── Spec rows helper ── */
        function specRow(label, val) {
            if (!val) return '';
            return '<div class="cb-bs-spec-row">' +
                '<span class="cb-bs-spec-lbl">' + escHtml(label) + '</span>' +
                '<span class="cb-bs-spec-val">' + val + '</span>' +
                '</div>';
        }
        var specRowsHtml =
            specRow('Judul',           escHtml(title)) +
            specRow('Penulis',         escHtml(author)) +
            (authorType ? specRow('Kategori Penulis', escHtml(authorType)) : '') +
            specRow('Penerbit',        escHtml(publisher)) +
            specRow('Tahun Terbit',    escHtml(year)) +
            (edition ? specRow('Edisi', escHtml(edition)) : '') +
            (isbn    ? specRow('ISBN',  escHtml(isbn))    : '') +
            specRow('Bahasa',          escHtml(language)) +
            (pages   ? specRow('Jumlah Halaman', escHtml(pages) + ' halaman') : '') +
            specRow('Ketersediaan',    escHtml(availability)) +
            '<div class="cb-bs-spec-row">' +
                '<span class="cb-bs-spec-lbl">Disukai</span>' +
                '<span class="cb-bs-spec-val"><i class="fas fa-heart" style="color:#ef4444;margin-right:.3rem;font-size:.7rem;"></i>' + escHtml(likes) + '</span>' +
            '</div>';

        /* ── Tabs: show Sinopsis tab only if synopsis exists ── */
        var hasSyn = synopsis.trim().length > 0;
        var tabsHtml =
            '<div class="cb-bs-tabs">' +
                '<div class="cb-bs-tabs-nav">' +
                    '<button class="cb-bs-tab active" data-bst="cb-bst-spec">Spesifikasi</button>' +
                    (hasSyn ? '<button class="cb-bs-tab" data-bst="cb-bst-syn">Sinopsis</button>' : '') +
                '</div>' +
                '<div class="cb-bs-tab-pane active" id="cb-bst-spec">' +
                    '<div class="cb-bs-spec-list">' + specRowsHtml + '</div>' +
                '</div>' +
                (hasSyn ?
                    '<div class="cb-bs-tab-pane" id="cb-bst-syn">' +
                        '<p class="cb-bs-synopsis">' + escHtml(synopsis) + '</p>' +
                    '</div>'
                : '') +
            '</div>';

        /* ── Full HTML ── */
        content.innerHTML =
            /* Cover area */
            '<div class="cb-bs-cover-wrap">' +
                '<div class="cb-bs-drag-handle"></div>' +
                imgHtml +
                '<div class="cb-bs-cover-gradient"></div>' +
                (isPrem ? '<span class="cb-bs-prem-badge"><i class="fas fa-crown"></i> Premium</span>' : '') +
                (isNew  ? '<span class="cb-bs-new-badge-cover">Baru</span>' : '') +
            '</div>' +

            /* Info section */
            '<div class="cb-bs-info">' +

                /* Top row: category + meta */
                '<div class="cb-bs-top-row">' +
                    (category ?
                        '<span class="cb-bs-cat" style="background:color-mix(in srgb,' + escHtml(spine) + ' 15%,white);color:' + escHtml(spine) + ';">' +
                            '<i class="fas fa-tag" style="font-size:.6rem;"></i>' + escHtml(category) +
                        '</span>'
                    : '') +
                    '<div class="cb-bs-meta-row">' +
                        (date ? '<span class="cb-bs-meta-item"><i class="fas fa-calendar-alt"></i>' + escHtml(date) + '</span>' : '') +
                        '<span class="cb-bs-meta-item cb-bs-meta-likes"><i class="fas fa-heart"></i>' + escHtml(likes) + '</span>' +
                    '</div>' +
                '</div>' +

                /* Title */
                '<h5 class="cb-bs-title">' + escHtml(title) + '</h5>' +

                /* Author line */
                (author ?
                    '<p class="cb-bs-author">' +
                        '<i class="fas fa-user-edit" style="font-size:.72rem;"></i>' +
                        escHtml(author) +
                        (authorType ? '<span class="cb-bs-author-type"> • ' + escHtml(authorType) + '</span>' : '') +
                    '</p>'
                : '') +

                /* Tabs */
                tabsHtml +

                /* CTA */
                '<a href="' + escHtml(url) + '" class="cb-bs-btn-primary">' +
                    '<i class="fas fa-book-open"></i><span>Lihat Detail Buku</span>' +
                '</a>' +

                /* Share */
                '<div class="cb-bs-share-wrap">' +
                    '<span class="cb-bs-share-label">Bagikan</span>' +
                    '<div class="cb-bs-share-row">' +
                        '<button class="cb-bs-share-btn cb-bs-share-copy cb-bs-copy-btn"><i class="fas fa-link"></i><span>Salin URL</span></button>' +
                        '<button class="cb-bs-share-btn cb-bs-share-wa  cb-bs-wa-btn" ><i class="fab fa-whatsapp"></i><span>WhatsApp</span></button>' +
                    '</div>' +
                '</div>' +

            '</div>'; /* /cb-bs-info */

        /* ── Wire tab switching ── */
        content.addEventListener('click', function (e) {
            var btn = e.target.closest('.cb-bs-tab');
            if (!btn) return;
            var nav = btn.closest('.cb-bs-tabs-nav');
            var tabs = btn.closest('.cb-bs-tabs');
            if (!nav || !tabs) return;
            nav.querySelectorAll('.cb-bs-tab').forEach(function (t) { t.classList.remove('active'); });
            tabs.querySelectorAll('.cb-bs-tab-pane').forEach(function (p) { p.classList.remove('active'); });
            btn.classList.add('active');
            var pane = tabs.querySelector('#' + btn.dataset.bst);
            if (pane) pane.classList.add('active');
        }, { once: false });

        /* ── Wire share buttons ── */
        var bsCopyBtn = content.querySelector('.cb-bs-copy-btn');
        var bsWaBtn   = content.querySelector('.cb-bs-wa-btn');
        if (bsCopyBtn) bsCopyBtn.addEventListener('click', function (e) {
            e.stopPropagation(); cbCopyUrl(url);
        });
        if (bsWaBtn) bsWaBtn.addEventListener('click', function (e) {
            e.stopPropagation(); cbShareWa(url, title);
        });

        document.getElementById('cb-bottom-sheet').scrollTop = 0;
        document.getElementById('cb-bs-backdrop').classList.add('active');
        document.getElementById('cb-bottom-sheet').classList.add('active');
        cbLockScroll();
    };

    function cbCloseBs() {
        document.getElementById('cb-bs-backdrop').classList.remove('active');
        document.getElementById('cb-bottom-sheet').classList.remove('active');
        cbUnlockScroll();
    }

    var bsClose    = document.getElementById('cb-bs-close');
    var bsBackdrop = document.getElementById('cb-bs-backdrop');
    if (bsClose)    bsClose.addEventListener('click', cbCloseBs);
    if (bsBackdrop) bsBackdrop.addEventListener('click', cbCloseBs);

    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        var bs = document.getElementById('cb-bottom-sheet');
        if (bs && bs.classList.contains('active')) cbCloseBs();
    });


    /* ============================================================
       13. INITIAL STATE — sync server-rendered pills
       ============================================================ */
    document.querySelectorAll('#cb-active-pills .sfb-pill[data-select-id]').forEach(function (pill) {
        var icon = pill.querySelector('i.fa-times');
        if (!icon) return;
        icon.addEventListener('click', function () {
            var p   = this.closest('.sfb-pill');
            var sel = document.getElementById(p.dataset.selectId);
            if (!sel) return;
            for (var i = 0; i < sel.options.length; i++) {
                if (sel.options[i].value === p.dataset.value) sel.options[i].selected = false;
            }
            if (typeof $ !== 'undefined') $(sel).trigger('change');
            updateFilterBadge();
            buildActivePills();
            cbLoadPage(cbBuildUrl());
        });
    });

    updateFilterBadge();

}); /* end DOMContentLoaded */
</script>
