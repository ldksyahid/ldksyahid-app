<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $label }}</title>
    <style>
        /* Kita bisa menyamakan blok CSS persis seperti file izin-orang-tua di atas */
        @page { margin: 0; }
        body { margin: 0; color: #000; font-family: "Times New Roman", DejaVu Serif, serif; font-size: 12px; line-height: 1.25; }
        .page-bg { position: fixed; top: 0; left: 0; width: 210mm; height: 297mm; z-index: -1; }
        .content { position: absolute; top: 53mm; left: 25mm; right: 25mm; }
        .meta { width: 164mm; margin: 0 0 12px -4mm; border-collapse: collapse; }
        .meta td { padding: 0 0 2px 0; vertical-align: top; }
        .meta-label { width: 22mm; }
        .meta-sep { width: 4mm; }
        .date-cell { text-align: right; white-space: nowrap; }
        .recipient { margin: 12px 0 15px 19mm; }
        .recipient p { margin: 0; }
        p { margin: 0 0 6px 0; text-align: justify; }
        .salam { font-weight: bold; font-style: italic; }
        .indent { text-indent: 9mm; }
        .identity { width: 130mm; margin: 5px auto 10px auto; border-collapse: collapse; }
        .identity td { padding: 2px 0; vertical-align: top; }
        .identity-label { width: 35mm; }
        .identity-sep { width: 4mm; }
        
        /* List Barang */
        .list-barang { margin: 5px 0 10px 15mm; padding-left: 5mm; }
        .list-barang li { margin-bottom: 2px; text-align: justify; }

        /* Tanda Tangan */
        .signature-wrap { width: 66mm; margin: 10px 0 10px auto; page-break-inside: avoid; }
        .signature-box { width: 100%; border-collapse: collapse; }
        .signature-box td { text-align: center; border: none; padding: 0; }
        .signature-space { height: 26mm; }

        /* Verifikasi */
        .verification { width: 72mm; margin-top: 10px; border: .5px solid #36aaa1; border-collapse: collapse; color: #333; font-family: DejaVu Sans, sans-serif; font-size: 7px; page-break-inside: avoid; }
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

    // Memecah list daftar alat & membersihkan format angka manual dari mahasiswa
    $daftarAlat = preg_split('/\r\n|\r|\n/', trim($data['daftar_alat'] ?? ''));
    $daftarAlat = array_values(array_filter(array_map(function ($item) {
        return trim(preg_replace('/^\d+[\.\)]\s*/', '', $item));
    }, $daftarAlat)));
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
            <td colspan="2"><strong>Permohonan Peminjaman Alat</strong></td>
        </tr>
    </table>

    <div class="recipient">
        <p>Yth.</p>
        <p><strong>{{ $data['ditujukan_kepada'] ?? 'Departemen/Biro' }}</strong></p>
        <p>di Tempat</p>
    </div>

    <p class="salam">Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>

    <p class="indent">
        Segala puji bagi Allah SWT yang senantiasa melimpahkan rahmat dan hidayah-Nya. Shalawat dan salam
        selalu tercurah kepada Rasulullah Muhammad SAW.
    </p>

    <p class="indent">
        Sehubungan dengan akan dilaksanakannya agenda <strong>{{ $data['nama_acara'] ?? '-' }}</strong> dengan tema
        &ldquo;{{ $data['tema_acara'] ?? '-' }}&rdquo;, yang InsyaAllah akan diselenggarakan pada:
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
        Maka demi kelancaran agenda tersebut, kami bermaksud meminjam beberapa perlengkapan/alat, dengan rincian sebagai berikut:
    </p>

    <ol class="list-barang">
        @forelse ($daftarAlat as $alat)
            <li>{{ $alat }}</li>
        @empty
            <li><em>(Tidak ada daftar alat yang ditulis)</em></li>
        @endforelse
    </ol>

    <p class="indent">
        Demikian surat permohonan peminjaman alat ini kami sampaikan. Atas perhatian dan kerjasamanya, kami ucapkan jazakumullah khairan katsiran.
    </p>

    <p class="salam">Wassalamu'alaikum Warahmatullahi Wabarakatuh.</p>

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