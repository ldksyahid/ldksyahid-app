{{-- Event Section - Fun & Modern Design --}}
<section class="event-fun py-5">
    <div class="container">
        {{-- Section Header --}}
        <div class="row mb-4 mb-lg-5 align-items-center justify-content-between wow fadeInUp" data-wow-delay="0.1s">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="section-badge-event">
                    <span class="badge-emoji">🎉</span>
                    <span>Yuk Ikuti!</span>
                </div>
                <h2 class="section-title-fun">
                    Kegiatan Seru
                    <span class="title-party">🎊</span>
                </h2>
                <p class="section-description-fun">
                    Kegiatan yang bikin kamu makin asyik dan penuh ilmu! Mari bergabung bersama kami 💪
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="/events" class="btn-view-all-event">
                    <span>Semua Kegiatan</span>
                    <i class="fas fa-calendar-alt"></i>
                </a>
            </div>
        </div>

        {{-- Event Cards --}}
        <div class="event-list">
            @forelse($postevent as $key => $event)
            @php $date = \Carbon\Carbon::parse($event->start ?? $event->dateevent); @endphp
            <div class="event-card-fun wow fadeInUp" data-wow-delay="{{ 0.1 + ($key * 0.1) }}s">
                <div class="event-card-inner">
                    {{-- Date Box --}}
                    <div class="event-date-box">
                        <div class="date-day">{{ $date->format('d') }}</div>
                        <div class="date-month">{{ $date->isoFormat('MMM') }}</div>
                        <div class="date-emoji">📅</div>
                    </div>

                    {{-- Content --}}
                    <div class="event-content">
                        <div class="event-badges">
                            <span class="event-division-badge">{{ $event->division }}</span>
                        </div>
                        <h4 class="event-title">
                            <a href="/events/{{ $event->id }}">{{ $event->title }}</a>
                        </h4>
                        <p class="event-desc d-none d-md-block">
                            {!! \Illuminate\Support\Str::limit(strip_tags($event->broadcast), 100, '...') !!}
                        </p>
                        <a href="/events/{{ $event->id }}" class="event-join-btn">
                            <span>Lihat Detail</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    {{-- Image --}}
                    <a href="/events/{{ $event->id }}" class="event-image-link">
                        <img src="https://lh3.googleusercontent.com/d/{{ $event->gdrive_id }}"
                             alt="{{ $event->title }}"
                             class="event-img">
                        <div class="event-overlay">
                            <span class="overlay-text">Yuk Ikutan! 🙌</span>
                        </div>
                    </a>
                </div>
            </div>
            @empty
            <div class="empty-state-event">
                <div class="empty-emoji">🗓️</div>
                <h4>Belum Ada Kegiatan</h4>
                <p>Kegiatan seru akan segera hadir. Pantau terus ya!</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<style>
    .event-fun {
        background: transparent;
    }

    /* Section Badge */
    .section-badge-event {
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

    .title-party {
        display: inline-block;
        animation: partyPop 0.6s ease-in-out infinite alternate;
    }

    @keyframes partyPop {
        0% { transform: scale(1) rotate(-5deg); }
        100% { transform: scale(1.15) rotate(5deg); }
    }

    .section-description-fun {
        color: var(--secondary);
        font-size: 1rem;
    }

    /* View All Button */
    .btn-view-all-event {
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

    .btn-view-all-event:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 167, 157, 0.4);
        color: white;
    }

    /* Event List */
    .event-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    /* Event Card */
    .event-card-fun {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
        transition: all 0.4s ease;
    }

    .event-card-fun:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    }

    .event-card-inner {
        display: flex;
        align-items: stretch;
    }

    /* Date Box */
    .event-date-box {
        width: 100px;
        background: var(--primary-gradient);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 1.5rem 1rem;
        flex-shrink: 0;
        position: relative;
    }

    .date-day {
        font-size: 2rem;
        font-weight: 700;
        color: white;
        line-height: 1;
    }

    .date-month {
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.9);
        text-transform: uppercase;
        font-weight: 500;
    }

    .date-emoji {
        position: absolute;
        bottom: 10px;
        font-size: 1.25rem;
        opacity: 0.5;
    }

    /* Content */
    .event-content {
        flex: 1;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
    }

    .event-badges {
        margin-bottom: 0.75rem;
    }

    .event-division-badge {
        display: inline-block;
        background: var(--primary-light);
        color: var(--primary);
        padding: 0.25rem 0.875rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .event-title {
        font-family: var(--font-primary);
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 0.75rem;
        line-height: 1.4;
    }

    .event-title a {
        color: var(--dark);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .event-title a:hover {
        color: var(--primary);
    }

    .event-desc {
        color: var(--secondary);
        font-size: 0.9rem;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .event-join-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary-gradient);
        color: white;
        padding: 0.625rem 1.25rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.3s ease;
        margin-top: auto;
        width: fit-content;
    }

    .event-join-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 20px rgba(0, 167, 157, 0.4);
        color: white;
    }

    /* Image */
    .event-image-link {
        position: relative;
        width: 30%;
        min-height: 200px;
        overflow: hidden;
        flex-shrink: 0;
    }

    .event-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .event-card-fun:hover .event-img {
        transform: scale(1.1);
    }

    .event-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(0, 167, 157, 0.9) 0%, rgba(0, 143, 134, 0.9) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .event-card-fun:hover .event-overlay {
        opacity: 1;
    }

    .overlay-text {
        color: white;
        font-weight: 700;
        font-size: 1rem;
    }

    /* Empty State */
    .empty-state-event {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
    }

    .empty-state-event .empty-emoji {
        font-size: 4rem;
        margin-bottom: 1rem;
    }

    /* Mobile Responsive */
    @media (max-width: 991.98px) {
        .event-card-inner {
            flex-direction: column;
        }

        .event-date-box {
            width: 100%;
            flex-direction: row;
            gap: 0.5rem;
            padding: 1rem;
        }

        .date-emoji {
            position: static;
            opacity: 1;
        }

        .event-image-link {
            width: 100%;
            min-height: 180px;
            order: -1;
        }

        .section-title-fun {
            font-size: 1.5rem;
        }

        .btn-view-all-event {
            width: 100%;
            justify-content: center;
        }
    }
</style>
