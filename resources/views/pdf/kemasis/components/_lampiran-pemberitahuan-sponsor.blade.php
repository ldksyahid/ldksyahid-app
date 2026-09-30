<div class="content page-break lampiran-page">
    <div class="lampiran-tag">Lampiran 3</div>
    <div class="lampiran-title" style="margin-bottom: 12pt;">SURAT PEMBERITAHUAN SPONSOR</div>

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
            <td colspan="2">-</td>
        </tr>
        <tr>
            <td>Hal</td>
            <td>:</td>
            <td colspan="2"><strong>Pemberitahuan Pelibatan Sponsor</strong></td>
        </tr>
    </table>

    <div class="body-surat">
        <div class="recipient">
            <p>Yth.</p>
            <p><strong>Kepala Biro Administrasi Umum dan Kepegawaian</strong></p>
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
                <td>{{ $data['tempat_dipinjam'] ?? $data['tempat'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="identity-label">Jumlah Peserta</td>
                <td class="identity-sep">:</td>
                <td>{{ $data['jumlah_peserta'] ?? '-' }}</td>
            </tr>
        </table>

        <p class="indent">
            Bersama ini kami memberitahukan bahwa demi kelancaran pendanaan kegiatan tersebut, panitia pelaksana akan menjalin kerja sama dengan pihak eksternal (sponsor). Adapun laporan rincian mitra sponsor beserta bentuk kerjasama yang disepakati akan kami infokan menyusul sehubungan dengan proses yang masih berjalan.
        </p>

        <p class="indent">
            Demikian pemberitahuan ini kami sampaikan. Atas perhatian dan bantuannya, kami ucapkan terima kasih.
        </p>

        <p class="salam-penutup">Wassalamualaikum warahmatullah wabarakatuh.</p>

        <table class="signature-table" style="margin-top: 10pt;">
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

        <table class="signature-table--warek" style="margin-top: 6pt;">
            <tr>
                <td class="ttd-cell">
                    <strong>Mengetahui,</strong><br>
                    <strong>Wakil Rektor Bidang Kemahasiswaan</strong><br>
                    UIN Syarif Hidayatullah Jakarta
                </td>
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
    </div>
</div>
