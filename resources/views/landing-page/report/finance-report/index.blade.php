@extends('landing-page.template.body')


{{-- ══════════════════════════════════════════════════
     STYLES
     ══════════════════════════════════════════════════ --}}
@section('styles')
@include('landing-page.report.finance-report.components._index-styles')
@endsection


{{-- ══════════════════════════════════════════════════
     CONTENT
     ══════════════════════════════════════════════════ --}}
@section('content')

<section class="fr-page-section py-5 wow fadeIn mt-5" data-wow-delay="0.1s">

    {{-- ── Hero Jumbotron ─────────────────────────────────────────── --}}
    <x-hero-jumbotron type="quran">
        <div class="hero-slide">
            <img class="hero-image"
                 src="https://lh3.googleusercontent.com/d/1wOvUz3jq66UwdPduMGiW4RUML9JMV-nC"
                 alt="Laporan Keuangan LDK Syahid" />
        </div>
    </x-hero-jumbotron>


    {{-- ── Main Container ─────────────────────────────────────────── --}}
    <div class="container mt-5" id="fr-main">

        {{-- Section Header --}}
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="fr-section-badge">
                <span>💰</span>
                <span>Laporan Keuangan</span>
                <span class="fr-badge-pulse"></span>
            </div>
            <h2 class="fr-section-title mt-3">Laporan Keuangan LDK Syahid</h2>
            <p class="fr-section-sub">Transparansi dan akuntabilitas pengelolaan keuangan LDK Syahid</p>
        </div>

        {{-- ── Info Card (Features) ────────────────────────────── --}}
        <div class="fr-info-card wow fadeInUp mb-5" data-wow-delay="0.15s">
            <div class="fr-features-grid">
                <div class="fr-feature-item">
                    <div class="fr-feature-icon"><i class="fas fa-hand-holding-usd"></i></div>
                    <div class="fr-feature-text">
                        <span class="fr-feature-title">Transparansi Keuangan</span>
                        <span class="fr-feature-sub">Seluruh laporan keuangan diungkapkan secara terbuka dan transparan</span>
                    </div>
                </div>
                <div class="fr-feature-item">
                    <div class="fr-feature-icon"><i class="fas fa-balance-scale"></i></div>
                    <div class="fr-feature-text">
                        <span class="fr-feature-title">Akuntabilitas Publik</span>
                        <span class="fr-feature-sub">Pertanggungjawaban penggunaan dana organisasi kepada anggota</span>
                    </div>
                </div>
                <div class="fr-feature-item">
                    <div class="fr-feature-icon"><i class="fas fa-calendar-check"></i></div>
                    <div class="fr-feature-text">
                        <span class="fr-feature-title">Periodik dan Teratur</span>
                        <span class="fr-feature-sub">Diterbitkan secara berkala sesuai periode anggaran</span>
                    </div>
                </div>
                <div class="fr-feature-item">
                    <div class="fr-feature-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                    <div class="fr-feature-text">
                        <span class="fr-feature-title">Standar Akuntansi</span>
                        <span class="fr-feature-sub">Mengikuti standar akuntansi yang berlaku dan dapat dipertanggungjawabkan</span>
                    </div>
                </div>
            </div>
            <p class="fr-info-desc">
                Laporan keuangan UKM LDK Syahid merupakan bentuk pertanggungjawaban publik atas
                pengelolaan dana organisasi. Setiap laporan mencakup realisasi anggaran, arus kas,
                dan posisi keuangan yang telah melalui proses audit internal untuk memastikan
                keakuratan dan kredibilitas informasi.
            </p>
        </div>

        {{-- ── LDK Accordion ─────────────────────────────────────── --}}
        @php
            $groupedReports = $reports->groupBy('ldkID');
            $sortedLdks     = [];
            foreach ($groupedReports as $ldkID => $ldkReports) {
                if ($ldkReports->first() && $ldkReports->first()->ldk) {
                    $ldk          = $ldkReports->first()->ldk;
                    $ldkName      = $ldk->ldkName;
                    $logoGdriveID = $ldk->logoGdriveID;
                } else {
                    $ldkName      = 'LDK Tidak Diketahui';
                    $logoGdriveID = null;
                }
                $sortedLdks[$ldkID] = [
                    'name'    => $ldkName,
                    'logo'    => $logoGdriveID,
                    'reports' => $ldkReports,
                    'count'   => $ldkReports->count(),
                ];
            }
            uasort($sortedLdks, fn($a, $b) => strcmp($a['name'], $b['name']));
        @endphp

        @if(!empty($sortedLdks))
        <div class="fr-accordion wow fadeInUp" data-wow-delay="0.15s">

            @foreach($sortedLdks as $ldkID => $ldkData)
            @php $collapseId = 'fr-collapse-' . $ldkID; @endphp

            <div class="fr-acc-item">

                {{-- LDK Header Button --}}
                <button class="fr-acc-btn collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#{{ $collapseId }}"
                        aria-expanded="false"
                        aria-controls="{{ $collapseId }}">
                    <div class="fr-acc-left">
                        <div class="fr-acc-logo">
                            @if($ldkData['logo'])
                                <img src="https://lh3.googleusercontent.com/d/{{ $ldkData['logo'] }}"
                                     alt="{{ $ldkData['name'] }}" loading="lazy">
                            @else
                                <i class="fas fa-university"></i>
                            @endif
                        </div>
                        <div class="fr-acc-info">
                            <span class="fr-acc-name">{{ $ldkData['name'] }}</span>
                            <span class="fr-acc-count">
                                <i class="fas fa-file-pdf"></i>
                                {{ $ldkData['count'] }} laporan
                            </span>
                        </div>
                    </div>
                    <i class="fas fa-chevron-down fr-acc-chevron"></i>
                </button>

                {{-- Collapsible Report List --}}
                <div class="collapse" id="{{ $collapseId }}">
                    <div class="fr-report-list">
                        @foreach($ldkData['reports'] as $report)
                        @php
                            $rDate = $report->createdDate
                                ? \Carbon\Carbon::parse($report->createdDate)
                                : null;
                        @endphp
                        <div class="fr-report-item">

                            {{-- Left: icon + info --}}
                            <div class="fr-report-left">
                                <div class="fr-report-icon">
                                    <i class="fas fa-file-pdf"></i>
                                </div>
                                <div class="fr-report-info">
                                    <span class="fr-report-name">{{ $report->fileName }}</span>
                                    @if($rDate)
                                    <span class="fr-report-date">
                                        <i class="far fa-calendar-alt"></i>
                                        Diunggah {{ $rDate->isoFormat('D MMM Y') }}
                                    </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Right: action + share buttons --}}
                            <div class="fr-report-right">
                                <div class="fr-report-btns">
                                    <a href="{{ $report->fileViewUrl() }}" target="_blank" rel="noopener"
                                       class="fr-action-btn fr-action-view">
                                        <i class="fas fa-eye"></i>
                                        <span>Lihat</span>
                                    </a>
                                    <a href="{{ $report->fileUrl() }}" target="_blank" rel="noopener"
                                       class="fr-action-btn fr-action-download">
                                        <i class="fas fa-download"></i>
                                        <span>Unduh</span>
                                    </a>
                                    <button class="fr-action-btn fr-share-copy"
                                            data-url="{{ $report->fileViewUrl() }}"
                                            onclick="frCopyUrl(this.dataset.url, event)">
                                        <i class="fas fa-link"></i>
                                        <span>Salin URL</span>
                                    </button>
                                </div>
                            </div>

                        </div>{{-- /fr-report-item --}}
                        @endforeach
                    </div>{{-- /fr-report-list --}}
                </div>{{-- /collapse --}}

            </div>{{-- /fr-acc-item --}}
            @endforeach

        </div>{{-- /fr-accordion --}}

        @else

        {{-- Empty State --}}
        <div class="fr-empty wow fadeInUp" data-wow-delay="0.2s">
            <div class="fr-empty-icon">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
            <h4 class="fr-empty-title">Belum ada laporan keuangan</h4>
            <p class="fr-empty-sub">Laporan keuangan akan diunggah sesuai periode yang ditentukan</p>
        </div>

        @endif

    </div>{{-- /container --}}
</section>

@endsection


{{-- ══════════════════════════════════════════════════
     SCRIPTS
     ══════════════════════════════════════════════════ --}}
@section('scripts')
@include('landing-page.report.finance-report.components._index-scripts')
@endsection
