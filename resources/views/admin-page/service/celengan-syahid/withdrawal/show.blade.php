@extends('admin-page.template.body')

@section('styles')
@include('admin-page.service.celengan-syahid.withdrawal.components._withdrawal-styles')
<style>
/* ── Show page extras ──────────────────────────────── */
.wd-hero {
    border-radius: 16px;
    padding: 1.5rem 1.75rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
    position: relative;
    overflow: hidden;
}
.wd-hero::before {
    content: '';
    position: absolute;
    right: -30px; top: -30px;
    width: 140px; height: 140px;
    border-radius: 50%;
    opacity: .08;
    background: #fff;
}
.wd-hero::after {
    content: '';
    position: absolute;
    right: 40px; bottom: -40px;
    width: 100px; height: 100px;
    border-radius: 50%;
    opacity: .06;
    background: #fff;
}
.wd-hero-pending   { background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff; }
.wd-hero-completed { background: linear-gradient(135deg, #10b981, #059669); color: #fff; }
.wd-hero-failed    { background: linear-gradient(135deg, #ef4444, #dc2626); color: #fff; }
.wd-hero-draft     { background: linear-gradient(135deg, #6b7280, #4b5563); color: #fff; }

.wd-hero-left { position: relative; z-index: 1; }
.wd-hero-label { font-size: .8rem; font-weight: 600; opacity: .85; text-transform: uppercase; letter-spacing: .06em; }
.wd-hero-amount { font-size: 2rem; font-weight: 800; line-height: 1.1; margin-top: .2rem; }
.wd-hero-ref { font-size: .75rem; opacity: .75; margin-top: .35rem; font-family: monospace; }

.wd-hero-right { position: relative; z-index: 1; text-align: center; }
.wd-status-icon { font-size: 2.5rem; margin-bottom: .35rem; display: block; }
.wd-status-text { font-size: 1rem; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; }

.wd-polling-badge {
    display: inline-flex;
    align-items: center;
    gap: .45em;
    font-size: .72rem;
    font-weight: 700;
    color: #92400e;
    background: #fef3c7;
    border: 1px solid #fde68a;
    border-radius: 50px;
    padding: .25em .8em;
    margin-top: .5rem;
}
html.dark-mode .wd-polling-badge { background: rgba(251,191,36,.15); color: #fbbf24; border-color: rgba(251,191,36,.3); }
.wd-spin { animation: wd-spin 1.2s linear infinite; display: inline-block; }
@keyframes wd-spin { to { transform: rotate(360deg); } }

/* ── Timeline ──────────────────────────────────────── */
.wd-timeline { list-style: none; padding: 0; margin: 0; position: relative; }
.wd-timeline::before {
    content: '';
    position: absolute;
    left: 17px; top: 0; bottom: 0;
    width: 2px;
    background: #e5e7eb;
}
html.dark-mode .wd-timeline::before { background: rgba(255,255,255,.1); }
.wd-tl-item {
    display: flex;
    gap: .85rem;
    align-items: flex-start;
    padding-bottom: 1.4rem;
    position: relative;
}
.wd-tl-item:last-child { padding-bottom: 0; }
.wd-tl-dot {
    flex-shrink: 0;
    width: 36px; height: 36px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .95rem;
    position: relative; z-index: 1;
    border: 2px solid transparent;
    transition: all .3s;
}
.wd-tl-dot.done     { background: #10b981; color: #fff; border-color: #10b981; }
.wd-tl-dot.active   { background: #f59e0b; color: #fff; border-color: #f59e0b; box-shadow: 0 0 0 4px rgba(245,158,11,.2); }
.wd-tl-dot.failed   { background: #ef4444; color: #fff; border-color: #ef4444; }
.wd-tl-dot.pending  { background: #e5e7eb; color: #9ca3af; border-color: #e5e7eb; }
.wd-tl-body { padding-top: .35rem; }
.wd-tl-title { font-weight: 700; font-size: .9rem; color: #111827; }
.wd-tl-time  { font-size: .75rem; color: #6b7280; margin-top: .1rem; }
html.dark-mode .wd-tl-title { color: #f9fafb; }
html.dark-mode .wd-tl-time  { color: #9ca3af; }
html.dark-mode .wd-tl-dot.pending { background: rgba(255,255,255,.08); border-color: rgba(255,255,255,.15); color: #6b7280; }

/* ── Info rows ─────────────────────────────────────── */
.wd-info-row {
    display: flex;
    align-items: baseline;
    gap: .5rem;
    padding: .55rem 0;
    border-bottom: 1px solid #f3f4f6;
}
.wd-info-row:last-child { border-bottom: none; }
html.dark-mode .wd-info-row { border-bottom-color: rgba(255,255,255,.06); }
.wd-info-label { font-size: .78rem; font-weight: 700; color: #6b7280; min-width: 130px; text-transform: uppercase; letter-spacing: .04em; }
.wd-info-value { font-size: .9rem; color: #111827; flex: 1; }
html.dark-mode .wd-info-label { color: #9ca3af; }
html.dark-mode .wd-info-value { color: #e5e7eb; }

/* ── Amount breakdown ──────────────────────────────── */
.wd-breakdown {
    background: rgba(0,167,157,.05);
    border: 1px solid rgba(0,167,157,.15);
    border-radius: 10px;
    padding: .85rem 1rem;
}
html.dark-mode .wd-breakdown { background: rgba(0,167,157,.08); border-color: rgba(0,167,157,.2); }
.wd-breakdown-row { display: flex; justify-content: space-between; align-items: center; padding: .3rem 0; font-size: .875rem; }
.wd-breakdown-row.total {
    border-top: 2px dashed rgba(0,167,157,.25);
    margin-top: .3rem;
    padding-top: .55rem;
    font-weight: 700;
}
.wd-net-value { font-size: 1.3rem; font-weight: 800; color: #059669; }
html.dark-mode .wd-net-value { color: #4ade80; }

/* ── Dark mode hero ────────────────────────────────── */
html.dark-mode .wd-hero-pending   { background: linear-gradient(135deg, #b45309, #92400e); }
html.dark-mode .wd-hero-completed { background: linear-gradient(135deg, #047857, #065f46); }
html.dark-mode .wd-hero-failed    { background: linear-gradient(135deg, #b91c1c, #991b1b); }
html.dark-mode .wd-hero-draft     { background: linear-gradient(135deg, #374151, #1f2937); }
</style>
@endsection

@php
    $statusHeroClass = match($withdrawal->status) {
        'PENDING'   => 'wd-hero-pending',
        'COMPLETED' => 'wd-hero-completed',
        'FAILED'    => 'wd-hero-failed',
        default     => 'wd-hero-draft',
    };
    $statusIcon = match($withdrawal->status) {
        'PENDING'   => 'fa-clock',
        'COMPLETED' => 'fa-circle-check',
        'FAILED'    => 'fa-circle-xmark',
        default     => 'fa-file-pen',
    };
    $isPending = $withdrawal->status === 'PENDING';
@endphp

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">

        {{-- Page Title --}}
        <div class="col-12 text-center">
            <h1 class="page-title">
                <i class="fas fa-eye me-2"></i>
                <span>Withdrawal</span>
                <span class="highlighted-text ms-1">Detail</span>
            </h1>
        </div>

        {{-- Hero Status Banner --}}
        <div class="col-12 mb-4">
            <div class="wd-hero {{ $statusHeroClass }}" id="wd-hero-banner">
                <div class="wd-hero-left">
                    <div class="wd-hero-label">Withdrawal Amount</div>
                    <div class="wd-hero-amount">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</div>
                    <div class="wd-hero-ref"><i class="fas fa-tag me-1 opacity-75"></i>{{ $withdrawal->reff_id }}</div>
                    @if($isPending)
                    <div class="wd-polling-badge" id="wd-polling-indicator">
                        <span class="wd-spin"><i class="fas fa-circle-notch"></i></span>
                        Checking status...
                    </div>
                    @endif
                </div>
                <div class="wd-hero-right">
                    <span class="wd-status-icon" id="wd-status-icon"><i class="fas {{ $statusIcon }}"></i></span>
                    <div class="wd-status-text" id="wd-status-text">{{ $withdrawal->status }}</div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="col-md-7 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="section-title mb-3">
                        <i class="fas fa-file-invoice-dollar me-2"></i>Withdrawal Information
                    </h5>

                    {{-- Campaign --}}
                    <div class="wd-info-row">
                        <span class="wd-info-label">Campaign</span>
                        <span class="wd-info-value">
                            @if($withdrawal->campaign)
                                <a href="{{ route('admin.celsyahid.campaign.finance', $withdrawal->campaign_id) }}" class="fw-semibold">
                                    {{ $withdrawal->campaign->judul }}
                                </a>
                            @else —
                            @endif
                        </span>
                    </div>

                    {{-- Destination --}}
                    <div class="wd-info-row">
                        <span class="wd-info-label">Destination</span>
                        <span class="wd-info-value d-flex align-items-center gap-2 flex-wrap">
                            <span class="wd-bank-chip">{{ strtoupper($withdrawal->bank_code) }}</span>
                            <span class="fw-semibold">{{ $withdrawal->account_number }}</span>
                        </span>
                    </div>

                    {{-- Account Holder --}}
                    <div class="wd-info-row">
                        <span class="wd-info-label">Account Holder</span>
                        <span class="wd-info-value fw-semibold">{{ $withdrawal->account_holder ?: '—' }}</span>
                    </div>

                    {{-- Created By --}}
                    <div class="wd-info-row">
                        <span class="wd-info-label">Created By</span>
                        <span class="wd-info-value">{{ $withdrawal->creator->name ?? '—' }}</span>
                    </div>

                    @if($withdrawal->remark)
                    <div class="wd-info-row">
                        <span class="wd-info-label">Remark</span>
                        <span class="wd-info-value text-muted">{{ $withdrawal->remark }}</span>
                    </div>
                    @endif

                    {{-- Amount Breakdown --}}
                    <div class="mt-4">
                        <div class="wd-breakdown">
                            <div class="wd-breakdown-row">
                                <span class="text-muted">Withdrawal Amount</span>
                                <span class="fw-semibold">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="wd-breakdown-row">
                                <span class="text-muted">Transfer Fee</span>
                                <span class="text-danger fw-semibold">− Rp {{ number_format($withdrawal->fee, 0, ',', '.') }}</span>
                            </div>
                            <div class="wd-breakdown-row total">
                                <span class="fw-bold">Amount Received</span>
                                <span class="wd-net-value">Rp {{ number_format($withdrawal->amount_net, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    @if($withdrawal->receipt_url)
                    <div class="mt-3" id="wd-receipt-wrap">
                        <a href="{{ $withdrawal->receipt_url }}" target="_blank" rel="noopener"
                           class="btn btn-custom-primary btn-sm">
                            <i class="fas fa-receipt me-1"></i> View Receipt
                        </a>
                    </div>
                    @else
                    <div id="wd-receipt-wrap" style="display:none" class="mt-3">
                        <a href="#" target="_blank" rel="noopener" class="btn btn-custom-primary btn-sm" id="wd-receipt-link">
                            <i class="fas fa-receipt me-1"></i> View Receipt
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Timeline Card --}}
        <div class="col-md-5 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="section-title mb-4">
                        <i class="fas fa-timeline me-2"></i>Transfer Timeline
                    </h5>

                    <ul class="wd-timeline">
                        {{-- Step 1: Draft Created --}}
                        <li class="wd-tl-item">
                            <div class="wd-tl-dot done"><i class="fas fa-file-pen"></i></div>
                            <div class="wd-tl-body">
                                <div class="wd-tl-title">Draft Created</div>
                                <div class="wd-tl-time">
                                    {{ optional($withdrawal->created_at)->isoFormat('D MMM YYYY, HH:mm') ?: '—' }}
                                </div>
                            </div>
                        </li>

                        {{-- Step 2: Sent to Bisabiller --}}
                        @php $executed = $withdrawal->executed_at; @endphp
                        <li class="wd-tl-item">
                            <div class="wd-tl-dot {{ $executed ? 'done' : 'pending' }}">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                            <div class="wd-tl-body">
                                <div class="wd-tl-title">Sent to Bisabiller</div>
                                <div class="wd-tl-time" id="tl-executed-time">
                                    {{ $executed ? $executed->isoFormat('D MMM YYYY, HH:mm') : 'Waiting...' }}
                                </div>
                            </div>
                        </li>

                        {{-- Step 3: Final status --}}
                        @php
                            $completed = $withdrawal->completed_at;
                            $isFailed  = $withdrawal->status === 'FAILED';
                            $isDone    = $withdrawal->status === 'COMPLETED';
                            $dotClass  = $isDone ? 'done' : ($isFailed ? 'failed' : ($isPending ? 'active' : 'pending'));
                            $stepIcon  = $isDone ? 'fa-circle-check' : ($isFailed ? 'fa-circle-xmark' : 'fa-circle-notch');
                            $stepTitle = $isDone ? 'Transfer Completed' : ($isFailed ? 'Transfer Failed' : 'Awaiting Confirmation');
                        @endphp
                        <li class="wd-tl-item">
                            <div class="wd-tl-dot {{ $dotClass }}" id="tl-final-dot">
                                <i class="fas {{ $stepIcon }} {{ $isPending ? 'wd-spin' : '' }}" id="tl-final-icon"></i>
                            </div>
                            <div class="wd-tl-body">
                                <div class="wd-tl-title" id="tl-final-title">{{ $stepTitle }}</div>
                                <div class="wd-tl-time" id="tl-final-time">
                                    @if($isDone || $isFailed)
                                        {{ $completed ? $completed->isoFormat('D MMM YYYY, HH:mm') : '—' }}
                                    @else
                                        Waiting for Bisabiller callback...
                                    @endif
                                </div>
                            </div>
                        </li>
                    </ul>

                    <div class="border-top pt-3 mt-3">
                        <div class="wd-info-row" style="border:none; padding:.3rem 0">
                            <span class="wd-info-label">Reference ID</span>
                        </div>
                        <code class="d-block small mt-1" style="word-break:break-all">{{ $withdrawal->reff_id }}</code>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action bar --}}
        <div class="col-12 d-flex justify-content-between align-items-center gap-2 mb-4 flex-wrap">
            <a href="{{ route('admin.celsyahid.withdrawal.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Withdrawals
            </a>
            @if($withdrawal->campaign)
            <a href="{{ route('admin.celsyahid.campaign.finance', $withdrawal->campaign_id) }}"
               class="btn btn-outline-secondary">
                <i class="fas fa-wallet me-1"></i> Campaign Finance
            </a>
            @endif
        </div>

    </div>
</div>
@endsection

@section('scripts')
@if($isPending)
<script>
(function () {
    const checkUrl   = "{{ route('admin.celsyahid.withdrawal.checkStatus', $withdrawal->id) }}";
    const interval   = 6000;
    let   timer      = null;
    let   attempts   = 0;
    const maxAttempts = 50; // ~5 minutes before giving up

    const heroMap = {
        PENDING:   { hero: 'wd-hero-pending',   icon: 'fa-clock',        text: 'PENDING'   },
        COMPLETED: { hero: 'wd-hero-completed',  icon: 'fa-circle-check', text: 'COMPLETED' },
        FAILED:    { hero: 'wd-hero-failed',     icon: 'fa-circle-xmark', text: 'FAILED'    },
    };
    const tlFinalMap = {
        COMPLETED: { dot: 'done',   icon: 'fa-circle-check', title: 'Transfer Completed' },
        FAILED:    { dot: 'failed', icon: 'fa-circle-xmark', title: 'Transfer Failed'    },
    };

    function applyStatus(data) {
        const s = data.status;
        if (s === 'PENDING') return; // no change

        clearInterval(timer);

        // Hero banner
        const hero  = document.getElementById('wd-hero-banner');
        const hMap  = heroMap[s] || heroMap.PENDING;
        hero.className = 'wd-hero ' + hMap.hero;
        document.getElementById('wd-status-icon').innerHTML = '<i class="fas ' + hMap.icon + '"></i>';
        document.getElementById('wd-status-text').textContent = hMap.text;

        // Hide polling badge
        const badge = document.getElementById('wd-polling-indicator');
        if (badge) badge.remove();

        // Timeline final step
        const dot   = document.getElementById('tl-final-dot');
        const icon  = document.getElementById('tl-final-icon');
        const title = document.getElementById('tl-final-title');
        const time  = document.getElementById('tl-final-time');
        const tMap  = tlFinalMap[s];
        if (tMap && dot) {
            dot.className   = 'wd-tl-dot ' + tMap.dot;
            icon.className  = 'fas ' + tMap.icon;
            title.textContent = tMap.title;
            time.textContent  = data.completed_at || '—';
        }

        // Receipt link
        if (data.receipt_url) {
            const wrap = document.getElementById('wd-receipt-wrap');
            const link = document.getElementById('wd-receipt-link');
            if (wrap && link) {
                link.href = data.receipt_url;
                wrap.style.display = '';
            }
        }
    }

    function poll() {
        attempts++;
        if (attempts > maxAttempts) {
            clearInterval(timer);
            const badge = document.getElementById('wd-polling-indicator');
            if (badge) badge.innerHTML = '<i class="fas fa-exclamation-circle"></i> Auto-check stopped. Refresh manually.';
            return;
        }

        fetch(checkUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.json())
            .then(applyStatus)
            .catch(() => {}); // silent fail — try again next tick
    }

    timer = setInterval(poll, interval);
    poll(); // run immediately on load
})();
</script>
@endif
@endsection
