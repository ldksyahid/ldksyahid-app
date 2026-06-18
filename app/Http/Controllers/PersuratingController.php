<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\SuratCounter;
use App\Models\SuratLog;

class PersuratingController extends Controller
{
    /**
     * Daftar jenis surat yang dilayani.
     * Sudah disesuaikan dengan SOP & Buku Pedoman Kestari.
     */
    private array $suratTypes = [
        'izin-orang-tua' => [
            'label'  => 'Surat Izin Orang Tua',
            'fields' => ['nama_acara', 'tema_acara', 'hari_tanggal', 'waktu', 'tempat'],
        ],
        'peminjaman-alat' => [
            'label'  => 'Surat Peminjaman Alat',
            'fields' => ['jenis_peminjaman', 'nama_acara', 'tema_acara', 'ditujukan_kepada', 'hari_tanggal', 'waktu', 'tempat', 'daftar_alat'],
        ],
        'peminjaman-tempat-kampus' => [
            'label'  => 'Surat Peminjaman Tempat (Kampus)',
            'fields' => ['nama_acara', 'tema_acara', 'ditujukan_kepada', 'hari_tanggal', 'waktu', 'tempat_dipinjam'],
        ],
        'permohonan-bantuan-dana' => [
            'label'  => 'Surat Permohonan Bantuan Dana',
            'fields' => ['nama_program', 'ditujukan_kepada', 'keperluan'],
        ],
        'permohonan-izin-luar-kampus' => [
            'label'  => 'Surat Permohonan Izin Kegiatan di Luar Kampus',
            'fields' => ['nama_acara', 'tema_acara', 'hari_tanggal', 'waktu', 'tempat', 'alamat_tempat'],
        ],
        'surat-rekomendasi' => [
            'label'  => 'Surat Rekomendasi',
            'fields' => ['nama', 'nim', 'fakultas', 'jurusan', 'jabatan', 'program_rekomendasi', 'pertimbangan'],
        ],
        'surat-undangan' => [
            'label'  => 'Surat Undangan',
            'fields' => ['jenis_undangan', 'nama_acara', 'tema_acara', 'ditujukan_kepada', 'hari_tanggal', 'waktu', 'tempat'],
        ],
        'surat-aktif-organisasi' => [
            'label'  => 'Surat Keterangan Aktif Organisasi',
            'fields' => ['nama', 'ttl', 'nim', 'fakultas', 'jurusan', 'jabatan', 'keperluan', 'penyelenggara'],
        ],
        'permohonan-pemateri' => [
            'label'  => 'Surat Permohonan Pemateri / Narasumber',
            'fields' => ['nama_acara', 'tema_acara', 'ditujukan_kepada', 'hari_tanggal', 'waktu', 'tempat', 'materi'],
        ],
        'kerja-sama-sponsorship' => [
            'label'  => 'Surat Kerja Sama / Sponsorship',
            'fields' => ['nama_acara', 'tema_acara', 'ditujukan_kepada', 'bentuk_kerjasama'],
        ],
        'surat-pemberitahuan' => [
            'label'  => 'Surat Pemberitahuan',
            'fields' => ['nama_kegiatan', 'ditujukan_kepada', 'hari_tanggal', 'waktu', 'tempat'],
        ],
    ];

    /**
     * Mapping prefix nomor surat — dipakai untuk generate & parsing.
     * Beberapa memiliki akhiran -i (Internal) atau -e (Eksternal).
     */
    private array $prefixMap = [
        'izin-orang-tua'              => 'Ph-e',
        'peminjaman-alat'             => 'Ph', // Di-generate dinamis
        'peminjaman-tempat-kampus'    => 'Ph-e',
        'permohonan-bantuan-dana'     => 'Ph-e',
        'permohonan-izin-luar-kampus' => 'Ph-e',
        'surat-rekomendasi'           => 'SR-e',
        'surat-undangan'              => 'Und', // Di-generate dinamis
        'surat-aktif-organisasi'      => 'S.Ket-i',
        'permohonan-pemateri'         => 'Ph-e',
        'kerja-sama-sponsorship'      => 'Ks-e',
        'surat-pemberitahuan'         => 'Pb-e',
    ];

    private array $romanMonth = [
        1 => 'I',   2 => 'II',  3 => 'III', 4 => 'IV',
        5 => 'V',   6 => 'VI',  7 => 'VII', 8 => 'VIII',
        9 => 'IX', 10 => 'X',  11 => 'XI', 12 => 'XII',
    ];

    /* ══════════════════════════════════════════
       LANDING — User
    ══════════════════════════════════════════ */

