@php
    use App\Http\Controllers\LibraryFunctionController as LFC;

    $isPaid      = $donation->payment_status === 'PAID';
    $isPending   = $donation->payment_status === 'PENDING';
    $statusLabel = $isPaid ? 'LUNAS' : ($isPending ? 'TERTUNDA' : 'GAGAL');
    $statusColor = $isPaid ? '#15803d' : ($isPending ? '#b45309' : '#b91c1c');
    $statusBg    = $isPaid ? '#eafbf1' : ($isPending ? '#fff8ec' : '#fdf1f1');
    $statusBdr   = $isPaid ? '#c8ecd7' : ($isPending ? '#fbe6bf' : '#f3caca');

    $donationDate = \Carbon\Carbon::parse($donation->created_at)->locale('id')->isoFormat('dddd, D MMMM Y');
    $donationTime = \Carbon\Carbon::parse($donation->created_at)->format('H:i') . ' WIB';
    $printDate    = \Carbon\Carbon::now('Asia/Jakarta')->isoFormat('D MMMM Y') . ' pukul '
                    . \Carbon\Carbon::now('Asia/Jakarta')->format('H:i') . ' WIB';

    $logoUrl = 'https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1';

    $hasBiayaAdmin = !empty($donation->biaya_admin) && (int) $donation->biaya_admin > 0;
    $totalTagihan  = !empty($donation->total_tagihan) ? $donation->total_tagihan
                                                      : $donation->jumlah_donasi;
    $deadlineStr   = $campaign->deadline
                        ? \Carbon\Carbon::parse($campaign->deadline)->locale('id')->isoFormat('D MMMM Y')
                        : null;
    $location      = implode(', ', array_filter([$campaign->kota, $campaign->provinsi]));
    $paymentMethod = implode(' - ', array_filter([$donation->metode_pembayaran, $donation->nama_merchant]));
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bukti Donasi #{{ $donation->id }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #384252;
            background-color: #ffffff;
            margin: 0; padding: 0;
        }

        /* ── Outer wrapper ── */
        .wrap {
            width: 100%;
            border: 1px solid #dceeec;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 130, 120, 0.06);
        }

        /* ════════ HEADER ════════ */
        .hdr {
            background: linear-gradient(120deg, #00a79d 0%, #00877d 100%);
            padding: 0;
        }
        .hdr table { width: 100%; border-collapse: collapse; }
        .hdr-left  { padding: 16px 20px; vertical-align: middle; }
        .hdr-right { padding: 16px 20px; vertical-align: middle; text-align: right; }

        .hdr-logo {
            width: 44px; height: 44px; vertical-align: middle;
            background-color: #ffffff; border-radius: 11px;
            padding: 4px;
        }
        .hdr-org       { vertical-align: middle; padding-left: 11px; }
        .hdr-org-name  { font-size: 13px; font-weight: bold; color: #ffffff; letter-spacing: .3px; }
        .hdr-org-sub   { font-size: 8px; color: #d6f6f2; margin-top: 3px; }

        .hdr-tag {
            display: block;
            font-size: 6.5px; font-weight: bold; color: rgba(255,255,255,0.85);
            letter-spacing: 2px; text-transform: uppercase;
            border: 1px solid rgba(255,255,255,0.4);
            border-radius: 20px; padding: 2px 9px;
            margin-bottom: 5px;
        }
        .hdr-title { font-size: 21px; font-weight: bold; color: #ffffff; line-height: 1.15; }
        .hdr-sub   { font-size: 8px; color: #d6f6f2; margin-top: 2px; letter-spacing: .4px; }

        /* ════════ META STRIP ════════ */
        .meta { background-color: #f3fbfa; }
        .meta table { width: 100%; border-collapse: collapse; }
        .meta td { padding: 8px 16px; border-right: 1px solid #e0f4f2; vertical-align: top; }
        .meta td:last-child { border-right: none; }
        .meta-lbl { font-size: 6.5px; font-weight: bold; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }
        .meta-val { font-size: 9.5px; font-weight: bold; color: #384252; margin-top: 2px; }
        .pill {
            font-size: 8px; font-weight: bold;
            padding: 2px 9px; border: 1px solid;
            border-radius: 20px;
        }

        /* ════════ BODY ════════ */
        .body-pad { padding: 16px 20px 4px; }

        /* Section label — soft minimal, no icon block */
        .sec { font-size: 7.5px; font-weight: bold; color: #00877d; text-transform: uppercase;
               letter-spacing: 1.5px; padding-left: 9px; border-left: 3px solid #00a79d;
               margin: 14px 0 7px; }
        .sec.first { margin-top: 0; }

        /* Soft card base */
        .card {
            background-color: #f9fefd;
            border: 1px solid #e0f4f2;
            border-radius: 10px;
            overflow: hidden;
        }

        /* Campaign */
        .campaign-box { padding: 11px 14px; }
        .campaign-name { font-size: 13px; font-weight: bold; color: #2d3748; margin-bottom: 7px; line-height: 1.35; }
        .tag { font-size: 7.5px; font-weight: bold; color: #00877d; background-color: #e6f7f5;
               border: 1px solid #bfe9e4; border-radius: 20px; padding: 2px 8px; margin-right: 4px;
               white-space: nowrap; display: inline-block; }

        /* Grid card (donor info) */
        .grid-tbl { width: 100%; border-collapse: collapse; }
        .grid-tbl td { padding: 7px 14px; vertical-align: top; border-bottom: 1px solid #eef6f5; width: 50%; }
        .grid-tbl tr:last-child td { border-bottom: none; }
        .grid-tbl td.solo { width: 100%; }
        .grid-tbl td + td { border-left: 1px solid #eef6f5; }
        .g-lbl { font-size: 6.5px; font-weight: bold; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 2px; }
        .g-val { font-size: 10.5px; font-weight: bold; color: #2d3748; }

        /* Message */
        .msg-box {
            background-color: #fdfaf2;
            border: 1px solid #f3e6bf;
            border-radius: 10px;
            padding: 9px 13px;
            font-size: 10px; color: #4a5568;
            line-height: 1.6; font-style: italic;
        }

        /* Payment table */
        .pay-tbl { width: 100%; border-collapse: collapse; }
        .pay-tbl td { padding: 8px 14px; border-bottom: 1px solid #eef6f5; vertical-align: middle; }
        .pay-tbl tr:last-child td { border-bottom: none; }
        .pay-tbl tr.total td { background-color: #e6f7f5; border-top: 2px solid #00a79d; padding: 11px 14px; }
        .pay-lbl   { font-size: 10.5px; color: #4a5568; }
        .pay-sub   { font-size: 8px; color: #94a3b8; margin-top: 1px; }
        .pay-val   { font-size: 10.5px; font-weight: bold; color: #2d3748; text-align: right; }
        .pay-lbl-t { font-size: 8.5px; font-weight: bold; color: #00877d; text-transform: uppercase; letter-spacing: 1.1px; }
        .pay-val-t { font-size: 17px; font-weight: bold; color: #00695f; text-align: right; }

        /* ════════ FOOTER ════════ */
        .footer {
            background-color: #f9fefd;
            border-top: 1px solid #e0f4f2;
            padding: 12px 20px 14px;
        }
        .footer table { width: 100%; border-collapse: collapse; }
        .footer td { vertical-align: top; width: 50%; }
        .f-lbl  { font-size: 6.5px; font-weight: bold; color: #00a79d; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .f-text { font-size: 8.5px; color: #4a5568; line-height: 1.75; }
        .disclaimer { font-size: 7.5px; color: #94a3b8; line-height: 1.7; font-style: italic; margin-top: 9px; border-top: 1px dashed #e0f4f2; padding-top: 8px; }
        .print-info { font-size: 7px; color: #b3c0cc; margin-top: 4px; }

        /* ════════ PRINT ════════ */
        @media print {
            body { background-color: #ffffff; }
            .wrap { border: none; box-shadow: none; }
        }
        @page { size: A4; margin: 12mm 10mm; }
    </style>
</head>
<body>
<div class="wrap">

    {{-- HEADER --}}
    <div class="hdr">
        <table>
            <tr>
                <td class="hdr-left">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="vertical-align:middle">
                                <img src="{{ $logoUrl }}" class="hdr-logo" alt="">
                            </td>
                            <td class="hdr-org">
                                <div class="hdr-org-name">UKM LDK Syahid</div>
                                <div class="hdr-org-sub">UIN Syarif Hidayatullah Jakarta</div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="hdr-right">
                    <div class="hdr-tag">Dokumen Resmi</div>
                    <div class="hdr-title">Bukti Donasi</div>
                    <div class="hdr-sub">Program Celengan Syahid</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- META STRIP --}}
    <div class="meta">
        <table>
            <tr>
                <td>
                    <div class="meta-lbl">No. Donasi</div>
                    <div class="meta-val" style="font-size:7.5px; word-break:break-all">{{ $donation->id }}</div>
                </td>
                <td>
                    <div class="meta-lbl">Tanggal Donasi</div>
                    <div class="meta-val" style="font-size:8.5px">{{ $donationDate }}</div>
                </td>
                <td>
                    <div class="meta-lbl">Waktu</div>
                    <div class="meta-val">{{ $donationTime }}</div>
                </td>
                <td>
                    <div class="meta-lbl">Status Pembayaran</div>
                    <div class="meta-val">
                        <span class="pill"
                              style="color:{{ $statusColor }};background-color:{{ $statusBg }};border-color:{{ $statusBdr }}">
                            {{ $statusLabel }}
                        </span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- BODY --}}
    <div class="body-pad">

        {{-- Campaign --}}
        <div class="sec first">Informasi Campaign</div>
        <div class="card campaign-box">
            <div class="campaign-name">{{ $campaign->judul }}</div>
            <div>
                @if($campaign->kategori)<span class="tag">{{ $campaign->kategori }}</span>@endif
                @if($location)<span class="tag">{{ $location }}</span>@endif
                @if($campaign->target_biaya)<span class="tag">Target {{ LFC::formatRupiah($campaign->target_biaya) }}</span>@endif
                @if($deadlineStr)<span class="tag">s.d. {{ $deadlineStr }}</span>@endif
            </div>
        </div>

        {{-- Donor Info --}}
        <div class="sec">Informasi Donatur</div>
        <div class="card">
            <table class="grid-tbl">
                <tr>
                    <td class="solo" colspan="2">
                        <div class="g-lbl">Nama Lengkap</div>
                        <div class="g-val">{{ $donation->nama_donatur }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="g-lbl">Email</div>
                        <div class="g-val">{{ $donation->email_donatur ?: '—' }}</div>
                    </td>
                    <td>
                        <div class="g-lbl">Nomor Kontak</div>
                        <div class="g-val">{{ $donation->no_telp_donatur ?: '—' }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="g-lbl">Usia</div>
                        <div class="g-val">{{ $donation->usia ? $donation->usia . ' tahun' : '—' }}</div>
                    </td>
                    <td>
                        <div class="g-lbl">Domisili</div>
                        <div class="g-val">{{ $donation->domisili ?: '—' }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="solo" colspan="2">
                        <div class="g-lbl">Pekerjaan</div>
                        <div class="g-val">{{ $donation->pekerjaan ?: '—' }}</div>
                    </td>
                </tr>
            </table>
        </div>

        {{-- Pesan --}}
        @if($donation->pesan_donatur)
        <div class="sec">Pesan Donatur</div>
        <div class="msg-box">&ldquo;{{ $donation->pesan_donatur }}&rdquo;</div>
        @endif

        {{-- Payment --}}
        <div class="sec">Rincian Pembayaran</div>
        <div class="card">
        <table class="pay-tbl">
            <tr>
                <td class="pay-lbl">Jumlah Donasi</td>
                <td class="pay-val">{{ LFC::formatRupiah($donation->jumlah_donasi) }}</td>
            </tr>
            @if($hasBiayaAdmin)
            <tr>
                <td>
                    <div class="pay-lbl">Biaya Layanan QRIS ({{ config('services.bisatopup.qris_mdr_percent', 1) }}%)</div>
                    @if($paymentMethod)<div class="pay-sub">{{ $paymentMethod }}</div>@endif
                </td>
                <td class="pay-val">{{ LFC::formatRupiah($donation->biaya_admin) }}</td>
            </tr>
            @else
            <tr>
                <td class="pay-lbl">Metode Pembayaran</td>
                <td class="pay-val" style="font-size:10px; font-weight:normal; color:#4a5568">
                    {{ $paymentMethod ?: '—' }}
                </td>
            </tr>
            @endif
            <tr class="total">
                <td class="pay-lbl-t">Total Tagihan</td>
                <td class="pay-val-t">{{ LFC::formatRupiah($totalTagihan) }}</td>
            </tr>
        </table>
        </div>

    </div>{{-- /body --}}

    {{-- FOOTER --}}
    <div class="footer">
        <table>
            <tr>
                <td>
                    <div class="f-lbl">Alamat Penyelenggara</div>
                    <div class="f-text">
                        Gedung Student Center Lantai 3, Ruang LDK Syahid<br>
                        UIN Syarif Hidayatullah Jakarta
                    </div>
                </td>
                <td>
                    <div class="f-lbl">Kontak Resmi</div>
                    <div class="f-text">
                        UKM LDK Syahid<br>
                        ldk.ormawa@apps.uinjkt.ac.id &middot; www.ldksyah.id
                    </div>
                </td>
            </tr>
        </table>
        <div class="disclaimer">
            * Bukti pembayaran yang sah yang dikeluarkan oleh UKM LDK Syahid UIN Syarif Hidayatullah Jakarta.
            Dokumen ini berlaku sebagai bukti penerimaan donasi resmi dari program Celengan Syahid.
        </div>
        <div class="print-info">Dicetak pada: {{ $printDate }}</div>
    </div>

</div>{{-- /wrap --}}

<script>
    window.onafterprint = window.close;
    window.print();
</script>
</body>
</html>
