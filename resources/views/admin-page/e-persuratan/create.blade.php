@extends('admin-page.template.body')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    .note-editor .note-editing-area { font-family: 'Times New Roman', Times, serif; font-size: 12pt; }
</style>
@endsection

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white mt-2 pb-0 border-0">
            <h4 class="mb-0 fw-bold"><i class="fas fa-edit text-primary me-2"></i>Buat Surat Baru</h4>
            <p class="text-muted small">Silakan pilih jenis surat, template akan otomatis terisi.</p>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.e-persuratan.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Jenis Surat <span class="text-danger">*</span></label>
                        <select class="form-select border-2" name="type" id="jenisSurat" required>
                            <option value="">-- Pilih Jenis Surat --</option>
                            <option value="Peminjaman Tempat">Permohonan Peminjaman Tempat</option>
                            <option value="Permohonan Narasumber">Permohonan Menjadi Narasumber</option>
                            <option value="Surat Keputusan (SK)">Surat Keputusan (SK)</option>
                            <option value="Surat Undangan">Surat Undangan (Umum)</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Tujuan Surat / Kepada Yth. <span class="text-danger">*</span></label>
                        <input type="text" class="form-control border-2" name="destination" placeholder="Contoh: Pengurus DKM Masjid Fathullah" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Perihal / Hal <span class="text-danger">*</span></label>
                    <input type="text" class="form-control border-2" name="subject" id="perihalSurat" placeholder="Otomatis terisi menyesuaikan jenis surat..." required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Isi Surat <span class="text-danger">*</span></label>
                    <textarea id="summernote" name="content" required></textarea>
                </div>

                <hr class="my-4">

                <div class="text-end">
                    <a href="{{ route('admin.e-persuratan.index') }}" class="btn btn-light border-2 px-4 me-2 rounded-pill">Batal</a>
                    <button type="submit" class="btn btn-primary px-4 rounded-pill">
                        <i class="fas fa-paper-plane me-2"></i>Simpan & Ajukan Approval
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
$(document).ready(function() {
    // Inisialisasi Text Editor
    $('#summernote').summernote({
        placeholder: 'Ketik isi surat di sini...',
        tabsize: 2,
        height: 350,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'italic', 'clear']],
            ['fontname', ['fontname']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });

    // Otomatisasi Template Surat berdasarkan Pilihan
    $('#jenisSurat').on('change', function() {
        let jenis = $(this).val();
        let templateContent = '';
        let halContent = '';

        if (jenis === 'Peminjaman Tempat') {
            halContent = 'Permohonan Peminjaman Tempat';
            templateContent = `
                <p style="text-align: justify;">Teriring do’a dan harapan semoga Bapak/Ibu dalam keadaan sehat wal ‘afiat serta berkah dalam menjalankan aktivitas sehari-hari.</p>
                <p style="text-align: justify;">Sehubungan dengan pelaksanaan <strong>[Nama Acara]</strong> dengan tema <strong>“[Tema Acara]”</strong> yang dilaksanakan oleh pengurus UKM Lembaga Dakwah Kampus (LDK) Syahid UIN Syarif Hidayatullah Jakarta, yang InsyaAllah akan dilaksanakan pada:</p>
                <table style="width: 100%; margin-left: 20px; margin-bottom: 15px;">
                    <tbody>
                        <tr><td style="width: 20%;">Hari, Tanggal</td><td style="width: 5%;">:</td><td>[Hari, Tanggal Pelaksanaan]</td></tr>
                        <tr><td>Waktu</td><td>:</td><td>[Waktu Pelaksanaan] WIB</td></tr>
                        <tr><td>Tempat</td><td>:</td><td>[Lokasi Pelaksanaan]</td></tr>
                    </tbody>
                </table>
                <p style="text-align: justify;">Maka kami selaku pengurus UKM Lembaga Dakwah Kampus (LDK) memohon izin meminjam <strong>[Sebutkan Nama Tempat]</strong> demi terlaksananya kegiatan tersebut.</p>
                <p style="text-align: justify;">Demikian permohonan ini kami sampaikan. Atas perhatian dan bantuannya, kami ucapkan terima kasih.</p>
            `;
        } 
        else if (jenis === 'Permohonan Narasumber') {
            halContent = 'Permohonan Menjadi Narasumber';
            templateContent = `
                <p style="text-align: justify;">Teriring do’a dan harapan semoga Bapak/Ibu/Saudara/i dalam keadaan sehat wal ‘afiat serta berkah dalam menjalankan aktivitas sehari-hari.</p>
                <p style="text-align: justify;">Sehubungan dengan pelaksanaan <strong>[Nama Acara]</strong> dengan tema <strong>“[Tema Acara]”</strong> yang dilaksanakan oleh pengurus UKM Lembaga Dakwah Kampus (LDK) Syahid UIN Syarif Hidayatullah Jakarta, yang InsyaAllah akan dilaksanakan pada:</p>
                <table style="width: 100%; margin-left: 20px; margin-bottom: 15px;">
                    <tbody>
                        <tr><td style="width: 20%;">Hari, Tanggal</td><td style="width: 5%;">:</td><td>[Hari, Tanggal Pelaksanaan]</td></tr>
                        <tr><td>Waktu</td><td>:</td><td>[Waktu Pelaksanaan] WIB</td></tr>
                        <tr><td>Tempat</td><td>:</td><td>[Lokasi Pelaksanaan]</td></tr>
                    </tbody>
                </table>
                <p style="text-align: justify;">Maka kami selaku panitia bermaksud memohon Bapak/Ibu/Saudara/i untuk bersedia menjadi <strong>Narasumber</strong> dalam acara tersebut.</p>
                <p style="text-align: justify;">Demikian permohonan ini kami sampaikan. Atas perhatian dan bantuannya, kami ucapkan terima kasih.</p>
            `;
        }
        else if (jenis === 'Surat Keputusan (SK)') {
            halContent = 'PENGANGKATAN DAN PENGESAHAN STRUKTUR';
            templateContent = `
                <p style="text-align: center;"><strong>PENGANGKATAN DAN PENGESAHAN<br>STRUKTUR KEPANITIAAN [NAMA ACARA]<br>LEMBAGA DAKWAH KAMPUS (LDK) SYAHID<br>PERIODE 2026</strong></p>
                <p style="text-align: justify;">Dengan senantiasa mengharap rahmat Allah SWT, serta petunjuk dan keridhoan-Nya untuk tetap menapaki jalan kebenaran dan dengan untaian asma Allah, Lembaga Dakwah Kampus Syahid, setelah:</p>
                <table style="width: 100%;">
                    <tbody>
                        <tr><td style="width: 15%; vertical-align: top;"><strong>Menimbang</strong></td><td style="width: 5%; vertical-align: top;">:</td><td>1. Perlunya dibentuk kepanitiaan sebagai aplikasi untuk melaksanakan agenda...<br>2. Pentingnya kegiatan tersebut...</td></tr>
                        <tr><td style="vertical-align: top;"><strong>Memperhatikan</strong></td><td style="vertical-align: top;">:</td><td>Hasil Syuro...</td></tr>
                        <tr><td style="vertical-align: top;"><strong>Mengingat</strong></td><td style="vertical-align: top;">:</td><td>1. Al-Qur’an dan As-Sunnah.<br>2. Anggaran Dasar (AD) dan Anggaran Rumah Tangga (ART) LDK Syahid.</td></tr>
                        <tr><td style="vertical-align: top;"><strong>Memutuskan</strong></td><td style="vertical-align: top;">:</td><td>Mengangkat dan mengesahkan kepanitiaan [Nama Acara] 2026.</td></tr>
                    </tbody>
                </table>
            `;
        }

        // Memasukkan konten ke input Perihal dan Summernote
        $('#perihalSurat').val(halContent);
        $('#summernote').summernote('code', templateContent);
    });
});
</script>
@endsection