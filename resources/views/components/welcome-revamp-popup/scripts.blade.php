<script>
/* ── Welcome 17 Agustus / HUT RI ke-81 — Popup Logic + Mini Game (REVAMP) ───── */
(function () {
    /* ── localStorage keys ── */
    var LS_KEYS_OLD = [
        'ldksyahid_welcome_popup',
        'ldksyahid_welcome_popup_eid_fitri',
        'ldksyahid_welcome_popup_arafah_fasting',
        'ldksyahid_welcome_popup_syawal_fasting',
        'ldksyahid_welcome_popup_self_reward',
        'ldksyahid_welcome_popup_qurban',
        'ldksyahid_welcome_popup_milad_30',
        'ldksyahid_welcome_popup_muharram_1448',
    ];
    var LS_KEY      = 'ldksyahid_welcome_popup_17agustus_2026';
    var LS_BEST_KEY = 'ldksyahid_welcome_popup_17agustus_best';
    var backdrop = document.getElementById('wrp-backdrop');

    LS_KEYS_OLD.forEach(function (k) { localStorage.removeItem(k); });
    if (localStorage.getItem(LS_KEY)) return;

    /* ── Scroll lock ── */
    function lockScroll()   { document.body.style.overflow = 'hidden'; }
    function unlockScroll() { document.body.style.overflow = ''; }

    /* ── Open / close / dismiss ── */
    function closePopup() {
        if (!backdrop) return;
        backdrop.classList.remove('active');
        unlockScroll();
        stopConfetti();
    }
    function dismissPopup() {
        if (!backdrop) return;
        backdrop.classList.remove('active');
        unlockScroll();
        stopConfetti();
        localStorage.setItem(LS_KEY, '1');
    }

    var btnShare   = document.getElementById('wrp-btn-share');
    var btnDismiss = document.getElementById('wrp-btn-dismiss');
    var btnX       = document.getElementById('wrp-x');
    var fallback   = document.getElementById('wrp-share-fallback');

    if (btnX)       btnX.addEventListener('click', closePopup);
    if (btnDismiss) btnDismiss.addEventListener('click', dismissPopup);

    /* ── Share data ── */
    var SHARE_TITLE = 'Dirgahayu Republik Indonesia ke-81';
    var SHARE_TEXT  = 'Dirgahayu Republik Indonesia ke-81! Merdeka! Semoga semangat kemerdekaan terus membakar karya dan dakwah kita. — LDK Syahid UIN Jakarta 🇮🇩✨';
    var SHARE_URL   = 'https://ldksyah.id';

    /* ── Copy to clipboard helper ── */
    function copyText(text, btn, doneLabel) {
        var old = btn ? btn.querySelector('span').textContent : '';
        function ok() {
            if (btn) {
                var span = btn.querySelector('span');
                span.textContent = doneLabel;
                btn.classList.add('copied');
                setTimeout(function () {
                    span.textContent = old;
                    btn.classList.remove('copied');
                }, 1600);
            }
        }
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text).then(ok).catch(function () { textareaCopy(text); ok(); });
        } else {
            textareaCopy(text); ok();
        }
    }
    function textareaCopy(text) {
        var ta = document.createElement('textarea');
        ta.value = text; ta.style.position = 'fixed'; ta.style.left = '-9999px';
        document.body.appendChild(ta); ta.select();
        try { document.execCommand('copy'); } catch (e) {}
        document.body.removeChild(ta);
    }

    /* ── Share buttons ── */
    (function initShare() {
        var copyBtn = document.getElementById('wrp-share-copy');
        if (copyBtn) copyBtn.addEventListener('click', function () {
            copyText(SHARE_TEXT + ' ' + SHARE_URL, copyBtn, 'Tersalin!');
        });

        function openShare(url) {
            var w = 560, h = 420;
            var left = (window.screen.width - w) / 2, top = (window.screen.height - h) / 2;
            window.open(url, '_blank', 'width=' + w + ',height=' + h + ',top=' + top + ',left=' + left);
        }

        var waBtn = document.getElementById('wrp-share-wa');
        if (waBtn) waBtn.addEventListener('click', function () {
            openShare('https://wa.me/?text=' + encodeURIComponent(SHARE_TEXT + ' ' + SHARE_URL));
        });

        var fbBtn = document.getElementById('wrp-share-fb');
        if (fbBtn) fbBtn.addEventListener('click', function () {
            openShare('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(SHARE_URL) + '&quote=' + encodeURIComponent(SHARE_TEXT));
        });

        var xBtn = document.getElementById('wrp-share-x');
        if (xBtn) xBtn.addEventListener('click', function () {
            openShare('https://twitter.com/intent/tweet?text=' + encodeURIComponent(SHARE_TEXT) + '&url=' + encodeURIComponent(SHARE_URL));
        });
    }());

    /* ── Main Share button (Web Share API + fallback) ── */
    if (btnShare) {
        btnShare.addEventListener('click', function () {
            if (navigator.share) {
                navigator.share({ title: SHARE_TITLE, text: SHARE_TEXT, url: SHARE_URL }).catch(function () {});
            } else {
                if (fallback) fallback.style.display = 'block';
                btnShare.style.display = 'none';
            }
        });
    }

    /* ── Close on backdrop click & Escape ── */
    if (backdrop) {
        backdrop.addEventListener('click', function (e) {
            if (e.target === backdrop) closePopup();
        });
    }
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closePopup();
    });

    /* ════════════════════════════════════════════════
       FULL-SCREEN CONFETTI / FIREWORKS ENGINE
    ════════════════════════════════════════════════ */
    var confettiRunning = false;
    var confettiId = null;
    var confettiPieces = [];

    function startConfetti() {
        var cv = document.getElementById('wrp-confetti-canvas');
        if (!cv) return;
        var ctx = cv.getContext('2d');
        var dpr = window.devicePixelRatio || 1;
        function resize() {
            cv.width = cv.clientWidth * dpr;
            cv.height = cv.clientHeight * dpr;
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        }
        resize();
        window.addEventListener('resize', resize);

        var cW = cv.clientWidth, cH = cv.clientHeight;
        var colors = ['#ff4444', '#ffffff', '#ffd43b', '#ff6b6b', '#ff9a3c', '#e02929'];
        var COLORS = colors;

        function makePiece(fromTop) {
            return {
                x: Math.random() * cW,
                y: fromTop ? Math.random() * cH * 0.5 : -20,
                vx: (Math.random() - .5) * 1.6,
                vy: (Math.random() * 2.2 + 1.2),
                w: 6 + Math.random() * 6,
                h: 4 + Math.random() * 5,
                rot: Math.random() * Math.PI * 2,
                vr: (Math.random() - .5) * .15,
                color: COLORS[Math.floor(Math.random() * COLORS.length)],
                kind: Math.random() > .5 ? 'rect' : 'circle',
            };
        }

        function burst(x, y) {
            for (var i = 0; i < 26; i++) {
                var a = Math.random() * Math.PI * 2;
                var sp = Math.random() * 5 + 2;
                confettiPieces.push(makePiece(true));
                var p = confettiPieces[confettiPieces.length - 1];
                p.x = x; p.y = y; p.vx = Math.cos(a) * sp; p.vy = Math.sin(a) * sp; p.w = 3; p.h = 3;
                p.life = 1;
            }
        }

        function frame() {
            if (!confettiRunning) return;
            ctx.clearRect(0, 0, cW, cH);
            // ambient falling confetti
            if (confettiPieces.length < 120 && Math.random() < .25) confettiPieces.push(makePiece(false));
            // occasional fireworks burst
            if (Math.random() < .02) burst(Math.random() * cW, Math.random() * cH * .5);
            for (var i = confettiPieces.length - 1; i >= 0; i--) {
                var p = confettiPieces[i];
                p.x += p.vx; p.y += p.vy;
                p.vy += .06; p.rot += p.vr;
                if (p.life != null) p.life -= .012;
                ctx.save();
                ctx.globalAlpha = p.life != null ? Math.max(p.life, 0) : 1;
                ctx.translate(p.x, p.y); ctx.rotate(p.rot);
                ctx.fillStyle = p.color;
                if (p.kind === 'circle') {
                    ctx.beginPath(); ctx.arc(0, 0, p.w / 2, 0, Math.PI * 2); ctx.fill();
                } else {
                    ctx.fillRect(-p.w / 2, -p.h / 2, p.w, p.h);
                }
                ctx.restore();
                if (p.y > cH + 20 || (p.life != null && p.life <= 0)) confettiPieces.splice(i, 1);
            }
            confettiId = requestAnimationFrame(frame);
        }
        confettiRunning = true;
        // prefill some
        for (var k = 0; k < 40; k++) confettiPieces.push(makePiece(false));
        frame();
    }
    function stopConfetti() {
        confettiRunning = false;
        if (confettiId) cancelAnimationFrame(confettiId);
        confettiId = null;
        confettiPieces = [];
    }

    /* ════════════════════════════════════════════════
       FLAG + FIREWORKS CANVAS — dekoratif di header
    ════════════════════════════════════════════════ */
    (function drawHeaderArt() {
        var mc = document.getElementById('wrp-moon-canvas');
        if (!mc) return;
        var dpr = window.devicePixelRatio || 1;
        mc.width  = mc.offsetWidth * dpr;
        mc.height = 96 * dpr;
        var mx = mc.getContext('2d');
        mx.scale(dpr, dpr);
        var mw = mc.offsetWidth, mh = 96;

        /* bintang latar */
        for (var j = 0; j < 40; j++) {
            var sx = Math.random() * mw, sy = Math.random() * mh, sr = Math.random() * .5 + .1;
            mx.beginPath(); mx.arc(sx, sy, sr, 0, Math.PI * 2);
            mx.fillStyle = 'rgba(255,255,255,' + (Math.random() * .5 + .15) + ')';
            mx.fill();
        }

        /* bendera merah putih bergelombang */
        var flagW = 84, flagH = 56, fx = mw / 2 - flagW / 2, fy = mh / 2 - flagH / 2;
        var wave = 5;

        function drawFlagStripe(colorTop, colorBottom, x, y, w, h) {
            mx.save();
            mx.beginPath();
            mx.moveTo(x, y + Math.sin(0) * wave);
            for (var i = 0; i <= w; i += 4) {
                mx.lineTo(x + i, y + Math.sin(i / 14) * wave);
            }
            mx.lineTo(x + w, y + h);
            mx.lineTo(x, y + h);
            mx.closePath();
            mx.fillStyle = colorTop;
            mx.fill();
            mx.restore();
        }
        drawFlagStripe('#e02929', '#e02929', fx, fy, flagW, flagH / 2);
        drawFlagStripe('#ffffff', '#ffffff', fx, fy + flagH / 2, flagW, flagH / 2);

        /* tiang bendera */
        mx.fillStyle = 'rgba(255,255,255,.55)';
        mx.fillRect(fx - 3, fy - 6, 3, flagH + 12);

        /* glow + percikan kembang api */
        function drawBurst(cx, cy, color, size, glow) {
            mx.save();
            if (glow) { mx.shadowColor = color; mx.shadowBlur = glow; }
            for (var p = 0; p < 8; p++) {
                var a = (Math.PI * 2 / 8) * p;
                mx.beginPath();
                mx.moveTo(cx, cy);
                mx.lineTo(cx + Math.cos(a) * size, cy + Math.sin(a) * size);
                mx.strokeStyle = color;
                mx.lineWidth = 1.4;
                mx.stroke();
            }
            mx.beginPath(); mx.arc(cx, cy, 2, 0, Math.PI * 2);
            mx.fillStyle = color; mx.fill();
            mx.restore();
        }
        drawBurst(fx + flagW + 26, fy + 6, '#ffd43b', 14, 12);
        drawBurst(fx - 22, fy + 20, '#ff6b6b', 12, 10);
        drawBurst(fx + flagW + 8, fy + flagH + 4, '#ffffff', 10, 8);
    }());

    /* ════════════════════════════════════════════════
       MINI GAME — Nyalakan Kembang Api Kemerdekaan
    ════════════════════════════════════════════════ */
    (function initGame() {
        var cv      = document.getElementById('wrp-canvas');
        if (!cv) return;
        var ctx     = cv.getContext('2d');
        var dpr     = window.devicePixelRatio || 1;
        cv.width    = cv.offsetWidth * dpr;
        cv.height   = 120 * dpr;
        ctx.scale(dpr, dpr);
        var cW = cv.offsetWidth, cH = 120;

        var score = 0, timeLeft = 15, running = true;
        var combo = 0, best = parseInt(localStorage.getItem(LS_BEST_KEY) || '0', 10) || 0;
        var stars = [], particles = [], lastSpawn = 0;

        var scoreEl    = document.getElementById('wrp-score-val');
        var timerEl    = document.getElementById('wrp-timer-val');
        var timerWrap  = document.getElementById('wrp-timer');
        var comboEl    = document.getElementById('wrp-combo');
        var comboWrap  = document.getElementById('wrp-combo');
        var comboVal   = document.getElementById('wrp-combo-val');
        var bestEl     = document.getElementById('wrp-best-val');
        var msgEl      = document.getElementById('wrp-game-msg');

        if (bestEl) bestEl.textContent = best;

        function rnd(a, b) { return a + Math.random() * (b - a); }

        function spawnStar() {
            stars.push({
                x     : rnd(16, cW - 16),
                y     : -16,
                r     : rnd(7, 11),
                speed : rnd(.9, 2.4),
                rot   : 0,
                rs    : rnd(-.05, .05),
                trail : [],
                color : Math.random() > .4 ? '#ff4444' : (Math.random() > .5 ? '#ffffff' : '#ffd43b'),
            });
        }

        function drawStar5(c, x, y, r, rot, op, col) {
            c.save(); c.globalAlpha = op;
            c.translate(x, y); c.rotate(rot);
            c.beginPath();
            for (var i = 0; i < 10; i++) {
                var a = Math.PI / 5 * i - Math.PI / 2, rad = i % 2 === 0 ? r : r * .42;
                c.lineTo(Math.cos(a) * rad, Math.sin(a) * rad);
            }
            c.closePath();
            c.fillStyle = col; c.shadowColor = col; c.shadowBlur = 10;
            c.fill(); c.restore();
        }

        function spawnParticles(x, y, col) {
            for (var i = 0; i < 12; i++) {
                var a = Math.random() * Math.PI * 2, spd = rnd(1.5, 4.5);
                particles.push({ x: x, y: y, vx: Math.cos(a) * spd, vy: Math.sin(a) * spd, life: 1, col: col });
            }
        }

        function drawBg() {
            ctx.fillStyle = '#0d0303'; ctx.fillRect(0, 0, cW, cH);
            ctx.fillStyle = 'rgba(255,255,255,0.03)';
            for (var gx = 0; gx < cW; gx += 18)
                for (var gy = 0; gy < cH; gy += 18)
                    ctx.fillRect(gx, gy, 1, 1);
        }

        var lt = 0;
        function update(dt) {
            lastSpawn += dt;
            // level-based spawn: faster as score grows
            var base = Math.max(420, 950 - score * 22);
            var si = timeLeft > 10 ? base : timeLeft > 5 ? base * .7 : base * .45;
            if (lastSpawn > si) { spawnStar(); lastSpawn = 0; }

            stars.forEach(function (s) {
                s.y += s.speed;
                s.rot += s.rs;
                s.trail.push({ x: s.x, y: s.y });
                if (s.trail.length > 6) s.trail.shift();
            });
            stars = stars.filter(function (s) { return s.y < cH + 20; });

            particles.forEach(function (p) { p.x += p.vx; p.y += p.vy; p.vy += .12; p.life -= .065; });
            particles = particles.filter(function (p) { return p.life > 0; });
        }

        function render() {
            drawBg();

            // star trails
            stars.forEach(function (s) {
                for (var t = 0; t < s.trail.length; t++) {
                    ctx.save();
                    ctx.globalAlpha = (t + 1) / s.trail.length * .35;
                    ctx.fillStyle = s.color;
                    ctx.beginPath();
                    ctx.arc(s.trail[t].x, s.trail[t].y, s.r * .5 * ((t + 1) / s.trail.length), 0, Math.PI * 2);
                    ctx.fill();
                    ctx.restore();
                }
            });

            stars.forEach(function (s) { drawStar5(ctx, s.x, s.y, s.r, s.rot, 1, s.color); });

            particles.forEach(function (p) {
                ctx.save(); ctx.globalAlpha = p.life;
                ctx.shadowColor = p.col; ctx.shadowBlur = 8;
                ctx.fillStyle = p.col; ctx.beginPath();
                ctx.arc(p.x, p.y, 2.5, 0, Math.PI * 2); ctx.fill(); ctx.restore();
            });

            if (!running) {
                ctx.fillStyle = 'rgba(13,3,3,0.82)'; ctx.fillRect(0, 0, cW, cH);
                ctx.fillStyle = '#ff5c5c'; ctx.font = 'bold 13px sans-serif'; ctx.textAlign = 'center';
                ctx.fillText('Selesai! ' + score + ' percikan tertangkap', cW / 2, cH / 2 - 8);
                ctx.fillStyle = 'rgba(255,255,255,0.45)'; ctx.font = '10px sans-serif';
                ctx.fillText('Klik untuk main lagi', cW / 2, cH / 2 + 10);
            }
        }

        function loop(ts) { var dt = ts - lt; lt = ts; if (running) update(dt); render(); requestAnimationFrame(loop); }
        requestAnimationFrame(loop);

        /* Timer */
        var timerInt;
        function startTimer() {
            clearInterval(timerInt);
            timerInt = setInterval(function () {
                if (!running) return;
                timeLeft--;
                if (timerEl) timerEl.textContent = timeLeft;
                if (timeLeft <= 5 && timerWrap) timerWrap.style.color = '#e06060';
                if (timeLeft <= 0) {
                    running = false; clearInterval(timerInt);
                    var msgs = [
                        'Jangan menyerah, coba lagi! 💪',
                        'Hampir! Coba sekali lagi ✨',
                        'Mulai bagus! Coba lagi! 🇮🇩',
                        'MERDEKA! Semangat juangmu membara! 🔥',
                    ];
                    var idx = score >= 5 ? 3 : score >= 2 ? 2 : score >= 1 ? 1 : 0;
                    if (msgEl) {
                        msgEl.style.color = score >= 5 ? '#ff5c5c' : '#6b5252';
                        msgEl.textContent = msgs[idx];
                    }
                    // save best score
                    if (score > best) {
                        best = score;
                        localStorage.setItem(LS_BEST_KEY, String(best));
                        if (bestEl) bestEl.textContent = best;
                    }
                }
            }, 1000);
        }
        startTimer();

        /* Reset game */
        function resetGame() {
            score = 0; timeLeft = 15; stars = []; particles = []; running = true; lastSpawn = 0; combo = 0;
            if (scoreEl) scoreEl.textContent = '0';
            if (timerEl) timerEl.textContent = '15';
            if (timerWrap) timerWrap.style.color = 'rgba(255,255,255,0.35)';
            if (comboVal) comboVal.textContent = '0';
            if (msgEl) { msgEl.style.color = '#6b5252'; msgEl.textContent = 'Klik percikan kembang api yang jatuh secepat mungkin!'; }
            startTimer();
        }

        /* Click handler */
        cv.addEventListener('click', function (e) {
            if (!running) { resetGame(); return; }
            var rect = cv.getBoundingClientRect();
            var mx = e.clientX - rect.left, my = e.clientY - rect.top;
            var hit = false;
            stars = stars.filter(function (s) {
                var dx = s.x - mx, dy = s.y - my;
                if (Math.sqrt(dx * dx + dy * dy) < s.r + 9) {
                    spawnParticles(s.x, s.y, s.color);
                    combo++;
                    score += combo >= 3 ? 2 : 1; // combo bonus
                    if (scoreEl) scoreEl.textContent = score;
                    if (comboVal) comboVal.textContent = combo;
                    if (comboWrap) comboWrap.classList.remove('pop'), void comboWrap.offsetWidth, comboWrap.classList.add('pop');
                    hit = true; return false;
                }
                return true;
            });
            if (!hit) { combo = 0; if (comboVal) comboVal.textContent = '0'; }
            if (hit && msgEl) {
                var m = ['Yaa! +1 ✨', 'Semangat merdeka! ⭐', 'MERDEKA! 🇮🇩', 'Terus semangat! 💫', 'Mantap! 🎇', 'Combo! 🔥🔥'];
                if (combo >= 3) m = ['COMBO ' + combo + 'x! 🔥🔥', 'Luar biasa! 🌟', 'Merdeka terus! 💥'];
                msgEl.style.color = '#ff8080';
                msgEl.textContent = m[Math.floor(Math.random() * m.length)];
            }
        });
    }());

    /* ════════════════════════════════════════════════
       KADO HUT RI ke-81 — REVEAL SURPRISE
    ════════════════════════════════════════════════ */
    (function initGift() {
        var box    = document.getElementById('wrp-gift-box');
        var reveal = document.getElementById('wrp-gift-reveal');
        var giftShare = document.getElementById('wrp-btn-gift-share');
        if (!box || !reveal) return;

        function openGift() {
            box.style.display = 'none';
            reveal.hidden = false;
            // burst of confetti on reveal
            for (var i = 0; i < 3; i++) {
                burstAt(Math.random() * (window.innerWidth), Math.random() * (window.innerHeight * .5));
            }
        }

        box.addEventListener('click', openGift);
        box.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); openGift(); }
        });

        if (giftShare) {
            giftShare.addEventListener('click', function () {
                var msg = 'Kado HUT RI ke-81 🎁🇮🇩\n"Dirgahayu Republik Indonesia ke-81! Semoga negeri ini diberkahi Allah, dipersatukan dalam keberagaman, dijauhkan dari fitnah, dan dipimpin oleh amanah. Aamiin. 🤲"\n— LDK Syahid UIN Jakarta';
                if (navigator.share) {
                    navigator.share({ title: SHARE_TITLE, text: msg, url: SHARE_URL }).catch(function () {});
                } else {
                    copyText(msg, giftShare, 'Doa tersalin!');
                }
            });
        }

        // globe-level burst helper (accessible from confetti engine)
        window.__wrpBurst = burstAt;
    }());

    // helper to trigger a burst using the confetti engine
    function burstAt(x, y) {
        var cv = document.getElementById('wrp-confetti-canvas');
        if (!cv || !confettiRunning) return;
        var ctx = cv.getContext('2d');
        var dpr = window.devicePixelRatio || 1;
        var colors = ['#ff4444', '#ffffff', '#ffd43b', '#ff6b6b', '#ff9a3c', '#e02929'];
        for (var i = 0; i < 26; i++) {
            var a = Math.random() * Math.PI * 2;
            var sp = Math.random() * 5 + 2;
            var halfW = cv.clientWidth / 2, halfH = cv.clientHeight / 2;
            var px = x, py = y;
            confettiPieces.push({
                x: px, y: py,
                vx: Math.cos(a) * sp, vy: Math.sin(a) * sp,
                w: 3, h: 3, rot: 0, vr: (Math.random() - .5) * .2,
                color: colors[Math.floor(Math.random() * colors.length)],
                kind: 'circle', life: 1,
            });
        }
    }

    /* ── Show popup ── */
    function showPopup() {
        setTimeout(function () {
            if (backdrop) {
                backdrop.classList.add('active');
                lockScroll();
                startConfetti();
            }
        }, 800);
    }
    if (document.readyState === 'complete') { showPopup(); }
    else { window.addEventListener('load', showPopup); }
}());
</script>
