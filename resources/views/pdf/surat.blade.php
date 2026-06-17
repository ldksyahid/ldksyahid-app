<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $label }}</title>
    <style>
        @page { margin: 36px 48px; }

        body {
            color: #111;
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.55;
        }

        .kop {
            border-bottom: 3px solid #111;
            padding-bottom: 10px;
            text-align: center;
        }

        .kop h1 {
            font-size: 17px;
            margin: 0;
            text-transform: uppercase;
        }

        .kop p {
            font-size: 10px;
            margin: 2px 0 0;
        }

        .meta {
            margin-top: 24px;
            width: 100%;
        }

        .meta td,
        .field-table td {
            padding: 3px 0;
            vertical-align: top;
        }

        .title {
            margin: 28px 0 18px;
            text-align: center;
        }

        .title h2 {
            border-bottom: 1px solid #111;
            display: inline-block;
            font-size: 15px;
            margin: 0;
            padding-bottom: 2px;
            text-transform: uppercase;
        }

        .field-table {
            border-collapse: collapse;
            margin: 12px 0 18px;
            width: 100%;
        }

        .field-table .label { width: 190px; }
        .field-table .sep { width: 14px; }

        .signature {
            margin-top: 34px;
            page-break-inside: avoid;
            width: 100%;
        }

        .signature td {
            vertical-align: top;
            width: 50%;
        }

        .signature .name-space { height: 70px; }
    </style>
</head>
<body>
@php
    $labels = [
        'jenis_undangan' => 'Jenis Undangan',
        'nama_acara' => 'Nama Acara',
        'tema_acara' => 'Tema Acara',
        'hari_tanggal' => 'Tanggal Acara',
        'waktu' => 'Waktu',
        'tempat' => 'Tempat',
        'tempat_dipinjam' => 'Tempat yang Dipinjam',
        'alamat_tempat' => 'Alamat Tempat',
        'ditujukan_kepada' => 'Ditujukan Kepada',
        'daftar_alat' => 'Daftar Alat yang Dipinjam',
        'nama_program' => 'Nama Program/Kegiatan',
        'keperluan' => 'Keperluan',
        'nama' => 'Nama',
        'nim' => 'NIM',
        'fakultas' => 'Fakultas',
        'jurusan' => 'Jurusan',
        'jabatan' => 'Jabatan/Bidang di LDK',
        'program_rekomendasi' => 'Program yang Direkomendasikan',
        'pertimbangan' => 'Pertimbangan',
    ];

    $formatValue = function ($key, $value) {
        if ($key === 'jenis_undangan') {
            return $value === 'internal' ? 'Internal (LDK Syahid)' : 'Eksternal';
        }

        if ($key === 'hari_tanggal' && !empty($value)) {
            try {
                return \Carbon\Carbon::parse($value)->locale('id')->translatedFormat('d F Y');
            } catch (\Exception $e) {
                return $value;
            }
        }

        return $value;
    };
@endphp

<div class="kop">
    <h1>Lembaga Dakwah Kampus Syahid</h1>
    <p>UIN Syarif Hidayatullah Jakarta</p>
    <p>Jl. Ir. H. Juanda No. 95, Ciputat, Tangerang Selatan</p>
</div>

<table class="meta">
    <tr>
        <td style="width: 70px;">Nomor</td>
        <td style="width: 14px;">:</td>
        <td>{{ $nomorSurat }}</td>
        <td style="text-align: right;">Jakarta, {{ $tanggalSurat }}</td>
    </tr>
    <tr>
        <td>Perihal</td>
        <td>:</td>
        <td colspan="2">{{ $label }}</td>
    </tr>
</table>

<div class="title">
    <h2>{{ $label }}</h2>
</div>

<p>Assalamu'alaikum warahmatullahi wabarakatuh.</p>
<p>
    Dengan hormat, melalui surat ini LDK Syahid UIN Syarif Hidayatullah Jakarta
    menyampaikan dokumen resmi dengan rincian sebagai berikut:
</p>

<table class="field-table">
    @foreach ($data as $key => $value)
        @continue($key === 'jenis_surat')
        <tr>
            <td class="label">{{ $labels[$key] ?? ucwords(str_replace('_', ' ', $key)) }}</td>
            <td class="sep">:</td>
            <td>{!! nl2br(e($formatValue($key, $value))) !!}</td>
        </tr>
    @endforeach
</table>

<p>
    Demikian surat ini dibuat untuk dipergunakan sebagaimana mestinya.
    Atas perhatian dan kerja sama yang baik, kami ucapkan terima kasih.
</p>
<p>Wassalamu'alaikum warahmatullahi wabarakatuh.</p>

<table class="signature">
    <tr>
        <td></td>
        <td style="text-align: center;">
            <p>Hormat kami,</p>
            <p>Pengurus LDK Syahid</p>
            <div class="name-space"></div>
            <p><strong>Kesekretariatan LDK Syahid</strong></p>
        </td>
    </tr>
</table>

@include('pdf.components._qr-verifikasi')
</body>
</html>
