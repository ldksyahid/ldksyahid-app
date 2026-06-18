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
        .meta { 
            width: 100%; 
            margin: 0 0 12px 0; /* Sebelumnya: margin: 0 0 12px -4mm; */
            border-collapse: collapse; 
        }
        .meta td { padding: 0 0 2px 0; vertical-align: top; }
        .meta-label { width: 22mm; }
        .meta-sep { width: 4mm; }
        .date-cell { text-align: right; white-space: nowrap; }
        .recipient { 
            margin: 5px 0 15px 0; /* Sebelumnya: margin: 12px 0 15px 19mm; */
        }
        .recipient p { margin: 0; }
        p { margin: 0 0 6px 0; text-align: justify; }
        .salam { font-weight: bold; font-style: italic; }
        .indent { text-indent: 9mm; }
        .identity { width: 130mm; margin: 5px auto 10px auto; border-collapse: collapse; }
        .identity td { padding: 2px 0; vertical-align: top; }
        .identity-label { width: 35mm; }
        .identity-sep { width: 4mm; }
        .signature-wrap { width: 66mm; margin: 10px 0 10px auto; page-break-inside: avoid; }
        .signature-box { width: 100%; border-collapse: collapse; }
        .signature-box td { text-align: center; border: none; padding: 0; }
        .signature-space { height: 26mm; text-align: center; }
        .signature-qr { margin-top: 2mm; }
        .signature-qr img { width: 18mm; height: 18mm; }
        .verification { width: 72mm; margin-top: 10px; border: .5px solid #36aaa1; border-collapse: collapse; color: #333; font-family: DejaVu Sans, sans-serif; font-size: 7px; page-break-inside: avoid; }
        .verification td { padding: 3px; vertical-align: middle; }
        .verification .qr-cell { width: 16mm; text-align: center;}
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

    $hariTanggal = !empty($data['hari_tanggal'])
        ? \Carbon\Carbon::parse($data['hari_tanggal'])->locale('id')->translatedFormat('l, d F Y')
        : '-';

    $isInternal = ($data['jenis_undangan'] ?? 'eksternal') === 'internal';

    $salamPembuka = $isInternal
        ? "Teriring do'a dan harapan semoga Saudara/i dalam keadaan sehat wal 'afiat serta berkah dalam menjalankan aktivitas sehari-hari."
        : "Teriring do'a dan harapan semoga Bapak/Ibu/Saudara/i dalam keadaan sehat wal 'afiat serta berkah dalam menjalankan aktivitas sehari-hari.";

    $sasaranUndangan = $isInternal ? 'Saudara/i' : 'Bapak/Ibu/Saudara/i';
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
            <td>Lampiran</td>
            <td>:</td>
            <td colspan="2">-</td>
        </tr>
        <tr>
            <td>Hal</td>
            <td>:</td>
            <td colspan="2"><strong>Undangan Kegiatan</strong></td>
        </tr>
    </table>

    <div class="recipient">
        <p>Yth.</p>
        <p><strong>{{ $data['ditujukan_kepada'] ?? $sasaranUndangan }}</strong></p>
        <p>di Tempat</p>
    </div>

    <p class="salam">Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>

    <p class="indent">{{ $salamPembuka }}</p>

    <p class="indent">
        Sehubungan dengan akan diadakannya kegiatan <strong>{{ $data['nama_acara'] ?? '-' }}</strong> yang mengusung tema
        &ldquo;{{ $data['tema_acara'] ?? '-' }}&rdquo; oleh UKM Lembaga Dakwah Kampus (LDK) Syahid, kami bermaksud mengundang {{ $sasaranUndangan }} untuk dapat hadir pada:
    </p>

    <table class="identity">
        <tr>
            <td class="identity-label">Hari, Tanggal</td>
            <td class="identity-sep">:</td>
            <td>{{ $hariTanggal }}</td>
        </tr>
        <tr>
            <td>Waktu</td>
            <td>:</td>
            <td>{{ $data['waktu'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Tempat</td>
            <td>:</td>
            <td>{{ $data['tempat'] ?? '-' }}</td>
        </tr>
    </table>

    <p class="indent">
        Kehadiran dan partisipasi dari {{ $sasaranUndangan }} sangat kami harapkan guna menyemarakkan dan mendukung kesuksesan kegiatan tersebut.
    </p>

    <p class="indent">
        Demikian surat undangan ini kami sampaikan. Atas perhatian dan kesediaan waktunya, kami ucapkan jazakumullah khairan katsiran.
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