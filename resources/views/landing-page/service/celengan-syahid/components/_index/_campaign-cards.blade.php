{{-- ===========================================================
     CAMPAIGN CARDS PARTIAL
     Variables: $campaigns (LengthAwarePaginator)
     =========================================================== --}}

@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
    use Carbon\Carbon;
    use Illuminate\Support\Str;

    $categoryColors = [
        'Pendidikan'   => '#3b82f6',
        'Kemanusiaan'  => '#ef4444',
        'Kesehatan'    => '#10b981',
        'Ekonomi'      => '#f59e0b',
        'Sosial Dakwah'=> '#8b5cf6',
        'Lingkungan'   => '#16a34a',
    ];
@endphp


{{-- ── Desktop Grid (d-none d-lg-block) ────────────────────── --}}
<div class="d-none d-lg-block">
    @if($campaigns->isEmpty())
        <div class="cs-empty-state">
            <div class="cs-empty-visual">
                <div class="cs-empty-ring cs-empty-ring-1"></div>
                <div class="cs-empty-ring cs-empty-ring-2"></div>
                <div class="cs-empty-icon-wrap">
                    <i class="fas fa-hand-holding-heart"></i>
                    <span class="cs-empty-sparkle cs-empty-sparkle-1">💝</span>
                    <span class="cs-empty-sparkle cs-empty-sparkle-2">✨</span>
                    <span class="cs-empty-sparkle cs-empty-sparkle-3">🔍</span>
                </div>
            </div>
            <h4 class="cs-empty-title">Belum Ada Campaign</h4>
            <p class="cs-empty-sub">Coba ubah kata kunci pencarian atau reset filter</p>
        </div>
    @else
        <div class="cs-grid">
            @foreach($campaigns as $campaign)
            @php
                $donationTotal = 0;
                foreach($campaign->donation as $d) { $donationTotal += (int)$d->jumlah_donasi; }
                $percent = (float)number_format(LFC::persentaseBiayaTerkumpul($donationTotal, $campaign->target_biaya), 1, '.', '');
                $donorCount = $campaign->donation->count();
                $isDeadlinePassed = strtotime($campaign->deadline) < time();
                $daysLeft = LFC::countdownHari($campaign->deadline);
                $isNew = Carbon::parse($campaign->created_at)->diffInDays(now()) <= 14;
                $cover = $campaign->gdrive_id
                    ? 'https://lh3.googleusercontent.com/d/' . $campaign->gdrive_id
                    : 'https://lh3.googleusercontent.com/d/13hUNUJ_oQhmBGMRx37dj380dOhlsKm7O';
                $logoSrc = $campaign->gdrive_id_1
                    ? 'https://lh3.googleusercontent.com/d/' . $campaign->gdrive_id_1
                    : 'https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1';
                $orgName = ($campaign->nama_pj && $campaign->link_pj) ? $campaign->nama_pj : 'UKM LDK Syahid';
                $orgLink = ($campaign->nama_pj && $campaign->link_pj) ? $campaign->link_pj : 'https://www.ldksyah.id/';
                $catColor = $categoryColors[$campaign->kategori] ?? '#00a79d';
            @endphp
            <div class="cs-campaign-card wow fadeInUp"
                 style="--cs-cat: {{ $catColor }}"
                 data-wow-delay="0.{{ ($loop->index % 3 + 1) }}s">

                {{-- Image Area --}}
                <a href="{{ route('service.celengansyahid.detail', $campaign->link) }}" class="cs-card-img-wrap">
                    <img src="{{ $cover }}" alt="{{ $campaign->judul }}" class="cs-card-img" loading="lazy">
                    <div class="cs-card-img-overlay"></div>
                    <span class="cs-cat-badge">{{ $campaign->kategori }}</span>
                    @if($isNew)<span class="cs-new-badge">Baru</span>@endif
                    <div class="cs-percent-chip">{{ number_format($percent, 0) }}%</div>
                </a>

                {{-- Card Body --}}
                <div class="cs-card-body">
                    <div class="cs-card-org">
                        <img src="{{ $logoSrc }}" alt="{{ $orgName }}" class="cs-org-logo" loading="lazy">
                        <a href="{{ $orgLink }}" target="_blank" class="cs-org-name">{{ $orgName }}</a>
                    </div>

                    <h3 class="cs-card-title">
                        <a href="{{ route('service.celengansyahid.detail', $campaign->link) }}">{{ $campaign->judul }}</a>
                    </h3>

                    {{-- Progress bar --}}
                    <div class="cs-progress-wrap">
                        <div class="cs-progress-track">
                            <div class="cs-progress-fill" style="width: {{ min($percent, 100) }}%"></div>
                        </div>
                    </div>

                    {{-- Stats --}}
                    <div class="cs-stats-row">
                        <div class="cs-stat-item">
                            <span class="cs-stat-label">Terkumpul</span>
                            <span class="cs-stat-value cs-stat-primary">{{ LFC::formatRupiah($donationTotal) }}</span>
                        </div>
                        <div class="cs-stat-sep"></div>
                        <div class="cs-stat-item cs-stat-right">
                            <span class="cs-stat-label">{{ $isDeadlinePassed ? 'Status' : 'Sisa Hari' }}</span>
                            <span class="cs-stat-value {{ $isDeadlinePassed ? 'cs-stat-ended' : '' }}">
                                {{ $daysLeft }}
                            </span>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="cs-card-actions">
                        <a href="{{ route('service.celengansyahid.detail.donatenow', $campaign->link) }}" class="cs-btn-donate">
                            <i class="fas fa-heart"></i><span>Donasi Sekarang</span>
                        </a>
                        <div class="cs-share-group">
                            <button class="cs-share-btn cs-share-copy"
                                    onclick="csCopyUrl('{{ route('service.celengansyahid.detail', $campaign->link) }}', event)"
                                    title="Salin URL">
                                <i class="fas fa-link"></i>
                            </button>
                            <button class="cs-share-btn cs-share-wa"
                                    onclick="csShareWa('{{ route('service.celengansyahid.detail', $campaign->link) }}', '{{ e($campaign->judul) }}', event)"
                                    title="Bagikan via WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>


