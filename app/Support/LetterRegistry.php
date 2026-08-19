<?php

namespace App\Support;

class LetterRegistry
{
    public const KODE_JENIS = [
        'izin-orang-tua'                      => ['kode' => 'Ph',    'sifat' => 'e'],
        'peminjaman-alat'                     => ['kode' => 'Ph',    'sifat' => 'e'],
        'peminjaman-tempat-kampus'            => ['kode' => 'Ph',    'sifat' => 'i'],
        'peminjaman-tempat-fakultas'          => ['kode' => 'Ph',    'sifat' => 'i'],
        'peminjaman-tempat-luar-kampus'       => ['kode' => 'Ph',    'sifat' => 'e'],
        'permohonan-bantuan-dana'             => ['kode' => 'Ph',    'sifat' => 'e'],
        'permohonan-izin-luar-kampus'         => ['kode' => 'Ph',    'sifat' => 'e'],
        'surat-rekomendasi'                   => ['kode' => 'SR',    'sifat' => 'e'],
        'surat-undangan'                      => ['kode' => 'Und',   'sifat' => null],
        'surat-aktif-organisasi'              => ['kode' => 'S.Ket', 'sifat' => 'e'],
        'permohonan-pemateri'                 => ['kode' => 'Ph',    'sifat' => 'e'],
        'permohonan-sambutan'                 => ['kode' => 'Ph',    'sifat' => 'e'],
        'surat-izin-buka-stand'               => ['kode' => 'Ph',    'sifat' => 'i'],
        'surat-izin-pengambilan-gambar-video' => ['kode' => 'Ph',    'sifat' => 'i'],
        'surat-kunjungan-lembaga'             => ['kode' => 'Ph',    'sifat' => 'e'],
        'surat-imbauan'                       => ['kode' => 'Pb',    'sifat' => 'e'],
        'kerja-sama-sponsorship'              => ['kode' => 'Ks',    'sifat' => 'e'],
        'surat-pemberitahuan'                 => ['kode' => 'Pb',    'sifat' => 'e'],
    ];

    public const CATEGORIES = [
        'all'                  => ['label' => 'Semua Surat',        'icon' => 'fa-th-large'],
        'izin_peminjaman'      => ['label' => 'Izin & Peminjaman',  'icon' => 'fa-building-columns'],
        'permohonan_kemitraan' => ['label' => 'Permohonan & Mitra', 'icon' => 'fa-handshake'],
        'keterangan_undangan'  => ['label' => 'Keterangan & Undangan', 'icon' => 'fa-file-signature'],
    ];

