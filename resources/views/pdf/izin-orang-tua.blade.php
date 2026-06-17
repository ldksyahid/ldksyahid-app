<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $label }}</title>
    <style>
        @page { margin: 0; }

        body {
            margin: 0; color: #000;
            font-family: "Times New Roman", DejaVu Serif, serif;
            font-size: 12px; line-height: 1.25;
        }

        .page-bg {
            position: fixed; top: 0; left: 0;
            width: 210mm; height: 297mm; z-index: -1;
        }

        .content {
            position: absolute;
            top: 53mm; /* Jarak dari atas kertas (sesuaikan dengan tinggi kop PNG) */
            left: 25mm; right: 25mm;
        }

        .meta {
            width: 164mm; margin: 0 0 12px -4mm;
            border-collapse: collapse;
        }
        .meta td { padding: 0 0 2px 0; vertical-align: top; }
        .meta-label { width: 22mm; }
        .meta-sep { width: 4mm; }
        .date-cell { text-align: right; white-space: nowrap; }

        .recipient { margin: 12px 0 15px 19mm; }
        .recipient p { margin: 0; }

        p { margin: 0 0 6px 0; text-align: justify; }
        .salam { font-weight: bold; font-style: italic; }
        .indent { text-indent: 9mm; }

        .identity {
            width: 130mm;
            margin: 5px auto 10px auto; /* Posisi di tengah */
            border-collapse: collapse;
        }
        .identity td { padding: 2px 0; vertical-align: top; }
        .identity-label { width: 35mm; }
        .identity-sep { width: 4mm; }

        /* Tanda Tangan */
        .signature-wrap {
            width: 66mm;
            margin: 10px 0 10px auto; /* Rata Kanan */
            page-break-inside: avoid;
        }
        .signature-box { width: 100%; border-collapse: collapse; }
        .signature-box td { text-align: center; border: none; padding: 0; } /* Tanpa border untuk surat biasa */
        .signature-space { height: 26mm; }

        /* Verifikasi */
        .verification {
            width: 72mm; margin-top: 10px;
            border: .5px solid #36aaa1; border-collapse: collapse;
            color: #333; font-family: DejaVu Sans, sans-serif;
            font-size: 7px; page-break-inside: avoid;
        }
        .verification td { padding: 3px; vertical-align: middle; }
        .verification .qr-cell { width: 16mm; }
        .verification svg { width: 15mm; height: 15mm; }
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
            <td colspan="2">1 (satu) halaman</td>
        </tr>
        <tr>
            <td>Hal</td>
            <td>:</td>
            <td colspan="2"><strong>Permohonan Izin Orang Tua</strong></td>
        </tr>
    </table>

    <div class="recipient">
        <p>Yth.</p>
        <p><strong>Orang Tua/Wali Kader LDK Syahid</strong></p>
        <p>di Tempat</p>
    </div>

    <p class="salam">Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>

    <p class="indent">
        Teriring do'a dan harapan semoga Bapak/Ibu/Wali dalam keadaan sehat wal 'afiat serta berkah
        dalam menjalankan aktivitas sehari-hari.
    </p>

    <p class="indent">
        Sehubungan dengan pelaksanaan <strong>{{ $data['nama_acara'] ?? '-' }}</strong> dengan tema
        &ldquo;{{ $data['tema_acara'] ?? '-' }}&rdquo; yang dilaksanakan oleh pengurus UKM Lembaga Dakwah
        Kampus (LDK) Syahid UIN Syarif Hidayatullah Jakarta, yang InsyaAllah akan dilaksanakan pada:
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
        Maka kami memohon kepada Bapak/Ibu/Wali Mahasiswa/i agar bersedia memberikan izin kepada putra-putrinya
        untuk dapat mengikuti kegiatan tersebut.
    </p>

    <p class="indent">
        Demikian permohonan ini kami sampaikan. Atas perhatian dan bantuannya, kami ucapkan terima kasih.
    </p>

    <p class="salam">Wassalamu'alaikum Warahmatullahi Wabarakatuh.</p>

    <div class="signature-wrap">
        <table class="signature-box">
            <tr>
                <td>
                    <strong>Ketua Umum LDK Syahid</strong>
                    <div class="signature-space"></div>
                    <strong>Muhammad Syauqi Mubarak</strong><br>
                    NIM. 11230600000067
                </td>
            </tr>
        </table>
    </div>

    <table class="verification">
        <tr>
            <td class="qr-cell">{!! $qrCode !!}</td>
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