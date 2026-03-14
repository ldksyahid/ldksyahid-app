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
            {{-- Header - Compact --}}
            <div class="text-center mb-3">
                <div class="testimony-badge-mobile mb-2">
                    <span class="testimony-badge__emoji">💬</span>
                    <span>Testimoni</span>
                </div>
                <h2 class="testimony-heading-mobile mb-2">
                    Kata Mereka <span class="testimony-heading__heart">❤️</span>
                </h2>
                <p class="testimony-subtitle-mobile mb-3">
                    Banyak mahasiswa UIN Jakarta yang sudah merasakan manfaat bergabung dengan LDK Syahid
                </p>
            </div>

            {{-- Mobile Stats - Compact Horizontal --}}
            <div class="testimony-stats-compact mb-3">
                <div class="stat-compact">
                    <span class="stat-compact__icon">👥</span>
                    <div class="stat-compact__text">
                        <span class="stat-compact__number">1000+</span>
                        <span class="stat-compact__label">Anggota</span>
                    </div>
                </div>
                <div class="stat-compact-divider"></div>
                <div class="stat-compact">
                    <span class="stat-compact__icon">💝</span>
                    <div class="stat-compact__text">
                        <span class="stat-compact__number">1001</span>
                        <span class="stat-compact__label">Manfaat</span>
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

@include('landing-page.home.partials.testimony.components._index-styles')
@include('landing-page.home.partials.testimony.components._index-scripts')
