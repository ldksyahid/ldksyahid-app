<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MyDios - Laravel 8</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            line-height: 1.6;
            background: #0a0c10;
            color: #e5e7eb;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Main Watermark - Large Center */
        .main-watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 0;
            text-align: center;
            pointer-events: none;
            width: 100%;
            opacity: 0.12;
        }

        .watermark-text {
            font-size: clamp(5rem, 18vw, 14rem);
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 25px;
            color: transparent;
            -webkit-text-stroke: 4px #e74430;
            text-stroke: 4px #e74430;
            animation: watermarkGlow 5s ease-in-out infinite;
            white-space: nowrap;
            line-height: 1;
            text-shadow: 0 0 30px rgba(231, 68, 48, 0.3);
        }

        @keyframes watermarkGlow {
            0%, 100% {
                -webkit-text-stroke-color: #e74430;
                filter: drop-shadow(0 0 20px rgba(231, 68, 48, 0.5));
            }
            50% {
                -webkit-text-stroke-color: #ff6b4a;
                filter: drop-shadow(0 0 40px rgba(231, 68, 48, 0.9));
            }
        }

        /* Decorative Elements for Watermark */
        .watermark-decoration {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 180%;
            height: 180%;
            background: radial-gradient(circle, rgba(231, 68, 48, 0.15) 0%, transparent 70%);
            z-index: -1;
            animation: pulseGlow 5s ease-in-out infinite;
        }

        @keyframes pulseGlow {
            0%, 100% {
                opacity: 0.3;
                transform: translate(-50%, -50%) scale(1);
            }
            50% {
                opacity: 0.7;
                transform: translate(-50%, -50%) scale(1.3);
            }
        }

        .container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 30px 20px;
            position: relative;
            z-index: 2;
            background: rgba(10, 12, 16, 0.7);
            backdrop-filter: blur(12px);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header with Simple MyDios Logo */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            margin-bottom: 40px;
            border-bottom: 2px solid rgba(231, 68, 48, 0.15);
            position: relative;
        }

        .custom-logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-icon {
            width: 55px;
            height: 55px;
            background: linear-gradient(145deg, #e74430, #c43d2b);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 900;
            color: white;
            box-shadow: 0 10px 30px rgba(231, 68, 48, 0.6);
            transform: rotate(5deg);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo-icon:hover {
            transform: rotate(0deg) scale(1.15);
            box-shadow: 0 15px 40px rgba(231, 68, 48, 0.8);
        }

        .logo-text {
            font-size: 32px;
            font-weight: 800;
            color: white;
            letter-spacing: 2px;
            text-shadow: 0 0 20px rgba(231, 68, 48, 0.5);
            background: linear-gradient(135deg, #fff, #e0e0e0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .created-by {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(5px);
            padding: 10px 25px;
            border-radius: 40px;
            border: 1px solid rgba(231, 68, 48, 0.4);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }

        .created-by i {
            color: #e74430;
            font-size: 20px;
            filter: drop-shadow(0 0 5px rgba(231, 68, 48, 0.5));
        }

        .created-by span {
            color: #d1d5db;
            font-weight: 400;
            font-size: 15px;
        }

        .created-by strong {
            color: #e74430;
            font-weight: 800;
            font-size: 20px;
            letter-spacing: 1px;
            text-shadow: 0 0 10px rgba(231, 68, 48, 0.5);
        }

        /* Hero Section */
        .hero {
            text-align: center;
            margin-bottom: 70px;
            position: relative;
        }

        .hero h1 {
            font-size: 90px;
            font-weight: 900;
            background: linear-gradient(135deg, #e74430 0%, #ff8a6c 40%, #e74430 80%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 15px;
            letter-spacing: -3px;
            animation: gradientShift 8s ease infinite;
            background-size: 200% 200%;
            text-shadow: 0 0 50px rgba(231, 68, 48, 0.3);
            line-height: 1.1;
        }

        .hero p {
            font-size: 24px;
            color: #9ca3af;
            max-width: 700px;
            margin: 0 auto;
            font-weight: 300;
            letter-spacing: 1px;
            background: rgba(0, 0, 0, 0.3);
            display: inline-block;
            padding: 10px 30px;
            border-radius: 50px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(231, 68, 48, 0.2);
        }

        @keyframes gradientShift {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
        }

        /* Features Grid - 4 Cards */
        .features {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 35px;
            margin-bottom: 60px;
        }

        .feature-card {
            background: rgba(17, 24, 39, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(231, 68, 48, 0.15);
            border-radius: 30px;
            padding: 40px 35px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 30px -15px rgba(0, 0, 0, 0.5);
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, transparent, #e74430, #ff8a6c, #e74430, transparent);
            transform: translateX(-100%);
            transition: transform 0.8s ease;
        }

        .feature-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(231, 68, 48, 0.1) 0%, transparent 80%);
            border-radius: 50%;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .feature-card:hover {
            transform: translateY(-12px) scale(1.02);
            border-color: rgba(231, 68, 48, 0.4);
            box-shadow: 0 30px 50px -15px rgba(231, 68, 48, 0.4);
            background: rgba(20, 28, 45, 0.9);
        }

        .feature-card:hover::before {
            transform: translateX(100%);
        }

        .feature-card:hover::after {
            opacity: 1;
        }

        .card-icon {
            font-size: 48px;
            color: #e74430;
            margin-bottom: 25px;
            background: rgba(231, 68, 48, 0.15);
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 25px;
            transition: all 0.4s ease;
            border: 1px solid rgba(231, 68, 48, 0.3);
            box-shadow: 0 10px 20px -5px rgba(231, 68, 48, 0.3);
        }

        .feature-card:hover .card-icon {
            transform: scale(1.1) rotate(5deg);
            background: rgba(231, 68, 48, 0.25);
            border-color: rgba(231, 68, 48, 0.6);
            box-shadow: 0 15px 30px -5px rgba(231, 68, 48, 0.5);
        }

        .feature-card h2 {
            font-size: 32px;
            color: #fff;
            margin-bottom: 20px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .feature-card h2 a {
            color: white;
            text-decoration: none;
            position: relative;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #fff, #e0e0e0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .feature-card h2 a:hover {
            background: linear-gradient(135deg, #e74430, #ff8a6c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .feature-card h2 a::after {
            content: '→';
            margin-left: 10px;
            opacity: 0;
            transform: translateX(-15px);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: inline-block;
            background: linear-gradient(135deg, #e74430, #ff8a6c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .feature-card:hover h2 a::after {
            opacity: 1;
            transform: translateX(5px);
        }

        .feature-card p {
            color: #9ca3af;
            font-size: 17px;
            line-height: 1.8;
            margin-bottom: 25px;
        }

        .feature-card strong {
            color: #e74430;
            font-weight: 700;
            background: rgba(231, 68, 48, 0.15);
            padding: 2px 8px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .feature-card:hover strong {
            background: rgba(231, 68, 48, 0.3);
            color: #ff8a6c;
        }

        .card-footer {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .card-link {
            color: #e74430;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 40px;
            background: rgba(231, 68, 48, 0.1);
            border: 1px solid rgba(231, 68, 48, 0.3);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .card-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0%;
            height: 100%;
            background: linear-gradient(135deg, #e74430, #c43d2b);
            transition: width 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            z-index: -1;
        }

        .card-link:hover::before {
            width: 100%;
        }

        .card-link:hover {
            color: white;
            border-color: #e74430;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(231, 68, 48, 0.6);
        }

        .card-link i {
            transition: transform 0.3s ease;
        }

        .card-link:hover i {
            transform: translateX(8px);
            color: white;
        }

        /* Tool Tags for Ecosystem Card */
        .tool-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 25px 0 10px;
        }

        .tool-tag {
            background: rgba(231, 68, 48, 0.08);
            border: 1px solid rgba(231, 68, 48, 0.2);
            padding: 6px 15px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 500;
            color: #d1d5db;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .tool-tag::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0%;
            height: 100%;
            background: linear-gradient(135deg, #e74430, #c43d2b);
            transition: width 0.3s ease;
            z-index: -1;
        }

        .tool-tag:hover::before {
            width: 100%;
        }

        .tool-tag:hover {
            color: white;
            border-color: #e74430;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px -5px rgba(231, 68, 48, 0.5);
        }

        .feature-card:hover .tool-tag {
            background: rgba(231, 68, 48, 0.15);
            border-color: rgba(231, 68, 48, 0.4);
            color: white;
        }

        /* Footer - Minimal */
        .footer {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px 0;
            margin-top: auto;
            border-top: 2px solid rgba(231, 68, 48, 0.15);
        }

        .version-badge {
            display: flex;
            align-items: center;
            gap: 20px;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(5px);
            padding: 12px 35px;
            border-radius: 50px;
            border: 1px solid rgba(231, 68, 48, 0.3);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }

        .version-badge i {
            color: #e74430;
            font-size: 20px;
            filter: drop-shadow(0 0 5px rgba(231, 68, 48, 0.5));
        }

        .version-badge span {
            color: #9ca3af;
            font-size: 18px;
            font-weight: 500;
        }

        .version-badge strong {
            color: #e74430;
            font-weight: 800;
            font-size: 20px;
        }

        .version-divider {
            width: 2px;
            height: 25px;
            background: rgba(231, 68, 48, 0.3);
            margin: 0 5px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .features {
                gap: 25px;
            }

            .feature-card {
                padding: 30px 25px;
            }

            .feature-card h2 {
                font-size: 28px;
            }
        }

        @media (max-width: 768px) {
            .main-watermark {
                opacity: 0.08;
            }

            .watermark-text {
                -webkit-text-stroke: 3px #e74430;
                letter-spacing: 8px;
                font-size: clamp(3rem, 12vw, 8rem);
            }

            .header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }

            .custom-logo {
                justify-content: center;
            }

            .hero h1 {
                font-size: 55px;
            }

            .hero p {
                font-size: 18px;
                padding: 8px 20px;
            }

            .features {
                grid-template-columns: 1fr;
                gap: 25px;
            }

            .card-icon {
                width: 70px;
                height: 70px;
                font-size: 40px;
            }

            .version-badge {
                flex-direction: column;
                gap: 10px;
                padding: 15px 25px;
                text-align: center;
            }

            .version-divider {
                width: 50px;
                height: 2px;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 14px;
        }

        ::-webkit-scrollbar-track {
            background: #0a0c10;
            border-left: 1px solid rgba(231, 68, 48, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #e74430, #c43d2b);
            border-radius: 8px;
            border: 3px solid #0a0c10;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #ff6b4a, #e74430);
        }
    </style>
</head>
<body>
    <!-- Main Watermark - Large Center -->
    <div class="main-watermark">
        <div class="watermark-decoration"></div>
        <div class="watermark-text">MYDIOS</div>
    </div>

    <div class="container">
        <!-- Header with Simple MyDios Logo -->
        <header class="header">
            <div class="custom-logo">
                <div class="logo-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <div class="logo-text">
                    MyDios
                </div>
            </div>

            <div class="created-by">
                <i class="fas fa-crown"></i>
                <span>This Site createdBy</span>
                <strong>MyDios</strong>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="hero">
            <h1>Laravel</h1>
            <p>The PHP Framework for Web Artisans</p>
        </section>

        <!-- Features Grid - 4 Cards with Active Links -->
        <div class="features">
            <!-- Documentation Card -->
            <div class="feature-card">
                <div class="card-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h2><a href="https://laravel.com/docs" target="_blank" rel="noopener noreferrer">Documentation</a></h2>
                <p>Laravel has wonderful, thorough documentation covering every aspect of the framework. Whether you are new to the framework or have previous experience with Laravel, we recommend reading all of the documentation from beginning to end.</p>
                <div class="card-footer">
                    <a href="https://laravel.com/docs" target="_blank" rel="noopener noreferrer" class="card-link">
                        Explore Docs <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Laracasts Card -->
            <div class="feature-card">
                <div class="card-icon">
                    <i class="fas fa-play-circle"></i>
                </div>
                <h2><a href="https://laracasts.com" target="_blank" rel="noopener noreferrer">Laracasts</a></h2>
                <p>Laracasts offers thousands of video tutorials on Laravel, PHP, and JavaScript development. Check them out, see for yourself, and massively level up your development skills in the process.</p>
                <div class="card-footer">
                    <a href="https://laracasts.com" target="_blank" rel="noopener noreferrer" class="card-link">
                        Watch Videos <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Laravel News Card -->
            <div class="feature-card">
                <div class="card-icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <h2><a href="https://laravel-news.com" target="_blank" rel="noopener noreferrer">Laravel News</a></h2>
                <p>Laravel News is a community-driven portal and newsletter aggregating all of the latest and most important news in the Laravel ecosystem, including new package releases and tutorials.</p>
                <div class="card-footer">
                    <a href="https://laravel-news.com" target="_blank" rel="noopener noreferrer" class="card-link">
                        Read News <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Vibrant Ecosystem Card -->
            <div class="feature-card">
                <div class="card-icon">
                    <i class="fas fa-cubes"></i>
                </div>
                <h2>Vibrant Ecosystem</h2>
                <p>Laravel's robust library of first-party tools and libraries, such as <strong>Eager</strong>, <strong>Vapor</strong>, <strong>Nova</strong>, and <strong>Envoy</strong>, help you take your projects to the next level. Pair them with powerful open source libraries like Cashier, Dusk, Echo, Horizon, Sanctum, Telescope, and more.</p>
                <div class="tool-tags">
                    <a href="https://github.com/laravel/vapor" target="_blank" rel="noopener noreferrer" class="tool-tag">Vapor</a>
                    <a href="https://nova.laravel.com" target="_blank" rel="noopener noreferrer" class="tool-tag">Nova</a>
                    <a href="https://github.com/laravel/envoy" target="_blank" rel="noopener noreferrer" class="tool-tag">Envoy</a>
                    <a href="https://github.com/laravel/cashier" target="_blank" rel="noopener noreferrer" class="tool-tag">Cashier</a>
                    <a href="https://github.com/laravel/dusk" target="_blank" rel="noopener noreferrer" class="tool-tag">Dusk</a>
                    <a href="https://github.com/laravel/echo" target="_blank" rel="noopener noreferrer" class="tool-tag">Echo</a>
                    <a href="https://github.com/laravel/horizon" target="_blank" rel="noopener noreferrer" class="tool-tag">Horizon</a>
                    <a href="https://github.com/laravel/sanctum" target="_blank" rel="noopener noreferrer" class="tool-tag">Sanctum</a>
                    <a href="https://github.com/laravel/telescope" target="_blank" rel="noopener noreferrer" class="tool-tag">Telescope</a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="version-badge">
                <i class="fas fa-bolt"></i>
                <span>Laravel <strong>v{{ Illuminate\Foundation\Application::VERSION }}</strong></span>
                <div class="version-divider"></div>
                <span>PHP <strong>v{{ PHP_VERSION }}</strong></span>
                <i class="fas fa-gem"></i>
            </div>
        </footer>
    </div>
</body>
</html>
