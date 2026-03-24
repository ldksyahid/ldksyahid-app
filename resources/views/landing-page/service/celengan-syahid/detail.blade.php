@extends('landing-page.template.body')

@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
    use Carbon\Carbon;

    $donationTotal = 0;
    $donorCount    = 0;
    foreach ($data->donation as $d) {
        if ($d->payment_status === 'PAID') {
            $donationTotal += (int) $d->jumlah_donasi;
            $donorCount++;
        }
    }
    $percent          = (float) number_format(LFC::persentaseBiayaTerkumpul($donationTotal, $data->target_biaya), 1, '.', '');
    $isDeadlinePassed = strtotime($data->deadline) < time();
    $daysLeft         = LFC::countdownHari($data->deadline);
    $coverSrc         = $data->gdrive_id
                            ? 'https://lh3.googleusercontent.com/d/' . $data->gdrive_id
                            : 'https://lh3.googleusercontent.com/d/13hUNUJ_oQhmBGMRx37dj380dOhlsKm7O';
    $logoSrc          = $data->gdrive_id_1
                            ? 'https://lh3.googleusercontent.com/d/' . $data->gdrive_id_1
                            : 'https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1';
    $orgName          = ($data->nama_pj && $data->link_pj) ? $data->nama_pj : 'UKM LDK Syahid';
    $orgLink          = ($data->nama_pj && $data->link_pj) ? $data->link_pj : 'https://www.ldksyah.id/';
    $waText           = urlencode(
        "🚨 *[CELENGAN SYAHID]* 🚨\n\n_*{$data->judul}*_\n\n_" . url('/celengansyahid/' . $data->link) . "_\n\nYuk teman-teman kita bantu saudara kita 😇\n\n_\"Dan berbuat-baiklah kepada kedua orang tua, karib-kerabat, anak-anak yatim, orang-orang miskin, tetangga dekat dan tetangga jauh, teman sejawat, ibnu sabil dan hamba sahaya yang kamu miliki. Sungguh, Allah tidak menyukai orang yang sombong dan membanggakan diri,\" ● (QS. An-Nisa 4: Ayat 36)_\n\n#CelenganSyahid\n#{$data->link}\n#UKMLDKSyahid\n#KitaAdalahSaudara\n#Bismillah"
    );
@endphp


{{-- ══════════════════════════════════════════════════
     OPEN GRAPH
     ══════════════════════════════════════════════════ --}}
@section('openGraph')
<meta property="og:title"       content="{{ $data->judul }}" />
<meta property="og:type"        content="website" />
<meta property="og:url"         content="{{ url()->current() }}" />
<meta property="og:image"       content="{{ $coverSrc }}" />
<meta property="og:description" content="{{ substr(strip_tags($data->cerita), 0, 160) }}" />
<meta property="og:image:alt"   content="{{ $data->judul }}" />
@endsection


{{-- ══════════════════════════════════════════════════
     STYLES
     ══════════════════════════════════════════════════ --}}
@section('styles')
@include('landing-page.service.celengan-syahid.components._detail._detail-styles')
@endsection


{{-- ══════════════════════════════════════════════════
     CONTENT
     ══════════════════════════════════════════════════ --}}
@section('content')

