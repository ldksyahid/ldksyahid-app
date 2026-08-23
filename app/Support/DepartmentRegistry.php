<?php

namespace App\Support;

class DepartmentRegistry
{
    public const GROUPS = [
        'Pengurus Pusat' => [
            'BPH'  => 'BPH (Badan Pengurus Harian)',
            'KST'  => 'Biro Kesekretariatan',
            'KEU'  => 'Biro Keuangan',
            'KPT'  => 'Biro Keputrian',
            'PE'   => 'Bidang Pengembangan Ekonomi',
            'KDR'  => 'Bidang Kaderisasi',
            'SYR'  => 'Bidang Syiar',
            'PABK' => 'Bidang Pengembangan, Akademik, Bakat dan Keilmuan',
            'HUM'  => 'Bidang Humas',
            'MED'  => 'Bidang Media Center',
            'PSU'  => 'Bidang PSU',
            'SQC'  => 'Bidang SQC (Syahid Qur\'an Center)',
            'RMSC' => 'Bidang Remaja Masjid Student Center',
        ],
        'LDK Syahid Fakultas (LDKSF)' => [
            'LDKS.FST'      => 'LDKS Fakultas Sains dan Teknologi',
            'LDKS.FDIKOM'   => 'LDKS Fakultas Dakwah dan Ilmu Komunikasi',
            'LDKS.FU'       => 'LDKS Fakultas Ushuluddin',
            'LDKS.FSH'      => 'LDKS Fakultas Syariah dan Hukum',
            'LDKS.FAH'      => 'LDKS Fakultas Adab dan Humaniora',
            'LDKS.FITK'     => 'LDKS Fakultas Ilmu Tarbiyah dan Keguruan',
            'LDKS.FDI'      => 'LDKS Fakultas Dirasat Islamiyah',
            'LDKS.FPsi'     => 'LDKS Fakultas Psikologi',
            'LDKS.FISIP'    => 'LDKS Ilmu Sosial dan Politik',
            'LDKS.FIKES-FK' => 'LDKS Fakultas Kedokteran dan Ilmu Kesehatan',
        ],
    ];

    public const CATEGORIES = [
        'all'      => ['label' => 'Semua (23)',            'icon' => 'fa-th-large'],
        'pusat'    => ['label' => 'Pengurus Pusat (13)',   'icon' => 'fa-landmark'],
        'fakultas' => ['label' => 'LDKS Fakultas (10)',    'icon' => 'fa-graduation-cap'],
    ];