    private const TYPES = [
        'izin-orang-tua' => [
            'label'       => 'Surat Izin Orang Tua',
            'category'    => 'izin_peminjaman',
            'icon'        => 'fa-user-shield',
            'badge'       => 'Ph-e',
            'description' => 'Izin kepada orang tua/wali kader untuk mengikuti agenda kegiatan resmi LDK Syahid.',
            'fields'      => ['kode_bidang', 'nama_acara', 'tema_acara', 'hari_tanggal', 'waktu', 'tempat'],
        ],
        'peminjaman-alat' => [
            'label'       => 'Surat Peminjaman Alat',
            'category'    => 'izin_peminjaman',
            'icon'        => 'fa-tools',
            'badge'       => 'Ph-e',
            'description' => 'Permohonan peminjaman inventaris & perlengkapan operasional kegiatan.',
            'fields'      => ['kode_bidang', 'jenis_peminjaman', 'nama_acara', 'tema_acara', 'ditujukan_kepada', 'hari_tanggal', 'waktu', 'tempat', 'daftar_alat'],
        ],
        'peminjaman-tempat-kampus' => [
            'label'       => 'Surat Peminjaman Fasilitas Kampus Bersama',
            'category'    => 'izin_peminjaman',
            'icon'        => 'fa-landmark',
            'badge'       => 'Ph-i',
            'description' => 'Peminjaman fasilitas bersama kampus UIN Jakarta (Student Center, Aula, Lapangan).',
            'fields'      => ['kode_bidang', 'nama_acara', 'tema_acara', 'nama_ketua_pelaksana', 'nim_ketua_pelaksana', 'ditujukan_kepada', 'hari_tanggal', 'waktu', 'tempat_dipinjam'],
        ],
        'peminjaman-tempat-fakultas' => [
            'label'       => 'Surat Peminjaman Tempat Fakultas (Internal)',
            'category'    => 'izin_peminjaman',
            'icon'        => 'fa-school',
            'badge'       => 'Ph-i',
            'description' => 'Peminjaman ruang kuliah, teater, atau aula internal di lingkungan fakultas UIN.',
            'fields'      => ['kode_bidang', 'nama_acara', 'tema_acara', 'nama_ketua_pelaksana', 'nim_ketua_pelaksana', 'ditujukan_kepada', 'hari_tanggal', 'waktu', 'tempat_dipinjam'],
        ],
        'peminjaman-tempat-luar-kampus' => [
            'label'       => 'Surat Peminjaman Tempat Luar Kampus',
            'category'    => 'izin_peminjaman',
            'icon'        => 'fa-map-marked-alt',
            'badge'       => 'Ph-e',
            'description' => 'Permohonan izin peminjaman tempat atau lokasi kegiatan di luar kampus.',
            'fields'      => ['kode_bidang', 'nama_acara', 'tema_acara', 'nama_ketua_pelaksana', 'nim_ketua_pelaksana', 'ditujukan_kepada', 'hari_tanggal', 'waktu', 'tempat_dipinjam'],
        ],
        'permohonan-bantuan-dana' => [
            'label'       => 'Surat Permohonan Bantuan Dana',
            'category'    => 'permohonan_kemitraan',
            'icon'        => 'fa-hand-holding-usd',
            'badge'       => 'Ph-e',
            'description' => 'Pengajuan permohonan donasi atau bantuan sponsorship dana kegiatan.',
            'fields'      => ['kode_bidang', 'nama_program', 'ditujukan_kepada', 'keperluan'],
        ],
        'permohonan-izin-luar-kampus' => [
            'label'       => 'Surat Permohonan Izin Kegiatan di Luar Kampus',
            'category'    => 'izin_peminjaman',
            'icon'        => 'fa-bus',
            'badge'       => 'Ph-e',
            'description' => 'Permohonan izin kegiatan di luar kampus kepada Wakil Rektor Bidang Kemahasiswaan.',
            'fields'      => ['kode_bidang', 'nama_acara', 'tema_acara', 'hari_tanggal', 'waktu', 'tempat', 'alamat_tempat'],
        ],
        'surat-rekomendasi' => [
            'label'       => 'Surat Rekomendasi',
            'category'    => 'keterangan_undangan',
            'icon'        => 'fa-award',
            'badge'       => 'SR-e',
            'description' => 'Rekomendasi resmi pengurus untuk beasiswa, seleksi delegasi, atau perlombaan.',
            'fields'      => ['kode_bidang', 'nama', 'nim', 'fakultas', 'jurusan', 'jabatan', 'program_rekomendasi', 'pertimbangan'],
        ],
        'surat-undangan' => [
            'label'       => 'Surat Undangan',
            'category'    => 'keterangan_undangan',
            'icon'        => 'fa-envelope-open-text',
            'badge'       => 'Und-i/e',
            'description' => 'Undangan resmi menghadiri agenda acara untuk pihak internal maupun eksternal.',
            'fields'      => ['kode_bidang', 'jenis_undangan', 'nama_acara', 'tema_acara', 'ditujukan_kepada', 'hari_tanggal', 'waktu', 'tempat'],
        ],
        'surat-aktif-organisasi' => [
            'label'       => 'Surat Keterangan Aktif Organisasi',
            'category'    => 'keterangan_undangan',
            'icon'        => 'fa-id-card',
            'badge'       => 'S.Ket-e',
            'description' => 'Keterangan resmi status keaktifan kepengurusan mahasiswa di UKM LDK Syahid.',
            'fields'      => ['kode_bidang', 'nama', 'ttl', 'nim', 'fakultas', 'jurusan', 'jabatan', 'keperluan', 'penyelenggara'],
        ],
        'permohonan-pemateri' => [
            'label'       => 'Surat Permohonan Narasumber / Pemateri',
            'category'    => 'permohonan_kemitraan',
            'icon'        => 'fa-chalkboard-teacher',
            'badge'       => 'Ph-e',
            'description' => 'Permohonan kesediaan menjadi pemateri/narasumber pada seminar, workshop, atau kajian.',
            'fields'      => ['kode_bidang', 'nama_acara', 'tema_acara', 'ditujukan_kepada', 'hari_tanggal', 'waktu', 'tempat', 'materi'],
        ],
        'permohonan-sambutan' => [
            'label'       => 'Surat Permohonan Sambutan',
            'category'    => 'permohonan_kemitraan',
            'icon'        => 'fa-microphone-alt',
            'badge'       => 'Ph-e',
            'description' => 'Permohonan kata sambutan dari pimpinan/tokoh dalam pembukaan kegiatan.',
            'fields'      => ['kode_bidang', 'nama_acara', 'tema_acara', 'ditujukan_kepada', 'jabatan_tujuan', 'hari_tanggal', 'waktu', 'tempat'],
        ],
        'surat-izin-buka-stand' => [
            'label'       => 'Surat Izin Buka Stand',
            'category'    => 'izin_peminjaman',
            'icon'        => 'fa-store',
            'badge'       => 'Ph-i',
            'description' => 'Permohonan izin membuka stand/booth promosi, bazar kuliner, atau stand pameran.',
            'fields'      => ['kode_bidang', 'nama_acara', 'ditujukan_kepada', 'hari_tanggal', 'waktu', 'tempat', 'keperluan'],
        ],
        'surat-izin-pengambilan-gambar-video' => [
            'label'       => 'Surat Izin Pengambilan Gambar / Video',
            'category'    => 'izin_peminjaman',
            'icon'        => 'fa-camera',
            'badge'       => 'Ph-i',
            'description' => 'Izin dokumentasi peliputan, pengambilan foto, dan perekaman video resmi kegiatan.',
            'fields'      => ['kode_bidang', 'nama_acara', 'ditujukan_kepada', 'hari_tanggal', 'waktu', 'tempat', 'keperluan'],
        ],
        'surat-kunjungan-lembaga' => [
            'label'       => 'Surat Kunjungan Lembaga / Studi Banding',
            'category'    => 'permohonan_kemitraan',
            'icon'        => 'fa-people-arrows',
            'badge'       => 'Ph-e',
            'description' => 'Permohonan kunjungan silaturahmi, studi banding, atau audiensi ke lembaga lain.',
            'fields'      => ['kode_bidang', 'nama_kegiatan', 'ditujukan_kepada', 'hari_tanggal', 'waktu', 'tempat', 'keperluan'],
        ],
        'surat-imbauan' => [
            'label'       => 'Surat Imbauan',
            'category'    => 'keterangan_undangan',
            'icon'        => 'fa-bullhorn',
            'badge'       => 'Pb-e',
            'description' => 'Surat imbauan dan arahan resmi pengurus kepada anggota atau civitas akademika.',
            'fields'      => ['kode_bidang', 'perihal_imbauan', 'ditujukan_kepada', 'poin_imbauan'],
        ],
        'kerja-sama-sponsorship' => [
            'label'       => 'Surat Kerja Sama / Sponsorship',
            'category'    => 'permohonan_kemitraan',
            'icon'        => 'fa-handshake',
            'badge'       => 'Ks-e',
            'description' => 'Permohonan kemitraan, media partner, atau kerja sama sponsorship dengan mitra.',
            'fields'      => ['kode_bidang', 'nama_acara', 'tema_acara', 'ditujukan_kepada', 'bentuk_kerjasama'],
        ],
        'surat-pemberitahuan' => [
            'label'       => 'Surat Pemberitahuan',
            'category'    => 'keterangan_undangan',
            'icon'        => 'fa-bell',
            'badge'       => 'Pb-e',
            'description' => 'Pemberitahuan resmi mengenai kegiatan kepada pengamanan atau pihak terkait.',
            'fields'      => ['kode_bidang', 'nama_kegiatan', 'ditujukan_kepada', 'hari_tanggal', 'waktu', 'tempat'],
        ],
    ];

