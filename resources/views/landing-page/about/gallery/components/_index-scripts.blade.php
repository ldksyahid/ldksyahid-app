{{-- ── Hero Jumbotron hadith system ── --}}
@include('components.hero-jumbotron.scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ============================================================
       1. AJAX PAGINATION
       ============================================================ */
    document.addEventListener('click', function (e) {
        var link = e.target.closest('#gl-cards-wrap .pgn-nav[href], #gl-cards-wrap .pgn-num[href]');
        if (!link) return;
        e.preventDefault();
        glLoadPage(link.href);
    });

    function glLoadPage(url) {
        var wrap = document.getElementById('gl-cards-wrap');

        /* 1. Fade-out + slide down */
        if (wrap) wrap.classList.add('gl-cards-out');

        /* 2. Smooth scroll ke section header */
        var section = document.getElementById('gl-gallery-section');
        if (section) {
            var top = section.getBoundingClientRect().top + window.scrollY - 90;
            window.scrollTo({ top: top, behavior: 'smooth' });
        }

        /* 3. Fetch data — parallel dengan fade & scroll.
              Tunggu keduanya (fetch + min 350ms fade) selesai dulu. */
        var minDelay   = new Promise(function (res) { setTimeout(res, 350); });
        var fetchData  = fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                            .then(function (r) { return r.json(); });

        Promise.all([fetchData, minDelay])
            .then(function (results) {
                var data = results[0];
                if (wrap) {
                    wrap.innerHTML = data.html;
                    /* Dua frame sebelum hapus class agar browser sempat paint dulu */
                    requestAnimationFrame(function () {
                        requestAnimationFrame(function () {
                            wrap.classList.remove('gl-cards-out');
                        });
                    });
                }
                GL_DATA = data.glData;
            })
            .catch(function () {
                if (wrap) wrap.classList.remove('gl-cards-out');
                window.location.href = url;
            });
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
    /* Scroll lock: hanya pakai overflow:hidden — TIDAK position:fixed agar navbar tetap terlihat */
    function lockScroll()   { document.body.classList.add('gl-sheet-open'); }
    function unlockScroll() { document.body.classList.remove('gl-sheet-open'); }

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

    /* Open zoom from inline desktop grid */
    window.glOpenZoomInline = function (dataIdx, photoIdx) {
        var data = GL_DATA[dataIdx];
        if (data && data.photos && data.photos.length > 0) {
            glOpenZoom(data.photos, photoIdx);
        }
    };

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
       6. VIDEO LIGHTBOX (YouTube embed)
       ============================================================ */
    window.glOpenVideo = function (videoId) {
        var iframe = document.getElementById('gl-video-iframe');
        if (iframe) iframe.src = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1';
        document.getElementById('gl-video-overlay').classList.add('active');
        lockScroll();
        hideBtt();
    };

    function glCloseVideo() {
        var iframe = document.getElementById('gl-video-iframe');
        if (iframe) iframe.src = '';
        document.getElementById('gl-video-overlay').classList.remove('active');
        unlockScroll();
        showBtt();
    }

    document.getElementById('gl-video-close').addEventListener('click', glCloseVideo);
    document.getElementById('gl-video-overlay').addEventListener('click', function (e) {
        if (e.target === this) glCloseVideo();
    });

    /* Escape key — close in priority: zoom > video > bottom sheet */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            var zoomOverlay  = document.getElementById('gl-zoom-overlay');
            var videoOverlay = document.getElementById('gl-video-overlay');
            var bs           = document.getElementById('gl-bottom-sheet');
            if (zoomOverlay  && zoomOverlay.classList.contains('active'))  { glCloseZoom();  return; }
            if (videoOverlay && videoOverlay.classList.contains('active')) { glCloseVideo(); return; }
            if (bs           && bs.classList.contains('active'))           { glCloseBs();    return; }
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
            html += '<div class="gl-bs-video">'
                 +  '<div class="gl-bs-video-label"><i class="fab fa-youtube"></i> Video Dokumentasi</div>'
                 +  '<div class="gl-bs-video-thumb" onclick="glOpenVideo(\'' + escHtml(data.videoId) + '\')">'
                 +  '<img src="' + escHtml(thumb) + '" alt="YouTube" '
                 +  'onerror="this.src=\'https://img.youtube.com/vi/' + escHtml(data.videoId) + '/hqdefault.jpg\'">'
                 +  '<div class="gl-bs-play-btn"><i class="fas fa-play"></i></div>'
                 +  '</div></div>';
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
