<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $label }}</title>
    @include('pdf.components._index-styles')
</head>
<body>
@php
    $templatePath = public_path('assets/persuratan/kop-ldk.png');
    $templateUri  = file_exists($templatePath)
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($templatePath))
        : null;
@endphp
@if ($templateUri)<img class="page-bg" src="{{ $templateUri }}" alt="">@endif

<div class="content">
    <table class="meta">
        <tr>
            <td class="meta-label">Nomor</td><td class="meta-sep">:</td>
            <td>{{ $nomorSurat }}</td>
            <td class="date-cell">Jakarta, {{ $tanggalSurat }}</td>
        </tr>
        <tr><td>Lampiran</td><td>:</td><td colspan="2">1 (satu) Berkas Proposal</td></tr>
        <tr><td>Hal</td><td>:</td><td colspan="2"><strong>Permohonan Kerja Sama / Sponsorship</strong></td></tr>
    </table>

    <div class="body-surat">
        <div class="recipient">
            <p>Yth.</p>
            <p><strong>{{ $data['ditujukan_kepada'] ?? 'Bapak/Ibu Pimpinan' }}</strong></p>
            <p>di Tempat</p>
        </div>

        <p class="salam">Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>

        <p class="indent">Puji syukur senantiasa kita panjatkan ke hadirat Allah SWT atas segala
            nikmat-Nya. Shalawat dan salam senantiasa tercurah kepada Nabi Muhammad SAW beserta
            keluarga dan para pengikutnya.</p>

        <p class="indent">Melalui surat ini, kami dari pengurus UKM Lembaga Dakwah Kampus (LDK) Syahid
            UIN Syarif Hidayatullah Jakarta bermaksud mengajukan permohonan dukungan kerja
            sama/sponsorship untuk menyukseskan program kami:</p>

        <p style="text-align:center; margin:10pt 0;">
            <strong><em>&ldquo;{{ $data['nama_acara'] ?? '-' }} : {{ $data['tema_acara'] ?? '-' }}&rdquo;</em></strong>
        </p>

        <p class="indent">Adapun bentuk kerja sama yang kami tawarkan secara ringkas adalah sebagai berikut:</p>

        <div style="margin: 4pt 0 10pt 9mm; line-height:1.5;">
            {!! nl2br(e($data['bentuk_kerjasama'] ?? '-')) !!}
        </div>

        <p class="indent">Rincian lebih lanjut mengenai paket sponsorship dan penawaran timbal balik
            (benefit) telah kami lampirkan dalam proposal bersama surat ini. Besar harapan kami agar
            Bapak/Ibu berkenan menjalin kerja sama demi kesuksesan program tersebut.</p>

        <p class="indent">Demikian surat permohonan ini kami sampaikan. Atas perhatian, dukungan,
            dan kerja sama yang diberikan, kami ucapkan jazakumullah khairan katsiran.</p>

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