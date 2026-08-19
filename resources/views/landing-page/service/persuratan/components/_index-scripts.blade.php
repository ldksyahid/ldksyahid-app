{{-- Flatpickr CDN --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

<script>
(function () {
    var bidangOptions = [
        {value: 'BPH', label: 'BPH (Badan Pengurus Harian)'},
        {value: 'KST', label: 'KST (Biro Kesekretariatan)'},
        {value: 'KEU', label: 'KEU (Biro Keuangan)'},
        {value: 'KPT', label: 'KPT (Biro Keputrian)'},
        {value: 'PE',  label: 'PE (Pengembangan Ekonomi)'},
        {value: 'KDR', label: 'KDR (Kaderisasi)'},
        {value: 'SYR', label: 'SYR (Syiar)'},
        {value: 'PABK',label: 'PABK (Pengembangan Akademik & Keilmuan)'},
        {value: 'HUM', label: 'HUM (Humas)'},
        {value: 'MED', label: 'MED (Media Center)'},
        {value: 'PSU', label: 'PSU'},
        {value: 'SQC', label: 'SQC'},
        {value: 'RMSC',label: 'RMSC'},
        {value: 'LDKS.FST',     label: 'LDKS Fakultas Sains dan Teknologi'},
        {value: 'LDKS.FDIKOM',  label: 'LDKS Fakultas Dakwah dan Ilmu Komunikasi'},
        {value: 'LDKS.FU',      label: 'LDKS Fakultas Ushuluddin'},
        {value: 'LDKS.FSH',     label: 'LDKS Fakultas Syariah dan Hukum'},
        {value: 'LDKS.FAH',     label: 'LDKS Fakultas Adab dan Humaniora'},
        {value: 'LDKS.FITK',    label: 'LDKS Fakultas Ilmu Tarbiyah dan Keguruan'},
        {value: 'LDKS.FDI',     label: 'LDKS Fakultas Dirasat Islamiyah'},
        {value: 'LDKS.FPsi',    label: 'LDKS Fakultas Psikologi'},
        {value: 'LDKS.FISIP',   label: 'LDKS Ilmu Sosial dan Politik'},
        {value: 'LDKS.FIKES-FK',label: 'LDKS Fakultas Kedokteran dan Ilmu Kesehatan'},
    ];

    var descriptions = {
        'izin-orang-tua': 'Permohonan izin kepada Orang Tua/Wali kader LDK Syahid untuk mengikuti agenda kegiatan (Kode format: <strong>Ph-e</strong>).',
        'peminjaman-alat': 'Permohonan peminjaman inventaris/alat untuk operasional kegiatan, baik internal maupun eksternal (Kode format: <strong>Ph-e</strong>).',
        'peminjaman-tempat-kampus': 'Permohonan izin peminjaman fasilitas bersama kampus UIN Jakarta (Student Center/Aula/Lapangan) dengan pengesahan Warek Kemahasiswaan (Kode format: <strong>Ph-i</strong>).',
        'peminjaman-tempat-fakultas': 'Permohonan izin peminjaman ruang/aula internal fakultas di lingkungan UIN Jakarta (Kode format: <strong>Ph-i</strong>).',
        'peminjaman-tempat-luar-kampus': 'Permohonan peminjaman tempat/lokasi kegiatan di luar kampus (Kode format: <strong>Ph-e</strong>).',
        'permohonan-bantuan-dana': 'Permohonan pengajuan bantuan dana sponsorship/donasi kegiatan kepada pimpinan atau instansi terkait (Kode format: <strong>Ph-e</strong>).',
        'permohonan-izin-luar-kampus': 'Surat resmi permohonan izin penyelenggaraan agenda di luar kampus yang ditujukan kepada Wakil Rektor Bidang Kemahasiswaan (Kode format: <strong>Ph-e</strong>).',
        'surat-rekomendasi': 'Rekomendasi resmi pengurus LDK Syahid untuk pendaftaran beasiswa, delegasi, atau program kemahasiswaan (Kode format: <strong>SR-e</strong>).',
        'surat-undangan': 'Surat undangan resmi menghadiri acara atau agenda LDK Syahid untuk pihak internal maupun eksternal (Kode format: <strong>Und-i / Und-e</strong>).',
        'surat-aktif-organisasi': 'Surat keterangan resmi keaktifan kepengurusan mahasiswa di UKM LDK Syahid UIN Jakarta (Kode format: <strong>S.Ket-e</strong>).',
        'permohonan-pemateri': 'Permohonan resmi kesediaan menjadi narasumber/pemateri pada acara atau kajian (Kode format: <strong>Ph-e</strong>).',
        'permohonan-sambutan': 'Permohonan resmi kepada pimpinan/tokoh untuk memberikan kata sambutan dalam pembukaan acara (Kode format: <strong>Ph-e</strong>).',
        'surat-izin-buka-stand': 'Permohonan izin membuka stand/booth promosi atau bazar pada area tertentu (Kode format: <strong>Ph-i</strong>).',
        'surat-izin-pengambilan-gambar-video': 'Permohonan izin dokumentasi, pengambilan foto, dan video resmi kegiatan (Kode format: <strong>Ph-i</strong>).',
        'surat-kunjungan-lembaga': 'Permohonan kunjungan silaturahmi, kolaborasi, atau studi banding ke lembaga/instansi/organisasi lain (Kode format: <strong>Ph-e</strong>).',
        'surat-imbauan': 'Surat imbauan dan arahan resmi pengurus kepada seluruh anggota/kader atau civitas akademika (Kode format: <strong>Pb-e</strong>).',
        'kerja-sama-sponsorship': 'Permohonan kemitraan, media partner, atau kerja sama sponsorship dengan pihak mitra/perusahaan (Kode format: <strong>Ks-e</strong>).',
        'surat-pemberitahuan': 'Surat pemberitahuan resmi mengenai kegiatan kepada pihak pengamanan, pengelola gedung, atau instansi terkait (Kode format: <strong>Pb-e</strong>).'
    };

    var fieldMap = {
        'izin-orang-tua': [
            { name: 'kode_bidang',  label: 'Asal Bidang / LDKSF', icon: 'fa-users',          type: 'select', options: bidangOptions },
            { name: 'nama_acara',   label: 'Nama Acara',           icon: 'fa-star',            placeholder: 'Contoh: Rihlah LDK Syahid 2026' },
            { name: 'tema_acara',   label: 'Tema Acara',           icon: 'fa-tag',             placeholder: 'Contoh: Membangun Generasi Islami' },
            { name: 'hari_tanggal', label: 'Tanggal Pelaksanaan',  icon: 'fa-calendar',        type: 'date' },
            { name: 'waktu',        label: 'Waktu Pelaksanaan',    icon: 'fa-clock',           type: 'time-range' },
            { name: 'tempat',       label: 'Tempat Pelaksanaan',   icon: 'fa-map-marker-alt',  placeholder: 'Contoh: Aula Madya UIN Jakarta' },
        ],
        'peminjaman-alat': [
            { name: 'kode_bidang',      label: 'Asal Bidang / LDKSF', icon: 'fa-users',  type: 'select', options: bidangOptions },
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
            { name: 'kode_bidang',          label: 'Asal Bidang / LDKSF',   icon: 'fa-users',    type: 'select', options: bidangOptions },
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
            { name: 'kode_bidang',          label: 'Asal Bidang / LDKSF',   icon: 'fa-users',    type: 'select', options: bidangOptions },
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
            { name: 'kode_bidang',          label: 'Asal Bidang / LDKSF',   icon: 'fa-users',    type: 'select', options: bidangOptions },
            { name: 'nama_acara',           label: 'Nama Acara',             icon: 'fa-star',     placeholder: 'Contoh: Rihlah Akbar' },
            { name: 'tema_acara',           label: 'Tema Acara',             icon: 'fa-tag',      placeholder: 'Contoh: Menjalin Ukhuwah Tanpa Batas' },
            { name: 'nama_ketua_pelaksana', label: 'Nama Ketua Pelaksana',   icon: 'fa-user',     placeholder: 'Contoh: Muhammad Fulan' },
            { name: 'nim_ketua_pelaksana',  label: 'NIM Ketua Pelaksana',    icon: 'fa-id-card',  inputmode: 'numeric', pattern: '[0-9]*', placeholder: 'Contoh: 11230000000002' },
            { name: 'ditujukan_kepada',     label: 'Ditujukan Kepada',       icon: 'fa-envelope', placeholder: 'Contoh: Pengelola Villa Cisarua' },
            { name: 'hari_tanggal',         label: 'Tanggal Peminjaman',     icon: 'fa-calendar', type: 'date' },
            { name: 'waktu',                label: 'Waktu Peminjaman',       icon: 'fa-clock',    type: 'time-range' },
            { name: 'tempat_dipinjam',      label: 'Tempat yang Dipinjam',   icon: 'fa-building', placeholder: 'Contoh: Villa Alam Hijau, Puncak, Bogor' },
        ],
        'permohonan-bantuan-dana': [
            { name: 'kode_bidang',      label: 'Asal Bidang / LDKSF', icon: 'fa-users',           type: 'select', options: bidangOptions },
            { name: 'nama_program',     label: 'Nama Program Kegiatan',icon: 'fa-project-diagram', placeholder: 'Contoh: Gebyar Ramadan LDK Syahid 1448 H' },
            { name: 'ditujukan_kepada', label: 'Ditujukan Kepada',     icon: 'fa-envelope',        placeholder: 'Contoh: Pimpinan BAZNAS Pusat / Bank Syariah Indonesia' },
            { name: 'keperluan',        label: 'Rincian Keperluan Bantuan', icon: 'fa-file-alt',    type: 'textarea', placeholder: 'Jelaskan alokasi dan urgensi kebutuhan bantuan dana secara singkat...' },
        ],
        'permohonan-izin-luar-kampus': [
            { name: 'kode_bidang',   label: 'Asal Bidang / LDKSF', icon: 'fa-users',          type: 'select', options: bidangOptions },
            { name: 'nama_acara',    label: 'Nama Acara',           icon: 'fa-star',            placeholder: 'Contoh: Kemah Bakti Mahasiswa' },
            { name: 'tema_acara',    label: 'Tema Acara',           icon: 'fa-tag',             placeholder: 'Contoh: Mengabdi untuk Negeri' },
            { name: 'hari_tanggal',  label: 'Tanggal Pelaksanaan',  icon: 'fa-calendar',        type: 'date' },
            { name: 'waktu',         label: 'Waktu Pelaksanaan',    icon: 'fa-clock',           type: 'time-range' },
            { name: 'tempat',        label: 'Nama Tempat',          icon: 'fa-map-marker-alt',  placeholder: 'Contoh: Desa Wisata Babakan Madang' },
            { name: 'alamat_tempat', label: 'Alamat Lengkap',       icon: 'fa-map-pin',         placeholder: 'Contoh: Jl. Raya Babakan No. 45, Bogor, Jawa Barat' },
        ],
        'surat-rekomendasi': [
            { name: 'kode_bidang',         label: 'Asal Bidang / LDKSF',            icon: 'fa-users',        type: 'select', options: bidangOptions },
            { name: 'nama',                label: 'Nama Lengkap Mahasiswa',          icon: 'fa-user',         placeholder: 'Contoh: Muhammad Fakhri Alfarisi' },
            { name: 'nim',                 label: 'NIM',                             icon: 'fa-id-card',      placeholder: 'Contoh: 11230910000029' },
            { name: 'fakultas',            label: 'Fakultas',                        icon: 'fa-university',   placeholder: 'Contoh: Sains dan Teknologi' },
            { name: 'jurusan',             label: 'Program Studi / Jurusan',         icon: 'fa-graduation-cap', placeholder: 'Contoh: Teknik Informatika' },
            { name: 'jabatan',             label: 'Bidang / Jabatan di LDK',         icon: 'fa-briefcase',    placeholder: 'Contoh: Anggota Bidang Media Center' },
            { name: 'program_rekomendasi', label: 'Program yang Direkomendasikan',   icon: 'fa-award',        placeholder: 'Contoh: Beasiswa Prestasi BAZNAS 2026' },
            { name: 'pertimbangan',        label: 'Poin Pertimbangan Rekomendasi',   icon: 'fa-list-ul',      type: 'textarea', placeholder: "Tuliskan poin pertimbangan (1 baris = 1 poin):\n1. Aktif berkontribusi dalam berbagai program kerja organisasi.\n2. Memiliki komitmen integritas dan akhlak yang baik." },
        ],
        'surat-undangan': [
            { name: 'kode_bidang',     label: 'Asal Bidang / LDKSF', icon: 'fa-users', type: 'select', options: bidangOptions },
            { name: 'jenis_undangan',  label: 'Sifat Undangan',       icon: 'fa-tag',   type: 'select',
              options: [{value:'internal',label:'Internal (UIN Syahid)'},{value:'eksternal',label:'Eksternal'}] },
            { name: 'nama_acara',      label: 'Nama Acara',           icon: 'fa-star',         placeholder: 'Contoh: Grand Opening Syahid Fair' },
            { name: 'tema_acara',      label: 'Tema Acara',           icon: 'fa-tag',          placeholder: 'Contoh: Harmoni Dakwah Kreatif' },
            { name: 'ditujukan_kepada',label: 'Ditujukan Kepada',     icon: 'fa-envelope',     placeholder: 'Contoh: Ketua BEM Universitas / Bapak Rektor' },
            { name: 'hari_tanggal',    label: 'Tanggal Acara',        icon: 'fa-calendar',     type: 'date' },
            { name: 'waktu',           label: 'Waktu Acara',          icon: 'fa-clock',        type: 'time-range' },
            { name: 'tempat',          label: 'Tempat Acara',         icon: 'fa-map-marker-alt', placeholder: 'Contoh: Auditorium Utama Harun Nasution' },
        ],
        'surat-aktif-organisasi': [
            { name: 'kode_bidang',  label: 'Asal Bidang / LDKSF',    icon: 'fa-users',        type: 'select', options: bidangOptions },
            { name: 'nama',         label: 'Nama Lengkap',            icon: 'fa-user',          placeholder: 'Contoh: Ahmad Fulan' },
            { name: 'ttl',          label: 'Tempat, Tanggal Lahir',   icon: 'fa-calendar-alt', placeholder: 'Contoh: Tangerang, 26 Januari 2005' },
            { name: 'nim',          label: 'NIM',                     icon: 'fa-id-card',       placeholder: 'Contoh: 11230910000029' },
            { name: 'fakultas',     label: 'Fakultas',                icon: 'fa-university',    placeholder: 'Contoh: Sains dan Teknologi' },
            { name: 'jurusan',      label: 'Semester / Jurusan',      icon: 'fa-graduation-cap', placeholder: 'Contoh: Semester 4 / Teknik Informatika' },
            { name: 'jabatan',      label: 'Bidang / Jabatan di LDK', icon: 'fa-briefcase',     placeholder: 'Contoh: Anggota Bidang Kaderisasi' },
            { name: 'keperluan',    label: 'Keperluan Surat',         icon: 'fa-file-alt',      type: 'textarea', placeholder: 'Contoh: Persyaratan Beasiswa Unggulan Kemendikbud' },
            { name: 'penyelenggara',label: 'Instansi / Penyelenggara',icon: 'fa-building',      placeholder: 'Contoh: Kementerian Pendidikan dan Kebudayaan' },
        ],
        'permohonan-pemateri': [
            { name: 'kode_bidang',      label: 'Asal Bidang / LDKSF', icon: 'fa-users',          type: 'select', options: bidangOptions },
            { name: 'nama_acara',       label: 'Nama Acara',           icon: 'fa-star',            placeholder: 'Contoh: Talkshow Inspirasi Muslim' },
            { name: 'tema_acara',       label: 'Tema Acara',           icon: 'fa-tag',             placeholder: 'Contoh: Menjadi Generasi Emas Islami' },
            { name: 'ditujukan_kepada', label: 'Ditujukan Kepada',     icon: 'fa-envelope',       placeholder: 'Contoh: Ustadz Dr. Fulan, M.A.' },
            { name: 'materi',           label: 'Tema Materi Khusus',   icon: 'fa-book-open',      placeholder: 'Contoh: Urgensi Menuntut Ilmu di Era Disrupsi' },
            { name: 'hari_tanggal',     label: 'Tanggal Acara',        icon: 'fa-calendar',       type: 'date' },
            { name: 'waktu',            label: 'Waktu Acara',          icon: 'fa-clock',          type: 'time-range' },
            { name: 'tempat',           label: 'Tempat Acara',         icon: 'fa-map-marker-alt',  placeholder: 'Contoh: Ruang Teater Prof. Aqib Suminto' },
        ],
        'permohonan-sambutan': [
            { name: 'kode_bidang',      label: 'Asal Bidang / LDKSF', icon: 'fa-users',          type: 'select', options: bidangOptions },
            { name: 'nama_acara',       label: 'Nama Acara',           icon: 'fa-star',            placeholder: 'Contoh: Grand Opening Syahid Fair 2026' },
            { name: 'tema_acara',       label: 'Tema Acara',           icon: 'fa-tag',             placeholder: 'Contoh: Meneguhkan Langkah Dakwah Kampus' },
            { name: 'ditujukan_kepada', label: 'Nama Tokoh / Pejabat', icon: 'fa-user-tie',       placeholder: 'Contoh: Prof. Dr. Hj. Amany Lubis, M.A.' },
            { name: 'jabatan_tujuan',   label: 'Jabatan / Instansi',   icon: 'fa-id-badge',        placeholder: 'Contoh: Guru Besar UIN Syarif Hidayatullah Jakarta' },
            { name: 'hari_tanggal',     label: 'Tanggal Pelaksanaan',  icon: 'fa-calendar',        type: 'date' },
            { name: 'waktu',            label: 'Waktu Pelaksanaan',    icon: 'fa-clock',           type: 'time-range' },
            { name: 'tempat',           label: 'Tempat Pelaksanaan',   icon: 'fa-map-marker-alt',  placeholder: 'Contoh: Auditorium Harun Nasution' },
        ],
        'surat-izin-buka-stand': [
            { name: 'kode_bidang',      label: 'Asal Bidang / LDKSF', icon: 'fa-users',          type: 'select', options: bidangOptions },
            { name: 'nama_acara',       label: 'Nama Agenda / Bazar',  icon: 'fa-store',           placeholder: 'Contoh: Bazar Kuliner Syahid Entrepreneur' },
            { name: 'ditujukan_kepada', label: 'Ditujukan Kepada',     icon: 'fa-envelope',        placeholder: 'Contoh: Kepala Biro Umum / Pengelola Tempat' },
            { name: 'hari_tanggal',     label: 'Tanggal Pelaksanaan',  icon: 'fa-calendar',        type: 'date' },
            { name: 'waktu',            label: 'Waktu Operasional',    icon: 'fa-clock',           type: 'time-range' },
            { name: 'tempat',           label: 'Lokasi Stand/Booth',   icon: 'fa-map-marker-alt',  placeholder: 'Contoh: Selasar Depan Student Center' },
            { name: 'keperluan',        label: 'Deskripsi Stand',      icon: 'fa-file-alt',        type: 'textarea', placeholder: 'Contoh: Penjualan merchandise resmi, buku islami, dan produk kewirausahaan kader.' },
        ],
        'surat-izin-pengambilan-gambar-video': [
            { name: 'kode_bidang',      label: 'Asal Bidang / LDKSF', icon: 'fa-users',          type: 'select', options: bidangOptions },
            { name: 'nama_acara',       label: 'Nama Kegiatan / Proyek', icon: 'fa-video',        placeholder: 'Contoh: Pembuatan Video Profil LDK Syahid 2026' },
            { name: 'ditujukan_kepada', label: 'Ditujukan Kepada',     icon: 'fa-envelope',        placeholder: 'Contoh: Kepala Bagian Keamanan / Pengelola Gedung' },
            { name: 'hari_tanggal',     label: 'Tanggal Pengambilan',  icon: 'fa-calendar',        type: 'date' },
            { name: 'waktu',            label: 'Waktu Pengambilan',    icon: 'fa-clock',           type: 'time-range' },
            { name: 'tempat',           label: 'Lokasi / Area',        icon: 'fa-map-marker-alt',  placeholder: 'Contoh: Area Rektorat dan Taman SC' },
            { name: 'keperluan',        label: 'Rincian Keperluan',    icon: 'fa-file-alt',        type: 'textarea', placeholder: 'Contoh: Dokumentasi visual, video cinematic profil organisasi, dan publikasi dakwah.' },
        ],
        'surat-kunjungan-lembaga': [
            { name: 'kode_bidang',      label: 'Asal Bidang / LDKSF', icon: 'fa-users',          type: 'select', options: bidangOptions },
            { name: 'nama_kegiatan',    label: 'Nama Program Kunjungan', icon: 'fa-handshake',     placeholder: 'Contoh: Studi Banding & Silaturahmi Kelembagaan' },
            { name: 'ditujukan_kepada', label: 'Lembaga / Instansi Tujuan', icon: 'fa-building', placeholder: 'Contoh: Pengurus Pusat BAZNAS RI / LDK Sahabat Kampus' },
            { name: 'hari_tanggal',     label: 'Tanggal Kunjungan',    icon: 'fa-calendar',        type: 'date' },
            { name: 'waktu',            label: 'Waktu Kunjungan',      icon: 'fa-clock',           type: 'time-range' },
            { name: 'tempat',           label: 'Alamat / Tempat Tujuan', icon: 'fa-map-marker-alt', placeholder: 'Contoh: Gedung BAZNAS RI, Jl. Matraman Raya No. 134, Jakarta' },
            { name: 'keperluan',        label: 'Fokus Agenda Kunjungan', icon: 'fa-file-alt',     type: 'textarea', placeholder: 'Contoh: Sharing session manajemen organisasi, kolaborasi program dakwah, dan penyerahan cinderamata.' },
        ],
        'surat-imbauan': [
            { name: 'kode_bidang',      label: 'Asal Bidang / LDKSF', icon: 'fa-users',          type: 'select', options: bidangOptions },
            { name: 'perihal_imbauan',  label: 'Perihal Imbauan',      icon: 'fa-bullhorn',        placeholder: 'Contoh: Menjaga Ketertiban dan Kebersihan Fasilitas Dakwah' },
            { name: 'ditujukan_kepada', label: 'Ditujukan Kepada',     icon: 'fa-envelope',        placeholder: 'Contoh: Seluruh Pengurus dan Kader LDK Syahid' },
            { name: 'poin_imbauan',     label: 'Poin-poin Imbauan (1 per baris)', icon: 'fa-list-ol', type: 'textarea', placeholder: "Tuliskan poin imbauan (1 baris = 1 poin):\n1. Menjaga kebersihan dan ketertiban sekretariat.\n2. Mematikan alat elektronik setelah selesai digunakan.\n3. Menjaga koordinasi dan komunikasi yang santun." },
        ],
        'kerja-sama-sponsorship': [
            { name: 'kode_bidang',     label: 'Asal Bidang / LDKSF', icon: 'fa-users',     type: 'select', options: bidangOptions },
            { name: 'nama_acara',      label: 'Nama Acara',           icon: 'fa-star',      placeholder: 'Contoh: Syahid Entrepreneur Fest' },
            { name: 'tema_acara',      label: 'Tema Acara',           icon: 'fa-tag',       placeholder: 'Contoh: Wirausaha Berkah Berdaya' },
            { name: 'ditujukan_kepada',label: 'Ditujukan Kepada',     icon: 'fa-envelope',  placeholder: 'Contoh: Pimpinan PT Wardah Cosmetics / Bank Muamalat' },
            { name: 'bentuk_kerjasama',label: 'Bentuk Kerja Sama',    icon: 'fa-handshake', type: 'textarea', placeholder: "Jelaskan ringkasan bentuk kerja sama:\n1. Dukungan pendanaan dan publikasi bersama\n2. Booth sponsor pada venue kegiatan" },
        ],
        'surat-pemberitahuan': [
            { name: 'kode_bidang',      label: 'Asal Bidang / LDKSF', icon: 'fa-users',          type: 'select', options: bidangOptions },
            { name: 'nama_kegiatan',    label: 'Nama Kegiatan',        icon: 'fa-star',            placeholder: 'Contoh: Rihlah Akbar Kader LDK Syahid' },
            { name: 'ditujukan_kepada', label: 'Ditujukan Kepada',     icon: 'fa-envelope',       placeholder: 'Contoh: Komandan Satpam / Pengelola Keamanan Kampus' },
            { name: 'hari_tanggal',     label: 'Tanggal Pelaksanaan',  icon: 'fa-calendar',       type: 'date' },
            { name: 'waktu',            label: 'Waktu Pelaksanaan',    icon: 'fa-clock',          type: 'time-range' },
            { name: 'tempat',           label: 'Tempat Pelaksanaan',   icon: 'fa-map-marker-alt',  placeholder: 'Contoh: Parkiran Utama UIN Syarif Hidayatullah' },
        ],
    };

    var oldValues = @json(old());

    function escapeAttr(v) {
        return String(v || '')
            .replace(/&/g, '&amp;').replace(/"/g, '&quot;')
            .replace(/</g, '&lt;').replace(/>/g, '&gt;');
    }

    function renderFields(type) {
        var container = document.getElementById('dynamic-fields');
        var submitBtn = document.getElementById('btn-submit-wrapper');
        var descBox   = document.getElementById('prsDescBox');

        container.innerHTML = '';

        if (!type || !fieldMap[type]) {
            submitBtn.style.setProperty('display', 'none', 'important');
            if (descBox) descBox.style.display = 'none';
            return;
        }

        // Show description
        if (descBox && descriptions[type]) {
            descBox.innerHTML = '<i class="fas fa-info-circle me-1 text-primary"></i> ' + descriptions[type];
            descBox.style.display = 'block';
        } else if (descBox) {
            descBox.style.display = 'none';
        }

        var fields = fieldMap[type];

        fields.forEach(function (f) {
            var val = oldValues[f.name] !== undefined ? oldValues[f.name] : '';
            var group = document.createElement('div');
            group.className = 'prs-form-group';

            var iconHtml = f.icon ? '<i class="fas ' + f.icon + '"></i>' : '<i class="fas fa-circle"></i>';
            var prefixIcon = f.icon ? '<i class="fas ' + f.icon + ' prs-input-prefix-icon"></i>' : '';

            // 1. SELECT FIELD
            if (f.type === 'select') {
                var labelHtml = '<label class="prs-form-label" for="field_' + f.name + '">' + iconHtml + ' ' + f.label + '</label>';
                var inputHtml = '<div class="prs-input-group">' + prefixIcon +
                    '<select name="' + f.name + '" id="field_' + f.name + '" class="prs-form-select" required>' +
                    '<option value="" disabled ' + (val === '' ? 'selected' : '') + '>-- Pilih ' + f.label + ' --</option>';

                f.options.forEach(function (opt) {
                    var selected = String(val) === String(opt.value) ? 'selected' : '';
                    inputHtml += '<option value="' + escapeAttr(opt.value) + '" ' + selected + '>' + escapeAttr(opt.label) + '</option>';
                });

                inputHtml += '</select></div>';
                group.innerHTML = labelHtml + inputHtml;
            }
            // 2. TEXTAREA FIELD
            else if (f.type === 'textarea') {
                var labelHtml = '<label class="prs-form-label" for="field_' + f.name + '">' + iconHtml + ' ' + f.label + '</label>';
                var inputHtml = '<div class="prs-input-group">' + prefixIcon +
                    '<textarea name="' + f.name + '" id="field_' + f.name + '" class="prs-form-textarea" placeholder="' + escapeAttr(f.placeholder || '') + '" required>' +
                    escapeAttr(val) + '</textarea></div>';
                group.innerHTML = labelHtml + inputHtml;
            }
            // 3. DATE FIELD (Single Day vs Multi-Day Range Toggle)
            else if (f.type === 'date') {
                var isMulti = String(val).indexOf('to') !== -1 || String(val).indexOf('s.d.') !== -1;
                
                var headerHtml = '<div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">' +
                    '<label class="prs-form-label mb-0" for="field_' + f.name + '">' + iconHtml + ' ' + f.label + '</label>' +
                    '<div class="prs-date-toggle-wrap">' +
                        '<button type="button" class="prs-date-toggle-btn ' + (!isMulti ? 'active' : '') + '" id="btn_date_single">1 Hari</button>' +
                        '<button type="button" class="prs-date-toggle-btn ' + (isMulti ? 'active' : '') + '" id="btn_date_range">Rentang Hari (&gt; 1 Hari)</button>' +
                    '</div>' +
                '</div>';

                var inputHtml = '<input type="hidden" name="' + f.name + '" id="field_' + f.name + '" value="' + escapeAttr(val) + '" required>' +
                    '<div class="prs-input-group">' + prefixIcon +
                        '<input type="text" id="picker_' + f.name + '" class="prs-form-input prs-datepicker" placeholder="Pilih tanggal kegiatan..." autocomplete="off" readonly required>' +
                    '</div>' +
                    '<span class="prs-form-hint" id="hint_' + f.name + '">Pilih 1 tanggal jika acara 1 hari, atau pilih rentang tanggal jika lebih dari 1 hari.</span>';

                group.innerHTML = headerHtml + inputHtml;
            }
            // 4. TIME-RANGE FIELD (Interactive Time Picker - s.d.)
            else if (f.type === 'time-range') {
                var defaultVal = val || '08.00 s.d. 16.00 WIB';

                var labelHtml = '<label class="prs-form-label" for="field_' + f.name + '">' + iconHtml + ' ' + f.label + '</label>';
                var inputHtml = '<input type="hidden" name="' + f.name + '" id="field_' + f.name + '" value="' + escapeAttr(defaultVal) + '" required>' +
                    '<div class="prs-time-box">' +
                        '<div class="row g-2 align-items-end">' +
                            '<div class="col-sm-4 col-6">' +
                                '<label class="small text-muted mb-1" style="font-size:0.76rem; font-weight:600;"><i class="fas fa-hourglass-start me-1 text-primary"></i> Jam Mulai</label>' +
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
            // 5. STANDARD INPUT FIELD
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

        var fpEnd = flatpickr(endInput, {
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

    var jenisSuratSelect = document.getElementById('jenis_surat');
    if (jenisSuratSelect) {
        jenisSuratSelect.addEventListener('change', function () {
            renderFields(this.value);
        });

        if (jenisSuratSelect.value) {
            renderFields(jenisSuratSelect.value);
        }
    }

    // FAQ Accordion Toggle
    var faqItems = document.querySelectorAll('.prs-faq-item');
    faqItems.forEach(function (item) {
        var btn = item.querySelector('.prs-faq-question');
        var answer = item.querySelector('.prs-faq-answer');

        btn.addEventListener('click', function () {
            var isActive = item.classList.contains('active');

            // Close all
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