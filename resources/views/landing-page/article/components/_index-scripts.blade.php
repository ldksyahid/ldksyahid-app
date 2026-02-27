{{-- ── Hero Jumbotron scripts (hadith/quran countdown + API) ── --}}
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
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    var scrollY = 0;
    function lockScroll() {
        scrollY = window.scrollY;
        document.body.style.overflow  = 'hidden';
        document.body.style.position  = 'fixed';
        document.body.style.top       = -scrollY + 'px';
        document.body.style.width     = '100%';
    }
    function unlockScroll() {
        document.body.style.overflow  = '';
        document.body.style.position  = '';
        document.body.style.top       = '';
        document.body.style.width     = '';
        window.scrollTo({ top: scrollY, left: 0, behavior: 'instant' });
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
        var $filterSelects = $('#ar-theme-select, #ar-writer-select, #ar-editor-select, #ar-year-select');

        /* Move Select2's inline search INSIDE the rendered <ul> so pills
           and search share one flex row. Select2 v4.1-rc puts the search
           outside the ul (as a sibling); this restores v4.0 behaviour. */
        function fixSelect2Search($select) {
            var $cnt  = $select.next('.select2-container');
            var $ul   = $cnt.find('.select2-selection__rendered');
            var $srch = $cnt.find('.select2-search--inline');
            if ($ul.length && $srch.length && !$.contains($ul[0], $srch[0])) {
                $ul.append($srch);
            }
        }

        $filterSelects.each(function () {
            var $s = $(this);
            $s.select2({
                placeholder: 'Semua',
                allowClear: true,
                width: '100%',
                dropdownParent: $('#ar-filter-modal'),
            });
            fixSelect2Search($s);
            /* Re-fix after any change (allowClear button re-render, etc.) */
            $s.on('select2:select select2:unselect select2:clear', function () {
                setTimeout(function () { fixSelect2Search($s); }, 0);
            });
        });
        $(window).on('scroll', function () { $filterSelects.select2('close'); });
    }


    /* ============================================================
       2. FILTER COUNT BADGE
       ============================================================ */
    function updateFilterBadge() {
        var count = 0;
        ['ar-theme-select', 'ar-writer-select', 'ar-editor-select', 'ar-year-select'].forEach(function (id) {
            var el = document.getElementById(id);
            if (el && el.selectedOptions) count += el.selectedOptions.length;
        });
        var badge = document.getElementById('ar-filter-count');
        if (badge) {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'flex' : 'none';
        }
    }

    /* Custom blur backdrop — show/hide with filter modal */
    var filterModal = document.getElementById('ar-filter-modal');
    var fmBackdrop  = document.getElementById('ar-fm-backdrop');

    if (filterModal) {
        filterModal.addEventListener('show.bs.modal',   function () {
            updateFilterBadge();
            if (fmBackdrop) fmBackdrop.classList.add('active');
        });
        filterModal.addEventListener('hidden.bs.modal', function () {
            if (fmBackdrop) fmBackdrop.classList.remove('active');
        });
    }

    /* Click on custom backdrop → close modal */
    if (fmBackdrop) {
        fmBackdrop.addEventListener('click', function () {
            var modal = bootstrap.Modal.getInstance(filterModal);
            if (modal) modal.hide();
        });
    }


    /* ============================================================
       3. BUILD URL FROM FORM STATE
       ============================================================ */
    function arBuildUrl(page) {
        var params = new URLSearchParams();

        var searchEl = document.getElementById('ar-search-input');
        var search   = searchEl ? searchEl.value.trim() : '';
        if (search) params.set('search', search);

        var fieldMap = {
            'ar-theme-select':  'theme',
            'ar-writer-select': 'writer',
            'ar-editor-select': 'editor',
            'ar-year-select':   'created_year',
        };
        Object.keys(fieldMap).forEach(function (id) {
            var el = document.getElementById(id);
            if (!el || !el.selectedOptions) return;
            Array.from(el.selectedOptions).forEach(function (opt) {
                params.append(fieldMap[id] + '[]', opt.value);
            });
        });

        var sortEl = document.getElementById('ar-sort-val');
        var sort   = sortEl ? sortEl.value : 'newest';
        if (sort && sort !== 'newest') params.set('sort', sort);

        if (page && page > 1) params.set('page', page);

        var base = document.getElementById('ar-base-url').value;
        var qs   = params.toString();
        return base + (qs ? '?' + qs : '');
    }


    /* ============================================================
       4. ACTIVE FILTER PILLS (JS-driven)
       ============================================================ */
    function buildActivePills() {
        var container = document.getElementById('ar-active-pills');
        if (!container) return;
        container.innerHTML = '';

        var fieldMap = {
            'ar-theme-select':  'Tema',
            'ar-writer-select': 'Penulis',
            'ar-editor-select': 'Editor',
            'ar-year-select':   'Tahun',
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

                pill.addEventListener('click', function () {
                    var sel = document.getElementById(this.dataset.selectId);
                    if (!sel) return;
                    for (var i = 0; i < sel.options.length; i++) {
                        if (sel.options[i].value === this.dataset.value) sel.options[i].selected = false;
                    }
                    if (typeof $ !== 'undefined') $(sel).trigger('change');
                    updateFilterBadge();
                    buildActivePills();
                    arLoadPage(arBuildUrl());
                });

                container.appendChild(pill);
            });
        });
    }


    /* ============================================================
       5. AJAX LOAD PAGE
       ============================================================ */
    function arLoadPage(url) {
        var wrap    = document.getElementById('ar-cards-wrap');
        var section = document.getElementById('ar-article-section');

        if (wrap) wrap.classList.add('ar-cards-out');

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

                    /* Two rAF frames before removing class so browser paints first */
                    requestAnimationFrame(function () {
                        requestAnimationFrame(function () {
                            wrap.classList.remove('ar-cards-out');
                        });
                    });
                }

                /* Update results info */
                var info = document.getElementById('ar-results-info');
                if (info) {
                    if (data.total > 0) {
                        info.innerHTML =
                            'Menampilkan <strong>' + data.from + '–' + data.to + '</strong>' +
                            ' dari <strong>' + data.total + '</strong> artikel';
                    } else {
                        info.innerHTML = 'Tidak ada artikel yang ditemukan';
                    }
                }

                /* Re-init carousel dots for fresh cards */
                initCarouselDots();
            })
            .catch(function () {
                if (wrap) wrap.classList.remove('ar-cards-out');
                window.location.href = url;
            });
    }


    /* ============================================================
       6. AJAX PAGINATION (click on pgn links inside cards wrap)
       ============================================================ */
    document.addEventListener('click', function (e) {
        var link = e.target.closest('#ar-cards-wrap .pgn-nav[href], #ar-cards-wrap .pgn-num[href]');
        if (!link) return;
        e.preventDefault();
        arLoadPage(link.href);
    });


    /* ============================================================
       7. SEARCH — debounced AJAX
       ============================================================ */
    var searchInput = document.getElementById('ar-search-input');
    var searchClear = document.getElementById('ar-search-clear');
    var searchTimer = null;

    if (searchInput) {
        /* Show/hide clear button on input */
        searchInput.addEventListener('input', function () {
            if (searchClear) searchClear.style.display = this.value ? 'flex' : 'none';
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function () {
                arLoadPage(arBuildUrl());
            }, 420);
        });

        /* Suppress native form submit (we handle via JS) */
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(searchTimer);
                arLoadPage(arBuildUrl());
            }
        });

        /* Initial clear button state */
        if (searchClear) {
            searchClear.style.display = searchInput.value ? 'flex' : 'none';
        }
    }

    if (searchClear) {
        searchClear.addEventListener('click', function () {
            if (searchInput) { searchInput.value = ''; this.style.display = 'none'; }
            clearTimeout(searchTimer);
            arLoadPage(arBuildUrl());
        });
    }


    /* ============================================================
       8. FILTER APPLY / RESET
       ============================================================ */
    var applyBtn = document.getElementById('ar-apply-filter');
    if (applyBtn) {
        applyBtn.addEventListener('click', function () {
            var modal = bootstrap.Modal.getInstance(document.getElementById('ar-filter-modal'));
            if (modal) modal.hide();
            updateFilterBadge();
            buildActivePills();
            arLoadPage(arBuildUrl());
        });
    }

    var resetBtn = document.getElementById('ar-reset-filter');
    if (resetBtn) {
        resetBtn.addEventListener('click', function () {
            ['ar-theme-select', 'ar-writer-select', 'ar-editor-select', 'ar-year-select'].forEach(function (id) {
                var el = document.getElementById(id);
                if (!el) return;
                for (var i = 0; i < el.options.length; i++) el.options[i].selected = false;
                if (typeof $ !== 'undefined') $(el).trigger('change');
            });
            updateFilterBadge();
        });
    }


    /* ============================================================
       9. SORT DROPDOWN
       ============================================================ */
    document.querySelectorAll('[data-sort][data-sort-prefix="ar"]').forEach(function (el) {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            var val    = this.dataset.sort;
            var sortEl = document.getElementById('ar-sort-val');
            if (sortEl) sortEl.value = val;

            /* Update active class */
            document.querySelectorAll('[data-sort][data-sort-prefix="ar"]').forEach(function (s) {
                s.classList.toggle('active', s.dataset.sort === val);
            });
            arLoadPage(arBuildUrl());
        });
    });


    /* ============================================================
       10. MOBILE CAROUSEL — Scroll Snap Dots
       ============================================================ */
    function initCarouselDots() {
        var carousel = document.getElementById('ar-mobile-carousel');
        var dotsWrap = document.getElementById('ar-carousel-dots');
        if (!carousel || !dotsWrap) return;

        var cards = carousel.querySelectorAll('.ar-mobile-card');
        dotsWrap.innerHTML = '';

        if (cards.length <= 1) { dotsWrap.style.display = 'none'; return; }
        dotsWrap.style.display = 'flex';

        var dots = [];
        cards.forEach(function (card, i) {
            var dot = document.createElement('span');
            dot.className = 'ar-dot' + (i === 0 ? ' active' : '');
            dot.title = 'Artikel ' + (i + 1);
            dot.addEventListener('click', function () {
                card.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
            });
            dotsWrap.appendChild(dot);
            dots.push(dot);
        });

        /* IntersectionObserver to track visible card */
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
       11. MOBILE BOTTOM SHEET
       ============================================================ */
    window.arOpenBottomSheet = function (el) {
        var content = document.getElementById('ar-bs-content');
        if (!content) return;

        var title  = el.dataset.title;
        var theme  = el.dataset.theme;
        var date   = el.dataset.date;
        var writer = el.dataset.writer;
        var editor = el.dataset.editor;
        var image  = el.dataset.image;
        var url    = el.dataset.url;

        content.innerHTML =
            '<div class="ar-bs-img">' +
                '<img src="https://lh3.googleusercontent.com/d/' + escHtml(image) +
                     '" alt="' + escHtml(title) + '" loading="lazy">' +
            '</div>' +
            '<div class="ar-bs-header">' +
                '<div class="ar-bs-meta">' +
                    '<span class="ar-bs-tag">' + escHtml(theme) + '</span>' +
                    '<span class="ar-bs-date"><i class="far fa-calendar-alt"></i> ' + escHtml(date) + '</span>' +
                '</div>' +
                '<h5 class="ar-bs-title">' + escHtml(title) + '</h5>' +
                '<div class="ar-bs-info">' +
                    '<div><i class="fas fa-pen"></i> Penulis: ' + escHtml(writer) + '</div>' +
                    '<div><i class="fas fa-edit"></i> Editor: ' + escHtml(editor) + '</div>' +
                '</div>' +
                '<div class="ar-bs-actions">' +
                    '<a href="' + escHtml(url) + '" class="ar-bs-read-btn">' +
                        '<i class="fas fa-book-open"></i><span>Baca Artikel</span>' +
                    '</a>' +
                '</div>' +
            '</div>';

        document.getElementById('ar-bs-backdrop').classList.add('active');
        document.getElementById('ar-bottom-sheet').classList.add('active');
        lockScroll();
        hideBtt();
    };

    function arCloseBs() {
        document.getElementById('ar-bs-backdrop').classList.remove('active');
        document.getElementById('ar-bottom-sheet').classList.remove('active');
        unlockScroll();
        showBtt();
    }

    var bsClose    = document.getElementById('ar-bs-close');
    var bsBackdrop = document.getElementById('ar-bs-backdrop');
    if (bsClose)    bsClose.addEventListener('click', arCloseBs);
    if (bsBackdrop) bsBackdrop.addEventListener('click', arCloseBs);

    /* Escape key */
    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        var bs = document.getElementById('ar-bottom-sheet');
        if (bs && bs.classList.contains('active')) arCloseBs();
    });


    /* ============================================================
       12. INITIAL STATE — sync pills if server rendered filters
       ============================================================ */
    /* The server renders initial pills in the Blade template.
       Wire up their click handlers to deselect + re-fetch. */
    document.querySelectorAll('#ar-active-pills .sfb-pill[data-select-id]').forEach(function (pill) {
        pill.addEventListener('click', function () {
            var sel = document.getElementById(this.dataset.selectId);
            if (!sel) return;
            for (var i = 0; i < sel.options.length; i++) {
                if (sel.options[i].value === this.dataset.value) sel.options[i].selected = false;
            }
            if (typeof $ !== 'undefined') $(sel).trigger('change');
            updateFilterBadge();
            buildActivePills();
            arLoadPage(arBuildUrl());
        });
    });

    /* Sync filter badge on init */
    updateFilterBadge();

}); /* end DOMContentLoaded */
</script>
