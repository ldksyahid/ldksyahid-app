<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $label }}</title>
    @include('pdf.kemasis.components._styles')
</head>
<body>
@php
    $templateUri = \App\Models\SuratLog::getKopImageBase64();
    $hariTanggal  = \App\Models\SuratLog::formatHariTanggal($data['hari_tanggal'] ?? null);
@endphp

@if ($templateUri)
    <div class="page-bg">
        <img src="{{ $templateUri }}" style="width: 100%; height: 100%;" alt="">
    </div>
@endif

<div class="content">

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
            <td colspan="2">1 (satu) Bundel Proposal</td>
        </tr>
        <tr>
            <td>Hal</td>
            <td>:</td>
            <td colspan="2"><strong>Permohonan Penandatanganan</strong></td>
        </tr>
    </table>

    <div class="body-surat">

        <div class="recipient">
            <p>Yth.</p>
            <p><strong>{{ $data['ditujukan_kepada'] ?? 'Wakil Rektor Bidang Kemahasiswaan' }}</strong></p>
            <p>UIN Syarif Hidayatullah Jakarta</p>
            <p>di Tempat</p>
        </div>

        <p class="salam">Assalamualaikum warahmatullah wabarakatuh,</p>

        <p class="indent">
            Teriring doa dan harapan semoga Bapak/Ibu dalam keadaan sehat wal afiat serta berkah dalam menjalankan aktivitas sehari-hari.
        </p>

        <p class="indent">
            Dengan hormat, sehubungan dengan pelaksanaan <strong>{{ $data['nama_acara'] ?? $data['nama_kegiatan'] ?? '-' }}</strong>
            dengan tema <strong><em>&ldquo;{{ $data['tema_acara'] ?? '-' }}&rdquo;</em></strong>
            yang diselenggarakan oleh pengurus UKM Lembaga Dakwah Kampus (LDK) Syahid UIN Syarif Hidayatullah Jakarta, yang Insyaallah akan dilaksanakan pada:
        </p>

        <table class="identity">
            <tr>
                <td class="identity-label">Hari, Tanggal</td>
                <td class="identity-sep">:</td>
                <td>{{ $hariTanggal }}</td>
            </tr>
            <tr>
                <td class="identity-label">Waktu</td>
                <td class="identity-sep">:</td>
                <td>{{ \App\Models\SuratLog::formatWaktu($data['waktu'] ?? null) }}</td>
            </tr>
            <tr>
                <td class="identity-label">Tempat</td>
                <td class="identity-sep">:</td>
                <td><strong>{{ $data['tempat'] ?? '-' }}</strong></td>
            </tr>
        </table>

        <p class="indent">
            Maka dengan ini kami mengajukan permohonan kepada Wakil Rektor Bidang Kemahasiswaan untuk berkenan menandatangani Proposal Kegiatan yang telah kami susun sebagai syarat administrasi dalam pelaksanaan kegiatan dan permohonan penggunaan fasilitas kampus. Adapun proposal terlampir.
        </p>

        <p class="indent">
            Demikian permohonan ini kami sampaikan. Atas perhatian dan bantuannya, kami ucapkan terima kasih.
        </p>

        <p class="salam-penutup">Wassalamualaikum warahmatullah wabarakatuh.</p>

        {{-- TTD SEKJEN & KETUM --}}
        <table class="signature-table">
            <tr>
                <td class="ttd-cell"><strong>Sekretaris Jenderal LDK Syahid</strong></td>
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

        {{-- KOTAK VERIFIKASI QR --}}
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
