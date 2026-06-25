<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $label }}</title>
    @include('pdf.components._index-styles')
    <style>
        /* "Tema Materi Khusus" butuh sedikit lebih lebar */
        .identity-label { width: 42mm; }
    </style>
</head>
<body>
@php
    $templatePath = public_path('assets/persuratan/kop-ldk.png');
    $templateUri  = file_exists($templatePath)
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($templatePath))
        : null;
    $hariTanggal  = !empty($data['hari_tanggal'])
        ? \Carbon\Carbon::parse($data['hari_tanggal'])->locale('id')->translatedFormat('l, d F Y')
        : '-';
@endphp
@if ($templateUri)<img class="page-bg" src="{{ $templateUri }}" alt="">@endif

<div class="content">
    <table class="meta">
        <tr>
            <td class="meta-label">Nomor</td><td class="meta-sep">:</td>
            <td>{{ $nomorSurat }}</td>
            <td class="date-cell">Jakarta, {{ $tanggalSurat }}</td>
        </tr>
        <tr><td>Lampiran</td><td>:</td><td colspan="2">-</td></tr>
        <tr><td>Hal</td><td>:</td><td colspan="2"><strong>Permohonan Menjadi Pemateri</strong></td></tr>
    </table>

    <div class="body-surat">
        <div class="recipient">
            <p>Yth.</p>
            <p><strong>{{ $data['ditujukan_kepada'] ?? 'Bapak/Ibu/Ustadz/ah' }}</strong></p>
            <p>di Tempat</p>
        </div>

        <p class="salam">Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>

        <p class="indent">Teriring do'a dan harapan semoga Bapak/Ibu senantiasa dalam keadaan sehat
            wal 'afiat serta selalu berada dalam lindungan Allah SWT.</p>

        <p class="indent">Sehubungan dengan akan diadakannya agenda
            <strong>{{ $data['nama_acara'] ?? '-' }}</strong>
            yang mengusung tema <strong><em>&ldquo;{{ $data['tema_acara'] ?? '-' }}&rdquo;</em></strong>,
            kami bermaksud mengundang Bapak/Ibu untuk berkenan menjadi
            <strong>Pemateri/Narasumber</strong> pada agenda tersebut.
            Adapun kegiatan ini akan dilaksanakan pada:</p>

        <table class="identity">
            <tr>
                <td class="identity-label">Hari, Tanggal</td>
                <td class="identity-sep">:</td>
                <td>{{ $hariTanggal }}</td>
            </tr>
            <tr>
                <td class="identity-label">Waktu</td>
                <td class="identity-sep">:</td>
                <td>{{ $data['waktu'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="identity-label">Tempat</td>
                <td class="identity-sep">:</td>
                <td>{{ $data['tempat'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="identity-label">Tema Materi Khusus</td>
                <td class="identity-sep">:</td>
                <td><strong><em>&ldquo;{{ $data['materi'] ?? '-' }}&rdquo;</em></strong></td>
            </tr>
        </table>

        <p class="indent">Besar harapan kami agar Bapak/Ibu berkenan hadir dan memberikan ilmu serta
            motivasi kepada para peserta kegiatan. Demikian surat permohonan ini kami sampaikan,
            atas perhatian dan kesediaannya kami ucapkan jazakumullah khairan katsiran.</p>

        <p class="salam-penutup">Wassalamu'alaikum Warahmatullahi Wabarakatuh.</p>

        <table class="signature-table">
            <tr>
                <td class="ttd-cell"><strong>Ketua Umum LDK Syahid</strong></td>
                <td class="ttd-cell"><strong>Sekretaris Jenderal</strong></td>
            </tr>
            <tr>
                <td class="ttd-cell">
                    <div class="ttd-space"><img src="{!! $qrCode !!}" alt="QR Verifikasi"></div>
                </td>
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
                <td class="qr-cell"><img src="{!! $qrCode !!}" alt="QR Verifikasi"></td>
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