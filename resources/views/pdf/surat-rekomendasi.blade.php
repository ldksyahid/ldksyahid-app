<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $label }}</title>
    <style>
        @page { margin: 0; }

        body {
            margin: 0;
            color: #000;
            font-family: "Times New Roman", DejaVu Serif, serif;
            font-size: 12px;
            line-height: 1.22;
        }

        .page-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 210mm;
            height: 297mm;
            z-index: -1;
        }

        .content {
            position: absolute;
            top: 53mm;
            left: 25mm;
            right: 25mm;
        }

        .meta {
            width: 164mm;
            margin: 0 0 12px -4mm;
            border-collapse: collapse;
        }

        .meta td {
            padding: 0 0 1px 0;
            vertical-align: top;
        }

        .meta-label { width: 22mm; }
        .meta-sep { width: 4mm; }

        .date-cell {
            text-align: right;
            white-space: nowrap;
        }

        .recipient {
            margin: 12px 0 10px 19mm;
        }

        .recipient p {
            margin: 0;
        }

        p {
            margin: 0 0 6px 0;
            text-align: justify;
        }

        .salam {
            font-style: italic;
            font-weight: bold;
        }

        .indent {
            text-indent: 9mm;
        }

        .identity {
            width: 112mm;
            margin: 2px 0 7px 30mm;
            border-collapse: collapse;
        }

        .identity td {
            padding: 0;
            vertical-align: top;
        }

        .identity-label { width: 31mm; }
        .identity-sep { width: 4mm; }

        .considerations {
            margin: 0 0 7px 9mm;
            padding-left: 6mm;
        }

        .considerations li {
            margin-bottom: 2px;
            text-align: justify;
        }

        .signature-wrap {
            width: 66mm;
            margin: 2px 12mm 6px auto;
            page-break-inside: avoid;
        }

        .signature-box {
            width: 100%;
            border-collapse: collapse;
        }

        .signature-box td {
            border: 1px solid #000;
            padding: 3px 6px;
            text-align: center;
        }

        .signature-space {
            height: 26mm;
        }

        .verification {
            width: 72mm;
            margin-top: 4px;
            border: .5px solid #36aaa1;
            border-collapse: collapse;
            color: #333;
            font-family: DejaVu Sans, sans-serif;
            font-size: 7px;
            page-break-inside: avoid;
        }

        .verification td {
            padding: 3px;
            vertical-align: middle;
        }

        .verification .qr-cell {
            width: 16mm;
        }

        .verification svg {
            width: 15mm;
            height: 15mm;
        }

        .verification p {
            margin: 0 0 2px;
            line-height: 1.25;
            text-align: left;
        }

        .verification-url {
            word-break: break-all;
        }
    </style>
</head>
<body>
@php
    $templatePath = public_path('assets/persuratan/surat-rekomendasi-header.png');
    $templateUri = file_exists($templatePath)
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($templatePath))
        : null;

    $program = $data['program_rekomendasi'] ?? 'program yang direkomendasikan';

    $pertimbangan = preg_split('/\r\n|\r|\n/', trim($data['pertimbangan'] ?? ''));
    $pertimbangan = array_values(array_filter(array_map(function ($item) {
        return trim(preg_replace('/^\d+[\.\)]\s*/', '', $item));
    }, $pertimbangan)));

    if (empty($pertimbangan)) {
        $pertimbangan = [
            'Mengingat yang bersangkutan merupakan anggota aktif dari UKM LDK Syahid.',
            'Mengingat yang bersangkutan tidak pernah terlibat dalam kegiatan yang terlarang selama menempuh pendidikan di kampus.',
        ];
    }
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
            <td colspan="2"><strong>Rekomendasi</strong></td>
        </tr>
    </table>

    <div class="recipient">
        <p>Yth.</p>
        <p><strong>Pengurus {{ $program }}</strong></p>
        <p>di Tempat</p>
    </div>

    <p class="salam">Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>

    <p class="indent">
        Segala puji bagi Allah Rabb semesta alam dengan rahmat dan karunia yang tak terhingga.
        Shalawat dan salam semoga tetap tercurah kepada Rasulullah SAW., keluarga, sahabat,
        dan para pengikutnya yang setia hingga akhir zaman.
    </p>

    <p class="indent">
        Dengan ini UKM Lembaga Dakwah Kampus Syarif Hidayatullah Jakarta (LDK Syahid)
        memberikan <strong>Rekomendasi</strong> terhadap peserta program
        <strong>{{ $program }}</strong>. Adapun identitas peserta program adalah sebagai berikut:
    </p>

    <table class="identity">
        <tr>
            <td class="identity-label">Nama</td>
            <td class="identity-sep">:</td>
            <td>{{ $data['nama'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>NIM</td>
            <td>:</td>
            <td>{{ $data['nim'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Fakultas</td>
            <td>:</td>
            <td>{{ $data['fakultas'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Jurusan</td>
            <td>:</td>
            <td>{{ $data['jurusan'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Bidang Jabatan</td>
            <td>:</td>
            <td>{{ $data['jabatan'] ?? '-' }}</td>
        </tr>
    </table>

    <p class="indent">
        Yang bersangkutan diberikan <strong>Rekomendasi</strong> untuk mengikuti program
        <strong>{{ $program }}</strong>. Dengan pertimbangan sebagai berikut:
    </p>

    <ol class="considerations">
        @foreach ($pertimbangan as $item)
            <li>{{ $item }}</li>
        @endforeach
    </ol>

    <p class="indent">
        Demikian rekomendasi ini kami sampaikan. Atas perhatian dan kerja sama yang diberikan
        kami ucapkan terima kasih.
    </p>

    <div class="signature-wrap">
        <table class="signature-box">
            <tr>
                <td>
                    <strong>Mengetahui,</strong><br>
                    Ketua Umum LDK Syahid
                    <div class="signature-space"></div>
                    <strong>Muhammad Syauqi Mubarak</strong><br>
                    NIM. 11230600000067
                </td>
            </tr>
        </table>
    </div>

    <p class="salam">Wassalamu'alaikum Warahmatullahi Wabarakatuh.</p>

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