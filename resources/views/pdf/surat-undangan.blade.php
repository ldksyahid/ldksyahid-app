<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $label }}</title>
    @include('pdf.components._index-styles')
</head>
<body>
@php
    $templatePath  = public_path('assets/persuratan/kop-ldk.png');
    $templateUri   = file_exists($templatePath)
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($templatePath)) : null;
    $hariTanggal   = !empty($data['hari_tanggal'])
        ? \Carbon\Carbon::parse($data['hari_tanggal'])->locale('id')->translatedFormat('l, d F Y') : '-';
    $isInternal    = ($data['jenis_undangan'] ?? 'eksternal') === 'internal';
    $sapaan        = $isInternal ? 'Saudara/i' : 'Bapak/Ibu/Saudara/i';
    $salamPembuka  = "Teriring do'a dan harapan semoga {$sapaan} dalam keadaan sehat wal 'afiat serta berkah dalam menjalankan aktivitas sehari-hari.";
@endphp
@if ($templateUri)<img class="page-bg" src="{{ $templateUri }}" alt="">@endif
<div class="content">
    <table class="meta">
        <tr>
            <td class="meta-label">Nomor</td><td class="meta-sep">:</td>
            <td>{{ $nomorSurat }}</td><td class="date-cell">Jakarta, {{ $tanggalSurat }}</td>
        </tr>
        <tr><td>Lampiran</td><td>:</td><td colspan="2">-</td></tr>
        <tr><td>Hal</td><td>:</td><td colspan="2"><strong>Undangan Kegiatan</strong></td></tr>
    </table>
    <div class="body-surat">
        <div class="recipient">
            <p>Yth.</p>
            <p><strong>{{ $data['ditujukan_kepada'] ?? $sapaan }}</strong></p>
            <p>di Tempat</p>
        </div>
        <p class="salam">Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>
        <p class="indent">{{ $salamPembuka }}</p>
        <p class="indent">Sehubungan dengan akan diadakannya kegiatan
            <strong>{{ $data['nama_acara'] ?? '-' }}</strong>
            yang mengusung tema <strong><em>&ldquo;{{ $data['tema_acara'] ?? '-' }}&rdquo;</em></strong>
            oleh UKM Lembaga Dakwah Kampus (LDK) Syahid, kami bermaksud mengundang
            {{ $sapaan }} untuk dapat hadir pada:</p>
        <table class="identity">
            <tr><td class="identity-label">Hari, Tanggal</td><td class="identity-sep">:</td><td>{{ $hariTanggal }}</td></tr>
            <tr><td class="identity-label">Waktu</td><td class="identity-sep">:</td><td>{{ $data['waktu'] ?? '-' }}</td></tr>
            <tr><td class="identity-label">Tempat</td><td class="identity-sep">:</td><td>{{ $data['tempat'] ?? '-' }}</td></tr>
        </table>
        <p class="indent">Kehadiran dan partisipasi dari {{ $sapaan }} sangat kami harapkan guna
            menyemarakkan dan mendukung kesuksesan kegiatan tersebut.</p>
        <p class="indent">Demikian surat undangan ini kami sampaikan. Atas perhatian dan kesediaan
            waktunya, kami ucapkan jazakumullah khairan katsiran.</p>
        <p class="salam-penutup">Wassalamu'alaikum Warahmatullahi Wabarakatuh.</p>
        <table class="signature-table">
            <tr>
                <td class="ttd-cell"><strong>Ketua Umum LDK Syahid</strong></td>
                <td class="ttd-cell"><strong>Sekretaris Jenderal</strong></td>
            </tr>
            <tr>
                <td class="ttd-cell"><div class="ttd-space"><img src="{!! $qrCode !!}" alt="QR"></div></td>
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
                <td class="qr-cell"><img src="{!! $qrCode !!}" alt="QR"></td>
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