    public static function all(): array
    {
        return self::TYPES;
    }

    public static function categories(): array
    {
        return self::CATEGORIES;
    }

    public static function exists(string $type): bool
    {
        return isset(self::TYPES[$type]);
    }

    public static function get(string $type): ?array
    {
        return self::TYPES[$type] ?? null;
    }

    public static function getLabel(string $type): string
    {
        return self::TYPES[$type]['label'] ?? $type;
    }

    public static function getFields(string $type): array
    {
        return self::TYPES[$type]['fields'] ?? [];
    }

    public static function getKodeJenis(string $type): ?array
    {
        return self::KODE_JENIS[$type] ?? null;
    }

    public static function getValidationRules(string $type): ?array
    {
        if (!isset(self::TYPES[$type])) {
            return null;
        }

        $rules = ['jenis_surat' => 'required|string'];

        foreach (self::TYPES[$type]['fields'] as $field) {
            if ($field === 'kode_bidang') {
                $rules[$field] = 'required|string|max:20';
            } elseif ($field === 'nim_ketua_pelaksana') {
                $rules[$field] = 'required|string|max:30|regex:/^[0-9]+$/';
            } elseif (in_array($field, ['jenis_undangan', 'jenis_peminjaman'])) {
                $rules[$field] = 'required|in:internal,eksternal';
            } elseif (in_array($field, ['hari_tanggal', 'tanggal_mulai', 'tanggal_selesai'])) {
                $rules[$field] = 'required|string|max:100';
            } elseif (in_array($field, ['daftar_alat', 'keperluan', 'pertimbangan', 'bentuk_kerjasama', 'materi', 'poin_imbauan'])) {
                $rules[$field] = 'required|string|max:2000';
            } else {
                $rules[$field] = 'required|string|max:255';
            }
        }

        return $rules;
    }
}