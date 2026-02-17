{{-- Event Section - Modern & Balanced Design --}}
<section class="event-section py-5" id="eventSection">
    <div class="container">
        {{-- Section Header (Centered) --}}
        <div class="text-center mb-5 event-header-wrap">
            <div class="event-badge">
                <span class="event-badge__emoji">🎉</span>
                <span>Yuk Ikuti!</span>
                <span class="event-badge__pulse"></span>
            </div>
            <h2 class="event-heading">
                Kegiatan <span class="event-heading__highlight">Seru</span>
            </h2>
            <p class="event-subtitle">
                Berbagai kegiatan menarik yang bikin kamu makin berkembang!
            </p>
        </div>

        {{-- Desktop Grid Layout --}}
        <div class="d-none d-md-block">
            <div class="event-grid">
                @forelse($postevent as $key => $event)
                @php
                    $date = \Carbon\Carbon::parse($event->start ?? $event->dateevent);
                    $colors = [
                        ['primary' => '#6366f1', 'gradient' => 'linear-gradient(135deg, #6366f1 0%, #4f46e5 100%)'],
                        ['primary' => '#10b981', 'gradient' => 'linear-gradient(135deg, #10b981 0%, #059669 100%)'],
                        ['primary' => '#f59e0b', 'gradient' => 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)'],
                        ['primary' => '#ef4444', 'gradient' => 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)'],
                        ['primary' => '#8b5cf6', 'gradient' => 'linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%)'],
                        ['primary' => '#ec4899', 'gradient' => 'linear-gradient(135deg, #ec4899 0%, #db2777 100%)'],
                    ];
                    $scheme = $colors[$key % count($colors)];
                @endphp
                <div class="event-card event-card-animate"
                     style="--ev-color: {{ $scheme['primary'] }}; --ev-gradient: {{ $scheme['gradient'] }}; --anim-delay: {{ $key * 0.1 }}s">

                    <div class="event-card__img-wrap">
                        <a href="/events/{{ $event->id }}">
                            <img src="https://lh3.googleusercontent.com/d/{{ $event->gdrive_id }}"
                                 alt="{{ $event->title }}"
                                 class="event-card__img"
                                 loading="lazy">
                            <div class="event-card__overlay">
                                <i class="fas fa-eye"></i>
                            </div>
                        </a>
                        <div class="event-card__date" style="background: {{ $scheme['gradient'] }}">
                            <span class="event-card__day">{{ $date->format('d') }}</span>
                            <span class="event-card__month">{{ $date->isoFormat('MMM') }}</span>
                        </div>
                    </div>

                    <div class="event-card__content">
                        <div class="event-card__badge" style="background: {{ $scheme['primary'] }}20; color: {{ $scheme['primary'] }}">
                            <i class="fas fa-bookmark"></i>
                            {{ $event->division }}
                        </div>
                        <h4 class="event-card__title">
                            <a href="/events/{{ $event->id }}">{{ $event->title }}</a>
                        </h4>
                        <p class="event-card__desc">
                            {!! \Illuminate\Support\Str::limit(strip_tags($event->broadcast), 100, '...') !!}
                        </p>
                        <a href="/events/{{ $event->id }}" class="event-card__btn" style="background: {{ $scheme['gradient'] }}">
                            <span>Lihat Detail</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="event-empty">
                    <div class="event-empty__icon">🗓️</div>
                    <h4>Belum Ada Kegiatan</h4>
                    <p>Kegiatan seru akan segera hadir. Pantau terus ya!</p>
                </div>
                @endforelse
            </div>

            {{-- View All Button --}}
            @if(count($postevent) > 0)
            <div class="text-center mt-4 event-card-animate" style="--anim-delay: 0.5s">
                <a href="/events" class="event-btn-all">
                    <span>Lihat Semua Kegiatan</span>
                    <i class="fas fa-calendar-alt"></i>
                </a>
            </div>
            @endif
        </div>

        {{-- Mobile Carousel --}}
        <div class="d-md-none">
            <div class="owl-carousel event-carousel">
                @forelse($postevent as $key => $event)
                @php
                    $date = \Carbon\Carbon::parse($event->start ?? $event->dateevent);
                    $colors = [
                        ['primary' => '#6366f1', 'gradient' => 'linear-gradient(135deg, #6366f1 0%, #4f46e5 100%)'],
                        ['primary' => '#10b981', 'gradient' => 'linear-gradient(135deg, #10b981 0%, #059669 100%)'],
                        ['primary' => '#f59e0b', 'gradient' => 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)'],
                        ['primary' => '#ef4444', 'gradient' => 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)'],
                        ['primary' => '#8b5cf6', 'gradient' => 'linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%)'],
                        ['primary' => '#ec4899', 'gradient' => 'linear-gradient(135deg, #ec4899 0%, #db2777 100%)'],
                    ];
                    $scheme = $colors[$key % count($colors)];
                @endphp
                <div class="event-card-mobile"
                     style="--ev-color: {{ $scheme['primary'] }}; --ev-gradient: {{ $scheme['gradient'] }}"
                     data-event-id="{{ $event->id }}"
                     data-event-title="{{ $event->title }}"
                     data-event-division="{{ $event->division }}"
                     data-event-date="{{ $date->isoFormat('D MMMM YYYY') }}"
                     data-event-day="{{ $date->format('d') }}"
                     data-event-month="{{ $date->isoFormat('MMM') }}"
                     data-event-img="https://lh3.googleusercontent.com/d/{{ $event->gdrive_id }}"
                     data-event-desc="{!! \Illuminate\Support\Str::limit(strip_tags($event->broadcast), 200, '...') !!}"
                     data-event-url="/events/{{ $event->id }}"
                     data-event-color="{{ $scheme['primary'] }}">

                    <div class="event-card-mobile__img-wrap">
                        <img src="https://lh3.googleusercontent.com/d/{{ $event->gdrive_id }}"
                             alt="{{ $event->title }}"
                             class="event-card-mobile__img">

                        <div class="event-card-mobile__date" style="background: {{ $scheme['gradient'] }}">
                            <span class="event-card-mobile__day">{{ $date->format('d') }}</span>
                            <span class="event-card-mobile__month">{{ $date->isoFormat('MMM') }}</span>
                        </div>

                        <div class="event-card-mobile__tap">
                            Tap untuk info seru! 🎉
                        </div>
                    </div>

                    <div class="event-card-mobile__content">
                        <span class="event-card-mobile__badge" style="background: {{ $scheme['primary'] }}20; color: {{ $scheme['primary'] }}">
                            <i class="fas fa-bookmark"></i>
                            {{ $event->division }}
                        </span>
                        <h5 class="event-card-mobile__title">{{ $event->title }}</h5>
                    </div>
                </div>
                @empty
                <div class="event-empty">
                    <div class="event-empty__icon">🗓️</div>
                    <h4>Belum Ada Kegiatan</h4>
                    <p>Kegiatan seru akan segera hadir!</p>
                </div>
                @endforelse
            </div>

            @if(count($postevent) > 1)
            <div class="event-carousel-dots"></div>
            @endif

            @if(count($postevent) > 0)
            <div class="text-center mt-3">
                <a href="/events" class="event-btn-all event-btn-all--mobile">
                    <span>Semua Kegiatan</span>
                    <i class="fas fa-calendar-alt"></i>
                </a>
            </div>
            @endif
        </div>
    </div>
