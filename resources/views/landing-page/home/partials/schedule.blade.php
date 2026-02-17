{{-- Schedule Section - Fun & Modern Design --}}
<section class="schedule-fun py-5">
    <div class="container">
        {{-- Section Header --}}
        <div class="text-center mb-5 schedule-header-animate">
            <div class="section-badge-schedule">
                <span class="badge-emoji">📅</span>
                <span>Yuk Catat!</span>
                <span class="badge-pulse"></span>
            </div>
            <h2 class="section-title-fun">
                Jadwal <span class="section-title-highlight">Terbaru</span>
            </h2>
            <p class="section-description-fun">
                Jadwal kegiatan LDK Syahid agar kamu tidak ketinggalan info penting!
            </p>
        </div>

        {{-- Schedule Cards --}}
        @forelse($postschedule as $key => $schedule)
        <div class="schedule-card-fun schedule-card-animate" style="--anim-delay: {{ $key * 0.1 }}s">
            <div class="schedule-card-inner">
                {{-- Image Side --}}
                @if(!empty($schedule->gdrive_id))
                <div class="schedule-image-wrapper">
                    <img src="https://lh3.googleusercontent.com/d/{{ $schedule->gdrive_id }}"
                         alt="{{ $schedule->month }} {{ $schedule->year }}"
                         class="schedule-img">
                    <div class="schedule-image-gradient"></div>
                </div>
                @endif

                {{-- Info Side --}}
                <div class="schedule-info-box">
                    <div class="info-badge">
                        <i class="fas fa-calendar-check"></i>
                        <span>Jadwal LDK Syahid</span>
                    </div>
                    <div class="info-divider">
                        <span class="divider-line"></span>
                        <i class="fas fa-star divider-icon"></i>
                        <span class="divider-line"></span>
                    </div>
                    <div class="info-date">
                        <span class="date-label">EDISI</span>
                        <h3 class="date-month">{{ $schedule->month }}</h3>
                        <span class="date-year">{{ $schedule->year }}</span>
                    </div>
                    <a href="/schedule" class="info-cta">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Lihat Semua Jadwal</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state-schedule schedule-card-animate" style="--anim-delay: 0.1s">
            <div class="empty-card">
                <div class="empty-icon">📆</div>
                <h4 class="empty-title">Jadwal Belum Tersedia</h4>
                <p class="empty-text">Jadwal kegiatan akan segera hadir. Pantau terus ya!</p>
            </div>
        </div>
        @endforelse
    </div>
</section>

<style>
/* ═══════════════════════════════════════════════
   SCHEDULE SECTION — Modern & Elegant
   ═══════════════════════════════════════════════ */
.schedule-fun {
    background: transparent;
    position: relative;
}

/* ── Header (Matching About Style) ── */
.schedule-header-animate {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.7s ease, transform 0.7s ease;
}

.schedule-header-animate.is-visible {
    opacity: 1;
    transform: translateY(0);
}

.section-badge-schedule {
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
    position: relative;
}

.badge-emoji {
    font-size: 1.1rem;
}

.badge-pulse {
    width: 8px;
    height: 8px;
    background: var(--primary);
    border-radius: 50%;
    animation: schPulse 2s ease-in-out infinite;
}

@keyframes schPulse {
    0%, 100% {
        opacity: 1;
        transform: scale(1);
    }
    50% {
        opacity: 0.5;
        transform: scale(1.5);
    }
}

.section-title-fun {
    font-family: var(--font-primary);
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.section-title-highlight {
    color: var(--primary);
    position: relative;
}

.section-title-highlight::after {
    content: '';
    position: absolute;
    bottom: 2px;
    left: 0;
    width: 100%;
    height: 8px;
    background: rgba(0, 167, 157, 0.15);
    border-radius: 4px;
    z-index: -1;
}

.section-description-fun {
    color: var(--secondary);
    font-size: 1rem;
    margin-bottom: 0;
}

/* ── Card Animations ── */
.schedule-card-animate {
    opacity: 0;
    transform: translateY(40px) scale(0.97);
    transition: opacity 0.6s ease var(--anim-delay, 0s),
                transform 0.6s cubic-bezier(0.4, 0, 0.2, 1) var(--anim-delay, 0s);
}

.schedule-card-animate.is-visible {
    opacity: 1;
    transform: translateY(0) scale(1);
}

/* ═══════════════════════════════════════════════
   SCHEDULE CARD — Elegant Horizontal Layout
   ═══════════════════════════════════════════════ */
.schedule-card-fun {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 8px 40px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    margin-bottom: 2rem;
    border: 1px solid rgba(0, 0, 0, 0.04);
}

.schedule-card-fun:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
}

.schedule-card-inner {
    display: flex;
    align-items: stretch;
    min-height: 320px;
}

