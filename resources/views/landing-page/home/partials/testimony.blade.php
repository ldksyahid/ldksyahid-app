{{-- Testimony Section - Modern & Elegant Revamp --}}
<section class="testimony-modern py-5" id="testimonySection">
    <div class="container">
        {{-- Desktop View --}}
        <div class="d-none d-md-block">
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

        {{-- Mobile View - WITH DOTS --}}
        <div class="d-md-none">
            {{-- Header --}}
            <div class="text-center mb-4">
                <div class="testimony-badge mb-3">
                    <span class="testimony-badge__emoji">💬</span>
                    <span>Testimoni</span>
                    <span class="testimony-badge__pulse"></span>
                </div>
                <h2 class="testimony-heading mb-3">
                    Kata Mereka <span class="testimony-heading__heart">❤️</span>
                </h2>
                <p class="testimony-subtitle mb-4">
                    Banyak mahasiswa UIN Jakarta yang sudah merasakan manfaat bergabung dengan LDK Syahid
                </p>
            </div>

            {{-- Mobile Stats --}}
            <div class="testimony-stats-mobile mb-4">
                <div class="stat-mobile">
                    <div class="stat-mobile__icon">👥</div>
                    <div class="stat-mobile__content">
                        <span class="stat-mobile__number">1000+</span>
                        <span class="stat-mobile__label">ANGGOTA</span>
                    </div>
                </div>
                <div class="stat-mobile">
                    <div class="stat-mobile__icon">💝</div>
                    <div class="stat-mobile__content">
                        <span class="stat-mobile__number">1001</span>
                        <span class="stat-mobile__label">MANFAAT</span>
                    </div>
                </div>
            </div>

            {{-- Carousel with DOTS --}}
            <div class="testimony-carousel-container">
                <div class="testimony-carousel owl-carousel">
                    @forelse($posttestimony as $key => $testimony)
                    <div class="testimony-card-mobile" data-index="{{ $key }}">
                        <div class="testimony-card-mobile__header">
                            <div class="testimony-card-mobile__avatar-wrapper">
                                <img src="https://lh3.googleusercontent.com/d/{{ $testimony->gdrive_id }}"
                                     alt="{{ $testimony->name }}"
                                     class="testimony-card-mobile__avatar">
                            </div>
                            <div class="testimony-card-mobile__info">
                                <h5 class="testimony-card-mobile__name">{{ $testimony->name }}</h5>
                                <span class="testimony-card-mobile__role">{{ $testimony->profession }}</span>
                            </div>
                        </div>
                        <button class="testimony-card-mobile__btn"
                                data-name="{{ $testimony->name }}"
                                data-role="{{ $testimony->profession }}"
                                data-img="https://lh3.googleusercontent.com/d/{{ $testimony->gdrive_id }}"
                                data-text="{{ $testimony->testimony }}">
                            Baca Testimoni 💬
                        </button>
                    </div>
                    @empty
                    <div class="testimony-empty-mobile">
                        <div class="testimony-empty__icon">💭</div>
                        <h4>Testimoni Segera Hadir</h4>
                    </div>
                    @endforelse
                </div>

                {{-- Custom Dots Navigation --}}
                @if(count($posttestimony) > 1)
                <div class="testimony-carousel-dots">
                    @foreach($posttestimony as $key => $testimony)
                    <button class="testimony-carousel-dot {{ $key == 0 ? 'active' : '' }}"
                            data-slide="{{ $key }}"
                            aria-label="Go to slide {{ $key + 1 }}"></button>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- Bottom Sheet --}}
<div class="testimony-sheet-overlay" id="testimonySheetOverlay"></div>
<div class="testimony-sheet" id="testimonySheet">
    <div class="testimony-sheet__header">
        <div class="testimony-sheet__handle"></div>
        <button class="testimony-sheet__close" id="testimonySheetClose">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="testimony-sheet__content">
        <div class="testimony-sheet__profile">
            <img src="" alt="" class="testimony-sheet__avatar" id="testimonySheetAvatar">
            <div class="testimony-sheet__info">
                <h4 class="testimony-sheet__name" id="testimonySheetName"></h4>
                <span class="testimony-sheet__role" id="testimonySheetRole"></span>
            </div>
        </div>
        <div class="testimony-sheet__divider"></div>
        <div class="testimony-sheet__quote">"</div>
        <p class="testimony-sheet__text" id="testimonySheetText"></p>
    </div>
