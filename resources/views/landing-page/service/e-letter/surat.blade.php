
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $label }}</title>
@include('pdf.components._index-styles')
    <style>
        /* Tabel field generik */
        .field-table { width: 100%; margin: 8pt 0 12pt 0; border-collapse: collapse; }
        .field-table td { padding: 2.5pt 0; vertical-align: top; line-height: 1.15; }
        .field-table .label { width: 44mm; }
        .field-table .sep   { width:  5mm; }
    </style>
</head>
<body>
@php
    $templatePath = public_path('assets/persuratan/kop-ldk.png');
    $templateUri  = file_exists($templatePath)
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($templatePath)) : null;
    $skipKeys     = ['jenis_surat', 'kode_bidang'];
    $labelMap     = [
        'nama_acara'       => 'Nama Acara',
        'tema_acara'       => 'Tema Acara',
        'hari_tanggal'     => 'Tanggal',
        'waktu'            => 'Waktu',
        'tempat'           => 'Tempat',
        'ditujukan_kepada' => 'Ditujukan Kepada',
    ];
    $formatValue = function ($key, $value) {
        if ($key === 'hari_tanggal' && !empty($value)) {
            try { return \Carbon\Carbon::parse($value)->locale('id')->translatedFormat('d F Y'); }
            catch (\Exception $e) { return $value; }
        }
        return $value;
    };
@endphp
@if ($templateUri)<img class="page-bg" src="{{ $templateUri }}" alt="">@endif
<div class="content">
    <table class="meta">
        <tr>
            <td class="meta-label">Nomor</td><td class="meta-sep">:</td>
            <td>{{ $nomorSurat }}</td><td class="date-cell">Jakarta, {{ $tanggalSurat }}</td>
        </tr>
        <tr><td>Hal</td><td>:</td><td colspan="2"><strong>{{ $label }}</strong></td></tr>
    </table>
    <div class="body-surat">
        <p class="salam">Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>
        <p class="indent">Dengan hormat, melalui surat ini LDK Syahid UIN Syarif Hidayatullah Jakarta
            menyampaikan dokumen resmi dengan rincian sebagai berikut:</p>
        <table class="field-table">
            @foreach ($data as $key => $value)
                @continue(in_array($key, $skipKeys))
                <tr>
                    <td class="label">{{ $labelMap[$key] ?? ucwords(str_replace('_', ' ', $key)) }}</td>
                    <td class="sep">:</td>
                    <td>{!! nl2br(e($formatValue($key, $value))) !!}</td>
                </tr>
            @endforeach
        </table>
        <p class="indent">Demikian surat ini kami sampaikan untuk dipergunakan sebagaimana mestinya.
            Atas perhatian dan kerja sama yang baik, kami ucapkan terima kasih.</p>
        <p class="salam-penutup">Wassalamu'alaikum Warahmatullahi Wabarakatuh.</p>
        <table class="signature-table">
            <tr>
                <td class="ttd-cell"><strong>Ketua Umum LDK Syahid</strong></td>
                <td class="ttd-cell"><strong>Sekretaris Jenderal</strong></td>
            </tr>
            <tr>
                <td class="ttd-cell"><div class="ttd-space"><img src="{!! $qrCode !!}" alt="QR"></div></td>
                <td class="ttd-cell"><div class="ttd-space"></div></td>
            </tr>
            <tr>
                <td class="ttd-cell"><strong>Muhammad Syauqi Mubarak</strong></td>
                <td class="ttd-cell"><strong>Muhammad Zhaffar Rabbani</strong></td>
            </tr>
            <tr>
                <td class="ttd-cell">NIM. 11230600000067</td>
                <td class="ttd-cell">NIM. 11230340000016</td>
            </tr>
        </table>
        <table class="verification">
            <tr>
                <td class="qr-cell"><img src="{!! $qrCode !!}" alt="QR"></td>
                <td>
                    <p><strong>Verifikasi Keaslian Dokumen</strong></p>
                    <p>Pindai QR atau buka tautan berikut untuk memastikan surat tercatat di sistem LDK Syahid.</p>
                    <p class="verification-url">{{ $verifikasiUrl }}</p>
                    <p>Kode Verifikasi: <strong>{{ $kodeVerifikasi }}</strong></p>
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>