<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $label }}</title>
    <style>
    @include('persuratan.components._index-styles')
    .identity-label { width: 44mm; }
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

    <table class="meta">
        <tr>
            <td class="meta-label">Nomor</td>
            <td class="meta-sep">:</td>
            <td>{{ $nomorSurat }}</td>
            <td class="date-cell">Jakarta, {{ $tanggalSurat }}</td>
        </tr>
        <tr><td>Lampiran</td><td>:</td><td colspan="2">-</td></tr>
        <tr>
            <td>Hal</td>
            <td>:</td>
            <td colspan="2"><strong>Permohonan Peminjaman Tempat</strong></td>
        </tr>
    </table>

    <div class="body-surat">

        <div class="recipient">
            <p>Yth.</p>
            <p><strong>{{ $data['ditujukan_kepada'] ?? 'Pihak Pengelola' }}</strong></p>
            <p>di Tempat</p>
        </div>

        <p class="salam">Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>

        <p class="indent">Puji syukur senantiasa kita panjatkan ke hadirat Allah SWT. Shalawat serta salam
            semoga selalu tercurah kepada junjungan kita Nabi Muhammad SAW, beserta keluarga,
            sahabat, dan umatnya.</p>

        <p class="indent">Sehubungan dengan akan dilaksanakannya agenda
            <strong>{{ $data['nama_acara'] ?? '-' }}</strong>
            dengan tema <strong><em>&ldquo;{{ $data['tema_acara'] ?? '-' }}&rdquo;</em></strong>
            oleh UKM Lembaga Dakwah Kampus (LDK) Syahid, yang InsyaAllah akan diselenggarakan pada:</p>

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
                <td class="identity-label">Tempat yang Dipinjam</td>
                <td class="identity-sep">:</td>
                <td><strong>{{ $data['tempat_dipinjam'] ?? '-' }}</strong></td>
            </tr>
        </table>

        <p class="indent">Mengingat pentingnya kelancaran kegiatan tersebut, kami memohon izin dan
            perkenan Bapak/Ibu untuk meminjam fasilitas tempat tersebut pada waktu yang telah
            disebutkan di atas.</p>

        <p class="indent">Demikian permohonan peminjaman tempat ini kami sampaikan. Atas izin dan
            dukungan yang diberikan, kami ucapkan jazakumullah khairan katsiran.</p>

        <p class="salam-penutup">Wassalamu'alaikum Warahmatullahi Wabarakatuh.</p>

        {{-- TTD: Ketua Pelaksana (kiri) + Ketua Umum (kanan) --}}
        <table class="signature-table">
            <tr>
                <td class="ttd-cell"><strong>Mengetahui,</strong><br>Ketua Pelaksana</td>
                <td class="ttd-cell"><strong>Ketua Umum LDK Syahid</strong></td>
            </tr>
            <tr>
                <td class="ttd-cell">
                    <div class="ttd-space"></div>
                </td>
                <td class="ttd-cell">
                    <div class="ttd-space">
                        <img src="{!! $qrCode !!}" alt="QR Verifikasi">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="ttd-cell">
                    <strong>{{ $data['nama_ketua_pelaksana'] ?? '(............................................)' }}</strong>
                </td>
                <td class="ttd-cell"><strong>Muhammad Syauqi Mubarak</strong></td>
            </tr>
            <tr>
                <td class="ttd-cell">NIM. {{ $data['nim_ketua_pelaksana'] ?? '................' }}</td>
                <td class="ttd-cell">NIM. 11230600000067</td>
            </tr>
        </table>

        {{-- TTD Wakil Rektor — tengah halaman --}}
        <table style="width:100%; margin-top:14pt; border-collapse:collapse; page-break-inside:avoid;">
            <tr>
                <td style="width:20%;"></td>
                <td style="width:60%; text-align:center; vertical-align:top; line-height:1.15;">
                    <strong>Mengetahui,</strong><br>
                    Wakil Rektor Bidang Kemahasiswaan
                    <div style="height:20mm;"></div>
                    <strong>Prof. Ali Munhanif, M.A., Ph.D.</strong><br>
                    NIP. 196512121992031004
                </td>
                <td style="width:20%;"></td>
            </tr>
        </table>

        {{-- VERIFIKASI --}}
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