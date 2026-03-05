<script>
(function () {

    /* ── Reading progress bar ────────────────────────────────────── */
    var progress = document.getElementById('ed-progress');
    if (progress) {
        window.addEventListener('scroll', function () {
            var scrollTop = window.scrollY || document.documentElement.scrollTop;
            var docHeight = document.documentElement.scrollHeight - window.innerHeight;
            progress.style.width = (docHeight > 0 ? Math.min(scrollTop / docHeight * 100, 100) : 0) + '%';
        }, { passive: true });
    }

    /* ── Share helpers ───────────────────────────────────────────── */
    function showToast(ok) {
        if (typeof Swal === 'undefined') return;
        Swal.fire({
            toast: true, position: 'top-end',
            icon: ok ? 'success' : 'error',
            title: ok ? 'URL berhasil disalin!' : 'Gagal menyalin URL',
            showConfirmButton: false,
            timer: 2500, timerProgressBar: true,
            customClass: { container: 'ed-swal-below-nav' }
        });
    }

    window.edCopyUrl = function (ev) {
        if (ev) ev.stopPropagation();
        var url = window.location.href;
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(url)
                .then(function () { showToast(true); })
                .catch(function () { showToast(false); });
        } else {
            try {
                var ta = document.createElement('textarea');
                ta.value = url;
                ta.style.cssText = 'position:fixed;top:0;left:0;opacity:0;pointer-events:none;';
                document.body.appendChild(ta); ta.select();
                document.execCommand('copy');
                document.body.removeChild(ta);
                showToast(true);
            } catch (e) { showToast(false); }
        }
    };

    window.edShareWa = function (ev) {
        if (ev) ev.stopPropagation();
        var titleEl = document.getElementById('ed-event-title');
        var text = (titleEl ? titleEl.textContent.trim() + '\n' : '') + window.location.href;
        window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank');
    };

    window.edShareTw = function (ev) {
        if (ev) ev.stopPropagation();
        var titleEl = document.getElementById('ed-event-title');
        var text = (titleEl ? titleEl.textContent.trim() + ' — LDK Syahid\n' : '') + window.location.href;
        window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(text), '_blank');
    };

    /* ── Tab switcher ────────────────────────────────────────────── */
    window.edSwitchTab = function (btn, targetId) {
        var newPane = document.getElementById(targetId);
        var currentPane = document.querySelector('.ed-tab-pane.active');
        if (!newPane || (currentPane && currentPane.id === targetId)) return;

        /* update button states immediately */
        document.querySelectorAll('.ed-tab-btn').forEach(function (b) {
            b.classList.remove('active');
            b.setAttribute('aria-selected', 'false');
        });
        btn.classList.add('active');
        btn.setAttribute('aria-selected', 'true');

        if (currentPane) {
            /* fade out current pane, then show new */
            currentPane.classList.remove('active');
            currentPane.classList.add('ed-tab-leaving');
            setTimeout(function () {
                currentPane.classList.remove('ed-tab-leaving');
                newPane.classList.add('active');
            }, 200);
        } else {
            newPane.classList.add('active');
        }
    };

    /* ── Countdown timer ─────────────────────────────────────────── */
    var cdWrap = document.getElementById('ed-countdown-wrap');
    if (cdWrap) {
        var target = new Date(cdWrap.dataset.target);
        var elD = document.getElementById('ed-cd-days');
        var elH = document.getElementById('ed-cd-hours');
        var elM = document.getElementById('ed-cd-mins');
        var elS = document.getElementById('ed-cd-secs');

        function tick() {
            var diff = target - Date.now();
            if (diff <= 0) { clearInterval(_t); cdWrap.style.display = 'none'; return; }
            var d = Math.floor(diff / 86400000);
            var h = Math.floor(diff % 86400000 / 3600000);
            var m = Math.floor(diff % 3600000  / 60000);
            var s = Math.floor(diff % 60000    / 1000);
            if (elD) elD.textContent = String(d).padStart(2, '0');
            if (elH) elH.textContent = String(h).padStart(2, '0');
            if (elM) elM.textContent = String(m).padStart(2, '0');
            if (elS) elS.textContent = String(s).padStart(2, '0');
        }

        tick();
        var _t = setInterval(tick, 1000);
    }

})();

/* ── Disqus ──────────────────────────────────────────────────────── */
(function () {
    var d = document, s = d.createElement('script');
    s.src = 'https://https-ldksyah-id-1.disqus.com/embed.js';
    s.setAttribute('data-timestamp', +new Date());
    (d.head || d.body).appendChild(s);
})();
</script>
<noscript>
    Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a>
</noscript>