{{-- ── Mobile Carousel (d-lg-none) ─────────────────────────── --}}
<div class="d-lg-none">
    @if($campaigns->isEmpty())
        <div class="cs-empty-state">
            <div class="cs-empty-visual">
                <div class="cs-empty-ring cs-empty-ring-1"></div>
                <div class="cs-empty-icon-wrap">
                    <i class="fas fa-hand-holding-heart"></i>
                    <span class="cs-empty-sparkle cs-empty-sparkle-1">💝</span>
                    <span class="cs-empty-sparkle cs-empty-sparkle-2">✨</span>
                </div>
            </div>
            <h4 class="cs-empty-title">Belum Ada Campaign</h4>
            <p class="cs-empty-sub">Coba ubah kata kunci atau reset filter</p>
        </div>
    @else
        <div class="cs-mobile-carousel" id="cs-mobile-carousel">
            @foreach($campaigns as $campaign)
            @php
                $donationTotal = 0;
                foreach($campaign->donation as $d) { $donationTotal += (int)$d->jumlah_donasi; }
                $percent = (float)number_format(LFC::persentaseBiayaTerkumpul($donationTotal, $campaign->target_biaya), 1, '.', '');
                $donorCount = $campaign->donation->count();
                $isDeadlinePassed = strtotime($campaign->deadline) < time();
                $daysLeft = LFC::countdownHari($campaign->deadline);
                $isNew = Carbon::parse($campaign->created_at)->diffInDays(now()) <= 14;
                $cover = $campaign->gdrive_id
                    ? 'https://lh3.googleusercontent.com/d/' . $campaign->gdrive_id
                    : 'https://lh3.googleusercontent.com/d/13hUNUJ_oQhmBGMRx37dj380dOhlsKm7O';
                $logoSrc = $campaign->gdrive_id_1
                    ? 'https://lh3.googleusercontent.com/d/' . $campaign->gdrive_id_1
                    : 'https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1';
                $orgName = ($campaign->nama_pj && $campaign->link_pj) ? $campaign->nama_pj : 'UKM LDK Syahid';
                $orgLink = ($campaign->nama_pj && $campaign->link_pj) ? $campaign->link_pj : 'https://www.ldksyah.id/';
                $catColor = $categoryColors[$campaign->kategori] ?? '#00a79d';
            @endphp
            <div class="cs-mobile-card"
                 style="--cs-cat: {{ $catColor }}"
                 data-title="{{ e($campaign->judul) }}"
                 data-cover="{{ $cover }}"
                 data-org="{{ e($orgName) }}"
                 data-org-logo="{{ $logoSrc }}"
                 data-org-link="{{ e($orgLink) }}"
                 data-category="{{ e($campaign->kategori) }}"
                 data-percent="{{ number_format($percent, 0) }}"
                 data-collected="{{ LFC::formatRupiah($donationTotal) }}"
                 data-days="{{ $daysLeft }}"
                 data-deadline-passed="{{ $isDeadlinePassed ? '1' : '0' }}"
                 data-donors="{{ $donorCount }}"
                 data-excerpt="{{ e(Str::limit(strip_tags($campaign->cerita), 160)) }}"
                 data-url="{{ route('service.celengansyahid.detail', $campaign->link) }}"
                 data-donate-url="{{ route('service.celengansyahid.detail.donatenow', $campaign->link) }}"
                 onclick="csOpenBottomSheet(this)">

                <div class="cs-m-img-wrap">
                    <img src="{{ $cover }}" alt="{{ $campaign->judul }}" class="cs-m-img" loading="lazy">
                    <div class="cs-m-img-overlay"></div>
                    <span class="cs-m-cat-badge">{{ $campaign->kategori }}</span>
                    @if($isNew)<span class="cs-m-new-badge">Baru</span>@endif
                </div>

                <div class="cs-m-body">
                    <div class="cs-m-org">
                        <img src="{{ $logoSrc }}" alt="{{ $orgName }}" class="cs-m-org-logo" loading="lazy">
                        <span class="cs-m-org-name">{{ Str::limit($orgName, 25) }}</span>
                    </div>
                    <h4 class="cs-m-title">{{ Str::limit($campaign->judul, 55) }}</h4>
                    <div class="cs-m-progress-track">
                        <div class="cs-m-progress-fill" style="width: {{ min($percent, 100) }}%"></div>
                    </div>
                    <div class="cs-m-stats">
                        <span class="cs-m-collected">{{ LFC::formatRupiah($donationTotal) }}</span>
                        <span class="cs-m-days {{ $isDeadlinePassed ? 'cs-m-ended' : '' }}">{{ $daysLeft }}</span>
                    </div>
                    <span class="cs-m-hint"><i class="fas fa-hand-pointer"></i> Lihat detail</span>
                </div>
            </div>
            @endforeach
        </div>
        <div class="cs-carousel-dots" id="cs-carousel-dots"></div>
    @endif
</div>


{{-- ── Pagination ─────────────────────────────────────────── --}}
<div class="cs-pagination-wrap mt-4">
    @include('components.pagination-custom.index', [
        'paginator' => $campaigns,
        'itemLabel' => 'campaign',
    ])
</div>
