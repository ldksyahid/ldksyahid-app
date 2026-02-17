{{-- Testimony Section - Modern & Elegant Revamp --}}
<section class="testimony-modern py-5" id="testimonySection">
    <div class="container">
        <div class="row g-4">
            {{-- Left Side - Testimony Cards --}}
            <div class="col-lg-7 order-2 order-lg-1">
                {{-- Testimony Cards Grid --}}
                <div class="testimony-grid">
            @forelse($posttestimony as $key => $testimony)
            <div class="testimony-card testimony-card-animate" style="--anim-delay: {{ $key * 0.1 }}s">
                <div class="testimony-card__quote">"</div>
                <div class="testimony-card__profile">
                    <div class="profile__avatar-wrap">
                        <img src="https://lh3.googleusercontent.com/d/{{ $testimony->gdrive_id }}"
                             alt="{{ $testimony->name }}"
                             class="profile__avatar">
                        <div class="profile__status"></div>
                    </div>
                    <div class="profile__info">
                        <h5 class="profile__name">{{ $testimony->name }}</h5>
                        <span class="profile__role">{{ $testimony->profession }}</span>
                    </div>
                </div>
                <div class="testimony-card__divider">
                    <span class="divider__line"></span>
                    <span class="divider__dot"></span>
                    <span class="divider__line"></span>
                </div>
                <p class="testimony-card__text">"{{ $testimony->testimony }}"</p>
            </div>
            @empty
            <div class="testimony-empty">
                <div class="testimony-empty__icon">💭</div>
                <h4>Testimoni Segera Hadir</h4>
                <p>Cerita inspiratif akan segera hadir!</p>
            </div>
            @endforelse
                </div>
            </div>

            {{-- Right Side - Header & Stats --}}
            <div class="col-lg-5 order-1 order-lg-2">
                <div class="testimony-sidebar">
                    {{-- Badge --}}
                    <div class="testimony-badge mb-3">
                        <span class="testimony-badge__emoji">💬</span>
                        <span>Testimoni</span>
                        <span class="testimony-badge__pulse"></span>
                    </div>

                    {{-- Heading --}}
                    <h2 class="testimony-heading mb-3">
                        Kata Mereka <span class="testimony-heading__heart">❤️</span>
                    </h2>

                    {{-- Subtitle --}}
                    <p class="testimony-subtitle mb-4">
                        Banyak mahasiswa UIN Jakarta yang sudah merasakan manfaat bergabung dengan LDK Syahid
                    </p>

                    {{-- Stats Cards --}}
                    <div class="testimony-stats-sidebar">
                        <div class="stat-card stat-card-animate" style="--anim-delay: 0.1s">
                            <div class="stat-card__icon">👥</div>
                            <div class="stat-card__content">
                                <span class="stat-card__number">1000+</span>
                                <span class="stat-card__label">Anggota Aktif</span>
                            </div>
                            <div class="stat-card__shine"></div>
                        </div>
                        <div class="stat-card stat-card-animate" style="--anim-delay: 0.2s">
                            <div class="stat-card__icon">💝</div>
                            <div class="stat-card__content">
                                <span class="stat-card__number">1001</span>
                                <span class="stat-card__label">Berbagi Manfaat</span>
                            </div>
                            <div class="stat-card__shine"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* ═══════════════════════════════════════════════
   TESTIMONY SECTION — Modern & Elegant
   ═══════════════════════════════════════════════ */
.testimony-modern {
    background: transparent;
    position: relative;
}

/* ── Sidebar Container ── */
.testimony-sidebar {
    position: sticky;
    top: 100px;
    opacity: 0;
    transform: translateX(30px);
    transition: opacity 0.8s ease, transform 0.8s ease;
}

.testimony-sidebar.is-visible {
    opacity: 1;
    transform: translateX(0);
}

