<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $label }}</title>
    @include('pdf.components._surat-style')
    <style>
        .tools-table {
            width: 100%;
            margin: 6px 0 10px 0;
            border-collapse: collapse;
            font-size: 11px;
        }
        .tools-table th,
        .tools-table td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: left;
        }
        .tools-table th {
            text-align: center;
            background: #f2f2f2;
        }
        .tools-table .no-col { width: 28px; text-align: center; }
    </style>
</head>
<body>
@php
    $hariTanggal = !empty($data['hari_tanggal'])
        ? \Carbon\Carbon::parse($data['hari_tanggal'])->locale('id')->translatedFormat('l, d F Y')
        : '-';

    // Pecah daftar alat per baris -> [nama alat, keterangan]
    $alatRows = preg_split('/\r\n|\r|\n/', trim($data['daftar_alat'] ?? ''));
    $alatRows = array_values(array_filter(array_map('trim', $alatRows)));
    $alatItems = array_map(function ($line) {
        $line = preg_replace('/^\d+[\.\)]\s*/', '', $line);
        $parts = preg_split('/\s*-\s*/', $line, 2);
        return [
            'nama' => $parts[0] ?? $line,
            'ket'  => $parts[1] ?? '',
        ];
    }, $alatRows);

    if (empty($alatItems)) {
        $alatItems = [['nama' => '-', 'ket' => '-']];
    }
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
        <td colspan="2">1 (satu) halaman</td>
    </tr>
    <tr>
        <td>Hal</td>
        <td>:</td>
        <td colspan="2"><strong>Permohonan Peminjaman Alat</strong></td>
    </tr>
</table>

<div class="recipient">
    <p>Yth.</p>
    <p><strong>{{ $data['ditujukan_kepada'] ?? '-' }}</strong></p>
    <p>di Tempat</p>
</div>

<p class="salam">Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>

<p class="indent">
    Teriring do'a dan harapan semoga Saudara/i dalam keadaan sehat wal 'afiat serta berkah
    menjalankan aktivitas sehari-hari.
</p>

<p class="indent">
    Sehubungan dengan pelaksanaan <strong>{{ $data['nama_acara'] ?? '-' }}</strong> dengan tema
    &ldquo;{{ $data['tema_acara'] ?? '-' }}&rdquo; yang dilaksanakan oleh pengurus UKM Lembaga Dakwah
    Kampus (LDK) Syahid, yang InsyaAllah akan dilaksanakan pada:
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
</table>

<p class="indent">
    Maka kami bermaksud mengajukan permohonan peminjaman alat untuk kegiatan tersebut. Bersamaan
    dengan surat ini, kami menyatakan sanggup untuk menanggung segala bentuk akibat yang ditimbulkan
    terkait peminjaman alat untuk mendukung penyelenggaraan acara tersebut.
</p>

<p>Berikut alat-alat yang akan dipinjam untuk mendukung pelaksanaan acara tersebut di atas:</p>

<table class="tools-table">
    <thead>
        <tr>
            <th class="no-col">No.</th>
            <th>Nama Alat</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($alatItems as $i => $item)
            <tr>
                <td class="no-col">{{ $i + 1 }}.</td>
                <td>{{ $item['nama'] }}</td>
                <td>{{ $item['ket'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<p class="indent">
    Demikian permohonan ini kami sampaikan. Atas perhatian dan bantuannya, kami ucapkan terima kasih.
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

@include('pdf.components._verification-box')
</body>
</html>