<section class="cd-page py-5 mt-5">
    <div class="container cd-page-content">

        {{-- ── Main Grid: Image + Info Panel ──────────────────── --}}
        <div class="row g-4 align-items-start wow fadeInUp" data-wow-delay="0.1s">

            {{-- Image Column --}}
            <div class="col-lg-7">
                <div class="cd-hero-img-wrap">
                    <img src="{{ $coverSrc }}" alt="{{ $data->judul }}" class="cd-hero-img" loading="eager">
                </div>
            </div>

            {{-- Info Panel Column --}}
            <div class="col-lg-5">
                <div class="cd-info-panel">

                    {{-- Category Badge --}}
                    <span class="cd-cat-badge">
                        <i class="fas fa-tag"></i> {{ $data->kategori }}
                    </span>

                    {{-- Title --}}
                    <h1 class="cd-title">{{ $data->judul }}</h1>

                    {{-- Org --}}
                    <div class="cd-org-row">
                        <img src="{{ $logoSrc }}" alt="{{ $orgName }}" class="cd-org-logo">
                        <div class="cd-org-info">
                            <span class="cd-org-label">Diselenggarakan oleh</span>
                            <a href="{{ $orgLink }}" target="_blank" class="cd-org-name">{{ $orgName }}</a>
                        </div>
                    </div>

                    {{-- Amount + Donors --}}
                    <div class="cd-stats-top">
                        <span class="cd-amount">{{ LFC::formatRupiah($donationTotal) }}</span>
                        <span class="cd-donor-chip">
                            <i class="fas fa-users"></i> {{ $donorCount }} Donatur
                        </span>
                    </div>

                    {{-- Progress --}}
                    <div>
                        <div class="cd-progress-track">
                            <div class="cd-progress-fill" style="width: {{ min($percent, 100) }}%"></div>
                        </div>
                        <div class="cd-progress-meta">
                            <span class="cd-progress-pct">{{ number_format($percent, 0) }}% tercapai</span>
                            <span class="cd-progress-target">Target {{ LFC::formatRupiah($data->target_biaya) }}</span>
                        </div>
                    </div>

                    {{-- Deadline --}}
                    <div class="cd-deadline-row">
                        <i class="far fa-clock"></i>
                        @if($isDeadlinePassed)
                            <span>Campaign telah berakhir</span>
                            <span class="cd-days-badge ended">{{ $daysLeft }}</span>
                        @else
                            <span>Sisa waktu</span>
                            <span class="cd-days-badge">{{ $daysLeft }}</span>
                        @endif
                    </div>

                    {{-- Actions — desktop only --}}
                    <div class="cd-action-row d-none d-lg-flex">
                        @if($isDeadlinePassed)
                        <span class="cd-btn-donate cd-btn-ended">
                            <i class="fas fa-times-circle"></i> Campaign Berakhir
                        </span>
                        @else
                        <a href="{{ route('service.celengansyahid.detail.donatenow', $data->link) }}" class="cd-btn-donate">
                            <i class="fas fa-heart"></i> Donasi Sekarang
                        </a>
                        @endif
                        <div class="cd-share-row">
                            <span class="cd-share-label">Bagikan:</span>
                            <button class="cd-share-btn cd-share-copy" onclick="cdCopyUrl(event)" title="Salin URL">
                                <i class="fas fa-link"></i> Salin
                            </button>
                            <a href="https://api.whatsapp.com/send?text={{ $waText }}" target="_blank"
                               class="cd-share-btn cd-share-wa" title="Bagikan via WhatsApp">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>{{-- /row --}}


        {{-- ── Tabs ─────────────────────────────────────────────── --}}
        <div class="cd-tabs-wrap wow fadeInUp" data-wow-delay="0.15s">
            <nav class="cd-tabs-nav" role="tablist">
                <button class="cd-tab active" data-target="cd-pane-story" type="button" role="tab">
                    Detail
                </button>
                <button class="cd-tab" data-target="cd-pane-updates" type="button" role="tab">
                    Kabar Terbaru
                </button>
                <button class="cd-tab" data-target="cd-pane-donors" type="button" role="tab">
                    Donatur
                    <span class="cd-tab-badge">{{ $donorCount }}</span>
                </button>
            </nav>

            {{-- Detail Pane --}}
            <div id="cd-pane-story" class="cd-tab-pane active">
                <div class="cd-tab-body">
                    <div class="cd-story-content">
                        {!! $data->cerita !!}
                    </div>
                </div>
            </div>

            {{-- Latest Updates Pane --}}
            <div id="cd-pane-updates" class="cd-tab-pane">
                <div class="cd-tab-body">
                    @if($data->kabar_terbaru)
                        <div class="cd-updates-content">
                            {!! $data->kabar_terbaru !!}
                        </div>
                    @else
                        <div class="cd-no-update">
                            <i class="far fa-newspaper"></i>
                            <p>Campaign ini belum memiliki kabar terbaru</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Donatur Pane --}}
            <div id="cd-pane-donors" class="cd-tab-pane">
                <div class="cd-tab-body">
                    @if($donorCount > 0)
                        <div class="cd-donor-list">
                            @foreach($data->donation as $donation)
                                @if($donation->payment_status === 'PAID')
                                <div class="cd-donor-item">
                                    <div class="cd-donor-avatar">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="cd-donor-info">
                                        <p class="cd-donor-name">{{ $donation->nama_donatur }}</p>
                                        <span class="cd-donor-amount">{{ LFC::formatRupiah($donation->jumlah_donasi) }}</span>
                                        @if($donation->pesan_donatur)
                                            <p class="cd-donor-msg">{{ $donation->pesan_donatur }}</p>
                                        @endif
                                    </div>
                                    <span class="cd-donor-time">{{ $donation->created_at->diffForHumans() }}</span>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="cd-no-donors">
                            <i class="fas fa-hand-holding-heart"></i>
                            <p>Campaign ini belum memiliki donatur</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>{{-- /cd-tabs-wrap --}}

        <div class="my-3 wow fadeInUp" data-wow-delay="0.15s">
            {{-- ── Back Link ──────────────────────────────────────── --}}
            <a href="{{ route('service.celengansyahid') }}" class="cd-back-link wow fadeIn" data-wow-delay="0.05s">
                <span class="cd-back-icon"><i class="fas fa-arrow-left"></i></span>
                <span>Kembali ke Celengan Syahid</span>
            </a>
        </div>

    </div>{{-- /container --}}
</section>


{{-- ── Mobile Sticky Donate Footer (d-lg-none) ──────────────────── --}}
<div class="cd-mobile-footer d-lg-none">
    <a href="{{ route('service.celengansyahid') }}" class="cd-mobile-back-btn" title="Kembali ke Celengan Syahid">
        <i class="fas fa-arrow-left"></i>
    </a>
    @if($isDeadlinePassed)
    <span class="cd-mobile-donate-btn cd-btn-ended">
        <i class="fas fa-times-circle"></i> Campaign Berakhir
    </span>
    @else
    <a href="{{ route('service.celengansyahid.detail.donatenow', $data->link) }}" class="cd-mobile-donate-btn">
        <i class="fas fa-heart"></i> Donasi Sekarang
    </a>
    @endif
</div>

@endsection


{{-- ══════════════════════════════════════════════════
     SCRIPTS
     ══════════════════════════════════════════════════ --}}
@section('scripts')
@include('landing-page.service.celengan-syahid.components._detail._detail-scripts')
@endsection
