@php
    use App\Http\Controllers\LibraryFunctionController as LFC;

    $isPaid      = $donation->payment_status === 'PAID';
    $isPending   = $donation->payment_status === 'PENDING';
    $statusLabel = $isPaid ? 'LUNAS' : ($isPending ? 'TERTUNDA' : 'GAGAL');
    $statusColor = $isPaid ? '#16a34a' : ($isPending ? '#d97706' : '#dc2626');
    $statusBg    = $isPaid ? '#dcfce7' : ($isPending ? '#fef3c7' : '#fee2e2');
    $statusBdr   = $isPaid ? '#bbf7d0' : ($isPending ? '#fde68a' : '#fecaca');

    $donationDate = \Carbon\Carbon::parse($donation->created_at)->locale('id')->isoFormat('dddd, D MMMM Y');
    $donationTime = \Carbon\Carbon::parse($donation->created_at)->format('H:i') . ' WIB';
    $printDate    = \Carbon\Carbon::now('Asia/Jakarta')->isoFormat('D MMMM Y · H:i') . ' WIB';

    $logoUrl = 'https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1';

    $hasBiayaAdmin = !empty($donation->biaya_admin) && (int) $donation->biaya_admin > 0;
    $totalTagihan  = !empty($donation->total_tagihan) ? $donation->total_tagihan
                                                      : $donation->jumlah_donasi;
    $deadlineStr   = $campaign->deadline
                        ? \Carbon\Carbon::parse($campaign->deadline)->locale('id')->isoFormat('D MMMM Y')
                        : null;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bukti Donasi #{{ $donation->id }}</title>
    <link rel="icon" href="{{ $logoUrl }}" type="image/x-icon" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DejaVu Sans', 'Helvetica Neue', Arial, sans-serif;
            background: #eef2f7;
            color: #1a2332;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* ── Page wrapper ── */
        .dp-wrap { max-width: 760px; margin: 2rem auto; }
        .dp-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 12px 50px rgba(0,0,0,.13);
        }

        /* ════════════════ HEADER ════════════════ */
        .dp-header {
            background: linear-gradient(135deg, #006b65 0%, #00a79d 45%, #00c9bc 80%, #2ed8cd 100%);
            padding: 1.75rem 2.25rem;
            display: flex; align-items: center; justify-content: space-between;
            position: relative; overflow: hidden;
            -webkit-print-color-adjust: exact; print-color-adjust: exact;
        }
        .dp-hd1 { position:absolute; top:-50px; right:-50px; width:200px; height:200px; background:rgba(255,255,255,.07); border-radius:50%; }
        .dp-hd2 { position:absolute; bottom:-80px; left:35%; width:260px; height:260px; background:rgba(255,255,255,.04); border-radius:50%; }
        .dp-hd3 { position:absolute; top:10px; left:45%; width:80px; height:80px; background:rgba(255,255,255,.05); border-radius:50%; }

        .dp-brand { display:flex; align-items:center; gap:.875rem; position:relative; z-index:1; }
        .dp-logo-ring {
            width:60px; height:60px;
            background:rgba(255,255,255,.22); border-radius:16px;
            display:flex; align-items:center; justify-content:center;
            padding:6px; flex-shrink:0; border:1.5px solid rgba(255,255,255,.3);
        }
        .dp-logo-ring img { width:100%; height:100%; object-fit:contain; border-radius:10px; }
        .dp-org-name { font-size:1.05rem; font-weight:800; color:#fff; line-height:1.2; }
        .dp-org-sub  { font-size:.72rem; color:rgba(255,255,255,.8); margin-top:.15rem; }

        .dp-doc-badge { text-align:right; position:relative; z-index:1; }
        .dp-doc-tag {
            display:inline-block;
            background:rgba(255,255,255,.18); border:1px solid rgba(255,255,255,.3);
            color:rgba(255,255,255,.9); font-size:.58rem; font-weight:700;
            letter-spacing:2.5px; text-transform:uppercase;
            padding:.22rem .7rem; border-radius:20px; margin-bottom:.4rem;
        }
        .dp-doc-title { font-size:1.75rem; font-weight:900; color:#fff; line-height:1.05; letter-spacing:-.5px; }
        .dp-doc-sub   { font-size:.7rem; color:rgba(255,255,255,.75); margin-top:.15rem; }

        /* ════════════════ META STRIP ════════════════ */
        .dp-meta {
            display:flex; background:#f0fdfc;
            border-bottom:1.5px solid #b2f0eb;
        }
        .dp-meta-item {
            flex:1; padding:.75rem 1.25rem;
            border-right:1px solid #b2f0eb;
        }
        .dp-meta-item:last-child { border-right:none; }
        .dp-meta-label { font-size:.58rem; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:1.2px; margin-bottom:.18rem; }
        .dp-meta-value { font-size:.8rem; font-weight:700; color:#1a2332; }

        .dp-status-pill {
            display:inline-flex; align-items:center; gap:.3rem;
            padding:.2rem .65rem; border-radius:20px;
            font-size:.7rem; font-weight:700;
        }
        .dp-status-dot { width:5px; height:5px; border-radius:50%; flex-shrink:0; }

        /* ════════════════ BODY ════════════════ */
        .dp-body { padding:1.75rem 2.25rem 1.25rem; }

        /* Section header */
        .dp-sec {
            display:flex; align-items:center; gap:.5rem;
            margin-bottom:.875rem; margin-top:1.5rem;
        }
        .dp-sec:first-child { margin-top:0; }
        .dp-sec-icon {
            width:26px; height:26px;
            background:linear-gradient(135deg,#00a79d,#00c9bc);
            border-radius:7px;
            display:flex; align-items:center; justify-content:center;
            font-size:.75rem; flex-shrink:0;
        }
        .dp-sec-label { font-size:.62rem; font-weight:700; color:#00a79d; text-transform:uppercase; letter-spacing:1.5px; }
        .dp-sec-line   { flex:1; height:1px; background:#e0f7f5; }

        /* Campaign card */
        .dp-campaign {
            background:linear-gradient(135deg,#e8fbf9 0%,#f0fdfc 100%);
            border:1.5px solid rgba(0,167,157,.2);
            border-radius:14px; padding:1rem 1.25rem;
            position:relative; overflow:hidden;
            margin-bottom:.25rem;
        }
        .dp-campaign::before {
            content:''; position:absolute; top:0; left:0;
            width:4px; height:100%;
            background:linear-gradient(180deg,#00a79d,#00c9bc);
            border-radius:4px 0 0 4px;
        }
        .dp-campaign-name { font-size:.95rem; font-weight:800; color:#1a2332; line-height:1.35; padding-left:.25rem; margin-bottom:.5rem; }
        .dp-campaign-tags { display:flex; flex-wrap:wrap; gap:.375rem; padding-left:.25rem; }
        .dp-campaign-tag {
            display:inline-flex; align-items:center; gap:.25rem;
            background:rgba(0,167,157,.1); color:#007a73;
            font-size:.65rem; font-weight:600;
            padding:.18rem .6rem; border-radius:20px;
        }

        /* Info grid */
        .dp-grid { display:grid; grid-template-columns:1fr 1fr; gap:.625rem; }
        .dp-field {
            background:#f9fafb; border:1px solid #e9ecef;
            border-radius:11px; padding:.75rem 1rem;
        }
        .dp-field.span2 { grid-column:1/-1; }
        .dp-field-label { font-size:.58rem; font-weight:700; color:#9ca3af; text-transform:uppercase; letter-spacing:1px; margin-bottom:.2rem; }
        .dp-field-value { font-size:.85rem; font-weight:600; color:#1a2332; word-break:break-word; }
        .dp-field-empty { color:#d1d5db; font-style:italic; }

        /* Payment breakdown */
        .dp-payment-table {
            width:100%; border-radius:14px; overflow:hidden;
            border:1px solid #e0f7f5;
        }
        .dp-payment-row {
            display:flex; align-items:center; justify-content:space-between;
            padding:.75rem 1.25rem;
            border-bottom:1px solid #e0f7f5;
        }
        .dp-payment-row:last-child { border-bottom:none; }
        .dp-payment-row.total {
            background:linear-gradient(135deg,#006b65,#00a79d 50%,#00c4b8);
            -webkit-print-color-adjust:exact; print-color-adjust:exact;
        }
        .dp-pay-label { font-size:.78rem; color:#374151; font-weight:500; }
        .dp-pay-label-sub { font-size:.65rem; color:#9ca3af; margin-top:.1rem; }
        .dp-pay-value { font-size:.85rem; font-weight:700; color:#1a2332; }
        .dp-payment-row.total .dp-pay-label { color:rgba(255,255,255,.8); font-size:.72rem; text-transform:uppercase; letter-spacing:.8px; }
        .dp-payment-row.total .dp-pay-value { color:#fff; font-size:1.2rem; font-weight:900; }

        /* Message box */
        .dp-msg-box {
            background:#fefce8; border:1px solid #fde68a;
            border-radius:11px; padding:.875rem 1.125rem;
            font-size:.82rem; color:#374151; line-height:1.6;
            font-style:italic;
        }
        .dp-msg-box::before { content:'"'; font-size:1.5rem; color:#d97706; line-height:0; vertical-align:-.3rem; margin-right:.25rem; }
        .dp-msg-box::after  { content:'"'; font-size:1.5rem; color:#d97706; line-height:0; vertical-align:-.3rem; margin-left:.1rem; }

        /* Org info */
        .dp-org-row { display:flex; gap:1.5rem; }
        .dp-org-col { flex:1; }
        .dp-org-col-label { font-size:.6rem; font-weight:700; color:#9ca3af; text-transform:uppercase; letter-spacing:1px; margin-bottom:.3rem; }
        .dp-org-col-text  { font-size:.78rem; color:#374151; line-height:1.7; }

        /* ════════════════ FOOTER ════════════════ */
        .dp-footer {
            background:#f9fafb; border-top:1.5px solid #e9ecef;
            padding:1.125rem 2.25rem 1.375rem;
            display:flex; align-items:flex-end; justify-content:space-between; gap:2rem;
        }
        .dp-disclaimer { flex:1; font-size:.62rem; color:#9ca3af; line-height:1.7; font-style:italic; }
        .dp-print-info  { font-size:.6rem; color:#d1d5db; margin-top:.375rem; }
        .dp-sign { text-align:center; flex-shrink:0; min-width:140px; }
        .dp-sign-box { height:55px; border-bottom:1.5px solid #d1d5db; margin-bottom:.35rem; }
        .dp-sign-label { font-size:.6rem; color:#9ca3af; font-weight:500; }

        /* ════════════════ PRINT ════════════════ */
        @media print {
            body { background:#fff; }
            .dp-wrap { margin:0; max-width:100%; }
            .dp-card { box-shadow:none; border-radius:0; }
            .dp-header, .dp-payment-row.total { -webkit-print-color-adjust:exact; print-color-adjust:exact; }
        }
        @page { size:A4; margin:0; }
    </style>
</head>
<body>
<div class="dp-wrap">
<div class="dp-card">

    {{-- ══ HEADER ══ --}}
    <div class="dp-header">
        <div class="dp-hd1"></div><div class="dp-hd2"></div><div class="dp-hd3"></div>
        <div class="dp-brand">
            <div class="dp-logo-ring"><img src="{{ $logoUrl }}" alt="LDK Syahid"></div>
            <div>
                <div class="dp-org-name">UKM LDK Syahid</div>
                <div class="dp-org-sub">UIN Syarif Hidayatullah Jakarta</div>
            </div>
        </div>
        <div class="dp-doc-badge">
            <div class="dp-doc-tag">Dokumen Resmi</div>
            <div class="dp-doc-title">Bukti<br>Donasi</div>
            <div class="dp-doc-sub">Celengan Syahid</div>
        </div>
    </div>

    {{-- ══ META STRIP ══ --}}
    <div class="dp-meta">
        <div class="dp-meta-item">
            <div class="dp-meta-label">No. Donasi</div>
            <div class="dp-meta-value" style="font-size:.7rem; word-break:break-all">{{ $donation->id }}</div>
        </div>
        <div class="dp-meta-item">
            <div class="dp-meta-label">Tanggal Donasi</div>
            <div class="dp-meta-value" style="font-size:.72rem">{{ $donationDate }}</div>
        </div>
        <div class="dp-meta-item">
            <div class="dp-meta-label">Waktu</div>
            <div class="dp-meta-value">{{ $donationTime }}</div>
        </div>
        <div class="dp-meta-item">
            <div class="dp-meta-label">Status Pembayaran</div>
            <div class="dp-meta-value">
                <span class="dp-status-pill"
                      style="background:{{ $statusBg }};color:{{ $statusColor }};border:1px solid {{ $statusBdr }}">
                    <span class="dp-status-dot" style="background:{{ $statusColor }}"></span>
                    {{ $statusLabel }}
                </span>
            </div>
        </div>
    </div>

    {{-- ══ BODY ══ --}}
    <div class="dp-body">

        {{-- Campaign --}}
        <div class="dp-sec">
            <div class="dp-sec-icon">C</div>
            <div class="dp-sec-label">Informasi Campaign</div>
            <div class="dp-sec-line"></div>
        </div>
        <div class="dp-campaign">
            <div class="dp-campaign-name">{{ $campaign->judul }}</div>
            <div class="dp-campaign-tags">
                @if($campaign->kategori)
                <span class="dp-campaign-tag">Kategori: {{ $campaign->kategori }}</span>
                @endif
                @if($campaign->kota || $campaign->provinsi)
                <span class="dp-campaign-tag">Lokasi: {{ implode(', ', array_filter([$campaign->kota, $campaign->provinsi])) }}</span>
                @endif
                @if($campaign->target_biaya)
                <span class="dp-campaign-tag">Target: {{ LFC::formatRupiah($campaign->target_biaya) }}</span>
                @endif
                @if($deadlineStr)
                <span class="dp-campaign-tag">Deadline: {{ $deadlineStr }}</span>
                @endif
            </div>
        </div>

        {{-- Donor Info --}}
        <div class="dp-sec">
            <div class="dp-sec-icon">D</div>
            <div class="dp-sec-label">Informasi Donatur</div>
            <div class="dp-sec-line"></div>
        </div>
        <div class="dp-grid">
            <div class="dp-field span2">
                <div class="dp-field-label">Nama Lengkap</div>
                <div class="dp-field-value">{{ $donation->nama_donatur }}</div>
            </div>
            <div class="dp-field">
                <div class="dp-field-label">Email</div>
                <div class="dp-field-value">{{ $donation->email_donatur ?: '—' }}</div>
            </div>
            <div class="dp-field">
                <div class="dp-field-label">Nomor Kontak</div>
                <div class="dp-field-value">{{ $donation->no_telp_donatur ?: '—' }}</div>
            </div>
            <div class="dp-field">
                <div class="dp-field-label">Usia</div>
                <div class="dp-field-value">{{ $donation->usia ? $donation->usia . ' tahun' : '—' }}</div>
            </div>
            <div class="dp-field">
                <div class="dp-field-label">Domisili</div>
                <div class="dp-field-value">{{ $donation->domisili ?: '—' }}</div>
            </div>
            <div class="dp-field span2">
                <div class="dp-field-label">Pekerjaan</div>
                <div class="dp-field-value">{{ $donation->pekerjaan ?: '—' }}</div>
            </div>
        </div>

        @if($donation->pesan_donatur)
        <div class="dp-sec" style="margin-top:1rem">
            <div class="dp-sec-icon">P</div>
            <div class="dp-sec-label">Pesan Donatur</div>
            <div class="dp-sec-line"></div>
        </div>
        <div class="dp-msg-box">{{ $donation->pesan_donatur }}</div>
        @endif

        {{-- Payment Details --}}
        <div class="dp-sec">
            <div class="dp-sec-icon">Rp</div>
            <div class="dp-sec-label">Rincian Pembayaran</div>
            <div class="dp-sec-line"></div>
        </div>
        <div class="dp-payment-table">
            <div class="dp-payment-row" style="background:#f8fffe">
                <div>
                    <div class="dp-pay-label">Jumlah Donasi</div>
                </div>
                <div class="dp-pay-value">{{ LFC::formatRupiah($donation->jumlah_donasi) }}</div>
            </div>
            @if($hasBiayaAdmin)
            <div class="dp-payment-row">
                <div>
                    <div class="dp-pay-label">Biaya Admin</div>
                    @if($donation->metode_pembayaran || $donation->nama_merchant)
                    <div class="dp-pay-label-sub">
                        {{ implode(' — ', array_filter([$donation->metode_pembayaran, $donation->nama_merchant])) }}
                    </div>
                    @endif
                </div>
                <div class="dp-pay-value">{{ LFC::formatRupiah($donation->biaya_admin) }}</div>
            </div>
            @else
            <div class="dp-payment-row">
                <div>
                    <div class="dp-pay-label">Metode Pembayaran</div>
                </div>
                <div class="dp-pay-value" style="font-size:.8rem; color:#374151; font-weight:500">
                    {{ implode(' — ', array_filter([$donation->metode_pembayaran, $donation->nama_merchant])) ?: '—' }}
                </div>
            </div>
            @endif
            <div class="dp-payment-row total">
                <div>
                    <div class="dp-pay-label">Total Tagihan</div>
                </div>
                <div class="dp-pay-value">{{ LFC::formatRupiah($totalTagihan) }}</div>
            </div>
        </div>

        {{-- Org Info --}}
        <div class="dp-sec">
            <div class="dp-sec-icon">O</div>
            <div class="dp-sec-label">Penyelenggara</div>
            <div class="dp-sec-line"></div>
        </div>
        <div class="dp-org-row">
            <div class="dp-org-col">
                <div class="dp-org-col-label">Alamat</div>
                <div class="dp-org-col-text">
                    Gedung Student Center Lantai 3<br>
                    Ruang LDK Syahid<br>
                    UIN Syarif Hidayatullah Jakarta
                </div>
            </div>
            <div class="dp-org-col">
                <div class="dp-org-col-label">Kontak Resmi</div>
                <div class="dp-org-col-text">
                    UKM LDK Syahid<br>
                    ldk.ormawa@apps.uinjkt.ac.id<br>
                    www.ldksyah.id
                </div>
            </div>
        </div>

    </div>{{-- /dp-body --}}

    {{-- ══ FOOTER ══ --}}
    <div class="dp-footer">
        <div>
            <div class="dp-disclaimer">
                * Bukti pembayaran yang sah yang dikeluarkan oleh UKM LDK Syahid UIN Syarif Hidayatullah Jakarta.<br>
                Dokumen ini berlaku sebagai bukti penerimaan donasi resmi dari program Celengan Syahid.
            </div>
            <div class="dp-print-info">Dicetak pada: {{ $printDate }}</div>
        </div>
        <div class="dp-sign">
            <div class="dp-sign-box"></div>
            <div class="dp-sign-label">Tanda Tangan Pengelola</div>
        </div>
    </div>

</div>{{-- /dp-card --}}
</div>{{-- /dp-wrap --}}

<script>
    window.onafterprint = window.close;
    window.print();
</script>
</body>
</html>
