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
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            color: #1a2332;
            background-color: #ffffff;
            margin: 0; padding: 0;
        }

        /* ── Outer wrapper ── */
        .wrap {
            width: 700px;
            margin: 0 auto;
            border: 1px solid #cccccc;
            border-radius: 14px;
            overflow: hidden;
        }

        /* ════════ HEADER ════════ */
        .hdr {
            background-color: #00a79d;
            padding: 0;
        }
        .hdr table { width: 100%; border-collapse: collapse; }
        .hdr-left  { padding: 16px 20px; vertical-align: middle; }
        .hdr-right { padding: 16px 20px; vertical-align: middle; text-align: right; }

        .hdr-logo  { width: 44px; height: 44px; vertical-align: middle; background-color: #ffffff; border: 2px solid rgba(255,255,255,0.6); border-radius: 10px; padding: 3px; }
        .hdr-org   { vertical-align: middle; padding-left: 10px; }
        .hdr-org-name { font-size: 14px; font-weight: bold; color: #ffffff; }
        .hdr-org-sub  { font-size: 9px; color: #e0f7f5; margin-top: 2px; }

        .hdr-tag   {
            font-size: 8px; font-weight: bold; color: #e0f7f5;
            letter-spacing: 2px; text-transform: uppercase;
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 20px;
            padding: 2px 8px;
        }
        .hdr-title { font-size: 22px; font-weight: bold; color: #ffffff; margin-top: 4px; }
        .hdr-sub   { font-size: 9px; color: #e0f7f5; margin-top: 2px; }

        /* ════════ META STRIP ════════ */
        .meta { background-color: #e8faf8; border-bottom: 1px solid #b2f0eb; }
        .meta table { width: 100%; border-collapse: collapse; }
        .meta td { padding: 8px 14px; border-right: 1px solid #b2f0eb; vertical-align: top; }
        .meta td:last-child { border-right: none; }
        .meta-lbl { font-size: 7px; font-weight: bold; color: #6b7280; text-transform: uppercase; letter-spacing: 1px; }
        .meta-val { font-size: 10px; font-weight: bold; color: #1a2332; margin-top: 2px; }
        .pill {
            font-size: 9px; font-weight: bold;
            padding: 2px 8px;
            border: 1px solid;
            border-radius: 20px;
        }

        /* ════════ BODY ════════ */
        .body-pad { padding: 16px 20px 12px; }

        /* Section heading */
        .sec-hdr { margin-bottom: 8px; margin-top: 16px; }
        .sec-hdr:first-child { margin-top: 0; }
        .sec-hdr table { width: 100%; border-collapse: collapse; }
        .sec-hdr td { vertical-align: middle; padding: 0; }
        .sec-icon {
            width: 22px; height: 22px;
            background-color: #00a79d;
            border-radius: 6px;
            color: #ffffff; font-size: 8px; font-weight: bold;
            text-align: center; vertical-align: middle;
            padding-top: 5px;
        }
        .sec-lbl { font-size: 8px; font-weight: bold; color: #00a79d; text-transform: uppercase; letter-spacing: 1.5px; padding-left: 7px; white-space: nowrap; }
        .sec-line td { border-bottom: 1px solid #ccecea; }

        /* Campaign */
        .campaign-box {
            background-color: #e8faf8;
            border: 1px solid #99ddd9;
            border-radius: 10px;
            padding: 10px 12px;
            margin-bottom: 2px;
        }
        .campaign-name { font-size: 13px; font-weight: bold; color: #1a2332; margin-bottom: 6px; }
        .tag-wrap { margin-top: 4px; }
        .tag {
            font-size: 8px; font-weight: bold;
            color: #007a73; background-color: #c8f0ec;
            border: 1px solid #99ddd9;
            border-radius: 20px;
            padding: 1px 7px; margin-right: 4px;
        }

        /* Fields layout (two-column using table) */
        .fields { width: 100%; border-collapse: collapse; }
        .fields td { vertical-align: top; padding: 3px; }
        .field-box {
            background-color: #f5f5f5;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 7px 10px;
        }
        .field-lbl { font-size: 7px; font-weight: bold; color: #9ca3af; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 3px; }
        .field-val { font-size: 11px; font-weight: bold; color: #1a2332; }

        /* Payment table */
        .pay-wrap { border: 1px solid #ccecea; border-radius: 10px; overflow: hidden; }
        .pay-tbl { width: 100%; border-collapse: collapse; }
        .pay-tbl td { padding: 9px 14px; border-bottom: 1px solid #ccecea; vertical-align: middle; }
        .pay-tbl tr:last-child td { border-bottom: none; }
        .pay-tbl tr.alt td { background-color: #f0fdfc; }
        .pay-tbl tr.total td { background-color: #00a79d; }
        .pay-lbl   { font-size: 12px; color: #374151; }
        .pay-sub   { font-size: 9px; color: #9ca3af; margin-top: 2px; }
        .pay-val   { font-size: 12px; font-weight: bold; color: #1a2332; text-align: right; }
        .pay-lbl-t { font-size: 9px; font-weight: bold; color: #e0f7f5; text-transform: uppercase; letter-spacing: 1px; }
        .pay-val-t { font-size: 15px; font-weight: bold; color: #ffffff; text-align: right; }

        /* Message */
        .msg-box {
            background-color: #fefce8;
            border: 1px solid #fde68a;
            border-radius: 8px;
            padding: 9px 12px;
            font-size: 11px; color: #374151;
            line-height: 1.6; font-style: italic;
        }

        /* Org info */
        .org-tbl { width: 100%; border-collapse: collapse; }
        .org-tbl td { vertical-align: top; padding-right: 16px; width: 50%; }
        .org-tbl td:last-child { padding-right: 0; }
        .org-lbl  { font-size: 7px; font-weight: bold; color: #9ca3af; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .org-text { font-size: 10px; color: #374151; line-height: 1.8; }

        /* ════════ FOOTER ════════ */
        .footer {
            background-color: #f5f5f5;
            border-top: 1px solid #e0e0e0;
            padding: 10px 20px 14px;
        }
        .footer table { width: 100%; border-collapse: collapse; }
        .footer td { vertical-align: bottom; }
        .footer td:last-child { text-align: center; width: 150px; }
        .disclaimer  { font-size: 8px; color: #9ca3af; line-height: 1.7; font-style: italic; }
        .print-info  { font-size: 7px; color: #c0c0c0; margin-top: 4px; }
        .sign-box    { height: 50px; border-bottom: 1px solid #cccccc; margin-bottom: 4px; }
        .sign-lbl    { font-size: 8px; color: #9ca3af; }

        /* ════════ PRINT ════════ */
        @media print {
            body { background-color: #ffffff; }
            .wrap { border: none; width: 100%; margin: 0; }
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
                    <div class="meta-val" style="font-size:8px; word-break:break-all">{{ $donation->id }}</div>
                </td>
                <td>
                    <div class="meta-lbl">Tanggal Donasi</div>
                    <div class="meta-val" style="font-size:9px">{{ $donationDate }}</div>
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
        <div class="sec-hdr">
            <table>
                <tr>
                    <td style="width:22px"><div class="sec-icon">C</div></td>
                    <td style="width:1px"><span class="sec-lbl">Informasi Campaign</span></td>
                    <td class="sec-line"><table width="100%"><tr><td></td></tr></table></td>
                </tr>
            </table>
        </div>
        <div class="campaign-box">
            <div class="campaign-name">{{ $campaign->judul }}</div>
            <div class="tag-wrap">
                @if($campaign->kategori)<span class="tag">Kategori: {{ $campaign->kategori }}</span>@endif
                @if($location)<span class="tag">Lokasi: {{ $location }}</span>@endif
                @if($campaign->target_biaya)<span class="tag">Target: {{ LFC::formatRupiah($campaign->target_biaya) }}</span>@endif
                @if($deadlineStr)<span class="tag">Deadline: {{ $deadlineStr }}</span>@endif
            </div>
        </div>

        {{-- Donor Info --}}
        <div class="sec-hdr">
            <table>
                <tr>
                    <td style="width:22px"><div class="sec-icon">D</div></td>
                    <td style="width:1px"><span class="sec-lbl">Informasi Donatur</span></td>
                    <td class="sec-line"><table width="100%"><tr><td></td></tr></table></td>
                </tr>
            </table>
        </div>
        <table class="fields">
            <tr>
                <td colspan="2">
                    <div class="field-box">
                        <div class="field-lbl">Nama Lengkap</div>
                        <div class="field-val">{{ $donation->nama_donatur }}</div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="field-box">
                        <div class="field-lbl">Email</div>
                        <div class="field-val">{{ $donation->email_donatur ?: '—' }}</div>
                    </div>
                </td>
                <td style="width:50%">
                    <div class="field-box">
                        <div class="field-lbl">Nomor Kontak</div>
                        <div class="field-val">{{ $donation->no_telp_donatur ?: '—' }}</div>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="width:50%">
                    <div class="field-box">
                        <div class="field-lbl">Usia</div>
                        <div class="field-val">{{ $donation->usia ? $donation->usia . ' tahun' : '—' }}</div>
                    </div>
                </td>
                <td style="width:50%">
                    <div class="field-box">
                        <div class="field-lbl">Domisili</div>
                        <div class="field-val">{{ $donation->domisili ?: '—' }}</div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="field-box">
                        <div class="field-lbl">Pekerjaan</div>
                        <div class="field-val">{{ $donation->pekerjaan ?: '—' }}</div>
                    </div>
                </td>
            </tr>
        </table>

        {{-- Pesan --}}
        @if($donation->pesan_donatur)
        <div class="sec-hdr" style="margin-top:14px">
            <table>
                <tr>
                    <td style="width:22px"><div class="sec-icon">P</div></td>
                    <td style="width:1px"><span class="sec-lbl">Pesan Donatur</span></td>
                    <td class="sec-line"><table width="100%"><tr><td></td></tr></table></td>
                </tr>
            </table>
        </div>
        <div class="msg-box">&ldquo;{{ $donation->pesan_donatur }}&rdquo;</div>
        @endif

        {{-- Payment --}}
        <div class="sec-hdr">
            <table>
                <tr>
                    <td style="width:22px"><div class="sec-icon">Rp</div></td>
                    <td style="width:1px"><span class="sec-lbl">Rincian Pembayaran</span></td>
                    <td class="sec-line"><table width="100%"><tr><td></td></tr></table></td>
                </tr>
            </table>
        </div>
        <div class="pay-wrap">
        <table class="pay-tbl">
            <tr class="alt">
                <td class="pay-lbl">Jumlah Donasi</td>
                <td class="pay-val">{{ LFC::formatRupiah($donation->jumlah_donasi) }}</td>
            </tr>
            @if($hasBiayaAdmin)
            <tr>
                <td>
                    <div class="pay-lbl">Biaya Admin</div>
                    @if($paymentMethod)<div class="pay-sub">{{ $paymentMethod }}</div>@endif
                </td>
                <td class="pay-val">{{ LFC::formatRupiah($donation->biaya_admin) }}</td>
            </tr>
            @else
            <tr>
                <td class="pay-lbl">Metode Pembayaran</td>
                <td class="pay-val" style="font-size:11px; font-weight:normal; color:#374151">
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

        {{-- Org --}}
        <div class="sec-hdr">
            <table>
                <tr>
                    <td style="width:22px"><div class="sec-icon">O</div></td>
                    <td style="width:1px"><span class="sec-lbl">Penyelenggara</span></td>
                    <td class="sec-line"><table width="100%"><tr><td></td></tr></table></td>
                </tr>
            </table>
        </div>
        <table class="org-tbl">
            <tr>
                <td>
                    <div class="org-lbl">Alamat</div>
                    <div class="org-text">
                        Gedung Student Center Lantai 3<br>
                        Ruang LDK Syahid<br>
                        UIN Syarif Hidayatullah Jakarta
                    </div>
                </td>
                <td>
                    <div class="org-lbl">Kontak Resmi</div>
                    <div class="org-text">
                        UKM LDK Syahid<br>
                        ldk.ormawa@apps.uinjkt.ac.id<br>
                        www.ldksyah.id
                    </div>
                </td>
            </tr>
        </table>

    </div>{{-- /body --}}

    {{-- FOOTER --}}
    <div class="footer">
        <table>
            <tr>
                <td>
                    <div class="disclaimer">
                        * Bukti pembayaran yang sah yang dikeluarkan oleh UKM LDK Syahid<br>
                        UIN Syarif Hidayatullah Jakarta. Dokumen ini berlaku sebagai bukti<br>
                        penerimaan donasi resmi dari program Celengan Syahid.
                    </div>
                    <div class="print-info">Dicetak pada: {{ $printDate }}</div>
                </td>
                <td>
                    <div class="sign-box"></div>
                    <div class="sign-lbl">Tanda Tangan Pengelola</div>
                </td>
            </tr>
        </table>
    </div>

</div>{{-- /wrap --}}

<script>
    window.onafterprint = window.close;
    window.print();
</script>
</body>
</html>
