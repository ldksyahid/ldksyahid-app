{{-- ── Hero Jumbotron shared scripts ── --}}
@include('components.hero-jumbotron.scripts')

{{-- ── Skeleton cards shared scripts ── --}}
@include('components.skeleton-cards.scripts')

{{-- ── Select2 JS ── --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ============================================================
       SELECT2 INIT
       ============================================================ */
    if (typeof $.fn !== 'undefined' && typeof $.fn.select2 !== 'undefined') {
        $('#cs-category-select').select2({
            placeholder: 'Semua kategori',
            allowClear: true,
            width: '100%',
            dropdownParent: $('#cs-filter-modal'),
        });
        $(window).on('scroll', function () { $('#cs-category-select').select2('close'); });
    }


    /* ============================================================
       BADGE + CLEAR-BUTTON HELPER
       ============================================================ */
    function csUpdateBadge(count) {
        var badge    = document.getElementById('cs-filter-count');
        var clearBtn = document.getElementById('cs-filter-clear');
        if (badge)    { badge.textContent = count; badge.style.display = count > 0 ? '' : 'none'; }
        if (clearBtn) { clearBtn.style.display = count > 0 ? 'flex' : 'none'; }
    }


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
        document.body.classList.add('cs-sheet-open');
        _touchBlock = function (e) {
            var sheet = document.getElementById('cs-bottom-sheet');
            if (sheet && sheet.contains(e.target)) return;
            e.preventDefault();
        };
        window.addEventListener('touchmove', _touchBlock, { passive: false });
        if (btt) { btt.style.opacity = '0'; btt.style.visibility = 'hidden'; }
    }
    function unlockScroll() {
        document.body.classList.remove('cs-sheet-open');
        if (_touchBlock) {
            window.removeEventListener('touchmove', _touchBlock);
            _touchBlock = null;
        }
        if (btt) { btt.style.opacity = ''; btt.style.visibility = ''; }
    }

    /* ============================================================
       SHARE HELPERS
       ============================================================ */
    function showCopyToast(ok) {
        if (typeof Swal === 'undefined') return;
        Swal.fire({
            toast: true, position: 'top-end',
            icon: ok ? 'success' : 'error',
            title: ok ? 'URL berhasil disalin!' : 'Gagal menyalin URL',
            showConfirmButton: false, timer: 2500, timerProgressBar: true,
            customClass: { container: 'cs-swal-above-sheet' }
        });
    }
    window.csCopyUrl = function (url, ev) {
        if (ev) ev.stopPropagation();
        var full = (url && url.indexOf('http') === 0) ? url : window.location.origin + url;
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(full)
                .then(function () { showCopyToast(true); })
                .catch(function () { showCopyToast(false); });
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
    window.csShareWa = function (url, title, ev) {
        if (ev) ev.stopPropagation();
        var full = (url && url.indexOf('http') === 0) ? url : window.location.origin + url;
        var text = (title ? title + '\n' : '') + full;
        window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank');
    };


    /* ============================================================
       MOBILE BOTTOM SHEET
       ============================================================ */
    window.csOpenBottomSheet = function (el) {
        var content = document.getElementById('cs-bs-content');
        if (!content) return;

        var title       = el.dataset.title       || '';
        var cover       = el.dataset.cover        || '';
        var org         = el.dataset.org          || 'UKM LDK Syahid';
        var orgLogo     = el.dataset.orgLogo      || '';
        var orgLink     = el.dataset.orgLink      || '#';
        var category    = el.dataset.category     || '';
        var percent     = el.dataset.percent      || '0';
        var collected   = el.dataset.collected    || 'Rp0';
        var days        = el.dataset.days         || '';
        var deadlinePassed = el.dataset.deadlinePassed === '1';
        var donors      = el.dataset.donors       || '0';
        var excerpt     = el.dataset.excerpt      || '';
        var url         = el.dataset.url          || '#';
        var donateUrl   = el.dataset.donateUrl    || '#';
        var catColor    = getComputedStyle(el).getPropertyValue('--cs-cat').trim() || '#00a79d';

        var imgHtml = cover
            ? '<img src="' + escHtml(cover) + '" alt="' + escHtml(title) + '" class="cs-bs-cover-img" loading="lazy">'
            : '<div class="cs-bs-cover-fallback"><i class="fas fa-hand-holding-heart"></i></div>';

        content.innerHTML =
            '<div class="cs-bs-cover-wrap">' +
                '<div class="cs-bs-drag-handle"></div>' +
                imgHtml +
                '<div class="cs-bs-cover-gradient"></div>' +
            '</div>' +
            '<div class="cs-bs-info">' +
                '<span class="cs-bs-cat-badge" style="background:' + escHtml(catColor) + '20;color:' + escHtml(catColor) + '">' +
                    '<i class="fas fa-tag" style="font-size:.6rem"></i>' + escHtml(category) +
                '</span>' +
                '<h5 class="cs-bs-title">' + escHtml(title) + '</h5>' +
                '<div class="cs-bs-org">' +
                    (orgLogo ? '<img src="' + escHtml(orgLogo) + '" alt="' + escHtml(org) + '" class="cs-bs-org-logo">' : '') +
                    '<a href="' + escHtml(orgLink) + '" target="_blank" class="cs-bs-org-name">' + escHtml(org) + '</a>' +
                '</div>' +
                '<div class="cs-bs-progress-wrap">' +
                    '<div class="cs-bs-progress-head">' +
                        '<span class="cs-bs-progress-pct">' + escHtml(percent) + '% tercapai</span>' +
                        '<span class="cs-bs-progress-days' + (deadlinePassed ? ' ended' : '') + '">' + escHtml(days) + '</span>' +
                    '</div>' +
                    '<div class="cs-bs-progress-track">' +
                        '<div class="cs-bs-progress-fill" style="width:' + Math.min(parseFloat(percent)||0, 100) + '%"></div>' +
                    '</div>' +
                '</div>' +
                '<div class="cs-bs-stats">' +
                    '<div class="cs-bs-stat"><span class="cs-bs-stat-label">Terkumpul</span><span class="cs-bs-stat-val primary">' + escHtml(collected) + '</span></div>' +
                    '<div class="cs-bs-stat-sep"></div>' +
                    '<div class="cs-bs-stat"><span class="cs-bs-stat-label">Donatur</span><span class="cs-bs-stat-val">' + escHtml(donors) + ' orang</span></div>' +
                '</div>' +
                (excerpt ? '<p class="cs-bs-excerpt">' + escHtml(excerpt) + '</p>' : '') +
                '<div class="cs-bs-btns">' +
                    '<a href="' + escHtml(donateUrl) + '" class="cs-bs-btn-donate"><i class="fas fa-heart"></i><span>Donasi Sekarang</span></a>' +
                    '<a href="' + escHtml(url) + '" class="cs-bs-btn-detail"><i class="fas fa-info-circle"></i><span>Lihat Detail</span></a>' +
                '</div>' +
                '<div class="cs-bs-share-wrap">' +
                    '<span class="cs-bs-share-label">Bagikan</span>' +
                    '<div class="cs-bs-share-row">' +
                        '<button class="cs-bs-share-btn cs-bs-share-copy cs-bs-copy-btn"><i class="fas fa-link"></i><span>Salin URL</span></button>' +
                        '<button class="cs-bs-share-btn cs-bs-share-wa cs-bs-wa-btn"><i class="fab fa-whatsapp"></i><span>WhatsApp</span></button>' +
                    '</div>' +
                '</div>' +
            '</div>';

        /* Wire share buttons */
        var copyBtn = content.querySelector('.cs-bs-copy-btn');
        var waBtn   = content.querySelector('.cs-bs-wa-btn');
        if (copyBtn) copyBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            window.csCopyUrl(url, e);
        });
        if (waBtn) waBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            window.csShareWa(url, title, e);
        });

        var backdrop = document.getElementById('cs-bs-backdrop');
        var sheet    = document.getElementById('cs-bottom-sheet');
        if (backdrop) backdrop.classList.add('active');
        if (sheet)    sheet.classList.add('active');
        lockScroll();
    };

    function csCloseBottomSheet() {
        var backdrop = document.getElementById('cs-bs-backdrop');
        var sheet    = document.getElementById('cs-bottom-sheet');
        if (backdrop) backdrop.classList.remove('active');
        if (sheet)    sheet.classList.remove('active');
        unlockScroll();
    }

    var backdrop = document.getElementById('cs-bs-backdrop');
    var closeBtn = document.getElementById('cs-bs-close');
    if (backdrop) backdrop.addEventListener('click', csCloseBottomSheet);
    if (closeBtn) closeBtn.addEventListener('click', csCloseBottomSheet);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') csCloseBottomSheet();
    });


    /* ============================================================
       CAROUSEL DOTS
       ============================================================ */
    function initCarouselDots() {
        var carousel = document.getElementById('cs-mobile-carousel');
        var dotsWrap = document.getElementById('cs-carousel-dots');
        if (!carousel || !dotsWrap) return;

        var cards = carousel.querySelectorAll('.cs-mobile-card');
        if (!cards.length) { dotsWrap.innerHTML = ''; return; }

        dotsWrap.innerHTML = '';
        cards.forEach(function (_, i) {
            var dot = document.createElement('button');
            dot.className = 'cs-dot' + (i === 0 ? ' active' : '');
            dot.setAttribute('aria-label', 'Campaign ' + (i + 1));
            dot.addEventListener('click', function () {
                cards[i].scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            });
            dotsWrap.appendChild(dot);
        });

        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                var idx = Array.from(cards).indexOf(entry.target);
                dotsWrap.querySelectorAll('.cs-dot').forEach(function (d, i) {
                    d.classList.toggle('active', i === idx);
                });
            });
        }, { root: carousel, threshold: .5 });
        cards.forEach(function (c) { io.observe(c); });
    }
    initCarouselDots();


    /* ============================================================
       AJAX FADE HELPERS
       ============================================================ */
    var FADE = 300;

    function csFadeOut(el) {
        return new Promise(function (resolve) {
            el.classList.add('cs-cards-out');
            setTimeout(resolve, FADE);
        });
    }
    function csFadeIn(el) {
        requestAnimationFrame(function () {
            requestAnimationFrame(function () {
                el.classList.remove('cs-cards-out');
            });
        });
    }

    /* ============================================================
       AJAX LOAD PAGE
       ============================================================ */
    function csScrollToSection() {
        var section = document.getElementById('cs-campaign-section');
        if (!section) return;
        requestAnimationFrame(function () {
            var top = section.getBoundingClientRect().top + window.scrollY - 90;
            window.scrollTo({ top: top, behavior: 'smooth' });
        });
    }

    function csLoadPage(url) {
        var wrap = document.getElementById('cs-cards-wrap');

        var fetchData = fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                            .then(function (r) { return r.json(); });

        /* Phase 1 — fade out current → show skeleton */
        var skeletonShown = wrap
            ? csFadeOut(wrap).then(function () {
                wrap.innerHTML = buildSkeleton('campaign', 3, 3);
                csFadeIn(wrap);
              })
            : Promise.resolve();

        /* Phase 2 — wait data + min skeleton time */
        var minSkeleton = new Promise(function (res) { setTimeout(res, FADE + 400); });

        Promise.all([fetchData, skeletonShown, minSkeleton])
            .then(function (results) {
                var data = results[0];
                if (!wrap) return;

                /* Phase 3 — fade out skeleton → show content → scroll to section */
                csFadeOut(wrap).then(function () {
                    wrap.innerHTML = data.html;
                    csFadeIn(wrap);

                    var info = document.getElementById('cs-results-info');
                    if (info) {
                        if (data.total > 0) {
                            info.innerHTML =
                                'Menampilkan <strong>' + data.from + '–' + data.to + '</strong>' +
                                ' dari <strong>' + data.total + '</strong> campaign';
                        } else {
                            info.innerHTML = 'Tidak ada campaign yang ditemukan';
                        }
                    }
                    initCarouselDots();
                    csScrollToSection();
                });
            })
            .catch(function () {
                if (wrap) wrap.classList.remove('cs-cards-out');
                window.location.href = url;
            });
    }


    /* ============================================================
       URL BUILDER
       ============================================================ */
    function csBuildUrl() {
        var base   = document.getElementById('cs-base-url');
        var search = document.getElementById('cs-search-input');
        var sort   = document.getElementById('cs-sort-val');

        var params = new URLSearchParams();
        if (search && search.value.trim()) params.set('search', search.value.trim());
        if (sort && sort.value)            params.set('sort',   sort.value);

        /* Category pills */
        var pills = document.querySelectorAll('#cs-active-pills .sfb-pill');
        var cats  = [];
        pills.forEach(function (p) {
            if (p.dataset.selectId === 'cs-category-select') {
                cats.push(p.dataset.value);
            }
        });
        cats.forEach(function (c) { params.append('category', c); });

        var q = params.toString();
        return (base ? base.value : window.location.pathname) + (q ? '?' + q : '');
    }


    /* ============================================================
       PAGINATION CLICK
       ============================================================ */
    document.addEventListener('click', function (e) {
        var link = e.target.closest('#cs-cards-wrap .pgn-nav[href], #cs-cards-wrap .pgn-num[href]');
        if (!link) return;
        e.preventDefault();
        csLoadPage(link.href);
    });


    /* ============================================================
       SEARCH — debounced
       ============================================================ */
    var searchInput = document.getElementById('cs-search-input');
    var searchClear = document.getElementById('cs-search-clear');
    var searchTimer = null;

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            if (searchClear) searchClear.style.display = this.value ? 'flex' : 'none';
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function () { csLoadPage(csBuildUrl()); }, 420);
        });
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(searchTimer);
                csLoadPage(csBuildUrl());
            }
        });
    }
    if (searchClear) {
        searchClear.addEventListener('click', function () {
            if (searchInput) { searchInput.value = ''; this.style.display = 'none'; }
            csLoadPage(csBuildUrl());
        });
    }


    /* ============================================================
       SORT
       ============================================================ */
    document.addEventListener('click', function (e) {
        var opt = e.target.closest('.sfb-sort-item[data-sort]');
        if (!opt || opt.dataset.sortPrefix !== 'cs') return;
        e.preventDefault();
        var sortVal = document.getElementById('cs-sort-val');
        if (sortVal) sortVal.value = opt.dataset.sort;
        csLoadPage(csBuildUrl());
    });


    /* ============================================================
       FILTER — pill × remove
       ============================================================ */
    document.addEventListener('click', function (e) {
        var icon = e.target.closest('#cs-active-pills .sfb-pill i.fa-times');
        if (!icon) return;

        var pill = icon.closest('.sfb-pill');
        if (!pill) return;

        /* Deselect option in native select + sync Select2 */
        var sel = document.getElementById(pill.dataset.selectId);
        if (sel) {
            Array.from(sel.options).forEach(function (opt) {
                if (opt.value === pill.dataset.value) opt.selected = false;
            });
            if (typeof $ !== 'undefined') $(sel).trigger('change');
        }

        /* Remove pill */
        pill.remove();

        /* Update badge + clear button */
        var remaining = document.querySelectorAll('#cs-active-pills .sfb-pill').length;
        csUpdateBadge(remaining);

        csLoadPage(csBuildUrl());
    });


    /* ============================================================
       FILTER MODAL — sync select with active pills on open
       ============================================================ */
    var filterModal = document.getElementById('cs-filter-modal');
    if (filterModal) {
        filterModal.addEventListener('show.bs.modal', function () {
            var sel = document.getElementById('cs-category-select');
            var pillsWrap = document.getElementById('cs-active-pills');
            if (!sel || !pillsWrap) return;
            var activeCats = Array.from(
                pillsWrap.querySelectorAll('.sfb-pill[data-select-id="cs-category-select"]')
            ).map(function (p) { return p.dataset.value; });
            Array.from(sel.options).forEach(function (opt) {
                opt.selected = activeCats.indexOf(opt.value) !== -1;
            });
            if (typeof $ !== 'undefined') $(sel).trigger('change');
        });
    }


    /* ============================================================
       FILTER MODAL APPLY
       ============================================================ */
    document.addEventListener('click', function (e) {
        var applyBtn = e.target.closest('#cs-apply-filter');
        if (!applyBtn) return;

        var sel = document.getElementById('cs-category-select');
        var pillsWrap = document.getElementById('cs-active-pills');

        if (sel && pillsWrap) {
            /* Remove old category pills */
            pillsWrap.querySelectorAll('.sfb-pill[data-select-id="cs-category-select"]')
                .forEach(function (p) { p.remove(); });

            /* Create pills for each selected option */
            Array.from(sel.options).forEach(function (opt) {
                if (!opt.selected) return;
                var pill = document.createElement('span');
                pill.className = 'sfb-pill';
                pill.dataset.selectId = 'cs-category-select';
                pill.dataset.value = opt.value;
                pill.innerHTML = '<span>Kategori: ' + opt.text + '</span> <i class="fas fa-times"></i>';
                pillsWrap.appendChild(pill);
            });

            /* Update filter count badge + clear button */
            var count = Array.from(sel.options).filter(function (o) { return o.selected; }).length;
            csUpdateBadge(count);
        }

        /* Close modal */
        if (filterModal) {
            var bsModal = bootstrap.Modal.getInstance(filterModal);
            if (bsModal) bsModal.hide();
        }

        csLoadPage(csBuildUrl());
    });


    /* ============================================================
       FILTER MODAL RESET
       ============================================================ */
    document.addEventListener('click', function (e) {
        var resetBtn = e.target.closest('#cs-reset-filter');
        if (!resetBtn) return;

        /* Reset sort */
        var sortVal = document.getElementById('cs-sort-val');
        if (sortVal) sortVal.value = 'newest';

        /* Reset search */
        if (searchInput) { searchInput.value = ''; if (searchClear) searchClear.style.display = 'none'; }

        /* Reset select */
        var sel = document.getElementById('cs-category-select');
        if (sel) {
            Array.from(sel.options).forEach(function (o) { o.selected = false; });
            if (typeof $ !== 'undefined') $(sel).trigger('change');
        }

        /* Remove category pills */
        var pillsWrap = document.getElementById('cs-active-pills');
        if (pillsWrap) {
            pillsWrap.querySelectorAll('.sfb-pill[data-select-id="cs-category-select"]')
                .forEach(function (p) { p.remove(); });
        }

        /* Update badge + clear button */
        csUpdateBadge(0);

        setTimeout(function () { csLoadPage(csBuildUrl()); }, 50);
    });


    /* ============================================================
       FILTER CLEAR BUTTON (× next to Filter button)
       ============================================================ */
    var filterClearBtn = document.getElementById('cs-filter-clear');
    if (filterClearBtn) {
        filterClearBtn.addEventListener('click', function () {
            /* Deselect all */
            var sel = document.getElementById('cs-category-select');
            if (sel) {
                Array.from(sel.options).forEach(function (o) { o.selected = false; });
                if (typeof $ !== 'undefined') $(sel).trigger('change');
            }
            /* Remove all pills */
            var pillsWrap = document.getElementById('cs-active-pills');
            if (pillsWrap) pillsWrap.querySelectorAll('.sfb-pill').forEach(function (p) { p.remove(); });
            csUpdateBadge(0);
            csLoadPage(csBuildUrl());
        });
    }

});
</script>
