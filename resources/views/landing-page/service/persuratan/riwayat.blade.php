@extends('landing-page.template.body')

@section('title', $title)

@section('content')

@php
    $totalSurat    = $totalSurat ?? $riwayat->total();
    $pendingCount  = $pendingCount ?? $riwayat->getCollection()->where('status', 'pending')->count();
    $approvedCount = $approvedCount ?? $riwayat->getCollection()->where('status', 'approved')->count();
    $rejectedCount = $rejectedCount ?? $riwayat->getCollection()->where('status', 'rejected')->count();
    $expiredCount  = $expiredCount ?? $riwayat->getCollection()->where('status', 'expired')->count();
@endphp

<section id="persuratan-riwayat-section">
    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-10">

                <div class="pr-header">
                    <div>
                        <span class="pr-eyebrow">
                            <i class="fas fa-folder-open"></i>
                            Layanan Persuratan
                        </span>
                        <h2>Riwayat Surat Saya</h2>
                        <p>Monitor status pengajuan, nomor surat, catatan admin, dan unduh PDF saat surat sudah disetujui.</p>
                    </div>
                    <a href="{{ route('service.persuratan.index') }}" class="btn btn-primary pr-header-action">
                        <i class="fas fa-plus"></i>
                        Ajukan Baru
                    </a>
                </div>

                <div class="pr-stats">
                    <div class="pr-stat">
                        <span class="pr-stat-icon total"><i class="fas fa-file-alt"></i></span>
                        <div>
                            <strong>{{ $totalSurat }}</strong>
                            <span>Total</span>
                        </div>
                    </div>
                    <div class="pr-stat">
                        <span class="pr-stat-icon pending"><i class="fas fa-clock"></i></span>
                        <div>
                            <strong>{{ $pendingCount }}</strong>
                            <span>Menunggu</span>
                        </div>
                    </div>
                    <div class="pr-stat">
                        <span class="pr-stat-icon approved"><i class="fas fa-check"></i></span>
                        <div>
                            <strong>{{ $approvedCount }}</strong>
                            <span>Disetujui</span>
                        </div>
                    </div>
                    <div class="pr-stat">
                        <span class="pr-stat-icon rejected"><i class="fas fa-times"></i></span>
                        <div>
                            <strong>{{ $rejectedCount }}</strong>
                            <span>Ditolak</span>
                        </div>
                    </div>
                    <div class="pr-stat">
                        <span class="pr-stat-icon expired"><i class="fas fa-hourglass-end"></i></span>
                        <div>
                            <strong>{{ $expiredCount }}</strong>
                            <span>Kadaluarsa</span>
                        </div>
                    </div>
                </div>

                @if ($riwayat->isEmpty())
                    <div class="pr-empty">
                        <span><i class="fas fa-file-circle-plus"></i></span>
                        <h5>Belum ada pengajuan surat</h5>
                        <p>Mulai ajukan surat resmi LDK Syahid, lalu statusnya akan tampil di halaman ini.</p>
                        <a href="{{ route('service.persuratan.index') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>
                            Ajukan Sekarang
                        </a>
                    </div>
                @else
                    <div class="pr-list">
                        @foreach ($riwayat as $log)
                            <article class="pr-item">
                                <div class="pr-item-marker bg-{{ $log->statusBadgeClass() }}">
                                    @if ($log->isApproved())
                                        <i class="fas fa-check"></i>
                                    @elseif ($log->isRejected())
                                        <i class="fas fa-times"></i>
                                    @elseif ($log->isExpired())
                                        <i class="fas fa-hourglass-end"></i>
                                    @else
                                        <i class="fas fa-clock"></i>
                                    @endif
                                </div>

                                <div class="pr-item-body">
                                    <div class="pr-item-main">
                                        <div>
                                            <div class="pr-item-title">{{ $log->label }}</div>
                                            <div class="pr-item-meta">
                                                <span>
                                                    <i class="fas fa-calendar-alt"></i>
                                                    {{ $log->created_at->locale('id')->translatedFormat('d F Y, H:i') }} WIB
                                                </span>
                                                @if ($log->nomor_surat !== '-')
                                                    <span>
                                                        <i class="fas fa-hashtag"></i>
                                                        {{ $log->nomor_surat }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="pr-item-actions d-flex align-items-center gap-2">
                                            <span class="pr-status bg-{{ $log->statusBadgeClass() }}">
                                                {{ $log->statusLabel() }}
                                            </span>
                                            @if ($log->isApproved())
                                                <a href="{{ route('service.persuratan.download', $log) }}" class="btn btn-sm btn-success">
                                                    <i class="fas fa-download"></i>
                                                    PDF
                                                </a>
                                            @elseif ($log->isExpired() || $log->isRejected())
                                                <a href="{{ route('service.persuratan.index', ['reapply' => $log->id]) }}"
                                                   class="btn btn-sm btn-outline-primary"
                                                   title="Ajukan Ulang dengan data sebelumnya">
                                                    <i class="fas fa-redo-alt me-1"></i>
                                                    Ajukan Ulang
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    @if ($log->catatan_admin)
                                        <div class="pr-note {{ $log->isRejected() || $log->isExpired() ? 'is-rejected' : 'is-approved' }}">
                                            <i class="fas fa-comment-alt"></i>
                                            <div>
                                                <strong>Catatan:</strong>
                                                <span>{{ $log->catatan_admin }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="pr-pagination">
                        {{ $riwayat->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</section>

<style>
#persuratan-riwayat-section {
    padding: 6.5rem 0 5rem;
    min-height: 100vh;
    background: transparent;
}
@media (max-width: 767.98px) {
    #persuratan-riwayat-section {
        padding: 5rem 0 3.5rem;
    }
}

#persuratan-riwayat-section .pr-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

#persuratan-riwayat-section .pr-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #0284c7;
    margin-bottom: 0.4rem;
}
[data-theme="dark"] #persuratan-riwayat-section .pr-eyebrow {
    color: #38bdf8;
}