    /**
     * Form pengajuan surat (semua user login bisa akses).
     */
    public function index()
    {
        $riwayat = auth()->check()
            ? SuratLog::where('user_id', auth()->id())
                ->latest()
                ->take(5)
                ->get()
            : collect();

        return view('landing-page.service.persuratan.index', [
            'title'      => 'Layanan Persuratan',
            'suratTypes' => $this->suratTypes,
            'riwayat'    => $riwayat,
        ]);
    }

    /**
     * Simpan pengajuan surat sebagai PENDING — belum generate PDF.
     */
    public function submit(Request $request)
    {
        $jenis = $request->input('jenis_surat');

        if (!array_key_exists($jenis, $this->suratTypes)) {
            return back()->withErrors(['jenis_surat' => 'Jenis surat tidak valid.'])->withInput();
        }

        $suratConfig = $this->suratTypes[$jenis];
        $rules       = $this->buildValidationRules($jenis, $suratConfig['fields']);
        $validated   = $request->validate($rules);

        SuratLog::create([
            'user_id'         => auth()->id(),
            'jenis_surat'     => $jenis,
            'label'           => $suratConfig['label'],
            'nomor_surat'     => '-',
            'data'            => $validated,
            'filename'        => '',
            'status'          => 'pending',
            'kode_verifikasi' => Str::uuid()->toString(), // Auto-generate UUID
        ]);

        return back()->with('success', 'Pengajuan surat berhasil dikirim! Silakan tunggu konfirmasi dari admin.');
    }

    /**
     * Riwayat surat milik user yang sedang login.
     */
    public function riwayat()
    {
        $riwayat = SuratLog::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('landing-page.service.persuratan.riwayat', [
            'title'   => 'Riwayat Surat Saya',
            'riwayat' => $riwayat,
        ]);
    }

    /**
     * Download PDF surat milik sendiri (hanya jika sudah approved).
     */
    public function download(SuratLog $suratLog)
    {
        abort_if($suratLog->user_id !== auth()->id(), 403);
        abort_if(!$suratLog->isApproved(), 403, 'Surat belum disetujui.');

        return $this->streamPdf($suratLog);
    }

    /**
     * Halaman publik verifikasi keaslian surat.
     */
    public function verifikasi(string $kode)
    {
        $suratLog = SuratLog::where('kode_verifikasi', $kode)->first();

        return view('landing-page.service.persuratan.verifikasi', [
            'title'    => 'Verifikasi Surat',
            'suratLog' => $suratLog,
            'kode'     => $kode,
        ]);
    }

    /* ══════════════════════════════════════════
       ADMIN — HelperLetter | Superadmin
    ══════════════════════════════════════════ */

    /**
     * Daftar semua pengajuan surat di admin.
     */
    public function indexAdmin(Request $request)
    {
        $query = SuratLog::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis')) {
            $query->where('jenis_surat', $request->jenis);
        }

        $suratLogs = $query->paginate(20)->withQueryString();

