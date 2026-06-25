<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $label }}</title>
    <style>
    {{-- Paste isi _surat-base.css di sini, atau gunakan @include --}}
    @include('persuratan.components._index-styles')
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

@if ($templateUri)
    <img class="page-bg" src="{{ $templateUri }}" alt="">
@endif

<div class="content">

    {{-- HEADER --}}
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

    <div class="body-surat">

        {{-- PENERIMA --}}
        <div class="recipient">
            <p>Yth.</p>
            <p><strong>Orang Tua/Wali Kader LDK Syahid</strong></p>
            <p>di Tempat</p>
        </div>

        <p class="salam">Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>

        <p class="indent">Teriring do'a dan harapan semoga Bapak/Ibu/Wali dalam keadaan sehat wal 'afiat
            serta berkah dalam menjalankan aktivitas sehari-hari.</p>

        <p class="indent">Sehubungan dengan pelaksanaan <strong>{{ $data['nama_acara'] ?? '-' }}</strong>
            dengan tema <strong><em>&ldquo;{{ $data['tema_acara'] ?? '-' }}&rdquo;</em></strong>
            yang dilaksanakan oleh pengurus UKM Lembaga Dakwah Kampus (LDK) Syahid
            UIN Syarif Hidayatullah Jakarta, yang InsyaAllah akan dilaksanakan pada:</p>

        {{-- TABEL IDENTITAS KEGIATAN --}}
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
        </table>

        <p class="indent">Maka kami memohon kepada Bapak/Ibu/Wali Mahasiswa/i agar bersedia memberikan
            izin kepada putra-putrinya untuk dapat mengikuti kegiatan tersebut.</p>

        <p class="indent">Demikian permohonan ini kami sampaikan. Atas perhatian dan bantuannya,
            kami ucapkan terima kasih.</p>

        <p class="salam-penutup">Wassalamu'alaikum Warahmatullahi Wabarakatuh.</p>

        {{-- TANDA TANGAN --}}
        <table class="signature-table">
            <tr>
                <td class="ttd-cell"><strong>Ketua Umum LDK Syahid</strong></td>
                <td class="ttd-cell"><strong>Sekretaris Jenderal</strong></td>
            </tr>
            <tr>
                <td class="ttd-cell">
                    <div class="ttd-space">
                        <img src="{!! $qrCode !!}" alt="QR Verifikasi">
                    </div>
                </td>
                <td class="ttd-cell">
                    <div class="ttd-space"></div>
                </td>
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

        {{-- VERIFIKASI QR --}}
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

    </div>{{-- end .body-surat --}}
</div>{{-- end .content --}}
</body>
</html>