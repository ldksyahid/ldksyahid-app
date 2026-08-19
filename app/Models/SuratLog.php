<?php

namespace App\Models;

use App\Services\LetterAssetService;
use App\Services\LetterFormatter;
use App\Services\LetterNumberingService;
use App\Support\DepartmentRegistry;
use App\Support\LetterRegistry;
use Illuminate\Database\Eloquent\Builder;
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

    public const KOP_IMAGE_URL  = LetterAssetService::KOP_IMAGE_URL;
    public const TTD_SEKJEN_URL = LetterAssetService::TTD_SEKJEN_URL;

    protected static function boot()
    {
        parent::boot();

        static::creating(function (SuratLog $log) {
            if (empty($log->kode_verifikasi)) {
                $log->kode_verifikasi = (string) Str::uuid();
            }
        });
    }

    /* ── Relationships ─────────────────────────────────────── */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /* ── Status State Helpers ──────────────────────────────── */
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

    public function isExpired(): bool
    {
        return $this->status === 'expired';
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'expired'  => 'Kadaluarsa',
            default    => 'Menunggu',
        };
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'approved' => 'success',
            'rejected' => 'danger',
            'expired'  => 'secondary',
            default    => 'warning',
        };
    }

    /* ── Department & Activity Helpers ────────────────────── */
    public function kodeBidangPengaju(): ?string
    {
        return $this->data['kode_bidang'] ?? null;
    }

    public function labelBidangPengaju(): string
    {
        return DepartmentRegistry::label($this->kodeBidangPengaju());
    }

    public function isFakultas(): bool
    {
        $code = $this->kodeBidangPengaju();
        if (!$code) {
            return false;
        }

        $item = DepartmentRegistry::get($code);
        if ($item) {
            return ($item['group'] ?? '') === 'fakultas';
        }

        return str_starts_with($code, 'LDKS.');
    }

    public function keperluanKegiatan(): string
    {
        $data = $this->data ?? [];

        return $data['nama_acara']
            ?? $data['nama_kegiatan']
            ?? $data['nama_program']
            ?? $data['program_rekomendasi']
            ?? $data['perihal_imbauan']
            ?? $data['keperluan']
            ?? '-';
    }

    /* ── Query Scopes ──────────────────────────────────────── */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected(Builder $query): Builder
    {
        return $query->where('status', 'rejected');
    }

    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('status', 'expired');
    }

    public function scopeSearchAdmin(Builder $query, Request $request): Builder
    {
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis')) {
            $query->where('jenis_surat', $request->jenis);
        }

        if ($request->filled('q')) {
            $search = '%' . trim($request->q) . '%';
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', $search)
                  ->orWhere('kode_verifikasi', 'like', $search)
                  ->orWhere('label', 'like', $search)
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', $search)
                         ->orWhere('email', 'like', $search);
                  });
            });
        }

        return $query;
    }

    /* ── Admin Management Helpers ──────────────────────────── */
    public static function getTableConfig(): array
    {
        return [
            'idKey'        => 'id',
            'emptyMessage' => 'Belum ada pengajuan surat.',
            'emptyIcon'    => 'fa-file-signature',
            'colspan'      => 7,
        ];
    }

    public static function searchAdminPersuratan(Request $request)
    {
        return self::query()
            ->with('user')
            ->searchAdmin($request)
            ->latest()
            ->paginate(15)
            ->appends($request->query());
    }

    /* ── Approval Execution Proxy ──────────────────────────── */
    public function executeApproval(?string $nomorManual, ?string $catatanAdmin, int $adminId, string $kodeBidang = 'KST'): array
    {
        return app(LetterNumberingService::class)->approve($this, $nomorManual, $catatanAdmin, $adminId, $kodeBidang);
    }

    /* ── Backward-Compatible Delegates ─────────────────────── */
    public static function getSuratTypes(): array
    {
        return LetterRegistry::all();
    }

    public static function getValidationRules(string $type): ?array
    {
        return LetterRegistry::getValidationRules($type);
    }

    public static function getKodeBidangOptions(): array
    {
        return DepartmentRegistry::options();
    }

    public static function getKodeBidangGroups(): array
    {
        return DepartmentRegistry::groups();
    }

    public static function getKodeBidangLabel(?string $kodeBidang): string
    {
        return DepartmentRegistry::label($kodeBidang);
    }

    public static function getKopImageBase64(): ?string
    {
        return LetterAssetService::kopBase64();
    }

    public static function getTtdSekjenBase64(): ?string
    {
        return LetterAssetService::ttdSekjenBase64();
    }

    public static function fetchImageBase64(string $url, string $cacheKey): ?string
    {
        return LetterAssetService::fetchBase64($url, $cacheKey);
    }

    public static function formatWaktu(?string $waktuStr): string
    {
        return LetterFormatter::formatWaktu($waktuStr);
    }

    public static function formatHariTanggal(?string $dateStr): string
    {
        return LetterFormatter::formatHariTanggal($dateStr);
    }
}