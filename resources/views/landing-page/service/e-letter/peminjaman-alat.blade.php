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
    $hariTanggal  = !empty($data['hari_tanggal'])
        ? \Carbon\Carbon::parse($data['hari_tanggal'])->locale('id')->translatedFormat('l, d F Y')
        : '-';
    $daftarAlat   = preg_split('/\r\n|\r|\n/', trim($data['daftar_alat'] ?? ''));
    $daftarAlat   = array_values(array_filter(array_map(
        fn($item) => trim(preg_replace('/^\d+[\.\)]\s*/', '', $item)),
        $daftarAlat
    )));
@endphp
@if ($templateUri)<img class="page-bg" src="{{ $templateUri }}" alt="">@endif

<div class="content">
    <table class="meta">
        <tr>
            <td class="meta-label">Nomor</td><td class="meta-sep">:</td>
            <td>{{ $nomorSurat }}</td>
            <td class="date-cell">Jakarta, {{ $tanggalSurat }}</td>
        </tr>
        <tr><td>Lampiran</td><td>:</td><td colspan="2">-</td></tr>
        <tr><td>Hal</td><td>:</td><td colspan="2"><strong>Permohonan Peminjaman Alat</strong></td></tr>
    </table>

    <div class="body-surat">
        <div class="recipient">
            <p>Yth.</p>
            <p><strong>{{ $data['ditujukan_kepada'] ?? 'Pihak Terkait' }}</strong></p>
            <p>di Tempat</p>
        </div>

        <p class="salam">Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>

        <p class="indent">Segala puji bagi Allah SWT yang senantiasa melimpahkan rahmat dan hidayah-Nya.
            Shalawat dan salam selalu tercurah kepada Rasulullah Muhammad SAW.</p>

        <p class="indent">Sehubungan dengan akan dilaksanakannya agenda
            <strong>{{ $data['nama_acara'] ?? '-' }}</strong>
            dengan tema <strong><em>&ldquo;{{ $data['tema_acara'] ?? '-' }}&rdquo;</em></strong>,
            yang InsyaAllah akan diselenggarakan pada:</p>

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
                <td class="identity-label">Tempat</td>
                <td class="identity-sep">:</td>
                <td>{{ $data['tempat'] ?? '-' }}</td>
            </tr>
        </table>

        <p class="indent">Maka demi kelancaran agenda tersebut, kami dari LDK Syahid bermaksud meminjam
            beberapa perlengkapan/alat, dengan rincian sebagai berikut:</p>

        <ol>
            @forelse ($daftarAlat as $alat)
                <li>{{ $alat }}</li>
            @empty
                <li><em>(Tidak ada rincian alat)</em></li>
            @endforelse
        </ol>

        <p class="indent">Demikian surat permohonan peminjaman alat ini kami sampaikan. Atas perhatian
            dan izin yang diberikan, kami ucapkan jazakumullah khairan katsiran.</p>

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