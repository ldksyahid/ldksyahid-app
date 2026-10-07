<div class="content page-break lampiran-page">
    <div class="lampiran-tag">Lampiran 2</div>
    <div class="lampiran-title">SURAT PERNYATAAN</div>
    <div class="lampiran-subtitle" style="margin-bottom: 2pt;">KOMITMEN DAN KEPATUHAN PELAKSANAAN KEGIATAN</div>
    <div class="lampiran-nomor">Nomor: {{ $nomorSurat }}</div>

    <p style="margin-top: 4pt; font-size: 10pt;">Yang bertanda tangan di bawah ini:</p>

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
            <td class="id-label">Jabatan</td>
            <td class="id-sep">:</td>
            <td>Ketua Pelaksana</td>
        </tr>
        <tr>
            <td class="id-label">Nama Kegiatan</td>
            <td class="id-sep">:</td>
            <td><strong>{{ $data['nama_acara'] ?? $data['nama_kegiatan'] ?? '-' }}</strong></td>
        </tr>
        <tr>
            <td class="id-label">Nama Ormawa</td>
            <td class="id-sep">:</td>
            <td>Lembaga Dakwah Kampus (LDK) Syahid UIN Syarif Hidayatullah Jakarta</td>
        </tr>
        <tr>
            <td class="id-label">Nomor HP / WhatsApp</td>
            <td class="id-sep">:</td>
            <td>{{ $data['no_hp_ketua_pelaksana'] ?? $data['narahubung'] ?? '-' }}</td>
        </tr>
    </table>

    <p style="margin-top: 4pt; font-size: 9.5pt; text-align: justify; line-height: 1.2;">
        Sehubungan dengan pengajuan peminjaman tempat/sarana dan prasarana tersebut di atas kepada Biro Administrasi Umum dan Kepegawaian (BAUK) UIN Syarif Hidayatullah Jakarta, dengan ini saya menyatakan berkomitmen dan bertanggung jawab penuh untuk:
    </p>

    <ol class="list-komitmen">
        <li>Melaksanakan seluruh rangkaian kegiatan sesuai dengan proposal dan susunan acara (<em>rundown</em>) yang telah diverifikasi Tim Kemahasiswaan dan Alumni dan disetujui oleh Wakil Rektor Bidang Kemahasiswaan;</li>
        <li>Memulai dan mengakhiri kegiatan tepat waktu sesuai dengan durasi yang tercantum dalam izin kegiatan;</li>
        <li>Tidak akan menambahkan, menyisipkan, atau mengubah mata acara/konten kegiatan secara sepihak di luar susunan acara yang telah disetujui (termasuk dilarang adanya agenda terselubung);</li>
        <li>Menjaga kebersihan, kerapihan, ketertiban, dan keamanan lingkungan kampus, serta mengembalikan kondisi tempat/sarana dan prasarana dalam keadaan baik seperti semula setelah kegiatan selesai;</li>
        <li>Menjamin bahwa kegiatan ini bersifat mandiri serta tidak melibatkan, memfasilitasi, atau berafiliasi dengan organisasi luar kampus, partai politik, maupun organisasi yang dilarang oleh hukum;</li>
        <li>Mematuhi segala ketentuan dalam Kode Etik Mahasiswa UIN Syarif Hidayatullah Jakarta, serta norma hukum, agama, dan kesusilaan;</li>
        <li>Menjaga kondusifitas lingkungan kampus dan tidak menimbulkan kebisingan yang mengganggu kegiatan perkuliahan;</li>
        <li>Menghentikan seluruh aktivitas kegiatan sementara (jeda) minimal 10 menit setiap memasuki waktu shalat fardhu;</li>
        <li>Menyusun dan menyerahkan Laporan Pertanggungjawaban (LPJ) kegiatan dan keuangan secara jujur dan transparan paling lambat 14 hari setelah kegiatan berakhir kepada Tim Kemahasiswaan dan Alumni;</li>
        <li>Menjamin bahwa penggunaan anggaran negara dalam kegiatan ini dapat dipertanggungjawabkan sesuai dengan regulasi keuangan yang berlaku.</li>
    </ol>

    <p style="margin-top: 4pt; font-size: 9.5pt; text-align: justify; line-height: 1.2;">
        Apabila ditemukan pelanggaran terhadap poin-poin komitmen di atas, baik pada saat pelaksanaan kegiatan berlangsung maupun setelah kegiatan berakhir, saya beserta seluruh panitia dan pengurus Ormawa bersedia menerima sanksi berupa:
    </p>

    <ol class="list-sanksi">
        <li>Penghentian atau pembubaran kegiatan seketika oleh pihak berwenang saat acara berlangsung;</li>
        <li>Sanksi administratif berupa penundaan atau pembekuan izin kegiatan organisasi pada periode berikutnya;</li>
        <li>Sanksi akademik sesuai peraturan yang berlaku di UIN Syarif Hidayatullah Jakarta.</li>
    </ol>

    <p style="margin-top: 4pt; font-size: 9.5pt; line-height: 1.2;">
        Demikian Pernyataan ini saya buat dengan sadar dan penuh rasa tanggung jawab.
    </p>

    <table class="signature-lampiran-single">
        <tr>
            <td>
                Jakarta, {{ $tanggalSurat }}<br>
                Yang Menyatakan,<br>
                <strong>Ketua Pelaksana</strong><br>
                <div style="height: 16mm;"></div>
                <strong>{{ $data['nama_ketua_pelaksana'] ?? $data['nama'] ?? '.........................................' }}</strong><br>
                NIM. {{ $data['nim_ketua_pelaksana'] ?? $data['nim'] ?? '.........................' }}
            </td>
        </tr>
    </table>
</div>