#persuratan-riwayat-section .pr-header h2 {
    font-size: clamp(1.5rem, 4vw, 2rem);
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 0.35rem;
}
[data-theme="dark"] #persuratan-riwayat-section .pr-header h2 {
    color: #f1f5f9;
}

#persuratan-riwayat-section .pr-header p {
    color: #64748b;
    margin: 0;
    font-size: 0.92rem;
    max-width: 600px;
}
[data-theme="dark"] #persuratan-riwayat-section .pr-header p {
    color: #94a3b8;
}

#persuratan-riwayat-section .pr-header-action {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    border-radius: 14px;
    font-weight: 700;
    padding: 0.75rem 1.4rem;
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
    border: none;
    color: #fff;
    box-shadow: 0 4px 14px rgba(14, 165, 233, 0.3);
    white-space: nowrap;
    transition: all 0.25s ease;
}
#persuratan-riwayat-section .pr-header-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(14, 165, 233, 0.4);
    color: #fff;
}

#persuratan-riwayat-section .pr-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

#persuratan-riwayat-section .pr-stat {
    display: flex;
    align-items: center;
    gap: 0.85rem;
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
    padding: 0.95rem 1rem;
    transition: transform 0.2s;
}
[data-theme="dark"] #persuratan-riwayat-section .pr-stat {
    background: #1a1f2e;
    border-color: rgba(255, 255, 255, 0.08);
    box-shadow: 0 4px 16px rgba(0,0,0,0.25);
}

#persuratan-riwayat-section .pr-stat-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 42px;
    height: 42px;
    border-radius: 12px;
    flex-shrink: 0;
    font-size: 1.15rem;
}
#persuratan-riwayat-section .pr-stat-icon.total { background: #e0f2fe; color: #0284c7; }
#persuratan-riwayat-section .pr-stat-icon.pending { background: #fef3c7; color: #d97706; }
#persuratan-riwayat-section .pr-stat-icon.approved { background: #d1fae5; color: #059669; }
#persuratan-riwayat-section .pr-stat-icon.rejected { background: #fee2e2; color: #dc2626; }
#persuratan-riwayat-section .pr-stat-icon.expired { background: #f1f5f9; color: #64748b; }

