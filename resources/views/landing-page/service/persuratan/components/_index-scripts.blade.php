<script>
(function () {
    var fieldMap = {
        'izin-orang-tua': [
            { name: 'nama_acara',  label: 'Nama Acara',  icon: 'fa-star',     placeholder: 'Contoh: Rihlah LDK Syahid 2025' },
            { name: 'tema_acara',  label: 'Tema Acara',  icon: 'fa-tag',      placeholder: 'Contoh: Membangun Generasi Islami' },
            { name: 'hari_tanggal',label: 'Tanggal',     icon: 'fa-calendar', type: 'date' },
            { name: 'waktu',       label: 'Waktu',       icon: 'fa-clock',    placeholder: 'Contoh: 08.00 – 17.00 WIB' },
            { name: 'tempat',      label: 'Tempat',      icon: 'fa-map-marker-alt', placeholder: 'Contoh: Aula Madya UIN Jakarta' },
        ],
        'peminjaman-alat': [
            { name: 'jenis_peminjaman', label: 'Sifat Peminjaman', icon: 'fa-tag', type: 'select',
              options: [{value:'internal',label:'Internal (LDK Syahid)'},{value:'eksternal',label:'Eksternal'}] },
            { name: 'nama_acara',       label: 'Nama Acara',        icon: 'fa-star',         placeholder: 'Contoh: Seminar Nasional' },
            { name: 'tema_acara',       label: 'Tema Acara',        icon: 'fa-tag',          placeholder: 'Contoh: Moderasi Beragama' },
            { name: 'ditujukan_kepada', label: 'Ditujukan Kepada',  icon: 'fa-envelope',     placeholder: 'Contoh: Departemen Media LDK / Perpustakaan' },
            { name: 'hari_tanggal',     label: 'Tanggal',           icon: 'fa-calendar',     type: 'date' },
            { name: 'waktu',            label: 'Waktu',             icon: 'fa-clock',        placeholder: 'Contoh: 08.00 – 17.00 WIB' },
            { name: 'tempat',           label: 'Tempat',            icon: 'fa-map-marker-alt', placeholder: 'Contoh: Aula Madya' },
            { name: 'daftar_alat',      label: 'Daftar Alat',       icon: 'fa-list',         type: 'textarea', placeholder: 'Contoh:\n1. Proyektor\n2. Mic' },
        ],
        'peminjaman-tempat-kampus': [
            { name: 'nama_acara',       label: 'Nama Acara',        icon: 'fa-star',         placeholder: 'Contoh: Rapat Koordinasi' },
            { name: 'tema_acara',       label: 'Tema Acara',        icon: 'fa-tag',          placeholder: 'Contoh: Evaluasi Program Kerja' },
            { name: 'ditujukan_kepada', label: 'Ditujukan Kepada',  icon: 'fa-envelope',     placeholder: 'Contoh: Dekan FIDKOM' },
            { name: 'hari_tanggal',     label: 'Tanggal',           icon: 'fa-calendar',     type: 'date' },
            { name: 'waktu',            label: 'Waktu',             icon: 'fa-clock',        placeholder: 'Contoh: 13.00 – 16.00 WIB' },
            { name: 'tempat_dipinjam',  label: 'Tempat yang Dipinjam', icon: 'fa-building',  placeholder: 'Contoh: Aula Student Center Lt. 3' },
        ],
        'permohonan-bantuan-dana': [
            { name: 'nama_program',     label: 'Nama Program',      icon: 'fa-project-diagram', placeholder: 'Contoh: Kajian Rutin Ramadan' },
            { name: 'ditujukan_kepada', label: 'Ditujukan Kepada',  icon: 'fa-envelope',     placeholder: 'Contoh: Wakil Rektor III' },
            { name: 'keperluan',        label: 'Keperluan',         icon: 'fa-file-alt',     type: 'textarea', placeholder: 'Jelaskan kebutuhan dana secara singkat...' },
        ],
        'permohonan-izin-luar-kampus': [
            { name: 'nama_acara',   label: 'Nama Acara',    icon: 'fa-star',          placeholder: 'Contoh: Camping Dakwah' },
            { name: 'tema_acara',   label: 'Tema Acara',    icon: 'fa-tag',           placeholder: 'Contoh: Merajut Ukhuwah' },
            { name: 'hari_tanggal', label: 'Tanggal',       icon: 'fa-calendar',      type: 'date' },
            { name: 'waktu',        label: 'Waktu',         icon: 'fa-clock',         placeholder: 'Contoh: 07.00 – selesai' },
            { name: 'tempat',       label: 'Tempat',        icon: 'fa-map-marker-alt', placeholder: 'Contoh: Bumi Perkemahan Ragunan' },
            { name: 'alamat_tempat',label: 'Alamat Lengkap',icon: 'fa-map-pin',       placeholder: 'Contoh: Jl. Ragunan No. 1, Jakarta Selatan' },
        ],
        'surat-rekomendasi': [
            { name: 'nama',                label: 'Nama Lengkap',          icon: 'fa-user',      placeholder: 'Contoh: Ahmad Fakhri' },
            { name: 'nim',                 label: 'NIM',                   icon: 'fa-id-card',   placeholder: 'Contoh: 11220910000001' },
            { name: 'fakultas',            label: 'Fakultas',              icon: 'fa-university', placeholder: 'Contoh: Dakwah dan Ilmu Komunikasi' },
            { name: 'jurusan',             label: 'Jurusan',               icon: 'fa-graduation-cap', placeholder: 'Contoh: Komunikasi dan Penyiaran Islam' },
            { name: 'jabatan',             label: 'Jabatan di LDK',        icon: 'fa-briefcase', placeholder: 'Contoh: Ketua Departemen SPAM' },
            { name: 'program_rekomendasi', label: 'Program yang Direkomendasikan', icon: 'fa-award', placeholder: 'Contoh: Beasiswa Aktivis Peneleh 3' },
            { name: 'pertimbangan',        label: 'Pertimbangan',          icon: 'fa-list-ul',   type: 'textarea', placeholder: 'Tulis pertimbangan rekomendasi (tiap baris = 1 poin)...' },
        ],
        'surat-undangan': [
            { name: 'jenis_undangan',  label: 'Jenis Undangan',  icon: 'fa-tag',          type: 'select',
              options: [{value:'internal',label:'Internal (LDK Syahid)'},{value:'eksternal',label:'Eksternal'}] },
            { name: 'nama_acara',      label: 'Nama Acara',      icon: 'fa-star',         placeholder: 'Contoh: Seminar Nasional' },
            { name: 'tema_acara',      label: 'Tema Acara',      icon: 'fa-tag',          placeholder: 'Contoh: Islam Rahmatan Lil Alamin' },
            { name: 'ditujukan_kepada',label: 'Ditujukan Kepada',icon: 'fa-envelope',     placeholder: 'Contoh: Seluruh Mahasiswa UIN Jakarta' },
            { name: 'hari_tanggal',    label: 'Tanggal',         icon: 'fa-calendar',     type: 'date' },
            { name: 'waktu',           label: 'Waktu',           icon: 'fa-clock',        placeholder: 'Contoh: 09.00 – 12.00 WIB' },
            { name: 'tempat',          label: 'Tempat',          icon: 'fa-map-marker-alt', placeholder: 'Contoh: Auditorium Utama' },
        ],
        'surat-aktif-organisasi': [
            { name: 'nama', label: 'Nama Lengkap', icon: 'fa-user', placeholder: 'Contoh: Ahmad Fakhri' },
            { name: 'ttl', label: 'Tempat, Tanggal Lahir', icon: 'fa-calendar-alt', placeholder: 'Contoh: Jakarta, 17 Agustus 2005' },
            { name: 'nim', label: 'NIM', icon: 'fa-id-card', placeholder: 'Contoh: 11220910000001' },
            { name: 'fakultas', label: 'Fakultas', icon: 'fa-university', placeholder: 'Contoh: Sains dan Teknologi' },
            { name: 'jurusan', label: 'Semester / Jurusan', icon: 'fa-graduation-cap', placeholder: 'Contoh: 5 / Teknik Informatika' },
            { name: 'jabatan', label: 'Bidang / Jabatan', icon: 'fa-briefcase', placeholder: 'Contoh: Ketua Departemen PKPI' },
            { name: 'keperluan', label: 'Keperluan', icon: 'fa-file-alt', type: 'textarea', placeholder: 'Contoh: Persyaratan Beasiswa...' },
            { name: 'penyelenggara', label: 'Penyelenggara', icon: 'fa-building', placeholder: 'Contoh: BAZNAS' },
        ],
        'permohonan-pemateri': [
            { name: 'nama_acara', label: 'Nama Acara', icon: 'fa-star' },
            { name: 'tema_acara', label: 'Tema Acara', icon: 'fa-tag' },
            { name: 'ditujukan_kepada', label: 'Ditujukan Kepada', icon: 'fa-envelope', placeholder: 'Contoh: Ustadz Hanan Attaki' },
            { name: 'materi', label: 'Tema Materi Khusus', icon: 'fa-book', placeholder: 'Contoh: Peran Pemuda di Era Digital' },
            { name: 'hari_tanggal', label: 'Tanggal', icon: 'fa-calendar', type: 'date' },
            { name: 'waktu', label: 'Waktu', icon: 'fa-clock' },
            { name: 'tempat', label: 'Tempat', icon: 'fa-map-marker-alt' },
        ],
        'kerja-sama-sponsorship': [
            { name: 'nama_acara', label: 'Nama Acara', icon: 'fa-star' },
            { name: 'tema_acara', label: 'Tema Acara', icon: 'fa-tag' },
            { name: 'ditujukan_kepada', label: 'Ditujukan Kepada', icon: 'fa-envelope', placeholder: 'Contoh: Manager PT. Wardah Cosmetics' },
            { name: 'bentuk_kerjasama', label: 'Bentuk Kerja Sama', icon: 'fa-handshake', type: 'textarea', placeholder: 'Jelaskan ringkasan penawaran sponsorship...' },
        ],
        'surat-pemberitahuan': [
            { name: 'nama_kegiatan', label: 'Nama Kegiatan', icon: 'fa-star' },
            { name: 'ditujukan_kepada', label: 'Ditujukan Kepada', icon: 'fa-envelope', placeholder: 'Contoh: Satpam UIN Jakarta' },
            { name: 'hari_tanggal', label: 'Tanggal', icon: 'fa-calendar', type: 'date' },
            { name: 'waktu', label: 'Waktu', icon: 'fa-clock' },
            { name: 'tempat', label: 'Tempat', icon: 'fa-map-marker-alt' },
        ],
    };

    var oldValues = @json(old());

    function buildField(f, idx) {
        var val = oldValues[f.name] || '';
        var delay = 'style="animation-delay:' + (idx * 0.05).toFixed(2) + 's"';

        if (f.type === 'select') {
            var opts = f.options.map(function (o) {
                return '<option value="' + o.value + '"' + (val === o.value ? ' selected' : '') + '>' + o.label + '</option>';
            }).join('');
            return (
                '<div class="prs-field" ' + delay + '>' +
                    '<label class="prs-label" for="' + f.name + '">' +
                        '<i class="fas ' + f.icon + '"></i> ' + f.label +
                    '</label>' +
                    '<select name="' + f.name + '" id="' + f.name + '" class="prs-select" required>' +
                        '<option value="" disabled' + (!val ? ' selected' : '') + '>-- Pilih --</option>' + opts +
                    '</select>' +
                '</div>'
            );
        }

        if (f.type === 'textarea') {
            return (
                '<div class="prs-field" ' + delay + '>' +
                    '<label class="prs-label" for="' + f.name + '">' +
                        '<i class="fas ' + f.icon + '"></i> ' + f.label +
                    '</label>' +
                    '<textarea name="' + f.name + '" id="' + f.name + '" class="prs-textarea" ' +
                        'placeholder="' + (f.placeholder || '') + '" required>' + val + '</textarea>' +
                '</div>'
            );
        }

        var type = f.type || 'text';
        return (
            '<div class="prs-field" ' + delay + '>' +
                '<label class="prs-label" for="' + f.name + '">' +
                    '<i class="fas ' + f.icon + '"></i> ' + f.label +
                '</label>' +
                '<input type="' + type + '" name="' + f.name + '" id="' + f.name + '" ' +
                    'class="prs-input" ' +
                    (f.placeholder ? 'placeholder="' + f.placeholder + '" ' : '') +
                    (val ? 'value="' + val + '" ' : '') +
                    'required>' +
            '</div>'
        );
    }

    function renderFields(jenis) {
        var container  = document.getElementById('dynamic-fields');
        var btnWrapper = document.getElementById('btn-submit-wrapper');
        var fields     = fieldMap[jenis];

        if (!fields) {
            container.innerHTML = '';
            btnWrapper.style.display = 'none';
            return;
        }

        var html = '<hr class="prs-divider">' +
            '<p class="prs-hint-text"><i class="fas fa-info-circle"></i> Isi semua field berikut dengan benar.</p>';
        fields.forEach(function (f, idx) { html += buildField(f, idx); });
        container.innerHTML = html;
        btnWrapper.style.removeProperty('display');

        // --- 1. MENCEGAH TANGGAL MASA LALU ---
        // Dieksekusi setiap kali field di-render ulang
        var dateInputs = container.querySelectorAll('input[type="date"]');
        if (dateInputs.length > 0) {
            var today = new Date().toISOString().split('T')[0];
            dateInputs.forEach(function(input) {
                input.setAttribute('min', today);
            });
        }
    }

    // Eksekusi awal saat halam diload
    var selectEl = document.getElementById('jenis_surat');
    if (selectEl && selectEl.value) renderFields(selectEl.value);
    if (selectEl) selectEl.addEventListener('change', function () { renderFields(this.value); });

    // --- 2. PENCEGAHAN DOUBLE SUBMIT ---
    var formPersuratan = document.getElementById('form-persuratan');
    var btnSubmit = document.getElementById('btn-submit');

    if (formPersuratan && btnSubmit) {
        formPersuratan.addEventListener('submit', function (e) {
            // Cek validasi bawaan HTML5 (required)
            if (this.checkValidity()) {
                // Disable tombol
                btnSubmit.disabled = true;
                
                // Ubah teks dan beri ikon loading spin
                btnSubmit.innerHTML = '<i class="fas fa-circle-notch fa-spin me-2"></i>Memproses Pengajuan...';
                
                // Sedikit styling agar terlihat sedang tidak aktif
                btnSubmit.style.cursor = 'not-allowed';
                btnSubmit.style.opacity = '0.8';
            }
        });
    }

    // --- 3. FAQ ACCORDION (Sidebar) ---
    var faqList = document.getElementById('prs-faq-list');
    if (faqList) {
        faqList.addEventListener('click', function (e) {
            var btn = e.target.closest('.prs-faq-question');
            if (!btn) return;
            var item = btn.closest('.prs-faq-item');
            var wasOpen = item.classList.contains('prs-faq-open');

            faqList.querySelectorAll('.prs-faq-item').forEach(function (el) {
                el.classList.remove('prs-faq-open');
            });

            if (!wasOpen) item.classList.add('prs-faq-open');
        });
    }
}());
</script>