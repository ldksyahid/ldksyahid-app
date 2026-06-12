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
                @if($data->payment_link)
                <a href="{{ route('service.celengansyahid.detail.donateNow.gateway', $data->id) }}"
                   target="_blank"
                   class="ds-btn ds-btn-primary">
                    <i class="fas fa-credit-card"></i> Bayar Sekarang
                </a>
                @endif
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
@if($isPending)
{{-- Render the QRIS code: image when the gateway returns a URL/data-uri,
     otherwise generate it locally from the raw QRIS payload string. --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
(function () {
    var box = document.getElementById('ds-qris');
    if (!box) return;
    var raw = box.getAttribute('data-qr') || '';
    if (!raw) return;

    if (/^https?:\/\//i.test(raw) || /^data:image\//i.test(raw)) {
        var img = document.createElement('img');
        img.src = raw;
        img.alt = 'QRIS';
        box.appendChild(img);
    } else {
        try {
            new QRCode(box, { text: raw, width: 240, height: 240, correctLevel: QRCode.CorrectLevel.M });
        } catch (e) {
            box.innerHTML = '<div style="font-size:.75rem;color:#6c757d;word-break:break-all;">' + raw + '</div>';
        }
    }
})();
</script>
<script>
(function () {
    var CHECK_URL  = @json(route('service.celengansyahid.api.checkPayment', $data->id));
    var SAVE_URL   = @json(route('service.celengansyahid.savePayment', ['link' => $campaign->link, 'id' => $data->id]));
    var PAY_URL    = @json(route('service.celengansyahid.detail.donatenow', $campaign->link));
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
            var qrCardPaid = document.getElementById('ds-qris-card');
            if (qrCardPaid) qrCardPaid.style.display = 'none';

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
            var qrCardFailed = document.getElementById('ds-qris-card');
            if (qrCardFailed) qrCardFailed.style.display = 'none';

            actions.className = 'ds-action-wrap';
            actions.innerHTML =
                '<a href="' + PAY_URL + '" class="ds-btn ds-btn-primary">' +
                    '<i class="fas fa-redo"></i> Donasi Lagi' +
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
