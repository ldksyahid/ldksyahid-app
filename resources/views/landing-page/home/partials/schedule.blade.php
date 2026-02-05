{{-- Schedule Section - Fun & Modern Design --}}
<section class="schedule-fun py-5">
    <div class="container">
        {{-- Section Header --}}
        <div class="row mb-4 mb-lg-5 align-items-center justify-content-between wow fadeInUp" data-wow-delay="0.1s">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="section-badge-schedule">
                    <span class="badge-emoji">📅</span>
                    <span>Yuk Catat!</span>
                </div>
                <h2 class="section-title-fun">
                    Jadwal Terbaru
                    <span class="title-calendar">🗓️</span>
                </h2>
                <p class="section-description-fun">
                    Jadwal kegiatan LDK Syahid agar kamu tidak ketinggalan info penting!
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="/schedule" class="btn-view-all-schedule">
                    <span>Semua Jadwal</span>
                    <i class="fas fa-calendar-alt"></i>
                </a>
            </div>
        </div>

        {{-- Schedule Cards --}}
        @forelse($postschedule as $key => $schedule)
        <div class="schedule-card-fun wow fadeInUp" data-wow-delay="{{ 0.1 + ($key * 0.1) }}s">
            <div class="schedule-card-inner">
                {{-- Image Side --}}
                <div class="schedule-image-wrapper">
                    <img src="https://lh3.googleusercontent.com/d/{{ $schedule->gdrive_id }}"
                         alt="{{ $schedule->title }}"
                         class="schedule-img">
                    <div class="schedule-overlay">
                        <span class="overlay-emoji">📋</span>
                    </div>
                </div>

                {{-- Info Side --}}
                <div class="schedule-info-box">
                    <div class="info-deco">
                        <span class="deco-emoji">✨</span>
                    </div>
                    <div class="info-badge">
                        <span>Jadwal LDK Syahid</span>
                    </div>
                    <div class="info-divider">
                        <span class="divider-line"></span>
                        <span class="divider-icon">📅</span>
                        <span class="divider-line"></span>
                    </div>
                    <div class="info-date">
                        <span class="date-label">Edisi</span>
                        <h3 class="date-month">{{ $schedule->month }}</h3>
                        <span class="date-year">{{ $schedule->year }}</span>
                    </div>
                    <div class="info-cta">
                        <span class="cta-emoji">👀</span>
                        <span class="cta-text">Lihat Jadwal!</span>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state-schedule wow fadeInUp" data-wow-delay="0.1s">
            <div class="empty-card">
                <div class="empty-emoji">📆</div>
                <h4 class="empty-title">Jadwal Belum Tersedia</h4>
                <p class="empty-text">Jadwal kegiatan akan segera hadir. Pantau terus ya!</p>
                <div class="empty-decoration">
                    <span>✨</span>
                    <span>🌟</span>
                    <span>✨</span>
                </div>
            </div>
        </div>
        @endforelse
    </div>
</section>

<style>
    .schedule-fun {
        background: transparent;
    }

    /* Section Badge */
    .section-badge-schedule {
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
        margin-bottom: 0.5rem;
    }

    .title-calendar {
        display: inline-block;
        animation: calendarFlip 1s ease-in-out infinite alternate;
    }

    @keyframes calendarFlip {
        0% { transform: rotateY(0deg); }
        100% { transform: rotateY(15deg); }
    }

    .section-description-fun {
        color: var(--secondary);
        font-size: 1rem;
    }

    /* View All Button */
    .btn-view-all-schedule {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        background: var(--primary-gradient);
        color: white;
        padding: 0.875rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(0, 167, 157, 0.3);
        transition: all 0.3s ease;
    }

    .btn-view-all-schedule:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 167, 157, 0.4);
        color: white;
    }

    /* Schedule Card */
    .schedule-card-fun {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
        transition: all 0.4s ease;
        margin-bottom: 1.5rem;
    }

    .schedule-card-fun:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    }

    .schedule-card-inner {
        display: flex;
        align-items: stretch;
    }

    /* Image Wrapper */
    .schedule-image-wrapper {
        flex: 1;
        position: relative;
        min-height: 300px;
        overflow: hidden;
    }

    .schedule-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .schedule-card-fun:hover .schedule-img {
        transform: scale(1.05);
    }

    .schedule-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(0, 167, 157, 0.1) 0%, rgba(0, 143, 134, 0.2) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .schedule-card-fun:hover .schedule-overlay {
        opacity: 1;
    }

    .schedule-overlay .overlay-emoji {
        font-size: 3rem;
        animation: bounce 1s ease-in-out infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    /* Info Box */
    .schedule-info-box {
        width: 280px;
        background: var(--primary-light);
        padding: 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        position: relative;
        flex-shrink: 0;
    }

    .info-deco {
        position: absolute;
        top: 15px;
        right: 15px;
    }

    .info-deco .deco-emoji {
        font-size: 1.5rem;
        opacity: 0.5;
    }

    .info-badge {
        background: white;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        margin-bottom: 1rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .info-badge span {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--primary);
    }

    .info-divider {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
        width: 100%;
    }

    .info-divider .divider-line {
        flex: 1;
        height: 2px;
        background: linear-gradient(90deg, transparent, var(--primary), transparent);
    }

    .info-divider .divider-icon {
        font-size: 1.25rem;
    }

    .info-date {
        margin-bottom: 1.5rem;
    }

    .date-label {
        font-size: 0.75rem;
        color: var(--secondary);
        text-transform: uppercase;
        font-weight: 500;
        display: block;
        margin-bottom: 0.25rem;
    }

    .date-month {
        font-family: var(--font-primary);
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary);
        margin: 0;
        line-height: 1.2;
    }

    .date-year {
        font-size: 1rem;
        color: var(--secondary);
        font-weight: 500;
    }

    .info-cta {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary-gradient);
        color: white;
        padding: 0.75rem 1.25rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        box-shadow: 0 4px 15px rgba(0, 167, 157, 0.3);
    }

    .info-cta .cta-emoji {
        font-size: 1rem;
    }

    /* Empty State */
    .empty-state-schedule {
        display: flex;
        justify-content: center;
    }

    .empty-card {
        background: white;
        border-radius: 24px;
        padding: 3rem;
        text-align: center;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
        max-width: 500px;
        width: 100%;
    }

    .empty-emoji {
        font-size: 4rem;
        margin-bottom: 1rem;
    }

    .empty-title {
        font-family: var(--font-primary);
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.5rem;
    }

    .empty-text {
        color: var(--secondary);
        margin-bottom: 1.5rem;
    }

    .empty-decoration {
        display: flex;
        justify-content: center;
        gap: 1rem;
        font-size: 1.5rem;
    }

    /* Mobile Responsive */
    @media (max-width: 991.98px) {
        .schedule-card-inner {
            flex-direction: column;
        }

        .schedule-image-wrapper {
            min-height: 250px;
        }

        .schedule-info-box {
            width: 100%;
            padding: 1.5rem;
        }

        .section-title-fun {
            font-size: 1.5rem;
        }

        .btn-view-all-schedule {
            width: 100%;
            justify-content: center;
        }

        .date-month {
            font-size: 1.5rem;
        }
    }
</style>
