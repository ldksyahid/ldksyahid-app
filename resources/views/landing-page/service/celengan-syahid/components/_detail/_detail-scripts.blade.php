<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Live countdown: switch to HH:MM:SS once under 24h remain ── */
    var cdBadge = document.querySelector('.cd-live-countdown[data-deadline-ts]');
    if (cdBadge) {
        var cdDeadlineTs   = parseInt(cdBadge.dataset.deadlineTs, 10);
        var cdOriginalText = cdBadge.textContent;

        function cdPad2(n) { return String(n).padStart(2, '0'); }

        function cdTickCountdown() {
            var remainingMs = cdDeadlineTs * 1000 - Date.now();
            if (remainingMs <= 0) {
                cdBadge.textContent = 'Berakhir';
                cdBadge.classList.add('ended');
                return;
            }
            if (remainingMs >= 86400000) {
                cdBadge.textContent = cdOriginalText;
                return;
            }

            var totalSeconds = Math.floor(remainingMs / 1000);
            var h = Math.floor(totalSeconds / 3600);
            var m = Math.floor((totalSeconds % 3600) / 60);
            var s = totalSeconds % 60;
            cdBadge.textContent = cdPad2(h) + ':' + cdPad2(m) + ':' + cdPad2(s);
        }

        cdTickCountdown();
        setInterval(cdTickCountdown, 1000);
    }

    /* ── Tab switching ── */
    var tabs  = document.querySelectorAll('.cd-tab');
    var panes = document.querySelectorAll('.cd-tab-pane');

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            var target = this.dataset.target;

            tabs.forEach(function (t) { t.classList.remove('active'); });
            panes.forEach(function (p) { p.classList.remove('active'); });

            this.classList.add('active');
            var pane = document.getElementById(target);
            if (pane) pane.classList.add('active');
        });
    });

    /* ── Share: Copy URL ── */
    window.cdCopyUrl = function (ev) {
        if (ev) ev.preventDefault();
        var url = window.location.href;
        function showToast(ok) {
            if (typeof Swal === 'undefined') return;
            Swal.fire({
                toast: true, position: 'top-end',
                icon: ok ? 'success' : 'error',
                title: ok ? 'URL berhasil disalin!' : 'Gagal menyalin URL',
                showConfirmButton: false, timer: 2500, timerProgressBar: true
            });
        }
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(url)
                .then(function () { showToast(true); })
                .catch(function () { showToast(false); });
        } else {
            try {
                var ta = document.createElement('textarea');
                ta.value = url;
                ta.style.cssText = 'position:fixed;top:0;left:0;opacity:0;pointer-events:none;';
                document.body.appendChild(ta); ta.select(); document.execCommand('copy');
                document.body.removeChild(ta); showToast(true);
            } catch (e) { showToast(false); }
        }
    };

    /* ── Donor list: show 5 at a time ── */
    var loadMoreBtn  = document.getElementById('cd-donor-loadmore');
    var loadMoreWrap = document.getElementById('cd-donor-loadmore-wrap');
    var loadMoreText = document.getElementById('cd-donor-loadmore-text');
    var loadMoreCount= document.getElementById('cd-donor-loadmore-count');
    var BATCH        = 5;

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function () {
            var hidden = document.querySelectorAll('#cd-donor-list .cd-donor-hidden');
            var toShow = Array.from(hidden).slice(0, BATCH);

            toShow.forEach(function (item, i) {
                item.classList.remove('cd-donor-hidden');
                /* stagger: each item reveals 60ms after the previous */
                setTimeout(function () {
                    item.style.display = 'flex';
                    item.classList.add('cd-donor-reveal');
                }, i * 60);
            });

            /* Update button state */
            var remaining = document.querySelectorAll('#cd-donor-list .cd-donor-hidden').length;
            if (remaining === 0) {
                if (loadMoreWrap) loadMoreWrap.style.display = 'none';
            } else {
                if (loadMoreCount) loadMoreCount.textContent = '(' + remaining + ' lagi)';
            }
        });
    }

    /* ── Progress bar animated fill on scroll ── */
    var fills = document.querySelectorAll('.cd-progress-fill');
    if ('IntersectionObserver' in window && fills.length) {
        var widths = [];
        fills.forEach(function (fill, i) {
            widths[i] = fill.style.width;
            fill.style.width = '0%';
        });
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                var idx = Array.from(fills).indexOf(entry.target);
                entry.target.style.width = widths[idx];
                io.unobserve(entry.target);
            });
        }, { threshold: .1 });
        fills.forEach(function (fill) { io.observe(fill); });
    }

});
</script>
