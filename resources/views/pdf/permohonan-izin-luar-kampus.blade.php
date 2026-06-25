<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $label }}</title>
    @include('pdf.components._index-styles')
    <style>
        /* Label lebih panjang: "Alamat Lengkap" */
        .identity-label { width: 36mm; }
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
        <tr><td>Hal</td><td>:</td><td colspan="2"><strong>Permohonan Izin Kegiatan di Luar Kampus</strong></td></tr>
    </table>

    <div class="body-surat">
        <div class="recipient">
            <p>Yth.</p>
            <p><strong>Wakil Rektor Bidang Kemahasiswaan</strong></p>
            <p>UIN Syarif Hidayatullah Jakarta</p>
        </div>

        <p class="salam">Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>

        <p class="indent">Puji syukur senantiasa kita panjatkan ke hadirat Allah SWT. Shalawat serta
            salam semoga selalu tercurah kepada Nabi Muhammad SAW beserta keluarga, sahabat,
            dan umatnya.</p>

        <p class="indent">Sehubungan dengan program kerja pengurus UKM Lembaga Dakwah Kampus (LDK)
            Syahid, kami bermaksud akan menyelenggarakan kegiatan
            <strong>{{ $data['nama_acara'] ?? '-' }}</strong>
            dengan tema <strong><em>&ldquo;{{ $data['tema_acara'] ?? '-' }}&rdquo;</em></strong>,
            yang mana kegiatan ini berlokasi di luar area kampus. InsyaAllah kegiatan ini akan
            diselenggarakan pada:</p>

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
                <td class="identity-label">Nama Tempat</td>
                <td class="identity-sep">:</td>
                <td>{{ $data['tempat'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="identity-label">Alamat Lengkap</td>
                <td class="identity-sep">:</td>
                <td>{{ $data['alamat_tempat'] ?? '-' }}</td>
            </tr>
        </table>

        <p class="indent">Oleh karena itu, kami memohon izin dan persetujuan dari Bapak/Ibu agar
            kegiatan mahasiswa yang berlokasi di luar kampus tersebut dapat berjalan dengan
            lancar dan resmi.</p>

        <p class="indent">Demikian surat permohonan izin ini kami sampaikan. Atas perhatian dan izin
            yang diberikan, kami ucapkan jazakumullah khairan katsiran.</p>

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