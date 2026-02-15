{{-- Footer - Fun, Playful but Modern Design --}}
<footer class="footer-fun">
    {{-- Decorative Top Wave --}}
    <div class="footer-wave">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,60 C240,120 480,0 720,60 C960,120 1200,0 1440,60 L1440,120 L0,120 Z" fill="#1a2332"></path>
        </svg>
    </div>

    <div class="footer-main">
        <div class="container py-5">
            <div class="row g-4 g-lg-5">
                {{-- Brand & Description --}}
                <div class="col-lg-3 col-md-6">
                    <div class="footer-brand-section">
                        <div class="footer-brand mb-3">
                            <div class="footer-logo-wrapper me-1">
                                <img src="https://lh3.googleusercontent.com/d/1LsDxFAt1WU66CNp-2CN3J2qWXXJHlWIY"
                                     alt="Logo UIN Jakarta"
                                     class="footer-logo footer-logo-secondary">
                            </div>
                            <div class="footer-logo-wrapper">
                                <img src="https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1"
                                     alt="Logo LDK Syahid"
                                     class="footer-logo">
                                <span class="footer-logo-sparkle">✨</span>
                            </div>
                            <div class="footer-brand-text">
                                <span class="brand-name">LDK Syahid</span>
                                <span class="brand-tagline">#KitaAdalahSaudara</span>
                            </div>
                        </div>
                        <p class="footer-description">
                            Lembaga Dakwah Kampus UIN Syarif Hidayatullah Jakarta. Tempat bertumbuh bersama dalam kebaikan! 🌱
                        </p>
                        <div class="footer-social">
                            <a class="social-btn social-facebook" href="https://www.facebook.com/ldksyahid/" target="_blank" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="social-btn social-twitter" href="https://twitter.com/ldksyahid/" target="_blank" aria-label="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="social-btn social-youtube" href="https://www.youtube.com/channel/UCJ-SyxQN5sG4CzO0waSYpBQ" target="_blank" aria-label="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                            <a class="social-btn social-instagram" href="https://www.instagram.com/ldksyahid/" target="_blank" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Contact Info --}}
                <div class="col-lg-2 col-md-6">
                    <div class="footer-section">
                        <h5 class="footer-title">
                            <span class="title-icon">📍</span>
                            Alamat
                        </h5>
                        <ul class="footer-contact-list">
                            <li>
                                <i class="fas fa-building"></i>
                                <span>Lt. 3 Gedung SC UIN Jakarta</span>
                            </li>
                            <li>
                                <i class="fas fa-phone-alt"></i>
                                <span>+62 851-5936-0504</span>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <span>ldk.ormawa@apps.uinjkt.ac.id</span>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div class="col-lg-4 col-md-6">
                    <div class="footer-section">
                        <h5 class="footer-title">
                            <span class="title-icon">🚀</span>
                            Jelajahi
                        </h5>
                        <div class="footer-links-grid">
                            <a href="/about/contact" class="footer-link-card">
                                <i class="fas fa-comments"></i>
                                <span>Hubungi</span>
                            </a>
                            <a href="/articles" class="footer-link-card">
                                <i class="fas fa-newspaper"></i>
                                <span>Artikel</span>
                            </a>
                            <a href="/news" class="footer-link-card">
                                <i class="fas fa-bullhorn"></i>
                                <span>Berita</span>
                            </a>
                            <a href="/events" class="footer-link-card">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Kegiatan</span>
                            </a>
                            <a href="/schedule" class="footer-link-card">
                                <i class="fas fa-clock"></i>
                                <span>Jadwal</span>
                            </a>
                            <a href="/kalkulatorkestari" class="footer-link-card">
                                <i class="fas fa-calculator"></i>
                                <span>Kalkulator Kestari</span>
                            </a>
                            <a href="/perpustakaan" class="footer-link-card">
                                <i class="fas fa-book"></i>
                                <span>Perpustakaan</span>
                            </a>
                            <a href="/laporan" class="footer-link-card">
                                <i class="fas fa-file-alt"></i>
                                <span>Laporan</span>
                            </a>
                            <a href="/shortlink" class="footer-link-card">
                                <i class="fas fa-link"></i>
                                <span>Shortlink Request</span>
                            </a>
                            <a href="/callkestari" class="footer-link-card">
                                <i class="fas fa-phone"></i>
                                <span>Call Kestari</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Newsletter --}}
                <div class="col-lg-3 col-md-6">
                    <div class="footer-section">
                        <h5 class="footer-title">
                            <span class="title-icon">💌</span>
                            Newsletter
                        </h5>
                        <p class="footer-newsletter-text">
                            Yuk berlangganan! Dapatkan info seru dan inspirasi langsung ke email kamu.
                        </p>
                        <form action="{{ route('subscribers.store') }}" method="post" class="footer-subscribe-form">
                            @csrf
                            <div class="subscribe-input-wrapper">
                                <input class="subscribe-input"
                                       type="email"
                                       name="email"
                                       placeholder="Email kamu..."
                                       required />
                                <button type="submit" class="subscribe-btn">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                        <div class="footer-fun-text">
                            <span>Mari berteman! 🤝</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Copyright --}}
        <div class="footer-copyright">
            <div class="container">
                <div class="copyright-content">
                    <div class="copyright-left">
                        <span>&copy; {{ date('Y') }}</span>
                        <a href="/" class="copyright-link">UKM LDK Syahid</a>
                        <span class="copyright-heart">🤝</span>
                        <span>Kita Adalah Saudara</span>

                    </div>
                    <div class="copyright-right">
                        <span>Developed by</span>
                        <a href="/itsupport" class="copyright-link">IT Support</a>
                        <span class="dev-emoji">👨‍💻</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer-fun {
        position: relative;
        background: transparent;
        border-radius: 40px 40px 0 0;
        overflow: hidden;
        margin-bottom: 0;
    }

    .footer-wave {
        position: relative;
        height: 80px;
        overflow: hidden;
    }

    .footer-wave svg {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 100%;
    }

    .footer-main {
        background: #1a2332;
        position: relative;
        overflow: hidden;
    }

    /* Decorative background pattern */
    .footer-main::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image:
            radial-gradient(circle at 20% 30%, rgba(0, 167, 157, 0.08) 0%, transparent 50%),
            radial-gradient(circle at 80% 70%, rgba(255, 107, 107, 0.05) 0%, transparent 50%);
        pointer-events: none;
    }

    /* Brand Section */
    .footer-brand-section {
        position: relative;
        text-align: left;
    }

    .footer-brand {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .footer-logo-wrapper {
        position: relative;
        flex-shrink: 0;
    }

    .footer-logo {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        border: 3px solid var(--primary);
        padding: 2px;
        background: white;
        transition: transform 0.3s ease;
        object-fit: contain;
    }

    .footer-logo-secondary {
        background: transparent;
        border-color: rgba(255, 255, 255, 0.2);
        padding: 5px;
    }

    .footer-logo:hover {
        transform: rotate(-5deg) scale(1.05);
    }

    .footer-logo-sparkle {
        position: absolute;
        top: -8px;
        right: -8px;
        font-size: 1.2rem;
        animation: sparkleFloat 2s ease-in-out infinite;
    }

    @keyframes sparkleFloat {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-5px) rotate(15deg); }
    }

    .footer-brand-text {
        display: flex;
        flex-direction: column;
    }

    .brand-name {
        font-family: var(--font-primary);
        font-size: 1.4rem;
        font-weight: 700;
        color: white;
    }

    .brand-tagline {
        font-size: 0.8rem;
        color: var(--primary);
        font-weight: 500;
    }

    .footer-description {
        color: #a0a8b3;
        font-size: 0.9rem;
        line-height: 1.7;
        margin-bottom: 1.5rem;
        text-align: left;
    }

    /* Social Buttons */
    .footer-social {
        display: flex;
        gap: 0.75rem;
    }

    .social-btn {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .social-facebook {
        background: linear-gradient(135deg, #1877f2 0%, #0d65d9 100%);
        color: white;
    }

    .social-twitter {
        background: linear-gradient(135deg, #1da1f2 0%, #0c85d0 100%);
        color: white;
    }

    .social-youtube {
        background: linear-gradient(135deg, #ff0000 0%, #cc0000 100%);
        color: white;
    }

    .social-instagram {
        background: linear-gradient(135deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        color: white;
    }

    .social-btn:hover {
        transform: translateY(-4px) scale(1.05);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        color: white;
        filter: brightness(1.2);
    }

    .social-btn::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.25);
        border-radius: 12px;
        transform: translate(-50%, -50%);
        transition: width 0.35s ease, height 0.35s ease;
    }

    .social-btn:hover::after {
        width: 100%;
        height: 100%;
    }

    /* Footer Section */
    .footer-section {
        position: relative;
        text-align: left;
    }

    .footer-title {
        font-family: var(--font-primary);
        font-size: 1.1rem;
        font-weight: 600;
        color: white;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .title-icon {
        font-size: 1.2rem;
    }

    /* Contact List */
    .footer-contact-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-contact-list li {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        color: #a0a8b3;
        font-size: 0.85rem;
        margin-bottom: 1rem;
        transition: color 0.3s ease;
    }

    .footer-contact-list li:hover {
        color: white;
    }

    .footer-contact-list li i {
        color: var(--primary);
        width: 16px;
        margin-top: 3px;
        flex-shrink: 0;
    }

    /* Links Grid */
    .footer-links-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.6rem;
    }

    .footer-link-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        padding: 0.65rem 0.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.35rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .footer-link-card i {
        font-size: 1rem;
        color: var(--primary);
        transition: transform 0.3s ease;
    }

    .footer-link-card span {
        font-size: 0.7rem;
        color: #a0a8b3;
        font-weight: 500;
        transition: color 0.3s ease;
        text-align: center;
        line-height: 1.3;
    }

    .footer-link-card:hover {
        background: rgba(0, 167, 157, 0.15);
        border-color: var(--primary);
        transform: translateY(-3px);
    }

    .footer-link-card:hover i {
        transform: scale(1.2);
    }

    .footer-link-card:hover span {
        color: white;
    }

    /* Newsletter */
    .footer-newsletter-text {
        color: #a0a8b3;
        font-size: 0.85rem;
        line-height: 1.6;
        margin-bottom: 1rem;
        text-align: left;
    }

    .subscribe-input-wrapper {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .subscribe-input {
        flex: 1;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        color: white;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .subscribe-input:focus {
        outline: none;
        border-color: var(--primary);
        background: rgba(255, 255, 255, 0.12);
        box-shadow: 0 0 0 3px rgba(0, 167, 157, 0.2);
    }

    .subscribe-input::placeholder {
        color: #6b7280;
    }

    .subscribe-btn {
        background: var(--primary-gradient);
        border: none;
        border-radius: 12px;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .subscribe-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 25px rgba(0, 167, 157, 0.4);
    }

    .subscribe-btn:active {
        transform: scale(0.95);
    }

    .footer-fun-text {
        color: #a0a8b3;
        font-size: 0.85rem;
        text-align: left;
    }

    /* Copyright */
    .footer-copyright {
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        padding: 1.25rem 0;
        margin-top: 1rem;
    }

    .copyright-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .copyright-left,
    .copyright-right {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #6b7280;
        font-size: 0.85rem;
    }

    .copyright-link {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .copyright-link:hover {
        color: white;
    }

    .copyright-heart,
    .dev-emoji {
        animation: heartBeat 1.5s ease-in-out infinite;
    }

    @keyframes heartBeat {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    /* Mobile Responsive */
    @media (max-width: 991.98px) {
        .footer-fun {
            border-radius: 28px 28px 0 0;
        }

        .footer-wave {
            height: 60px;
        }

        .footer-logo {
            width: 48px;
            height: 48px;
        }

        .brand-name {
            font-size: 1.2rem;
        }

        .footer-links-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 767.98px) {
        .footer-fun {
            border-radius: 20px 20px 0 0;
        }

        .footer-links-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .copyright-content {
            flex-direction: column;
            text-align: center;
        }

        .subscribe-input-wrapper {
            flex-direction: column;
        }

        .subscribe-btn {
            width: 100%;
            height: 44px;
        }
    }
</style>
