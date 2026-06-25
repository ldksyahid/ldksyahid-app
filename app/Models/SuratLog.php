<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SuratLog extends Model
{
    protected $fillable = [
        'user_id',
        'jenis_surat',
        'label',
        'nomor_surat',
        'kode_verifikasi',
        'data',
        'filename',
        'status',
        'catatan_admin',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'data'        => 'array',
        'approved_at' => 'datetime',
    ];

    private const KODE_JENIS = [
        'izin-orang-tua'              => ['kode' => 'Ph',    'sifat' => 'e'],
        'peminjaman-alat'             => ['kode' => 'Ph',    'sifat' => 'e'],
        'peminjaman-tempat-kampus'    => ['kode' => 'Ph',    'sifat' => 'e'],
        'permohonan-bantuan-dana'     => ['kode' => 'Ph',    'sifat' => 'e'],
        'permohonan-izin-luar-kampus' => ['kode' => 'Ph',    'sifat' => 'e'],
        'surat-rekomendasi'           => ['kode' => 'SR',    'sifat' => 'e'],
        'surat-undangan'              => ['kode' => 'Und',   'sifat' => null],
        'surat-aktif-organisasi'      => ['kode' => 'S.Ket', 'sifat' => 'e'],
        'permohonan-pemateri'         => ['kode' => 'Ph',    'sifat' => 'e'],
        'kerja-sama-sponsorship'      => ['kode' => 'Ks',    'sifat' => 'e'],
        'surat-pemberitahuan'         => ['kode' => 'Pb',    'sifat' => 'e'],
    ];

    private const KODE_BIDANG_GROUPS = [
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
            'SQC'  => 'Bidang SQC',
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

    public static function getKodeBidangOptions(): array
    {
        return array_merge(...array_values(self::KODE_BIDANG_GROUPS));
    }

    public static function getKodeBidangGroups(): array
    {
        return self::KODE_BIDANG_GROUPS;
    }

    public static function getKodeBidangLabel(?string $kodeBidang): string
    {
        if (!$kodeBidang) {
            return 'Belum diisi';
        }

        return self::getKodeBidangOptions()[$kodeBidang] ?? $kodeBidang;
    }

    public function kodeBidangPengaju(): ?string
    {
        return $this->data['kode_bidang'] ?? null;
    }

    public function labelBidangPengaju(): string
    {
        return self::getKodeBidangLabel($this->kodeBidangPengaju());
    }

    public static function getTableConfig(): array
    {
        return [
            'idKey' => 'id',
            'emptyMessage' => 'Belum ada pengajuan surat.',
            'emptyIcon' => 'fa-file-signature',
            'colspan' => 7,
        ];
    }

    public static function searchAdminPersuratan(Request $request)
    {
        $query = self::query()->with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis')) {
            $query->where('jenis_surat', $request->jenis);
        }

        return $query
            ->latest()
            ->paginate(15)
            ->appends($request->query());
    }

    private const NOMOR_MANUAL_PATTERN = '/^\d{3}(\.\d{2})?\/[A-Za-z.\-]+-(i|e)\/[A-Za-z.\-]+\/LDK SYAHID\/\d{1,2}\/\d{4}$/';

    protected static function boot()
    {
        parent::boot();

        static::creating(function (SuratLog $log) {
            if (empty($log->kode_verifikasi)) {
                $log->kode_verifikasi = (string) Str::uuid();
            }
        });
    }

    public static function getSuratTypes(): array
    {
        return [
            'izin-orang-tua'              => ['label' => 'Surat Izin Orang Tua', 'fields' => ['kode_bidang', 'nama_acara', 'tema_acara', 'hari_tanggal', 'waktu', 'tempat']],
            'peminjaman-alat'             => ['label' => 'Surat Peminjaman Alat', 'fields' => ['kode_bidang', 'jenis_peminjaman', 'nama_acara', 'tema_acara', 'ditujukan_kepada', 'hari_tanggal', 'waktu', 'tempat', 'daftar_alat']],
            'peminjaman-tempat-kampus'    => ['label' => 'Surat Peminjaman Tempat (Kampus)', 'fields' => ['kode_bidang', 'nama_acara', 'tema_acara', 'nama_ketua_pelaksana', 'nim_ketua_pelaksana', 'ditujukan_kepada', 'hari_tanggal', 'waktu', 'tempat_dipinjam']],
            'permohonan-bantuan-dana'     => ['label' => 'Surat Permohonan Bantuan Dana', 'fields' => ['kode_bidang', 'nama_program', 'ditujukan_kepada', 'keperluan']],
            'permohonan-izin-luar-kampus' => ['label' => 'Surat Permohonan Izin Kegiatan di Luar Kampus', 'fields' => ['kode_bidang', 'nama_acara', 'tema_acara', 'hari_tanggal', 'waktu', 'tempat', 'alamat_tempat']],
            'surat-rekomendasi'           => ['label' => 'Surat Rekomendasi', 'fields' => ['kode_bidang', 'nama', 'nim', 'fakultas', 'jurusan', 'jabatan', 'program_rekomendasi', 'pertimbangan']],
            'surat-undangan'              => ['label' => 'Surat Undangan', 'fields' => ['kode_bidang', 'jenis_undangan', 'nama_acara', 'tema_acara', 'ditujukan_kepada', 'hari_tanggal', 'waktu', 'tempat']],
            'surat-aktif-organisasi'      => ['label' => 'Surat Keterangan Aktif Organisasi', 'fields' => ['kode_bidang', 'nama', 'ttl', 'nim', 'fakultas', 'jurusan', 'jabatan', 'keperluan', 'penyelenggara']],
            'permohonan-pemateri'         => ['label' => 'Surat Permohonan Pemateri / Narasumber', 'fields' => ['kode_bidang', 'nama_acara', 'tema_acara', 'ditujukan_kepada', 'hari_tanggal', 'waktu', 'tempat', 'materi']],
            'kerja-sama-sponsorship'      => ['label' => 'Surat Kerja Sama / Sponsorship', 'fields' => ['kode_bidang', 'nama_acara', 'tema_acara', 'ditujukan_kepada', 'bentuk_kerjasama']],
            'surat-pemberitahuan'         => ['label' => 'Surat Pemberitahuan', 'fields' => ['kode_bidang', 'nama_kegiatan', 'ditujukan_kepada', 'hari_tanggal', 'waktu', 'tempat']],
        ];
    }

    public static function getValidationRules(string $type): ?array
    {
        $types = self::getSuratTypes();
        if (!isset($types[$type])) return null;

        $rules = ['jenis_surat' => 'required|string'];

        foreach ($types[$type]['fields'] as $field) {
            if ($field === 'kode_bidang') {
                $rules[$field] = 'required|string|max:20';
            } elseif ($field === 'nim_ketua_pelaksana') {
                $rules[$field] = 'required|string|max:30|regex:/^[0-9]+$/';
            } elseif (in_array($field, ['jenis_undangan', 'jenis_peminjaman'])) {
                $rules[$field] = 'required|in:internal,eksternal';
            } elseif (in_array($field, ['hari_tanggal', 'tanggal_mulai', 'tanggal_selesai'])) {
                $rules[$field] = 'required|date';
            } elseif (in_array($field, ['daftar_alat', 'keperluan', 'pertimbangan', 'bentuk_kerjasama', 'materi'])) {
                $rules[$field] = 'required|string|max:1000';
            } else {
                $rules[$field] = 'required|string|max:255';
            }
        }

        return $rules;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default    => 'Menunggu',
        };
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'approved' => 'success',
            'rejected' => 'danger',
            default    => 'warning',
        };
    }

    public function executeApproval(?string $nomorManual, ?string $catatanAdmin, int $adminId, string $kodeBidang = 'KST'): array
    {
        if ($nomorManual) {
            if (!str_contains($nomorManual, '/')) {
                $kodeJenis = $this->resolveKodeJenis();
                $sifat     = $this->resolveSifat();
                $bulan     = now()->month;
                $tahun     = now()->year;

                $nomorManual = "{$nomorManual}/{$kodeJenis}-{$sifat}/{$kodeBidang}/LDK SYAHID/{$bulan}/{$tahun}";
            }

            if (!preg_match(self::NOMOR_MANUAL_PATTERN, $nomorManual)) {
                return ['success' => false, 'error' => 'format'];
            }

            $parsed = $this->parseManualNomor($nomorManual);

            $synced = NomorSuratCounter::syncManualNomor(
                $parsed['tahun'],
                $parsed['urut'],
                $parsed['sub'],
                now()
            );

            if (!$synced) {
                return ['success' => false, 'error' => 'mundur'];
            }

            $nomor = $nomorManual;
        } else {
            $nomor = $this->generateNomorSurat($kodeBidang);
        }

        $this->update([
            'status'        => 'approved',
            'nomor_surat'   => $nomor,
            'catatan_admin' => $catatanAdmin,
            'approved_by'   => $adminId,
            'approved_at'   => now(),
            'filename'      => $this->buildFilename($nomor),
        ]);

        return ['success' => true, 'error' => null];
    }

    private function generateNomorSurat(string $kodeBidang): string
    {
        $now   = now();
        $tahun = $now->year;
        $bulan = $now->month;

        $nomor = NomorSuratCounter::nextNomor($tahun, $now);

        $urut     = $nomor['urut'];
        $subNomor = $nomor['sub'];

        $kodeJenis = $this->resolveKodeJenis();
        $sifat     = $this->resolveSifat();

        return "{$urut}{$subNomor}/{$kodeJenis}-{$sifat}/{$kodeBidang}/LDK SYAHID/{$bulan}/{$tahun}";
    }

    private function resolveKodeJenis(): string
    {
        return self::KODE_JENIS[$this->jenis_surat]['kode'] ?? 'Ph';
    }

    private function resolveSifat(): string
    {
        $map = self::KODE_JENIS[$this->jenis_surat] ?? null;

        if (!$map) {
            return 'e';
        }

        if ($map['sifat'] === null) {
            $jenis = $this->data['jenis_undangan'] ?? 'eksternal';
            return $jenis === 'internal' ? 'i' : 'e';
        }

        return $map['sifat'];
    }

    private function parseManualNomor(string $nomor): array
    {
        $segments = explode('/', $nomor);
        $urutPart = $segments[0];
        $tahun    = (int) end($segments);

        if (str_contains($urutPart, '.')) {
            [$urut, $sub] = explode('.', $urutPart, 2);
        } else {
            $urut = $urutPart;
            $sub  = null;
        }

        return [
            'urut'  => (int) $urut,
            'sub'   => $sub !== null ? (int) $sub : null,
            'tahun' => $tahun,
        ];
    }

    private function buildFilename(string $nomor): string
    {
        $safe = str_replace(['/', ' '], ['_', '-'], $nomor);
        return $safe . '.pdf';
    }
}
