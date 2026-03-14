{{-- ===========================================================
     REPORT CARDS PARTIAL
     Variables required: $reports (LengthAwarePaginator)
     =========================================================== --}}

@php
    $cardColors = ['#6366f1', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#0ea5e9'];
@endphp

{{-- ── Desktop Grid (d-none d-lg-block) ───────────────────────── --}}
<div class="d-none d-lg-block">
    @if($reports->isEmpty())
        <div class="rp-empty-state">
            <div class="rp-empty-visual">
                <div class="rp-empty-deco rp-empty-deco-1"></div>
                <div class="rp-empty-deco rp-empty-deco-2"></div>
                <div class="rp-empty-deco rp-empty-deco-3"></div>
                <div class="rp-empty-ring rp-empty-ring-1"></div>
                <div class="rp-empty-ring rp-empty-ring-2"></div>
                <div class="rp-empty-icon-wrap">
                    <i class="fas fa-folder-open"></i>
                    <span class="rp-empty-sparkle rp-empty-sparkle-1">✨</span>
                    <span class="rp-empty-sparkle rp-empty-sparkle-2">📄</span>
                    <span class="rp-empty-sparkle rp-empty-sparkle-3">🔍</span>
                </div>
            </div>
            <h4 class="rp-empty-title">Belum Ada Laporan</h4>
            <p class="rp-empty-sub">Laporan akan ditampilkan di sini setelah diterbitkan</p>
        </div>
    @else
        <div class="rp-grid">
            @foreach($reports as $report)
            @php $accent = $cardColors[$loop->index % count($cardColors)]; @endphp
            <div class="rp-card wow fadeInUp" style="--rp-accent: {{ $accent }}"
                 data-wow-delay="0.{{ ($loop->index % 3 + 1) }}s">

                {{-- Image --}}
                <a href="{{ $report->node ?? '#' }}" class="rp-card-img-wrap"
                   @if($report->node) target="_blank" rel="noopener" @endif>
                    @if($report->iconGdriveID)
                        <img src="https://lh3.googleusercontent.com/d/{{ $report->iconGdriveID }}"
                             alt="{{ $report->reportName }}"
                             class="rp-card-img" loading="lazy">
                    @else
                        <div class="rp-card-img-fallback">
                            <i class="fas fa-file-alt"></i>
                        </div>
                    @endif
                </a>

                {{-- Body --}}
                <div class="rp-card-body">
                    <h3 class="rp-card-title">
                        <a href="{{ $report->node ?? '#' }}"
                           @if($report->node) target="_blank" rel="noopener" @endif>{{ $report->reportName }}</a>
                    </h3>
                    @if($report->description)
                    <p class="rp-card-desc">{{ $report->description }}</p>
                    @endif

                    <a href="{{ $report->node ?? '#' }}" class="rp-read-btn"
                       @if($report->node) target="_blank" rel="noopener" @endif>
                        <span>Baca Laporan</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>

                    @if($report->node)
                    <div class="rp-card-share">
                        <span class="rp-card-share-label">Bagikan</span>
                        <div class="rp-card-share-row">
                            <button class="rp-card-share-btn rp-card-share-copy"
                                    onclick="rpCopyUrl('{{ $report->node }}', event)">
                                <i class="fas fa-link"></i><span>Salin URL</span>
                            </button>
                            <button class="rp-card-share-btn rp-card-share-wa"
                                    onclick="rpShareWa('{{ $report->node }}', '{{ e($report->reportName) }}', event)">
                                <i class="fab fa-whatsapp"></i><span>WhatsApp</span>
                            </button>
                        </div>
                    </div>
                    @endif
                </div>

            </div>
            @endforeach
        </div>
    @endif
</div>

{{-- ── Mobile List (d-lg-none) ──────────────────────────────────── --}}
<div class="d-lg-none">
    @if($reports->isEmpty())
        <div class="rp-empty-state">
            <div class="rp-empty-visual">
                <div class="rp-empty-deco rp-empty-deco-1"></div>
                <div class="rp-empty-deco rp-empty-deco-2"></div>
                <div class="rp-empty-icon-wrap">
                    <i class="fas fa-folder-open"></i>
                    <span class="rp-empty-sparkle rp-empty-sparkle-1">✨</span>
                    <span class="rp-empty-sparkle rp-empty-sparkle-2">📄</span>
                </div>
            </div>
            <h4 class="rp-empty-title">Belum Ada Laporan</h4>
            <p class="rp-empty-sub">Laporan akan ditampilkan di sini setelah diterbitkan</p>
        </div>
    @else
        <div class="rp-mobile-list">
            @foreach($reports as $report)
            @php $accent = $cardColors[$loop->index % count($cardColors)]; @endphp
            <div class="rp-m-list-card"
                 style="--rp-accent: {{ $accent }}"
                 data-id="{{ $report->reportID }}"
                 data-title="{{ e($report->reportName) }}"
                 data-desc="{{ e($report->description ?? '') }}"
                 data-image="{{ $report->iconGdriveID ?? '' }}"
                 data-node="{{ e($report->node ?? '') }}"
                 onclick="rpOpenBottomSheet(this)">

                <div class="rp-m-thumb">
                    @if($report->iconGdriveID)
                        <img src="https://lh3.googleusercontent.com/d/{{ $report->iconGdriveID }}"
                             alt="{{ $report->reportName }}" loading="lazy">
                    @else
                        <div class="rp-m-thumb-fallback">
                            <i class="fas fa-file-alt"></i>
                        </div>
                    @endif
                </div>

                <div class="rp-m-info">
                    <h4 class="rp-m-title">{{ $report->reportName }}</h4>
                    @if($report->description)
                    <p class="rp-m-desc">{{ Str::limit($report->description, 80) }}</p>
                    @endif
                    <span class="rp-m-hint"><i class="fas fa-hand-pointer"></i> Lihat detail</span>
                </div>

                <div class="rp-m-arrow">
                    <i class="fas fa-chevron-right"></i>
                </div>

            </div>
            @endforeach
        </div>
    @endif
</div>

{{-- ── Pagination ─────────────────────────────────────────────── --}}
<div class="rp-pagination-wrap mt-4">
    @include('components.pagination-custom.index', [
        'paginator' => $reports,
        'itemLabel' => 'laporan',
    ])
</div>
