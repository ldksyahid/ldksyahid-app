<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $label }}</title>
    @include('pdf.components._index-styles')
</head>
<body>
@php
    $templateUri  = \App\Models\SuratLog::getKopImageBase64();
    $hariTanggal  = \App\Models\SuratLog::formatHariTanggal($data['hari_tanggal'] ?? null);
    $waktu        = \App\Models\SuratLog::formatWaktu($data['waktu'] ?? null);
@endphp
@if ($templateUri)<img class="page-bg" src="{{ $templateUri }}" alt="">@endif
<div class="content">
    <table class="meta">
        <tr>
            <td class="meta-label">Nomor</td><td class="meta-sep">:</td>
            <td>{{ $nomorSurat }}</td><td class="date-cell">Jakarta, {{ $tanggalSurat }}</td>
        </tr>
        <tr><td>Lampiran</td><td>:</td><td colspan="2">1 (satu) Berkas Proposal</td></tr>
        <tr><td>Hal</td><td>:</td><td colspan="2"><strong>Permohonan Kunjungan Silaturahmi / Studi Banding</strong></td></tr>
    </table>
    <div class="body-surat">
        <div class="recipient">
            <p>Yth.</p>
            <p><strong>{{ $data['ditujukan_kepada'] ?? 'Pimpinan Lembaga / Ketua Organisasi' }}</strong></p>
            <p>di Tempat</p>
        </div>
        <p class="salam">Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>
        <p class="indent">Puji syukur senantiasa kita panjatkan ke hadirat Allah SWT. Shalawat dan salam semoga selalu tercurah kepada junjungan kita Nabi Muhammad SAW, beserta keluarga, sahabat, dan para pengikutnya.</p>
        <p class="indent">Dalam rangka mempererat tali silaturahmi, bertukar gagasan, serta memperluas wawasan keorganisasian melalui program kerja <strong>{{ $data['nama_kegiatan'] ?? 'Kunjungan Studi Banding' }}</strong>, maka pengurus UKM Lembaga Dakwah Kampus (LDK) Syahid UIN Syarif Hidayatullah Jakarta bermaksud mengadakan kunjungan silaturahmi ke lembaga yang Bapak/Ibu pimpin pada:</p>
        <table class="identity">
            <tr><td class="identity-label">Hari, Tanggal</td><td class="identity-sep">:</td><td>{{ $hariTanggal }}</td></tr>
            <tr><td class="identity-label">Waktu</td><td class="identity-sep">:</td><td>{{ $waktu }}</td></tr>
            <tr><td class="identity-label">Tempat / Lokasi</td><td class="identity-sep">:</td><td>{{ $data['tempat'] ?? '-' }}</td></tr>
            <tr><td class="identity-label">Fokus Agenda</td><td class="identity-sep">:</td><td>{{ $data['keperluan'] ?? 'Silaturahmi dan Studi Banding Kelembagaan' }}</td></tr>
        </table>
        <p class="indent">Besar harapan kami agar permohonan kunjungan ini dapat disambut dengan baik guna terwujudnya sinergi dan kolaborasi dakwah yang produktif di masa mendatang.</p>
        <p class="indent">Demikian surat permohonan ini kami sampaikan. Atas perhatian, perkenan, dan kerja sama yang diberikan, kami ucapkan jazakumullah khairan katsiran.</p>
        <p class="salam-penutup">Wassalamu'alaikum Warahmatullahi Wabarakatuh.</p>
        <table class="signature-table">
            <tr>
                <td class="ttd-cell"><strong>Sekretaris Jenderal</strong></td>
                <td class="ttd-cell"><strong>Ketua Umum LDK Syahid</strong></td>
            </tr>
            <tr>
                <td class="ttd-cell"><div class="ttd-space">@include('pdf.components._sekjen-signature')</div></td>
                <td class="ttd-cell"><div class="ttd-space"><img src="{!! $qrCode !!}" alt="QR Verifikasi"></div></td>
            </tr>
            <tr>
                <td class="ttd-cell"><strong>Muhammad Zhafar Rabbany</strong></td>
                <td class="ttd-cell"><strong>Muhammad Syauqi Mubarak</strong></td>
            </tr>
            <tr>
                <td class="ttd-cell">NIM. 11230340000016</td>
                <td class="ttd-cell">NIM. 11230600000067</td>
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