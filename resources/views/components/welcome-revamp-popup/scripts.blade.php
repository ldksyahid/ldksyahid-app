<script>
/* ── Popup open / close / dismiss ────────────────────────────────── */
(function () {
    var LS_KEYS_OLD = [
        'ldksyahid_welcome_popup',
        'ldksyahid_welcome_popup_eid_fitri',
        'ldksyahid_welcome_popup_arafah_fasting',
        'ldksyahid_welcome_popup_syawal_fasting',
        'ldksyahid_welcome_popup_self_reward',
    ];
    var LS_KEY   = 'ldksyahid_welcome_popup_qurban';
    var backdrop = document.getElementById('wrp-backdrop');

    LS_KEYS_OLD.forEach(function (k) { localStorage.removeItem(k); });
    if (localStorage.getItem(LS_KEY)) return;

    function lockScroll()   { document.body.style.overflow = 'hidden'; }
    function unlockScroll() { document.body.style.overflow = ''; }

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

    var btnExplore = document.getElementById('wrp-btn-explore');
    var btnDismiss = document.getElementById('wrp-btn-dismiss');
    var btnX       = document.getElementById('wrp-x');

    if (btnExplore) btnExplore.addEventListener('click', closePopup);
    if (btnDismiss) btnDismiss.addEventListener('click', dismissPopup);
    if (btnX)       btnX.addEventListener('click', closePopup);

    if (backdrop) {
        backdrop.addEventListener('click', function (e) {
            if (e.target === backdrop) closePopup();
        });
    }
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closePopup();
    });

    function showPopup() {
        setTimeout(function () {
            if (backdrop) { backdrop.classList.add('active'); lockScroll(); }
        }, 800);
    }
    if (document.readyState === 'complete') { showPopup(); }
    else { window.addEventListener('load', showPopup); }
}());