</section>

{{-- Mobile Bottom Sheet --}}
<div class="event-sheet-overlay" id="eventSheetOverlay"></div>
<div class="event-sheet" id="eventSheet">
    <div class="event-sheet__header">
        <div class="event-sheet__handle"></div>
        <button class="event-sheet__close" id="eventSheetClose">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="event-sheet__content">
        <div class="event-sheet__img-wrap">
            <img src="" alt="" class="event-sheet__img" id="eventSheetImg">
            <div class="event-sheet__date" id="eventSheetDate">
                <span class="event-sheet__day" id="eventSheetDay"></span>
                <span class="event-sheet__month" id="eventSheetMonth"></span>
            </div>
            <div class="event-sheet__gradient"></div>
        </div>
        <div class="event-sheet__info">
            <span class="event-sheet__badge" id="eventSheetBadge">
                <i class="fas fa-bookmark"></i>
                <span id="eventSheetBadgeText"></span>
            </span>
            <h3 class="event-sheet__title" id="eventSheetTitle"></h3>
            <div class="event-sheet__meta">
                <i class="fas fa-calendar-alt"></i>
                <span id="eventSheetDateFull"></span>
            </div>
            <p class="event-sheet__desc" id="eventSheetDesc"></p>
            <a href="#" class="event-sheet__btn" id="eventSheetBtn">
                <span>Lihat Detail Lengkap</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<style>
