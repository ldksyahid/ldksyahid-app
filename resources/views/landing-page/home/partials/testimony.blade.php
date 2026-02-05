{{-- Testimony Section - Fun & Modern Design --}}
<section class="testimony-fun py-5">
    <div class="container">
        <div class="testimony-wrapper wow fadeIn" data-wow-delay="0.1s">
            <div class="row g-4 g-lg-5 align-items-center">
                {{-- Left Side - Info --}}
                <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="testimony-info">
                        <div class="section-badge-testimony">
                            <span class="badge-emoji">💬</span>
                            <span>Testimoni</span>
                        </div>
                        <h2 class="section-title-fun">
                            Kata Mereka
                            <span class="title-heart">❤️</span>
                        </h2>
                        <p class="testimony-description">
                            Banyak mahasiswa UIN Jakarta yang sudah merasakan manfaat bergabung dengan LDK Syahid. Yuk, dengar cerita mereka! 🌟
                        </p>

                        {{-- Fun Stats --}}
                        <div class="testimony-stats">
                            <div class="stat-item-fun">
                                <div class="stat-icon">👥</div>
                                <div class="stat-info">
                                    <span class="stat-number">1000+</span>
                                    <span class="stat-label">Anggota Aktif</span>
                                </div>
                            </div>
                            <div class="stat-item-fun">
                                <div class="stat-icon">💝</div>
                                <div class="stat-info">
                                    <span class="stat-number">1001</span>
                                    <span class="stat-label">Berbagi Manfaat</span>
                                </div>
                            </div>
                        </div>

                        <div class="testimony-cta">
                            <span class="cta-emoji">🤝</span>
                            <span class="cta-text">Gabung bersama kami!</span>
                        </div>
                    </div>
                </div>

                {{-- Right Side - Carousel --}}
                <div class="col-lg-7 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="owl-carousel testimonial-carousel">
                        @forelse($posttestimony as $testimony)
                        <div class="testimony-card-fun">
                            {{-- Quote Decoration --}}
                            <div class="quote-deco">"</div>

                            {{-- Profile --}}
                            <div class="testimony-profile">
                                <div class="profile-avatar-wrapper">
                                    <img class="profile-avatar"
                                         src="https://lh3.googleusercontent.com/d/{{ $testimony->gdrive_id }}"
                                         alt="{{ $testimony->name }}" />
                                    <span class="avatar-emoji">⭐</span>
                                </div>
                                <div class="profile-info">
                                    <h5 class="profile-name">{{ $testimony->name }}</h5>
                                    <span class="profile-role">{{ $testimony->profession }}</span>
                                </div>
                            </div>

                            {{-- Divider --}}
                            <div class="testimony-divider">
                                <span class="divider-line"></span>
                                <span class="divider-emoji">💫</span>
                                <span class="divider-line"></span>
                            </div>

                            {{-- Text --}}
                            <p class="testimony-text">
                                "{{ $testimony->testimony }}"
                            </p>
                        </div>
                        @empty
                        <div class="testimony-card-fun empty">
                            <div class="empty-emoji">💭</div>
                            <h5>Testimoni Segera Hadir</h5>
                            <p>Kami sedang mengumpulkan cerita-cerita inspiratif!</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .testimony-fun {
        background: transparent;
    }

    .testimony-wrapper {
        background: white;
        border-radius: 32px;
        padding: 2.5rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
    }

    /* Section Badge */
    .section-badge-testimony {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary-light);
        border: 1px solid rgba(0, 167, 157, 0.2);
        border-radius: 50px;
        padding: 0.5rem 1.25rem;
        margin-bottom: 0.75rem;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--primary);
    }

    .section-title-fun {
        font-family: var(--font-primary);
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.75rem;
    }

    .title-heart {
        display: inline-block;
        animation: heartPulse 1s ease-in-out infinite;
    }

    @keyframes heartPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }

    .testimony-description {
        color: var(--secondary);
        font-size: 1rem;
        line-height: 1.7;
        margin-bottom: 1.5rem;
    }

    /* Stats */
    .testimony-stats {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-item-fun {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: var(--primary-light);
        padding: 1rem 1.25rem;
        border-radius: 16px;
        flex: 1;
    }

    .stat-icon {
        font-size: 2rem;
    }

    .stat-info {
        display: flex;
        flex-direction: column;
    }

    .stat-number {
        font-family: var(--font-primary);
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary);
        line-height: 1;
    }

    .stat-label {
        font-size: 0.75rem;
        color: var(--secondary);
        font-weight: 500;
    }

    .testimony-cta {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary-gradient);
        color: white;
        padding: 0.875rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(0, 167, 157, 0.3);
    }

    .testimony-cta .cta-emoji {
        font-size: 1.25rem;
    }

    /* Testimony Card */
    .testimony-card-fun {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 24px;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .testimony-card-fun:hover {
        border-color: var(--primary);
        transform: translateY(-5px);
    }

    .quote-deco {
        position: absolute;
        top: 15px;
        right: 25px;
        font-size: 5rem;
        font-family: Georgia, serif;
        color: var(--primary);
        opacity: 0.15;
        line-height: 1;
    }

    /* Profile */
    .testimony-profile {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.25rem;
    }

    .profile-avatar-wrapper {
        position: relative;
    }

    .profile-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .avatar-emoji {
        position: absolute;
        bottom: 0;
        right: -5px;
        font-size: 1.25rem;
    }

    .profile-name {
        font-family: var(--font-primary);
        font-weight: 700;
        color: var(--primary);
        margin: 0;
        font-size: 1.1rem;
    }

    .profile-role {
        color: var(--secondary);
        font-size: 0.85rem;
    }

    /* Divider */
    .testimony-divider {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.25rem;
    }

    .divider-line {
        flex: 1;
        height: 2px;
        background: linear-gradient(90deg, var(--primary), transparent);
        border-radius: 10px;
    }

    .divider-line:last-child {
        background: linear-gradient(90deg, transparent, var(--primary));
    }

    .divider-emoji {
        font-size: 1rem;
    }

    /* Text */
    .testimony-text {
        color: var(--dark);
        font-size: 1rem;
        font-style: italic;
        line-height: 1.7;
        margin: 0;
    }

    /* Empty State */
    .testimony-card-fun.empty {
        text-align: center;
    }

    .testimony-card-fun.empty .empty-emoji {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    /* Owl Carousel Overrides */
    .testimonial-carousel .owl-nav {
        margin-top: 1.5rem;
        display: flex;
        gap: 0.75rem;
    }

    .testimonial-carousel .owl-nav button {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: var(--primary-gradient) !important;
        color: white !important;
        border: none !important;
        transition: all 0.3s ease;
    }

    .testimonial-carousel .owl-nav button:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 20px rgba(0, 167, 157, 0.4);
    }

    /* Mobile Responsive */
    @media (max-width: 991.98px) {
        .testimony-wrapper {
            padding: 1.5rem;
        }

        .section-title-fun {
            font-size: 1.5rem;
        }

        .testimony-stats {
            flex-direction: column;
        }

        .stat-item-fun {
            padding: 0.875rem 1rem;
        }

        .stat-number {
            font-size: 1.25rem;
        }

        .testimony-card-fun {
            padding: 1.5rem;
        }

        .profile-avatar {
            width: 55px;
            height: 55px;
        }
    }
</style>
