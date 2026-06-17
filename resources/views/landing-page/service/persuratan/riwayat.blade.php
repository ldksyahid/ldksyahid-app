@extends('landing-page.template.body')

@section('title', $title)

@section('content')

@php
    $totalSurat = $riwayat->total();
    $pendingCount = $riwayat->getCollection()->where('status', 'pending')->count();
    $approvedCount = $riwayat->getCollection()->where('status', 'approved')->count();
    $rejectedCount = $riwayat->getCollection()->where('status', 'rejected')->count();
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
                            <span>Total Pengajuan</span>
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
                                        <div class="pr-item-actions">
                                            <span class="pr-status bg-{{ $log->statusBadgeClass() }}">
                                                {{ $log->statusLabel() }}
                                            </span>
                                            @if ($log->isApproved())
                                                <a href="{{ route('service.persuratan.download', $log) }}" class="btn btn-sm btn-success">
                                                    <i class="fas fa-download"></i>
                                                    PDF
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    @if ($log->catatan_admin)
                                        <div class="pr-note {{ $log->isRejected() ? 'is-rejected' : 'is-approved' }}">
                                            <i class="fas fa-comment-alt"></i>
                                            <div>
                                                <strong>Catatan Admin</strong>
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
    min-height: 82vh;
    background:
        linear-gradient(180deg, rgba(var(--bs-primary-rgb), .06), rgba(255,255,255,0) 260px);
}

#persuratan-riwayat-section .pr-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1rem;
}

#persuratan-riwayat-section .pr-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .45rem .75rem;
    border-radius: 999px;
    background: rgba(var(--bs-primary-rgb), .1);
    color: var(--bs-primary);
    font-size: .78rem;
    font-weight: 700;
    margin-bottom: .85rem;
}

#persuratan-riwayat-section .pr-header h2 {
    font-size: 1.75rem;
    font-weight: 800;
    margin: 0 0 .35rem;
}

#persuratan-riwayat-section .pr-header p {
    color: #6c757d;
    margin: 0;
    max-width: 620px;
}

#persuratan-riwayat-section .pr-header-action {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    border-radius: 12px;
    font-weight: 700;
    white-space: nowrap;
}

#persuratan-riwayat-section .pr-stats {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: .75rem;
    margin-bottom: 1rem;
}

#persuratan-riwayat-section .pr-stat {
    display: flex;
    align-items: center;
    gap: .75rem;
    background: #fff;
    border: 1px solid rgba(15, 23, 42, .06);
    border-radius: 14px;
    box-shadow: 0 8px 24px rgba(15, 23, 42, .06);
    padding: .9rem;
}

#persuratan-riwayat-section .pr-stat-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 12px;
    flex: 0 0 38px;
}

#persuratan-riwayat-section .pr-stat-icon.total { background: rgba(var(--bs-primary-rgb), .12); color: var(--bs-primary); }
#persuratan-riwayat-section .pr-stat-icon.pending { background: rgba(255, 193, 7, .16); color: #b58100; }
#persuratan-riwayat-section .pr-stat-icon.approved { background: rgba(25, 135, 84, .14); color: #198754; }
#persuratan-riwayat-section .pr-stat-icon.rejected { background: rgba(220, 53, 69, .12); color: #dc3545; }

#persuratan-riwayat-section .pr-stat strong {
    display: block;
    font-size: 1.15rem;
    line-height: 1;
}

#persuratan-riwayat-section .pr-stat span:last-child {
    display: block;
    color: #6c757d;
    font-size: .75rem;
    margin-top: .25rem;
}

#persuratan-riwayat-section .pr-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    background: #fff;
    border: 1px solid rgba(15, 23, 42, .06);
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(15, 23, 42, .08);
    padding: 3rem 1.5rem;
}

#persuratan-riwayat-section .pr-empty span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 64px;
    height: 64px;
    border-radius: 18px;
    background: rgba(var(--bs-primary-rgb), .1);
    color: var(--bs-primary);
    font-size: 1.8rem;
    margin-bottom: 1rem;
}

#persuratan-riwayat-section .pr-empty h5 {
    font-weight: 800;
    margin-bottom: .4rem;
}

#persuratan-riwayat-section .pr-empty p {
    color: #6c757d;
    max-width: 420px;
    margin-bottom: 1rem;
}

