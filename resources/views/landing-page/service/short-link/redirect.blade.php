<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Mengalihkan… &#9679; LDK Syahid</title>
    <link rel="icon" href="https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1"/>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet"/>
    {{-- Apply dark mode before render to prevent flash --}}
    <script>(function(){if(localStorage.getItem('darkMode')==='enabled')document.documentElement.setAttribute('data-theme','dark');})();</script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            min-height: 100vh;
            gap: 1.5rem;
            transition: background 0.3s;
        }

        [data-theme="dark"] body {
            background:
                radial-gradient(ellipse at 15% 50%, rgba(0,180,170,0.22) 0%, transparent 55%),
                radial-gradient(ellipse at 85% 50%, rgba(255,154,158,0.18) 0%, transparent 55%),
                #0f1117;
        }

        /* ── Spinner ── */
        .spinner-fun-ldk {
            position: relative;
            width: 130px;
            height: 130px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ldk-spin-img {
            width: 72px;
            height: 72px;
            border-radius: 18px;
            position: relative;
            z-index: 2;
            animation: ldkSpinPulse 2.2s ease-in-out infinite;
            mix-blend-mode: multiply;
        }

        [data-theme="dark"] .ldk-spin-img {
            mix-blend-mode: normal;
            filter: brightness(1.15) drop-shadow(0 0 10px rgba(0,167,157,0.35));
        }

        .ldk-ring {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border: 2.5px solid transparent;
            pointer-events: none;
        }

        .ldk-ring-1 {
            border-top-color: #00a79d;
            border-right-color: #00a79d;
            animation: ldkOrbitFun 1.5s linear infinite;
            opacity: 0.7;
        }

        .ldk-ring-2 {
            inset: -12px;
            border-bottom-color: #f59e0b;
            border-left-color: #f59e0b;
            animation: ldkOrbitFun 2.2s linear infinite reverse;
            opacity: 0.5;
        }

        .ldk-dot-orbit {
            position: absolute;
            inset: -6px;
            border-radius: 50%;
            animation: ldkOrbitFun 2.8s linear infinite;
        }

        .ldk-dot-orbit-2 { animation-delay: -0.93s; }
        .ldk-dot-orbit-3 { animation-delay: -1.87s; }

        .ldk-orbit-dot {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 9px;
            height: 9px;
            border-radius: 50%;
            display: block;
        }

        .ldk-dot-orbit-1 .ldk-orbit-dot { background: #00a79d; }
        .ldk-dot-orbit-2 .ldk-orbit-dot { background: #f59e0b; }
        .ldk-dot-orbit-3 .ldk-orbit-dot { background: #ec4899; }

        @keyframes ldkSpinPulse {
            0%, 100% { transform: scale(1); filter: drop-shadow(0 0 8px rgba(0,167,157,0.4)); }
            50%       { transform: scale(1.1); filter: drop-shadow(0 0 18px rgba(0,167,157,0.7)); }
        }

        @keyframes ldkOrbitFun {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        /* ── Label ── */
        .ldk-spin-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }

        .ldk-spin-brand {
            font-weight: 700;
            font-size: 1rem;
            color: #1a1d1f;
            letter-spacing: -0.01em;
        }

        [data-theme="dark"] .ldk-spin-brand { color: #e2e8f0; }
        [data-theme="dark"] #spinner {
            background:
                radial-gradient(ellipse at 15% 50%, rgba(0,180,170,0.22) 0%, transparent 55%),
                radial-gradient(ellipse at 85% 50%, rgba(255,154,158,0.18) 0%, transparent 55%),
                #0f1117;
        }

        .ldk-spin-dots {
            display: flex;
            gap: 5px;
            align-items: center;
        }

        .ldk-spin-dots span {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            animation: ldkDotBounce 0.7s ease-in-out infinite;
        }

        .ldk-spin-dots span:nth-child(1) { background: #00a79d; animation-delay: 0s; }
        .ldk-spin-dots span:nth-child(2) { background: #f59e0b; animation-delay: 0.12s; }
        .ldk-spin-dots span:nth-child(3) { background: #ec4899; animation-delay: 0.24s; }

        @keyframes ldkDotBounce {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-7px); }
        }
    </style>
</head>
<body>
    <div class="spinner-fun-ldk">
        <div class="ldk-ring ldk-ring-1"></div>
        <div class="ldk-ring ldk-ring-2"></div>
        <div class="ldk-dot-orbit ldk-dot-orbit-1"><span class="ldk-orbit-dot"></span></div>
        <div class="ldk-dot-orbit ldk-dot-orbit-2"><span class="ldk-orbit-dot"></span></div>
        <div class="ldk-dot-orbit ldk-dot-orbit-3"><span class="ldk-orbit-dot"></span></div>
        <img src="https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1"
             alt="LDK Syahid" class="ldk-spin-img"/>
    </div>
    <div class="ldk-spin-label">
        <span class="ldk-spin-brand">LDK Syahid</span>
        <div class="ldk-spin-dots">
            <span></span><span></span><span></span>
        </div>
    </div>

    <script>
        window.location.href = @json($destination);
    </script>
</body>
</html>