/* ── Mini Game: Kambing Runner (Chrome Dino style) ───────────────── */
(function () {
    var canvas = document.getElementById('wrp-dino-canvas');
    if (!canvas) return;
    var ctx = canvas.getContext('2d');

    /* ── Logical dimensions (set on boot) ── */
    var W = 0, H = 0, dpr = 1;
    var GROUND_H  = 15;  /* strip height at bottom */
    var GROUND_Y  = 0;   /* y of ground line — set on boot */
    var GOAT_SIZE = 30;  /* emoji render size (px) */
    var GOAT_X    = 30;  /* fixed horizontal position */
    var GOAT_BASE = 0;   /* y when standing on ground — set on boot */

    /* ── Physics ── */
    var GRAVITY   = 0.52;
    var JUMP_VEL  = -7.8;
    var MAX_JUMPS = 2;   /* double-jump allowed */

    /* ── Game state ── */
    var state        = 'idle';
    var goatY        = 0;
    var goatVel      = 0;
    var jumpCount    = 0;
    var obstacles    = [];
    var score        = 0;
    var frame        = 0;
    var spd          = 3.2;
    var obCooldown   = 90;   /* frames before first obstacle */
    var dashOffset   = 0;    /* ground dash animation offset */
    var clouds       = [];

    /* ── Canvas init ── */
    function initCanvas() {
        dpr = window.devicePixelRatio || 1;
        W   = canvas.offsetWidth  || 300;
        H   = canvas.offsetHeight || 115;
        canvas.width  = Math.round(W * dpr);
        canvas.height = Math.round(H * dpr);
        ctx.scale(dpr, dpr);
        GROUND_Y  = H - GROUND_H;
        GOAT_BASE = GROUND_Y - GOAT_SIZE;
        /* Randomise cloud positions once */
        clouds = [
            { x: W * 0.20, y: 10, w: 32, h: 11 },
            { x: W * 0.55, y: 22, w: 26, h:  9 },
            { x: W * 0.82, y:  8, w: 38, h: 13 },
        ];
    }

    /* ── Reset ── */
    function reset() {
        goatY      = GOAT_BASE;
        goatVel    = 0;
        jumpCount  = 0;
        obstacles  = [];
        score      = 0;
        frame      = 0;
        spd        = 3.2;
        obCooldown = 90;
        dashOffset = 0;
    }

    /* ── Jump ── */
    function tryJump() {
        if (jumpCount < MAX_JUMPS) {
            goatVel = JUMP_VEL;
            jumpCount++;
        }
    }

    /* ── Input handler ── */
    function handleTap() {
        if (state === 'idle') {
            reset();
            state = 'playing';
            tryJump();
        } else if (state === 'playing') {
            tryJump();
        } else {           /* dead → restart */
            reset();
            state = 'playing';
            tryJump();
        }
    }

    canvas.addEventListener('pointerdown', function (e) {
        e.preventDefault();
        handleTap();
    });

    document.addEventListener('keydown', function (e) {
        if (e.code !== 'Space' && e.key !== ' ') return;
        var bd = document.getElementById('wrp-backdrop');
        if (!bd || !bd.classList.contains('active')) return;
        e.preventDefault();
        handleTap();
    });

    /* ── Obstacle spawn ── */
    function spawnObstacle() {
        /* Obstacle heights vary — keep clearable with single jump */
        var heights = [20, 24, 28, 32, 36, 22, 26];
        var widths  = [13, 15, 17, 14, 16];
        var h = heights[Math.floor(Math.random() * heights.length)];
        var w = widths[Math.floor(Math.random() * widths.length)];
        obstacles.push({ x: W + 4, w: w, h: h });

        /* Gap between obstacles shrinks as speed rises */
        var minGap = Math.max(55 - (spd - 3.2) * 6, 38);
        obCooldown = Math.floor(minGap + Math.random() * 40);
    }

    /* ── Update ── */
    function update() {
        frame++;

        /* Idle: gentle bob */
        if (state === 'idle') {
            goatY = GOAT_BASE + Math.sin(frame * 0.1) * 2.5;
            return;
        }
        if (state !== 'playing') return;

        /* Progressive speed (cap at 8.5) */
        spd = Math.min(3.2 + frame * 0.0022, 8.5);

        /* Score every 5 frames */
        if (frame % 5 === 0) score++;

        /* Goat physics */
        goatVel += GRAVITY;
        goatY   += goatVel;
        if (goatY >= GOAT_BASE) {
            goatY     = GOAT_BASE;
            goatVel   = 0;
            jumpCount = 0;
        }

        /* Ground dash offset */
        dashOffset = (dashOffset + spd * 0.5) % 28;

        /* Cloud drift */
        clouds.forEach(function (c) {
            c.x -= 0.5;
            if (c.x + c.w < -5) c.x = W + 5;
        });

        /* Obstacles */
        obCooldown--;
        if (obCooldown <= 0) spawnObstacle();
        for (var i = obstacles.length - 1; i >= 0; i--) {
            obstacles[i].x -= spd;
            if (obstacles[i].x + obstacles[i].w < -5) obstacles.splice(i, 1);
        }

        /* ── Collision (slightly shrunk hitbox for fairness) ── */
        var ghb = 5;  /* hitbox inset */
        var gx  = GOAT_X + ghb;
        var gy  = goatY  + ghb;
        var gw  = GOAT_SIZE - ghb * 2;
        var gh  = GOAT_SIZE - ghb * 2;

        for (var j = 0; j < obstacles.length; j++) {
            var ob    = obstacles[j];
            var obTop = GROUND_Y - ob.h;
            if (gx + gw > ob.x + 2 &&
                gx      < ob.x + ob.w - 2 &&
                gy + gh > obTop + 2) {
                state = 'dead';
                return;
            }
        }
    }

    /* ── Draw helpers ── */
    function fillRR(x, y, w, h, r) {
        if (w <= 0 || h <= 0) return;
        var rv = Math.min(r, w / 2, h / 2);
        ctx.beginPath();
        ctx.moveTo(x + rv, y);
        ctx.lineTo(x + w - rv, y);
        ctx.quadraticCurveTo(x + w, y, x + w, y + rv);
        ctx.lineTo(x + w, y + h - rv);
        ctx.quadraticCurveTo(x + w, y + h, x + w - rv, y + h);
        ctx.lineTo(x + rv, y + h);
        ctx.quadraticCurveTo(x, y + h, x, y + rv);
        ctx.quadraticCurveTo(x, y, x + rv, y);
        ctx.closePath();
        ctx.fill();
    }

    function drawCloud(c) {
        ctx.fillStyle = 'rgba(167,139,250,.1)';
        ctx.beginPath();
        ctx.arc(c.x + c.w * 0.28, c.y + c.h * 0.6, c.h * 0.65, 0, Math.PI * 2);
        ctx.arc(c.x + c.w * 0.52, c.y + c.h * 0.35, c.h * 0.75, 0, Math.PI * 2);
        ctx.arc(c.x + c.w * 0.78, c.y + c.h * 0.6, c.h * 0.58, 0, Math.PI * 2);
        ctx.fill();
    }

    function drawObstacle(ob) {
        var obTop = GROUND_Y - ob.h;
        /* Body */
        var g = ctx.createLinearGradient(ob.x, 0, ob.x + ob.w, 0);
        g.addColorStop(0, '#6d28d9');
        g.addColorStop(1, '#9333ea');
        ctx.fillStyle = g;
        fillRR(ob.x, obTop + 6, ob.w, ob.h - 6, 2);
        /* Cap */
        ctx.fillStyle = '#a855f7';
        fillRR(ob.x - 2, obTop, ob.w + 4, 8, 3);
        /* Highlight */
        ctx.fillStyle = 'rgba(255,255,255,.11)';
        ctx.fillRect(ob.x + 2, obTop + 8, 3, ob.h - 10);
    }

    function resultMsg() {
        if (score <  8)  return 'Bestie... 💀 skill issue nih fr';
        if (score < 20)  return 'Lumayan! Masih bisa naik bestie 😤';
        if (score < 35)  return 'W play bestie! No cap! 🔥';
        if (score < 55)  return 'Beast mode unlocked bro! 👑';
        return 'OMG qurban running GOD!! 🏆🐐';
    }

    /* ── Draw ── */
    function draw() {
        ctx.clearRect(0, 0, W, H);

        /* Sky */
        var sky = ctx.createLinearGradient(0, 0, 0, GROUND_Y);
        sky.addColorStop(0, '#1c0a35');
        sky.addColorStop(1, '#2a1050');
        ctx.fillStyle = sky;
        ctx.fillRect(0, 0, W, GROUND_Y);

        /* Clouds */
        clouds.forEach(drawCloud);

        /* Ground strip */
        var gnd = ctx.createLinearGradient(0, GROUND_Y, 0, H);
        gnd.addColorStop(0, '#5b21b6');
        gnd.addColorStop(1, '#3b0f6e');
        ctx.fillStyle = gnd;
        ctx.fillRect(0, GROUND_Y, W, GROUND_H);

        /* Ground line */
        ctx.strokeStyle = '#a855f7';
        ctx.lineWidth = 1.5;
        ctx.beginPath();
        ctx.moveTo(0, GROUND_Y);
        ctx.lineTo(W, GROUND_Y);
        ctx.stroke();

        /* Ground running dashes (moves when playing) */
        if (state === 'playing') {
            ctx.strokeStyle = 'rgba(167,139,250,.22)';
            ctx.lineWidth = 1;
            for (var dx = -dashOffset; dx < W; dx += 28) {
                ctx.beginPath();
                ctx.moveTo(dx, GROUND_Y + 6);
                ctx.lineTo(dx + 14, GROUND_Y + 6);
                ctx.stroke();
            }
        }

        /* Obstacles */
        obstacles.forEach(drawObstacle);

        /* Goat — flip horizontal so it faces right (running direction).
           Explicit emoji font stack forces color rendering on all platforms
           (avoids monochrome fallback on Windows/Android). */
        ctx.save();
        ctx.font = GOAT_SIZE + 'px "Apple Color Emoji","Segoe UI Emoji","Noto Color Emoji",serif';
        ctx.textBaseline = 'top';
        ctx.translate(GOAT_X + GOAT_SIZE, goatY);
        ctx.scale(-1, 1);
        ctx.fillText('🐐', 0, 0);
        ctx.restore();

        /* Score — textBaseline:'top' prevents text being clipped at y=0 */
        if (state === 'playing') {
            ctx.textAlign    = 'right';
            ctx.textBaseline = 'top';
            ctx.font = 'bold 12px monospace';
            ctx.fillStyle = 'rgba(0,0,0,.3)';
            ctx.fillText(score, W - 7, 11);
            ctx.fillStyle = '#f3e8ff';
            ctx.fillText(score, W - 8, 10);
            ctx.font = '9px monospace';
            ctx.fillStyle = 'rgba(192,132,252,.5)';
            ctx.fillText('SKOR', W - 8, 24);
        }

        /* ── Idle overlay ── */
        if (state === 'idle') {
            ctx.fillStyle = 'rgba(12,4,24,.52)';
            ctx.fillRect(0, 0, W, H);
            ctx.textAlign = 'center';
            ctx.fillStyle = '#f3e8ff';
            ctx.font = 'bold 12px monospace';
            ctx.fillText('🎮 TAP UNTUK MAIN!', W / 2, H / 2 - 14);
            ctx.fillStyle = '#c084fc';
            ctx.font = '10px monospace';
            ctx.fillText('Lompat hindari halangan — double jump OK!', W / 2, H / 2 + 2);
        }

        /* ── Dead overlay ── */
        if (state === 'dead') {
            ctx.fillStyle = 'rgba(12,4,24,.7)';
            ctx.fillRect(0, 0, W, H);
            ctx.textAlign = 'center';
            ctx.fillStyle = '#f87171';
            ctx.font = 'bold 12px monospace';
            ctx.fillText('NABRAK!! 😭', W / 2, H / 2 - 22);
            ctx.fillStyle = '#f3e8ff';
            ctx.font = 'bold 14px monospace';
            ctx.fillText('⭐ SKOR: ' + score, W / 2, H / 2 - 5);
            ctx.fillStyle = '#c084fc';
            ctx.font = '10px monospace';
            ctx.fillText(resultMsg(), W / 2, H / 2 + 11);
            ctx.fillStyle = 'rgba(192,132,252,.55)';
            ctx.font = '9px monospace';
            ctx.fillText('tap / spasi untuk main lagi', W / 2, H / 2 + 24);
        }
    }

    /* ── Game loop ── */
    function loop() {
        update();
        draw();
        requestAnimationFrame(loop);
    }

    /* ── Boot: wait for layout ── */
    function boot() {
        initCanvas();
        reset();
        requestAnimationFrame(loop);
    }

    if (document.readyState === 'complete') {
        setTimeout(boot, 250);
    } else {
        window.addEventListener('load', function () { setTimeout(boot, 250); });
    }
}());
</script>
