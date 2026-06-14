@extends('landing-page.template.body')

@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
    use Carbon\Carbon;

    $isPaid    = $data->payment_status === 'PAID';
    $isPending = $data->payment_status === 'PENDING';
    $isFailed  = !$isPaid && !$isPending;

    $statusClass = $isPaid ? 'paid' : ($isPending ? 'pending' : 'failed');
    $statusIcon  = $isPaid ? 'fas fa-check-circle' : ($isPending ? 'fas fa-clock' : 'fas fa-times-circle');
    $statusTitle = $isPaid ? 'Pembayaran Berhasil' : ($isPending ? 'Menunggu Pembayaran' : 'Pembayaran Gagal');
    $statusSub   = $isPaid
                    ? 'Jazakallah khayran, donasi kamu sudah kami terima!'
                    : ($isPending
                        ? 'Silakan selesaikan proses pembayaranmu'
                        : 'Terjadi masalah, silakan coba lagi');

    $paymentTime = Carbon::parse($data->created_at)
                        ->locale('id')
                        ->isoFormat('dddd, D MMMM Y [pukul] HH:mm');
@endphp


{{-- ══════════════════════════════════════════════════
     STYLES
     ══════════════════════════════════════════════════ --}}
@section('styles')
@include('landing-page.service.celengan-syahid.components._payment-status._payment-status-styles')
<style>
    .ds-qris-card { background:#fff; border:1px solid #e6eef0; border-radius:18px; padding:1.5rem; text-align:center; margin-bottom:1.25rem; box-shadow:0 6px 20px rgba(0,0,0,.06); }
    .ds-qris-title { font-weight:700; color:#00a79d; margin-bottom:1rem; }
    .ds-qris-box { display:inline-flex; align-items:center; justify-content:center; min-height:240px; background:#fff; padding:14px; border-radius:14px; }
    .ds-qris-box img, .ds-qris-box canvas { width:240px; height:240px; max-width:100%; background:#fff; filter:none !important; image-rendering:pixelated; }
    .ds-qris-amount { font-size:1.4rem; font-weight:800; color:#00a79d; margin-top:1rem; }
    .ds-qris-hint { font-size:.85rem; color:#6c757d; margin:.5rem 0 0; }
    .ds-qris-expiry { font-size:.82rem; color:#6c757d; margin-top:.5rem; }
    .ds-qris-dl-btn { display:inline-flex; align-items:center; gap:.45rem; margin-top:1rem; padding:.6rem 1.4rem; background:#00a79d; color:#fff; border:none; border-radius:50px; font-size:.875rem; font-weight:600; cursor:pointer; text-decoration:none; transition:background .2s; }
    .ds-qris-dl-btn:hover { background:#008f86; color:#fff; }
    .ds-qris-dl-btn:active { background:#007a72; }
    [data-theme="dark"] .ds-qris-card { background:#1a1f2e; border-color:#252b3b; }
    [data-theme="dark"] .ds-qris-hint, [data-theme="dark"] .ds-qris-expiry { color:#9ca3af; }
    /* QR tile stays white + un-inverted in every theme so scanners read it */
    [data-theme="dark"] .ds-qris-box { background:#fff !important; }
    [data-theme="dark"] .ds-qris-box img, [data-theme="dark"] .ds-qris-box canvas { filter:none !important; background:#fff !important; }
</style>
@endsection


{{-- ══════════════════════════════════════════════════
     CONTENT
     ══════════════════════════════════════════════════ --}}
@section('content')

<section class="ds-page py-5 mt-5">
    <div class="container" style="max-width: 600px;">

        {{-- ── Status Banner ─────────────────────────────────── --}}
        <div id="ds-banner" class="ds-status-banner {{ $statusClass }} wow fadeInDown" data-wow-delay="0.05s">
            <div class="ds-status-icon">
                <i class="{{ $statusIcon }}"></i>
            </div>
            <h1 class="ds-status-title">{{ $statusTitle }}</h1>
            <p class="ds-status-sub">{{ $statusSub }}</p>
            @if($isPending)
            <div id="ds-polling" class="ds-polling-indicator">
                <span class="ds-polling-dot"></span>
                <span>Memeriksa status pembayaran...</span>
            </div>
            @endif
        </div>

        {{-- ── QRIS Payment (pending) ────────────────────────── --}}
        @if($isPending && $data->qr_code)
        <div id="ds-qris-card" class="ds-qris-card wow fadeInUp" data-wow-delay="0.08s">
            <div class="ds-qris-title"><i class="fas fa-qrcode"></i> Scan QRIS untuk Membayar</div>
            <div id="ds-qris" class="ds-qris-box" data-qr="{{ $data->qr_code }}"></div>
            <div class="ds-qris-amount">{{ LFC::formatRupiah($data->jumlah_donasi) }}</div>
            <p class="ds-qris-hint">Buka aplikasi e-wallet atau m-banking apa pun, lalu scan kode di atas.</p>
            @if($data->expired_at)
            <div class="ds-qris-expiry">
                <i class="far fa-clock"></i> Berlaku sampai
                <strong>{{ \Carbon\Carbon::parse($data->expired_at)->locale('id')->isoFormat('D MMM Y, HH:mm') }}</strong>
            </div>
            @endif
            <button id="ds-qris-dl" type="button" class="ds-qris-dl-btn"
                data-amount="{{ LFC::formatRupiah($data->jumlah_donasi) }}"
                data-campaign="{{ $campaign->judul }}"
                data-expiry="{{ $data->expired_at ? \Carbon\Carbon::parse($data->expired_at)->locale('id')->isoFormat('D MMM Y, HH:mm') : '' }}">
                <i class="fas fa-download"></i> Download QR Code
            </button>
        </div>
        @endif

        {{-- ── Payment Detail Card ───────────────────────────── --}}
        <div class="ds-detail-card wow fadeInUp" data-wow-delay="0.1s">
            <div class="ds-detail-header">
                <h2 class="ds-detail-title">
                    <i class="fas fa-receipt"></i> Detail Pembayaran
                </h2>
            </div>
            <div class="ds-detail-body">
                <div class="ds-detail-row">
                    <span class="ds-detail-key">ID Donasi</span>
                    <span class="ds-detail-val">#{{ $data->id }}</span>
                </div>
                <div class="ds-detail-row">
                    <span class="ds-detail-key">Waktu</span>
                    <span class="ds-detail-val">{{ $paymentTime }}</span>
                </div>
                <div class="ds-detail-row">
                    <span class="ds-detail-key">Campaign</span>
                    <span class="ds-detail-val">{{ $campaign->judul }}</span>
                </div>
                <div class="ds-detail-row">
                    <span class="ds-detail-key">Atas Nama</span>
                    <span class="ds-detail-val">{{ $data->nama_donatur }}</span>
                </div>
                <div class="ds-detail-row">
                    <span class="ds-detail-key">Jumlah Donasi</span>
                    <span class="ds-detail-val amount">{{ LFC::formatRupiah($data->jumlah_donasi) }}</span>
                </div>
                <div class="ds-detail-row">
                    <span class="ds-detail-key">Total Pembayaran</span>
                    <span class="ds-detail-val amount">{{ LFC::formatRupiah($data->jumlah_donasi) }}</span>
                </div>
            </div>
        </div>

        {{-- ── Action Buttons ─────────────────────────────────── --}}
        <div class="wow fadeInUp" data-wow-delay="0.14s">

            @if($isPaid)
            <div id="ds-actions" class="ds-action-wrap two-col">
                <a href="{{ route('service.celengansyahid.savePayment', ['link' => $campaign->link, 'id' => $data->id]) }}"
                   class="ds-btn ds-btn-success">
                    <i class="fas fa-download"></i> Simpan Bukti
                </a>
                <a href="{{ route('service.celengansyahid') }}" class="ds-btn ds-btn-outline">
                    <i class="fas fa-home"></i> Kembali
                </a>
            </div>

            @elseif($isPending)
            <div id="ds-actions" class="ds-action-wrap">
                <button type="button" class="ds-btn ds-btn-gray" onclick="location.reload()">
                    <i class="fas fa-sync-alt"></i> Muat Ulang Halaman
                </button>
            </div>

            @else
            <div id="ds-actions" class="ds-action-wrap">
                <a href="{{ route('service.celengansyahid.detail.donatenow', $campaign->link) }}"
                   class="ds-btn ds-btn-primary">
                    <i class="fas fa-redo"></i> Donasi Lagi
                </a>
                <button type="button" class="ds-btn ds-btn-gray" onclick="location.reload()">
                    <i class="fas fa-sync-alt"></i> Muat Ulang Halaman
                </button>
                <a href="{{ route('service.celengansyahid') }}" class="ds-btn ds-btn-outline">
                    <i class="fas fa-arrow-left"></i> Kembali ke Celengan Syahid
                </a>
            </div>
            @endif

        </div>

    </div>
</section>

@endsection


{{-- ══════════════════════════════════════════════════
     SCRIPTS
     ══════════════════════════════════════════════════ --}}
@section('scripts')
@include('landing-page.service.celengan-syahid.components._payment-status._payment-status-scripts')
@endsection