/* ── Image Section ── */
.schedule-image-wrapper {
    flex: 1;
    position: relative;
    min-height: 320px;
    overflow: hidden;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.schedule-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.schedule-card-fun:hover .schedule-img {
    transform: scale(1.1);
}

.schedule-image-gradient {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 120px;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.4), transparent);
    pointer-events: none;
}

/* ── Info Box Section ── */
.schedule-info-box {
    width: 340px;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    padding: 2.5rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    position: relative;
    flex-shrink: 0;
    border-left: 1px solid rgba(0, 0, 0, 0.05);
}

.info-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: white;
    border: 2px solid var(--primary);
    color: var(--primary);
    padding: 0.6rem 1.25rem;
    border-radius: var(--radius-pill);
    margin-bottom: 1.5rem;
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 0.3px;
    box-shadow: 0 4px 15px rgba(0, 167, 157, 0.15);
    transition: all 0.3s ease;
}

.schedule-card-fun:hover .info-badge {
    background: var(--primary);
    color: white;
    transform: scale(1.05);
}

.info-badge i {
    font-size: 0.9rem;
}

.info-divider {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.75rem;
    width: 100%;
}

.divider-line {
    flex: 1;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(0, 167, 157, 0.3), transparent);
}

.divider-icon {
    color: var(--primary);
    font-size: 0.9rem;
    animation: schStarSpin 3s linear infinite;
}

@keyframes schStarSpin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

.info-date {
    margin-bottom: 2rem;
}

.date-label {
    font-size: 0.7rem;
    color: var(--secondary);
    text-transform: uppercase;
    font-weight: 700;
    letter-spacing: 1.5px;
    display: block;
    margin-bottom: 0.5rem;
}

.date-month {
    font-family: var(--font-primary);
    font-size: 2rem;
    font-weight: 800;
    color: var(--primary);
    margin: 0;
    line-height: 1.2;
    text-shadow: 0 2px 4px rgba(0, 167, 157, 0.1);
}

.date-year {
    font-size: 1.1rem;
    color: var(--secondary);
    font-weight: 600;
    display: block;
    margin-top: 0.25rem;
}

.info-cta {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--primary-gradient);
    color: white;
    padding: 0.9rem 1.75rem;
    border-radius: var(--radius-pill);
    font-weight: 700;
    font-size: 0.85rem;
    text-decoration: none;
    box-shadow: 0 6px 20px rgba(0, 167, 157, 0.35);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.info-cta:hover {
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(0, 167, 157, 0.45);
}

.info-cta i:first-child {
    font-size: 0.85rem;
}

.info-cta i:last-child {
    font-size: 0.75rem;
    transition: transform 0.3s ease;
    margin-left: 0.25rem;
}

.info-cta:hover i:last-child {
    transform: translateX(4px);
}

/* ── Empty State ── */
.empty-state-schedule {
    display: flex;
    justify-content: center;
}

.empty-card {
    background: white;
    border-radius: 24px;
    padding: 4rem 3rem;
    text-align: center;
    box-shadow: 0 8px 40px rgba(0, 0, 0, 0.08);
    max-width: 500px;
    width: 100%;
    border: 1px solid rgba(0, 0, 0, 0.04);
}

.empty-icon {
    font-size: 4.5rem;
    margin-bottom: 1.5rem;
    animation: schEmptyFloat 3s ease-in-out infinite;
}

@keyframes schEmptyFloat {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

.empty-title {
    font-family: var(--font-primary);
    font-weight: 700;
    font-size: 1.4rem;
    color: var(--dark);
    margin-bottom: 0.75rem;
}

.empty-text {
    color: var(--secondary);
    font-size: 1rem;
    margin-bottom: 0;
    line-height: 1.6;
}

/* ═══════════════════════════════════════════════
   RESPONSIVE
   ═══════════════════════════════════════════════ */
@media (max-width: 991.98px) {
    .schedule-card-inner {
        flex-direction: column;
    }

    .schedule-image-wrapper {
        min-height: 280px;
    }

    .schedule-info-box {
        width: 100%;
        padding: 2rem 1.5rem;
        border-left: none;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    .section-title-fun {
        font-size: 1.6rem;
    }

    .date-month {
        font-size: 1.75rem;
    }
}

@media (max-width: 767.98px) {
    .section-title-fun {
        font-size: 1.4rem;
    }

    .schedule-info-box {
        padding: 1.75rem 1.25rem;
    }

    .date-month {
        font-size: 1.5rem;
    }

    .info-badge {
        font-size: 0.75rem;
        padding: 0.5rem 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Viewport animations with IntersectionObserver
    var animEls = document.querySelectorAll('.schedule-header-animate, .schedule-card-animate');

    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.15
        });

        animEls.forEach(function(el) {
            observer.observe(el);
        });
    } else {
        // Fallback for browsers without IntersectionObserver
        animEls.forEach(function(el) {
            el.classList.add('is-visible');
        });
    }
});
</script>
