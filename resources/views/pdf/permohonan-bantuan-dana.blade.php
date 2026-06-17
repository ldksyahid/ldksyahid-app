<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $label }}</title>
    @include('pdf.components._surat-style')
</head>
<body>

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
        <td colspan="2">1 (satu) bundel Proposal</td>
    </tr>
    <tr>
        <td>Hal</td>
        <td>:</td>
        <td colspan="2"><strong>Permohonan Bantuan Dana untuk {{ $data['nama_program'] ?? '-' }}</strong></td>
    </tr>
</table>

<div class="recipient">
    <p>Yth.</p>
    <p><strong>{{ $data['ditujukan_kepada'] ?? '-' }}</strong></p>
    <p>di Tempat</p>
</div>

<p class="salam">Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>

<p class="indent">
    Segala puji bagi Allah Rabb semesta alam dengan rahmat dan karunia yang tak terhingga. Shalawat
    dan salam semoga tetap tercurah kepada Rasulullah SAW., keluarga, sahabat, serta para pengikutnya
    yang setia hingga akhir zaman.
</p>

<p class="indent">
    Sehubungan dengan adanya program <strong>{{ $data['nama_program'] ?? '-' }}</strong>, maka kami
    bermaksud mengajukan permohonan bantuan dana dengan keperluan sebagai berikut:
</p>

<table class="field-table">
    <tr>
        <td colspan="3">{!! nl2br(e($data['keperluan'] ?? '-')) !!}</td>
    </tr>
</table>

<p class="indent">
    Sebagai bahan kelengkapan permohonan dana kegiatan, bersama ini kami lampirkan proposal kegiatan
    beserta rencana pembiayaan (terlampir dalam proposal).
</p>

<p class="indent">
    Demikian permohonan ini kami sampaikan, atas perhatian dan kerjasama yang diberikan, kami
    ucapkan terima kasih.
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