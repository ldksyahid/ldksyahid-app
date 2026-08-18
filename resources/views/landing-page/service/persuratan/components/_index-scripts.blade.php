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
        'kerja-sama-sponsorship': 'Permohonan kemitraan, media partner, atau kerja sama sponsorship dengan pihak mitra/perusahaan (Kode format: <strong>Ks-e</strong>).',
        'surat-pemberitahuan': 'Surat pemberitahuan resmi mengenai kegiatan kepada pihak pengamanan, pengelola gedung, atau instansi terkait (Kode format: <strong>Pb-e</strong>).'
    };

    var fieldMap = {
        'izin-orang-tua': [
            { name: 'kode_bidang',  label: 'Asal Bidang / LDKSF', icon: 'fa-users',          type: 'select', options: bidangOptions },
            { name: 'nama_acara',   label: 'Nama Acara',           icon: 'fa-star',            placeholder: 'Contoh: Rihlah LDK Syahid 2026' },
            { name: 'tema_acara',   label: 'Tema Acara',           icon: 'fa-tag',             placeholder: 'Contoh: Membangun Generasi Islami' },
            { name: 'hari_tanggal', label: 'Tanggal Pelaksanaan',  icon: 'fa-calendar',        type: 'date' },
            { name: 'waktu',        label: 'Waktu Pelaksanaan',    icon: 'fa-clock',           type: 'time-range', placeholder: 'Contoh: 08.00 - 16.00 WIB' },
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
            { name: 'waktu',            label: 'Waktu Peminjaman',     icon: 'fa-clock',        type: 'time-range', placeholder: 'Contoh: 08.00 - 15.00 WIB' },
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
            { name: 'waktu',                label: 'Waktu Peminjaman',       icon: 'fa-clock',    type: 'time-range', placeholder: 'Contoh: 08.00 - 17.00 WIB' },
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
            { name: 'waktu',                label: 'Waktu Peminjaman',       icon: 'fa-clock',    type: 'time-range', placeholder: 'Contoh: 08.00 - 16.00 WIB' },
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
            { name: 'waktu',                label: 'Waktu Peminjaman',       icon: 'fa-clock',    type: 'time-range', placeholder: 'Contoh: 2 Hari 1 Malam' },
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
            { name: 'waktu',         label: 'Waktu Pelaksanaan',    icon: 'fa-clock',           type: 'time-range', placeholder: 'Contoh: 07.00 - Selesai' },
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
            { name: 'waktu',           label: 'Waktu Acara',          icon: 'fa-clock',        type: 'time-range', placeholder: 'Contoh: 08.30 - 12.00 WIB' },
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
            { name: 'waktu',            label: 'Waktu Acara',          icon: 'fa-clock',          type: 'time-range', placeholder: 'Contoh: 09.00 - 11.30 WIB' },
            { name: 'tempat',           label: 'Tempat Acara',         icon: 'fa-map-marker-alt',  placeholder: 'Contoh: Ruang Teater Prof. Aqib Suminto' },
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
            { name: 'waktu',            label: 'Waktu Pelaksanaan',    icon: 'fa-clock',          type: 'time-range', placeholder: 'Contoh: 06.00 - 18.00 WIB' },
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
            var labelHtml = '<label class="prs-form-label" for="field_' + f.name + '">' + iconHtml + ' ' + f.label + '</label>';

            var inputHtml = '';
            var prefixIcon = f.icon ? '<i class="fas ' + f.icon + ' prs-input-prefix-icon"></i>' : '';

            if (f.type === 'select') {
                inputHtml = '<div class="prs-input-group">' + prefixIcon +
                    '<select name="' + f.name + '" id="field_' + f.name + '" class="prs-form-select" required>' +
                    '<option value="" disabled ' + (val === '' ? 'selected' : '') + '>-- Pilih ' + f.label + ' --</option>';

                f.options.forEach(function (opt) {
                    var selected = String(val) === String(opt.value) ? 'selected' : '';
                    inputHtml += '<option value="' + escapeAttr(opt.value) + '" ' + selected + '>' + escapeAttr(opt.label) + '</option>';
                });

                inputHtml += '</select></div>';
            } else if (f.type === 'textarea') {
                inputHtml = '<div class="prs-input-group">' + prefixIcon +
                    '<textarea name="' + f.name + '" id="field_' + f.name + '" class="prs-form-textarea" placeholder="' + escapeAttr(f.placeholder || '') + '" required>' +
                    escapeAttr(val) + '</textarea></div>';
            } else if (f.type === 'date') {
                inputHtml = '<div class="prs-input-group">' + prefixIcon +
                    '<input type="text" name="' + f.name + '" id="field_' + f.name + '" class="prs-form-input prs-datepicker" value="' + escapeAttr(val) + '" placeholder="Pilih tanggal" required autocomplete="off">' +
                    '</div>';
            } else {
                var extraAttr = '';
                if (f.inputmode) extraAttr += ' inputmode="' + f.inputmode + '"';
                if (f.pattern) extraAttr += ' pattern="' + f.pattern + '"';

                inputHtml = '<div class="prs-input-group">' + prefixIcon +
                    '<input type="text" name="' + f.name + '" id="field_' + f.name + '" class="prs-form-input" value="' + escapeAttr(val) + '" placeholder="' + escapeAttr(f.placeholder || '') + '"' + extraAttr + ' required>' +
                    '</div>';
            }

            group.innerHTML = labelHtml + inputHtml;
            container.appendChild(group);
        });

        // Initialize Flatpickr on date inputs
        if (typeof flatpickr !== 'undefined') {
            flatpickr('.prs-datepicker', {
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'j F Y',
                locale: 'id',
                minDate: 'today',
                disableMobile: false
            });
        }

        submitBtn.style.setProperty('display', 'block', 'important');
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