        return view('admin-page.service-request.persuratan.index', [
            'title'      => 'Manajemen Persuratan',
            'suratLogs'  => $suratLogs,
            'suratTypes' => $this->suratTypes,
        ]);
    }

    /**
     * Detail pengajuan surat di admin.
     */
    public function showAdmin(SuratLog $suratLog)
    {
        // Cari nomor terakhir yang diterbitkan untuk jenis surat yang sama
        $lastSurat = SuratLog::where('jenis_surat', $suratLog->jenis_surat)
            ->where('status', 'approved')
            ->latest('approved_at')
            ->first();

        $lastNomor = $lastSurat ? $lastSurat->nomor_surat : null;

        return view('admin-page.service-request.persuratan.show', [
            'title'     => 'Detail Pengajuan Surat',
            'suratLog'  => $suratLog->load('user', 'approvedBy'),
            'lastNomor' => $lastNomor,
        ]);
    }

    /**
     * Approve pengajuan — generate nomor otomatis/manual dan terbitkan surat.
     */
    public function approve(Request $request, SuratLog $suratLog)
    {
        abort_if(!$suratLog->isPending(), 422, 'Surat sudah diproses sebelumnya.');

        $request->validate([
            'catatan_admin'      => 'nullable|string|max:500',
            'nomor_surat_manual' => 'nullable|string|max:100',
        ]);

        $nomorManual = trim((string) $request->input('nomor_surat_manual'));

        if ($nomorManual !== '') {
            $parsed = $this->parseNomorSurat($nomorManual, $suratLog->jenis_surat);

            if (!$parsed) {
                return back()
                    ->withErrors(['nomor_surat_manual' => 'Format nomor surat tidak valid. Contoh: 005.1/SR-e/KST/LDK-SYAHID/VI/2026'])
                    ->withInput();
            }
        }

        DB::transaction(function () use ($request, $suratLog, $nomorManual) {
            if ($nomorManual !== '') {
                $parsed     = $this->parseNomorSurat($nomorManual, $suratLog->jenis_surat);
                $nomorSurat = $parsed['nomor_surat'];

                $this->syncCounter($suratLog->jenis_surat, $parsed['periode'], $parsed['urutan']);
            } else {
                $nomorSurat = $this->generateNomorSurat($suratLog);
            }

            $filename = $suratLog->jenis_surat . '_' . now()->format('Ymd_His') . '.pdf';

            $suratLog->update([
                'nomor_surat'   => $nomorSurat,
                'filename'      => $filename,
                'status'        => 'approved',
                'catatan_admin' => $request->catatan_admin,
                'approved_by'   => auth()->id(),
                'approved_at'   => now(),
            ]);
        });

        return redirect()
            ->route('admin.persuratan.show', $suratLog)
            ->with('success', 'Surat berhasil disetujui dan nomor surat telah diterbitkan.');
    }

    /**
     * Tolak pengajuan surat.
     */
    public function reject(Request $request, SuratLog $suratLog)
    {
        abort_if(!$suratLog->isPending(), 422, 'Surat sudah diproses sebelumnya.');

        $request->validate([
            'catatan_admin' => 'required|string|max:500',
        ]);

        $suratLog->update([
            'status'        => 'rejected',
            'catatan_admin' => $request->catatan_admin,
            'approved_by'   => auth()->id(),
            'approved_at'   => now(),
        ]);

        return redirect()
            ->route('admin.persuratan.index')
            ->with('success', 'Pengajuan surat telah ditolak.');
    }

    /**
     * Admin download PDF surat yang sudah approved.
     */
    public function downloadAdmin(SuratLog $suratLog)
    {
        abort_if(!$suratLog->isApproved(), 422, 'Surat belum disetujui.');

        return $this->streamPdf($suratLog);
    }

    /**
     * Hapus pengajuan surat (Superadmin only).
     */
    public function destroy(SuratLog $suratLog)
    {
        $suratLog->delete();

        return redirect()
            ->route('admin.persuratan.index')
            ->with('success', 'Data pengajuan surat berhasil dihapus.');
    }

    /* ══════════════════════════════════════════
       PRIVATE HELPERS
    ══════════════════════════════════════════ */

    /**
     * Stream PDF ke browser (download).
     */
    private function streamPdf(SuratLog $suratLog)
    {
        $tanggalSurat = $suratLog->approved_at
            ? $suratLog->approved_at->locale('id')->translatedFormat('d F Y')
            : now()->locale('id')->translatedFormat('d F Y');

        $verifikasiUrl = route('persuratan.verifikasi', ['kode' => $suratLog->kode_verifikasi]);
        
        // Trik QR Base64 SVG agar tidak error butuh ekstensi Imagick di Windows/XAMPP
        $qrSvg  = QrCode::size(120)->margin(0)->generate($verifikasiUrl);
        $qrCode = 'data:image/svg+xml;base64,' . base64_encode((string) $qrSvg);

        $pdfView = View::exists('pdf.' . $suratLog->jenis_surat)
            ? 'pdf.' . $suratLog->jenis_surat
            : 'pdf.surat';

        $pdf = Pdf::loadView($pdfView, [
            'data'           => $suratLog->data,
            'nomorSurat'     => $suratLog->nomor_surat,
            'tanggalSurat'   => $tanggalSurat,
            'label'          => $suratLog->label,
            'user'           => $suratLog->user,
            'kodeVerifikasi' => $suratLog->kode_verifikasi,
            'verifikasiUrl'  => $verifikasiUrl,
            'qrCode'         => $qrCode, // String SVG Base64 untuk tag <img>
        ])->setPaper('a4', 'portrait');

        return $pdf->download($suratLog->filename ?: $suratLog->jenis_surat . '.pdf');
    }

    /**
     * Build dynamic validation rules.
     */
    private function buildValidationRules(string $jenis, array $fields): array
    {
        $dateFields     = ['hari_tanggal', 'tanggal_mulai', 'tanggal_selesai'];
        $textareaFields = ['daftar_alat', 'keperluan', 'pertimbangan', 'bentuk_kerjasama', 'materi'];

        $rules = ['jenis_surat' => 'required|string'];

        foreach ($fields as $field) {
            if ($field === 'jenis_undangan' || $field === 'jenis_peminjaman') {
                $rules[$field] = 'required|in:internal,eksternal';
            } elseif (in_array($field, $dateFields)) {
                $rules[$field] = 'required|date';
            } elseif (in_array($field, $textareaFields)) {
                $rules[$field] = 'required|string|max:1000';
            } else {
                $rules[$field] = 'required|string|max:255';
            }
        }

        return $rules;
    }

    /**
     * Generate nomor otomatis sesuai Pedoman Kesekretariatan LDK Syahid.
     */
    private function generateNomorSurat(SuratLog $suratLog): string
    {
        $jenis   = $suratLog->jenis_surat;
        $periode = now()->format('Ym');
        $counter = $this->incrementCounter($jenis, $periode);

        $prefix = $this->prefixMap[$jenis] ?? 'XX';

        // Deteksi sifat Internal/Eksternal dari isian form untuk prefix dinamis
        if ($jenis === 'surat-undangan') {
            $isInternal = ($suratLog->data['jenis_undangan'] ?? 'eksternal') === 'internal';
            $prefix     = $isInternal ? 'Und-i' : 'Und-e';
        } elseif ($jenis === 'peminjaman-alat') {
            $isInternal = ($suratLog->data['jenis_peminjaman'] ?? 'eksternal') === 'internal';
            $prefix     = $isInternal ? 'Ph-i' : 'Ph-e';
        }

        $nomor = str_pad($counter, 3, '0', STR_PAD_LEFT);
        $bulan = $this->romanMonth[now()->month];
        $tahun = now()->year;

        // Nomor/Prefix/Biro(KST)/Organisasi/Bulan/Tahun
        return "{$nomor}/{$prefix}/KST/LDK-SYAHID/{$bulan}/{$tahun}";
    }

    /**
     * Increment & return counter terbaru.
     */
    private function incrementCounter(string $jenis, string $periode): int
    {
        $counter = SuratCounter::where('jenis_surat', $jenis)
            ->where('periode', $periode)
            ->lockForUpdate()
            ->first();

        if (!$counter) {
            $counter = SuratCounter::create([
                'jenis_surat' => $jenis,
                'periode'     => $periode,
                'counter'     => 0,
            ]);
        }

        $counter->increment('counter');
        $counter->refresh();

        return (int) $counter->counter;
    }

    /**
     * Sinkronkan counter ke nilai tertentu.
     */
    private function syncCounter(string $jenis, string $periode, int $urutan): void
    {
        $counter = SuratCounter::where('jenis_surat', $jenis)
            ->where('periode', $periode)
            ->lockForUpdate()
            ->first();

        if (!$counter) {
            SuratCounter::create([
                'jenis_surat' => $jenis,
                'periode'     => $periode,
                'counter'     => $urutan,
            ]);
            return;
        }

        if ($urutan > $counter->counter) {
            $counter->update(['counter' => $urutan]);
        }
    }

    /**
     * Parse & validasi nomor surat manual.
     * Mengizinkan keberadaan sub-surat (misal: 005.01)
     * Mengizinkan kode biro KST sesuai pedoman.
     */
    private function parseNomorSurat(string $nomor, string $jenis): ?array
    {
        $expectedPrefix = $this->prefixMap[$jenis] ?? null;
        
        // Dinamis prefix untuk parse manual (Agar admin tidak dibatasi jika ada perubahan)
        if ($jenis === 'surat-undangan' || $jenis === 'peminjaman-alat') {
            $expectedPrefix = null; // Lewati pengecekan strict karena bisa Und-i/Und-e
        }

        // Match: XXX/PREFIX/KST/LDK-SYAHID/BULAN/TAHUN atau XXX.YYY/PREFIX/KST/...
        $pattern = '/^(\d{1,4})(?:\.(\d{1,4}))?\/([A-Za-z\-]+)\/KST\/LDK-SYAHID\/([IVXLCDM]+)\/(\d{4})$/i';

        if (!preg_match($pattern, $nomor, $m)) {
            return null;
        }

        $urutanStr   = $m[1];
        $subStr      = $m[2] ?? '';
        $prefix      = $m[3];
        $bulanRomawi = $m[4];
        $tahun       = $m[5];

        if ($expectedPrefix && strcasecmp($prefix, $expectedPrefix) !== 0) {
            return null;
        }

        $bulanNumber = array_search(strtoupper($bulanRomawi), array_map('strtoupper', $this->romanMonth), true);

        if ($bulanNumber === false) {
            return null;
        }

        $urutan  = (int) $urutanStr;
        $periode = $tahun . str_pad((string) $bulanNumber, 2, '0', STR_PAD_LEFT);

        $nomorNormalized = str_pad((string) $urutan, 3, '0', STR_PAD_LEFT);
        if ($subStr !== '') {
            $nomorNormalized .= '.' . $subStr;
        }
        
        $nomorNormalized .= '/' . strtoupper($prefix)
            . '/KST/LDK-SYAHID/' . $this->romanMonth[$bulanNumber]
            . '/' . $tahun;

        return [
            'nomor_surat' => $nomorNormalized,
            'periode'     => $periode,
            'urutan'      => $urutan,
        ];
    }
}