/* ═══════════════════════════════════════════════
   EVENT SECTION — Modern & Balanced
   ═══════════════════════════════════════════════ */
.event-section {
    background: transparent;
    position: relative;
}

/* ── Header ── */
.event-badge {
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
}

.event-badge__emoji { font-size: 1.1rem; }

.event-badge__pulse {
    width: 8px;
    height: 8px;
    background: var(--primary);
    border-radius: 50%;
    animation: evPulse 2s ease-in-out infinite;
}

@keyframes evPulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.5); }
}

.event-heading {
    font-family: var(--font-primary);
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.event-heading__highlight {
    color: var(--primary);
    position: relative;
}

.event-heading__highlight::after {
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

.event-subtitle {
    color: var(--secondary);
    font-size: 1rem;
    margin-bottom: 0;
}

/* ── Animations ── */
.event-header-wrap {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.7s ease, transform 0.7s ease;
}

.event-header-wrap.is-visible {
    opacity: 1;
    transform: translateY(0);
}

.event-card-animate {
    opacity: 0;
    transform: translateY(40px) scale(0.97);
    transition: opacity 0.6s ease var(--anim-delay, 0s),
                transform 0.6s cubic-bezier(0.4, 0, 0.2, 1) var(--anim-delay, 0s);
}

.event-card-animate.is-visible {
    opacity: 1;
    transform: translateY(0) scale(1);
}

/* ── Grid ── */
.event-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.75rem;
}

/* ═══════════════════════════════════════════════
   EVENT CARD — Clean & Modern
   ═══════════════════════════════════════════════ */
.event-card {
    --ev-color: #6366f1;
    --ev-gradient: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    border: 1px solid rgba(0, 0, 0, 0.04);
    min-height: 280px;
}

.event-card:hover {
    transform: translateY(-8px);
    box-shadow:
        0 20px 50px rgba(0, 0, 0, 0.12),
        0 0 0 2px var(--ev-color);
    border-color: transparent;
}

/* ── Image (Full Left Side) ── */
.event-card__img-wrap {
    position: relative;
    width: 45%;
    flex-shrink: 0;
    overflow: hidden;
}

.event-card__img-wrap a {
    display: block;
    width: 100%;
    height: 100%;
}

.event-card__img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.event-card:hover .event-card__img {
    transform: scale(1.1);
}

.event-card__overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(0, 0, 0, 0.6) 0%, rgba(0, 0, 0, 0.4) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.event-card:hover .event-card__overlay {
    opacity: 1;
}

.event-card__overlay i {
    color: white;
    font-size: 2.5rem;
    animation: evEyePulse 2s ease-in-out infinite;
}

@keyframes evEyePulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.15); }
}

/* ── Date Badge on Image ── */
.event-card__date {
    position: absolute;
    top: 16px;
    left: 16px;
    padding: 10px 16px;
    border-radius: 14px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    z-index: 2;
    display: flex;
    align-items: baseline;
    gap: 0.5rem;
    backdrop-filter: blur(8px);
}

