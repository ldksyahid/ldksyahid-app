<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $label }}</title>
    <style>
        @page { margin: 0; }
        body { margin: 0; color: #000; font-family: "Times New Roman", DejaVu Serif, serif; font-size: 12px; line-height: 1.25; }
        .page-bg { position: fixed; top: 0; left: 0; width: 210mm; height: 297mm; z-index: -1; }
        .content { position: absolute; top: 53mm; left: 25mm; right: 25mm; }
        .meta { width: 164mm; margin: 0 0 12px -4mm; border-collapse: collapse; }
        .meta td { padding: 0 0 2px 0; vertical-align: top; }
        .meta-label { width: 22mm; }
        .meta-sep { width: 4mm; }
        .date-cell { text-align: right; white-space: nowrap; }
        
        .title { margin: 20px 0 15px; text-align: center; }
        .title h2 { display: inline-block; font-size: 14px; margin: 0; padding-bottom: 2px; text-transform: uppercase; border-bottom: 1.5px solid #000; }
        
        p { margin: 0 0 6px 0; text-align: justify; }
        .salam { font-weight: bold; font-style: italic; }
        .indent { text-indent: 9mm; }
        
        .field-table { width: 100%; margin: 10px 0 15px; border-collapse: collapse; }
        .field-table td { padding: 3px 0; vertical-align: top; }
        .field-table .label { width: 40mm; font-weight: 600; }
        .field-table .sep { width: 5mm; }

        .signature-wrap { width: 66mm; margin: 15px 0 10px auto; page-break-inside: avoid; }
        .signature-box { width: 100%; border-collapse: collapse; }
        .signature-box td { text-align: center; border: none; padding: 0; }
        .signature-space { height: 26mm; text-align: center; }
        .signature-qr { margin-top: 2mm; }
        .signature-qr img { width: 18mm; height: 18mm; }
        
        .verification { width: 72mm; margin-top: 15px; border: .5px solid #36aaa1; border-collapse: collapse; color: #333; font-family: DejaVu Sans, sans-serif; font-size: 7px; page-break-inside: avoid; }
        .verification td { padding: 3px; vertical-align: middle; }
        .verification .qr-cell { width: 16mm; text-align: center; }
        .verification img { width: 15mm; height: 15mm; }
        .verification p { margin: 0 0 2px; line-height: 1.25; text-align: left; }
        .verification-url { word-break: break-all; }
    </style>
</head>
<body>
@php
    $templatePath = public_path('assets/persuratan/kop-ldk.png');
    $templateUri = file_exists($templatePath)
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($templatePath))
        : null;

    $labels = [
        'nama_acara' => 'Nama Acara', 'tema_acara' => 'Tema Acara', 'hari_tanggal' => 'Tanggal',
        'waktu' => 'Waktu', 'tempat' => 'Tempat', 'ditujukan_kepada' => 'Ditujukan Kepada',
    ];

    $formatValue = function ($key, $value) {
        if ($key === 'hari_tanggal' && !empty($value)) {
            try { return \Carbon\Carbon::parse($value)->locale('id')->translatedFormat('d F Y'); } 
            catch (\Exception $e) { return $value; }
        }
        return $value;
    };
@endphp

@if ($templateUri)
    <img class="page-bg" src="{{ $templateUri }}" alt="">
@endif

<div class="content">
    <table class="meta">
        <tr>
            <td class="meta-label">Nomor</td>
            <td class="meta-sep">:</td>
            <td>{{ $nomorSurat }}</td>
            <td class="date-cell">Jakarta, {{ $tanggalSurat }}</td>
        </tr>
        <tr>
            <td>Hal</td>
            <td>:</td>
            <td colspan="2"><strong>{{ $label }}</strong></td>
        </tr>
    </table>

    <div class="title">
        <h2>{{ $label }}</h2>
    </div>

    <p class="salam">Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>
    
    <p class="indent">
        Dengan hormat, melalui surat ini LDK Syahid UIN Syarif Hidayatullah Jakarta
        menyampaikan dokumen resmi dengan rincian sebagai berikut:
    </p>

    <table class="field-table">
        @foreach ($data as $key => $value)
            @continue($key === 'jenis_surat')
            <tr>
                <td class="label">{{ $labels[$key] ?? ucwords(str_replace('_', ' ', $key)) }}</td>
                <td class="sep">:</td>
                <td>{!! nl2br(e($formatValue($key, $value))) !!}</td>
            </tr>
        @endforeach
    </table>

    <p class="indent">
        Demikian surat ini kami sampaikan untuk dipergunakan sebagaimana mestinya.
        Atas perhatian dan kerja sama yang baik, kami ucapkan terima kasih.
    </p>

    <p class="salam">Wassalamu'alaikum Warahmatullahi Wabarakatuh.</p>

    <div class="signature-wrap">
        <table class="signature-box">
            <tr>
                <td>
                    <strong>Mengetahui,</strong><br>
                    Ketua Umum LDK Syahid
                    <div class="signature-space">
                        <div class="signature-qr">
                            <img src="{!! $qrCode !!}" alt="QR Verifikasi">
                        </div>
                    </div>
                    <strong>Muhammad Syauqi Mubarak</strong><br>
                    NIM. 11230600000067
                </td>
            </tr>
        </table>
    </div>

    <table class="verification">
        <tr>
            <td class="qr-cell"><img src="{!! $qrCode !!}" alt="QR Verifikasi"></td>
            <td>
                <p><strong>Verifikasi Keaslian Dokumen</strong></p>
                <p>Pindai QR code atau kunjungi tautan berikut untuk memastikan surat ini tercatat di sistem LDK Syahid.</p>
                <p class="verification-url">{{ $verifikasiUrl }}</p>
                <p>Kode Verifikasi: <strong>{{ $kodeVerifikasi }}</strong></p>
            </td>
        </tr>
    </table>
</div>
</body>
</html>