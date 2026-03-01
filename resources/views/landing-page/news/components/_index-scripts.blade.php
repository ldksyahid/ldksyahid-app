{{-- ── Hero Jumbotron scripts ── --}}
@include('components.hero-jumbotron.scripts')

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

    var _scrollY = 0;
    function lockScroll() {
        _scrollY = window.scrollY;
        document.documentElement.style.overflow = 'hidden';
    }
    function unlockScroll() {
        document.documentElement.style.overflow = '';
        window.scrollTo({ top: _scrollY, left: 0, behavior: 'instant' });
    }

    var btt = document.querySelector('.back-to-top');
    function hideBtt() {
        if (btt) { btt.style.transition = 'opacity .3s,visibility .3s'; btt.style.opacity = '0'; btt.style.visibility = 'hidden'; }
    }
    function showBtt() {
        if (btt) { btt.style.opacity = ''; btt.style.visibility = ''; }
    }


    /* ============================================================
       1. SELECT2 INIT
       ============================================================ */
    if (typeof $.fn !== 'undefined' && typeof $.fn.select2 !== 'undefined') {
        var $filterSelects = $('#nw-publisher-select, #nw-reporter-select, #nw-editor-select, #nw-year-select');
        $filterSelects.each(function () {
            $(this).select2({
                placeholder: 'Semua',
                allowClear: true,
                width: '100%',
                dropdownParent: $('#nw-filter-modal'),
            });
        });
        $(window).on('scroll', function () { $filterSelects.select2('close'); });
    }


    /* ============================================================
       2. FILTER COUNT BADGE
       ============================================================ */
    function updateFilterBadge() {
        var count = 0;
        ['nw-publisher-select', 'nw-reporter-select', 'nw-editor-select', 'nw-year-select'].forEach(function (id) {
            var el = document.getElementById(id);
            if (el && el.selectedOptions) count += el.selectedOptions.length;
        });
        var badge    = document.getElementById('nw-filter-count');
        var clearBtn = document.getElementById('nw-filter-clear');
        if (badge)    { badge.textContent = count; badge.style.display = count > 0 ? 'flex' : 'none'; }
        if (clearBtn) { clearBtn.style.display = count > 0 ? 'flex' : 'none'; }
    }

    /* Custom blur backdrop for filter modal */
    var filterModal = document.getElementById('nw-filter-modal');
    var fmBackdrop  = document.getElementById('nw-fm-backdrop');
    var _fmScrollY  = 0;
    var _fmTouchBlock = null;

    function nwFmLockScroll() {
        _fmScrollY = window.scrollY;
        document.documentElement.style.overflow = 'hidden';
    }
    function nwFmUnlockScroll() {
        document.documentElement.style.overflow = '';
        window.scrollTo({ top: _fmScrollY, left: 0, behavior: 'instant' });
    }

    if (filterModal) {
        filterModal.addEventListener('show.bs.modal', function () {
            updateFilterBadge();
            if (fmBackdrop) fmBackdrop.classList.add('active');
            nwFmLockScroll();
            _fmTouchBlock = function (e) {
                if (!e.target.closest('.sfb-fm-body')) e.preventDefault();
            };
            window.addEventListener('touchmove', _fmTouchBlock, { passive: false, capture: true });
        });
        filterModal.addEventListener('hidden.bs.modal', function () {
            if (fmBackdrop) fmBackdrop.classList.remove('active');
            nwFmUnlockScroll();
            if (_fmTouchBlock) {
                window.removeEventListener('touchmove', _fmTouchBlock, { capture: true });
                _fmTouchBlock = null;
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
    function nwBuildUrl(page) {
        var params = new URLSearchParams();

        var searchEl = document.getElementById('nw-search-input');
        var search   = searchEl ? searchEl.value.trim() : '';
        if (search) params.set('search', search);

        var fieldMap = {
            'nw-publisher-select': 'publisher',
            'nw-reporter-select':  'reporter',
            'nw-editor-select':    'editor',
            'nw-year-select':      'year',
        };
        Object.keys(fieldMap).forEach(function (id) {
            var el = document.getElementById(id);
            if (!el || !el.selectedOptions) return;
            Array.from(el.selectedOptions).forEach(function (opt) {
                params.append(fieldMap[id] + '[]', opt.value);
            });
        });

        var sortEl = document.getElementById('nw-sort-val');
        var sort   = sortEl ? sortEl.value : 'newest';
        if (sort && sort !== 'newest') params.set('sort', sort);

        if (page && page > 1) params.set('page', page);

        var base = document.getElementById('nw-base-url').value;
        var qs   = params.toString();
        return base + (qs ? '?' + qs : '');
    }


    /* ============================================================
       4. ACTIVE FILTER PILLS (JS-driven)
       ============================================================ */
    function buildActivePills() {
        var container = document.getElementById('nw-active-pills');
        if (!container) return;
        container.innerHTML = '';

        var fieldMap = {
            'nw-publisher-select': 'Penerbit',
            'nw-reporter-select':  'Reporter',
            'nw-editor-select':    'Editor',
            'nw-year-select':      'Tahun',
        };

        Object.keys(fieldMap).forEach(function (id) {
            var el = document.getElementById(id);
            if (!el) return;
            Array.from(el.selectedOptions).forEach(function (opt) {
                var pill = document.createElement('span');
                pill.className = 'sfb-pill';
                pill.innerHTML =
                    '<span>' + escHtml(fieldMap[id]) + ': ' + escHtml(opt.text) + '</span>' +
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
                        updateFilterBadge(); buildActivePills();
                        nwLoadPage(nwBuildUrl());
                    });
                }
                container.appendChild(pill);
            });
        });
    }


    /* ============================================================
       5. AJAX LOAD PAGE
       ============================================================ */
    function nwLoadPage(url) {
        var wrap    = document.getElementById('nw-cards-wrap');
        var section = document.getElementById('nw-news-section');

        if (wrap) wrap.classList.add('nw-cards-out');

        if (section) {
            var top = section.getBoundingClientRect().top + window.scrollY - 90;
            window.scrollTo({ top: top, behavior: 'smooth' });
        }

        var minDelay  = new Promise(function (res) { setTimeout(res, 350); });
        var fetchData = fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                            .then(function (r) { return r.json(); });

        Promise.all([fetchData, minDelay])
            .then(function (results) {
                var data = results[0];

                if (wrap) {
                    wrap.innerHTML = data.html;
                    requestAnimationFrame(function () {
                        requestAnimationFrame(function () {
                            wrap.classList.remove('nw-cards-out');
                        });
                    });
                }

                var info = document.getElementById('nw-results-info');
                if (info) {
                    if (data.total > 0) {
                        info.innerHTML =
                            'Menampilkan <strong>' + data.from + '–' + data.to + '</strong>' +
                            ' dari <strong>' + data.total + '</strong> berita';
                    } else {
                        info.innerHTML = 'Tidak ada berita yang ditemukan';
                    }
                }

                initCarouselDots();
            })
            .catch(function () {
                if (wrap) wrap.classList.remove('nw-cards-out');
                window.location.href = url;
            });
    }


    /* ============================================================
       6. AJAX PAGINATION (click on pagination links inside wrap)
       ============================================================ */
    document.addEventListener('click', function (e) {
        var link = e.target.closest('#nw-cards-wrap .pgn-nav[href], #nw-cards-wrap .pgn-num[href]');
        if (!link) return;
        e.preventDefault();
        nwLoadPage(link.href);
    });


    /* ============================================================
       7. SEARCH — debounced AJAX
       ============================================================ */
    var searchInput = document.getElementById('nw-search-input');
    var searchClear = document.getElementById('nw-search-clear');
    var searchTimer = null;

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            if (searchClear) searchClear.style.display = this.value ? 'flex' : 'none';
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function () { nwLoadPage(nwBuildUrl()); }, 420);
        });
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault(); clearTimeout(searchTimer);
                nwLoadPage(nwBuildUrl());
            }
        });
        if (searchClear) searchClear.style.display = searchInput.value ? 'flex' : 'none';
    }
    if (searchClear) {
        searchClear.addEventListener('click', function () {
            if (searchInput) { searchInput.value = ''; this.style.display = 'none'; }
            clearTimeout(searchTimer);
            nwLoadPage(nwBuildUrl());
        });
    }


    /* ============================================================
       8. FILTER APPLY / RESET
       ============================================================ */
    var applyBtn = document.getElementById('nw-apply-filter');
    if (applyBtn) {
        applyBtn.addEventListener('click', function () {
            var modal = bootstrap.Modal.getInstance(document.getElementById('nw-filter-modal'));
            if (modal) modal.hide();
            updateFilterBadge(); buildActivePills();
            nwLoadPage(nwBuildUrl());
        });
    }

    function nwClearAllFilters() {
        ['nw-publisher-select', 'nw-reporter-select', 'nw-editor-select', 'nw-year-select'].forEach(function (id) {
            var el = document.getElementById(id);
            if (!el) return;
            for (var i = 0; i < el.options.length; i++) el.options[i].selected = false;
            if (typeof $ !== 'undefined') $(el).trigger('change');
        });
        updateFilterBadge();
    }

    var resetBtn = document.getElementById('nw-reset-filter');
    if (resetBtn) resetBtn.addEventListener('click', nwClearAllFilters);

    var filterClearBtn = document.getElementById('nw-filter-clear');
    if (filterClearBtn) {
        filterClearBtn.addEventListener('click', function () {
            nwClearAllFilters(); buildActivePills();
            nwLoadPage(nwBuildUrl());
        });
    }


    /* ============================================================
       9. SORT DROPDOWN
       ============================================================ */
    document.querySelectorAll('[data-sort][data-sort-prefix="nw"]').forEach(function (el) {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            var val    = this.dataset.sort;
            var sortEl = document.getElementById('nw-sort-val');
            if (sortEl) sortEl.value = val;
            document.querySelectorAll('[data-sort][data-sort-prefix="nw"]').forEach(function (s) {
                s.classList.toggle('active', s.dataset.sort === val);
            });
            nwLoadPage(nwBuildUrl());
        });
    });


    /* ============================================================
       10. MOBILE CAROUSEL — Scroll Snap Dots
       ============================================================ */
    function initCarouselDots() {
        var carousel = document.getElementById('nw-mobile-carousel');
        var dotsWrap = document.getElementById('nw-carousel-dots');
        if (!carousel || !dotsWrap) return;

        var cards = carousel.querySelectorAll('.nw-mobile-card');
        dotsWrap.innerHTML = '';

        if (cards.length <= 1) { dotsWrap.style.display = 'none'; return; }
        dotsWrap.style.display = 'flex';

        var dots = [];
        cards.forEach(function (card, i) {
            var dot = document.createElement('span');
            dot.className = 'nw-dot' + (i === 0 ? ' active' : '');
            dot.title = 'Berita ' + (i + 1);
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
       11. SHARE FUNCTIONS
       ============================================================ */
    window.nwCopyUrl = function (url, ev) {
        if (ev) ev.stopPropagation();
        var full = window.location.origin + url;
        function showToast(ok) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    toast: true, position: 'top-end',
                    icon: ok ? 'success' : 'error',
                    title: ok ? 'URL berhasil disalin!' : 'Gagal menyalin URL',
                    showConfirmButton: false, timer: 2500, timerProgressBar: true,
                    customClass: { container: 'nw-swal-below-nav' }
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

    window.nwShareWa = function (url, title, ev) {
        if (ev) ev.stopPropagation();
        var full = window.location.origin + url;
        var text = (title ? title + '\n' : '') + full;
        window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank');
    };

    window.nwShareTw = function (url, title, ev) {
        if (ev) ev.stopPropagation();
        var full = window.location.origin + url;
        var text = (title ? title + ' — LDK Syahid\n' : '') + full;
        window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(text), '_blank');
    };


    /* ============================================================
       12. MOBILE BOTTOM SHEET
       ============================================================ */
    window.nwOpenBottomSheet = function (el) {
        var content = document.getElementById('nw-bs-content');
        if (!content) return;

        var title     = el.dataset.title;
        var publisher = el.dataset.publisher;
        var date      = el.dataset.date;
        var reporter  = el.dataset.reporter;
        var editor    = el.dataset.editor;
        var image     = el.dataset.image;
        var url       = el.dataset.url;
        var excerpt   = el.dataset.excerpt;

        var imgSrc = image
            ? 'https://lh3.googleusercontent.com/d/' + escHtml(image)
            : 'https://lh3.googleusercontent.com/d/1STslQ7I3qeakz_Pu5ZY5V8RcsxxcrqOm';

        content.innerHTML =
            '<div class="nw-bs-img-wrap">' +
                '<div class="nw-bs-drag-handle"></div>' +
                '<img src="' + imgSrc + '" alt="' + escHtml(title) + '" class="nw-bs-img-photo" loading="lazy">' +
                '<div class="nw-bs-img-gradient"></div>' +
            '</div>' +
            '<div class="nw-bs-info">' +
                '<div class="nw-bs-publisher"><span class="nw-bs-publisher-dot"></span>' + escHtml(publisher) + '</div>' +
                '<h5 class="nw-bs-title">' + escHtml(title) + '</h5>' +
                (excerpt ? '<p style="font-size:.84rem;color:#6b7280;line-height:1.65;margin:0 0 1rem;">' + escHtml(excerpt) + '</p>' : '') +
                '<div class="nw-bs-metas">' +
                    '<div class="nw-bs-meta-item">' +
                        '<div class="nw-bs-meta-icon"><i class="far fa-calendar-alt"></i></div>' +
                        '<div class="nw-bs-meta-text">' +
                            '<span class="nw-bs-meta-label">Tanggal</span>' +
                            '<span class="nw-bs-meta-name">' + escHtml(date) + '</span>' +
                        '</div>' +
                    '</div>' +
                    '<div class="nw-bs-meta-item">' +
                        '<div class="nw-bs-meta-icon"><i class="fas fa-user-edit"></i></div>' +
                        '<div class="nw-bs-meta-text">' +
                            '<span class="nw-bs-meta-label">Reporter</span>' +
                            '<span class="nw-bs-meta-name">' + escHtml(reporter) + '</span>' +
                        '</div>' +
                    '</div>' +
                    (editor
                        ? '<div class="nw-bs-meta-item">' +
                              '<div class="nw-bs-meta-icon"><i class="fas fa-pen"></i></div>' +
                              '<div class="nw-bs-meta-text">' +
                                  '<span class="nw-bs-meta-label">Editor</span>' +
                                  '<span class="nw-bs-meta-name">' + escHtml(editor) + '</span>' +
                              '</div>' +
                          '</div>'
                        : '') +
                '</div>' +
                '<a href="' + escHtml(url) + '" class="nw-bs-btn">' +
                    '<i class="fas fa-newspaper"></i><span>Baca Selengkapnya</span>' +
                '</a>' +
                '<div class="nw-bs-share">' +
                    '<p class="nw-bs-share-title">Bagikan Artikel</p>' +
                    '<div class="nw-bs-share-grid">' +
                        '<button class="nw-bs-share-btn nw-bs-share-btn--copy nw-bs-copy-btn" title="Salin tautan artikel">' +
                            '<span class="nw-bs-share-icon"><i class="fas fa-link"></i></span>' +
                            '<span class="nw-bs-share-lbl">Salin URL</span>' +
                        '</button>' +
                        '<button class="nw-bs-share-btn nw-bs-share-btn--wa nw-bs-wa-btn" title="Bagikan ke WhatsApp">' +
                            '<span class="nw-bs-share-icon"><i class="fab fa-whatsapp"></i></span>' +
                            '<span class="nw-bs-share-lbl">WhatsApp</span>' +
                        '</button>' +
                        '<button class="nw-bs-share-btn nw-bs-share-btn--tw nw-bs-tw-btn" title="Bagikan ke Twitter / X">' +
                            '<span class="nw-bs-share-icon"><i class="fab fa-twitter"></i></span>' +
                            '<span class="nw-bs-share-lbl">Twitter / X</span>' +
                        '</button>' +
                    '</div>' +
                '</div>' +
            '</div>';

        var bsCopyBtn = content.querySelector('.nw-bs-copy-btn');
        var bsWaBtn   = content.querySelector('.nw-bs-wa-btn');
        var bsTwBtn   = content.querySelector('.nw-bs-tw-btn');

        if (bsCopyBtn) bsCopyBtn.addEventListener('click', function () {
            var btn = this;
            nwCopyUrl(url);
            btn.classList.add('nw-bs-copied');
            btn.querySelector('.nw-bs-share-icon').innerHTML = '<i class="fas fa-check"></i>';
            btn.querySelector('.nw-bs-share-lbl').textContent = 'Tersalin!';
            setTimeout(function () {
                btn.classList.remove('nw-bs-copied');
                btn.querySelector('.nw-bs-share-icon').innerHTML = '<i class="fas fa-link"></i>';
                btn.querySelector('.nw-bs-share-lbl').textContent = 'Salin URL';
            }, 2500);
        });
        if (bsWaBtn) bsWaBtn.addEventListener('click', function () { nwShareWa(url, title); });
        if (bsTwBtn) bsTwBtn.addEventListener('click', function () {
            var full = window.location.origin + url;
            var text = (title ? title + ' — LDK Syahid\n' : '') + full;
            window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(text), '_blank');
        });

        document.getElementById('nw-bottom-sheet').scrollTop = 0;
        document.getElementById('nw-bs-backdrop').classList.add('active');
        document.getElementById('nw-bottom-sheet').classList.add('active');
        lockScroll();
        hideBtt();
    };

    function nwCloseBs() {
        document.getElementById('nw-bs-backdrop').classList.remove('active');
        document.getElementById('nw-bottom-sheet').classList.remove('active');
        unlockScroll();
        showBtt();
    }

    var bsClose    = document.getElementById('nw-bs-close');
    var bsBackdrop = document.getElementById('nw-bs-backdrop');
    if (bsClose)    bsClose.addEventListener('click', nwCloseBs);
    if (bsBackdrop) bsBackdrop.addEventListener('click', nwCloseBs);

    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        var bs = document.getElementById('nw-bottom-sheet');
        if (bs && bs.classList.contains('active')) nwCloseBs();
    });


    /* ============================================================
       13. INITIAL STATE — sync server-rendered pills
       ============================================================ */
    document.querySelectorAll('#nw-active-pills .sfb-pill[data-select-id]').forEach(function (pill) {
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
            updateFilterBadge(); buildActivePills();
            nwLoadPage(nwBuildUrl());
        });
    });

    updateFilterBadge();

}); /* end DOMContentLoaded */
</script>