.event-card__day {
    font-size: 1.8rem;
    font-weight: 800;
    color: white;
    line-height: 1;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

.event-card__month {
    font-size: 0.7rem;
    font-weight: 700;
    color: rgba(255, 255, 255, 0.95);
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* ── Content ── */
.event-card__content {
    flex: 1;
    padding: 1.75rem;
    display: flex;
    flex-direction: column;
}

.event-card__badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4rem 1rem;
    border-radius: 50px;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.3px;
    text-transform: uppercase;
    margin-bottom: 0.85rem;
    width: fit-content;
}

.event-card__badge i {
    font-size: 0.65rem;
}

.event-card__title {
    font-family: var(--font-primary);
    font-weight: 700;
    font-size: 1.1rem;
    line-height: 1.4;
    margin-bottom: 0.75rem;
}

.event-card__title a {
    color: var(--dark);
    text-decoration: none;
    background-image: linear-gradient(var(--ev-color), var(--ev-color));
    background-size: 0% 2px;
    background-repeat: no-repeat;
    background-position: left bottom;
    transition: background-size 0.35s ease, color 0.3s ease;
    padding-bottom: 2px;
}

.event-card:hover .event-card__title a {
    background-size: 100% 2px;
    color: var(--ev-color);
}

.event-card__desc {
    color: var(--secondary);
    font-size: 0.88rem;
    line-height: 1.7;
    margin-bottom: 1.25rem;
    flex: 1;
}

.event-card__btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: white;
    font-weight: 700;
    font-size: 0.82rem;
    text-decoration: none;
    padding: 11px 22px;
    border-radius: 50px;
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    width: fit-content;
    margin-top: auto;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
}

.event-card:hover .event-card__btn {
    transform: translateX(5px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
}

.event-card__btn i {
    font-size: 0.7rem;
    transition: transform 0.3s ease;
}

.event-card:hover .event-card__btn i {
    transform: translateX(3px);
}

/* ── View All Button ── */
.event-btn-all {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    background: white;
    color: var(--primary);
    padding: 1rem 2.5rem;
    border-radius: var(--radius-pill);
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: var(--transition);
    border: 2px solid rgba(0, 167, 157, 0.2);
}

.event-btn-all:hover {
    background: var(--primary-gradient);
    color: white;
    transform: translateY(-3px);
    box-shadow: var(--shadow-primary);
    border-color: transparent;
}

.event-btn-all i { transition: transform 0.3s ease; }
.event-btn-all:hover i { transform: translateX(5px); }

/* ═══════════════════════════════════════════════
   MOBILE CARD
   ═══════════════════════════════════════════════ */
.event-card-mobile {
    --ev-color: #6366f1;
    --ev-gradient: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.04);
    display: flex;
    flex-direction: column;
    position: relative;
    isolation: isolate;
}

