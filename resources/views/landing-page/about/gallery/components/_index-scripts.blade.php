<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ============================================================
       1. HADITH SYSTEM (adapted from contact-us, gl- IDs)
       ============================================================ */

    function getFreshElements() {
        return {
            desktop: {
                arab:      document.getElementById('gl-arab-desktop'),
                text:      document.getElementById('gl-text-desktop'),
                source:    document.getElementById('gl-source-desktop'),
                number:    document.getElementById('gl-num-desktop'),
                wrapper:   document.getElementById('gl-wrapper-desktop'),
                toggle:    document.getElementById('gl-toggle-desktop'),
                countdown: document.getElementById('gl-countdown-desktop'),
            },
            mobile: {
                arab:      document.getElementById('gl-arab-mobile'),
                text:      document.getElementById('gl-text-mobile'),
                source:    document.getElementById('gl-source-mobile'),
                number:    document.getElementById('gl-num-mobile'),
                wrapper:   document.getElementById('gl-wrapper-mobile'),
                toggle:    document.getElementById('gl-toggle-mobile'),
                countdown: document.getElementById('gl-countdown-mobile'),
            }
        };
    }

    function getTextElements() {
        var el = getFreshElements();
        return [
            el.desktop.arab, el.desktop.text, el.desktop.number, el.desktop.source,
            el.mobile.arab,  el.mobile.text,  el.mobile.number,  el.mobile.source,
        ].filter(function (e) { return e && e.classList.contains('hadith-fade-text'); });
    }

    var books = [
        { id: 'bukhari',    name: 'HR. Bukhari',    max: 6638 },
        { id: 'muslim',     name: 'HR. Muslim',     max: 4930 },
        { id: 'abu-daud',   name: 'HR. Abu Daud',   max: 4419 },
        { id: 'tirmidzi',   name: 'HR. Tirmidzi',   max: 3625 },
        { id: 'ibnu-majah', name: 'HR. Ibnu Majah', max: 4285 },
        { id: 'nasai',      name: 'HR. Nasai',      max: 5364 },
    ];

    var timeLeft = 60, countdownInterval, isFetching = false, retryCount = 0, MAX_RETRY = 5, retryTimeout = null;

    /* Toggle expand/collapse */
    document.addEventListener('click', function (e) {
        if (e.target.closest('#gl-toggle-desktop')) {
            var t = document.getElementById('gl-toggle-desktop'),
                w = document.getElementById('gl-wrapper-desktop');
            if (t && w) {
                e.preventDefault();
                var exp = w.classList.toggle('expanded');
                t.classList.toggle('expanded');
                var s = t.querySelector('.toggle-text');
                if (s) s.textContent = exp ? 'Sembunyikan' : 'Selengkapnya';
            }
        }
        if (e.target.closest('#gl-toggle-mobile')) {
            var tm = document.getElementById('gl-toggle-mobile'),
                wm = document.getElementById('gl-wrapper-mobile');
            if (tm && wm) {
                e.preventDefault();
                var expm = wm.classList.toggle('expanded');
                tm.classList.toggle('expanded');
                var sm = tm.querySelector('.hadith-toggle-text');
                if (sm) sm.textContent = expm ? 'Sembunyikan' : 'Selengkapnya';
            }
        }
    });

    function checkOverflow() {
        var dw = document.getElementById('gl-wrapper-desktop'), dt = document.getElementById('gl-toggle-desktop');
        var mw = document.getElementById('gl-wrapper-mobile'),  mt = document.getElementById('gl-toggle-mobile');
        if (dw && dt) dt.style.display = dw.scrollHeight > 150 ? 'inline-flex' : 'none';
        if (mw && mt) mt.style.display = mw.scrollHeight > 150 ? 'inline-flex' : 'none';
    }

    function updateCountdown() {
        var d = document.getElementById('gl-countdown-desktop'), m = document.getElementById('gl-countdown-mobile');
        if (d) d.textContent = timeLeft;
        if (m) m.textContent = timeLeft;
    }

    function resetCountdown() { timeLeft = 60; updateCountdown(); }

    function startCountdown() {
        if (countdownInterval) clearInterval(countdownInterval);
        countdownInterval = setInterval(function () {
            timeLeft--;
            updateCountdown();
            if (timeLeft <= 0) { timeLeft = 60; fetchRandomHadith(); }
        }, 1000);
    }

    function fadeOutElements(cb) {
        var elems = getTextElements(), done = 0, total = elems.length;
        if (total === 0) { cb(); return; }
        elems.forEach(function (el) { el.classList.add('fade-out'); });
        elems.forEach(function (el) {
            var h = function () {
                el.removeEventListener('transitionend', h);
                if (++done === total) cb();
            };
            el.addEventListener('transitionend', h);
            setTimeout(function () {
                if (el.classList.contains('fade-out') && done < total) {
                    el.removeEventListener('transitionend', h);
                    if (++done === total) cb();
                }
            }, 600);
        });
    }

    function fadeInElements() { getTextElements().forEach(function (el) { el.classList.remove('fade-out'); }); }

    function showErrorMessage(msg, showRetry) {
        if (showRetry === undefined) showRetry = true;
        var el = getFreshElements();
        var txt = (showRetry && retryCount > 0) ? msg + ' (Percobaan ke-' + retryCount + '/' + MAX_RETRY + ')' : msg;
        if (el.desktop.text)   el.desktop.text.innerHTML   = txt;
        if (el.mobile.text)    el.mobile.text.innerHTML    = txt;
        if (el.desktop.source) el.desktop.source.textContent = 'Hadits dalam 1 Menit';
        if (el.mobile.source)  el.mobile.source.textContent  = 'Hadits dalam 1 Menit';
        if (el.desktop.arab)   el.desktop.arab.textContent   = '';
        if (el.mobile.arab)    el.mobile.arab.textContent    = '';
        if (el.desktop.number) el.desktop.number.textContent = '';
        if (el.mobile.number)  el.mobile.number.textContent  = '';
        if (el.desktop.toggle) el.desktop.toggle.style.display = 'none';
        if (el.mobile.toggle)  el.mobile.toggle.style.display  = 'none';
    }

    function scheduleRetry(delay) {
        if (retryTimeout) clearTimeout(retryTimeout);
        if (retryCount < MAX_RETRY) {
            retryTimeout = setTimeout(function () { fetchRandomHadith(); }, delay || 3000);
        } else {
            showErrorMessage('Gagal memuat hadits setelah beberapa kali percobaan. Silakan refresh halaman.', false);
            retryCount = 0;
        }
    }

    function fetchRandomHadith() {
        if (isFetching) return;
        isFetching = true;
        fadeOutElements(function () {
            var book   = books[Math.floor(Math.random() * books.length)];
            var number = Math.floor(Math.random() * book.max) + 1;
            var ctrl   = new AbortController();
            var tId    = setTimeout(function () { ctrl.abort(); }, 10000);

            fetch('https://api.hadith.gading.dev/books/' + book.id + '/' + number, { signal: ctrl.signal })
            .then(function (r) { clearTimeout(tId); return r.json(); })
            .then(function (json) {
                if (json.code === 200 && json.data && json.data.contents) {
                    retryCount = 0;
                    var c  = json.data.contents;
                    var el = getFreshElements();
                    if (el.desktop.wrapper) el.desktop.wrapper.classList.remove('expanded');
                    if (el.mobile.wrapper)  el.mobile.wrapper.classList.remove('expanded');
                    if (el.desktop.toggle) { el.desktop.toggle.classList.remove('expanded'); var sd = el.desktop.toggle.querySelector('.toggle-text'); if (sd) sd.textContent = 'Selengkapnya'; }
                    if (el.mobile.toggle)  { el.mobile.toggle.classList.remove('expanded');  var sm = el.mobile.toggle.querySelector('.hadith-toggle-text'); if (sm) sm.textContent = 'Selengkapnya'; }
                    if (el.desktop.arab)   el.desktop.arab.textContent   = c.arab;
                    if (el.desktop.text)   el.desktop.text.innerHTML     = '\u201c' + c.id + '\u201d';
                    if (el.desktop.source) el.desktop.source.textContent = book.name;
                    if (el.desktop.number) el.desktop.number.textContent = book.name + ' No. ' + c.number;
                    if (el.mobile.arab)    el.mobile.arab.textContent    = c.arab;
                    if (el.mobile.text)    el.mobile.text.innerHTML      = '\u201c' + c.id + '\u201d';
                    if (el.mobile.source)  el.mobile.source.textContent  = book.name;
                    if (el.mobile.number)  el.mobile.number.textContent  = book.name + ' No. ' + c.number;
                    fadeInElements();
                    setTimeout(checkOverflow, 100);
                    resetCountdown();
                } else { throw new Error('Invalid response'); }
            })
            .catch(function (e) {
                console.error('Hadith fetch error:', e);
                retryCount++;
                var msg = e.name === 'AbortError' ? 'Timeout memuat hadits.' : (e.message === 'Failed to fetch' ? 'Koneksi terputus.' : 'Gagal memuat hadits.');
                showErrorMessage(msg);
                fadeInElements();
                scheduleRetry(3000);
            })
            .finally(function () { isFetching = false; });
        });
    }

    fetchRandomHadith();
    startCountdown();

    /* ============================================================
       2. OWL CAROUSEL — mobile gallery cards
       ============================================================ */
    if (typeof jQuery !== 'undefined' && typeof jQuery.fn.owlCarousel !== 'undefined') {
        var $owl = jQuery('#gl-mobile-owl');
        if ($owl.length) {
            $owl.owlCarousel({
                items: 1,
                loop: false,
                margin: 12,
                nav: false,
                dots: false,
                pullDrag: true,
                touchDrag: true,
                mouseDrag: false,
                animateOut: false,
                autoplay: false,
                smartSpeed: 350,
                responsive: { 0: { items: 1 }, 480: { items: 1, margin: 16 } },
                onInitialized: function (e) { buildGlDots(e); },
                onTranslated:  function (e) { updateGlDots(e); }
            });
        }

        function buildGlDots(e) {
            var dotsEl = document.getElementById('gl-owl-dots');
            if (!dotsEl) return;
            dotsEl.innerHTML = '';
            var count = e.item.count;
            for (var i = 0; i < count; i++) {
                var d = document.createElement('div');
                d.className = 'gl-owl-dot' + (i === 0 ? ' active' : '');
                d.dataset.idx = i;
                d.addEventListener('click', function () {
                    $owl.trigger('to.owl.carousel', [parseInt(this.dataset.idx), 300]);
                });
                dotsEl.appendChild(d);
            }
        }

        function updateGlDots(e) {
            var dots = document.querySelectorAll('.gl-owl-dot');
            dots.forEach(function (d, i) { d.classList.toggle('active', i === e.item.index % e.item.count); });
        }
    }

    /* ============================================================
       3. BACK-TO-TOP: hide when modal/sheet open
       ============================================================ */
    var btt = document.querySelector('.back-to-top');

    function hideBtt() { if (btt) { btt.style.transition = 'opacity .3s,visibility .3s'; btt.style.opacity = '0'; btt.style.visibility = 'hidden'; } }
    function showBtt() { if (btt) { btt.style.opacity = ''; btt.style.visibility = ''; } }

    /* ============================================================
       4. BODY SCROLL LOCK helpers
       ============================================================ */
    var scrollY = 0;
    function lockScroll()   { scrollY = window.scrollY; document.body.style.overflow = 'hidden'; document.body.style.position = 'fixed'; document.body.style.top = -scrollY + 'px'; document.body.style.width = '100%'; }
    function unlockScroll() { document.body.style.overflow = ''; document.body.style.position = ''; document.body.style.top = ''; document.body.style.width = ''; window.scrollTo(0, scrollY); }

    /* ============================================================
       5. PHOTO ZOOM OVERLAY
       ============================================================ */
    var zoomPhotos = [], zoomIdx = 0;

    function glOpenZoom(photos, startIdx) {
        zoomPhotos = photos;
        zoomIdx    = startIdx;
        renderZoom();
        var overlay = document.getElementById('gl-zoom-overlay');
        if (overlay) overlay.classList.add('active');
    }

    function renderZoom() {
        var img  = document.getElementById('gl-zoom-img');
        var ctr  = document.getElementById('gl-zoom-counter');
        if (img) img.src = 'https://lh3.googleusercontent.com/d/' + zoomPhotos[zoomIdx];
        if (ctr) ctr.textContent = (zoomIdx + 1) + ' / ' + zoomPhotos.length;
    }

    function glCloseZoom() {
        var overlay = document.getElementById('gl-zoom-overlay');
        if (overlay) overlay.classList.remove('active');
    }

    document.getElementById('gl-zoom-close').addEventListener('click', glCloseZoom);
    document.getElementById('gl-zoom-prev').addEventListener('click', function () {
        zoomIdx = (zoomIdx - 1 + zoomPhotos.length) % zoomPhotos.length;
        renderZoom();
    });
    document.getElementById('gl-zoom-next').addEventListener('click', function () {
        zoomIdx = (zoomIdx + 1) % zoomPhotos.length;
        renderZoom();
    });
    document.getElementById('gl-zoom-overlay').addEventListener('click', function (e) {
        if (e.target === this) glCloseZoom();
    });

    /* Keyboard nav for zoom */
    document.addEventListener('keydown', function (e) {
        var overlay = document.getElementById('gl-zoom-overlay');
        if (overlay && overlay.classList.contains('active')) {
            if (e.key === 'ArrowLeft')  { zoomIdx = (zoomIdx - 1 + zoomPhotos.length) % zoomPhotos.length; renderZoom(); }
            if (e.key === 'ArrowRight') { zoomIdx = (zoomIdx + 1) % zoomPhotos.length; renderZoom(); }
            if (e.key === 'Escape')     glCloseZoom();
        }
    });

    /* ============================================================
       6. DESKTOP GALLERY MODAL
       ============================================================ */
    window.glOpenModal = function (idx) {
        var data = GL_DATA[idx];
        if (!data) return;

        /* Header */
        document.getElementById('gl-modal-num').textContent   = data.num;
        document.getElementById('gl-modal-event').textContent = data.name;
        document.getElementById('gl-modal-title').textContent = data.theme;

        /* Build body */
        var body = document.getElementById('gl-modal-body');
        body.innerHTML = buildModalBody(data);

        /* Attach photo zoom clicks */
        body.querySelectorAll('.gl-modal-photo').forEach(function (el) {
            el.addEventListener('click', function () {
                glOpenZoom(data.photos, parseInt(this.dataset.photoIdx));
            });
        });

        /* Open */
        document.getElementById('gl-modal-backdrop').classList.add('active');
        document.getElementById('gl-modal').classList.add('active');
        lockScroll();
        hideBtt();
    };

    function buildModalBody(data) {
        var html = '';

        /* Description */
        if (data.desc) {
            html += '<p class="gl-modal-desc">' + escHtml(data.desc) + '</p>';
        }

        /* Photo grid */
        if (data.photos.length > 0) {
            html += '<div class="gl-modal-grid">';
            data.photos.forEach(function (pid, i) {
                html += '<div class="gl-modal-photo" data-photo-idx="' + i + '">'
                     +  '<img src="https://lh3.googleusercontent.com/d/' + escHtml(pid) + '" alt="Foto ' + (i+1) + '" loading="lazy">'
                     +  '</div>';
            });
            html += '</div>';
        }

        /* YouTube */
        if (data.videoId) {
            var thumb = 'https://img.youtube.com/vi/' + data.videoId + '/maxresdefault.jpg';
            var ytUrl = 'https://www.youtube.com/watch?v=' + data.videoId;
            html += '<div class="gl-modal-video-section">'
                 +  '<div class="gl-modal-video-label"><i class="fab fa-youtube"></i> Video Dokumentasi</div>'
                 +  '<a href="' + escHtml(ytUrl) + '" target="_blank" rel="noopener" class="gl-modal-video-thumb">'
                 +  '<img src="' + escHtml(thumb) + '" alt="YouTube" '
                 +  'onerror="this.src=\'https://img.youtube.com/vi/' + escHtml(data.videoId) + '/hqdefault.jpg\'">'
                 +  '<div class="gl-modal-play-btn"><i class="fas fa-play"></i></div>'
                 +  '</a></div>';
        }

        /* Doc link */
        if (data.linkDoc) {
            html += '<a href="' + escHtml(data.linkDoc) + '" target="_blank" rel="noopener" class="gl-modal-doc">'
                 +  '<i class="fas fa-folder-open"></i> Dokumentasi Lengkap</a>';
        }

        return html;
    }

    function glCloseModal() {
        document.getElementById('gl-modal-backdrop').classList.remove('active');
        document.getElementById('gl-modal').classList.remove('active');
        unlockScroll();
        showBtt();
    }

    document.getElementById('gl-modal-close').addEventListener('click', glCloseModal);
    document.getElementById('gl-modal-backdrop').addEventListener('click', glCloseModal);
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            var overlay = document.getElementById('gl-zoom-overlay');
            if (overlay && overlay.classList.contains('active')) { glCloseZoom(); return; }
            if (document.getElementById('gl-modal').classList.contains('active')) glCloseModal();
            if (document.getElementById('gl-bottom-sheet').classList.contains('active')) glCloseBs();
        }
    });

    /* ============================================================
       7. MOBILE BOTTOM SHEET
       ============================================================ */
    window.glOpenBottomSheet = function (idx) {
        var data = GL_DATA[idx];
        if (!data) return;

        var content = document.getElementById('gl-bs-content');
        content.innerHTML = buildBsBody(data);

        /* Photo tap → zoom */
        content.querySelectorAll('.gl-bs-photo').forEach(function (el) {
            el.addEventListener('click', function () {
                glOpenZoom(data.photos, parseInt(this.dataset.photoIdx));
            });
        });

        document.getElementById('gl-bs-backdrop').classList.add('active');
        document.getElementById('gl-bottom-sheet').classList.add('active');
        lockScroll();
        hideBtt();
    };

    function buildBsBody(data) {
        var html = '<div class="gl-bs-header">'
                 + '<div class="gl-bs-meta">'
                 + '<span class="gl-bs-num">' + escHtml(data.num) + '</span>'
                 + '<span class="gl-bs-tag">' + escHtml(data.name) + '</span>'
                 + '</div>'
                 + '<h5 class="gl-bs-title">' + escHtml(data.theme) + '</h5>'
                 + (data.desc ? '<p class="gl-bs-desc">' + escHtml(data.desc) + '</p>' : '')
                 + '</div>';

        /* Photo grid (2-col, first photo spans 2 cols) */
        if (data.photos.length > 0) {
            html += '<div class="gl-bs-photo-grid">';
            data.photos.forEach(function (pid, i) {
                html += '<div class="gl-bs-photo" data-photo-idx="' + i + '">'
                     +  '<img src="https://lh3.googleusercontent.com/d/' + escHtml(pid) + '" alt="Foto ' + (i+1) + '" loading="lazy">'
                     +  '</div>';
            });
            html += '</div>';
        }

        /* Video */
        if (data.videoId) {
            var thumb = 'https://img.youtube.com/vi/' + data.videoId + '/maxresdefault.jpg';
            var ytUrl = 'https://www.youtube.com/watch?v=' + data.videoId;
            html += '<div class="gl-bs-video">'
                 +  '<div class="gl-bs-video-label"><i class="fab fa-youtube"></i> Video Dokumentasi</div>'
                 +  '<a href="' + escHtml(ytUrl) + '" target="_blank" rel="noopener" class="gl-bs-video-thumb">'
                 +  '<img src="' + escHtml(thumb) + '" alt="YouTube" '
                 +  'onerror="this.src=\'https://img.youtube.com/vi/' + escHtml(data.videoId) + '/hqdefault.jpg\'">'
                 +  '<div class="gl-bs-play-btn"><i class="fas fa-play"></i></div>'
                 +  '</a></div>';
        }

        /* Doc link */
        if (data.linkDoc) {
            html += '<div class="gl-bs-actions">'
                 +  '<a href="' + escHtml(data.linkDoc) + '" target="_blank" rel="noopener" class="gl-bs-doc">'
                 +  '<i class="fas fa-folder-open"></i> Dokumentasi Lengkap</a>'
                 +  '</div>';
        }

        return html;
    }

    function glCloseBs() {
        document.getElementById('gl-bs-backdrop').classList.remove('active');
        document.getElementById('gl-bottom-sheet').classList.remove('active');
        unlockScroll();
        showBtt();
    }
    window.glCloseBs = glCloseBs;

    document.getElementById('gl-bs-close').addEventListener('click', glCloseBs);
    document.getElementById('gl-bs-backdrop').addEventListener('click', glCloseBs);

    /* ============================================================
       8. UTILITY
       ============================================================ */
    function escHtml(str) {
        if (str == null) return '';
        return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

}); /* end DOMContentLoaded */
</script>
