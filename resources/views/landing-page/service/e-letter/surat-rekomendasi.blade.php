
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $label }}</title>
    @include('pdf.components._index-styles')
    <style>
        .identity-label { width: 38mm; }
    </style>
</head>
<body>
@php
    $templatePath  = public_path('assets/persuratan/kop-ldk.png');
    $templateUri   = file_exists($templatePath)
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($templatePath)) : null;
    $program       = $data['program_rekomendasi'] ?? 'program yang direkomendasikan';
    $pertimbangan  = preg_split('/\r\n|\r|\n/', trim($data['pertimbangan'] ?? ''));
    $pertimbangan  = array_values(array_filter(array_map(
        fn($item) => trim(preg_replace('/^\d+[\.\)]\s*/', '', $item)),
        $pertimbangan
    )));
    if (empty($pertimbangan)) {
        $pertimbangan = [
            'Mengingat yang bersangkutan merupakan anggota aktif dari UKM LDK Syahid.',
            'Mengingat yang bersangkutan tidak pernah terlibat dalam kegiatan yang terlarang selama menempuh pendidikan di kampus.',
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
        <tr><td>Hal</td><td>:</td><td colspan="2"><strong>Rekomendasi</strong></td></tr>
    </table>
    <div class="body-surat">
        <div class="recipient">
            <p>Yth.</p>
            <p><strong>Pengurus {{ $program }}</strong></p>
            <p>di Tempat</p>
        </div>
        <p class="salam">Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>
        <p class="indent">Segala puji bagi Allah Rabb semesta alam dengan rahmat dan karunia yang tak
            terhingga. Shalawat dan salam semoga tetap tercurah kepada Rasulullah SAW., keluarga,
            sahabat, dan para pengikutnya yang setia hingga akhir zaman.</p>
        <p class="indent">Dengan ini UKM Lembaga Dakwah Kampus Syarif Hidayatullah Jakarta (LDK Syahid)
            memberikan <strong>Rekomendasi</strong> terhadap peserta program
            <strong><em>&ldquo;{{ $program }}&rdquo;</em></strong>.
            Adapun identitas peserta program adalah sebagai berikut:</p>
        <table class="identity">
            <tr><td class="identity-label">Nama</td><td class="identity-sep">:</td><td>{{ $data['nama'] ?? '-' }}</td></tr>
            <tr><td class="identity-label">NIM</td><td class="identity-sep">:</td><td>{{ $data['nim'] ?? '-' }}</td></tr>
            <tr><td class="identity-label">Fakultas</td><td class="identity-sep">:</td><td>{{ $data['fakultas'] ?? '-' }}</td></tr>
            <tr><td class="identity-label">Jurusan</td><td class="identity-sep">:</td><td>{{ $data['jurusan'] ?? '-' }}</td></tr>
            <tr><td class="identity-label">Bidang Jabatan</td><td class="identity-sep">:</td><td>{{ $data['jabatan'] ?? '-' }}</td></tr>
        </table>
        <p class="indent">Yang bersangkutan diberikan <strong>Rekomendasi</strong> untuk mengikuti
            program tersebut dengan pertimbangan sebagai berikut:</p>
        <ol>
            @foreach ($pertimbangan as $item)
                <li>{{ $item }}</li>
            @endforeach
        </ol>
        <p class="indent">Demikian rekomendasi ini kami sampaikan. Atas perhatian dan kerja sama yang
            diberikan kami ucapkan terima kasih.</p>
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