.event-card-mobile__img-wrap {
    position: relative;
    width: 100%;
    height: 240px;
    overflow: hidden;
    flex-shrink: 0;
    background:
        radial-gradient(circle at 20% 30%, rgba(99, 102, 241, 0.05) 0%, transparent 50%),
        radial-gradient(circle at 80% 70%, rgba(236, 72, 153, 0.05) 0%, transparent 50%),
        radial-gradient(circle at 50% 50%, rgba(16, 185, 129, 0.03) 0%, transparent 70%),
        linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.event-card-mobile__img-wrap::before {
    content: '';
    position: absolute;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: radial-gradient(circle, var(--ev-color, #6366f1)15 0%, transparent 70%);
    top: -30px;
    right: -30px;
    opacity: 0.08;
    animation: evFloatDecor1 8s ease-in-out infinite;
}

.event-card-mobile__img-wrap::after {
    content: '';
    position: absolute;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: radial-gradient(circle, var(--ev-color, #6366f1)25 0%, transparent 70%);
    bottom: -20px;
    left: -20px;
    opacity: 0.1;
    animation: evFloatDecor2 6s ease-in-out infinite;
}

@keyframes evFloatDecor1 {
    0%, 100% { transform: translate(0, 0) scale(1); }
    50% { transform: translate(-10px, 10px) scale(1.1); }
}

@keyframes evFloatDecor2 {
    0%, 100% { transform: translate(0, 0) scale(1); }
    50% { transform: translate(10px, -10px) scale(1.15); }
}

.event-card-mobile__img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
    position: relative;
    z-index: 1;
}

.event-card-mobile__date {
    position: absolute;
    top: 12px;
    left: 12px;
    padding: 8px 16px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    z-index: 2;
    display: flex;
    align-items: baseline;
    gap: 0.4rem;
}

.event-card-mobile__day {
    font-size: 1.6rem;
    font-weight: 800;
    color: white;
    line-height: 1;
}

.event-card-mobile__month {
    font-size: 0.65rem;
    font-weight: 700;
    color: rgba(255, 255, 255, 0.9);
    text-transform: uppercase;
    letter-spacing: 1px;
}

.event-card-mobile__tap {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(6px);
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
    color: var(--dark);
    z-index: 2;
    animation: evTapPulse 2.5s ease-in-out infinite;
}

@keyframes evTapPulse {
    0%, 100% { opacity: 0.9; }
    50% { opacity: 0.5; }
}

.event-card-mobile__content {
    padding: 1.25rem;
    background: white;
    position: relative;
    z-index: 1;
}

.event-card-mobile__badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.35rem 0.9rem;
    border-radius: 50px;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.3px;
    text-transform: uppercase;
    margin-bottom: 0.75rem;
    display: inline-block;
}

.event-card-mobile__badge i {
    font-size: 0.6rem;
}

.event-card-mobile__title {
    font-family: var(--font-primary);
    font-weight: 700;
    font-size: 1.05rem;
    line-height: 1.4;
    color: var(--dark);
    margin: 0;
}

/* ── View All Button ── */
.event-btn-all {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    background: white;
    color: var(--primary);
    padding: 1rem 2.5rem;
    border-radius: var(--radius-pill);
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: var(--transition);
    border: 2px solid rgba(0, 167, 157, 0.2);
}

.event-btn-all:hover {
    background: var(--primary-gradient);
    color: white;
    transform: translateY(-3px);
    box-shadow: var(--shadow-primary);
    border-color: transparent;
}

.event-btn-all i { transition: transform 0.3s ease; }
.event-btn-all:hover i { transform: translateX(5px); }

.event-btn-all--mobile {
    width: 100%;
    justify-content: center;
}

/* ── Empty ── */
.event-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 5rem 2rem;
    background: white;
    border-radius: 24px;
    box-shadow: 0 6px 30px rgba(0, 0, 0, 0.06);
}

.event-empty__icon { font-size: 4rem; margin-bottom: 1.5rem; }
.event-empty h4 { color: var(--dark); margin-bottom: 0.5rem; }
.event-empty p { color: var(--secondary); margin-bottom: 0; }

/* ═══════════════════════════════════════════════
   CAROUSEL
   ═══════════════════════════════════════════════ */
.event-carousel.owl-carousel .owl-stage-outer {
    padding: 8px 0 16px;
    overflow: hidden;
}

.event-carousel.owl-carousel .owl-stage {
    display: flex !important;
}

.event-carousel.owl-carousel .owl-item {
    float: none !important;
    display: flex;
    isolation: isolate;
}

.event-carousel .event-card-mobile {
    width: 100%;
}

.event-carousel-dots {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 1.5rem;
}

.event-carousel-dots .event-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(0, 167, 157, 0.2);
    border: none;
    padding: 0;
    cursor: pointer;
    transition: all 0.3s ease;
}

.event-carousel-dots .event-dot.active {
    width: 32px;
    border-radius: 4px;
    background: var(--primary);
}

.event-carousel .owl-dots,
.event-carousel .owl-nav {
    display: none !important;
}

/* ═══════════════════════════════════════════════
   BOTTOM SHEET
   ═══════════════════════════════════════════════ */
.event-sheet-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    z-index: 10000;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}

.event-sheet-overlay.active {
    opacity: 1;
    visibility: visible;
}

.event-sheet {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: white;
    border-radius: 24px 24px 0 0;
    z-index: 10001;
    max-height: 90vh;
    overflow-y: auto;
    transform: translateY(100%);
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 -10px 40px rgba(0, 0, 0, 0.2);
}

.event-sheet.active {
    transform: translateY(0);
}

