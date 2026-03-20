<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ============================================================
       1. VIEWPORT ANIMATIONS (section header)
       ============================================================ */
    var animEls = document.querySelectorAll('.gallery-header-wrap');
    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });
        animEls.forEach(function (el) { observer.observe(el); });
    } else {
        animEls.forEach(function (el) { el.classList.add('is-visible'); });
    }

    /* ============================================================
       2. BACK-TO-TOP — sembunyikan saat overlay terbuka
       ============================================================ */
    var btt = document.querySelector('.back-to-top');
    function hideBtt() { if (btt) { btt.style.transition = 'opacity .3s,visibility .3s'; btt.style.opacity = '0'; btt.style.visibility = 'hidden'; } }
    function showBtt() { if (btt) { btt.style.opacity = ''; btt.style.visibility = ''; } }

    /* ============================================================
       3. SCROLL LOCK helpers
       ============================================================ */
    function lockScroll() {}
    function unlockScroll() {}

    /* ============================================================
       4. PHOTO ZOOM OVERLAY
       ============================================================ */
    var zoomPhotos = [], zoomIdx = 0;

    function hglOpenZoom(photos, startIdx) {
        zoomPhotos = photos;
        zoomIdx    = startIdx;
        renderZoom();
        var overlay = document.getElementById('hgl-zoom-overlay');
        if (overlay) overlay.classList.add('active');
    }

    function renderZoom() {
        var img = document.getElementById('hgl-zoom-img');
        var ctr = document.getElementById('hgl-zoom-counter');
        if (img) img.src = 'https://lh3.googleusercontent.com/d/' + zoomPhotos[zoomIdx];
        if (ctr) ctr.textContent = (zoomIdx + 1) + ' / ' + zoomPhotos.length;
    }

    function hglCloseZoom() {
        var overlay = document.getElementById('hgl-zoom-overlay');
        if (overlay) overlay.classList.remove('active');
    }

    document.getElementById('hgl-zoom-close').addEventListener('click', hglCloseZoom);
    document.getElementById('hgl-zoom-prev').addEventListener('click', function () {
        zoomIdx = (zoomIdx - 1 + zoomPhotos.length) % zoomPhotos.length;
        renderZoom();
    });
    document.getElementById('hgl-zoom-next').addEventListener('click', function () {
        zoomIdx = (zoomIdx + 1) % zoomPhotos.length;
        renderZoom();
    });
    document.getElementById('hgl-zoom-overlay').addEventListener('click', function (e) {
        if (e.target === this) hglCloseZoom();
    });

    /* Dipanggil dari onclick di markup Blade */
    window.hglOpenZoomInline = function (dataIdx, photoIdx) {
        var data = HGL_DATA[dataIdx];
        if (data && data.photos && data.photos.length > 0) {
            hglOpenZoom(data.photos, photoIdx);
        }
    };

    /* ============================================================
       5. VIDEO LIGHTBOX (YouTube embed)
       ============================================================ */
    window.hglOpenVideo = function (videoId) {
        var iframe = document.getElementById('hgl-video-iframe');
        if (iframe) iframe.src = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1';
        document.getElementById('hgl-video-overlay').classList.add('active');
        lockScroll(document.getElementById('hgl-video-overlay'));
        hideBtt();
    };

    function hglCloseVideo() {
        var iframe = document.getElementById('hgl-video-iframe');
        if (iframe) iframe.src = '';
        document.getElementById('hgl-video-overlay').classList.remove('active');
        unlockScroll();
        showBtt();
    }

    document.getElementById('hgl-video-close').addEventListener('click', hglCloseVideo);
    document.getElementById('hgl-video-overlay').addEventListener('click', function (e) {
        if (e.target === this) hglCloseVideo();
    });

    /* ============================================================
       6. ESCAPE KEY — prioritas: zoom > video > bottom sheet
       ============================================================ */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            var zoomOverlay  = document.getElementById('hgl-zoom-overlay');
            var videoOverlay = document.getElementById('hgl-video-overlay');
            var bs           = document.getElementById('hgl-bottom-sheet');
            if (zoomOverlay  && zoomOverlay.classList.contains('active'))  { hglCloseZoom();  return; }
            if (videoOverlay && videoOverlay.classList.contains('active')) { hglCloseVideo(); return; }
            if (bs           && bs.classList.contains('active'))           { hglCloseBs();    return; }
        }
        /* Arrow keys untuk zoom */
        var zoomOverlay = document.getElementById('hgl-zoom-overlay');
        if (zoomOverlay && zoomOverlay.classList.contains('active')) {
            if (e.key === 'ArrowLeft')  { zoomIdx = (zoomIdx - 1 + zoomPhotos.length) % zoomPhotos.length; renderZoom(); }
            if (e.key === 'ArrowRight') { zoomIdx = (zoomIdx + 1) % zoomPhotos.length; renderZoom(); }
        }
    });

    /* ============================================================
       7. MOBILE BOTTOM SHEET
       ============================================================ */
    window.hglOpenBottomSheet = function (idx) {
        var data = HGL_DATA[idx];
        if (!data) return;

        var content = document.getElementById('hgl-bs-content');
        content.innerHTML = buildBsBody(data);

        /* Foto di bottom sheet → buka zoom */
        content.querySelectorAll('.gl-bs-photo').forEach(function (el) {
            el.addEventListener('click', function () {
                hglOpenZoom(data.photos, parseInt(this.dataset.photoIdx));
            });
        });

        document.getElementById('hgl-bs-backdrop').classList.add('active');
        document.getElementById('hgl-bottom-sheet').classList.add('active');
        lockScroll(document.getElementById('hgl-bottom-sheet'));
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

        if (data.photos.length > 0) {
            html += '<div class="gl-bs-photo-grid">';
            data.photos.forEach(function (pid, i) {
                html += '<div class="gl-bs-photo" data-photo-idx="' + i + '">'
                     +  '<img src="https://lh3.googleusercontent.com/d/' + escHtml(pid) + '" alt="Foto ' + (i + 1) + '" loading="lazy">'
                     +  '</div>';
            });
            html += '</div>';
        }

        if (data.videoId) {
            var thumb = 'https://img.youtube.com/vi/' + data.videoId + '/maxresdefault.jpg';
            html += '<div class="gl-bs-video">'
                 +  '<div class="gl-bs-video-label"><i class="fab fa-youtube"></i> Video Dokumentasi</div>'
                 +  '<div class="gl-bs-video-thumb" onclick="hglOpenVideo(\'' + escHtml(data.videoId) + '\')">'
                 +  '<img src="' + escHtml(thumb) + '" alt="YouTube" '
                 +  'onerror="this.src=\'https://img.youtube.com/vi/' + escHtml(data.videoId) + '/hqdefault.jpg\'">'
                 +  '<div class="gl-bs-play-btn"><i class="fas fa-play"></i></div>'
                 +  '</div></div>';
        }

        if (data.linkDoc) {
            html += '<div class="gl-bs-actions">'
                 +  '<a href="' + escHtml(data.linkDoc) + '" target="_blank" rel="noopener" class="gl-bs-doc">'
                 +  '<i class="fas fa-folder-open"></i> Dokumentasi Lengkap</a>'
                 +  '</div>';
        }

        return html;
    }

    function hglCloseBs() {
        document.getElementById('hgl-bs-backdrop').classList.remove('active');
        document.getElementById('hgl-bottom-sheet').classList.remove('active');
        unlockScroll();
        showBtt();
    }
    window.hglCloseBs = hglCloseBs;

    document.getElementById('hgl-bs-close').addEventListener('click', hglCloseBs);
    document.getElementById('hgl-bs-backdrop').addEventListener('click', hglCloseBs);

    /* ============================================================
       8. UTILITY
       ============================================================ */
    function escHtml(str) {
        if (str == null) return '';
        return String(str)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;')
            .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

}); /* end DOMContentLoaded */
</script>
