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
@include('landing-page.service.celengan-syahid.components._donation-status._donation-status-styles')
@endsection


{{-- ══════════════════════════════════════════════════
     CONTENT
     ══════════════════════════════════════════════════ --}}
@section('content')

<section class="ds-page py-5 mt-5">
    <div class="container" style="max-width: 600px;">

        {{-- ── Status Banner ─────────────────────────────────── --}}
        <div class="ds-status-banner {{ $statusClass }} wow fadeInDown" data-wow-delay="0.05s">
            <div class="ds-status-icon">
                <i class="{{ $statusIcon }}"></i>
            </div>
            <h1 class="ds-status-title">{{ $statusTitle }}</h1>
            <p class="ds-status-sub">{{ $statusSub }}</p>
        </div>

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
            <div class="ds-action-wrap two-col">
                <a href="{{ url('/celengansyahid/simpan-bukti/' . $campaign->link . '/' . $data->id) }}"
                   target="_blank"
                   class="ds-btn ds-btn-success">
                    <i class="fas fa-download"></i> Simpan Bukti
                </a>
                <a href="{{ route('service.celengansyahid') }}" class="ds-btn ds-btn-outline">
                    <i class="fas fa-home"></i> Kembali
                </a>
            </div>

            @elseif($isPending)
            <div class="ds-action-wrap">
                <a href="{{ url('/celengansyahid/payment/' . $data->id) }}"
                   target="_blank"
                   class="ds-btn ds-btn-primary">
                    <i class="fas fa-credit-card"></i> Bayar Sekarang
                </a>
                <button type="button" class="ds-btn ds-btn-gray" onclick="location.reload()">
                    <i class="fas fa-sync-alt"></i> Muat Ulang Halaman
                </button>
            </div>

            @else
            <div class="ds-action-wrap">
                <a href="{{ url('/celengansyahid/payment/' . $data->id) }}"
                   target="_blank"
                   class="ds-btn ds-btn-primary">
                    <i class="fas fa-credit-card"></i> Coba Bayar Lagi
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
{{-- no additional scripts needed --}}
@endsection