.event-sheet__header {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px 16px;
    z-index: 10;
    background: transparent;
}

.event-sheet__handle {
    width: 40px;
    height: 4px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.event-sheet__close {
    position: absolute;
    right: 16px;
    top: 12px;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: none;
    background: rgba(255, 255, 255, 0.95);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.15);
}

.event-sheet__close:hover {
    background: var(--primary);
    color: white;
}

.event-sheet__content {
    padding: 0 0 2rem;
    position: relative;
}

.event-sheet__img-wrap {
    position: relative;
    width: 100%;
    height: 280px;
    overflow: hidden;
}

.event-sheet__img {
    width: 100%;
    height: 500px;
    object-fit: cover;
    object-position: center top;
}

.event-sheet__date {
    position: absolute;
    bottom: 24px;
    left: 16px;
    padding: 10px 18px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    z-index: 3;
    display: flex;
    align-items: baseline;
    gap: 0.5rem;
}

.event-sheet__day {
    font-size: 1.8rem;
    font-weight: 800;
    color: white;
    line-height: 1;
}

.event-sheet__month {
    font-size: 0.7rem;
    font-weight: 700;
    color: rgba(255, 255, 255, 0.9);
    text-transform: uppercase;
    letter-spacing: 1px;
}

.event-sheet__gradient {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 100px;
    background: linear-gradient(to top, white, transparent);
    z-index: 1;
}

.event-sheet__info {
    padding: 0.5rem 1.5rem 0;
}

.event-sheet__badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4rem 1rem;
    border-radius: 50px;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.3px;
    text-transform: uppercase;
    margin-bottom: 1rem;
}

.event-sheet__badge i {
    font-size: 0.65rem;
}

.event-sheet__title {
    font-family: var(--font-primary);
    font-weight: 800;
    font-size: 1.4rem;
    color: var(--dark);
    line-height: 1.4;
    margin: 0 0 1rem;
}

.event-sheet__meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--secondary);
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 1.25rem;
}

.event-sheet__meta i {
    color: var(--primary);
}

.event-sheet__desc {
    color: var(--secondary);
    font-size: 0.9rem;
    line-height: 1.7;
    margin-bottom: 1.5rem;
}

.event-sheet__btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    width: 100%;
    background: var(--primary-gradient);
    color: white;
    padding: 1.1rem;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1rem;
    text-decoration: none;
    box-shadow: 0 8px 25px rgba(0, 167, 157, 0.35);
    transition: var(--transition);
}

.event-sheet__btn:hover {
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 12px 35px rgba(0, 167, 157, 0.45);
}

body.event-sheet-open {
    overflow: hidden !important;
}

body.event-sheet-open .back-to-top {
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
}

/* ═══════════════════════════════════════════════
   RESPONSIVE
   ═══════════════════════════════════════════════ */
@media (max-width: 991.98px) {
    .event-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .event-card {
        flex-direction: column;
        min-height: auto;
    }

    .event-card__img-wrap {
        width: 100%;
        height: 220px;
    }

    .event-card__content {
        padding: 1.5rem;
    }

    .event-heading { font-size: 1.6rem; }
}

@media (max-width: 767.98px) {
    .event-heading { font-size: 1.4rem; }

    .event-card__img-wrap {
        height: 200px;
    }

    .event-card__content {
        padding: 1.25rem;
    }
}

@media (max-width: 575.98px) {
    .event-card__img-wrap {
        height: 180px;
    }

    .event-card__content {
        padding: 1rem 1.25rem;
    }
}