</div>

<style>
/* ═══════════════════════════════════════════════
   TESTIMONY SECTION — Modern & Elegant
   ═══════════════════════════════════════════════ */
:root {
    --primary: #00a79d;
    --primary-light: rgba(0, 167, 157, 0.1);
    --primary-gradient: linear-gradient(135deg, #00a79d 0%, #00d4c4 100%);
    --secondary: #6c757d;
    --dark: #2d3e50;
    --font-primary: 'Poppins', sans-serif;
    --radius-pill: 50px;
}

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

/* ═══════════════════════════════════════════════
   MOBILE STYLES - WITH DOTS
   ═══════════════════════════════════════════════ */

/* Mobile Stats */
.testimony-stats-mobile {
    display: flex;
    justify-content: center;
    gap: 1rem;
    padding: 0 0.5rem;
    margin-bottom: 1.5rem;
}

.stat-mobile {
    background: white;
    border-radius: 20px;
    padding: 1rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.04);
    flex: 0 1 auto;
    min-width: 140px;
}

.stat-mobile__icon {
    font-size: 2.2rem;
    filter: drop-shadow(0 2px 8px rgba(0, 167, 157, 0.2));
    flex-shrink: 0;
}

.stat-mobile__content {
    display: flex;
    flex-direction: column;
}

.stat-mobile__number {
    font-family: var(--font-primary);
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--primary);
    line-height: 1.2;
}

