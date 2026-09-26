<div class="content page-break lampiran-page">
    <div class="lampiran-tag">Lampiran 3</div>
    <div class="lampiran-title">SURAT PERNYATAAN BEBAS SPONSOR</div>
    <div class="lampiran-nomor" style="margin-bottom: 8pt;">Nomor: {{ $nomorSurat }}</div>

    <p style="font-size: 10pt; margin-bottom: 4pt;">Yang bertanda tangan di bawah ini:</p>

    <table class="table-identitas">
        <tr>
            <td class="id-label">Nama Lengkap</td>
            <td class="id-sep">:</td>
            <td><strong>{{ $data['nama_ketua_pelaksana'] ?? $data['nama'] ?? '-' }}</strong></td>
        </tr>
        <tr>
            <td class="id-label">NIM</td>
            <td class="id-sep">:</td>
            <td>{{ $data['nim_ketua_pelaksana'] ?? $data['nim'] ?? '-' }}</td>
        </tr>
        <tr>
            <td class="id-label">Fakultas</td>
            <td class="id-sep">:</td>
            <td>{{ $data['fakultas_ketua_pelaksana'] ?? $data['fakultas'] ?? '-' }}</td>
        </tr>
        <tr>
            <td class="id-label">Semester / Jurusan</td>
            <td class="id-sep">:</td>
            <td>{{ $data['jurusan_ketua_pelaksana'] ?? $data['jurusan'] ?? '-' }}</td>
        </tr>
        <tr>
            <td class="id-label">Jabatan</td>
            <td class="id-sep">:</td>
            <td>Ketua Pelaksana</td>
        </tr>
    </table>

    <p style="font-size: 10pt; margin-top: 6pt; margin-bottom: 4pt;">Dengan ini menyatakan dengan sesungguhnya bahwa:</p>

    <table class="table-identitas">
        <tr>
            <td class="id-label">Nama Kegiatan</td>
            <td class="id-sep">:</td>
            <td><strong>{{ $data['nama_acara'] ?? $data['nama_kegiatan'] ?? '-' }}</strong></td>
        </tr>
        <tr>
            <td class="id-label">Tema Kegiatan</td>
            <td class="id-sep">:</td>
            <td><em>&ldquo;{{ $data['tema_acara'] ?? '-' }}&rdquo;</em></td>
        </tr>
        <tr>
            <td class="id-label">Waktu Pelaksanaan</td>
            <td class="id-sep">:</td>
            <td>{{ $hariTanggal }} ({{ \App\Models\SuratLog::formatWaktu($data['waktu'] ?? null) }})</td>
        </tr>
        <tr>
            <td class="id-label">Tempat Pelaksanaan</td>
            <td class="id-sep">:</td>
            <td>{{ $data['tempat_dipinjam'] ?? $data['tempat'] ?? '-' }}</td>
        </tr>
    </table>

    <p style="margin-top: 8pt; font-size: 10pt; text-align: justify; line-height: 1.25;">
        Adalah benar kegiatan yang diselenggarakan oleh LDK Syahid UIN Syarif Hidayatullah Jakarta tidak menerima, tidak mengikat kerja sama, dan tidak melibatkan sponsor dalam bentuk apapun dari pihak eksternal, baik perusahaan, lembaga, instansi pemerintah/swasta, maupun perorangan.
    </p>

    <p style="margin-top: 6pt; font-size: 10pt; text-align: justify; line-height: 1.25;">
        Segala bentuk pembiayaan kegiatan ini bersumber dari dana internal organisasi, serta tidak bertentangan dengan ketentuan yang berlaku di UIN Syarif Hidayatullah Jakarta.
    </p>

    <p style="margin-top: 6pt; font-size: 10pt; text-align: justify; line-height: 1.25;">
        Apabila di kemudian hari terbukti pernyataan ini tidak benar, maka kami bersedia menerima sanksi sesuai peraturan yang berlaku di UIN Syarif Hidayatullah Jakarta.
    </p>

    <p style="margin-top: 6pt; font-size: 10pt; line-height: 1.25;">
        Demikian Pernyataan ini dibuat dengan sebenar-benarnya untuk dapat dipergunakan sebagaimana mestinya.
    </p>

    <table class="signature-lampiran" style="margin-top: 14pt;">
        <tr>
            <td>
                Jakarta, {{ $tanggalSurat }}<br>
                Yang Menyatakan,<br>
                <strong>Ketua Pelaksana</strong><br>
                <div style="height: 18mm;"></div>
                <strong>{{ $data['nama_ketua_pelaksana'] ?? $data['nama'] ?? '.........................................' }}</strong><br>
                NIM. {{ $data['nim_ketua_pelaksana'] ?? $data['nim'] ?? '.........................' }}
            </td>
            <td>
                Mengetahui,<br>
                <strong>Wakil Rektor Bidang Kemahasiswaan</strong><br>
                UIN Syarif Hidayatullah Jakarta<br>
                <div style="height: 18mm; text-align: center; line-height: 18mm;">
                    <span class="ttd-caret">^</span>
                </div>
                <strong>Prof. Ali Munhanif, M.A., Ph.D.</strong><br>
                NIP. 196512121992031004
            </td>
        </tr>
    </table>
</div>