.testimony-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--primary-light);
    border: 1px solid rgba(0, 167, 157, 0.2);
    border-radius: var(--radius-pill);
    padding: 0.5rem 1.25rem;
    margin-bottom: 1rem;
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--primary);
    max-width: 100%;
    word-wrap: break-word;
}

.testimony-badge__emoji {
    font-size: 1.1rem;
    flex-shrink: 0;
}

.testimony-badge__pulse {
    width: 8px;
    height: 8px;
    background: var(--primary);
    border-radius: 50%;
    animation: testimonyPulse 2s ease-in-out infinite;
    flex-shrink: 0;
}

@keyframes testimonyPulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.5); }
}

.testimony-heading {
    font-family: var(--font-primary);
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
    word-wrap: break-word;
    overflow-wrap: break-word;
    hyphens: auto;
}

.testimony-heading__heart {
    display: inline-block;
    animation: heartBeat 1.5s ease-in-out infinite;
}

@keyframes heartBeat {
    0%, 100% { transform: scale(1); }
    25% { transform: scale(1.1); }
    50% { transform: scale(1); }
}

.testimony-subtitle {
    color: var(--secondary);
    font-size: 1rem;
    line-height: 1.6;
    max-width: 100%;
    margin: 0;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

/* ── Stats Sidebar ── */
.testimony-stats-sidebar {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.stat-card {
    background: white;
    border-radius: 20px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(0, 0, 0, 0.04);
    position: relative;
    overflow: hidden;
    transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1),
                background-color 0.4s ease,
                border-color 0.4s ease;
}

.stat-card::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(0, 167, 157, 0.08) 0%, rgba(0, 167, 157, 0.03) 100%);
    opacity: 0;
    transition: opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: 20px;
    pointer-events: none;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 35px rgba(0, 167, 157, 0.15);
    border-color: var(--primary);
}

.stat-card:hover::after {
    opacity: 1;
}

.stat-card__icon {
    font-size: 2.5rem;
    filter: drop-shadow(0 2px 8px rgba(0, 167, 157, 0.2));
    position: relative;
    z-index: 1;
}

.stat-card__content {
    display: flex;
    flex-direction: column;
    position: relative;
    z-index: 1;
}

.stat-card__number {
    font-family: var(--font-primary);
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--primary);
    line-height: 1;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.stat-card__label {
    font-size: 0.85rem;
    color: var(--secondary);
    font-weight: 500;
    word-wrap: break-word;
    overflow-wrap: break-word;
    text-align: center;
}

.stat-card__shine {
    position: absolute;
    top: 0;
    left: -100%;
    width: 50%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
    transition: left 0.5s ease;
    z-index: 2;
    pointer-events: none;
}

.stat-card:hover .stat-card__shine {
    left: 100%;
}

/* ── Testimony Grid ── */
.testimony-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

.testimony-card {
    background: white;
    border-radius: 20px;
    padding: 1.75rem;
    position: relative;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(0, 0, 0, 0.04);
    transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1),
                background-color 0.4s ease,
                border-color 0.4s ease;
    display: flex;
    flex-direction: column;
}

.testimony-card::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(0, 167, 157, 0.06) 0%, rgba(0, 167, 157, 0.02) 100%);
    opacity: 0;
    transition: opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: 20px;
    pointer-events: none;
}

.testimony-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
    border-color: var(--primary);
}

.testimony-card:hover::after {
    opacity: 1;
}

.testimony-card__quote {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 4rem;
    font-family: Georgia, serif;
    color: var(--primary);
    opacity: 0.1;
    line-height: 1;
    pointer-events: none;
    z-index: 1;
}

.testimony-card__profile {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    margin-bottom: 1rem;
    position: relative;
    z-index: 2;
}

.profile__avatar-wrap {
    position: relative;
    flex-shrink: 0;
}

.profile__avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--primary-light);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.profile__status {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 14px;
    height: 14px;
    background: #10b981;
    border: 2px solid white;
    border-radius: 50%;
}