[data-theme="dark"] #persuratan-riwayat-section .pr-stat-icon.total { background: rgba(14, 165, 233, 0.2); color: #38bdf8; }
[data-theme="dark"] #persuratan-riwayat-section .pr-stat-icon.pending { background: rgba(245, 158, 11, 0.2); color: #fbbf24; }
[data-theme="dark"] #persuratan-riwayat-section .pr-stat-icon.approved { background: rgba(16, 185, 129, 0.2); color: #34d399; }
[data-theme="dark"] #persuratan-riwayat-section .pr-stat-icon.rejected { background: rgba(239, 68, 68, 0.2); color: #f87171; }
[data-theme="dark"] #persuratan-riwayat-section .pr-stat-icon.expired { background: rgba(148, 163, 184, 0.2); color: #94a3b8; }

#persuratan-riwayat-section .pr-stat strong {
    display: block;
    font-size: 1.25rem;
    font-weight: 800;
    color: #0f172a;
    line-height: 1;
}
[data-theme="dark"] #persuratan-riwayat-section .pr-stat strong {
    color: #f8fafc;
}

#persuratan-riwayat-section .pr-stat span:last-child {
    display: block;
    color: #64748b;
    font-size: 0.74rem;
    margin-top: 0.25rem;
}
[data-theme="dark"] #persuratan-riwayat-section .pr-stat span:last-child {
    color: #94a3b8;
}

#persuratan-riwayat-section .pr-list {
    display: flex;
    flex-direction: column;
    gap: 0.95rem;
}

#persuratan-riwayat-section .pr-item {
    display: flex;
    gap: 1.1rem;
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    border-radius: 18px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
    padding: 1.25rem 1.35rem;
    transition: all 0.25s ease;
}
#persuratan-riwayat-section .pr-item:hover {
    border-color: rgba(14, 165, 233, 0.4);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
}
[data-theme="dark"] #persuratan-riwayat-section .pr-item {
    background: #1a1f2e;
    border-color: rgba(255, 255, 255, 0.08);
    box-shadow: 0 6px 20px rgba(0,0,0,0.3);
}
[data-theme="dark"] #persuratan-riwayat-section .pr-item:hover {
    background: #252b3b;
    border-color: rgba(14, 165, 233, 0.4);
}

#persuratan-riwayat-section .pr-item-marker {
    width: 44px;
    height: 44px;
    min-width: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-size: 1.15rem;
    flex-shrink: 0;
}

#persuratan-riwayat-section .pr-item-body {
    flex-grow: 1;
    min-width: 0;
}

#persuratan-riwayat-section .pr-item-title {
    font-size: 1rem;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 0.35rem;
    line-height: 1.35;
}
[data-theme="dark"] #persuratan-riwayat-section .pr-item-title {
    color: #f1f5f9;
}

#persuratan-riwayat-section .pr-item-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem 1rem;
    color: #64748b;
    font-size: 0.8rem;
    margin-bottom: 0.65rem;
}
[data-theme="dark"] #persuratan-riwayat-section .pr-item-meta {
    color: #94a3b8;
}

#persuratan-riwayat-section .pr-item-meta span {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
}

#persuratan-riwayat-section .pr-status {
    display: inline-flex;
    align-items: center;
    padding: 0.3rem 0.75rem;
    border-radius: 50rem;
    font-size: 0.74rem;
    font-weight: 700;
    letter-spacing: 0.02em;
    text-transform: uppercase;
}

