{{-- Flatpickr CDN --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

<script>
(function () {
    var deptRegistry = @json(\App\Support\DepartmentRegistry::items());
    var oldData = @json(old() ?: ($reapplyLog?->data ?? []));

    var fieldMap = {
        'izin-orang-tua': [
            { name: 'kode_bidang',  label: 'Asal Bidang / LDKSF Pengaju', icon: 'fa-sitemap', type: 'dept-picker' },
            { name: 'nama_acara',   label: 'Nama Acara',                  icon: 'fa-star',    placeholder: 'Contoh: Rihlah LDK Syahid 2026' },
            { name: 'tema_acara',   label: 'Tema Acara',                  icon: 'fa-tag',     placeholder: 'Contoh: Membangun Generasi Islami' },
            { name: 'hari_tanggal', label: 'Tanggal Pelaksanaan',         icon: 'fa-calendar', type: 'date' },
            { name: 'waktu',        label: 'Waktu Pelaksanaan',           icon: 'fa-clock',    type: 'time-range' },
            { name: 'tempat',       label: 'Tempat Pelaksanaan',          icon: 'fa-map-marker-alt', placeholder: 'Contoh: Aula Madya UIN Jakarta' },
        ],
        'peminjaman-alat': [
            { name: 'kode_bidang',      label: 'Asal Bidang / LDKSF Pengaju', icon: 'fa-sitemap', type: 'dept-picker' },
            { name: 'jenis_peminjaman', label: 'Sifat Peminjaman',     icon: 'fa-tag',    type: 'select',
              options: [{value:'internal',label:'Internal (LDK Syahid)'},{value:'eksternal',label:'Eksternal'}] },
            { name: 'nama_acara',       label: 'Nama Acara',           icon: 'fa-star',         placeholder: 'Contoh: Seminar Nasional' },
            { name: 'tema_acara',       label: 'Tema Acara',           icon: 'fa-tag',          placeholder: 'Contoh: Moderasi Beragama di Era Digital' },
            { name: 'ditujukan_kepada', label: 'Ditujukan Kepada',     icon: 'fa-envelope',     placeholder: 'Contoh: Kepala Biro Umum / Bagian Logistik' },
            { name: 'hari_tanggal',     label: 'Tanggal Peminjaman',   icon: 'fa-calendar',     type: 'date' },
            { name: 'waktu',            label: 'Waktu Peminjaman',     icon: 'fa-clock',        type: 'time-range' },
            { name: 'tempat',           label: 'Tempat Penggunaan',    icon: 'fa-map-marker-alt', placeholder: 'Contoh: Aula Student Center Lt. 3' },
            { name: 'daftar_alat',      label: 'Daftar Alat yang Dipinjam', icon: 'fa-list-ol', type: 'textarea', placeholder: "Tuliskan daftar alat (1 per baris):\n1. Proyektor Epson 1 unit\n2. Sound Portable 1 set\n3. Kabel Roll 2 buah" },
        ],
        'peminjaman-tempat-kampus': [
            { name: 'kode_bidang',          label: 'Asal Bidang / LDKSF Pengaju', icon: 'fa-sitemap', type: 'dept-picker' },
            { name: 'nama_acara',           label: 'Nama Acara',             icon: 'fa-star',     placeholder: 'Contoh: Pelatihan Kepemimpinan' },
            { name: 'tema_acara',           label: 'Tema Acara',             icon: 'fa-tag',      placeholder: 'Contoh: Menyiapkan Pemimpin Peradaban' },
            { name: 'nama_ketua_pelaksana', label: 'Nama Ketua Pelaksana',   icon: 'fa-user',     placeholder: 'Contoh: Muhammad Syauqi Mubarak' },
            { name: 'nim_ketua_pelaksana',  label: 'NIM Ketua Pelaksana',    icon: 'fa-id-card',  inputmode: 'numeric', pattern: '[0-9]*', placeholder: 'Contoh: 11230600000067' },
            { name: 'ditujukan_kepada',     label: 'Ditujukan Kepada',       icon: 'fa-envelope', placeholder: 'Contoh: Kepala Bagian Umum UIN Jakarta' },
            { name: 'hari_tanggal',         label: 'Tanggal Peminjaman',     icon: 'fa-calendar', type: 'date' },
            { name: 'waktu',                label: 'Waktu Peminjaman',       icon: 'fa-clock',    type: 'time-range' },
            { name: 'tempat_dipinjam',      label: 'Tempat yang Dipinjam',   icon: 'fa-building', placeholder: 'Contoh: Aula Student Center Lt. 3 / Lapangan SC' },
        ],
        'peminjaman-tempat-fakultas': [
            { name: 'kode_bidang',          label: 'Asal Bidang / LDKSF Pengaju', icon: 'fa-sitemap', type: 'dept-picker' },
            { name: 'nama_acara',           label: 'Nama Acara',             icon: 'fa-star',     placeholder: 'Contoh: Seminar Fakultas' },
            { name: 'tema_acara',           label: 'Tema Acara',             icon: 'fa-tag',      placeholder: 'Contoh: Eksplorasi Sains Islam' },
            { name: 'nama_ketua_pelaksana', label: 'Nama Ketua Pelaksana',   icon: 'fa-user',     placeholder: 'Contoh: Ahmad Fulan' },
            { name: 'nim_ketua_pelaksana',  label: 'NIM Ketua Pelaksana',    icon: 'fa-id-card',  inputmode: 'numeric', pattern: '[0-9]*', placeholder: 'Contoh: 11230000000001' },
            { name: 'ditujukan_kepada',     label: 'Ditujukan Kepada',       icon: 'fa-envelope', placeholder: 'Contoh: Dekan Fakultas Sains dan Teknologi' },
            { name: 'hari_tanggal',         label: 'Tanggal Peminjaman',     icon: 'fa-calendar', type: 'date' },
            { name: 'waktu',                label: 'Waktu Peminjaman',       icon: 'fa-clock',    type: 'time-range' },
            { name: 'tempat_dipinjam',      label: 'Tempat yang Dipinjam',   icon: 'fa-building', placeholder: 'Contoh: Teater FST Lt. 2' },
        ],
        'peminjaman-tempat-luar-kampus': [
            { name: 'kode_bidang',          label: 'Asal Bidang / LDKSF Pengaju', icon: 'fa-sitemap', type: 'dept-picker' },
            { name: 'nama_acara',           label: 'Nama Acara',             icon: 'fa-star',     placeholder: 'Contoh: Kemah Bakti Syahid' },
            { name: 'tema_acara',           label: 'Tema Acara',             icon: 'fa-tag',      placeholder: 'Contoh: Harmoni Alam dan Iman' },
            { name: 'nama_ketua_pelaksana', label: 'Nama Ketua Pelaksana',   icon: 'fa-user',     placeholder: 'Contoh: Ahmad Fulan' },
            { name: 'nim_ketua_pelaksana',  label: 'NIM Ketua Pelaksana',    icon: 'fa-id-card',  inputmode: 'numeric', pattern: '[0-9]*', placeholder: 'Contoh: 11230000000001' },
            { name: 'ditujukan_kepada',     label: 'Ditujukan Kepada',       icon: 'fa-envelope', placeholder: 'Contoh: Pengelola Villa Bukit Cisarua' },
            { name: 'hari_tanggal',         label: 'Tanggal Peminjaman',     icon: 'fa-calendar', type: 'date' },
            { name: 'waktu',                label: 'Waktu Peminjaman',       icon: 'fa-clock',    type: 'time-range' },
            { name: 'tempat_dipinjam',      label: 'Tempat yang Dipinjam',   icon: 'fa-map-marker-alt', placeholder: 'Contoh: Villa & Lapangan Utama' },
        ],
        'permohonan-bantuan-dana': [
            { name: 'kode_bidang',      label: 'Asal Bidang / LDKSF Pengaju', icon: 'fa-sitemap', type: 'dept-picker' },
            { name: 'nama_program',     label: 'Nama Program/Acara',   icon: 'fa-hand-holding-usd', placeholder: 'Contoh: Syahid Peduli Ummat 2026' },
            { name: 'ditujukan_kepada', label: 'Ditujukan Kepada',     icon: 'fa-envelope',     placeholder: 'Contoh: Pimpinan BAZNAS RI / Direktur Utama PT...' },
            { name: 'keperluan',        label: 'Tujuan & Rincian Penggunaan Dana', icon: 'fa-align-left', type: 'textarea', placeholder: 'Jelaskan tujuan permohonan bantuan dana serta ringkasan peruntukan anggaran kegiatan...' },
        ],
        'permohonan-izin-luar-kampus': [
            { name: 'kode_bidang',   label: 'Asal Bidang / LDKSF Pengaju', icon: 'fa-sitemap', type: 'dept-picker' },
            { name: 'nama_acara',    label: 'Nama Acara',           icon: 'fa-star',            placeholder: 'Contoh: Rihlah Akbar Pengurus LDK Syahid' },
            { name: 'tema_acara',    label: 'Tema Acara',           icon: 'fa-tag',             placeholder: 'Contoh: Menjalin Ukhuwah, Menggapai Berkah' },
            { name: 'hari_tanggal',  label: 'Tanggal Pelaksanaan',  icon: 'fa-calendar',        type: 'date' },
            { name: 'waktu',         label: 'Waktu Pelaksanaan',    icon: 'fa-clock',           type: 'time-range' },
            { name: 'tempat',        label: 'Tempat/Lokasi Acara',  icon: 'fa-map-marker-alt',  placeholder: 'Contoh: Villa Bukit Cisarua' },
            { name: 'alamat_tempat', label: 'Alamat Lengkap',       icon: 'fa-directions',      placeholder: 'Contoh: Jl. Raya Puncak KM 84, Cisarua, Bogor, Jawa Barat' },
        ],
        'surat-rekomendasi': [
            { name: 'kode_bidang',          label: 'Asal Bidang / LDKSF Pengaju', icon: 'fa-sitemap', type: 'dept-picker' },
            { name: 'nama',                 label: 'Nama Lengkap Mahasiswa', icon: 'fa-user',  placeholder: 'Contoh: Ahmad Fulan' },
            { name: 'nim',                  label: 'NIM Mahasiswa',       icon: 'fa-id-card',  inputmode: 'numeric', pattern: '[0-9]*', placeholder: 'Contoh: 11230000000001' },
            { name: 'fakultas',             label: 'Fakultas',            icon: 'fa-school',   placeholder: 'Contoh: Sains dan Teknologi' },
            { name: 'jurusan',              label: 'Program Studi / Jurusan', icon: 'fa-graduation-cap', placeholder: 'Contoh: Teknik Informatika' },
            { name: 'jabatan',              label: 'Jabatan di LDK Syahid', icon: 'fa-briefcase', placeholder: 'Contoh: Ketua Departemen Kaderisasi' },
            { name: 'program_rekomendasi',  label: 'Untuk Keperluan / Program', icon: 'fa-award', placeholder: 'Contoh: Pendaftaran Beasiswa Unggulan 2026' },
            { name: 'pertimbangan',         label: 'Keterangan Pertimbangan', icon: 'fa-align-left', type: 'textarea', placeholder: 'Tuliskan pertimbangan rekomendasi (contoh: Mahasiswa aktif, berprestasi, dan memiliki integritas tinggi...)' },
        ],
        'surat-undangan': [
            { name: 'kode_bidang',      label: 'Asal Bidang / LDKSF Pengaju', icon: 'fa-sitemap', type: 'dept-picker' },
            { name: 'jenis_undangan',   label: 'Sifat Undangan',       icon: 'fa-tag',    type: 'select',
              options: [{value:'internal',label:'Internal Kampus (UIN Syahid)'},{value:'eksternal',label:'Eksternal Kampus'}] },
            { name: 'nama_acara',       label: 'Nama Acara',           icon: 'fa-star',         placeholder: 'Contoh: Milad Akbar LDK Syahid ke-30' },
            { name: 'tema_acara',       label: 'Tema Acara',           icon: 'fa-tag',          placeholder: 'Contoh: Tiga Dekade Menebar Inspirasi Kebaikan' },
            { name: 'ditujukan_kepada', label: 'Ditujukan Kepada',     icon: 'fa-envelope',     placeholder: 'Contoh: Ketua BEM UIN Syarif Hidayatullah Jakarta' },
            { name: 'hari_tanggal',     label: 'Tanggal Acara',        icon: 'fa-calendar',     type: 'date' },
            { name: 'waktu',            label: 'Waktu Acara',          icon: 'fa-clock',        type: 'time-range' },
            { name: 'tempat',           label: 'Tempat Pelaksanaan',   icon: 'fa-map-marker-alt', placeholder: 'Contoh: Auditorium Harun Nasution' },
        ],
        'surat-aktif-organisasi': [
            { name: 'kode_bidang',   label: 'Asal Bidang / LDKSF Pengaju', icon: 'fa-sitemap', type: 'dept-picker' },
            { name: 'nama',          label: 'Nama Lengkap Mahasiswa', icon: 'fa-user',        placeholder: 'Contoh: Ahmad Fulan' },
            { name: 'ttl',           label: 'Tempat, Tanggal Lahir', icon: 'fa-birthday-cake', placeholder: 'Contoh: Jakarta, 17 Agustus 2003' },
            { name: 'nim',           label: 'NIM Mahasiswa',       icon: 'fa-id-card',        inputmode: 'numeric', pattern: '[0-9]*', placeholder: 'Contoh: 11230000000001' },
            { name: 'fakultas',      label: 'Fakultas',            icon: 'fa-school',         placeholder: 'Contoh: Ushuluddin' },
            { name: 'jurusan',       label: 'Jurusan / Prodi',     icon: 'fa-graduation-cap', placeholder: 'Contoh: Ilmu Al-Qur\'an dan Tafsir' },
            { name: 'jabatan',       label: 'Jabatan di LDK Syahid', icon: 'fa-briefcase',    placeholder: 'Contoh: Anggota Bidang Syiar' },
            { name: 'keperluan',     label: 'Tujuan Surat Digunakan', icon: 'fa-file-alt',    placeholder: 'Contoh: Pengajuan Beasiswa Kemitraan' },
            { name: 'penyelenggara', label: 'Lembaga / Instansi Penyelenggara', icon: 'fa-building', placeholder: 'Contoh: Kementerian Agama RI' },
        ],
        'permohonan-pemateri': [
            { name: 'kode_bidang',      label: 'Asal Bidang / LDKSF Pengaju', icon: 'fa-sitemap', type: 'dept-picker' },
            { name: 'nama_acara',       label: 'Nama Acara',           icon: 'fa-star',            placeholder: 'Contoh: Kajian Spesial Ramadhan' },
            { name: 'tema_acara',       label: 'Tema Acara',           icon: 'fa-tag',             placeholder: 'Contoh: Menghidupkan Nilai Al-Qur\'an di Era Digital' },
            { name: 'ditujukan_kepada', label: 'Ditujukan Kepada (Calon Pemateri)', icon: 'fa-user-tie', placeholder: 'Contoh: Ustadz Dr. Fulan, M.A.' },
            { name: 'hari_tanggal',     label: 'Tanggal Acara',        icon: 'fa-calendar',        type: 'date' },
            { name: 'waktu',            label: 'Waktu Pelaksanaan',    icon: 'fa-clock',           type: 'time-range' },
            { name: 'tempat',           label: 'Tempat Acara',         icon: 'fa-map-marker-alt',  placeholder: 'Contoh: Masjid Al-Jami\'ah UIN Jakarta / Zoom Meeting' },
            { name: 'materi',           label: 'Topik / Materi yang Dimohonkan', icon: 'fa-book-open', placeholder: 'Contoh: Fiqih Prioritas dalam Gerakan Dakwah Kampus' },
        ],
        'permohonan-sambutan': [
            { name: 'kode_bidang',      label: 'Asal Bidang / LDKSF Pengaju', icon: 'fa-sitemap', type: 'dept-picker' },
            { name: 'nama_acara',       label: 'Nama Acara',           icon: 'fa-star',            placeholder: 'Contoh: Seminar Nasional Pemuda Muslim' },
            { name: 'tema_acara',       label: 'Tema Acara',           icon: 'fa-tag',             placeholder: 'Contoh: Kontribusi Pemuda Menuju Indonesia Emas' },
            { name: 'ditujukan_kepada', label: 'Ditujukan Kepada',     icon: 'fa-user-tie',        placeholder: 'Contoh: Prof. Dr. Hj. Fulanah, M.A.' },
            { name: 'jabatan_tujuan',   label: 'Jabatan Pimpinan',     icon: 'fa-briefcase',       placeholder: 'Contoh: Wakil Rektor Bidang Kemahasiswaan' },
            { name: 'hari_tanggal',     label: 'Tanggal Acara',        icon: 'fa-calendar',        type: 'date' },
            { name: 'waktu',            label: 'Waktu Sambutan',       icon: 'fa-clock',           type: 'time-range' },
            { name: 'tempat',           label: 'Tempat Acara',         icon: 'fa-map-marker-alt',  placeholder: 'Contoh: Auditorium Harun Nasution' },
        ],
        'surat-izin-buka-stand': [
            { name: 'kode_bidang',      label: 'Asal Bidang / LDKSF Pengaju', icon: 'fa-sitemap', type: 'dept-picker' },
            { name: 'nama_acara',       label: 'Nama Agenda / Kegiatan Stand', icon: 'fa-store',  placeholder: 'Contoh: Stand Open Recruitment & Expo UKM' },
            { name: 'ditujukan_kepada', label: 'Ditujukan Kepada',     icon: 'fa-envelope',        placeholder: 'Contoh: Pengelola Gedung Student Center UIN Jakarta' },
            { name: 'hari_tanggal',     label: 'Tanggal Stand',        icon: 'fa-calendar',        type: 'date' },
            { name: 'waktu',            label: 'Waktu Operasional Stand', icon: 'fa-clock',        type: 'time-range' },
            { name: 'tempat',           label: 'Lokasi Stand',         icon: 'fa-map-marker-alt',  placeholder: 'Contoh: Lobby Student Center Lt. 1' },
            { name: 'keperluan',        label: 'Rincian Kegiatan Stand', icon: 'fa-align-left',    type: 'textarea', placeholder: 'Jelaskan keperluan pembukaan stand (contoh: Sosialisasi pendaftaran anggota baru dan penjualan merchandise resmi)...' },
        ],
        'surat-izin-pengambilan-gambar-video': [
            { name: 'kode_bidang',      label: 'Asal Bidang / LDKSF Pengaju', icon: 'fa-sitemap', type: 'dept-picker' },
            { name: 'nama_acara',       label: 'Nama Agenda Peliputan', icon: 'fa-camera',       placeholder: 'Contoh: Shooting Video Profil & Dokumentasi Milad' },
            { name: 'ditujukan_kepada', label: 'Ditujukan Kepada',     icon: 'fa-envelope',        placeholder: 'Contoh: Kepala Biro Administrasi Umum' },
            { name: 'hari_tanggal',     label: 'Tanggal Pengambilan',  icon: 'fa-calendar',        type: 'date' },
            { name: 'waktu',            label: 'Waktu Pengambilan',    icon: 'fa-clock',           type: 'time-range' },
            { name: 'tempat',           label: 'Area / Spot Pengambilan', icon: 'fa-map-marker-alt', placeholder: 'Contoh: Taman Kampus 1 dan Area SC' },
            { name: 'keperluan',        label: 'Keperluan / Konten Video', icon: 'fa-align-left',  type: 'textarea', placeholder: 'Tuliskan tujuan pengambilan gambar/video dan daftar kru peliput...' },
        ],
        'surat-kunjungan-lembaga': [
            { name: 'kode_bidang',      label: 'Asal Bidang / LDKSF Pengaju', icon: 'fa-sitemap', type: 'dept-picker' },
            { name: 'nama_kegiatan',    label: 'Nama Agenda Kunjungan', icon: 'fa-people-arrows', placeholder: 'Contoh: Studi Banding & Silaturahmi Lembaga' },
            { name: 'ditujukan_kepada', label: 'Lembaga / Instansi Tujuan', icon: 'fa-building', placeholder: 'Contoh: Pengurus LDK SALAM Universitas Indonesia' },
            { name: 'hari_tanggal',     label: 'Tanggal Kunjungan',    icon: 'fa-calendar',        type: 'date' },
            { name: 'waktu',            label: 'Waktu Kunjungan',      icon: 'fa-clock',           type: 'time-range' },
            { name: 'tempat',           label: 'Tempat / Lokasi Kunjungan', icon: 'fa-map-marker-alt', placeholder: 'Contoh: Pusgiwa UI Depok' },
            { name: 'keperluan',        label: 'Tujuan & Pembahasan',  icon: 'fa-align-left',      type: 'textarea', placeholder: 'Jelaskan tujuan kunjungan, poin diskusi kemitraan, dan perkiraan jumlah delegasi...' },
        ],
        'surat-imbauan': [
            { name: 'kode_bidang',      label: 'Asal Bidang / LDKSF Pengaju', icon: 'fa-sitemap', type: 'dept-picker' },
            { name: 'perihal_imbauan',  label: 'Perihal Imbauan',      icon: 'fa-bullhorn',        placeholder: 'Contoh: Imbauan Ketertiban & Partisipasi Pemilu Raya' },
            { name: 'ditujukan_kepada', label: 'Ditujukan Kepada',     icon: 'fa-envelope',        placeholder: 'Contoh: Seluruh Pengurus dan Kader LDK Syahid' },
            { name: 'poin_imbauan',     label: 'Poin-Poin Imbauan',    icon: 'fa-list-ol',         type: 'textarea', placeholder: "Tuliskan poin imbauan (1 per baris):\n1. Menjaga netralitas dan etika dakwah\n2. Berpartisipasi aktif dengan damai\n3. Menjaga ukhuwah islamiyah" },
        ],
        'kerja-sama-sponsorship': [
            { name: 'kode_bidang',      label: 'Asal Bidang / LDKSF Pengaju', icon: 'fa-sitemap', type: 'dept-picker' },
            { name: 'nama_acara',       label: 'Nama Acara',           icon: 'fa-star',            placeholder: 'Contoh: Festival Syahid Fest 2026' },
            { name: 'tema_acara',       label: 'Tema Acara',           icon: 'fa-tag',             placeholder: 'Contoh: Eksplorasi Seni & Budaya Islami Nusantara' },
            { name: 'ditujukan_kepada', label: 'Mitra / Perusahaan Tujuan', icon: 'fa-handshake', placeholder: 'Contoh: Pimpinan PT Telkom Indonesia / Paragon Corp' },
            { name: 'bentuk_kerjasama', label: 'Bentuk Kerja Sama yang Ditawarkan', icon: 'fa-align-left', type: 'textarea', placeholder: 'Jelaskan paket sponsorship, publikasi logo, media partner, atau benefit kemitraan yang ditawarkan...' },
        ],
        'surat-pemberitahuan': [
            { name: 'kode_bidang',      label: 'Asal Bidang / LDKSF Pengaju', icon: 'fa-sitemap', type: 'dept-picker' },
            { name: 'nama_kegiatan',    label: 'Nama Kegiatan',        icon: 'fa-star',            placeholder: 'Contoh: Pelaksanaan Training Advokasi Mahasiswa' },
            { name: 'ditujukan_kepada', label: 'Ditujukan Kepada',     icon: 'fa-envelope',        placeholder: 'Contoh: Koordinator Keamanan Kampus 1 UIN Jakarta' },
            { name: 'hari_tanggal',     label: 'Tanggal Kegiatan',     icon: 'fa-calendar',        type: 'date' },
            { name: 'waktu',            label: 'Waktu Kegiatan',       icon: 'fa-clock',           type: 'time-range' },
            { name: 'tempat',           label: 'Tempat Kegiatan',      icon: 'fa-map-marker-alt',  placeholder: 'Contoh: Lapangan Student Center' },
        ],
    };

    function escapeAttr(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }

    function renderFields(type) {
        var container = document.getElementById('dynamic-fields');
        var submitBtn = document.getElementById('btn-submit-wrapper');
        if (!container || !submitBtn) return;

        container.innerHTML = '';

        var fields = fieldMap[type];
        if (!fields) {
            submitBtn.style.setProperty('display', 'none', 'important');
            return;
        }

        fields.forEach(function (f) {
            var val = oldData[f.name] || '';
            var group = document.createElement('div');
            group.className = 'prs-form-group';

            var iconHtml   = '<i class="fas ' + (f.icon || 'fa-pencil-alt') + '"></i>';
            var prefixIcon = '<i class="fas ' + (f.icon || 'fa-pencil-alt') + ' prs-input-prefix-icon"></i>';

            // 1. DEPARTMENT / FACULTY PICKER (MODERN CHOOSE MODAL)
            if (f.type === 'dept-picker') {
                var selectedDept = deptRegistry[val] || null;
                var labelHtml = '<label class="prs-form-label"><i class="fas fa-sitemap"></i> ' + f.label + '</label>';

                var pickerHtml = '<input type="hidden" name="kode_bidang" id="field_kode_bidang" value="' + escapeAttr(val) + '" required>' +
                    '<div class="prs-picker-card ' + (selectedDept ? 'has-value' : '') + '" id="prsDeptPickerTrigger" role="button" tabindex="0" data-bs-toggle="modal" data-bs-target="#modalChooseDepartment">' +
                        '<div class="prs-picker-icon-wrap" id="prsDeptPickerIcon">' +
                            '<i class="fas ' + (selectedDept ? selectedDept.icon : 'fa-sitemap') + '"></i>' +
                        '</div>' +
                        '<div class="prs-picker-content">' +
                            '<div class="prs-picker-title" id="prsDeptPickerTitle">' +
                                (selectedDept ? escapeAttr(selectedDept.name) : 'Pilih Bidang / LDKSF Pengaju...') +
                            '</div>' +
                            '<div class="prs-picker-desc" id="prsDeptPickerDesc">' +
                                (selectedDept ? escapeAttr(selectedDept.desc) : 'Klik untuk memilih dari 13 Bidang Pusat atau 10 LDKS Fakultas') +
                            '</div>' +
                        '</div>' +
                        '<div class="prs-picker-action">' +
                            '<span class="prs-picker-btn">' +
                                '<span>' + (selectedDept ? 'Ganti' : 'Pilih Bidang') + '</span>' +
                                '<i class="fas fa-th-large ms-1"></i>' +
                            '</span>' +
                        '</div>' +
                    '</div>';

                group.innerHTML = labelHtml + pickerHtml;
            }
            // 2. SELECT FIELD
            else if (f.type === 'select') {
                var optsHtml = (f.options || []).map(function (o) {
                    var isSelected = String(val) === String(o.value) ? ' selected' : '';
                    return '<option value="' + escapeAttr(o.value) + '"' + isSelected + '>' + escapeAttr(o.label) + '</option>';
                }).join('');

                var labelHtml = '<label class="prs-form-label" for="field_' + f.name + '">' + iconHtml + ' ' + f.label + '</label>';
                var selectHtml = '<div class="prs-input-group">' + prefixIcon +
                    '<select name="' + f.name + '" id="field_' + f.name + '" class="prs-form-select" required>' +
                    '<option value="" disabled' + (!val ? ' selected' : '') + '>-- Pilih ' + escapeAttr(f.label) + ' --</option>' +
                    optsHtml +
                    '</select></div>';
                group.innerHTML = labelHtml + selectHtml;
            }
            // 3. TEXTAREA FIELD
            else if (f.type === 'textarea') {
                var labelHtml = '<label class="prs-form-label" for="field_' + f.name + '">' + iconHtml + ' ' + f.label + '</label>';
                var textareaHtml = '<div class="prs-input-group">' + prefixIcon +
                    '<textarea name="' + f.name + '" id="field_' + f.name + '" class="prs-form-textarea" placeholder="' + escapeAttr(f.placeholder || '') + '" rows="3" required>' + escapeAttr(val) + '</textarea>' +
                    '</div>';
                group.innerHTML = labelHtml + textareaHtml;
            }
            // 4. DATEPICKER FIELD
            else if (f.type === 'date') {
                var isRange = val.indexOf('to') !== -1 || val.indexOf('s.d.') !== -1;

                var labelHtml = '<div class="d-flex align-items-center justify-content-between mb-2">' +
                    '<label class="prs-form-label mb-0" for="field_' + f.name + '">' + iconHtml + ' ' + f.label + '</label>' +
                    '<div class="prs-date-toggle-wrap">' +
                        '<button type="button" class="prs-date-toggle-btn' + (!isRange ? ' active' : '') + '" id="btn_date_single">1 Hari</button>' +
                        '<button type="button" class="prs-date-toggle-btn' + (isRange ? ' active' : '') + '" id="btn_date_range">Multi-Hari (Rentang)</button>' +
                    '</div>' +
                '</div>';

                var inputHtml = '<div class="prs-input-group">' + prefixIcon +
                    '<input type="hidden" name="' + f.name + '" id="field_' + f.name + '" value="' + escapeAttr(val) + '">' +
                    '<input type="text" id="input_hari_tanggal_picker" class="prs-form-input prs-datepicker" placeholder="Klik untuk memilih tanggal..." readonly required>' +
                    '</div>' +
                    '<span class="prs-form-hint" id="hint_hari_tanggal"><i class="fas fa-info-circle me-1 text-primary"></i> Format tanggal otomatis diterjemahkan ke Bahasa Indonesia di surat.</span>';

                group.innerHTML = labelHtml + inputHtml;
            }
            // 5. TIME RANGE PICKER FIELD
            else if (f.type === 'time-range') {
                var labelHtml = '<label class="prs-form-label" for="field_' + f.name + '">' + iconHtml + ' ' + f.label + '</label>';

                var inputHtml = '<input type="hidden" name="' + f.name + '" id="field_' + f.name + '" value="' + escapeAttr(val || '08.00 s.d. 16.00 WIB') + '">' +
                    '<div class="prs-time-box">' +
                        '<div class="row g-2 align-items-center">' +
                            '<div class="col-sm-4 col-6">' +
                                '<label class="small text-muted mb-1" style="font-size:0.76rem; font-weight:600;"><i class="fas fa-play-circle me-1 text-primary"></i> Jam Mulai</label>' +
                                '<div class="prs-input-group">' +
                                    '<input type="text" id="picker_time_start" class="prs-form-input prs-time-picker text-center font-weight-bold" style="padding-left:0.9rem!important;" value="08:00" readonly>' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-sm-4 col-6">' +
                                '<label class="small text-muted mb-1" style="font-size:0.76rem; font-weight:600;"><i class="fas fa-hourglass-end me-1 text-primary"></i> Jam Selesai</label>' +
                                '<div class="prs-input-group">' +
                                    '<input type="text" id="picker_time_end" class="prs-form-input prs-time-picker text-center font-weight-bold" style="padding-left:0.9rem!important;" value="16:00" readonly>' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-sm-4 col-12">' +
                                '<label class="small text-muted mb-1" style="font-size:0.76rem; font-weight:600;"><i class="fas fa-globe me-1 text-primary"></i> Zona</label>' +
                                '<select id="select_timezone" class="prs-form-select" style="padding-left:0.8rem!important; padding-right:1.8rem!important;">' +
                                    '<option value="WIB" selected>WIB (Waktu Indonesia Barat)</option>' +
                                    '<option value="WITA">WITA (Waktu Indonesia Tengah)</option>' +
                                    '<option value="WIT">WIT (Waktu Indonesia Timur)</option>' +
                                '</select>' +
                            '</div>' +
                            '<div class="col-12 mt-2">' +
                                '<div class="form-check">' +
                                    '<input class="form-check-input" type="checkbox" id="check_until_finish" style="cursor:pointer;">' +
                                    '<label class="form-check-label text-muted small" for="check_until_finish" style="cursor:pointer; font-size:0.82rem;">' +
                                        'Acara berlangsung <strong>sampai selesai</strong> (tanpa batas jam berakhir)' +
                                    '</label>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                    '<span class="prs-form-hint mt-2" id="preview_waktu_text">' +
                        '<i class="fas fa-check-circle text-success me-1"></i> Format waktu di surat: <strong class="text-primary" id="badge_compiled_time">08.00 s.d. 16.00 WIB</strong>' +
                    '</span>';

                group.innerHTML = labelHtml + inputHtml;
            }
            // 6. STANDARD INPUT FIELD
            else {
                var labelHtml = '<label class="prs-form-label" for="field_' + f.name + '">' + iconHtml + ' ' + f.label + '</label>';
                var extraAttr = '';
                if (f.inputmode) extraAttr += ' inputmode="' + f.inputmode + '"';
                if (f.pattern) extraAttr += ' pattern="' + f.pattern + '"';

                var inputHtml = '<div class="prs-input-group">' + prefixIcon +
                    '<input type="text" name="' + f.name + '" id="field_' + f.name + '" class="prs-form-input" value="' + escapeAttr(val) + '" placeholder="' + escapeAttr(f.placeholder || '') + '"' + extraAttr + ' required>' +
                    '</div>';
                group.innerHTML = labelHtml + inputHtml;
            }

            container.appendChild(group);
        });

        // ── Initialize Datepicker with Single / Range Mode ──
        initDatePickers();

        // ── Initialize Interactive Time Pickers ──
        initTimePickers();

        // ── Re-bind Department Picker Event Handlers ──
        initDepartmentPicker();

        submitBtn.style.setProperty('display', 'block', 'important');
    }

    // Function to setup single or multi-day datepicker
    function initDatePickers() {
        var hiddenDateInput = document.getElementById('field_hari_tanggal');
        var pickerInput     = document.getElementById('input_hari_tanggal_picker') || document.querySelector('.prs-datepicker');
        var btnSingle       = document.getElementById('btn_date_single');
        var btnRange        = document.getElementById('btn_date_range');
        var hintDate        = document.getElementById('hint_hari_tanggal');

        if (!pickerInput || !hiddenDateInput || typeof flatpickr === 'undefined') return;

        var currentMode = (hiddenDateInput.value.indexOf('to') !== -1 || hiddenDateInput.value.indexOf('s.d.') !== -1) ? 'range' : 'single';
        var fpInstance = null;

        function createFlatpickr(mode) {
            if (fpInstance) {
                fpInstance.destroy();
            }

            var initialDate = hiddenDateInput.value || null;

            fpInstance = flatpickr(pickerInput, {
                mode: mode,
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: mode === 'single' ? 'l, j F Y' : 'j F Y',
                locale: 'id',
                minDate: 'today',
                defaultDate: initialDate,
                onChange: function (selectedDates, dateStr, instance) {
                    if (mode === 'single') {
                        hiddenDateInput.value = dateStr;
                        if (hintDate && selectedDates.length > 0) {
                            hintDate.innerHTML = '<i class="fas fa-check-circle text-success me-1"></i> Acara berlangsung 1 hari: <strong>' + instance.altInput.value + '</strong>';
                        }
                    } else {
                        if (selectedDates.length === 2) {
                            var d1 = instance.formatDate(selectedDates[0], 'Y-m-d');
                            var d2 = instance.formatDate(selectedDates[1], 'Y-m-d');
                            hiddenDateInput.value = d1 + ' to ' + d2;
                            if (hintDate) {
                                var alt1 = instance.formatDate(selectedDates[0], 'j F Y');
                                var alt2 = instance.formatDate(selectedDates[1], 'j F Y');
                                hintDate.innerHTML = '<i class="fas fa-check-circle text-success me-1"></i> Acara berlangsung multi-hari: <strong>' + alt1 + ' s.d. ' + alt2 + '</strong>';
                            }
                        } else if (selectedDates.length === 1) {
                            hiddenDateInput.value = dateStr;
                            if (hintDate) {
                                hintDate.innerHTML = '<i class="fas fa-info-circle text-primary me-1"></i> Silakan klik tanggal selesai di kalender.';
                            }
                        }
                    }
                }
            });
        }

        createFlatpickr(currentMode);

        if (btnSingle && btnRange) {
            btnSingle.addEventListener('click', function () {
                if (btnSingle.classList.contains('active')) return;
                btnSingle.classList.add('active');
                btnRange.classList.remove('active');
                pickerInput.placeholder = 'Pilih tanggal kegiatan (1 hari)...';
                createFlatpickr('single');
            });

            btnRange.addEventListener('click', function () {
                if (btnRange.classList.contains('active')) return;
                btnRange.classList.add('active');
                btnSingle.classList.remove('active');
                pickerInput.placeholder = 'Pilih rentang tanggal (mulai s.d. selesai)...';
                createFlatpickr('range');
            });
        }
    }

    // Function to setup interactive time pickers
    function initTimePickers() {
        var hiddenTimeInput = document.getElementById('field_waktu');
        var startInput      = document.getElementById('picker_time_start');
        var endInput        = document.getElementById('picker_time_end');
        var tzSelect        = document.getElementById('select_timezone');
        var checkUntil      = document.getElementById('check_until_finish');
        var badgeCompiled   = document.getElementById('badge_compiled_time');

        if (!hiddenTimeInput || !startInput || !endInput || typeof flatpickr === 'undefined') return;

        function updateCompiledTime() {
            var startVal = (startInput.value || '08:00').replace(':', '.');
            var endVal   = (endInput.value || '16:00').replace(':', '.');
            var tzVal    = tzSelect ? tzSelect.value : 'WIB';
            var isUntil  = checkUntil ? checkUntil.checked : false;

            var result = '';
            if (isUntil) {
                result = startVal + ' ' + tzVal + ' s.d. Selesai';
            } else {
                result = startVal + ' s.d. ' + endVal + ' ' + tzVal;
            }

            hiddenTimeInput.value = result;
            if (badgeCompiled) {
                badgeCompiled.textContent = result;
            }
        }

        flatpickr(startInput, {
            enableTime: true,
            noCalendar: true,
            dateFormat: 'H:i',
            time_24hr: true,
            minuteIncrement: 15,
            defaultDate: '08:00',
            onChange: function () {
                updateCompiledTime();
            }
        });

        flatpickr(endInput, {
            enableTime: true,
            noCalendar: true,
            dateFormat: 'H:i',
            time_24hr: true,
            minuteIncrement: 15,
            defaultDate: '16:00',
            onChange: function () {
                updateCompiledTime();
            }
        });

        if (tzSelect) {
            tzSelect.addEventListener('change', updateCompiledTime);
        }

        if (checkUntil) {
            checkUntil.addEventListener('change', function () {
                if (this.checked) {
                    endInput.disabled = true;
                    endInput.style.opacity = '0.5';
                } else {
                    endInput.disabled = false;
                    endInput.style.opacity = '1';
                }
                updateCompiledTime();
            });
        }

        updateCompiledTime();
    }

    // ============================================================
    // MODAL CHOOSE LETTER TYPE ENGINE
    // ============================================================
    var hiddenJenisInput = document.getElementById('jenis_surat');
    var triggerCard      = document.getElementById('prsPickerTrigger');
    var triggerIcon      = document.getElementById('prsPickerIcon');
    var triggerTitle     = document.getElementById('prsPickerTitle');
    var triggerDesc      = document.getElementById('prsPickerDesc');
    var searchInput      = document.getElementById('prsSearchInput');
    var clearSearchBtn   = document.getElementById('prsClearSearch');
    var catPills         = document.querySelectorAll('.prs-cat-pill:not(.prs-dept-cat-pill)');
    var letterCards      = document.querySelectorAll('.prs-letter-card:not(.prs-dept-card)');
    var emptySearchResult = document.getElementById('prsEmptySearch');

    function selectLetterType(key, label, desc, icon, badge) {
        if (!key) return;

        if (hiddenJenisInput) {
            hiddenJenisInput.value = key;
        }

        if (triggerCard) {
            triggerCard.classList.add('has-value');
        }

        if (triggerIcon && icon) {
            triggerIcon.innerHTML = '<i class="fas ' + icon + '"></i>';
        }

        if (triggerTitle && label) {
            triggerTitle.textContent = label;
        }

        if (triggerDesc && desc) {
            triggerDesc.textContent = desc;
        }

        letterCards.forEach(function (c) {
            if (c.getAttribute('data-key') === key) {
                c.classList.add('selected');
            } else {
                c.classList.remove('selected');
            }
        });

        renderFields(key);

        var modalEl = document.getElementById('modalChooseLetter');
        if (modalEl && typeof bootstrap !== 'undefined') {
            var modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) {
                modalInstance.hide();
            }
        }

        var container = document.getElementById('dynamic-fields');
        if (container) {
            setTimeout(function () {
                container.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }, 300);
        }
    }

    letterCards.forEach(function (card) {
        card.addEventListener('click', function () {
            var key   = this.getAttribute('data-key');
            var label = this.getAttribute('data-label');
            var desc  = this.getAttribute('data-desc');
            var icon  = this.getAttribute('data-icon');
            var badge = this.getAttribute('data-badge');
            selectLetterType(key, label, desc, icon, badge);
        });
    });

    var activeLetterCategory = 'all';

    function filterLetterCards() {
        var query = (searchInput ? searchInput.value.toLowerCase().trim() : '');
        var visibleCount = 0;

        if (clearSearchBtn) {
            clearSearchBtn.style.display = query.length > 0 ? 'flex' : 'none';
        }

        letterCards.forEach(function (card) {
            var cardCat   = card.getAttribute('data-category');
            var cardLabel = (card.getAttribute('data-label') || '').toLowerCase();
            var cardDesc  = (card.getAttribute('data-desc') || '').toLowerCase();
            var cardBadge = (card.getAttribute('data-badge') || '').toLowerCase();

            var matchesCat   = (activeLetterCategory === 'all' || cardCat === activeLetterCategory);
            var matchesQuery = (query === '' || cardLabel.indexOf(query) !== -1 || cardDesc.indexOf(query) !== -1 || cardBadge.indexOf(query) !== -1);

            if (matchesCat && matchesQuery) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (emptySearchResult) {
            emptySearchResult.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterLetterCards);
    }

    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', function () {
            if (searchInput) {
                searchInput.value = '';
                searchInput.focus();
                filterLetterCards();
            }
        });
    }

    catPills.forEach(function (pill) {
        pill.addEventListener('click', function () {
            catPills.forEach(function (p) { p.classList.remove('active'); });
            this.classList.add('active');
            activeLetterCategory = this.getAttribute('data-category');
            filterLetterCards();
        });
    });

    var modalElement = document.getElementById('modalChooseLetter');
    if (modalElement) {
        modalElement.addEventListener('shown.bs.modal', function () {
            if (searchInput) searchInput.focus();
        });
    }

    // ============================================================
    // MODAL CHOOSE DEPARTMENT / FACULTY ENGINE (LANDING PAGE)
    // ============================================================
    var deptCards        = document.querySelectorAll('.prs-dept-card');
    var searchDeptInput  = document.getElementById('prsSearchDeptInput');
    var clearDeptSearch  = document.getElementById('prsClearDeptSearch');
    var deptCatPills     = document.querySelectorAll('.prs-dept-cat-pill');
    var emptyDeptSearch  = document.getElementById('prsEmptyDeptSearch');
    var activeDeptCat    = 'all';

    function initDepartmentPicker() {
        var hiddenDeptInput = document.getElementById('field_kode_bidang');
        var triggerDeptCard = document.getElementById('prsDeptPickerTrigger');
        var triggerDeptIcon = document.getElementById('prsDeptPickerIcon');
        var triggerDeptTitle = document.getElementById('prsDeptPickerTitle');
        var triggerDeptDesc = document.getElementById('prsDeptPickerDesc');

        deptCards.forEach(function (card) {
            // Unbind previous to avoid duplicate listeners
            card.onclick = function () {
                var code = this.getAttribute('data-code');
                var name = this.getAttribute('data-name');
                var icon = this.getAttribute('data-icon');
                var desc = this.getAttribute('data-desc');

                if (hiddenDeptInput) {
                    hiddenDeptInput.value = code;
                }
                oldData['kode_bidang'] = code;

                if (triggerDeptCard) {
                    triggerDeptCard.classList.add('has-value');
                }
                if (triggerDeptIcon && icon) {
                    triggerDeptIcon.innerHTML = '<i class="fas ' + icon + '"></i>';
                }
                if (triggerDeptTitle && name) {
                    triggerDeptTitle.textContent = name;
                }
                if (triggerDeptDesc && desc) {
                    triggerDeptDesc.textContent = desc;
                }

                // Highlight active in modal
                deptCards.forEach(function (c) {
                    c.classList.toggle('selected', c.getAttribute('data-code') === code);
                });

                // Close Department modal
                var deptModalEl = document.getElementById('modalChooseDepartment');
                if (deptModalEl && typeof bootstrap !== 'undefined') {
                    var modalInst = bootstrap.Modal.getInstance(deptModalEl);
                    if (modalInst) {
                        modalInst.hide();
                    }
                }
            };
        });
    }

    function filterDeptCards() {
        var query = (searchDeptInput ? searchDeptInput.value.toLowerCase().trim() : '');
        var visibleCount = 0;

        if (clearDeptSearch) {
            clearDeptSearch.style.display = query.length > 0 ? 'flex' : 'none';
        }

        deptCards.forEach(function (card) {
            var cardCat   = card.getAttribute('data-cat');
            var cardName  = (card.getAttribute('data-name') || '').toLowerCase();
            var cardCode  = (card.getAttribute('data-code') || '').toLowerCase();
            var cardBadge = (card.getAttribute('data-badge') || '').toLowerCase();
            var cardDesc  = (card.getAttribute('data-desc') || '').toLowerCase();

            var matchesCat   = (activeDeptCat === 'all' || cardCat === activeDeptCat);
            var matchesQuery = (query === '' || cardName.indexOf(query) !== -1 || cardCode.indexOf(query) !== -1 || cardBadge.indexOf(query) !== -1 || cardDesc.indexOf(query) !== -1);

            if (matchesCat && matchesQuery) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (emptyDeptSearch) {
            emptyDeptSearch.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    if (searchDeptInput) {
        searchDeptInput.addEventListener('input', filterDeptCards);
    }

    if (clearDeptSearch) {
        clearDeptSearch.addEventListener('click', function () {
            if (searchDeptInput) {
                searchDeptInput.value = '';
                searchDeptInput.focus();
                filterDeptCards();
            }
        });
    }

    deptCatPills.forEach(function (pill) {
        pill.addEventListener('click', function () {
            deptCatPills.forEach(function (p) { p.classList.remove('active'); });
            this.classList.add('active');
            activeDeptCat = this.getAttribute('data-dept-cat');
            filterDeptCards();
        });
    });

    var deptModalElement = document.getElementById('modalChooseDepartment');
    if (deptModalElement) {
        deptModalElement.addEventListener('shown.bs.modal', function () {
            if (searchDeptInput) searchDeptInput.focus();
        });
    }

    // Initial render if preselected
    if (hiddenJenisInput && hiddenJenisInput.value) {
        renderFields(hiddenJenisInput.value);
    }

    // FAQ Accordion Toggle
    var faqItems = document.querySelectorAll('.prs-faq-item');
    faqItems.forEach(function (item) {
        var btn = item.querySelector('.prs-faq-question');
        var answer = item.querySelector('.prs-faq-answer');

        btn.addEventListener('click', function () {
            var isActive = item.classList.contains('active');

            faqItems.forEach(function (other) {
                other.classList.remove('active');
                other.querySelector('.prs-faq-answer').style.maxHeight = null;
            });

            if (!isActive) {
                item.classList.add('active');
                answer.style.maxHeight = answer.scrollHeight + 'px';
            }
        });
    });

    // Form submit loading state
    var formEl = document.getElementById('form-persuratan');
    var btnSubmit = document.getElementById('btn-submit');
    if (formEl && btnSubmit) {
        formEl.addEventListener('submit', function () {
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i><span>Mengirim Pengajuan...</span>';
        });
    }
})();
</script>