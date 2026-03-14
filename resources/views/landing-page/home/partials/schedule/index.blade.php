{{-- Schedule Section - Fun & Modern Design --}}
<section class="schedule-fun py-5">
    <div class="container">
        {{-- Section Header (Matching Gallery Style - Left + Right Button) --}}
        <div class="row mb-4 mb-lg-5 align-items-center justify-content-between schedule-header-wrap">
            <div class="col-lg-8 mb-3 mb-lg-0">
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
            <div class="col-lg-4 text-lg-end d-none d-md-block">
                <a href="/schedules" class="schedule-btn-view-all">
                    <span>Lihat Semua</span>
                    <i class="fas fa-calendar-check"></i>
                </a>
            </div>
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
                    {{-- Decorative Elements --}}
                    <div class="info-deco-top">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <div class="info-deco-bottom">
                        <i class="fas fa-book-open"></i>
                    </div>

                    {{-- Pattern Background --}}
                    <div class="info-pattern"></div>

                    {{-- Main Content --}}
                    <div class="info-content">
                        <div class="info-badge">
                            <i class="fas fa-calendar-check"></i>
                            <span>Jadwal LDK Syahid</span>
                        </div>

                        <div class="info-divider">
                            <span class="divider-line"></span>
                            <i class="fas fa-star divider-icon"></i>
                            <span class="divider-line"></span>
                        </div>

                        <div class="info-date-wrapper">
                            <div class="info-date-circle">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="info-date">
                                <span class="date-label">EDISI</span>
                                <h3 class="date-month">{{ $schedule->month }}</h3>
                                <span class="date-year">{{ $schedule->year }}</span>
                            </div>
                        </div>

                        <div class="info-description">
                            <i class="fas fa-info-circle"></i>
                            <p>Cek jadwal lengkap kegiatan dan acara LDK Syahid bulan ini!</p>
                        </div>

                        <a href="/schedule" class="info-cta">
                            <span class="cta-icon-wrap">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                            <span class="cta-text">
                                <span class="cta-main">Lihat Semua Jadwal</span>
                                <span class="cta-sub">Klik untuk detail</span>
                            </span>
                            <i class="fas fa-arrow-right cta-arrow"></i>
                        </a>
                    </div>
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

@include('landing-page.home.partials.schedule.components._index-styles')
@include('landing-page.home.partials.schedule.components._index-scripts')