    public const ITEMS = [
        // ── Pengurus Pusat (13) ──
        'BPH' => [
            'code'     => 'BPH',
            'name'     => 'BPH (Badan Pengurus Harian)',
            'group'    => 'pusat',
            'badge'    => 'Pusat',
            'icon'     => 'fa-crown',
            'desc'     => 'Pimpinan harian UKM LDK Syahid UIN Jakarta',
        ],
        'KST' => [
            'code'     => 'KST',
            'name'     => 'Biro Kesekretariatan',
            'group'    => 'pusat',
            'badge'    => 'Biro',
            'icon'     => 'fa-file-signature',
            'desc'     => 'Pengelolaan administrasi & persuratan organisasi',
        ],
        'KEU' => [
            'code'     => 'KEU',
            'name'     => 'Biro Keuangan',
            'group'    => 'pusat',
            'badge'    => 'Biro',
            'icon'     => 'fa-coins',
            'desc'     => 'Pengelolaan anggaran & kas keuangan pusat',
        ],
        'KPT' => [
            'code'     => 'KPT',
            'name'     => 'Biro Keputrian',
            'group'    => 'pusat',
            'badge'    => 'Biro',
            'icon'     => 'fa-female',
            'desc'     => 'Pemberdayaan dan pembinaan kader akhwat',
        ],
        'PE' => [
            'code'     => 'PE',
            'name'     => 'Bidang Pengembangan Ekonomi',
            'group'    => 'pusat',
            'badge'    => 'Bidang',
            'icon'     => 'fa-chart-line',
            'desc'     => 'Kewirausahaan dan kemandirian finansial dakwah',
        ],
        'KDR' => [
            'code'     => 'KDR',
            'name'     => 'Bidang Kaderisasi',
            'group'    => 'pusat',
            'badge'    => 'Bidang',
            'icon'     => 'fa-user-graduate',
            'desc'     => 'Rekrutmen, pelatihan, dan pembinaan kader',
        ],
        'SYR' => [
            'code'     => 'SYR',
            'name'     => 'Bidang Syiar',
            'group'    => 'pusat',
            'badge'    => 'Bidang',
            'icon'     => 'fa-bullhorn',
            'desc'     => 'Syiar dakwah Islamiah & kajian umum kampus',
        ],
        'PABK' => [
            'code'     => 'PABK',
            'name'     => 'Bidang Pengembangan, Akademik, Bakat dan Keilmuan',
            'group'    => 'pusat',
            'badge'    => 'Bidang',
            'icon'     => 'fa-brain',
            'desc'     => 'Pengembangan potensi intelektual & bakat mahasiswa',
        ],
        'HUM' => [
            'code'     => 'HUM',
            'name'     => 'Bidang Humas',
            'group'    => 'pusat',
            'badge'    => 'Bidang',
            'icon'     => 'fa-comments',
            'desc'     => 'Hubungan masyarakat, relasi eksternal & jaringan',
        ],
        'MED' => [
            'code'     => 'MED',
            'name'     => 'Bidang Media Center',
            'group'    => 'pusat',
            'badge'    => 'Bidang',
            'icon'     => 'fa-photo-video',
            'desc'     => 'Publikasi digital, desain grafis & multimedia',
        ],
        'PSU' => [
            'code'     => 'PSU',
            'name'     => 'Bidang PSU',
            'group'    => 'pusat',
            'badge'    => 'Bidang',
            'icon'     => 'fa-handshake',
            'desc'     => 'Pelayanan sosial dan pengabdian umat',
        ],
        'SQC' => [
            'code'     => 'SQC',
            'name'     => 'Bidang SQC (Syahid Qur\'an Center)',
            'group'    => 'pusat',
            'badge'    => 'Bidang',
            'icon'     => 'fa-quran',
            'desc'     => 'Pembelajaran tahsin, tahfidz & kajian Al-Qur\'an',
        ],
        'RMSC' => [
            'code'     => 'RMSC',
            'name'     => 'Bidang Remaja Masjid Student Center',
            'group'    => 'pusat',
            'badge'    => 'Bidang',
            'icon'     => 'fa-mosque',
            'desc'     => 'Kemakmuran musholla & masjid Student Center',
        ],

        // ── LDKS Fakultas (10) ──
        'LDKS.FST' => [
            'code'     => 'LDKS.FST',
            'name'     => 'LDKS Fakultas Sains dan Teknologi',
            'group'    => 'fakultas',
            'badge'    => 'FST',
            'icon'     => 'fa-flask',
            'desc'     => 'Unit dakwah fakultas di lingkungan FST UIN Jakarta',
        ],
        'LDKS.FDIKOM' => [
            'code'     => 'LDKS.FDIKOM',
            'name'     => 'LDKS Fakultas Dakwah dan Ilmu Komunikasi',
            'group'    => 'fakultas',
            'badge'    => 'FDIKOM',
            'icon'     => 'fa-broadcast-tower',
            'desc'     => 'Unit dakwah fakultas di lingkungan FDIKOM UIN Jakarta',
        ],
        'LDKS.FU' => [
            'code'     => 'LDKS.FU',
            'name'     => 'LDKS Fakultas Ushuluddin',
            'group'    => 'fakultas',
            'badge'    => 'FU',
            'icon'     => 'fa-book-open',
            'desc'     => 'Unit dakwah fakultas di lingkungan Ushuluddin',
        ],
        'LDKS.FSH' => [
            'code'     => 'LDKS.FSH',
            'name'     => 'LDKS Fakultas Syariah dan Hukum',
            'group'    => 'fakultas',
            'badge'    => 'FSH',
            'icon'     => 'fa-balance-scale',
            'desc'     => 'Unit dakwah fakultas di lingkungan FSH UIN Jakarta',
        ],
        'LDKS.FAH' => [
            'code'     => 'LDKS.FAH',
            'name'     => 'LDKS Fakultas Adab dan Humaniora',
            'group'    => 'fakultas',
            'badge'    => 'FAH',
            'icon'     => 'fa-feather-alt',
            'desc'     => 'Unit dakwah fakultas di lingkungan FAH UIN Jakarta',
        ],
        'LDKS.FITK' => [
            'code'     => 'LDKS.FITK',
            'name'     => 'LDKS Fakultas Ilmu Tarbiyah dan Keguruan',
            'group'    => 'fakultas',
            'badge'    => 'FITK',
            'icon'     => 'fa-chalkboard-teacher',
            'desc'     => 'Unit dakwah fakultas di lingkungan FITK UIN Jakarta',
        ],
        'LDKS.FDI' => [
            'code'     => 'LDKS.FDI',
            'name'     => 'LDKS Fakultas Dirasat Islamiyah',
            'group'    => 'fakultas',
            'badge'    => 'FDI',
            'icon'     => 'fa-language',
            'desc'     => 'Unit dakwah fakultas di lingkungan FDI UIN Jakarta',
        ],
        'LDKS.FPsi' => [
            'code'     => 'LDKS.FPsi',
            'name'     => 'LDKS Fakultas Psikologi',
            'group'    => 'fakultas',
            'badge'    => 'FPsi',
            'icon'     => 'fa-smile',
            'desc'     => 'Unit dakwah fakultas di lingkungan Psikologi UIN Jakarta',
        ],
        'LDKS.FISIP' => [
            'code'     => 'LDKS.FISIP',
            'name'     => 'LDKS Ilmu Sosial dan Politik',
            'group'    => 'fakultas',
            'badge'    => 'FISIP',
            'icon'     => 'fa-users',
            'desc'     => 'Unit dakwah fakultas di lingkungan FISIP UIN Jakarta',
        ],
        'LDKS.FIKES-FK' => [
            'code'     => 'LDKS.FIKES-FK',
            'name'     => 'LDKS Fakultas Kedokteran dan Ilmu Kesehatan',
            'group'    => 'fakultas',
            'badge'    => 'FK/FIKES',
            'icon'     => 'fa-heartbeat',
            'desc'     => 'Unit dakwah fakultas di lingkungan FIKES & FK UIN Jakarta',
        ],
    ];

    public static function groups(): array
    {
        return self::GROUPS;
    }

    public static function items(): array
    {
        return self::ITEMS;
    }

    public static function categories(): array
    {
        return self::CATEGORIES;
    }

    public static function options(): array
    {
        return array_merge(...array_values(self::GROUPS));
    }

    public static function get(string $code): ?array
    {
        return self::ITEMS[$code] ?? null;
    }

    public static function label(?string $code): string
    {
        if (!$code) {
            return 'Belum diisi';
        }

        return self::ITEMS[$code]['name'] ?? self::options()[$code] ?? $code;
    }
}