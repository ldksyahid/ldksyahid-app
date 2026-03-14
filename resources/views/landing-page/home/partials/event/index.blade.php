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

@include('landing-page.home.partials.event.components._index-styles')
@include('landing-page.home.partials.event.components._index-scripts')
