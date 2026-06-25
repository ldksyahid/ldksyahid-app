{{-- Flatpickr CSS + JS — taruh di <head> layout utama atau di sini --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_green.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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

    var fieldMap = {
        'izin-orang-tua': [
            { name: 'kode_bidang',  label: 'Asal Bidang / LDKSF', icon: 'fa-users',          type: 'select', options: bidangOptions },
            { name: 'nama_acara',   label: 'Nama Acara',           icon: 'fa-star',            placeholder: 'Contoh: Rihlah LDK Syahid 2025' },
            { name: 'tema_acara',   label: 'Tema Acara',           icon: 'fa-tag',             placeholder: 'Contoh: Membangun Generasi Islami' },
            { name: 'hari_tanggal', label: 'Tanggal',              icon: 'fa-calendar',        type: 'date' },
            { name: 'waktu',        label: 'Waktu',                icon: 'fa-clock',           type: 'time-range' },
            { name: 'tempat',       label: 'Tempat',               icon: 'fa-map-marker-alt',  placeholder: 'Contoh: Aula Madya UIN Jakarta' },
        ],
        'peminjaman-alat': [
            { name: 'kode_bidang',      label: 'Asal Bidang / LDKSF', icon: 'fa-users',  type: 'select', options: bidangOptions },
            { name: 'jenis_peminjaman', label: 'Sifat Peminjaman',     icon: 'fa-tag',    type: 'select',
              options: [{value:'internal',label:'Internal (LDK Syahid)'},{value:'eksternal',label:'Eksternal'}] },
            { name: 'nama_acara',       label: 'Nama Acara',           icon: 'fa-star',         placeholder: 'Contoh: Seminar Nasional' },
            { name: 'tema_acara',       label: 'Tema Acara',           icon: 'fa-tag',          placeholder: 'Contoh: Moderasi Beragama' },
            { name: 'ditujukan_kepada', label: 'Ditujukan Kepada',     icon: 'fa-envelope',     placeholder: 'Contoh: Departemen Media LDK / Perpustakaan' },
            { name: 'hari_tanggal',     label: 'Tanggal',              icon: 'fa-calendar',     type: 'date' },
            { name: 'waktu',            label: 'Waktu',                icon: 'fa-clock',        type: 'time-range' },
            { name: 'tempat',           label: 'Tempat',               icon: 'fa-map-marker-alt', placeholder: 'Contoh: Aula Madya' },
            { name: 'daftar_alat',      label: 'Daftar Alat',          icon: 'fa-list',         type: 'textarea', placeholder: 'Contoh:\n1. Proyektor\n2. Mic' },
        ],
        'peminjaman-tempat-kampus': [
            { name: 'kode_bidang',          label: 'Asal Bidang / LDKSF',   icon: 'fa-users',    type: 'select', options: bidangOptions },
            { name: 'nama_acara',           label: 'Nama Acara',             icon: 'fa-star',     placeholder: 'Contoh: Rapat Koordinasi' },
            { name: 'tema_acara',           label: 'Tema Acara',             icon: 'fa-tag',      placeholder: 'Contoh: Evaluasi Program Kerja' },
            { name: 'nama_ketua_pelaksana', label: 'Nama Ketua Pelaksana',   icon: 'fa-user',     placeholder: 'Contoh: Muhammad Syauqi' },
            { name: 'nim_ketua_pelaksana',  label: 'NIM Ketua Pelaksana',    icon: 'fa-id-card',  inputmode: 'numeric', pattern: '[0-9]*', placeholder: 'Contoh: 11230600000067' },
            { name: 'ditujukan_kepada',     label: 'Ditujukan Kepada',       icon: 'fa-envelope', placeholder: 'Contoh: Dekan FIDKOM' },
            { name: 'hari_tanggal',         label: 'Tanggal',                icon: 'fa-calendar', type: 'date' },
            { name: 'waktu',                label: 'Waktu',                  icon: 'fa-clock',    type: 'time-range' },
            { name: 'tempat_dipinjam',      label: 'Tempat yang Dipinjam',   icon: 'fa-building', placeholder: 'Contoh: Aula Student Center Lt. 3' },
        ],
        'permohonan-bantuan-dana': [
            { name: 'kode_bidang',      label: 'Asal Bidang / LDKSF', icon: 'fa-users',           type: 'select', options: bidangOptions },
            { name: 'nama_program',     label: 'Nama Program',         icon: 'fa-project-diagram', placeholder: 'Contoh: Kajian Rutin Ramadan' },
            { name: 'ditujukan_kepada', label: 'Ditujukan Kepada',     icon: 'fa-envelope',        placeholder: 'Contoh: Wakil Rektor III' },
            { name: 'keperluan',        label: 'Keperluan',            icon: 'fa-file-alt',        type: 'textarea', placeholder: 'Jelaskan kebutuhan dana secara singkat...' },
        ],
        'permohonan-izin-luar-kampus': [
            { name: 'kode_bidang',   label: 'Asal Bidang / LDKSF', icon: 'fa-users',          type: 'select', options: bidangOptions },
            { name: 'nama_acara',    label: 'Nama Acara',           icon: 'fa-star',            placeholder: 'Contoh: Camping Dakwah' },
            { name: 'tema_acara',    label: 'Tema Acara',           icon: 'fa-tag',             placeholder: 'Contoh: Merajut Ukhuwah' },
            { name: 'hari_tanggal',  label: 'Tanggal',              icon: 'fa-calendar',        type: 'date' },
            { name: 'waktu',         label: 'Waktu',                icon: 'fa-clock',           type: 'time-range' },
            { name: 'tempat',        label: 'Tempat',               icon: 'fa-map-marker-alt',  placeholder: 'Contoh: Bumi Perkemahan Ragunan' },
            { name: 'alamat_tempat', label: 'Alamat Lengkap',       icon: 'fa-map-pin',         placeholder: 'Contoh: Jl. Ragunan No. 1, Jakarta Selatan' },
        ],
        'surat-rekomendasi': [
            { name: 'kode_bidang',         label: 'Asal Bidang / LDKSF',            icon: 'fa-users',        type: 'select', options: bidangOptions },
            { name: 'nama',                label: 'Nama Lengkap',                    icon: 'fa-user',         placeholder: 'Contoh: Ahmad Fakhri' },
            { name: 'nim',                 label: 'NIM',                             icon: 'fa-id-card',      placeholder: 'Contoh: 11220910000001' },
            { name: 'fakultas',            label: 'Fakultas',                        icon: 'fa-university',   placeholder: 'Contoh: Dakwah dan Ilmu Komunikasi' },
            { name: 'jurusan',             label: 'Jurusan',                         icon: 'fa-graduation-cap', placeholder: 'Contoh: Komunikasi dan Penyiaran Islam' },
            { name: 'jabatan',             label: 'Jabatan di LDK',                  icon: 'fa-briefcase',    placeholder: 'Contoh: Ketua Departemen SPAM' },
            { name: 'program_rekomendasi', label: 'Program yang Direkomendasikan',   icon: 'fa-award',        placeholder: 'Contoh: Beasiswa Aktivis Peneleh 3' },
            { name: 'pertimbangan',        label: 'Pertimbangan',                    icon: 'fa-list-ul',      type: 'textarea', placeholder: 'Tulis pertimbangan rekomendasi (tiap baris = 1 poin)...' },
        ],
        'surat-undangan': [
            { name: 'kode_bidang',     label: 'Asal Bidang / LDKSF', icon: 'fa-users', type: 'select', options: bidangOptions },
            { name: 'jenis_undangan',  label: 'Jenis Undangan',       icon: 'fa-tag',   type: 'select',
              options: [{value:'internal',label:'Internal (LDK Syahid)'},{value:'eksternal',label:'Eksternal'}] },
            { name: 'nama_acara',      label: 'Nama Acara',           icon: 'fa-star',         placeholder: 'Contoh: Seminar Nasional' },
            { name: 'tema_acara',      label: 'Tema Acara',           icon: 'fa-tag',          placeholder: 'Contoh: Islam Rahmatan Lil Alamin' },
            { name: 'ditujukan_kepada',label: 'Ditujukan Kepada',     icon: 'fa-envelope',     placeholder: 'Contoh: Seluruh Mahasiswa UIN Jakarta' },
            { name: 'hari_tanggal',    label: 'Tanggal',              icon: 'fa-calendar',     type: 'date' },
            { name: 'waktu',           label: 'Waktu',                icon: 'fa-clock',        type: 'time-range' },
            { name: 'tempat',          label: 'Tempat',               icon: 'fa-map-marker-alt', placeholder: 'Contoh: Auditorium Utama' },
        ],
        'surat-aktif-organisasi': [
            { name: 'kode_bidang',  label: 'Asal Bidang / LDKSF',    icon: 'fa-users',        type: 'select', options: bidangOptions },
            { name: 'nama',         label: 'Nama Lengkap',            icon: 'fa-user',          placeholder: 'Contoh: Ahmad Fakhri' },
            { name: 'ttl',          label: 'Tempat, Tanggal Lahir',   icon: 'fa-calendar-alt', placeholder: 'Contoh: Jakarta, 17 Agustus 2005' },
            { name: 'nim',          label: 'NIM',                     icon: 'fa-id-card',       placeholder: 'Contoh: 11220910000001' },
            { name: 'fakultas',     label: 'Fakultas',                icon: 'fa-university',    placeholder: 'Contoh: Sains dan Teknologi' },
            { name: 'jurusan',      label: 'Semester / Jurusan',      icon: 'fa-graduation-cap', placeholder: 'Contoh: 5 / Teknik Informatika' },
            { name: 'jabatan',      label: 'Bidang / Jabatan',        icon: 'fa-briefcase',     placeholder: 'Contoh: Ketua Departemen PKPI' },
            { name: 'keperluan',    label: 'Keperluan',               icon: 'fa-file-alt',      type: 'textarea', placeholder: 'Contoh: Persyaratan Beasiswa...' },
            { name: 'penyelenggara',label: 'Penyelenggara',           icon: 'fa-building',      placeholder: 'Contoh: BAZNAS' },
        ],
        'permohonan-pemateri': [
            { name: 'kode_bidang',      label: 'Asal Bidang / LDKSF', icon: 'fa-users',          type: 'select', options: bidangOptions },
            { name: 'nama_acara',       label: 'Nama Acara',           icon: 'fa-star' },
            { name: 'tema_acara',       label: 'Tema Acara',           icon: 'fa-tag' },
            { name: 'ditujukan_kepada', label: 'Ditujukan Kepada',     icon: 'fa-envelope',       placeholder: 'Contoh: Ustadz Hanan Attaki' },
            { name: 'materi',           label: 'Tema Materi Khusus',   icon: 'fa-book',           placeholder: 'Contoh: Peran Pemuda di Era Digital' },
            { name: 'hari_tanggal',     label: 'Tanggal',              icon: 'fa-calendar',       type: 'date' },
            { name: 'waktu',            label: 'Waktu',                icon: 'fa-clock',          type: 'time-range' },
            { name: 'tempat',           label: 'Tempat',               icon: 'fa-map-marker-alt' },
        ],
        'kerja-sama-sponsorship': [
            { name: 'kode_bidang',     label: 'Asal Bidang / LDKSF', icon: 'fa-users',     type: 'select', options: bidangOptions },
            { name: 'nama_acara',      label: 'Nama Acara',           icon: 'fa-star' },
            { name: 'tema_acara',      label: 'Tema Acara',           icon: 'fa-tag' },
            { name: 'ditujukan_kepada',label: 'Ditujukan Kepada',     icon: 'fa-envelope',  placeholder: 'Contoh: Manager PT. Wardah Cosmetics' },
            { name: 'bentuk_kerjasama',label: 'Bentuk Kerja Sama',    icon: 'fa-handshake', type: 'textarea', placeholder: 'Jelaskan ringkasan penawaran sponsorship...' },
        ],
        'surat-pemberitahuan': [
            { name: 'kode_bidang',      label: 'Asal Bidang / LDKSF', icon: 'fa-users',          type: 'select', options: bidangOptions },
            { name: 'nama_kegiatan',    label: 'Nama Kegiatan',        icon: 'fa-star' },
            { name: 'ditujukan_kepada', label: 'Ditujukan Kepada',     icon: 'fa-envelope',       placeholder: 'Contoh: Satpam UIN Jakarta' },
            { name: 'hari_tanggal',     label: 'Tanggal',              icon: 'fa-calendar',       type: 'date' },
            { name: 'waktu',            label: 'Waktu',                icon: 'fa-clock',          type: 'time-range' },
            { name: 'tempat',           label: 'Tempat',               icon: 'fa-map-marker-alt' },
        ],
    };

    var oldValues = @json(old());

    function escapeAttr(v) {
        return String(v || '')
            .replace(/&/g, '&amp;').replace(/"/g, '&quot;')
            .replace(/</g, '&lt;').replace(/>/g, '&gt;');
    }

    function parseTimeRange(value) {
        var cleaned = String(value || '').replace(' WIB', '');
        var parts   = cleaned.split(' s.d. ');
        return { start: parts.length === 2 ? parts[0] : '', end: parts.length === 2 ? parts[1] : '' };
    }

    /* ── Flatpickr instances registry ── */
    var fpInstances = {};

    function syncTimeRange(name) {
        var startFp = fpInstances[name + '_start'];
        var endFp   = fpInstances[name + '_end'];
        var hidden  = document.getElementById(name);
        if (!startFp || !endFp || !hidden) return;

        var sv = startFp.input.value;
        var ev = endFp.input.value;
        hidden.value = (sv && ev) ? sv + ' s.d. ' + ev + ' WIB' : '';
    }

    window.prsSyncTimeRange = syncTimeRange;

    function initFlatpickrTime(name, val) {
        var tr = parseTimeRange(val);

        ['start', 'end'].forEach(function (side) {
            var inputId  = name + '_' + side;
            var el       = document.getElementById(inputId);
            if (!el) return;

            var initTime = side === 'start' ? tr.start : tr.end;

            var fp = flatpickr(el, {
                enableTime:  true,
                noCalendar:  true,
                dateFormat:  'H:i',        /* output: 08:00 */
                time_24hr:   true,
                minuteIncrement: 5,        /* loncat per 5 menit */
                defaultDate: initTime || null,
                disableMobile: false,      /* pakai native picker di mobile */
                onClose: function () { syncTimeRange(name); },
                onChange: function () { syncTimeRange(name); },
            });

            fpInstances[inputId] = fp;
        });

        /* set initial hidden value kalau ada old value */
        if (tr.start && tr.end) {
            var hidden = document.getElementById(name);
            if (hidden) hidden.value = val;
        }
    }

    /* ── Build HTML field ── */
    function buildField(f, idx) {
        var val   = oldValues[f.name] || '';
        var delay = 'style="animation-delay:' + (idx * 0.05).toFixed(2) + 's"';

        /* TIME RANGE — pakai Flatpickr */
        if (f.type === 'time-range') {
            var tr = parseTimeRange(val);
            return (
                '<div class="prs-field" ' + delay + '>' +
                    '<label class="prs-label"><i class="fas ' + f.icon + '"></i> ' + f.label + '</label>' +
                    '<div class="prs-time-range">' +
                        '<div class="prs-time-box">' +
                            '<span class="prs-time-caption">Mulai</span>' +
                            '<div class="prs-fp-wrap">' +
                                '<i class="fas fa-clock prs-fp-icon"></i>' +
                                '<input type="text" id="' + f.name + '_start" class="prs-input prs-fp-input" ' +
                                    'placeholder="08:00" value="' + escapeAttr(tr.start) + '" readonly>' +
                            '</div>' +
                        '</div>' +
                        '<span class="prs-time-separator">s.d.</span>' +
                        '<div class="prs-time-box">' +
                            '<span class="prs-time-caption">Selesai</span>' +
                            '<div class="prs-fp-wrap">' +
                                '<i class="fas fa-clock prs-fp-icon"></i>' +
                                '<input type="text" id="' + f.name + '_end" class="prs-input prs-fp-input" ' +
                                    'placeholder="17:00" value="' + escapeAttr(tr.end) + '" readonly>' +
                            '</div>' +
                        '</div>' +
                        '<span class="prs-time-zone">WIB</span>' +
                    '</div>' +
                    '<input type="hidden" name="' + f.name + '" id="' + f.name + '" value="' + escapeAttr(val) + '" required>' +
                '</div>'
            );
        }

        /* DATE */
        if (f.type === 'date') {
            return (
                '<div class="prs-field" ' + delay + '>' +
                    '<label class="prs-label" for="' + f.name + '"><i class="fas ' + f.icon + '"></i> ' + f.label + '</label>' +
                    '<div class="prs-date-wrap">' +
                        '<input type="date" name="' + f.name + '" id="' + f.name + '" class="prs-input prs-date-input" value="' + escapeAttr(val) + '" required>' +
                        '<span class="prs-date-icon"><i class="fas fa-calendar-day"></i></span>' +
                    '</div>' +
                '</div>'
            );
        }

        /* SELECT */
        if (f.type === 'select') {
            var opts = f.options.map(function (o) {
                return '<option value="' + o.value + '"' + (val === o.value ? ' selected' : '') + '>' + o.label + '</option>';
            }).join('');
            return (
                '<div class="prs-field" ' + delay + '>' +
                    '<label class="prs-label" for="' + f.name + '"><i class="fas ' + f.icon + '"></i> ' + f.label + '</label>' +
                    '<select name="' + f.name + '" id="' + f.name + '" class="prs-select" required>' +
                        '<option value="" disabled' + (!val ? ' selected' : '') + '>-- Pilih --</option>' + opts +
                    '</select>' +
                '</div>'
            );
        }

        /* TEXTAREA */
        if (f.type === 'textarea') {
            return (
                '<div class="prs-field" ' + delay + '>' +
                    '<label class="prs-label" for="' + f.name + '"><i class="fas ' + f.icon + '"></i> ' + f.label + '</label>' +
                    '<textarea name="' + f.name + '" id="' + f.name + '" class="prs-textarea" ' +
                        'placeholder="' + escapeAttr(f.placeholder || '') + '" required>' + val + '</textarea>' +
                '</div>'
            );
        }

        /* TEXT / DEFAULT */
        return (
            '<div class="prs-field" ' + delay + '>' +
                '<label class="prs-label" for="' + f.name + '"><i class="fas ' + f.icon + '"></i> ' + f.label + '</label>' +
                '<input type="' + (f.type || 'text') + '" name="' + f.name + '" id="' + f.name + '" class="prs-input" ' +
                    (f.inputmode ? 'inputmode="' + escapeAttr(f.inputmode) + '" ' : '') +
                    (f.pattern   ? 'pattern="'   + escapeAttr(f.pattern)   + '" ' : '') +
                    (f.placeholder ? 'placeholder="' + escapeAttr(f.placeholder) + '" ' : '') +
                    (val ? 'value="' + escapeAttr(val) + '" ' : '') +
                    'required>' +
            '</div>'
        );
    }

    /* ── Render semua field + init Flatpickr setelah DOM siap ── */
    function renderFields(jenis) {
        var container  = document.getElementById('dynamic-fields');
        var btnWrapper = document.getElementById('btn-submit-wrapper');
        var fields     = fieldMap[jenis];

        /* destroy Flatpickr lama sebelum re-render */
        Object.keys(fpInstances).forEach(function (k) {
            fpInstances[k].destroy();
            delete fpInstances[k];
        });

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

        /* init date min=today */
        var today = (function () {
            var n = new Date();
            return n.getFullYear() + '-' +
                String(n.getMonth() + 1).padStart(2, '0') + '-' +
                String(n.getDate()).padStart(2, '0');
        }());
        container.querySelectorAll('input[type="date"]').forEach(function (inp) {
            inp.setAttribute('min', today);
            inp.addEventListener('focus', function () {
                if (typeof this.showPicker === 'function') try { this.showPicker(); } catch (e) {}
            });
        });

        /* init Flatpickr untuk semua field time-range */
        fields.forEach(function (f) {
            if (f.type === 'time-range') {
                initFlatpickrTime(f.name, oldValues[f.name] || '');
            }
        });
    }

    /* ── Boot ── */
    var selectEl = document.getElementById('jenis_surat');
    if (selectEl && selectEl.value) renderFields(selectEl.value);
    if (selectEl) selectEl.addEventListener('change', function () { renderFields(this.value); });

    /* ── Anti double-submit ── */
    var formEl    = document.getElementById('form-persuratan');
    var btnSubmit = document.getElementById('btn-submit');
    if (formEl && btnSubmit) {
        formEl.addEventListener('submit', function (e) {
            if (this.checkValidity()) {
                btnSubmit.disabled = true;
                btnSubmit.innerHTML = '<i class="fas fa-circle-notch fa-spin me-2"></i>Memproses Pengajuan...';
                btnSubmit.style.cursor  = 'not-allowed';
                btnSubmit.style.opacity = '0.8';
            }
        });
    }

    /* ── FAQ Accordion ── */
    var faqList = document.getElementById('prs-faq-list');
    if (faqList) {
        faqList.addEventListener('click', function (e) {
            var btn = e.target.closest('.prs-faq-question');
            if (!btn) return;
            var item    = btn.closest('.prs-faq-item');
            var wasOpen = item.classList.contains('prs-faq-open');
            faqList.querySelectorAll('.prs-faq-item').forEach(function (el) { el.classList.remove('prs-faq-open'); });
            if (!wasOpen) item.classList.add('prs-faq-open');
        });
    }

    /* ── Mobile Bottom Sheet ── */
    var triggerBtn  = document.getElementById('prs-mobile-trigger');
    var backdrop    = document.getElementById('prs-bs-backdrop');
    var bottomSheet = document.getElementById('prs-bottom-sheet');
    var closeBtn    = document.getElementById('prs-bs-close');

    function toggleSheet(show) {
        bottomSheet.classList.toggle('active', show);
        backdrop.classList.toggle('active', show);
        document.body.classList.toggle('prs-sheet-open', show);
    }

    if (triggerBtn)  triggerBtn.addEventListener('click',  function () { toggleSheet(true); });
    if (closeBtn)    closeBtn.addEventListener('click',    function () { toggleSheet(false); });
    if (backdrop)    backdrop.addEventListener('click',    function () { toggleSheet(false); });

    /* Override style Flatpickr agar cocok dengan desain form */
    var fpStyle = document.createElement('style');
    fpStyle.textContent = [
        '.prs-fp-wrap { position: relative; }',
        '.prs-fp-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #36aaa1; pointer-events: none; font-size: 13px; }',
        '.prs-fp-input { padding-left: 34px !important; cursor: pointer; background: #fff !important; }',
        '.flatpickr-calendar { border-radius: 12px !important; box-shadow: 0 8px 24px rgba(0,0,0,.12) !important; border: none !important; }',
        '.flatpickr-time input { font-size: 22px !important; font-weight: 600 !important; color: #1a1a2e !important; }',
        '.flatpickr-time .flatpickr-time-separator { font-size: 22px !important; font-weight: 600 !important; }',
        '.flatpickr-time input:hover, .flatpickr-time input:focus { background: #f0fafa !important; }',
        '.numInputWrapper span.arrowUp, .numInputWrapper span.arrowDown { border-color: #36aaa1 !important; }',
    ].join('\n');
    document.head.appendChild(fpStyle);

}());
</script>