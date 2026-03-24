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
            <div id="ds-actions" class="ds-action-wrap">
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
            <div id="ds-actions" class="ds-action-wrap">
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
@if($isPending)
<script>
(function () {
    var CHECK_URL  = @json(url('/celengansyahid/api/check-payment/' . $data->id));
    var SAVE_URL   = @json(url('/celengansyahid/simpan-bukti/' . $campaign->link . '/' . $data->id));
    var PAY_URL    = @json(url('/celengansyahid/payment/' . $data->id));
    var HOME_URL   = @json(route('service.celengansyahid'));
    var POLL_MS    = 5000;
    var active     = true;
    var timer      = null;

    function applyTransition(fn) {
        var banner  = document.getElementById('ds-banner');
        var actions = document.getElementById('ds-actions');

        banner.style.transition  = 'opacity .35s ease, transform .35s ease';
        actions.style.transition = 'opacity .35s ease';
        banner.style.opacity     = '0';
        banner.style.transform   = 'translateY(-6px) scale(0.98)';
        actions.style.opacity    = '0';

        setTimeout(function () {
            fn(banner, actions);

            requestAnimationFrame(function () {
                requestAnimationFrame(function () {
                    banner.style.opacity   = '1';
                    banner.style.transform = 'translateY(0) scale(1)';
                    actions.style.opacity  = '1';
                });
            });
        }, 350);
    }

    function transitionToPaid() {
        applyTransition(function (banner, actions) {
            banner.className = 'ds-status-banner paid';
            banner.querySelector('.ds-status-icon').innerHTML = '<i class="fas fa-check-circle"></i>';
            banner.querySelector('.ds-status-title').textContent = 'Pembayaran Berhasil';
            banner.querySelector('.ds-status-sub').textContent   = 'Jazakallah khayran, donasi kamu sudah kami terima!';
            var indicator = document.getElementById('ds-polling');
            if (indicator) indicator.remove();

            actions.className   = 'ds-action-wrap two-col';
            actions.innerHTML   =
                '<a href="' + SAVE_URL + '" target="_blank" class="ds-btn ds-btn-success">' +
                    '<i class="fas fa-download"></i> Simpan Bukti' +
                '</a>' +
                '<a href="' + HOME_URL + '" class="ds-btn ds-btn-outline">' +
                    '<i class="fas fa-home"></i> Kembali' +
                '</a>';
        });
    }

    function transitionToFailed() {
        applyTransition(function (banner, actions) {
            banner.className = 'ds-status-banner failed';
            banner.querySelector('.ds-status-icon').innerHTML = '<i class="fas fa-times-circle"></i>';
            banner.querySelector('.ds-status-title').textContent = 'Pembayaran Gagal';
            banner.querySelector('.ds-status-sub').textContent   = 'Terjadi masalah, silakan coba lagi';
            var indicator = document.getElementById('ds-polling');
            if (indicator) indicator.remove();

            actions.className = 'ds-action-wrap';
            actions.innerHTML =
                '<a href="' + PAY_URL + '" target="_blank" class="ds-btn ds-btn-primary">' +
                    '<i class="fas fa-credit-card"></i> Coba Bayar Lagi' +
                '</a>' +
                '<button type="button" class="ds-btn ds-btn-gray" onclick="location.reload()">' +
                    '<i class="fas fa-sync-alt"></i> Muat Ulang Halaman' +
                '</button>' +
                '<a href="' + HOME_URL + '" class="ds-btn ds-btn-outline">' +
                    '<i class="fas fa-arrow-left"></i> Kembali ke Celengan Syahid' +
                '</a>';
        });
    }

    function poll() {
        if (!active) return;
        fetch(CHECK_URL)
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (!active) return;
                if (data.status === 'PAID' || data.status === 'SETTLED') {
                    active = false;
                    transitionToPaid();
                } else if (data.status === 'FAILED' || data.status === 'EXPIRED') {
                    active = false;
                    transitionToFailed();
                } else {
                    timer = setTimeout(poll, POLL_MS);
                }
            })
            .catch(function () {
                if (active) timer = setTimeout(poll, POLL_MS);
            });
    }

    timer = setTimeout(poll, POLL_MS);
})();
</script>
@endif
@endsection