@media (min-width: 768px) {
    .event-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .event-sheet {
        max-width: 500px;
        left: 50%;
        transform: translate(-50%, 100%);
    }

    .event-sheet.active {
        transform: translate(-50%, 0);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Viewport animations
    var animEls = document.querySelectorAll('.event-header-wrap, .event-card-animate');
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

    // Carousel
    var $carousel = jQuery('.event-carousel');
    if ($carousel.length) {
        $carousel.owlCarousel({
            items: 1,
            margin: 14,
            stagePadding: 24,
            loop: false,
            dots: false,
            nav: false,
            autoplay: false,
            smartSpeed: 350,
            touchDrag: true,
            mouseDrag: true,
        });

        var $dots = jQuery('.event-carousel-dots');
        var count = $carousel.find('.owl-item:not(.cloned)').length;
        if (count > 1 && $dots.length) {
            for (var i = 0; i < count; i++) {
                var $d = jQuery('<button class="event-dot" aria-label="Slide ' + (i + 1) + '"></button>');
                if (i === 0) $d.addClass('active');
                $d.data('index', i);
                $dots.append($d);
            }
            $dots.on('click', '.event-dot', function() {
                $carousel.trigger('to.owl.carousel', [jQuery(this).data('index'), 300]);
            });
            $carousel.on('changed.owl.carousel', function(e) {
                $dots.find('.event-dot').removeClass('active').eq(e.item.index).addClass('active');
            });
        }
    }

    // Bottom Sheet
    var $overlay = jQuery('#eventSheetOverlay');
    var $sheet = jQuery('#eventSheet');
    var $body = jQuery('body');

    function openSheet(d) {
        jQuery('#eventSheetImg').attr('src', d.img).attr('alt', d.title);
        jQuery('#eventSheetDay').text(d.day);
        jQuery('#eventSheetMonth').text(d.month);
        jQuery('#eventSheetBadgeText').text(d.division);
        jQuery('#eventSheetTitle').text(d.title);
        jQuery('#eventSheetDateFull').text(d.date);
        jQuery('#eventSheetDesc').text(d.desc);
        jQuery('#eventSheetBtn').attr('href', d.url);

        // Apply dynamic color
        jQuery('.event-sheet__date').css('background', d.color);
        jQuery('.event-sheet__badge').css({
            'background': d.color + '20',
            'color': d.color
        });
        jQuery('.event-sheet__meta i').css('color', d.color);

        $body.addClass('event-sheet-open');
        $overlay.addClass('active');
        setTimeout(function() { $sheet.addClass('active'); }, 10);
        $sheet[0].scrollTop = 0;
    }

    function closeSheet() {
        $sheet.removeClass('active');
        setTimeout(function() {
            $overlay.removeClass('active');
            $body.removeClass('event-sheet-open');
            if (jQuery(window).scrollTop() > 300) {
                jQuery('.back-to-top').stop(true).fadeIn(300);
            }
        }, 380);
    }

    jQuery(document).on('click', '.event-card-mobile', function(e) {
        e.preventDefault();
        var $el = jQuery(this);
        openSheet({
            title: $el.data('event-title'),
            division: $el.data('event-division'),
            date: $el.data('event-date'),
            day: $el.data('event-day'),
            month: $el.data('event-month'),
            img: $el.data('event-img'),
            desc: $el.data('event-desc'),
            url: $el.data('event-url'),
            color: $el.data('event-color')
        });
    });

    jQuery('#eventSheetClose').on('click', closeSheet);
    $overlay.on('click', closeSheet);
    jQuery(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $sheet.hasClass('active')) closeSheet();
    });

    // Swipe down
    var startY = 0, currentY = 0, el = $sheet[0];
    if (el) {
        el.addEventListener('touchstart', function(e) {
            startY = this.scrollTop <= 0 ? e.touches[0].clientY : 0;
        }, { passive: true });
        el.addEventListener('touchmove', function(e) {
            if (!startY) return;
            currentY = e.touches[0].clientY;
            var diff = currentY - startY;
            if (diff > 0 && this.scrollTop <= 0) {
                var val = Math.min(diff * 0.6, 200);
                this.style.transform = window.innerWidth >= 768 ?
                    'translate(-50%, ' + val + 'px)' : 'translateY(' + val + 'px)';
            }
        }, { passive: true });
        el.addEventListener('touchend', function() {
            if (currentY - startY > 80) closeSheet();
            var self = this;
            setTimeout(function() { self.style.transform = ''; }, 380);
            startY = 0;
            currentY = 0;
        }, { passive: true });
    }
});
</script>
