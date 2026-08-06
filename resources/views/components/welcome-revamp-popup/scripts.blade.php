<script>
/* ── Welcome 17 Agustus / HUT RI ke-81 — Popup Logic + Mini Game ──────────────── */
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
    var LS_KEY   = 'ldksyahid_welcome_popup_17agustus_2026';
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
    }
    function dismissPopup() {
        if (!backdrop) return;
        backdrop.classList.remove('active');
        unlockScroll();
        localStorage.setItem(LS_KEY, '1');
    }

    var btnShare   = document.getElementById('wrp-btn-share');
    var btnDismiss = document.getElementById('wrp-btn-dismiss');
    var btnX       = document.getElementById('wrp-x');
    var fallback   = document.getElementById('wrp-share-fallback');

    if (btnX)       btnX.addEventListener('click', closePopup);
    if (btnDismiss) btnDismiss.addEventListener('click', dismissPopup);

    /* ── Share button — Web Share API + fallback ── */
    if (btnShare) {
        var shareData = {
            title : 'Dirgahayu Republik Indonesia ke-81',
            text  : 'Dirgahayu Republik Indonesia ke-81! Merdeka! Semoga semangat kemerdekaan terus membakar karya dan dakwah kita. — LDK Syahid UIN Jakarta 🇮🇩✨',
            url   : 'https://ldksyahid.com',
        };
        btnShare.addEventListener('click', function () {
            if (navigator.share) {
                navigator.share(shareData).catch(function () {});
            } else {
                /* Desktop fallback: tampilkan link copy-able */
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
       FLAG + FIREWORKS CANVAS — dekoratif di header
    ════════════════════════════════════════════════ */
    (function drawHeaderArt() {
        var mc = document.getElementById('wrp-moon-canvas');
        if (!mc) return;
        var dpr = window.devicePixelRatio || 1;
        mc.width  = mc.offsetWidth * dpr;
        mc.height = 90 * dpr;
        var mx = mc.getContext('2d');
        mx.scale(dpr, dpr);
        var mw = mc.offsetWidth, mh = 90;

        /* bintang latar (percikan jauh) */
        for (var j = 0; j < 40; j++) {
            var sx = Math.random() * mw, sy = Math.random() * mh, sr = Math.random() * .5 + .1;
            mx.beginPath(); mx.arc(sx, sy, sr, 0, Math.PI * 2);
            mx.fillStyle = 'rgba(255,255,255,' + (Math.random() * .5 + .15) + ')';
            mx.fill();
        }

        /* bendera merah putih bergelombang di tengah */
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

        /* percikan kembang api */
        function drawBurst(cx, cy, color, size) {
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
        }
        drawBurst(fx + flagW + 26, fy + 6, '#ffd43b', 12);
        drawBurst(fx - 22, fy + 20, '#ff6b6b', 10);
        drawBurst(fx + flagW + 8, fy + flagH + 4, '#ffffff', 8);
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
        var stars = [], particles = [], lastSpawn = 0;

        var scoreEl = document.getElementById('wrp-score-val');
        var timerEl = document.getElementById('wrp-timer-val');
        var timerWrap = document.getElementById('wrp-timer');
        var msgEl   = document.getElementById('wrp-game-msg');

        function rnd(a, b) { return a + Math.random() * (b - a); }

        function spawnStar() {
            stars.push({
                x     : rnd(14, cW - 14),
                y     : -14,
                r     : rnd(7, 11),
                speed : rnd(.9, 2.4),
                rot   : 0,
                rs    : rnd(-.05, .05),
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
            c.fillStyle = col; c.shadowColor = col; c.shadowBlur = 8;
            c.fill(); c.restore();
        }

        function spawnParticles(x, y, col) {
            for (var i = 0; i < 9; i++) {
                var a = Math.random() * Math.PI * 2, spd = rnd(1.5, 4);
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
            var si = timeLeft > 10 ? 950 : timeLeft > 5 ? 680 : 420;
            if (lastSpawn > si) { spawnStar(); lastSpawn = 0; }

            stars.forEach(function (s) { s.y += s.speed; s.rot += s.rs; });
            stars = stars.filter(function (s) { return s.y < cH + 20; });

            particles.forEach(function (p) { p.x += p.vx; p.y += p.vy; p.vy += .12; p.life -= .065; });
            particles = particles.filter(function (p) { return p.life > 0; });
        }

        function render() {
            drawBg();
            stars.forEach(function (s) { drawStar5(ctx, s.x, s.y, s.r, s.rot, 1, s.color); });
            particles.forEach(function (p) {
                ctx.save(); ctx.globalAlpha = p.life;
                ctx.fillStyle = p.col; ctx.beginPath();
                ctx.arc(p.x, p.y, 2.5, 0, Math.PI * 2); ctx.fill(); ctx.restore();
            });
            if (!running) {
                ctx.fillStyle = 'rgba(13,3,3,0.8)'; ctx.fillRect(0, 0, cW, cH);
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
                }
            }, 1000);
        }
        startTimer();

        /* Reset game */
        function resetGame() {
            score = 0; timeLeft = 15; stars = []; particles = []; running = true; lastSpawn = 0;
            if (scoreEl) scoreEl.textContent = '0';
            if (timerEl) timerEl.textContent = '15';
            if (timerWrap) timerWrap.style.color = 'rgba(255,255,255,0.35)';
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
                    score++; if (scoreEl) scoreEl.textContent = score;
                    hit = true; return false;
                }
                return true;
            });
            if (hit && msgEl) {
                var m = ['Yaa! +1 ✨', 'Semangat merdeka! ⭐', 'MERDEKA! 🇮🇩', 'Terus semangat! 💫', 'Mantap! 🎇'];
                msgEl.style.color = '#ff8080';
                msgEl.textContent = m[Math.floor(Math.random() * m.length)];
            }
        });
    }());

    /* ── Show popup ── */
    function showPopup() {
        setTimeout(function () {
            if (backdrop) { backdrop.classList.add('active'); lockScroll(); }
        }, 800);
    }
    if (document.readyState === 'complete') { showPopup(); }
    else { window.addEventListener('load', showPopup); }
}());
</script>