.profile__name {
    font-family: var(--font-primary);
    font-weight: 700;
    font-size: 1rem;
    color: var(--primary);
    margin: 0 0 0.25rem;
    line-height: 1.2;
}

.profile__role {
    font-size: 0.8rem;
    color: var(--secondary);
    display: block;
}

.testimony-card__divider {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    position: relative;
    z-index: 2;
}

.divider__line {
    flex: 1;
    height: 1px;
    background: linear-gradient(90deg, var(--primary), transparent);
}

.divider__line:last-child {
    background: linear-gradient(90deg, transparent, var(--primary));
}

.divider__dot {
    width: 6px;
    height: 6px;
    background: var(--primary);
    border-radius: 50%;
}

.testimony-card__text {
    color: var(--dark);
    font-size: 0.9rem;
    line-height: 1.7;
    font-style: italic;
    margin: 0;
    flex: 1;
    position: relative;
    z-index: 2;
}

/* ── CTA Button ── */
.testimony-cta {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    background: var(--primary-gradient);
    color: white;
    padding: 1rem 2.5rem;
    border-radius: var(--radius-pill);
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 8px 25px rgba(0, 167, 157, 0.35);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.testimony-cta::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    transform: translate(-50%, -50%);
    transition: width 0.6s ease, height 0.6s ease;
}

.testimony-cta:hover::before {
    width: 300px;
    height: 300px;
}

.testimony-cta:hover {
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 12px 40px rgba(0, 167, 157, 0.45);
}

.testimony-cta__icon {
    font-size: 1.3rem;
    z-index: 1;
}

.testimony-cta i {
    transition: transform 0.3s ease;
    z-index: 1;
}

.testimony-cta:hover i {
    transform: translateX(5px);
}

/* ── Animations ── */
.stat-card-animate,
.testimony-card-animate {
    opacity: 0;
    transform: translateY(40px) scale(0.97);
    transition: opacity 0.6s ease var(--anim-delay, 0s),
                transform 0.6s cubic-bezier(0.4, 0, 0.2, 1) var(--anim-delay, 0s);
}

.stat-card-animate.is-visible,
.testimony-card-animate.is-visible {
    opacity: 1;
    transform: translateY(0) scale(1);
}

/* ── Empty State ── */
.testimony-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 24px;
    box-shadow: 0 6px 30px rgba(0, 0, 0, 0.06);
}

.testimony-empty__icon {
    font-size: 4rem;
    margin-bottom: 1.5rem;
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.testimony-empty h4 {
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.testimony-empty p {
    color: var(--secondary);
    margin: 0;
}

/* ═══════════════════════════════════════════════
   RESPONSIVE
   ═══════════════════════════════════════════════ */
@media (max-width: 991.98px) {
    .testimony-grid {
        grid-template-columns: 1fr;
        gap: 1.25rem;
    }

    .testimony-heading {
        font-size: 1.6rem;
    }

    .stat-card__number {
        font-size: 1.5rem;
    }

    .stat-card__label {
        font-size: 0.8rem;
    }
}

@media (max-width: 767.98px) {
    .testimony-heading {
        font-size: 1.75rem;
    }

    .testimony-subtitle {
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .stat-card__number {
        font-size: 1.3rem;
    }

    .testimony-badge {
        font-size: 0.85rem;
        padding: 0.5rem 1rem;
    }

    .testimony-badge__emoji {
        font-size: 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Viewport animations
    var animEls = document.querySelectorAll('.testimony-sidebar, .stat-card-animate, .testimony-card-animate');
    if ('IntersectionObserver' in window) {
        var obs = new IntersectionObserver(function(entries) {
            entries.forEach(function(e) {
                if (e.isIntersecting) {
                    e.target.classList.add('is-visible');
                    obs.unobserve(e.target);
                }
            });
        }, { threshold: 0.15 });
        animEls.forEach(function(el) { obs.observe(el); });
    } else {
        animEls.forEach(function(el) { el.classList.add('is-visible'); });
    }
});
</script>