#persuratan-riwayat-section .pr-note {
    display: flex;
    gap: 0.65rem;
    margin-top: 0.85rem;
    border-radius: 12px;
    padding: 0.75rem 0.95rem;
    font-size: 0.82rem;
    line-height: 1.5;
}
#persuratan-riwayat-section .pr-note.is-approved {
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
    color: #065f46;
}
#persuratan-riwayat-section .pr-note.is-rejected {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
}
[data-theme="dark"] #persuratan-riwayat-section .pr-note.is-approved {
    background: rgba(16, 185, 129, 0.15);
    border-color: rgba(16, 185, 129, 0.3);
    color: #6ee7b7;
}
[data-theme="dark"] #persuratan-riwayat-section .pr-note.is-rejected {
    background: rgba(239, 68, 68, 0.15);
    border-color: rgba(239, 68, 68, 0.3);
    color: #fca5a5;
}

#persuratan-riwayat-section .pr-empty {
    text-align: center;
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    border-radius: 20px;
    padding: 3rem 1.5rem;
}
[data-theme="dark"] #persuratan-riwayat-section .pr-empty {
    background: #1a1f2e;
    border-color: rgba(255, 255, 255, 0.08);
}
#persuratan-riwayat-section .pr-empty span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 64px;
    height: 64px;
    border-radius: 18px;
    background: rgba(14, 165, 233, 0.1);
    color: #0ea5e9;
    font-size: 1.8rem;
    margin-bottom: 1rem;
}
#persuratan-riwayat-section .pr-empty h5 {
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 0.4rem;
}
[data-theme="dark"] #persuratan-riwayat-section .pr-empty h5 {
    color: #f1f5f9;
}
#persuratan-riwayat-section .pr-empty p {
    color: #64748b;
    max-width: 420px;
    margin: 0 auto 1.25rem;
}
[data-theme="dark"] #persuratan-riwayat-section .pr-empty p {
    color: #94a3b8;
}

[data-theme="dark"] #persuratan-riwayat-section .btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
    border: none !important;
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35) !important;
}
[data-theme="dark"] #persuratan-riwayat-section .btn-outline-primary {
    background: #1e2535 !important;
    border: 1.5px solid rgba(14, 165, 233, 0.4) !important;
    color: #38bdf8 !important;
}
[data-theme="dark"] #persuratan-riwayat-section .btn-outline-primary:hover {
    background: #0ea5e9 !important;
    color: #ffffff !important;
    border-color: #0ea5e9 !important;
}
[data-theme="dark"] #persuratan-riwayat-section .pr-empty .btn-primary {
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%) !important;
    color: #ffffff !important;
    border: none !important;
    box-shadow: 0 6px 20px rgba(14, 165, 233, 0.4) !important;
}
[data-theme="dark"] #persuratan-riwayat-section .pr-header-action {
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%) !important;
    box-shadow: 0 4px 16px rgba(14, 165, 233, 0.4) !important;
}
[data-theme="dark"] .pagination .page-item .page-link {
    background: #1e2535;
    border-color: rgba(255, 255, 255, 0.08);
    color: #cbd5e1;
}
[data-theme="dark"] .pagination .page-item.active .page-link {
    background: #0ea5e9;
    border-color: #0ea5e9;
    color: #ffffff;
}

@media (max-width: 767.98px) {
    #persuratan-riwayat-section .pr-header {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }
    #persuratan-riwayat-section .pr-header-action {
        width: 100%;
        justify-content: center;
    }
    #persuratan-riwayat-section .pr-stats {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
    #persuratan-riwayat-section .pr-item {
        flex-direction: column;
        padding: 1.15rem 1rem;
    }
    #persuratan-riwayat-section .pr-item-actions {
        width: 100%;
        margin-top: 0.5rem;
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
    }
    #persuratan-riwayat-section .pr-item-actions .btn {
        width: 100%;
        justify-content: center;
    }
}
@media (max-width: 420px) {
    #persuratan-riwayat-section .pr-stats {
        grid-template-columns: 1fr;
    }
}
</style>

@endsection
