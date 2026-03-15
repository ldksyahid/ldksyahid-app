<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyDios &mdash; Laravel {{ Illuminate\Foundation\Application::VERSION }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --red:    #e74430;
            --red2:   #ff6b4a;
            --dark:   #080a0f;
            --dark2:  #0d1017;
            --panel:  rgba(13,17,28,.75);
            --border: rgba(231,68,48,.18);
            --text:   #e2e8f0;
            --muted:  #64748b;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Figtree', sans-serif;
            background: var(--dark);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── GRID BACKGROUND ── */
        .bg-grid {
            position: fixed;
            inset: 0;
            z-index: 0;
            background-image:
                linear-gradient(rgba(231,68,48,.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(231,68,48,.04) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridPan 30s linear infinite;
        }
        @keyframes gridPan {
            from { background-position: 0 0; }
            to   { background-position: 50px 50px; }
        }

        /* ── GLOW ORBS ── */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(90px);
            pointer-events: none;
            z-index: 0;
            animation: orbDrift 18s ease-in-out infinite alternate;
        }
        .orb-1 { width: 500px; height: 500px; background: radial-gradient(circle, rgba(231,68,48,.25), transparent 70%); top: -150px; left: -100px; animation-duration: 18s; }
        .orb-2 { width: 400px; height: 400px; background: radial-gradient(circle, rgba(180,40,20,.18), transparent 70%); bottom: -100px; right: -80px; animation-duration: 22s; animation-delay: -8s; }
        .orb-3 { width: 300px; height: 300px; background: radial-gradient(circle, rgba(231,68,48,.12), transparent 70%); top: 40%; left: 45%; animation-duration: 15s; animation-delay: -4s; }
        @keyframes orbDrift {
            from { transform: translate(0, 0) scale(1); }
            to   { transform: translate(40px, 30px) scale(1.15); }
        }

        /* ── NOISE OVERLAY ── */
        .noise {
            position: fixed;
            inset: 0;
            z-index: 1;
            opacity: .025;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
            background-size: 200px 200px;
            pointer-events: none;
        }

        /* ── LAYOUT ── */
        .wrap {
            position: relative;
            z-index: 2;
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 28px 60px;
        }

        /* ── TOP NAV ── */
        nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 28px 0 36px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 0;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
        }

        .brand-mark {
            width: 46px; height: 46px;
            background: linear-gradient(145deg, var(--red), #b83322);
            border-radius: 14px;
            display: grid;
            place-items: center;
            font-size: 22px;
            color: #fff;
            box-shadow: 0 8px 24px rgba(231,68,48,.5), inset 0 1px 0 rgba(255,255,255,.12);
            transform: rotate(4deg);
            transition: transform .35s cubic-bezier(.175,.885,.32,1.275), box-shadow .35s;
        }
        .nav-brand:hover .brand-mark { transform: rotate(0deg) scale(1.1); box-shadow: 0 14px 36px rgba(231,68,48,.7); }

        .brand-name {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 1.5px;
            background: linear-gradient(135deg, #fff 30%, #aaa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-pills {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pill {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 13.5px;
            font-weight: 600;
            border: 1px solid var(--border);
            background: rgba(231,68,48,.07);
            color: #cbd5e0;
            text-decoration: none;
            transition: all .25s;
            white-space: nowrap;
        }
        .pill i { color: var(--red); font-size: 14px; }
        .pill:hover { background: rgba(231,68,48,.18); border-color: rgba(231,68,48,.5); color: #fff; transform: translateY(-2px); }

        .pill-wa { border-color: rgba(231,68,48,.35); background: rgba(231,68,48,.1); }
        .pill-wa:hover { background: var(--red); border-color: var(--red); }
        .pill-wa:hover i { color: #fff; }

        /* ── HERO ── */
        .hero {
            padding: 90px 0 80px;
            text-align: center;
            position: relative;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 18px;
            border-radius: 50px;
            background: rgba(231,68,48,.1);
            border: 1px solid rgba(231,68,48,.3);
            font-size: 12.5px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--red2);
            margin-bottom: 32px;
            animation: fadeSlideUp .6s ease both;
        }
        .hero-eyebrow span { width: 6px; height: 6px; border-radius: 50%; background: var(--red); display: inline-block; animation: pulse 1.5s ease infinite; }
        @keyframes pulse { 0%,100% { opacity:1; transform:scale(1); } 50% { opacity:.4; transform:scale(.6); } }

        .hero-title {
            font-size: clamp(4rem, 10vw, 8.5rem);
            font-weight: 900;
            letter-spacing: -4px;
            line-height: .95;
            margin-bottom: 28px;
            animation: fadeSlideUp .6s .1s ease both;
        }
        .hero-title .t-white { color: #fff; }
        .hero-title .t-red {
            background: linear-gradient(135deg, var(--red) 0%, var(--red2) 50%, var(--red) 100%);
            background-size: 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimTitle 5s ease infinite;
        }
        @keyframes shimTitle { 0%,100% { background-position:0% 50%; } 50% { background-position:100% 50%; } }

        .hero-sub {
            font-size: clamp(1rem, 2vw, 1.25rem);
            color: var(--muted);
            max-width: 560px;
            margin: 0 auto 48px;
            line-height: 1.7;
            font-weight: 400;
            animation: fadeSlideUp .6s .2s ease both;
        }
        .hero-sub strong { color: var(--red2); font-weight: 700; }

        .hero-actions {
            display: flex;
            justify-content: center;
            gap: 14px;
            flex-wrap: wrap;
            animation: fadeSlideUp .6s .3s ease both;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 14px 30px;
            border-radius: 50px;
            background: linear-gradient(135deg, var(--red), #b83322);
            color: #fff;
            font-weight: 700;
            font-size: 15px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            box-shadow: 0 12px 32px rgba(231,68,48,.45);
            transition: all .3s cubic-bezier(.175,.885,.32,1.275);
            position: relative;
            overflow: hidden;
        }
        .btn-primary::after { content:''; position:absolute; inset:0; background:linear-gradient(135deg,rgba(255,255,255,.15),transparent); opacity:0; transition:opacity .3s; }
        .btn-primary:hover { transform:translateY(-4px); box-shadow:0 18px 44px rgba(231,68,48,.6); }
        .btn-primary:hover::after { opacity:1; }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 14px 30px;
            border-radius: 50px;
            background: transparent;
            color: #cbd5e0;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            border: 1px solid rgba(255,255,255,.12);
            transition: all .3s;
        }
        .btn-ghost:hover { border-color: rgba(231,68,48,.5); background: rgba(231,68,48,.08); color:#fff; transform:translateY(-3px); }

        @keyframes fadeSlideUp { from { opacity:0; transform:translateY(24px); } to { opacity:1; transform:translateY(0); } }

        /* ── STATS BAR ── */
        .stats-bar {
            display: flex;
            justify-content: center;
            gap: 0;
            border: 1px solid var(--border);
            border-radius: 20px;
            background: var(--panel);
            backdrop-filter: blur(14px);
            overflow: hidden;
            margin-bottom: 80px;
            animation: fadeSlideUp .6s .4s ease both;
        }
        .stat-item {
            flex: 1;
            padding: 22px 10px;
            text-align: center;
            border-right: 1px solid var(--border);
            position: relative;
            transition: background .25s;
        }
        .stat-item:last-child { border-right: none; }
        .stat-item:hover { background: rgba(231,68,48,.06); }
        .stat-val {
            font-size: 1.6rem;
            font-weight: 900;
            background: linear-gradient(135deg, #fff, #ccc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: block;
            line-height: 1.1;
        }
        .stat-val em { font-style:normal; color: var(--red); -webkit-text-fill-color: var(--red); }
        .stat-label { font-size: 11.5px; color: var(--muted); font-weight: 600; letter-spacing: 1px; text-transform: uppercase; margin-top: 4px; display:block; }
        .stat-icon { font-size: 18px; color: var(--red); margin-bottom: 8px; filter: drop-shadow(0 0 6px rgba(231,68,48,.5)); }

        /* ── CARDS ── */
        .section-label {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 24px;
        }
        .section-label::before, .section-label::after { content:''; flex:1; height:1px; background: var(--border); }

        .cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 80px;
        }

        .card {
            background: var(--panel);
            backdrop-filter: blur(14px);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 36px 32px;
            position: relative;
            overflow: hidden;
            transition: transform .4s cubic-bezier(.175,.885,.32,1.275), border-color .3s, box-shadow .4s;
            group: '';
        }

        .card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 80% 20%, rgba(231,68,48,.1), transparent 60%);
            opacity: 0;
            transition: opacity .4s;
        }
        .card:hover { transform: translateY(-8px); border-color: rgba(231,68,48,.4); box-shadow: 0 24px 48px -12px rgba(231,68,48,.3), 0 0 0 1px rgba(231,68,48,.1); }
        .card:hover::before { opacity: 1; }

        /* top accent line */
        .card-accent {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--red), var(--red2), var(--red), transparent);
            transform: scaleX(0);
            transition: transform .5s cubic-bezier(.175,.885,.32,1.275);
        }
        .card:hover .card-accent { transform: scaleX(1); }

        .card-icon-wrap {
            width: 56px; height: 56px;
            border-radius: 16px;
            background: rgba(231,68,48,.12);
            border: 1px solid rgba(231,68,48,.25);
            display: grid;
            place-items: center;
            font-size: 24px;
            color: var(--red);
            margin-bottom: 22px;
            transition: all .35s cubic-bezier(.175,.885,.32,1.275);
            box-shadow: 0 8px 20px -4px rgba(231,68,48,.25);
        }
        .card:hover .card-icon-wrap { transform: scale(1.1) rotate(6deg); background: rgba(231,68,48,.22); border-color: rgba(231,68,48,.5); }

        .card h2 {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 12px;
            color: #fff;
        }
        .card h2 a { color: inherit; text-decoration: none; }
        .card h2 a:hover { color: var(--red2); }

        .card p {
            font-size: 15px;
            color: #64748b;
            line-height: 1.75;
            margin-bottom: 24px;
        }

        .card-cta {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 13.5px;
            font-weight: 700;
            color: var(--red);
            text-decoration: none;
            padding: 8px 18px;
            border-radius: 50px;
            border: 1px solid rgba(231,68,48,.3);
            background: rgba(231,68,48,.07);
            transition: all .28s cubic-bezier(.175,.885,.32,1.275);
            position: relative; overflow: hidden;
        }
        .card-cta::before { content:''; position:absolute; inset:0; background:linear-gradient(135deg,var(--red),#b83322); opacity:0; transition:opacity .28s; z-index:0; }
        .card-cta > * { position: relative; z-index: 1; }
        .card-cta:hover { color:#fff; border-color:var(--red); transform:translateY(-2px); box-shadow:0 8px 24px rgba(231,68,48,.4); }
        .card-cta:hover::before { opacity:1; }
        .card-cta i { transition: transform .28s; }
        .card-cta:hover i { transform: translateX(4px); }

        /* Tags */
        .tags { display: flex; flex-wrap: wrap; gap: 8px; margin: 16px 0; }
        .tag {
            padding: 5px 13px;
            border-radius: 50px;
            font-size: 12.5px;
            font-weight: 600;
            color: #94a3b8;
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.07);
            text-decoration: none;
            transition: all .25s;
        }
        .tag:hover { background: rgba(231,68,48,.15); border-color: rgba(231,68,48,.4); color: var(--red2); transform:translateY(-2px); }

        /* ── TERMINAL BLOCK ── */
        .terminal {
            background: #080a0f;
            border: 1px solid rgba(231,68,48,.2);
            border-radius: 18px;
            overflow: hidden;
            margin-bottom: 80px;
        }
        .terminal-bar {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 18px;
            background: rgba(231,68,48,.06);
            border-bottom: 1px solid rgba(231,68,48,.12);
        }
        .dot { width: 12px; height: 12px; border-radius: 50%; }
        .dot-r { background: #e74430; }
        .dot-y { background: #f59e0b; }
        .dot-g { background: #10b981; }
        .terminal-title { font-size: 12px; color: var(--muted); margin-left: auto; font-family: monospace; }
        .terminal-body { padding: 24px 24px 20px; font-family: 'Courier New', monospace; font-size: 14px; line-height: 1.9; }
        .t-prompt { color: var(--red); }
        .t-cmd    { color: #e2e8f0; }
        .t-out    { color: #64748b; }
        .t-val    { color: #34d399; }
        .t-str    { color: #fbbf24; }
        .t-comment { color: #374151; }
        .t-cursor { display: inline-block; width: 8px; height: 14px; background: var(--red); vertical-align: text-bottom; animation: blink .9s step-end infinite; }
        @keyframes blink { 0%,100% { opacity:1; } 50% { opacity:0; } }

        /* ── FOOTER ── */
        footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 28px 0 0;
            border-top: 1px solid var(--border);
            gap: 20px;
            flex-wrap: wrap;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 15px;
            font-weight: 700;
            color: #fff;
        }
        .footer-brand i { color: var(--red); font-size: 16px; }

        .footer-meta {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .meta-pill {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 7px 15px;
            border-radius: 50px;
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.07);
            font-size: 13px;
            color: #94a3b8;
            text-decoration: none;
            transition: all .25s;
        }
        .meta-pill i { color: var(--red); font-size: 13px; }
        .meta-pill strong { color: #cbd5e0; font-weight: 700; }
        .meta-pill:hover { background: rgba(231,68,48,.1); border-color: rgba(231,68,48,.35); color: #fff; }
        .meta-sep { width: 1px; height: 18px; background: var(--border); }

        .footer-copy {
            font-size: 12.5px;
            color: var(--muted);
        }
        .footer-copy a { color: var(--red); text-decoration: none; font-weight: 600; }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--dark); }
        ::-webkit-scrollbar-thumb { background: rgba(231,68,48,.5); border-radius: 6px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--red); }

        /* ── RESPONSIVE ── */
        @media (max-width: 860px) {
            .cards { grid-template-columns: 1fr; }
            .stats-bar { flex-wrap: wrap; }
            .stat-item { flex: 1 1 40%; border-right: none; border-bottom: 1px solid var(--border); }
            .stat-item:last-child, .stat-item:nth-last-child(-n+2):not(:nth-child(odd)) { border-bottom: none; }
            footer { flex-direction: column; text-align: center; }
            .footer-meta { justify-content: center; }
        }

        @media (max-width: 560px) {
            nav { flex-direction: column; gap: 16px; }
            .hero-title { letter-spacing: -2px; }
            .hero-actions { flex-direction: column; align-items: center; }
            .stats-bar { flex-direction: column; }
            .stat-item { border-right: none; border-bottom: 1px solid var(--border); }
            .stat-item:last-child { border-bottom: none; }
        }
    </style>
</head>
<body>
    <div class="bg-grid"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <div class="noise"></div>

    <div class="wrap">

        {{-- ── NAV ── --}}
        <nav>
            <a href="/" class="nav-brand">
                <div class="brand-mark"><i class="fas fa-bolt"></i></div>
                <span class="brand-name">MyDios</span>
            </a>
            <div class="nav-pills">
                <span class="pill"><i class="fas fa-code-branch"></i> Laravel v{{ Illuminate\Foundation\Application::VERSION }}</span>
                <span class="pill"><i class="fas fa-server"></i> PHP v{{ PHP_VERSION }}</span>
                <a href="https://wa.me/62895394755672" target="_blank" rel="noopener noreferrer" class="pill pill-wa">
                    <i class="fab fa-whatsapp" style="color:var(--red)"></i> Contact
                </a>
            </div>
        </nav>

        {{-- ── HERO ── --}}
        <section class="hero">
            <div class="hero-eyebrow">
                <span></span>
                Live &amp; Running
            </div>
            <h1 class="hero-title">
                <span class="t-white">Built with</span><br>
                <span class="t-red">Laravel</span>
            </h1>
            <p class="hero-sub">
                This application is powered by <strong>Laravel v{{ Illuminate\Foundation\Application::VERSION }}</strong>
                and crafted with care by <strong>MyDios</strong> &mdash; building fast, elegant web experiences.
            </p>
            <div class="hero-actions">
                <a href="https://laravel.com/docs" target="_blank" rel="noopener noreferrer" class="btn-primary">
                    <i class="fas fa-book-open"></i> Read the Docs
                </a>
                <a href="https://wa.me/62895394755672" target="_blank" rel="noopener noreferrer" class="btn-ghost">
                    <i class="fab fa-whatsapp"></i> WhatsApp MyDios
                </a>
            </div>
        </section>

        {{-- ── STATS ── --}}
        <div class="stats-bar">
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-layer-group"></i></div>
                <span class="stat-val">v<em>{{ Illuminate\Foundation\Application::VERSION }}</em></span>
                <span class="stat-label">Laravel</span>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-server"></i></div>
                <span class="stat-val"><em>{{ PHP_MAJOR_VERSION }}.{{ PHP_MINOR_VERSION }}</em></span>
                <span class="stat-label">PHP Version</span>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-shield-alt"></i></div>
                <span class="stat-val"><em>MVC</em></span>
                <span class="stat-label">Architecture</span>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-fire"></i></div>
                <span class="stat-val"><em>100%</em></span>
                <span class="stat-label">Custom Built</span>
            </div>
            <div class="stat-item">
                <div class="stat-icon"><i class="fas fa-crown"></i></div>
                <span class="stat-val"><em>MyDios</em></span>
                <span class="stat-label">Creator</span>
            </div>
        </div>

        {{-- ── CARDS ── --}}
        <div class="section-label">Resources &amp; Ecosystem</div>
        <div class="cards">
            <div class="card">
                <div class="card-accent"></div>
                <div class="card-icon-wrap"><i class="fas fa-book-open"></i></div>
                <h2><a href="https://laravel.com/docs" target="_blank" rel="noopener noreferrer">Documentation</a></h2>
                <p>Laravel has wonderful, thorough documentation covering every aspect of the framework. Whether you're new or experienced, it's the best starting point.</p>
                <a href="https://laravel.com/docs" target="_blank" rel="noopener noreferrer" class="card-cta">
                    Explore Docs <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="card">
                <div class="card-accent"></div>
                <div class="card-icon-wrap"><i class="fas fa-play-circle"></i></div>
                <h2><a href="https://laracasts.com" target="_blank" rel="noopener noreferrer">Laracasts</a></h2>
                <p>Thousands of video tutorials on Laravel, PHP, and JavaScript development. Level up your skills with the most popular screencasts in the Laravel community.</p>
                <a href="https://laracasts.com" target="_blank" rel="noopener noreferrer" class="card-cta">
                    Watch Videos <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="card">
                <div class="card-accent"></div>
                <div class="card-icon-wrap"><i class="fas fa-newspaper"></i></div>
                <h2><a href="https://laravel-news.com" target="_blank" rel="noopener noreferrer">Laravel News</a></h2>
                <p>A community-driven portal aggregating all the latest and most important news in the Laravel ecosystem, including new package releases and tutorials.</p>
                <a href="https://laravel-news.com" target="_blank" rel="noopener noreferrer" class="card-cta">
                    Read News <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="card">
                <div class="card-accent"></div>
                <div class="card-icon-wrap"><i class="fas fa-cubes"></i></div>
                <h2>Vibrant Ecosystem</h2>
                <p>First-party tools like Vapor, Nova, Envoy, and Forge alongside powerful open-source packages make Laravel the most complete PHP framework available.</p>
                <div class="tags">
                    <a href="https://github.com/laravel/vapor"    target="_blank" rel="noopener noreferrer" class="tag">Vapor</a>
                    <a href="https://nova.laravel.com"             target="_blank" rel="noopener noreferrer" class="tag">Nova</a>
                    <a href="https://github.com/laravel/envoy"    target="_blank" rel="noopener noreferrer" class="tag">Envoy</a>
                    <a href="https://github.com/laravel/cashier"  target="_blank" rel="noopener noreferrer" class="tag">Cashier</a>
                    <a href="https://github.com/laravel/dusk"     target="_blank" rel="noopener noreferrer" class="tag">Dusk</a>
                    <a href="https://github.com/laravel/horizon"  target="_blank" rel="noopener noreferrer" class="tag">Horizon</a>
                    <a href="https://github.com/laravel/sanctum"  target="_blank" rel="noopener noreferrer" class="tag">Sanctum</a>
                    <a href="https://github.com/laravel/telescope" target="_blank" rel="noopener noreferrer" class="tag">Telescope</a>
                </div>
            </div>
        </div>

        {{-- ── TERMINAL ── --}}
        <div class="section-label">Environment</div>
        <div class="terminal">
            <div class="terminal-bar">
                <div class="dot dot-r"></div>
                <div class="dot dot-y"></div>
                <div class="dot dot-g"></div>
                <span class="terminal-title">bash &mdash; php artisan about</span>
            </div>
            <div class="terminal-body">
                <div><span class="t-prompt">$</span> <span class="t-cmd">php artisan about</span></div>
                <div class="t-out">&nbsp;</div>
                <div><span class="t-out">&nbsp; Application Name &nbsp;&nbsp;&nbsp;&nbsp;</span><span class="t-val">LDK Syahid</span></div>
                <div><span class="t-out">&nbsp; Laravel Version &nbsp;&nbsp;&nbsp;&nbsp;</span><span class="t-str">{{ Illuminate\Foundation\Application::VERSION }}</span></div>
                <div><span class="t-out">&nbsp; PHP Version &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class="t-str">{{ PHP_VERSION }}</span></div>
                <div><span class="t-out">&nbsp; Environment &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class="t-val">production</span></div>
                <div><span class="t-out">&nbsp; Debug Mode &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class="t-val">OFF</span></div>
                <div><span class="t-out">&nbsp; Built By &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color:var(--red);font-weight:700">MyDios</span></div>
                <div class="t-out">&nbsp;</div>
                <div><span class="t-prompt">$</span> <span class="t-cursor"></span></div>
            </div>
        </div>

        {{-- ── FOOTER ── --}}
        <footer>
            <div class="footer-brand">
                <i class="fas fa-bolt"></i>
                MyDios
            </div>

            <div class="footer-meta">
                <div class="meta-pill">
                    <i class="fas fa-layer-group"></i>
                    Laravel <strong>v{{ Illuminate\Foundation\Application::VERSION }}</strong>
                </div>
                <div class="meta-sep"></div>
                <div class="meta-pill">
                    <i class="fas fa-server"></i>
                    PHP <strong>v{{ PHP_VERSION }}</strong>
                </div>
                <div class="meta-sep"></div>
                <a href="https://wa.me/62895394755672" target="_blank" rel="noopener noreferrer" class="meta-pill">
                    <i class="fab fa-whatsapp" style="color:var(--red)"></i>
                    <strong>+62 895-3947-55672</strong>
                </a>
            </div>

            <div class="footer-copy">
                &copy; {{ date('Y') }} <a href="https://wa.me/62895394755672" target="_blank" rel="noopener noreferrer">MyDios</a>. All rights reserved.
            </div>
        </footer>

    </div>
</body>
</html>