.stat-mobile__label {
    font-size: 0.75rem;
    color: var(--secondary);
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

/* Carousel Container */
.testimony-carousel-container {
    position: relative;
    width: 100%;
}

/* Mobile Carousel */
.testimony-carousel.owl-carousel {
    margin: 0 -12px;
    width: calc(100% + 24px);
}

.testimony-carousel .owl-stage-outer {
    padding: 10px 0 20px;
    overflow: hidden;
}

.testimony-carousel .owl-item {
    display: flex;
    justify-content: center;
}

.testimony-card-mobile {
    background: white;
    border-radius: 24px;
    padding: 1.5rem;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    border: 2px solid rgba(0, 167, 157, 0.08);
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
    width: 100%;
    max-width: 320px;
    margin: 0 auto;
}

.testimony-card-mobile__header {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.testimony-card-mobile__avatar-wrapper {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid var(--primary-light);
    box-shadow: 0 4px 15px rgba(0, 167, 157, 0.2);
    flex-shrink: 0;
}

.testimony-card-mobile__avatar {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.testimony-card-mobile__info {
    flex: 1;
    min-width: 0;
}

.testimony-card-mobile__name {
    font-family: var(--font-primary);
    font-weight: 700;
    font-size: 1.1rem;
    color: var(--primary);
    margin: 0 0 0.25rem;
    line-height: 1.3;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.testimony-card-mobile__role {
    font-size: 0.8rem;
    color: var(--secondary);
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.testimony-card-mobile__btn {
    width: 100%;
    padding: 0.875rem 1.25rem;
    background: linear-gradient(135deg, var(--primary) 0%, #00d4c4 100%);
    color: white;
    border: none;
    border-radius: 16px;
    font-size: 0.95rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 167, 157, 0.3);
}

.testimony-card-mobile__btn:active {
    transform: scale(0.97);
    box-shadow: 0 2px 8px rgba(0, 167, 157, 0.2);
}

/* Custom Dots Navigation */
.testimony-carousel-dots {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.75rem;
    margin-top: 1rem;
    padding: 0.5rem 0;
}

.testimony-carousel-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: rgba(0, 167, 157, 0.2);
    border: none;
    padding: 0;
    cursor: pointer;
    transition: all 0.3s ease;
}

.testimony-carousel-dot:hover {
    background: rgba(0, 167, 157, 0.4);
}

.testimony-carousel-dot.active {
    width: 24px;
    border-radius: 12px;
    background: var(--primary);
    transform: scale(1);
}

/* Hide default Owl Dots */
.owl-carousel .owl-dots {
    display: none !important;
}

/* Empty State */
.testimony-empty-mobile {
    text-align: center;
    padding: 2.5rem 1.5rem;
    background: white;
    border-radius: 24px;
    box-shadow: 0 6px 30px rgba(0, 0, 0, 0.06);
    max-width: 320px;
    margin: 0 auto;
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

/* Bottom Sheet */
.testimony-sheet-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    z-index: 10000;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}

.testimony-sheet-overlay.active {
    opacity: 1;
    visibility: visible;
}

.testimony-sheet {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: white;
    border-radius: 24px 24px 0 0;
    z-index: 10001;
    max-height: 80vh;
    overflow-y: auto;
    transform: translateY(100%);
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 -10px 40px rgba(0, 0, 0, 0.2);
}

.testimony-sheet.active {
    transform: translateY(0);
}

.testimony-sheet__header {
    position: sticky;
    top: 0;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px 16px;
    z-index: 10;
    border-radius: 24px 24px 0 0;
}

.testimony-sheet__handle {
    width: 40px;
    height: 4px;
    background: rgba(0, 0, 0, 0.2);
    border-radius: 2px;
}

.testimony-sheet__close {
    position: absolute;
    right: 16px;
    top: 12px;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: none;
    background: var(--primary-light);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.testimony-sheet__close:hover {
    background: var(--primary);
    color: white;
}

.testimony-sheet__content {
    padding: 1rem 1.5rem 2rem;
}

.testimony-sheet__profile {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.testimony-sheet__avatar {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid var(--primary-light);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    flex-shrink: 0;
}

.testimony-sheet__info {
    flex: 1;
    min-width: 0;
}

.testimony-sheet__name {
    font-family: var(--font-primary);
    font-weight: 800;
    font-size: 1.2rem;
    color: var(--primary);
    margin: 0 0 0.25rem;
    word-break: break-word;
}

.testimony-sheet__role {
    font-size: 0.9rem;
    color: var(--secondary);
    display: block;
    word-break: break-word;
}

.testimony-sheet__divider {
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, var(--primary), transparent, var(--primary));
    margin-bottom: 1.5rem;
    border-radius: 4px;
}

.testimony-sheet__quote {
    font-size: 3.5rem;
    font-family: Georgia, serif;
    color: var(--primary);
    opacity: 0.15;
    line-height: 1;
    margin-bottom: -1.5rem;
}

.testimony-sheet__text {
    color: var(--dark);
    font-size: 1rem;
    line-height: 1.7;
    font-style: italic;
    margin: 0;
    word-wrap: break-word;
    overflow-wrap: break-word;
    hyphens: auto;
}

body.testimony-sheet-open {
    overflow: hidden !important;
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
}

@media (max-width: 767.98px) {
    .testimony-heading {
        font-size: 1.75rem;
    }

    .testimony-subtitle {
        font-size: 0.95rem;
        line-height: 1.6;
        padding: 0 0.5rem;
    }

    .testimony-badge {
        font-size: 0.85rem;
        padding: 0.5rem 1rem;
    }
}

@media (max-width: 480px) {
    .testimony-stats-mobile {
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
    }

    .stat-mobile {
        width: 100%;
        max-width: 250px;
        justify-content: center;
    }

    .testimony-card-mobile {
        max-width: 280px;
        padding: 1.25rem;
    }

    .testimony-card-mobile__avatar-wrapper {
        width: 50px;
        height: 50px;
    }

    .testimony-card-mobile__name {
        font-size: 1rem;
    }

    .testimony-card-mobile__role {
        font-size: 0.75rem;
    }

    .testimony-carousel-dot {
        width: 8px;
        height: 8px;
    }

    .testimony-carousel-dot.active {
        width: 20px;
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

    // Mobile Carousel with Dots
    if (typeof jQuery !== 'undefined' && jQuery('.testimony-carousel').length) {
        var $carousel = jQuery('.testimony-carousel');
        var $dots = jQuery('.testimony-carousel-dot');

        if ($carousel.data('owl.carousel')) {
            $carousel.owlCarousel('destroy');
        }

        $carousel.owlCarousel({
            items: 1,
            margin: 16,
            stagePadding: 40,
            loop: false,
            dots: false, // Disable default dots
            nav: false,
            autoplay: false,
            smartSpeed: 400,
            touchDrag: true,
            mouseDrag: true,
            onChanged: function(event) {
                // Update custom dots on slide change
                var currentIndex = event.item.index - event.relatedTarget._clones.length / 2;
                var totalItems = event.item.count;

                // Adjust index for proper display
                if (currentIndex < 0) {
                    currentIndex = totalItems + currentIndex;
                } else if (currentIndex >= totalItems) {
                    currentIndex = currentIndex - totalItems;
                }

                $dots.removeClass('active');
                $dots.eq(currentIndex).addClass('active');
            },
            responsive: {
                0: {
                    items: 1,
                    stagePadding: 30,
                    margin: 12
                },
                576: {
                    items: 1,
                    stagePadding: 50,
                    margin: 16
                }
            }
        });

        // Custom dots click handler
        $dots.on('click', function() {
            var index = jQuery(this).data('slide');
            $carousel.trigger('to.owl.carousel', [index, 400]);
        });
    }

    // Bottom Sheet
    var $overlay = jQuery('#testimonySheetOverlay');
    var $sheet = jQuery('#testimonySheet');
    var $body = jQuery('body');

    function openSheet(data) {
        jQuery('#testimonySheetAvatar').attr('src', data.img).attr('alt', data.name);
        jQuery('#testimonySheetName').text(data.name);
        jQuery('#testimonySheetRole').text(data.role);
        jQuery('#testimonySheetText').text('"' + data.text + '"');

        $body.addClass('testimony-sheet-open');
        $overlay.addClass('active');
        setTimeout(function() {
            $sheet.addClass('active');
        }, 50);

        if ($sheet[0]) {
            $sheet[0].scrollTop = 0;
        }
    }

    function closeSheet() {
        $sheet.removeClass('active');
        setTimeout(function() {
            $overlay.removeClass('active');
            $body.removeClass('testimony-sheet-open');
        }, 400);
    }

    // Handle button clicks
    jQuery(document).on('click', '.testimony-card-mobile__btn', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var $btn = jQuery(this);
        openSheet({
            name: $btn.data('name'),
            role: $btn.data('role'),
            img: $btn.data('img'),
            text: $btn.data('text')
        });
    });

    // Close handlers
    jQuery('#testimonySheetClose').on('click', closeSheet);
    $overlay.on('click', closeSheet);

    jQuery(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $sheet.hasClass('active')) {
            closeSheet();
        }
    });

    // Swipe down to close
    var startY = 0, currentY = 0;
    var el = $sheet[0];
    if (el) {
        el.addEventListener('touchstart', function(e) {
            if (this.scrollTop <= 0) {
                startY = e.touches[0].clientY;
            }
        }, { passive: true });

        el.addEventListener('touchmove', function(e) {
            if (!startY) return;
            currentY = e.touches[0].clientY;
            var diff = currentY - startY;

            if (diff > 0 && this.scrollTop <= 0) {
                e.preventDefault();
                var val = Math.min(diff * 0.6, 200);
                this.style.transform = 'translateY(' + val + 'px)';
            }
        }, { passive: false });

        el.addEventListener('touchend', function() {
            if (currentY - startY > 80) {
                closeSheet();
            }
            this.style.transform = '';
            startY = 0;
            currentY = 0;
        }, { passive: true });
    }
});
</script>
