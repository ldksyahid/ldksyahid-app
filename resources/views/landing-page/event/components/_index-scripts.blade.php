@include('components.hero-jumbotron.scripts')

{{-- ── Select2 JS ── --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
/* ================================================================
   EVENT INDEX PAGE — prefix: ev-
   ================================================================ */
document.addEventListener('DOMContentLoaded', function () {

    /* ─── Select2 init ────────────────────────────────────────── */
    if (typeof $.fn !== 'undefined' && typeof $.fn.select2 !== 'undefined') {
        $('#ev-division-select, #ev-year-select').select2({
            placeholder: 'Pilih...',
            allowClear: true,
            width: '100%',
            dropdownParent: $('#ev-filter-modal'),
        });
        $(window).on('scroll', function () {
            $('#ev-division-select, #ev-year-select').select2('close');
        });
    }

    /* ─── HTML escape helper ─────────────────────────────────── */
    function escHtml(str) {
        if (str == null) return '';
        return String(str)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;')
            .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    /* ─── Scroll lock/unlock (bottom sheet) ──────────────────── */
    var _scrollY = 0;
    function lockScroll() {
        _scrollY = window.scrollY;
        document.documentElement.style.overflow = 'hidden';
    }
    function unlockScroll() {
        document.documentElement.style.overflow = '';
        window.scrollTo({ top: _scrollY, left: 0, behavior: 'instant' });
    }

    /* ─── Filter modal — backdrop blur + scroll lock ──────────── */
    var filterModal = document.getElementById('ev-filter-modal');
    var fmBackdrop  = document.getElementById('ev-fm-backdrop');
    var _evFmScrollY    = 0;
    var _evFmTouchBlock = null;

    function evFmLockScroll() {
        _evFmScrollY = window.scrollY;
        document.documentElement.style.overflow = 'hidden';
    }
    function evFmUnlockScroll() {
        document.documentElement.style.overflow = '';
        window.scrollTo({ top: _evFmScrollY, left: 0, behavior: 'instant' });
    }

    if (filterModal) {
        filterModal.addEventListener('show.bs.modal', function () {
            updateFilterBadge();
            if (fmBackdrop) fmBackdrop.classList.add('active');
            evFmLockScroll();
            _evFmTouchBlock = function (e) {
                if (!e.target.closest('.sfb-fm-body')) e.preventDefault();
            };
            window.addEventListener('touchmove', _evFmTouchBlock, { passive: false, capture: true });
        });
        filterModal.addEventListener('hidden.bs.modal', function () {
            if (fmBackdrop) fmBackdrop.classList.remove('active');
            evFmUnlockScroll();
            if (_evFmTouchBlock) {
                window.removeEventListener('touchmove', _evFmTouchBlock, { capture: true });
                _evFmTouchBlock = null;
            }
        });
    }

    if (fmBackdrop) {
        fmBackdrop.addEventListener('click', function () {
            var modal = bootstrap.Modal.getInstance(filterModal);
            if (modal) modal.hide();
        });
    }

    /* ─── Filter badge counter ───────────────────────────────── */
    function updateFilterBadge() {
        var count = 0;
        ['ev-division-select', 'ev-year-select'].forEach(function (id) {
            var el = document.getElementById(id);
            if (el && el.selectedOptions) count += el.selectedOptions.length;
        });
        var badge = document.getElementById('ev-filter-count');
        if (badge) {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'flex' : 'none';
        }
        var clearBtn = document.getElementById('ev-filter-clear');
        if (clearBtn) {
            clearBtn.style.display = count > 0 ? 'flex' : 'none';
        }
    }

    /* ─── Active filter pills ────────────────────────────────── */
    function buildPills() {
        var container = document.getElementById('ev-active-pills');
        if (!container) return;
        container.innerHTML = '';

        var fieldMap = {
            'ev-division-select': 'Divisi',
            'ev-year-select':     'Tahun',
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
                        updateFilterBadge();
                        buildPills();
                        loadEvents(buildUrl(1), true);
                    });
                }
                container.appendChild(pill);
            });
        });
    }

    /* ─── Build URL from current form state ──────────────────── */
    function buildUrl(page) {
        var base     = document.getElementById('ev-base-url').value;
        var searchEl = document.getElementById('ev-search-input');
        var search   = searchEl ? searchEl.value.trim() : '';
        var sortEl   = document.getElementById('ev-sort-val');
        var sort     = sortEl ? sortEl.value : 'newest';
        var params   = new URLSearchParams();

        if (search) params.set('search', search);

        var divEl = document.getElementById('ev-division-select');
        if (divEl && divEl.selectedOptions) {
            Array.from(divEl.selectedOptions).forEach(function (opt) {
                params.append('division[]', opt.value);
            });
        }

        var yearEl = document.getElementById('ev-year-select');
        if (yearEl && yearEl.selectedOptions) {
            Array.from(yearEl.selectedOptions).forEach(function (opt) {
                params.append('year[]', opt.value);
            });
        }

        if (sort && sort !== 'newest') params.set('sort', sort);
        if (page && page > 1) params.set('page', page);

        var qs = params.toString();
        return base + (qs ? '?' + qs : '');
    }

    /* ─── Scroll to event section ────────────────────────────── */
    function scrollToSection() {
        var section = document.getElementById('ev-event-section');
        if (section) {
            var top = section.getBoundingClientRect().top + window.scrollY - 90;
            window.scrollTo({ top: top, behavior: 'smooth' });
        }
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
                initCarouselDots();
            },
            error: function (xhr) {
                if (xhr.statusText !== 'abort') wrap.classList.remove('ev-page-transitioning');
            }
        });
    }

    /* ─── Pagination — event delegation ──────────────────────── */
    document.addEventListener('click', function (e) {
        var link = e.target.closest('#ev-cards-wrap .pgn-nav[href], #ev-cards-wrap .pgn-num[href]');
        if (!link) return;
        e.preventDefault();
        scrollToSection();
        loadEvents(link.href, true);
    });

    /* ─── Search (debounced) ─────────────────────────────────── */
    var _searchTimer;
    var searchInput = document.getElementById('ev-search-input');
    var searchClear = document.getElementById('ev-search-clear');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            if (searchClear) searchClear.style.display = this.value ? 'flex' : 'none';
            clearTimeout(_searchTimer);
            _searchTimer = setTimeout(function () {
                loadEvents(buildUrl(1), true);
            }, 420);
        });
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(_searchTimer);
                loadEvents(buildUrl(1), true);
            }
        });
        if (searchClear) {
            searchClear.style.display = searchInput.value ? 'flex' : 'none';
        }
    }

    if (searchClear) {
        searchClear.addEventListener('click', function () {
            if (searchInput) { searchInput.value = ''; this.style.display = 'none'; }
            clearTimeout(_searchTimer);
            loadEvents(buildUrl(1), true);
        });
    }

    /* ─── Filter apply ───────────────────────────────────────── */
    var applyBtn = document.getElementById('ev-apply-filter');
    if (applyBtn) {
        applyBtn.addEventListener('click', function () {
            var modal = bootstrap.Modal.getInstance(filterModal);
            if (modal) modal.hide();
            updateFilterBadge();
            buildPills();
            loadEvents(buildUrl(1), true);
        });
    }

    /* ─── Filter reset / clear ───────────────────────────────── */
    function evClearAllFilters() {
        ['ev-division-select', 'ev-year-select'].forEach(function (id) {
            var el = document.getElementById(id);
            if (!el) return;
            for (var i = 0; i < el.options.length; i++) el.options[i].selected = false;
            if (typeof $ !== 'undefined') $(el).trigger('change');
        });
        updateFilterBadge();
    }

    var resetBtn = document.getElementById('ev-reset-filter');
    if (resetBtn) {
        resetBtn.addEventListener('click', evClearAllFilters);
    }

    var filterClearBtn = document.getElementById('ev-filter-clear');
    if (filterClearBtn) {
        filterClearBtn.addEventListener('click', function () {
            evClearAllFilters();
            buildPills();
            loadEvents(buildUrl(1), true);
        });
    }

    /* ─── Sort dropdown ──────────────────────────────────────── */
    document.querySelectorAll('[data-sort][data-sort-prefix="ev"]').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            var val    = this.dataset.sort;
            var sortEl = document.getElementById('ev-sort-val');
            if (sortEl) sortEl.value = val;

            /* Update active class on sort items */
            document.querySelectorAll('[data-sort][data-sort-prefix="ev"]').forEach(function (s) {
                s.classList.toggle('active', s.dataset.sort === val);
            });

            scrollToSection();
            loadEvents(buildUrl(1), true);
        });
    });

    /* ─── Mobile carousel dots ───────────────────────────────── */
    function initCarouselDots() {
        var carousel = document.getElementById('ev-mobile-carousel');
        var dotsWrap = document.getElementById('ev-carousel-dots');
        if (!carousel || !dotsWrap) return;

        var cards = carousel.querySelectorAll('.ev-mobile-card');
        dotsWrap.innerHTML = '';

        if (cards.length <= 1) { dotsWrap.style.display = 'none'; return; }
        dotsWrap.style.display = 'flex';

        var dots = [];
        cards.forEach(function (card, i) {
            var dot = document.createElement('span');
            dot.className = 'ev-dot' + (i === 0 ? ' active' : '');
            dot.setAttribute('aria-label', 'Slide ' + (i + 1));
            dot.addEventListener('click', function () {
                card.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
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
            try {
                var ta = document.createElement('textarea');
                ta.value = full;
                ta.style.cssText = 'position:fixed;top:0;left:0;opacity:0;pointer-events:none;';
                document.body.appendChild(ta); ta.select(); document.execCommand('copy');
                document.body.removeChild(ta); showToast(true, 'URL berhasil disalin!');
            } catch (e) { showToast(false, 'Gagal menyalin URL'); }
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

    var _mainNav = document.getElementById('mainNavbar');

    function evOpenBs() {
        if (!sheet) return;
        if (backdrop) backdrop.classList.add('active');
        sheet.classList.add('open');
        if (_mainNav) _mainNav.classList.add('ev-navbar-sheet-active');
        lockScroll();
    }
    function evCloseBs() {
        if (!sheet) return;
        sheet.classList.remove('open');
        if (backdrop) backdrop.classList.remove('active');
        if (_mainNav) _mainNav.classList.remove('ev-navbar-sheet-active');
        unlockScroll();
    }

    if (closeBtn) closeBtn.addEventListener('click', evCloseBs);
    if (backdrop) backdrop.addEventListener('click', evCloseBs);
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && sheet && sheet.classList.contains('open')) evCloseBs();
    });

    /* ─── Lightbox (fullscreen image) ───────────────────────── */
    var _lbEl = null;
    function evOpenLightbox(src, alt) {
        if (!_lbEl) {
            _lbEl = document.createElement('div');
            _lbEl.className = 'ev-bs-lightbox';
            _lbEl.innerHTML =
                '<button class="ev-bs-lightbox-close" aria-label="Tutup"><i class="fas fa-times"></i></button>' +
                '<img class="ev-bs-lightbox-img" alt="">';
            document.body.appendChild(_lbEl);
            _lbEl.querySelector('.ev-bs-lightbox-close').addEventListener('click', evCloseLightbox);
            _lbEl.addEventListener('click', function (e) {
                if (e.target === _lbEl) evCloseLightbox();
            });
        }
        _lbEl.querySelector('.ev-bs-lightbox-img').src = src;
        _lbEl.querySelector('.ev-bs-lightbox-img').alt = alt || '';
        requestAnimationFrame(function () { _lbEl.classList.add('active'); });
    }
    function evCloseLightbox() {
        if (_lbEl) _lbEl.classList.remove('active');
    }
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && _lbEl && _lbEl.classList.contains('active')) evCloseLightbox();
    });

    window.evOpenBottomSheet = function (card) {
        if (!content) return;
        var title    = card.dataset.title;
        var division = card.dataset.division;
        var date     = card.dataset.date;
        var location = card.dataset.location;
        var status   = card.dataset.status;
        var statusCls= card.dataset.statusCls || '';
        var poster   = card.dataset.poster;
        var url      = card.dataset.url;
        var excerpt  = card.dataset.excerpt;

        /* ── Image section (edge-to-edge, like article sheet) ── */
        var imgHtml = poster
            ? '<div class="ev-bs-img-wrap">' +
                  '<div class="ev-bs-drag-handle"></div>' +
                  '<img src="' + escHtml(poster) + '" class="ev-bs-img-photo" alt="' + escHtml(title) + '" loading="lazy">' +
                  '<div class="ev-bs-img-gradient"></div>' +
                  '<button class="ev-bs-img-expand-btn" aria-label="Lihat foto penuh"><i class="fas fa-expand"></i></button>' +
              '</div>'
            : '<div class="ev-bs-no-img-handle"></div>';

        var metaRows = '';
        if (date && date !== '-')
            metaRows += '<div class="ev-bs-meta-row"><i class="far fa-calendar-alt"></i><span>' + escHtml(date) + '</span></div>';
        if (location && location !== '-')
            metaRows += '<div class="ev-bs-meta-row"><i class="fas fa-map-marker-alt"></i><span>' + escHtml(location) + '</span></div>';

        content.innerHTML =
            imgHtml +
            '<div class="ev-bs-body">' +
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
                '</div>' +
            '</div>';

        /* Wire expand button + image click → lightbox */
        if (poster) {
            var expandBtn = content.querySelector('.ev-bs-img-expand-btn');
            var imgPhoto  = content.querySelector('.ev-bs-img-photo');
            if (expandBtn) expandBtn.addEventListener('click', function () { evOpenLightbox(poster, title); });
            if (imgPhoto)  imgPhoto.addEventListener('click',  function () { evOpenLightbox(poster, title); });
        }

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
        if (waBtn) waBtn.addEventListener('click', function () { evShareWa(url, title); });
        if (twBtn) twBtn.addEventListener('click', function () { evShareTw(url, title); });

        sheet.scrollTop = 0;
        evOpenBs();
    };

    /* ─── Initial state sync ─────────────────────────────────── */
    /* Wire server-rendered pills (if any active filter on page load) */
    document.querySelectorAll('#ev-active-pills .sfb-pill[data-select-id]').forEach(function (pill) {
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
            buildPills();
            loadEvents(buildUrl(1), true);
        });
    });

    updateFilterBadge();

});
</script>
