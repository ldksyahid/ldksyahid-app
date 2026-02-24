@verbatim
<script>
(function () {
    /* ================================================================
       HERO JUMBOTRON — Hadith / Quran System
       Uses hj- prefix IDs (matches hero-jumbotron component HTML).
       ================================================================ */

    /* Detect content type from the component wrapper data-type attribute */
    var hjWrapper   = document.querySelector('.hero-carousel-wrapper');
    var contentType = (hjWrapper && hjWrapper.dataset.type) ? hjWrapper.dataset.type : 'hadith';

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

    /* ── Hadith data ── */
    var books = [
        { id: 'bukhari',    name: 'HR. Bukhari',    max: 6638 },
        { id: 'muslim',     name: 'HR. Muslim',     max: 4930 },
        { id: 'abu-daud',   name: 'HR. Abu Daud',   max: 4419 },
        { id: 'tirmidzi',   name: 'HR. Tirmidzi',   max: 3625 },
        { id: 'ibnu-majah', name: 'HR. Ibnu Majah', max: 4285 },
        { id: 'nasai',      name: 'HR. Nasai',      max: 5364 },
    ];

    /* ── Quran data — max ayah count per surah (index 0 = surah 1, index 113 = surah 114) ── */
    var surahMaxAyah = [
        7,286,200,176,120,165,206,75,129,109,123,111,43,52,99,128,   /* 1–16   */
        111,110,98,135,112,78,118,64,77,227,93,88,69,60,34,30,       /* 17–32  */
        73,54,45,83,182,88,75,85,54,53,89,59,37,35,38,29,            /* 33–48  */
        18,45,60,49,62,55,78,96,29,22,24,13,14,11,11,18,             /* 49–64  */
        12,12,30,52,52,44,28,28,20,56,40,31,50,40,46,42,             /* 65–80  */
        29,19,36,25,22,17,19,26,30,20,15,21,11,8,8,19,               /* 81–96  */
        5,8,8,11,11,8,3,9,5,4,7,3,6,3,5,4,5,6                       /* 97–114 */
    ];

    var defaultSourceLabel = contentType === 'quran' ? 'Al-Qur\'an dalam 1 Menit' : 'Hadits dalam 1 Menit';

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
        if (dw && dt) {
            var ovD = dw.scrollHeight > 150;
            dt.style.display = ovD ? 'inline-flex' : 'none';
            dw.classList.toggle('hj-no-overflow', !ovD);
        }
        if (mw && mt) {
            var ovM = mw.scrollHeight > 150;
            mt.style.display = ovM ? 'inline-flex' : 'none';
            mw.classList.toggle('hj-no-overflow', !ovM);
        }
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
            if (timeLeft <= 0) { timeLeft = 60; fetchContent(); }
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
        if (el.desktop.source) el.desktop.source.textContent = defaultSourceLabel;
        if (el.mobile.source)  el.mobile.source.textContent  = defaultSourceLabel;
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
            retryTimeout = setTimeout(function () { fetchContent(); }, delay || 3000);
        } else {
            showErrorMessage('Gagal memuat konten setelah beberapa kali percobaan. Silakan refresh halaman.', false);
            retryCount = 0;
        }
    }

    /* Shared: apply fetched content to all elements, then fade in */
    function applyContent(arabText, idText, sourceLabel, numberLabel) {
        var el = getFreshElements();
        if (el.desktop.wrapper) el.desktop.wrapper.classList.remove('expanded');
        if (el.mobile.wrapper)  el.mobile.wrapper.classList.remove('expanded');
        if (el.desktop.toggle) { el.desktop.toggle.classList.remove('expanded'); var sd = el.desktop.toggle.querySelector('.toggle-text'); if (sd) sd.textContent = 'Selengkapnya'; }
        if (el.mobile.toggle)  { el.mobile.toggle.classList.remove('expanded');  var sm = el.mobile.toggle.querySelector('.hadith-toggle-text'); if (sm) sm.textContent = 'Selengkapnya'; }
        if (el.desktop.arab)   el.desktop.arab.textContent   = arabText;
        if (el.desktop.text)   el.desktop.text.innerHTML     = '\u201c' + idText + '\u201d';
        if (el.desktop.source) el.desktop.source.textContent = sourceLabel;
        if (el.desktop.number) el.desktop.number.textContent = numberLabel;
        if (el.mobile.arab)    el.mobile.arab.textContent    = arabText;
        if (el.mobile.text)    el.mobile.text.innerHTML      = '\u201c' + idText + '\u201d';
        if (el.mobile.source)  el.mobile.source.textContent  = sourceLabel;
        if (el.mobile.number)  el.mobile.number.textContent  = numberLabel;
        fadeInElements();
        setTimeout(checkOverflow, 100);
        resetCountdown();
    }

    /* ── Fetch random hadith ── */
    function fetchRandomHadith() {
        var book   = books[Math.floor(Math.random() * books.length)];
        var number = Math.floor(Math.random() * book.max) + 1;
        var ctrl   = new AbortController();
        var tId    = setTimeout(function () { ctrl.abort(); }, 10000);

        /* Fetch starts immediately — loading text stays visible while waiting */
        fetch('https://api.hadith.gading.dev/books/' + book.id + '/' + number, { signal: ctrl.signal })
        .then(function (r) { clearTimeout(tId); return r.json(); })
        .then(function (json) {
            if (json.code === 200 && json.data && json.data.contents) {
                retryCount = 0;
                var c = json.data.contents;
                /* Response arrived → fade out, update, fade in */
                fadeOutElements(function () {
                    applyContent(c.arab, c.id, book.name, book.name + ' No. ' + c.number);
                });
            } else { throw new Error('Invalid response'); }
        })
        .catch(function (e) {
            retryCount++;
            var msg = e.name === 'AbortError' ? 'Timeout memuat hadits.' : (e.message === 'Failed to fetch' ? 'Koneksi terputus.' : 'Gagal memuat hadits.');
            fadeOutElements(function () {
                showErrorMessage(msg);
                fadeInElements();
                scheduleRetry(3000);
            });
        })
        .finally(function () { isFetching = false; });
    }

    /* ── Fetch random Quran ayat ── */
    function fetchRandomAyah() {
        var surahNo = Math.floor(Math.random() * 114) + 1;
        var ayahNo  = Math.floor(Math.random() * surahMaxAyah[surahNo - 1]) + 1;
        var ctrl    = new AbortController();
        var tId     = setTimeout(function () { ctrl.abort(); }, 10000);

        /* Fetch starts immediately — loading text stays visible while waiting */
        fetch('https://quran-api-id.vercel.app/surah/' + surahNo + '/' + ayahNo, { signal: ctrl.signal })
        .then(function (r) { clearTimeout(tId); return r.json(); })
        .then(function (json) {
            if (json.code === 200 && json.data) {
                retryCount = 0;
                var d         = json.data;
                var arabText  = d.text && d.text.arab ? d.text.arab : '';
                var idText    = d.translation && d.translation.id ? d.translation.id : '';
                var surahName = (d.surah && d.surah.name && d.surah.name.transliteration)
                              ? 'QS. ' + d.surah.name.transliteration.id
                              : 'QS. Surah ' + surahNo;
                var fullRef   = surahName + ': ' + ayahNo;
                /* Response arrived → fade out, update, fade in */
                fadeOutElements(function () {
                    applyContent(arabText, idText, surahName, fullRef);
                });
            } else { throw new Error('Invalid response'); }
        })
        .catch(function (e) {
            retryCount++;
            var msg = e.name === 'AbortError' ? 'Timeout memuat ayat.' : (e.message === 'Failed to fetch' ? 'Koneksi terputus.' : 'Gagal memuat ayat.');
            fadeOutElements(function () {
                showErrorMessage(msg);
                fadeInElements();
                scheduleRetry(3000);
            });
        })
        .finally(function () { isFetching = false; });
    }

    /* ── Main dispatcher ── */
    function fetchContent() {
        if (isFetching) return;
        isFetching = true;
        if (contentType === 'quran') {
            fetchRandomAyah();
        } else {
            fetchRandomHadith();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(checkOverflow, 100);
        window.addEventListener('resize', checkOverflow);
        fetchContent();
        startCountdown();
    });
})();
</script>
@endverbatim
