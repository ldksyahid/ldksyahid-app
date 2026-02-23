@verbatim
<script>
(function () {
    /* ================================================================
       HERO JUMBOTRON — Hadith System
       Uses hj- prefix IDs (matches hero-jumbotron component HTML.
       ================================================================ */

    function getFreshElements() {
        return {
            desktop: {
                arab:      document.getElementById('hj-arab-desktop'),
                text:      document.getElementById('hj-text-desktop'),
                source:    document.getElementById('hj-source-desktop'),
                number:    document.getElementById('hj-num-desktop'),
                wrapper:   document.getElementById('hj-wrapper-desktop'),
                toggle:    document.getElementById('hj-toggle-desktop'),
                countdown: document.getElementById('hj-countdown-desktop'),
            },
            mobile: {
                arab:      document.getElementById('hj-arab-mobile'),
                text:      document.getElementById('hj-text-mobile'),
                source:    document.getElementById('hj-source-mobile'),
                number:    document.getElementById('hj-num-mobile'),
                wrapper:   document.getElementById('hj-wrapper-mobile'),
                toggle:    document.getElementById('hj-toggle-mobile'),
                countdown: document.getElementById('hj-countdown-mobile'),
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
        if (e.target.closest('#hj-toggle-desktop')) {
            var t = document.getElementById('hj-toggle-desktop'),
                w = document.getElementById('hj-wrapper-desktop');
            if (t && w) {
                e.preventDefault();
                var exp = w.classList.toggle('expanded');
                t.classList.toggle('expanded');
                var s = t.querySelector('.toggle-text');
                if (s) s.textContent = exp ? 'Sembunyikan' : 'Selengkapnya';
            }
        }
        if (e.target.closest('#hj-toggle-mobile')) {
            var tm = document.getElementById('hj-toggle-mobile'),
                wm = document.getElementById('hj-wrapper-mobile');
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
        var dw = document.getElementById('hj-wrapper-desktop'), dt = document.getElementById('hj-toggle-desktop');
        var mw = document.getElementById('hj-wrapper-mobile'),  mt = document.getElementById('hj-toggle-mobile');
        if (dw && dt) dt.style.display = dw.scrollHeight > 150 ? 'inline-flex' : 'none';
        if (mw && mt) mt.style.display = mw.scrollHeight > 150 ? 'inline-flex' : 'none';
    }

    function updateCountdown() {
        var d = document.getElementById('hj-countdown-desktop'), m = document.getElementById('hj-countdown-mobile');
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
                retryCount++;
                var msg = e.name === 'AbortError' ? 'Timeout memuat hadits.' : (e.message === 'Failed to fetch' ? 'Koneksi terputus.' : 'Gagal memuat hadits.');
                showErrorMessage(msg);
                fadeInElements();
                scheduleRetry(3000);
            })
            .finally(function () { isFetching = false; });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(checkOverflow, 100);
        window.addEventListener('resize', checkOverflow);
        fetchRandomHadith();
        startCountdown();
    });
})();
</script>
@endverbatim
