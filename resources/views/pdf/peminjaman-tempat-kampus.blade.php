<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $label }}</title>
    @include('pdf.components._index-styles')
    <style>
    .identity-label { width: 44mm; }

    /* Blok TTD Wakil Rektor (khusus fasilitas rektorat / requiresWarek=true).
       Ditaruh sebagai baris terpisah di BAWAH baris Ketum+Sekjen (bukan kolom ke-3),
       lebar disamakan dengan 1 kolom signature-table (50%) dan diposisikan di tengah. */
    .signature-table--warek {
        width: 50%;
        margin: 10pt auto 0 auto;
        border-collapse: collapse;
        page-break-inside: avoid;
    }
    .signature-table--warek .ttd-cell { width: 100%; }

    /* Placeholder posisi TTD basah Wakil Rektor. Warek berada di luar sistem digital LDK,
       jadi belum ada citra tanda tangan/QR — tanda "^" dipakai sebagai anchor manual untuk
       proses verifikasi berikutnya. */
    .ttd-caret {
        font-size: 13pt;
        font-weight: bold;
        color: #999;
    }
    </style>
</head>
<body>
@php
    $templateUri = \App\Models\SuratLog::getKopImageBase64();
    $hariTanggal  = \App\Models\SuratLog::formatHariTanggal($data['hari_tanggal'] ?? null);
    $requiresWarek = $requiresWarek ?? true;
@endphp

{{-- 🛠️ PERBAIKAN 1: Membungkus gambar background ke dalam div .page-bg --}}
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
                <td>{{ \App\Models\SuratLog::formatWaktu($data['waktu'] ?? null) }}</td>
            </tr>
            <tr>
                <td class="identity-label">Tempat yang Dipinjam</td>
                <td class="identity-sep">:</td>
                <td><strong>{{ $data['tempat_dipinjam'] ?? '-' }}</strong></td>
            </tr>
            <tr>
                <td class="identity-label">Penanggung Jawab</td>
                <td class="identity-sep">:</td>
                <td>{{ $data['nama_ketua_pelaksana'] ?? '-' }} (NIM. {{ $data['nim_ketua_pelaksana'] ?? '-' }})</td>
            </tr>
        </table>

        <p class="indent">Mengingat pentingnya kelancaran kegiatan tersebut, kami memohon izin dan
            perkenan Bapak/Ibu untuk meminjam fasilitas tempat tersebut pada waktu yang telah
            disebutkan di atas.</p>

        <p class="indent">Demikian permohonan peminjaman tempat ini kami sampaikan. Atas izin dan
            dukungan yang diberikan, kami ucapkan jazakumullah khairan katsiran.</p>

        <p class="salam-penutup">Wassalamu'alaikum Warahmatullahi Wabarakatuh.</p>

        {{-- TTD Ketua Umum & Sekjen --}}
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

        {{-- TTD Wakil Rektor Bidang Kemahasiswaan --}}
        @if ($requiresWarek)
            <table class="signature-table--warek">
                <tr>
                    <td class="ttd-cell"><strong>Mengetahui,</strong><br>Wakil Rektor Bidang Kemahasiswaan</td>
                </tr>
                <tr>
                    <td class="ttd-cell">
                        <div class="ttd-space"><span class="ttd-caret">^</span></div>
                    </td>
                </tr>
                <tr>
                    <td class="ttd-cell"><strong>Prof. Ali Munhanif, M.A., Ph.D.</strong></td>
                </tr>
                <tr>
                    <td class="ttd-cell">NIP. 196512121992031004</td>
                </tr>
            </table>
        @endif

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

    </div>{{-- end .body-surat --}}
</div>{{-- end .content --}}
</body>
</html>
