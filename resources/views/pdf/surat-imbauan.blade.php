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
    $poinImbauan  = preg_split('/\r\n|\r|\n/', trim($data['poin_imbauan'] ?? ''));
    $poinImbauan  = array_values(array_filter(array_map(
        fn($item) => trim(preg_replace('/^\d+[\.\)]\s*/', '', $item)),
        $poinImbauan
    )));
    if (empty($poinImbauan)) {
        $poinImbauan = [
            'Senantiasa menjaga ukhuwah islamiyah dan koordinasi antar bidang.',
            'Mendukung ketertiban serta kelancaran setiap program dakwah kampus.',
        ];
    }
@endphp
@if ($templateUri)<img class="page-bg" src="{{ $templateUri }}" alt="">@endif
<div class="content">
    <table class="meta">
        <tr>
            <td class="meta-label">Nomor</td><td class="meta-sep">:</td>
            <td>{{ $nomorSurat }}</td><td class="date-cell">Jakarta, {{ $tanggalSurat }}</td>
        </tr>
        <tr><td>Lampiran</td><td>:</td><td colspan="2">-</td></tr>
        <tr><td>Hal</td><td>:</td><td colspan="2"><strong>Surat Imbauan</strong></td></tr>
    </table>
    <div class="body-surat">
        <div class="recipient">
            <p>Yth.</p>
            <p><strong>{{ $data['ditujukan_kepada'] ?? 'Seluruh Pengurus dan Kader LDK Syahid' }}</strong></p>
            <p>di Tempat</p>
        </div>
        <p class="salam">Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>
        <p class="indent">Puji syukur kita panjatkan ke hadirat Allah SWT atas limpahan rahmat dan karunia-Nya. Shalawat dan salam senantiasa tercurah kepada junjungan kita Nabi Muhammad SAW.</p>
        <p class="indent">Sehubungan dengan <strong>{{ $data['perihal_imbauan'] ?? 'arahan dan perkembangan situasi terkini' }}</strong>, maka dengan ini Pengurus UKM Lembaga Dakwah Kampus (LDK) Syahid UIN Syarif Hidayatullah Jakarta menyampaikan beberapa poin imbauan sebagai berikut:</p>
        <ol>
            @foreach ($poinImbauan as $item)
                <li>{{ $item }}</li>
            @endforeach
        </ol>
        <p class="indent">Demikian surat imbauan ini kami sampaikan agar dapat dipedomani dan dilaksanakan dengan penuh kesadaran dan tanggung jawab bersama.</p>
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