#persuratan-riwayat-section .pr-list {
    display: flex;
    flex-direction: column;
    gap: .85rem;
}

#persuratan-riwayat-section .pr-item {
    display: grid;
    grid-template-columns: 42px minmax(0, 1fr);
    gap: .9rem;
    background: #fff;
    border: 1px solid rgba(15, 23, 42, .06);
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(15, 23, 42, .06);
    padding: 1rem;
}

#persuratan-riwayat-section .pr-item-marker {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 42px;
    height: 42px;
    border-radius: 14px;
    color: #fff;
}

#persuratan-riwayat-section .pr-item-main {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
}

#persuratan-riwayat-section .pr-item-title {
    font-weight: 800;
    color: #172033;
    margin-bottom: .35rem;
}

#persuratan-riwayat-section .pr-item-meta {
    display: flex;
    flex-wrap: wrap;
    gap: .45rem .9rem;
    color: #6c757d;
    font-size: .8rem;
}

#persuratan-riwayat-section .pr-item-meta span {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    min-width: 0;
}

#persuratan-riwayat-section .pr-item-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: .45rem;
    flex: 0 0 auto;
}

#persuratan-riwayat-section .pr-status {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 28px;
    border-radius: 999px;
    color: #fff;
    font-size: .74rem;
    font-weight: 800;
    padding: .25rem .7rem;
    white-space: nowrap;
}

#persuratan-riwayat-section .pr-item-actions .btn {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    border-radius: 10px;
    font-weight: 700;
}

#persuratan-riwayat-section .pr-note {
    display: flex;
    gap: .65rem;
    margin-top: .85rem;
    border-radius: 12px;
    padding: .75rem;
    font-size: .82rem;
}

#persuratan-riwayat-section .pr-note.is-approved {
    background: rgba(25, 135, 84, .09);
    color: #146c43;
}

#persuratan-riwayat-section .pr-note.is-rejected {
    background: rgba(220, 53, 69, .09);
    color: #b02a37;
}

#persuratan-riwayat-section .pr-note i {
    margin-top: .15rem;
}

#persuratan-riwayat-section .pr-note strong,
#persuratan-riwayat-section .pr-note span {
    display: block;
}

#persuratan-riwayat-section .pr-pagination {
    margin-top: 1.25rem;
}

@media (max-width: 767.98px) {
    #persuratan-riwayat-section .pr-header {
        align-items: stretch;
        flex-direction: column;
    }

    #persuratan-riwayat-section .pr-header h2 {
        font-size: 1.45rem;
    }

    #persuratan-riwayat-section .pr-header-action {
        justify-content: center;
        width: 100%;
    }

    #persuratan-riwayat-section .pr-stats {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    #persuratan-riwayat-section .pr-item {
        grid-template-columns: 1fr;
    }

    #persuratan-riwayat-section .pr-item-main,
    #persuratan-riwayat-section .pr-item-actions {
        align-items: flex-start;
        flex-direction: column;
    }
}

@media (max-width: 420px) {
    #persuratan-riwayat-section .pr-stats {
        grid-template-columns: 1fr;
    }
}

[data-theme="dark"] #persuratan-riwayat-section {
    background: linear-gradient(180deg, rgba(var(--bs-primary-rgb), .1), rgba(17, 24, 39, 0) 260px);
}

[data-theme="dark"] #persuratan-riwayat-section .pr-stat,
[data-theme="dark"] #persuratan-riwayat-section .pr-empty,
[data-theme="dark"] #persuratan-riwayat-section .pr-item {
    background: #1a1f2e;
    border-color: rgba(255, 255, 255, .07);
    box-shadow: none;
}

[data-theme="dark"] #persuratan-riwayat-section .pr-header p,
[data-theme="dark"] #persuratan-riwayat-section .pr-stat span:last-child,
[data-theme="dark"] #persuratan-riwayat-section .pr-empty p,
[data-theme="dark"] #persuratan-riwayat-section .pr-item-meta {
    color: #9ca3af;
}

[data-theme="dark"] #persuratan-riwayat-section .pr-header h2,
[data-theme="dark"] #persuratan-riwayat-section .pr-empty h5,
[data-theme="dark"] #persuratan-riwayat-section .pr-item-title,
[data-theme="dark"] #persuratan-riwayat-section .pr-stat strong {
    color: #e5e7eb;
}
</style>

@endsection
