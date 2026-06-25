
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $label }}</title>
    @include('pdf.components._index-styles')
    <style>
        /* "Tempat, Tanggal Lahir" & "Fakultas / Jurusan" butuh lebih lebar */
        .identity-label { width: 46mm; }
    </style>
</head>
<body>
@php
    $templatePath = public_path('assets/persuratan/kop-ldk.png');
    $templateUri  = file_exists($templatePath)
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($templatePath)) : null;
@endphp
@if ($templateUri)<img class="page-bg" src="{{ $templateUri }}" alt="">@endif
<div class="content">
    <table class="meta">
        <tr>
            <td class="meta-label">Nomor</td><td class="meta-sep">:</td>
            <td>{{ $nomorSurat }}</td><td class="date-cell">Jakarta, {{ $tanggalSurat }}</td>
        </tr>
        <tr><td>Lampiran</td><td>:</td><td colspan="2">-</td></tr>
        <tr><td>Hal</td><td>:</td><td colspan="2"><strong>Keterangan Aktif Organisasi</strong></td></tr>
    </table>
    <div class="body-surat">
        <div class="recipient">
            <p>Yth.</p>
            <p><strong>{{ $data['penyelenggara'] ?? 'Pihak Terkait' }}</strong></p>
            <p>di Tempat</p>
        </div>
        <p class="salam">Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>
        <p class="indent">Puji syukur senantiasa kita panjatkan ke hadirat Allah SWT. Shalawat serta
            salam semoga selalu tercurah kepada Nabi Muhammad SAW beserta keluarga dan para
            pengikutnya.</p>
        <p class="indent">Yang bertanda tangan di bawah ini, Pengurus UKM Lembaga Dakwah Kampus (LDK)
            Syahid UIN Syarif Hidayatullah Jakarta menerangkan bahwa:</p>
        <table class="identity">
            <tr><td class="identity-label">Nama Lengkap</td><td class="identity-sep">:</td><td><strong>{{ $data['nama'] ?? '-' }}</strong></td></tr>
            <tr><td class="identity-label">Tempat, Tanggal Lahir</td><td class="identity-sep">:</td><td>{{ $data['ttl'] ?? '-' }}</td></tr>
            <tr><td class="identity-label">NIM</td><td class="identity-sep">:</td><td>{{ $data['nim'] ?? '-' }}</td></tr>
            <tr><td class="identity-label">Fakultas / Jurusan</td><td class="identity-sep">:</td><td>{{ $data['fakultas'] ?? '-' }} / {{ $data['jurusan'] ?? '-' }}</td></tr>
            <tr><td class="identity-label">Jabatan di LDK</td><td class="identity-sep">:</td><td>{{ $data['jabatan'] ?? '-' }}</td></tr>
        </table>
        <p class="indent">Merupakan mahasiswa/i UIN Syarif Hidayatullah Jakarta yang
            <strong>benar-benar aktif</strong> sebagai pengurus LDK Syahid.
            Surat keterangan ini dibuat untuk keperluan {{ $data['keperluan'] ?? '-' }}.</p>
        <p class="indent">Demikian surat keterangan ini kami buat agar dapat dipergunakan sebagaimana
            mestinya. Atas perhatiannya, kami ucapkan jazakumullah khairan katsiran.</p>
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
