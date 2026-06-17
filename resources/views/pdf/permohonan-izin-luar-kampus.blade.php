<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $label }}</title>
    @include('pdf.components._surat-style')
</head>
<body>
@php
    $hariTanggal = !empty($data['hari_tanggal'])
        ? \Carbon\Carbon::parse($data['hari_tanggal'])->locale('id')->translatedFormat('l, d F Y')
        : '-';
@endphp

{{-- TODO: ganti dengan kop image (lihat _surat-style.blade.php) --}}
<div class="kop">
    <h1>Lembaga Dakwah Kampus Syahid</h1>
    <p>UIN Syarif Hidayatullah Jakarta</p>
    <p>Jl. Ir. H. Juanda No. 95, Ciputat, Tangerang Selatan</p>
</div>

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
        <td colspan="2"><strong>Permohonan Izin Kegiatan di Luar Kampus</strong></td>
    </tr>
</table>

<div class="recipient">
    <p>Yth.</p>
    <p><strong>Biro Administrasi Akademik, Kemahasiswaan dan Kerja Sama</strong></p>
    <p>UIN Syarif Hidayatullah Jakarta</p>
    <p>di Tempat</p>
</div>

<p class="salam">Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>

<p class="indent">
    Teriring do'a dan harapan semoga Bapak/Ibu dalam keadaan sehat wal 'afiat serta berkah dalam
    menjalankan aktivitas sehari-hari.
</p>

<p class="indent">
    Melalui surat ini kami selaku pengurus UKM Lembaga Dakwah Kampus (LDK) Syahid UIN Syarif
    Hidayatullah Jakarta, mengajukan permohonan izin kegiatan di luar sehubungan dengan pelaksanaan
    rangkaian acara <strong>{{ $data['nama_acara'] ?? '-' }}</strong> dengan tema
    &ldquo;{{ $data['tema_acara'] ?? '-' }}&rdquo; yang InsyaAllah akan dilaksanakan pada:
</p>

<table class="field-table">
    <tr>
        <td class="label">Hari, Tanggal</td>
        <td class="sep">:</td>
        <td>{{ $hariTanggal }}</td>
    </tr>
    <tr>
        <td class="label">Waktu</td>
        <td class="sep">:</td>
        <td>{{ $data['waktu'] ?? '-' }}</td>
    </tr>
    <tr>
        <td class="label">Tempat</td>
        <td class="sep">:</td>
        <td>{{ $data['tempat'] ?? '-' }}</td>
    </tr>
    <tr>
        <td class="label">Alamat</td>
        <td class="sep">:</td>
        <td>{{ $data['alamat_tempat'] ?? '-' }}</td>
    </tr>
</table>

<p class="indent">
    Maka kami selaku pengurus UKM Lembaga Dakwah Kampus (LDK) Syahid memohon izin untuk melaksanakan
    kegiatan tersebut.
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

@include('pdf.components._verification-box')
</body>
</html>