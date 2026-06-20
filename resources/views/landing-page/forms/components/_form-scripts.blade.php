<script>
(function () {
    'use strict';

    // ── Open date/time picker via custom icon ──────────────────────
    window.gfOpenDatePicker = function(icon) {
        var input = icon.previousElementSibling;
        if (!input) return;
        try { input.showPicker(); } catch(e) { input.focus(); input.click(); }
    };

    // ── Custom Select Dropdown ──────────────────────────────────────
    (function () {
        document.querySelectorAll('.gf-csel-wrap').forEach(function (wrap) {
            var native  = wrap.querySelector('.gf-csel-native');
            var trigger = wrap.querySelector('.gf-csel-trigger');
            var panel   = wrap.querySelector('.gf-csel-panel');
            var current = wrap.querySelector('.gf-csel-current');
            var opts    = Array.from(wrap.querySelectorAll('.gf-csel-option:not(.gf-csel-opt-placeholder)'));
            var focIdx  = -1;

            if (!native || !trigger || !panel) return;

            function openPanel() {
                document.querySelectorAll('.gf-csel-wrap,.gf-dp-wrap').forEach(function (w) {
                    if (w !== wrap && w._gfClose) w._gfClose();
                });
                panel.classList.add('open');
                trigger.classList.add('open');
                trigger.setAttribute('aria-expanded', 'true');
                focIdx = opts.findIndex(function (o) { return o.classList.contains('selected'); });
                if (focIdx >= 0) highlight(focIdx);
            }

            function closePanel() {
                panel.classList.remove('open');
                trigger.classList.remove('open');
                trigger.setAttribute('aria-expanded', 'false');
                opts.forEach(function (o) { o.classList.remove('focused'); });
                focIdx = -1;
            }

            wrap._gfClose = closePanel;

            function highlight(idx) {
                opts.forEach(function (o) { o.classList.remove('focused'); });
                if (idx >= 0 && idx < opts.length) {
                    opts[idx].classList.add('focused');
                    opts[idx].scrollIntoView({ block: 'nearest' });
                    focIdx = idx;
                }
            }

            function pickOpt(opt) {
                var val   = opt.dataset.value;
                var label = opt.textContent.trim();
                native.value = val;
                current.textContent = val ? label : '-- Pilih salah satu --';
                current.classList.toggle('placeholder', !val);
                opts.forEach(function (o) { o.classList.remove('selected'); });
                if (val) opt.classList.add('selected');
                closePanel();
                trigger.focus();
            }

            // Stop wrap clicks reaching the document close handler
            wrap.addEventListener('click', function (e) { e.stopPropagation(); });

            trigger.addEventListener('click', function () {
                panel.classList.contains('open') ? closePanel() : openPanel();
            });

            trigger.addEventListener('keydown', function (e) {
                var isOpen = panel.classList.contains('open');
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    if (isOpen) { if (focIdx >= 0) pickOpt(opts[focIdx]); else closePanel(); }
                    else openPanel();
                } else if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    if (!isOpen) openPanel();
                    highlight(Math.min(focIdx + 1, opts.length - 1));
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    if (!isOpen) openPanel();
                    highlight(Math.max(focIdx - 1, 0));
                } else if (e.key === 'Escape') {
                    closePanel();
                }
            });

            panel.addEventListener('click', function (e) {
                var opt = e.target.closest('.gf-csel-option');
                if (!opt) return;
                if (opt.classList.contains('gf-csel-opt-placeholder')) {
                    native.value = '';
                    current.textContent = '-- Pilih salah satu --';
                    current.classList.add('placeholder');
                    opts.forEach(function (o) { o.classList.remove('selected'); });
                    closePanel(); trigger.focus();
                    return;
                }
                pickOpt(opt);
            });

            panel.addEventListener('mousemove', function (e) {
                var opt = e.target.closest('.gf-csel-option:not(.gf-csel-opt-placeholder)');
                if (!opt) return;
                var idx = opts.indexOf(opt);
                if (idx >= 0 && idx !== focIdx) highlight(idx);
            });

            // Sync is-invalid from native select to wrapper (for validation error display)
            new MutationObserver(function () {
                wrap.classList.toggle('is-invalid', native.classList.contains('is-invalid'));
            }).observe(native, { attributes: true, attributeFilter: ['class'] });
        });

        // Close all panels when clicking outside
        document.addEventListener('click', function () {
            document.querySelectorAll('.gf-csel-wrap').forEach(function (w) {
                if (w._gfClose) w._gfClose();
            });
        });
    })();

    // ── Custom Date Picker (3-mode: day / month / year) ────────────
    (function () {
        var MONTHS       = ['Januari','Februari','Maret','April','Mei','Juni',
                            'Juli','Agustus','September','Oktober','November','Desember'];
        var MONTHS_SHORT = ['Jan','Feb','Mar','Apr','Mei','Jun',
                            'Jul','Agu','Sep','Okt','Nov','Des'];

        function parseRaw(str) {
            if (!str) return null;
            var p = str.split('-');
            if (p.length !== 3) return null;
            var d = new Date(+p[0], +p[1] - 1, +p[2]);
            return isNaN(d.getTime()) ? null : d;
        }

        function toRaw(d) {
            return d.getFullYear() + '-' +
                   String(d.getMonth() + 1).padStart(2, '0') + '-' +
                   String(d.getDate()).padStart(2, '0');
        }

        function toDisplay(d) {
            return String(d.getDate()).padStart(2, '0') + '/' +
                   String(d.getMonth() + 1).padStart(2, '0') + '/' +
                   d.getFullYear();
        }

        function sameDay(a, b) {
            return a && b &&
                a.getFullYear() === b.getFullYear() &&
                a.getMonth()    === b.getMonth()    &&
                a.getDate()     === b.getDate();
        }

        var today = new Date(); today.setHours(0,0,0,0);

        document.querySelectorAll('.gf-dp-wrap').forEach(function (wrap) {
            var native     = wrap.querySelector('.gf-dp-native');
            var trigger    = wrap.querySelector('.gf-dp-trigger');
            var dispText   = wrap.querySelector('.gf-dp-text');
            var panel      = wrap.querySelector('.gf-dp-panel');
            var captionEl  = wrap.querySelector('.gf-dp-caption');
            var captionBtn = wrap.querySelector('.gf-dp-caption-btn');
            var grid       = wrap.querySelector('.gf-dp-grid');
            var monthGrid  = wrap.querySelector('.gf-dp-month-grid');
            var yearGrid   = wrap.querySelector('.gf-dp-year-grid');
            var btnPrev    = wrap.querySelector('[data-dp="prev"]');
            var btnNext    = wrap.querySelector('[data-dp="next"]');
            var btnClear   = wrap.querySelector('.gf-dp-btn-clear');
            var btnToday   = wrap.querySelector('.gf-dp-btn-today');

            if (!native || !trigger || !panel) return;

            var selected = parseRaw(native.value);
            var view     = new Date(selected || today); view.setDate(1);
            var mode     = 'day';

            function setMode(m) {
                mode = m;
                panel.setAttribute('data-mode', m);
            }

            /* ── Day grid ──────────────────────────────────────── */
            function renderDay() {
                setMode('day');
                var y = view.getFullYear(), m = view.getMonth();
                captionEl.textContent = MONTHS[m] + ' ' + y;
                grid.innerHTML = '';
                var firstDay    = new Date(y, m, 1).getDay();
                var daysInMonth = new Date(y, m + 1, 0).getDate();
                var daysInPrev  = new Date(y, m, 0).getDate();

                for (var i = firstDay - 1; i >= 0; i--)
                    grid.appendChild(dayCell(new Date(y, m - 1, daysInPrev - i), true));
                for (var d = 1; d <= daysInMonth; d++)
                    grid.appendChild(dayCell(new Date(y, m, d), false));
                var total = firstDay + daysInMonth;
                var trail = total % 7 === 0 ? 0 : 7 - (total % 7);
                for (var t = 1; t <= trail; t++)
                    grid.appendChild(dayCell(new Date(y, m + 1, t), true));
            }

            function dayCell(date, isOther) {
                var el = document.createElement('div');
                el.className = 'gf-dp-cell';
                el.textContent = date.getDate();
                if (isOther)                el.classList.add('other-month');
                if (sameDay(date, today))   el.classList.add('today');
                if (sameDay(date, selected)) el.classList.add('selected');
                el.addEventListener('click', function () { pick(date); });
                return el;
            }

            /* ── Month grid ────────────────────────────────────── */
            function renderMonth() {
                setMode('month');
                captionEl.textContent = view.getFullYear();
                monthGrid.innerHTML = '';
                for (var i = 0; i < 12; i++) {
                    var el = document.createElement('div');
                    el.className = 'gf-dp-month-cell';
                    el.textContent = MONTHS_SHORT[i];
                    if (i === today.getMonth() && view.getFullYear() === today.getFullYear())
                        el.classList.add('cur-month');
                    if (selected && i === selected.getMonth() && view.getFullYear() === selected.getFullYear())
                        el.classList.add('sel-month');
                    el.addEventListener('click', (function (idx) {
                        return function () { view.setMonth(idx); renderDay(); };
                    })(i));
                    monthGrid.appendChild(el);
                }
            }

            /* ── Year grid (scrollable 1920 → current+1) ───────── */
            function renderYear() {
                setMode('year');
                captionEl.textContent = 'Pilih Tahun';
                yearGrid.innerHTML = '';
                var endY = today.getFullYear() + 1;
                for (var y = 1920; y <= endY; y++) {
                    var el = document.createElement('div');
                    el.className = 'gf-dp-year-cell';
                    el.textContent = y;
                    if (y === today.getFullYear()) el.classList.add('cur-year');
                    if (selected && y === selected.getFullYear()) el.classList.add('sel-year');
                    el.addEventListener('click', (function (yr) {
                        return function () { view.setFullYear(yr); renderMonth(); };
                    })(y));
                    yearGrid.appendChild(el);
                }
                setTimeout(function () {
                    var target = yearGrid.querySelector('.sel-year') || yearGrid.querySelector('.cur-year');
                    if (target) target.scrollIntoView({ block: 'center' });
                }, 10);
            }

            /* ── Pick a date ───────────────────────────────────── */
            function pick(date) {
                selected = new Date(date); selected.setHours(0,0,0,0);
                native.value = toRaw(selected);
                if (dispText) {
                    dispText.textContent = toDisplay(selected);
                    dispText.classList.remove('placeholder');
                }
                close();
                trigger.focus();
            }

            /* ── Open / close ──────────────────────────────────── */
            function open() {
                document.querySelectorAll('.gf-csel-wrap,.gf-dp-wrap').forEach(function (w) {
                    if (w !== wrap && w._gfClose) w._gfClose();
                });
                view = new Date(selected || today); view.setDate(1);
                renderDay();
                panel.classList.add('open');
                trigger.classList.add('open');
                trigger.setAttribute('aria-expanded', 'true');
                var rect = wrap.getBoundingClientRect();
                if (window.innerHeight - rect.bottom < 330) {
                    panel.style.top = 'auto'; panel.style.bottom = 'calc(100% + 5px)';
                } else {
                    panel.style.top = 'calc(100% + 5px)'; panel.style.bottom = 'auto';
                }
            }

            function close() {
                panel.classList.remove('open');
                trigger.classList.remove('open');
                trigger.setAttribute('aria-expanded', 'false');
            }

            wrap._gfClose = close;

            /* ── Events ────────────────────────────────────────── */
            wrap.addEventListener('click', function (e) { e.stopPropagation(); });

            trigger.addEventListener('click', function () {
                panel.classList.contains('open') ? close() : open();
            });

            trigger.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    panel.classList.contains('open') ? close() : open();
                } else if (e.key === 'Escape') {
                    close();
                }
            });

            // Caption: day/month → year, year → day
            captionBtn && captionBtn.addEventListener('click', function () {
                if (mode === 'day' || mode === 'month') renderYear();
                else renderDay();
            });

            btnPrev && btnPrev.addEventListener('click', function () {
                if (mode === 'day')   { view.setMonth(view.getMonth() - 1);      renderDay();   }
                if (mode === 'month') { view.setFullYear(view.getFullYear() - 1); renderMonth(); }
            });

            btnNext && btnNext.addEventListener('click', function () {
                if (mode === 'day')   { view.setMonth(view.getMonth() + 1);      renderDay();   }
                if (mode === 'month') { view.setFullYear(view.getFullYear() + 1); renderMonth(); }
            });

            btnClear && btnClear.addEventListener('click', function () {
                selected = null; native.value = '';
                if (dispText) { dispText.textContent = 'Pilih tanggal'; dispText.classList.add('placeholder'); }
                close(); trigger.focus();
            });

            btnToday && btnToday.addEventListener('click', function () { pick(today); });

            /* ── Sync is-invalid ─────────────────────────────────── */
            new MutationObserver(function () {
                wrap.classList.toggle('is-invalid', native.classList.contains('is-invalid'));
            }).observe(native, { attributes: true, attributeFilter: ['class'] });
        });

        document.addEventListener('click', function () {
            document.querySelectorAll('.gf-dp-wrap').forEach(function (w) {
                if (w._gfClose) w._gfClose();
            });
        });
    })();

    // ── Custom Time Picker ─────────────────────────────────────────
    (function () {
        function parseTime(str) {
            if (!str) return null;
            var p = str.split(':');
            if (p.length < 2) return null;
            var h = parseInt(p[0]), m = parseInt(p[1]);
            if (isNaN(h) || isNaN(m)) return null;
            return { h: h, m: m };
        }

        function pad(n) { return String(n).padStart(2, '0'); }

        document.querySelectorAll('.gf-tp-wrap').forEach(function (wrap) {
            var native   = wrap.querySelector('.gf-tp-native');
            var trigger  = wrap.querySelector('.gf-tp-trigger');
            var dispText = wrap.querySelector('.gf-tp-text');
            var panel    = wrap.querySelector('.gf-tp-panel');
            var hourCol  = wrap.querySelector('[data-tp="hour"]');
            var minCol   = wrap.querySelector('[data-tp="minute"]');
            var btnClear = wrap.querySelector('.gf-tp-clear');
            var btnNow   = wrap.querySelector('.gf-tp-now');

            if (!native || !trigger || !panel) return;

            var parsed = parseTime(native.value);
            var selH   = parsed ? parsed.h : null;
            var selM   = parsed ? parsed.m : null;

            function buildCols() {
                hourCol.innerHTML = '';
                for (var h = 0; h <= 23; h++) {
                    var el = document.createElement('div');
                    el.className = 'gf-tp-item';
                    el.textContent = pad(h);
                    if (selH === h) el.classList.add('selected');
                    el.addEventListener('click', (function (hh) {
                        return function () { pickHour(hh); };
                    })(h));
                    hourCol.appendChild(el);
                }

                minCol.innerHTML = '';
                for (var m = 0; m <= 59; m++) {
                    var el2 = document.createElement('div');
                    el2.className = 'gf-tp-item';
                    el2.textContent = pad(m);
                    if (selM === m) el2.classList.add('selected');
                    el2.addEventListener('click', (function (mm) {
                        return function () { pickMin(mm); };
                    })(m));
                    minCol.appendChild(el2);
                }
            }

            function pickHour(h) {
                selH = h;
                hourCol.querySelectorAll('.gf-tp-item').forEach(function (el, idx) {
                    el.classList.toggle('selected', idx === h);
                });
                syncNative();
            }

            function pickMin(m) {
                selM = m;
                minCol.querySelectorAll('.gf-tp-item').forEach(function (el, idx) {
                    el.classList.toggle('selected', idx === m);
                });
                syncNative();
                // Auto-close once both are picked
                if (selH !== null) close();
            }

            function syncNative() {
                if (selH === null || selM === null) return;
                var val = pad(selH) + ':' + pad(selM);
                native.value = val;
                if (dispText) {
                    dispText.textContent = val;
                    dispText.classList.remove('placeholder');
                }
            }

            function scrollToCurrent() {
                if (selH !== null) {
                    var hEl = hourCol.children[selH];
                    if (hEl) hEl.scrollIntoView({ block: 'center' });
                }
                if (selM !== null) {
                    var mEl = minCol.children[selM];
                    if (mEl) mEl.scrollIntoView({ block: 'center' });
                }
            }

            function open() {
                document.querySelectorAll('.gf-csel-wrap,.gf-dp-wrap,.gf-tp-wrap').forEach(function (w) {
                    if (w !== wrap && w._gfClose) w._gfClose();
                });
                buildCols();
                panel.classList.add('open');
                trigger.classList.add('open');
                trigger.setAttribute('aria-expanded', 'true');
                setTimeout(scrollToCurrent, 10);
                var rect = wrap.getBoundingClientRect();
                if (window.innerHeight - rect.bottom < 290) {
                    panel.style.top = 'auto'; panel.style.bottom = 'calc(100% + 5px)';
                } else {
                    panel.style.top = 'calc(100% + 5px)'; panel.style.bottom = 'auto';
                }
            }

            function close() {
                panel.classList.remove('open');
                trigger.classList.remove('open');
                trigger.setAttribute('aria-expanded', 'false');
            }

            wrap._gfClose = close;
            wrap.addEventListener('click', function (e) { e.stopPropagation(); });

            trigger.addEventListener('click', function () {
                panel.classList.contains('open') ? close() : open();
            });

            trigger.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    panel.classList.contains('open') ? close() : open();
                } else if (e.key === 'Escape') {
                    close();
                }
            });

            btnClear && btnClear.addEventListener('click', function () {
                selH = null; selM = null; native.value = '';
                if (dispText) { dispText.textContent = '--:--'; dispText.classList.add('placeholder'); }
                close(); trigger.focus();
            });

            btnNow && btnNow.addEventListener('click', function () {
                var now = new Date();
                selH = now.getHours(); selM = now.getMinutes();
                syncNative(); close(); trigger.focus();
            });

            new MutationObserver(function () {
                wrap.classList.toggle('is-invalid', native.classList.contains('is-invalid'));
            }).observe(native, { attributes: true, attributeFilter: ['class'] });
        });

        document.addEventListener('click', function () {
            document.querySelectorAll('.gf-tp-wrap').forEach(function (w) {
                if (w._gfClose) w._gfClose();
            });
        });
    })();

    // ── Custom DateTime Picker ─────────────────────────────────────
    (function () {
        var MONTHS       = ['Januari','Februari','Maret','April','Mei','Juni',
                            'Juli','Agustus','September','Oktober','November','Desember'];
        var MONTHS_SHORT = ['Jan','Feb','Mar','Apr','Mei','Jun',
                            'Jul','Agu','Sep','Okt','Nov','Des'];

        function pad(n) { return String(n).padStart(2, '0'); }

        function parseRaw(str) {
            if (!str) return null;
            var p = str.split('T');
            if (p.length < 2) return null;
            var dp = p[0].split('-'), tp = p[1].split(':');
            if (dp.length !== 3) return null;
            var d = new Date(+dp[0], +dp[1] - 1, +dp[2]);
            return isNaN(d.getTime()) ? null : { date: d, h: +tp[0], m: +tp[1] };
        }

        function toRaw(date, h, m) {
            return date.getFullYear() + '-' + pad(date.getMonth() + 1) + '-' + pad(date.getDate()) +
                   'T' + pad(h) + ':' + pad(m);
        }

        function toDisplay(date, h, m) {
            return pad(date.getDate()) + '/' + pad(date.getMonth() + 1) + '/' + date.getFullYear() +
                   ' ' + pad(h) + ':' + pad(m);
        }

        function sameDay(a, b) {
            return a && b &&
                a.getFullYear() === b.getFullYear() &&
                a.getMonth()    === b.getMonth()    &&
                a.getDate()     === b.getDate();
        }

        var today = new Date(); today.setHours(0,0,0,0);

        document.querySelectorAll('.gf-dtp-wrap').forEach(function (wrap) {
            var native     = wrap.querySelector('.gf-dtp-native');
            var trigger    = wrap.querySelector('.gf-dtp-trigger');
            var dispText   = wrap.querySelector('.gf-dtp-text');
            var panel      = wrap.querySelector('.gf-dtp-panel');
            var captionEl  = wrap.querySelector('.gf-dtp-caption');
            var captionBtn = wrap.querySelector('.gf-dtp-caption-btn');
            var calGrid    = wrap.querySelector('.gf-dtp-grid');
            var monthGrid  = wrap.querySelector('.gf-dtp-month-grid');
            var yearGrid   = wrap.querySelector('.gf-dtp-year-grid');
            var hourCol    = wrap.querySelector('[data-dtp="hour"]');
            var minCol     = wrap.querySelector('[data-dtp="minute"]');
            var btnPrev    = wrap.querySelector('[data-dtp="prev"]');
            var btnNext    = wrap.querySelector('[data-dtp="next"]');
            var btnClear   = wrap.querySelector('.gf-dtp-btn-clear');
            var btnNow     = wrap.querySelector('.gf-dtp-btn-now');

            if (!native || !trigger || !panel) return;

            var parsed  = parseRaw(native.value);
            var selDate = parsed ? parsed.date : null;
            var selH    = parsed ? parsed.h    : null;
            var selM    = parsed ? parsed.m    : null;
            var view    = new Date(selDate || today); view.setDate(1);
            var mode    = 'day';

            function setMode(m) { mode = m; panel.setAttribute('data-mode', m); }

            /* ── Calendar ─────────────────────────────────────── */
            function renderDay() {
                setMode('day');
                var y = view.getFullYear(), m = view.getMonth();
                captionEl.textContent = MONTHS[m] + ' ' + y;
                calGrid.innerHTML = '';
                var firstDay    = new Date(y, m, 1).getDay();
                var daysInMonth = new Date(y, m + 1, 0).getDate();
                var daysInPrev  = new Date(y, m, 0).getDate();
                for (var i = firstDay - 1; i >= 0; i--)
                    calGrid.appendChild(dayCell(new Date(y, m - 1, daysInPrev - i), true));
                for (var d = 1; d <= daysInMonth; d++)
                    calGrid.appendChild(dayCell(new Date(y, m, d), false));
                var total = firstDay + daysInMonth;
                var trail = total % 7 === 0 ? 0 : 7 - (total % 7);
                for (var t = 1; t <= trail; t++)
                    calGrid.appendChild(dayCell(new Date(y, m + 1, t), true));
            }

            function dayCell(date, isOther) {
                var el = document.createElement('div');
                el.className = 'gf-dtp-cell';
                el.textContent = date.getDate();
                if (isOther)                el.classList.add('other-month');
                if (sameDay(date, today))   el.classList.add('today');
                if (sameDay(date, selDate)) el.classList.add('selected');
                el.addEventListener('click', function () {
                    selDate = new Date(date); selDate.setHours(0,0,0,0);
                    renderDay(); syncNative();
                });
                return el;
            }

            function renderMonth() {
                setMode('month');
                captionEl.textContent = view.getFullYear();
                monthGrid.innerHTML = '';
                for (var i = 0; i < 12; i++) {
                    var el = document.createElement('div');
                    el.className = 'gf-dtp-month-cell';
                    el.textContent = MONTHS_SHORT[i];
                    if (i === today.getMonth() && view.getFullYear() === today.getFullYear())
                        el.classList.add('cur-month');
                    if (selDate && i === selDate.getMonth() && view.getFullYear() === selDate.getFullYear())
                        el.classList.add('sel-month');
                    el.addEventListener('click', (function (idx) {
                        return function () { view.setMonth(idx); renderDay(); };
                    })(i));
                    monthGrid.appendChild(el);
                }
            }

            function renderYear() {
                setMode('year');
                captionEl.textContent = 'Pilih Tahun';
                yearGrid.innerHTML = '';
                var endY = today.getFullYear() + 1;
                for (var y = 1920; y <= endY; y++) {
                    var el = document.createElement('div');
                    el.className = 'gf-dtp-year-cell';
                    el.textContent = y;
                    if (y === today.getFullYear()) el.classList.add('cur-year');
                    if (selDate && y === selDate.getFullYear()) el.classList.add('sel-year');
                    el.addEventListener('click', (function (yr) {
                        return function () { view.setFullYear(yr); renderMonth(); };
                    })(y));
                    yearGrid.appendChild(el);
                }
                setTimeout(function () {
                    var t = yearGrid.querySelector('.sel-year') || yearGrid.querySelector('.cur-year');
                    if (t) t.scrollIntoView({ block: 'center' });
                }, 10);
            }

            /* ── Time columns ─────────────────────────────────── */
            function buildTimeCols() {
                hourCol.innerHTML = '';
                for (var h = 0; h <= 23; h++) {
                    var el = document.createElement('div');
                    el.className = 'gf-dtp-time-item';
                    el.textContent = pad(h);
                    if (selH === h) el.classList.add('selected');
                    el.addEventListener('click', (function (hh) {
                        return function () {
                            selH = hh;
                            hourCol.querySelectorAll('.gf-dtp-time-item').forEach(function (e, idx) {
                                e.classList.toggle('selected', idx === hh);
                            });
                            syncNative();
                        };
                    })(h));
                    hourCol.appendChild(el);
                }
                minCol.innerHTML = '';
                for (var m = 0; m <= 59; m++) {
                    var el2 = document.createElement('div');
                    el2.className = 'gf-dtp-time-item';
                    el2.textContent = pad(m);
                    if (selM === m) el2.classList.add('selected');
                    el2.addEventListener('click', (function (mm) {
                        return function () {
                            selM = mm;
                            minCol.querySelectorAll('.gf-dtp-time-item').forEach(function (e, idx) {
                                e.classList.toggle('selected', idx === mm);
                            });
                            syncNative();
                            if (selDate !== null && selH !== null) close();
                        };
                    })(m));
                    minCol.appendChild(el2);
                }
            }

            function scrollTimeCols() {
                if (selH !== null && hourCol.children[selH])
                    hourCol.children[selH].scrollIntoView({ block: 'center' });
                if (selM !== null && minCol.children[selM])
                    minCol.children[selM].scrollIntoView({ block: 'center' });
            }

            /* ── Sync ─────────────────────────────────────────── */
            function syncNative() {
                if (!selDate) return;
                var h = selH !== null ? selH : 0;
                var m = selM !== null ? selM : 0;
                native.value = toRaw(selDate, h, m);
                if (dispText) {
                    dispText.textContent = toDisplay(selDate, h, m);
                    dispText.classList.remove('placeholder');
                }
            }

            /* ── Open / close ─────────────────────────────────── */
            function open() {
                document.querySelectorAll('.gf-csel-wrap,.gf-dp-wrap,.gf-tp-wrap,.gf-dtp-wrap').forEach(function (w) {
                    if (w !== wrap && w._gfClose) w._gfClose();
                });
                view = new Date(selDate || today); view.setDate(1);
                renderDay();
                buildTimeCols();
                panel.classList.add('open');
                trigger.classList.add('open');
                trigger.setAttribute('aria-expanded', 'true');
                setTimeout(scrollTimeCols, 10);
                var rect = wrap.getBoundingClientRect();
                if (window.innerHeight - rect.bottom < 460) {
                    panel.style.top = 'auto'; panel.style.bottom = 'calc(100% + 5px)';
                } else {
                    panel.style.top = 'calc(100% + 5px)'; panel.style.bottom = 'auto';
                }
            }

            function close() {
                panel.classList.remove('open');
                trigger.classList.remove('open');
                trigger.setAttribute('aria-expanded', 'false');
            }

            wrap._gfClose = close;

            /* ── Events ───────────────────────────────────────── */
            wrap.addEventListener('click', function (e) { e.stopPropagation(); });

            trigger.addEventListener('click', function () {
                panel.classList.contains('open') ? close() : open();
            });

            trigger.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    panel.classList.contains('open') ? close() : open();
                } else if (e.key === 'Escape') { close(); }
            });

            captionBtn && captionBtn.addEventListener('click', function () {
                if (mode === 'day' || mode === 'month') renderYear();
                else renderDay();
            });

            btnPrev && btnPrev.addEventListener('click', function () {
                if (mode === 'day')   { view.setMonth(view.getMonth() - 1);      renderDay();   }
                if (mode === 'month') { view.setFullYear(view.getFullYear() - 1); renderMonth(); }
            });

            btnNext && btnNext.addEventListener('click', function () {
                if (mode === 'day')   { view.setMonth(view.getMonth() + 1);      renderDay();   }
                if (mode === 'month') { view.setFullYear(view.getFullYear() + 1); renderMonth(); }
            });

            btnClear && btnClear.addEventListener('click', function () {
                selDate = null; selH = null; selM = null; native.value = '';
                if (dispText) { dispText.textContent = 'dd/mm/yyyy --:--'; dispText.classList.add('placeholder'); }
                close(); trigger.focus();
            });

            btnNow && btnNow.addEventListener('click', function () {
                var now = new Date();
                selDate = new Date(now.getFullYear(), now.getMonth(), now.getDate());
                selH = now.getHours(); selM = now.getMinutes();
                syncNative(); close(); trigger.focus();
            });

            new MutationObserver(function () {
                wrap.classList.toggle('is-invalid', native.classList.contains('is-invalid'));
            }).observe(native, { attributes: true, attributeFilter: ['class'] });
        });

        document.addEventListener('click', function () {
            document.querySelectorAll('.gf-dtp-wrap').forEach(function (w) {
                if (w._gfClose) w._gfClose();
            });
        });
    })();

    // ── Phone input: allow only + and digits ───────────────────────
    document.querySelectorAll('[data-gf-tel]').forEach(function(input) {
        input.addEventListener('input', function() {
            var filtered = this.value.replace(/[^\d+]/g, '');
            if (this.value !== filtered) this.value = filtered;
        });
    });

    // ── Star rating interactivity ───────────────────────────────────
    document.querySelectorAll('.gf-rating-wrap').forEach(function(wrap) {
        var items = Array.from(wrap.querySelectorAll('.gf-rating-item'));

        function setFilled(upTo) {
            items.forEach(function(item, idx) {
                var star = item.querySelector('.gf-star');
                if (!star) return;
                if (idx <= upTo) {
                    star.classList.replace('far', 'fas');
                    star.classList.add('filled');
                } else {
                    star.classList.replace('fas', 'far');
                    star.classList.remove('filled');
                }
            });
        }

        function getCurrentSelected() {
            var checked = wrap.querySelector('.gf-rating-input:checked');
            if (!checked) return -1;
            return items.findIndex(function(it) { return it.querySelector('.gf-rating-input') === checked; });
        }

        // Restore persisted value on page load
        var sel = getCurrentSelected();
        if (sel >= 0) setFilled(sel);

        items.forEach(function(item, idx) {
            var input = item.querySelector('.gf-rating-input');

            item.addEventListener('mouseenter', function() { setFilled(idx); });
            item.addEventListener('mouseleave', function() {
                var s = getCurrentSelected();
                if (s >= 0) setFilled(s); else setFilled(-1);
            });
            item.addEventListener('click', function() {
                if (input) input.checked = true;
                setFilled(idx);
            });
        });
    });

    // ── File upload drag & drop ─────────────────────────────────────
    document.querySelectorAll('.gf-file-drop').forEach(function (drop) {
        var input    = drop.querySelector('input[type="file"]');
        var badge    = drop.querySelector('.gf-file-badge');
        var badgeTxt = badge ? badge.querySelector('span') : null;

        drop.addEventListener('click', function (e) {
            if (e.target !== input) input.click();
        });
        drop.addEventListener('dragover', function (e) {
            e.preventDefault();
            drop.classList.add('dragover');
        });
        drop.addEventListener('dragleave', function () {
            drop.classList.remove('dragover');
        });
        drop.addEventListener('drop', function (e) {
            e.preventDefault();
            drop.classList.remove('dragover');
            if (e.dataTransfer.files.length) {
                setFile(e.dataTransfer.files[0]);
                try { input.files = e.dataTransfer.files; } catch (_) {}
            }
        });
        input && input.addEventListener('change', function () {
            if (this.files && this.files[0]) setFile(this.files[0]);
            else resetFile();
        });

        function setFile(file) {
            if (badgeTxt) badgeTxt.textContent = file.name;
            if (badge) {
                badge.style.display = '';
                var ic = badge.querySelector('i');
                if (ic) ic.className = 'fas fa-file-check fa-xs';
            }
        }
        function resetFile() {
            if (badgeTxt) badgeTxt.textContent = 'Belum ada file dipilih';
        }
    });

    // ── Form config (injected from Blade) ───────────────────────────
    var gfIsMultiple = {{ $form->isMultipleSubmit ? 'true' : 'false' }};
    var gfFormSlug   = '{{ $form->slug }}';

    // ── AJAX form submission ────────────────────────────────────────
    var form = document.getElementById('publicFormSubmit');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        var btn  = document.getElementById('gfSubmitBtn');
        var span = btn ? btn.querySelector('span') : null;
        var icon = btn ? btn.querySelector('i') : null;

        // Loading state on button
        if (btn) {
            btn.disabled = true;
            if (span) span.textContent = 'Mengirimkan...';
            if (icon) icon.className = 'fas fa-spinner fa-spin';
        }

        clearErrors();

        var csrfMeta = document.querySelector('meta[name="csrf-token"]');

        fetch(form.action, {
            method : 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN'    : csrfMeta ? csrfMeta.content : '',
            },
            body: new FormData(form),
        })
        .then(function (res) {
            return res.json().then(function (data) {
                return { status: res.status, data: data };
            });
        })
        .then(function (result) {
            var status = result.status;
            var data   = result.data;

            if (status === 200 && data.success) {
                // ── Success ──────────────────────────────────────────
                if (data.redirectUrl) {
                    window.location.href = data.redirectUrl;
                } else {
                    showSuccessCard(data.formTitle, data.confirmationMessage, data.isMultipleSubmit, data.formSlug);
                }
            } else if (status === 422 && data.errors) {
                // ── Validation errors ────────────────────────────────
                // Notify multi-step navigator (if active) to go to error section first
                document.dispatchEvent(new CustomEvent('gf:validationErrors', { detail: data.errors }));
                showValidationErrors(data.errors);
                restoreBtn(btn, span, icon);
            } else if (status === 429) {
                // ── Rate limit (throttle middleware or controller) ────
                showGeneralError('Terlalu banyak percobaan pengiriman. Silakan tunggu beberapa saat dan coba lagi.');
                restoreBtn(btn, span, icon);
            } else {
                // ── Server / closed error ─────────────────────────────
                showGeneralError(data.message || 'Terjadi kesalahan. Silakan coba lagi.');
                restoreBtn(btn, span, icon);
            }
        })
        .catch(function () {
            showGeneralError('Terjadi kesalahan jaringan. Periksa koneksi kamu dan coba lagi.');
            restoreBtn(btn, span, icon);
        });
    });

    // ── Helpers ─────────────────────────────────────────────────────

    function restoreBtn(btn, span, icon) {
        if (!btn) return;
        btn.disabled = false;
        if (span) span.textContent = 'Kirimkan Formulir';
        if (icon) icon.className = 'fas fa-paper-plane';
    }

    function clearErrors() {
        form.querySelectorAll('.is-invalid').forEach(function (el) {
            el.classList.remove('is-invalid');
        });
        form.querySelectorAll('.gf-invalid').forEach(function (el) {
            el.textContent = '';
        });
        form.querySelectorAll('.gf-card.has-error').forEach(function (el) {
            el.classList.remove('has-error');
        });
        var gen = document.getElementById('gfGeneralError');
        if (gen) gen.remove();
    }

    function showGeneralError(message) {
        var wrap = document.querySelector('.gf-wrap');
        if (!wrap) return;
        var card = document.createElement('div');
        card.id        = 'gfGeneralError';
        card.className = 'gf-error-card';
        card.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>' + escHtml(message);
        wrap.insertBefore(card, form);
        card.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function showValidationErrors(errors) {
        if (!errors) return;
        var firstCard = null;

        Object.keys(errors).forEach(function (key) {
            var msgs  = errors[key];
            if (!msgs || !msgs.length) return;

            var input = form.querySelector('[name="' + key + '"]') ||
                        form.querySelector('[name="' + key + '[]"]');
            if (!input) return;

            input.classList.add('is-invalid');
            var card = input.closest('.gf-card');
            if (card) {
                card.classList.add('has-error');
                var errEl = card.querySelector('.gf-invalid');
                if (errEl) errEl.textContent = msgs[0];
                if (!firstCard) firstCard = card;
            }
        });

        if (firstCard) firstCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function showSuccessCard(formTitle, confirmationMessage, isMultiple, formSlug) {
        var wrap = document.querySelector('.gf-wrap');
        if (!wrap) return;

        // Fall back to Blade-injected values if server didn't return them
        if (typeof isMultiple === 'undefined') isMultiple = gfIsMultiple;
        if (typeof formSlug  === 'undefined') formSlug   = gfFormSlug;

        var bodyMsg = confirmationMessage
            ? escHtml(confirmationMessage)
            : 'Alhamdulillah, jawaban kamu telah berhasil kami terima. Jazakumullahu Khairan atas partisipasi kamu, semoga Allah membalas kebaikan kamu dan memudahkan segala urusan kamu.';

        var againLink = isMultiple
            ? '<a href="/form/' + escHtml(formSlug) + '" class="gf-again-link">Kirim jawaban lain</a>'
            : '';

        wrap.innerHTML =
            '<div class="gf-state-card">' +
                '<h2 class="gf-state-form-title">' + escHtml(formTitle) + '</h2>' +
                '<p class="gf-state-body">' + bodyMsg + '</p>' +
                againLink +
                '<a href="/" class="gf-again-link"><i class="fas fa-home" style="margin-right:.3rem;"></i>Kembali ke beranda</a>' +
            '</div>';

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function escHtml(str) {
        return String(str || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

})();
</script>

@if($isMultiStep ?? false)
<script>
(function () {
    'use strict';

    // ── Multi-step section navigation ───────────────────────────────
    var sections        = Array.from(document.querySelectorAll('.gf-form-section'));
    var totalSecs       = sections.length;
    var currentIndex    = 0;
    var gfSectionNames  = @json($jsSectionNames ?? []);
    var sectionHistory  = []; // back-navigation stack

    // Show the first section on load (already has class 'active' from Blade)

    function setSkipped(idx, skipped) {
        if (idx < 0 || idx >= totalSecs) return;
        var sec = sections[idx];
        sec.dataset.skipped = skipped ? '1' : '0';
        sec.querySelectorAll('input, select, textarea').forEach(function (el) {
            el.disabled = skipped;
        });
    }

    window.gfNextSection = function () {
        if (!validateSection(currentIndex)) return;

        // Reset any previously skipped sections after current (user may have changed answer)
        for (var i = currentIndex + 1; i < totalSecs; i++) {
            if (sections[i].dataset.skipped === '1') setSkipped(i, false);
        }

        // Check section routing: radio (data-go-to-section on checked input)
        // or dropdown (data-section-routing JSON on select element)
        var nextIndex = currentIndex + 1;
        var routedTarget = null;

        // 1. Radio routing
        var checkedRouted = sections[currentIndex].querySelector('[data-go-to-section]:checked');
        if (checkedRouted) {
            var t = parseInt(checkedRouted.getAttribute('data-go-to-section'));
            if (!isNaN(t) && t > currentIndex && t < totalSecs) routedTarget = t;
        }

        // 2. Dropdown routing
        if (routedTarget === null) {
            var routedSels = sections[currentIndex].querySelectorAll('select[data-section-routing]');
            routedSels.forEach(function (sel) {
                if (routedTarget !== null || !sel.value) return;
                try {
                    var map = JSON.parse(sel.getAttribute('data-section-routing'));
                    if (map[sel.value] !== undefined) {
                        var t2 = parseInt(map[sel.value]);
                        if (!isNaN(t2) && t2 > currentIndex && t2 < totalSecs) routedTarget = t2;
                    }
                } catch (e) {}
            });
        }

        if (routedTarget !== null) {
            nextIndex = routedTarget;
            for (var j = currentIndex + 1; j < nextIndex; j++) {
                setSkipped(j, true);
            }
        }

        goTo(nextIndex);
    };

    window.gfPrevSection = function () {
        if (sectionHistory.length === 0) return;
        var prev = sectionHistory.pop();
        // Un-skip the section we're returning to (in case it was skipped from a prior route)
        if (sections[prev].dataset.skipped === '1') setSkipped(prev, false);
        sections[currentIndex].classList.remove('active');
        sections[prev].classList.add('active');
        currentIndex = prev;
        updateProgress();
        updateNavForCurrentSection();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    function goTo(index) {
        if (index < 0 || index >= totalSecs) return;
        sectionHistory.push(currentIndex);
        sections[currentIndex].classList.remove('active');
        sections[index].classList.add('active');
        currentIndex = index;
        updateProgress();
        updateNavForCurrentSection();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Show Submit (instead of Next) if all remaining sections are skipped.
    // Restore Next button when going back and there are still unvisited sections.
    function updateNavForCurrentSection() {
        var sec     = sections[currentIndex];
        var nextBtn = sec.querySelector('.gf-nav-next');
        if (!nextBtn) return; // already a static submit section

        var hasUnvisited = false;
        for (var i = currentIndex + 1; i < totalSecs; i++) {
            if (sections[i].dataset.skipped !== '1') { hasUnvisited = true; break; }
        }

        var dynSubmit = sec.querySelector('.gf-submit-btn--routing');

        if (!hasUnvisited) {
            nextBtn.style.display = 'none';
            if (!dynSubmit) {
                dynSubmit = document.createElement('button');
                dynSubmit.type      = 'submit';
                dynSubmit.className = 'gf-submit-btn gf-submit-btn--routing';
                dynSubmit.innerHTML = '<i class="fas fa-paper-plane me-1"></i><span>Kirimkan Formulir</span>';
                nextBtn.parentNode.appendChild(dynSubmit);
            }
            dynSubmit.style.display = '';
        } else {
            nextBtn.style.display = '';
            if (dynSubmit) dynSubmit.style.display = 'none';
        }
    }

    function updateProgress() {
        var indicatorText = document.getElementById('gfSectionIndicatorText');
        var bar           = document.getElementById('gfProgressBar');
        var dots          = document.querySelectorAll('.gf-dot');

        // Update section indicator above header card
        if (indicatorText) {
            var name  = gfSectionNames[currentIndex] || '';
            var label = 'Bagian ' + (currentIndex + 1) + ' dari ' + totalSecs;
            indicatorText.textContent = name ? label + ' — ' + name : label;
        }
        if (bar) bar.style.width = Math.round(((currentIndex + 1) / totalSecs) * 100) + '%';
        dots.forEach(function (dot, i) {
            dot.classList.toggle('active', i === currentIndex);
            dot.classList.toggle('done',   i < currentIndex);
        });
    }

    // Validate required fields in the current section before advancing
    function validateSection(index) {
        var section = sections[index];
        var valid   = true;

        // Clear previous section-level errors
        section.querySelectorAll('.is-invalid').forEach(function (el) {
            el.classList.remove('is-invalid');
        });
        section.querySelectorAll('.gf-invalid').forEach(function (el) {
            el.textContent = '';
        });
        section.querySelectorAll('.gf-card.has-error').forEach(function (el) {
            el.classList.remove('has-error');
        });

        var firstErrorCard = null;

        section.querySelectorAll('[required]').forEach(function (input) {
            var empty = false;

            if (input.type === 'checkbox') {
                var name    = input.name.replace('[]', '');
                var checked = section.querySelectorAll('[name="' + input.name + '"]:checked, [name="' + name + '[]"]:checked');
                if (!checked.length) empty = true;
            } else if (input.type === 'radio') {
                var radios  = section.querySelectorAll('[name="' + input.name + '"]:checked');
                if (!radios.length) empty = true;
            } else if (input.type === 'file') {
                if (!input.files || !input.files.length) empty = true;
            } else {
                if (!input.value.trim()) empty = true;
            }

            if (empty) {
                valid = false;
                input.classList.add('is-invalid');
                var card = input.closest('.gf-card');
                if (card) {
                    card.classList.add('has-error');
                    var errEl = card.querySelector('.gf-invalid');
                    if (errEl && !errEl.textContent) errEl.textContent = 'Kolom ini wajib diisi.';
                    if (!firstErrorCard) firstErrorCard = card;
                }
            }
        });

        if (firstErrorCard) firstErrorCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return valid;
    }

    // After server-side validation error: navigate to the section containing the first error
    // Override the form submission error handler's behaviour
    var origShowValidation = window._gfShowValidationErrors;
    document.addEventListener('gf:validationErrors', function (e) {
        var errors = e.detail;
        if (!errors) return;
        var form = document.getElementById('publicFormSubmit');
        if (!form) return;

        var targetSection = null;
        Object.keys(errors).forEach(function (key) {
            if (targetSection !== null) return;
            var input = form.querySelector('[name="' + key + '"]') ||
                        form.querySelector('[name="' + key + '[]"]');
            if (!input) return;
            var sec = input.closest('.gf-form-section');
            if (sec) targetSection = parseInt(sec.getAttribute('data-section'), 10);
        });

        if (targetSection !== null && targetSection !== currentIndex) {
            goTo(targetSection);
        }
    });

})();
</script>
@endif
